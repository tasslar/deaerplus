<?php
/*
  Module Name : Guest
  Created By  : Ahila 01-12-2016 version 1.0
  Use of this module is New Dealer register Process, Dealer Schema Creation, Mail and Sms sending to registered dealers, Send dealer notifications, Login process, Maintain Cookies and Session data, Forget password, Logout process.

*/
namespace App\Http\Controllers;
use Request;
use Config;
use Redirect; 
use DB;
use Session;
use File;
use Cache;
use Exception;
use Cookie;
use DateTime;
use Validator;
use Carbon\Carbon;
use App\model\dealermodel;
use App\model\dms_dealers;
use App\Http\Controllers\dashboard;
use App\Http\Controllers\buy;
use App\model\creditmodel;
use App\model\billingmodel;
use App\model\subscriptionmodel;
use App\model\usersmodel;
use App\model\dealerPaymentmodel;
use App\model\notificationsmodel;
use App\model\emailmodel;
use App\model\smsmodel;
use App\model\master_temp_register;
use App\model\commonmodel;
use App\model\schemamodel;
use App\model\mongomodel;
use App\model\transaction_historymodel;
use App\model\branchesmodel;
use App\Http\Controllers\Api\api;
use App\Http\Requests;
use App\Http\Controllers\payment\techprocess;
use App\Http\Requests\registervalidation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\CustomException;

class guest extends Controller
{
	   
    public $title;
    public $dealercontactTable;
    public $dealerinventoryTable;
    public $dealerfundingTable;
	public $DmsCarListPhotosTable;
	public $caridfield;
    public function __construct(Request $req)
    {
        $this->dealercontactTable 		=	"dealer_contact_management";
        $this->dealerinventoryTable 	=	"dms_car_listings";
        $this->dealerfundingTable 		=	"dealer_funding_details";
        $this->DmsCarListPhotosTable    = 	"dms_car_listings_photos";
        $this->caridfield 				=	"car_id";
     
    }
    
    //The Functiosn indexview redirects the index page with title
    public function indexview()
    {
    	return view('index',['title' => 'DealerPlus-index']);
	}

    //For Guest pricing page
    public function pricingView()
    {
        $d_planlist =  subscriptionmodel::fetchExceptPlan();
        $trailFreq = subscriptionmodel::fetchFreeSubscription();
        foreach ($d_planlist as $key) 
        {
           $key->encPlanKey = encrypt($key->plan_type_id);
        }
        foreach ($trailFreq as $key) 
        {
           $key->encSubKey = encrypt($key->subscription_plan_id);
        }

        $title = 'Pricing';
        return view('pricing',compact('d_planlist','title','trailFreq'));
    }
    

    /*  The Function getmastercity fetch the list of city names 
    *   From master_city table and return into registration page.
    */
	public function getmastercity()
	{
        $pricePlanData = array();
        if(Request::has('planid'))
        {
          
        $planid         = decrypt(Request::get('planid'));
        $priFreq_id     = decrypt(Request::get('freqid'));
        $pricePlanData['key'] = "Pricing";
        }
        else
        {
          
            $planid = '1';
            $priFreq_id = '1';
            $pricePlanData['key'] = "";
        }

        $city_list  =  commonmodel::get_master_city();
        $d_planlist =  subscriptionmodel::fetchExceptPlan();
        $title      =  'Register';
        $freeVal    =  'FREE';
        $frequency_list=array();
        $data=array();
        foreach ($d_planlist as $key => $value)
        {

            $plan_list=$value->plan_type_id;
            $plan_name=$value->plan_type_name;
            $fre = DB::connection('mastermysql')
                        ->table('master_plan_frequency')
                        ->whereIn('frequency_id',function($query)use($plan_list){
                          
                        $query -> select('frequency_id')
                               -> from('master_subscription_plans')
                               ->where('enabled','Y')
                               /*->whereNotIn('subscription_plan_id', [1,14,15])*/
                               ->where('master_subscription_plans.plan_type_id', $plan_list);
                        })->get(); 
            

            $frequency_list[$plan_name]=array();

            foreach ($fre as $key) {
                
               $data['frequency_id']=$key->frequency_id;
               $data['frequency_interval']=$key->frequency_interval;
               $data['frequency_desc']=$key->frequency_desc;
               $data['frequency_name']=$key->frequency_name;
               
               
               $plan_details = $this->plan_amount($plan_list,$key->frequency_id);
               $data['plan_amount']=$plan_details[0]->total_cost;
               $data['subscription_plan_id']=$plan_details[0]->subscription_plan_id;
               array_push($frequency_list[$plan_name], $data);
               
            }

            $feature_list     =  subscriptionmodel::fetch_feature();
        
        
        }
        
       return view('registration',compact('title','feature_list','frequency_list','d_planlist','city_list','planid','priFreq_id','pricePlanData','freeVal'));
    }


    //Get plan amount from table 
    public function plan_amount($plan_id,$frequency_id)
    {
        try
        {
          $plan_amount     =        subscriptionmodel::fetch_plan($plan_id,$frequency_id);
        }
        catch(Exception $e)
        {
            throw new CustomException($e->getMessage());
        }
        return $plan_amount;
    }
    

    
    /* The Function user_register_store register new dealer data
    *  And send email , sms to the registered user. 
    *  Generate new schema , new password to the registered dealer.
    *  Add send dealer notifications and calculate billing details.
    */
    public function user_register_store(registervalidation $request)
    {

    $dealer_name      =  Request::input('dealer_name');
    $dealership_name  =  Request::input('dealership_name');
    $email            =  Request::input('d_email');
    $mobile           =  Request::input('d_mobile');
    $city             =  Request::input('d_city');
    $plan_duration    =  Request::input('plan_duration');
    $plan_amt         =  Request::input('plan_amt');
    $coupen_amount    =  Request::input('coupen_amount');
    $payable_amount   =  Request::input('payable_amount');
    $sub_id           =  Request::input('subscription_plan_id');
    $freq_id          =  Request::input('frequency_id');
    $hear_us          =  Request::input('hear_us');

    $curr             =  Carbon::now();
    try
    {
           
    $bill_date        =  billingmodel::billing_enddate($curr,$freq_id);
                  
    $checkusermail =  dealermodel::selectRaw("Count(*) as Total")
                                 ->where('d_email',"=",$email)
                                 ->first();

        if(intval($checkusermail->Total)>0)
        {
            Session::flash('message-err', "The Entered Email-id is already registered with us.");            
            return Redirect::back()->withInput();

        }
        else
        {   
            $checkdealershipname  =  dealermodel::selectRaw("Count(*) as Total")
                                           ->where('dealership_name',"=",$dealership_name)
                                           ->first();
            if(intval($checkdealershipname->Total)<=0)
            {
               $dealer_insert = array('dealer_name'=>$dealer_name,
                                   'dealership_name'=>$dealership_name,
                                    'd_email'=>$email,
                                    'd_mobile'=>$mobile,
                                    'd_city'=>$city,
                                    'acquisition_info'=>$hear_us,
                                    );

                $dealer_id      =   dealermodel::dealer_register($dealer_insert);
                $dealer         =   dealermodel::dealerfetch($dealer_id);
                $id             =   $dealer[0]->d_id;
                $dealer_name    =   $dealer[0]->dealer_name;
                $phone          =   $dealer[0]->d_mobile;
                $email          =   $dealer[0]->d_email;
                $dealership_name =  $dealer[0]->dealership_name;
                
                           
          
                //Schema name generated process to the registered user
                $dealer_name     =   str_replace(" ", " ", $dealer_name);
                $dbdealer_name   =   Carbon::now()->timestamp.$id;
                $dealer_dbname   =   $dbdealer_name;
                $affected_schema =   dealermodel::where('d_id', '=', $id)
                                      ->update([
                                           'dealer_schema_name' => "dmschema_".$dealer_dbname,
                                           'activation_status' => 'Inactive'
                                        ]);
                
                $getdealer      =     dealermodel::select('dealer_schema_name')
                                                ->where('d_id',"=",$id)
                                                ->first();
            // Schema creation start
              
                $register_users            =    dealermodel::dealerfetch($id);
               if(count($register_users) != 0)
               {
                    $password           = Hash::make('secret');
                    $username           = $register_users[0]->dealer_schema_name;
                    $user_password      = substr($password, 15, 8);  
                    $SchemaObject       = new schemamodel;
                    $CarlistDetails     = $SchemaObject->schema_generation($username);

               }       
                $dealerdetails    = array(
                                    'dealer_id' =>$dealer_id,
                                    'user_name' =>$dealer_name,                                
                                    'user_email'=>$email,
                                    'user_moblie_no'=>$mobile,
                                    'user_role'=>'1'                                   

                                    );
                $user_insert     =   dealermodel::user_accounts($register_users[0]->dealer_schema_name,$dealerdetails);                
        
                    //schema creation end

                  //Welcome Mail sending process               
                $welcome_email_template_id =    config::get('common.welcome_email_template_id');
                $email_template_data       =    emailmodel::get_email_templates($welcome_email_template_id);

                foreach ($email_template_data as $row) 
                    {
                        $mail_subject  =  $row->email_subject;
                        $mail_message  =  $row->email_message;
                        $mail_params   =  $row->email_parameters; 
                    }

                $url                   =    url("mailsend/".encrypt($id));
    
                $data                  =    array(
                                                    '0'=>$url,
                                                    '1'=>$dealer_name,
                                                    '2'=>$email,
                                                    '3'=> "",
                                                    '4'=>"",
                                                    '5'=>$getdealer->dealer_schema_name,
                                                    '6'=>$id,
                                                );

                $email_template    =     emailmodel::emailContentConstruct($mail_subject,$mail_message,$mail_params,$data);
                $email_sent        =     emailmodel::email_sending($email,$email_template);

                //Transaction history management - dealer notification(For welcome mail)
                $trans_data             =  array(
                                            'd_id'=>$id,
                                            'email_type_id'=>$welcome_email_template_id,
                                            'title'=>$mail_subject,
                                            'message'=>$email_template['mail_message'],
                                            'sent_status'=>$email_sent,
                                            'transaction_date'=>Carbon::now(),
                                            );
                $trans_futureentry      =  array(
                                            'd_id'=>$id,
                                            'email_type_id'=>"",
                                            'title'=>"",
                                            'message'=>"",
                                            'sent_status'=>"",
                                            'transaction_date'=>"",
                                            'tosend_date'=>$bill_date['exp']->subDays(Config::get('common.before_bill_enddate'))

                                            );

                
                $trans_id               =   transaction_historymodel::
                                                dealer_notification_insert($trans_data);
                $trans_futureid         =   transaction_historymodel::
                                               dealer_notification_insert($trans_futureentry);
                if($email_sent == "true")
                {
       
                        //Add Welcome email notifications into registered schema
                    $notification_type_id       =  Config::get('common.notification_type_id');
                    $notification_data          =  notificationsmodel::
                                                            get_notification_type($notification_type_id);
                    $welcome_title              =  $mail_subject;
                    $welcome_message            =  $email_template['mail_message'];
                    $data              =  array(
                                                'd_id'=>$id,
                                                'notification_type_id'=>$notification_data['0']->notification_type_id,
                                                'notification_type'=>$notification_data['0']->notification_type_name,
                                                'title'=>$welcome_title,
                                                'message'=>$welcome_message,
                                                'status'=>"1"
                                          );
                    $notification_sent_id  = notificationsmodel::notification_insert($getdealer->dealer_schema_name,$data);
                }
                else
                {
                     //call resend sms function.
                    echo "resend welcome email";
                }

                //Welcome SMS Sending to mobile
                
                $getPlan = subscriptionmodel::fetch_plandata($sub_id);
                                    
                $welcome_sms_id     =    Config::get('common.welcome_sms_id');
                $sms_template_data  =    smsmodel::get_sms_templates($welcome_sms_id);
                $smsdata            =    array($getPlan['plan_type_name'],$getPlan['freq_desc']);

                $sms_template_content  =     smsmodel::smsContentConstruct($sms_template_data[0]->sms_subject,$sms_template_data[0]->sms_message,$sms_template_data[0]->sms_parameters,$smsdata);
        
                $sms_data           = array('sms_template_data'=>$sms_template_content,
                                                'phone'=>$phone);
                $sms_sent           = smsmodel::sendsmsarray($sms_data);

                /*$sms_data           =    array('sms_template_data'=>$sms_template_data,
                                                'phone'=>$phone);
*/
                //$sms_sent           =    smsmodel::sendsms($sms_data);
                $dms_logo           =  url(Config::get('common.profilenoimage'));
                $dealer_code       =   commonmodel::dodealercode(); 
                $affected_schema    =  dealermodel::where('d_id', '=', $id)
                                                   ->update([
                                                        'dealer_code' => $dealer_code,
                                                        'logo'        => $dms_logo
                                                        ]);
                  
       // Dealer detail informations store into registered schema
            $dealerdata=array('dealer_id'=>$id,'phone'=>$phone);
            $dms_details = dealermodel::dealerdetails_store($register_users[0]->dealer_schema_name,$dealerdata);

            //Credit changes
            $tempCreditData  = array(
                                    'dealer_id'=>$id,
                                    'credit_balance'=>0,
                                    'created_at'=>Carbon::now(),
                                    );
            $creditId  =  creditmodel::addCredit($tempCreditData);

            $plan_data        =     subscriptionmodel::fetch_plandata(Request::input('subscription_plan_id'));
            $max_user         =      1;

            //Insert new plan details in master (master dealer billing table)
            $master_billdata       = array(
                                        'dealer_id'=>$id,
                                        'invoice_id'=>"",
                                        'subscription_plan_id'=>Request::input('subscription_plan_id'),
                                        'payment_date'=>Carbon::now(),
                                        'billing_date'=>Carbon::now(),
                                        'payment'=>Request::input('payment'),
                                        'max_users'=>1,
                                        'subscription_start_date'=>$bill_date['current'],
                                        'subscription_end_date'=>$bill_date['exp'],
                                        'coupon_amount'=>Request::input('coupen_amount'),
                                        'payable_amount'=>Request::input('payable_amount'),
                                        'bill_status'=>"",
                                        'current_subscription'=>1,
                                        'period'=>$plan_data['freq_desc'],
                                        'description'=>"Your Registered Plan is ".$plan_data['plan_type_name']." ".$plan_data['freq_desc']." for ".$max_user." Users.",
                                          );

            $master_bill_id        = subscriptionmodel::master_dealer_billing_store($master_billdata);
            if(Request::input('payable_amount') > 0)
            {
            //Payment Gateway
            $requesteddata = array(Session::get('ses_dealername'),Session::get('ses_id'),$phone,$master_bill_id ,'1', Carbon::now()->format('d-m-Y'),url('registerPaymentResp'),'Testdata');
            $payment_response = techprocess::paymentrequest($requesteddata);
            

            Redirect::to($payment_response)->send();
                
            }
            else{
                $updateBillData  =  array(
                              'history_id'=>$master_bill_id,
                              'bill_status'=>"N/A",
                              'billing_date'=>Carbon::now(),
                              'mode'=>"FREE TRIAL",
                            );
                $historyID = subscriptionmodel::updateMasterDealerBilling($updateBillData);
                Session::flash('message', "Successfully Registered. Password Activation Link Has Been Sent to Your Email-id.");
                return Redirect::back();
            }
        }    
        else
        {

            Session::flash('message-err', "The Entered Dealership name is already registered with us.");
            return Redirect::back()->withInput();
        } 
    }
    }
    catch(Exception $e)
    {
       //throw new CustomException($e->getMessage());
        $error          =   $e->getMessage();
        $createdate     =   'error_exceptionlog_'.date("y-m-d");
        if(file_exists(public_path('/custom_logs/')))
        {
            $original   =   public_path('/custom_logs/');
            $filename   =   File::append($original.'/'.$createdate.'.txt',$error."\r\n");
            $realpath   =   url('/custom_logs/'.$createdate.'.txt');
            $nameoffile =   $createdate.'.txt';
            $result     =   Storage::put("/custom_logs/".$nameoffile, file_get_contents($realpath),'public');
        }
        else
        {
            File::makeDirectory(public_path('/custom_logs/'), 0777, true, true);
            $original   =   public_path('/custom_logs/');
            $filename   =   File::append($original.'/'.$createdate.'.txt',$error."\r\n");
            $realpath   =   url('/custom_logs/'.$createdate.'.txt');
            $nameoffile =   $createdate.'.txt';
            $result     =   Storage::put("/custom_logs/".$nameoffile, file_get_contents($realpath),'public');
        }
        return \Response::view('custom_exp');
    }    
}

//payment gatway redirect back
public function registerPaymentResp()
{

  try
  {
     $reponse = $_POST;
     $paymentResponse = techprocess::paymentresponse($reponse);
     
     $updateBillData  =  array(
                              'history_id'=>$paymentResponse['clnt_txn_ref'],
                              'payment'=>$paymentResponse['txn_amt'],
                              'billing_date'=>\Carbon\Carbon::createFromFormat('d-m-Y H:i:s', $paymentResponse['tpsl_txn_time'])->format('Y-m-d H:i:s'),
                              'bill_status'=>$paymentResponse['txn_msg'],
                              'mode'=>config::get('common.paymentMode'),
                            );
     $historyID = subscriptionmodel::updateMasterDealerBilling($updateBillData);
     $paymentData  = array(
                              'payment_transaction_id'=>$paymentResponse['clnt_txn_ref'],
                              'dealer_id'=>Session::get('ses_id'),
                              'txn_status'=>$paymentResponse['txn_status'],
                              'txn_msg'=>$paymentResponse['txn_msg'],
                              'txn_err_msg'=>$paymentResponse['txn_err_msg'],
                              'clnt_txn_ref'=>$paymentResponse['clnt_txn_ref'],
                              'tpsl_bank_cd'=>$paymentResponse['tpsl_bank_cd'],
                              'tpsl_txn_id'=>$paymentResponse['tpsl_txn_id'],
                              'txn_amt'=>$paymentResponse['txn_amt'],
                              'clnt_rqst_meta'=>$paymentResponse['clnt_rqst_meta'],
                              'tpsl_txn_time'=>\Carbon\Carbon::createFromFormat('d-m-Y H:i:s', $paymentResponse['tpsl_txn_time'])->format('Y-m-d H:i:s'),
                              'tpsl_rfnd_id'=>$paymentResponse['tpsl_rfnd_id'],
                              'rqst_token'=>$paymentResponse['rqst_token'],
                              'hash'=>$paymentResponse['hash'],
                              'bal_amt'=>$paymentResponse['bal_amt'],
                              'create_at'=>Carbon::now(),
                                                            
                          );
     $paymentId  = dealerPaymentmodel::masterPaymentRespInsert($paymentData);

  }
  catch(\Exception $e)
  {
     throw new CustomException($e->getMessage());
  }

   if($paymentResponse['txn_msg'] == "success")
   {
   Session::flash('message', "Payment process done. Password Activation Link Has Been Sent to Your Email-id. ");
   
   }
   else if($paymentResponse['txn_msg'] == "failure")
   {
    Session::flash('message', "Payment process failure!!!");
   }
  return redirect('dealerregistration');
 

}


/* The function mailsend redirect password activation link page 
*  After getting mail.
*/
public function mailsend(Request $req, $id)
{
    try
    {

        $getdetail      =    dealermodel::select('activation_status')
                                        ->where('d_id',"=",decrypt($id))
                                        ->first();
        if($getdetail->activation_status=="Active")
         {
            Session::flash('message',"Already link has been activated.");
            return view('password_activation',['id' => 0]);

        }
        else
        {
           return view('password_activation', ['id' => $id]);
        }

    }
    catch(Exception $e)
    {
       throw new CustomException($e->getMessage());
    }

}

/* The Function login check user name and password cookies using  
*  Call_cookiedata function. And Redirect to the dealer dashboard page.
*  And maintain session data to the authendicated dealer.
*/   
public function login(Request $request)
{

    if(isset($_COOKIE["email"])&&isset($_COOKIE["password"]))
    {
        $get_temp     =    $this->call_cookiedata($_COOKIE["email"],$_COOKIE["password"]);

        if($get_temp==0)
        {
              $active_menu_name  =   'dashboard_menu';
              $header_data       =    array(
                                            'id'=>Session::get('ses_id'),
                                            'dealer_name'=>Session::get('ses_dealername'),
                                            'logo'=>Session::get('logo')
                                            );

              $compact_array     = array('active_menu_name'=>$this->active_menu_name);   
              return view('dashboard',compact('header_data','compact_array'));
        }
        elseif($get_temp==1)
        {
            $current=Carbon::now()->subDays(config::get('common.cookie_time'))->timestamp;
            setcookie("email", "",$current , "/");
            setcookie("password","",$current, "/");
            return redirect('login');
        }
        else
        {
            $current=Carbon::now()->subDays(config::get('common.cookie_time'))->timestamp;
            setcookie("email", "",$current , "/");
            setcookie("password","",$current, "/");
            return redirect('login');
        }

    }
    else
    {
        return view('login');
        /*if(!Session::has('ses_id'))
        {
            return view('login');
        }
        else
        {
            return redirect('dashboard');
        }*/
    }
}

/* Check user name and password for login.
*  Maintain dealer id, name , email, logo , schema name
*  As session data to the login user.
*/
public function call_cookiedata($email,$password)
{
 try
 {
        $checkuser   =  dealermodel::selectRaw("Count(*) as Total")
                                    ->where('d_email',"=",$email)
                                    ->first();
        if(intval($checkuser->Total)>0)
        {
          $getdetail   =     dealermodel::select('d_password','d_id','dealer_name',
                                                   'dealer_schema_name','d_email')
                                          ->where('d_email',"=",$email)
                                          ->first();
          $d_password  =     $getdetail->d_password;

            if($password==$d_password)
            { 
                $ses_id             =      $getdetail->d_id;
                $ses_email          =      $getdetail->d_email;
                $ses_dealername     =      $getdetail->dealer_name;
                $ses_dealer_schema_name =   $getdetail->dealer_schema_name;
                
                $dealerdata     =  dealermodel::dealermodel_get($getdetail->dealer_schema_name,$ses_id); 
               
                if(count($dealerdata))
                {
                     foreach($dealerdata as $dealer)
                     {
                        $dealer_logo =  $dealer->logo;
                     }
                } 
                else
                {
                    $dealer_logo    =   url(Config::get('common.profilenoimage'));
                }
                    
                $id                 =         $ses_id;
                $dealer_name        =         $ses_dealername;
                $data               =         array(
                                                'id'=>$id,
                                                'dealer_name'=>$dealer_name,
                                                'logo'=>$dealer_logo
                                                );
                $active_menu_name   =   'dashboard_menu';
                $header_data        =    array(
                                                'id'=>Session::get('ses_id'),
                                                'dealer_name'=>Session::get('ses_dealername'),
                                                'logo'=>Session::get('logo')
                                                );
                session(['ses_id' => $ses_id]);
                
                session(['ses_email' => $ses_email]);
                session(['ses_dealername' => $ses_dealername]);
                session(['dealer_schema_name'=>$ses_dealer_schema_name]);
                session(['logo'=>$dealer_logo]);
                $temp=0;
                return $temp;
            }
            else
            {   
                //invalid password
                $temp=1;    
                return $temp;
            }
        }
        else
        {
            //invalid user
            $temp=2;
            return $temp;
        }
    }
    catch(Exception $e)
    {
       throw new CustomException($e->getMessage());
    }
}


/* The function passwordconfirm check both new and confirm passwords
 * And update it on database. And send Login email details and sms details 
 * And add dealer notification into schema table. 
*/
public function passwordconfirm(Request $req)
{        

    $id          =   decrypt(Request::input('id'));    
    $dealer_id   =   dealermodel::fetch_dealer()->where('d_id',$id)->first();          
    $parent_id   =   $dealer_id->parent_id;            
    $password    =   Request::input('newpassword');
    $cpassword   =   Request::input('confirmpassword');
    if($password == $cpassword)
    {        
     
      $affectedRows = dealermodel::where('d_id', '=', $id)
                                  ->update(['d_password' => $password,'activation_status'=>'Active','status'=>'Active']);
        if($parent_id == '0')
        {
                $selectdealer = dealermodel::select('dealer_name','d_email','d_password','d_mobile','dealer_code','dealer_schema_name')
                                           ->where('d_id',"=",$id)
                                           ->first();   
                $email_count=notificationsmodel::email_notification_count($selectdealer->dealer_schema_name,$id);
                $dealer_logo      =  url(Config::get('common.profilenoimage'));
                session(['ses_id' => $id]);
                session(['ses_email' => $selectdealer->d_email]);
                session(['ses_dealername' => $selectdealer->dealer_name]);
                session(['dealer_schema_name'=>$selectdealer->dealer_schema_name]);
                session(['logo'=>$dealer_logo]);
                session(['email_count'=>$email_count]);


            //Login Mail sending process               
               
                $login_email_template_id  =   Config::get('common.login_email_template_id');
                $email_template_data      =   emailmodel::get_email_templates($login_email_template_id);
                foreach ($email_template_data as $row) 
                    {
                        $mail_subject  =  $row->email_subject;
                        $mail_message  =  $row->email_message;
                        $mail_params   =  $row->email_parameters; 
                    }

                $url                =   url("logindirect");
                $data               =   array(
                                            '0'=>$url,
                                            '1'=>$selectdealer->dealer_name,
                                            '2'=>$selectdealer->d_email,
                                            '3'=>$selectdealer->dealer_code,
                                            '4'=>$id,
                                            );

                $email_template    =     emailmodel::emailContentConstruct($mail_subject,$mail_message,$mail_params,$data);
                $email_sent        =     emailmodel::email_sending($selectdealer->d_email,$email_template);

    //Transaction history management - dealer notification
    $trans_data             = array(
                                'd_id'=>$id,
                                'email_type_id'=>$login_email_template_id,
                                'title'=>$mail_subject,
                                'message'=>$email_template['mail_message'],
                                'sent_status'=>$email_sent,
                                'transaction_date'=>Carbon::now(),
                                'tosend_date'=>""

                                );
    
    $trans_id               =   transaction_historymodel::
                                    dealer_notification_insert($trans_data);


                //Add login-email notifications into registered schema
                $notification_type_id  =  Config::get('common.notification_type_id');
                $notification_data     =  notificationsmodel::get_notification_type($notification_type_id);

                $login_title      =  $mail_subject;
                $login_message    =  $email_template['mail_message'];
                $data             =  array(
                                            'd_id'=>$id,
                                            'notification_type_id'=>$notification_data['0']->notification_type_id,
                                            'notification_type'=>$notification_data['0']->notification_type_name,
                                            'title'=>$login_title,
                                            'message'=>$login_message,
                                            'status'=>"1"
                                      );
                $notification_sent_id  = notificationsmodel::notification_insert($selectdealer->dealer_schema_name,$data);
               
                $email_count  = notificationsmodel::email_notification_count($selectdealer->dealer_schema_name,$id);
             

            //Sending Message to mobile
                $phone                  =     $selectdealer->d_mobile;
                $smsdata                =     array($selectdealer->dealer_name);
                $login_sms_id           =     Config::get('common.login_sms_id');
                $sms_template_data      =     smsmodel::get_sms_templates($login_sms_id);
                $sms_template_content   =     smsmodel::smsContentConstruct($sms_template_data[0]->sms_subject,$sms_template_data[0]->sms_message,$sms_template_data[0]->sms_parameters,$smsdata);
                $sms_data              = array('sms_template_data'=>$sms_template_content,
                                                'phone'=>$phone);
                $sms_sent              = smsmodel::sendsmsarray($sms_data);
                /*$sms_data               =       array(
                                                'sms_template_data'=>$sms_template_data,
                                                'phone'=>$phone
                                                    );
                $sms_sent               =       smsmodel::sendsms($sms_data);*/
                $data        =   array(
                                    'id'=>$id,
                                    'dealer_name'=>$selectdealer->dealer_name,
                                    'logo'=>url(Config::get('common.profilenoimage'))
                                    );
                $active_menu_name      =   'dashboard_menu';
                $header_data           =    array(
                                            'id'=>$id,
                                            'dealer_name'=>$selectdealer->dealer_name,
                                            'logo'=>url(Config::get('common.profilenoimage')),
                                            'title'=>'dashboard',
                                            'email_count'=>$email_count,
                                            'dealer_notification'=>notificationsmodel::dealer_notification_count( $selectdealer->dealer_schema_name,$id)
                                                );
                   
                $header_data['savedcount']="";
                $header_data['recentcount']="";
                    
                $compact_array         =    array('active_menu_name'=>$active_menu_name);
                    /*return view('dashboard',compact('data','header_data','compact_array'));*/  
                return redirect('dashboard');
                }
                else
                {
                    return redirect('login');
                }
            }
            else
            {
              return Redirect::back()->with('message', 'Password Mismatch Error! Please try again.');
            }
        
     
}

//This function forgetpassword redirect to forgetpassword page.
public function forgetpassword()
{

    return view('forget_password');
}

/* This function forgetpasswordprocess get email id 
 * And send forget password link to registered mailid.
 * And 
*/
public function forgetpasswordprocess(Request $req)
{

    $mailid            =       Request::input('mailid');
    $dealerdata        =       DB::table('dms_dealers')
                                  ->where('d_email','=', $mailid)
                                  ->get();

    if(!$dealerdata->isEmpty())
    {
        foreach($dealerdata as $dealer)
        {
            $dealer_id            =         $dealer->d_id;
            $dealer_name          =         $dealer->dealer_name;
            $phone                =         $dealer->d_mobile;
            $dealer_schema_name   =         $dealer->dealer_schema_name;
        }

//Mail sending process               
    $change_password_id       =   Config::get('common.change_password_template_id');
    $email_template_data      =   emailmodel::get_email_templates($change_password_id);
    foreach ($email_template_data as $row) 
    {
        $mail_subject  =  $row->email_subject;
        $mail_message  =  $row->email_message;
        $mail_params   =  $row->email_parameters; 
    }
    $url               =   url("changepassword/".encrypt($dealer_id));
    $data              =   array(
                                    '0'=>$url,
                                    '1'=>$dealer_name,
                                    '2'=>$mailid,
                                    '3'=>"",
                                    '4'=>"",
                                    'id'=>$dealer_id
                                );
    $email_template    =   emailmodel::emailContentConstruct($mail_subject,$mail_message,$mail_params,$data);
    $email_sent        =   emailmodel::email_sending($mailid,$email_template);
    $email_update      =   dealermodel::where('d_email', '=', $mailid)
                                      ->update(['activation_status'=>'Inactive']);

//Transaction history management - dealer notification(For change password)
    $trans_data             =array(
                                'd_id'=>$dealer_id,
                                'email_type_id'=>$change_password_id  ,
                                'title'=>$mail_subject,
                                'message'=>$email_template['mail_message'],
                                'sent_status'=>$email_sent,
                                'transaction_date'=>Carbon::now(),
                                'tosend_date'=>""

                                );
    
    $trans_id               =   transaction_historymodel::dealer_notification_insert($trans_data);   

    //Add email notifications into registered schema
       
    $notification_type_id    =  Config::get('common.notification_type_id');
    $notification_data       =  notificationsmodel::get_notification_type($notification_type_id);
    $change_title              =  $mail_subject;
    $change_message            =  $email_template['mail_message'];
    $data              =  array(
                                'd_id'=>$dealer_id,
                                'notification_type_id'=>$notification_data['0']->notification_type_id,
                                'notification_type'=>$notification_data['0']->notification_type_name,
                                'title'=>$change_title,
                                'message'=>$change_message,
                                'status'=>"1"
                          );
    $notification_sent_id  = notificationsmodel::notification_insert($dealer_schema_name,$data);
  
    //Sending Message to mobile
        $phone              =        $dealer->d_mobile;
        $smsdata            =        array($dealer_name);
        $change_sms_id      =        Config::get('common.change_sms_id');
        $sms_template_data  =        smsmodel::get_sms_templates($change_sms_id);
        $sms_template_content  =     smsmodel::smsContentConstruct($sms_template_data[0]->sms_subject,$sms_template_data[0]->sms_message,$sms_template_data[0]->sms_parameters,$smsdata);
        $sms_data           = array('sms_template_data'=>$sms_template_content,
                                                'phone'=>$phone);
        $sms_sent           = smsmodel::sendsmsarray($sms_data);
        

        

     Session::flash('message_success', "Password link has been sent to your mail id. Reset your password and login again.");
     return redirect('login');
    }
    else
    {
        Session::flash('message', "Email Id doesn't exists in our system.");
         return Redirect::back();
    }

}

/* The function changepasswordview redirect to change_password page.
 * And check already link activated or not.
*/
public function changepasswordview(Request $req,$id)
{

    $getdetail       =      dealermodel::select('activation_status')
                                       ->where('d_id',"=",decrypt($id))
                                       ->first();

    if($getdetail->activation_status=="Active")
    {
        Session::flash('message',"Already link has been activated.");
        return view('change_password',['id' => 0]);
    }
    else
    {
        return view('change_password', ['id' => decrypt($id)]);
    }
}

/* The function changepasswordprocess to change new password.
 * And send mail, sms , notifications related to change password
 * Process.
*/
public function changepasswordprocess(Request $req)
{
    $id              =         Request::input('id');
    $change          =         Request::input('changepassword');
    $confirmp        =         Request::input('confirmpassword');

    if($change == $confirmp)
    {

       $affectedRows  =     dealermodel::where('d_id', '=', $id)
                                        ->update(['d_password' => $change,'activation_status'=>'Active']);
       $selectdealer  =     dealermodel::select('d_id','dealer_name','d_email','d_password','d_mobile','dealer_code','dealer_schema_name')
                                          ->where('d_id',"=",$id)
                                          ->first();


    //Mail sending process               
     $login_email_template_id  = Config::get('common.login_email_template_id');
     $email_template_data    = emailmodel::get_email_templates($login_email_template_id);

        foreach ($email_template_data as $row) 
        {
            $mail_subject  =  $row->email_subject;
            $mail_message  =  $row->email_message;
            $mail_params   =  $row->email_parameters; 
        }
        $url               =   url("logindirect");
        $data              =   array(
                                '0'=>$url,
                                '1'=>$selectdealer->dealer_name,
                                '2'=>$selectdealer->d_email,
                                '3'=>$selectdealer->dealer_code,
                                '4'=>$id,
                                );
        
        $email_template =   emailmodel::emailContentConstruct($mail_subject,$mail_message,$mail_params,$data);
        $email_sent     =   emailmodel::email_sending($selectdealer->d_email,$email_template);
//Transaction history management - dealer notification(For change password)
    $trans_data         =   array(
                                'd_id'=>$id,
                                'email_type_id'=>$login_email_template_id ,
                                'title'=>$mail_subject,
                                'message'=>$email_template['mail_message'],
                                'sent_status'=>$email_sent,
                                'transaction_date'=>Carbon::now(),
                                'tosend_date'=>""

                             );
    
    $trans_id          =   transaction_historymodel::
                                    dealer_notification_insert($trans_data);

      //Add email notifications into registered schema
    $notification_type_id =  Config::get('common.notification_type_id');

    $notification_data    =  notificationsmodel::get_notification_type($notification_type_id);
    $changep_title        =  $mail_subject;
    $changep_message      =  $email_template['mail_message'];
    $data                 =  array(
                                'd_id'=>$id,
                                'notification_type_id'=>$notification_data['0']->notification_type_id,
                                'notification_type'=>$notification_data['0']->notification_type_name,
                                'title'=>$changep_title,
                                'message'=>$changep_message,
                                'status'=>"1"
                            );
    $notification_sent_id  = notificationsmodel::notification_insert($selectdealer->dealer_schema_name,$data);

    
    //Sending Message to mobile
        $phone              =      $selectdealer->d_mobile;
        $smsdata            =      array($selectdealer->dealer_name);
        $change_sms_id      =      Config::get('common.login_sms_id');

        $sms_template_data  =      smsmodel::get_sms_templates($change_sms_id);

        $sms_template_content  =     smsmodel::smsContentConstruct($sms_template_data[0]->sms_subject,$sms_template_data[0]->sms_message,$sms_template_data[0]->sms_parameters,$smsdata);
        $sms_data           = array('sms_template_data'=>$sms_template_content,
                                                'phone'=>$phone);
        $sms_sent           = smsmodel::sendsmsarray($sms_data);
        Session::flash('message_success', "Password has been changed Successfully.Your Login details sent to your Email-id.");
        return view('login',['id' => $id]);
    }
    else
    {
        return Redirect::back()->with('message', 'Password Mismatch Error! Please try again.');
    } 
}

/* The function loginprocess to check valid dealer.
 * And redirect to dashboard page.
 * Maintain session and cookies.
*/
public function loginprocess(Request $req)
{
    

    $email          =         Request::input('email');
    $password       =         Request::input('password');
    if($email== "" || $password== "")
    {
         Session::flash('message', "All fields are required");
         return Redirect::back()->withInput();
    }
    else
    {

        $checkuser      =         dealermodel::selectRaw("Count(*) as Total")
                                            ->where('d_email',"=",$email)
                                            ->where('status',"Active")
                                            ->first();    
        if(intval($checkuser->Total)>0)
        {            
          $getdetail    =    dealermodel::select('d_password','d_id','parent_id',
                                                'dealer_name','dealer_schema_name','d_email','logo')
                                              ->where('d_email',"=",$email)
                                              ->where('status',"Active")
                                              ->first();
          $d_password   =    $getdetail->d_password;
          
            if($password==$d_password)
            {

                if(empty($getdetail->parent_id))
                {

                   
                $ses_id          =     $getdetail->d_id;
                $ses_email       =     $getdetail->d_email;
                $ses_dealername  =     $getdetail->dealer_name;
                $ses_dealer_schema_name  =  $getdetail->dealer_schema_name;
                $ses_logo        =     $getdetail->logo;

                try{

                $email_count=notificationsmodel::email_notification_count($ses_dealer_schema_name,$ses_id);
                }catch(Exception $e){
                    throw new CustomException($e->getMessage());
                }

                $dealer_logo      =  url(Config::get('common.profilenoimage'));

                session(['ses_id' => $ses_id]);                
                session(['ses_email' => $ses_email]);
                session(['ses_dealername' => $ses_dealername]);
                session(['dealer_schema_name'=>$ses_dealer_schema_name]);
                session(['logo'=>$ses_logo]);                
                $remember     =    Request::input('remember');
                if(!empty($remember))
                {
                  $current=Carbon::now()->addDays(config::get('common.cookie_time'))->timestamp;
                  setcookie('email',  $email, $current, "/");
                  setcookie('password',  $d_password, $current, "/");     
                }
                
					/*return view('dashboard',compact('data','header_data','compact_array'));*/
                    return redirect('dashboard');
                }
                else
                {

                    $ses_id          =     $getdetail->d_id;                
                    $user_email       =     $getdetail->d_email;
                    $user_dealername  =     $getdetail->dealer_name;
                    $ses_logo        =     $getdetail->logo;
                    $ses_dealer_schema_name  =  $getdetail->dealer_schema_name;
                    $email_count=notificationsmodel::email_notification_count($ses_dealer_schema_name,$ses_id);
                   
                    $dealer_logo      =  url(Config::get('common.profilenoimage'));  
                    session(['ses_id' => $ses_id]);       
                    session(['ses_email' => $user_email]);
                    session(['ses_dealername' => $user_dealername]);
                    session(['dealer_schema_name'=>$ses_dealer_schema_name]);
                    session(['logo'=>$ses_logo]);                            
                    $remember     =    Request::input('remember');
                    if(!empty($remember))
                    {
                        $current=Carbon::now()->addDays(config::get('common.cookie_time'))->timestamp;
                        setcookie('email',  $email, $current, "/");
                        setcookie('password',  $d_password, $current, "/");     
                    }                
    					
                        return redirect('dashboard');
                }                
            }
            else
            {
                /*dd(Redirect::back()->withInput());*/
                Session::flash('message', "Invalid Password! Please try again.");
                return Redirect::back()->withInput();
                    
            }
        }
        else
        {
             Session::flash('message', "Invalid User! Please try again.");
             return Redirect::back()->withInput();            
        }
        
    }

}

//Redirect to dashboard view. 
public function show(Request $req,$id)
{
    return view('dashboard',['id'=>$id]);
}

//Redirect to changepassword view.
public function changepassword(Request $req)
{
    return view('change_password');
}


//Redirect to login view.
public function logindirect()
{
    return redirect('login');
}

/* The function logoutprocess logout the session.
 * And remove cookies.
 * And redirect to login page.
*/
public function logoutprocess(Request $request)
{  
    $current=Carbon::now()->subDays(config::get('common.cookie_time'))->timestamp;
    setcookie("email", "",$current , "/");
    setcookie("password","",$current, "/");
    Session::flush();
    Auth::logout();
    Cache::flush();
    /*return redirect(\URL::previous());*/
    return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/login');
    /*return redirect('login');*/

}


//Redirect to changepassword view.
public function guest_detailpage($car_id)
{
    $mongofetchdetaillisting      = buy::mongofetchdetaillisting($car_id,0,0);
    $detail_list_data           = $mongofetchdetaillisting[0];
    $listing_features           = $mongofetchdetaillisting[1];
    $bidding_data               = $mongofetchdetaillisting[2];
    $dealer_info                = $mongofetchdetaillisting[3];
    $title                      = 'Listing Detail';
    return view('guest_detail_list',compact('detail_list_data','bidding_data','listing_features','dealer_info','title'));
}
public function usersendmail(Request $req, $id)
    {           

        $getdetail      =    dealermodel::select('activation_status')
                                    ->where('d_id',"=",decrypt($id))
                                    ->first();

         if($getdetail->activation_status == "Active")
         {
            Session::flash('message',"Already link has been activated.");
            return view('password_activation',['id' => 0]);

        }
        else
        {
           return view('password_activation', ['id' => $id]);
        }
    }


}
