<?php

namespace App\Http\Controllers\api;
use Request;
use Config;
use Redirect; 
use DB;
use Session;
use File;
use Exception;
use Cookie;
use DateTime;
use Validator;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\model\dealermodel;
use App\model\emailmodel;
use App\model\transaction_historymodel;
use App\model\notificationsmodel;
use App\model\subscriptionmodel;
use App\model\billingmodel;
use App\model\apimodel;
use App\model\smsmodel;
use App\model\master_temp_register;
use App\model\commonmodel;
use App\model\schemamodel;
use App\Http\Controllers\Api\api;
use App\Http\Requests\registervalidation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;
use App\model\dms_dealerdetails;
use App\model\dms_dealer_subscription_history;
use App\Exceptions\Handler;

class guest extends Controller
{	
	public $emailMaterTable;
	public $emailTypeId;
	public $dealerMasterTable;
	public $emailStatus;
	public $masteremailId;
	public $masterUserId;
	public $masterPassword;
	public $userAccountTable;
	public $coupanTable;
	public $dealersubTable;
	public function __construct(Request $request)
    {		
		$this->dealerMasterTable	=	"dms_dealers";
        $this->emailTypeId          = 	"email_type_id";
        $this->emailMaterTable      = 	"master_email_templates";
        $this->emailStatus          = 	"activation_status";
        $this->masteremailId		=	"d_email";
        $this->masterUserId			= 	"d_id";
        $this->masterPassword		= 	"d_password";
        $this->userAccountTable		=	"user_account";
        $this->coupanTable			=	"dealer_coupons";
        $this->dealersubTable 		=	"dms_dealerdetails";
	}
	
	public  function doRegistrationStore(Request $request)
	{	
        $dealer_name     	=  	Request::input('DName');
        $mobile          	=  	Request::input('DContact');
		$email           	=  	Request::input('DEmail');
		$dealership_name 	=  	Request::input('DShipName');
		$city            	=	Request::input('Dcity');
		$freq_id         	=  	Request::input('planFreqId');
		$finalamount 	 	=	Request::input('finalamount');
		$planid 		 	=	Request::input('plan');
		$copanid 			=	Request::input('couponId');
		$currentdate     	=  	Carbon::now();
		$bill_date       	=  	billingmodel::billing_enddate($currentdate,$freq_id);

		if($dealer_name == "" || $email == "" || $mobile == "" || $dealership_name == "" || $city == "" || $freq_id == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'All fields are required!!'
									]);
		}
		$where 				=	array('subscription_plan_id'=>$planid);
		$checkplanisexist 	=	dealermodel::masterFetchTableDetails(
																		'master_subscription_plans',
																		$where);
		$planvalidamount 	=	((count($checkplanisexist)>=1)?$checkplanisexist[0]->unit_cost:'');
		
		$wherecopan 		=	array('coupon_id'=>$planid);
		$checkcopanexist 	=	dealermodel::masterFetchTableDetails(
																'dealer_coupons',
																$wherecopan);
		$coupon_amount 		=	((count($checkcopanexist)>=1)?$checkcopanexist[0]->coupon_amount:'');
		$checkusermail 		=  	dealermodel::selectRaw("Count(*) as Total")
                                     ->where('d_email',"=",$email)
                                     ->first();
       
		if(intval($checkusermail->Total)>0){
			return response()->json(['Result'=>'0',
									'message'=>'The Entered Email-id is already registered with us!!'
									]);

		}
		else
		{   
			$checkdealername  =  dealermodel::selectRaw("Count(*) as Total")
                                   ->where('d_mobile',"=",$mobile)
                                   ->first();
                                   //echo $checkdealername; exit;
		if(intval($checkdealername->Total)<=0)
		{
			$dealer_insert = array('dealer_name'=>$dealer_name,
									'd_email'=>$email,
									'd_city'=>$city,
									'd_mobile'=>$mobile,
									'logo'=>url(Config::get('common.profilenoimage')),
									'dealership_name'=>$dealership_name
									);
			$dealer_id      =   dealermodel::dealer_register($dealer_insert);
			$dealer         =   dealermodel::dealerfetch($dealer_id);
			$id             =   $dealer[0]->d_id;
			$dealer_name    =   $dealer[0]->dealer_name;
			$phone          =   $dealer[0]->d_mobile;
			$email          =   $dealer[0]->d_email;
      
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
		//Welcome Mail sending process               
			$welcome_email_template_id =    config::get('common.welcome_email_template_id');
			$email_template_data       =    emailmodel::get_email_templates($welcome_email_template_id);

			foreach ($email_template_data as $row) 
				{
					$mail_subject  =  $row->email_subject;
					$mail_message  =  $row->email_message;
					$mail_params   =  $row->email_parameters; 
				}

				$url               =    url("mailsend/".encrypt($id));
				
				$data              =    array(
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
			
			
		
		//Welcome SMS Sending to mobile
				
		$welcome_sms_id     =   Config::get('common.welcome_sms_id');
		$sms_template_data  =   smsmodel::get_sms_templates($welcome_sms_id);
		$sms_data           =   array('sms_template_data'=>$sms_template_data,
										'phone'=>$phone);
		$sms_sent           =   smsmodel::sendsms($sms_data);
		$dms_logo           =  	Config::get('common.profilenoimage');
		$dealer_code        =  	Config::get('common.dealercodePrefix')
									  .Carbon::now()->timestamp;
		$affected_schema    =  	dealermodel::where('d_id', '=', $id)
										   ->update([
												'dealer_code' => $dealer_code,
												'logo'        => $dms_logo
												]);

		// Schema creation start
		$register_users         =    DB::table('dms_dealers')->where('d_id', $id)->get();
		if(count($register_users) != 0)
		{
			$password           = 	Hash::make('secret');
			$username           = 	$register_users[0]->dealer_schema_name;
			$user_password      = 	substr($password, 15, 8);  
			$SchemaObject       = 	new schemamodel;
			$CarlistDetails     = 	$SchemaObject->schema_generation($username);  
		}   
		//schema creation end

		 //Adding Plan details into registered schema start
		$insert_subscription	=	array(
											'dealer_id'=>$id,
											'subscription_plan_id'=>$planid,
											'payment'=>$finalamount,
											'payment_date'=>date('Y-m-d h:i:s')
											);
		$subscription_sent_id  	=	subscriptionmodel::dealer_subscription_store($register_users[0]->dealer_schema_name,$insert_subscription);
		//Adding Plan details into registered schema end
		
		//Transaction history management  start
			$trans_data             =  array(
											'd_id'=>$id,
											'email_type_id'=>$welcome_email_template_id,
											'title'=>$mail_subject,
											'message'=>$email_template['mail_message'],
											'sent_status'=>$email_sent,
											'transaction_date'=>Carbon::now()
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

		$trans_id               =   transaction_historymodel::dealer_notification_insert($trans_data);
		$trans_futureid         =   transaction_historymodel::dealer_notification_insert($trans_futureentry);
		if($email_sent == "true")
		{
			//Add Welcome email notifications into registered schema
			$notification_type_id       =  Config::get('common.notification_type_id');
			$notification_data          =  notificationsmodel::get_notification_type($notification_type_id);
			if(!empty($notification_data))
			{
				$data              			=  array(
												'd_id'=>$id,
												'notification_type_id'=>$notification_data[0]->notification_type_id,
												'notification_type'=>$notification_data[0]->notification_type_name,
												'status'=>"Active"
												);
				$notification_sent_id  = notificationsmodel::notification_insert($register_users[0]->dealer_schema_name,$data);
				//$notification_sent_id  = notificationsmodel::notification_insert($register_users[0]->dealer_schema_name,$email_template_data,$data);
			}
		}
		//Transaction history management end
		
		// Dealer detail informations store into registered schema
		$dealerdata			=	array('dealer_id'=>$id,
									'd_city'=>$city,
									'phone'=>$phone,
									'dealer_name'=>$dealer_name
								);

		$dms_details 		= 	dealermodel::dealerdetails_store($register_users[0]->dealer_schema_name,$dealerdata);
		//insert records in user accounts table in schmea connection
		$dealerdetails   	= 	array(
									'dealer_id' =>$id,
									'user_name' =>$dealer_name,                                
									'user_email'=>$email,
									'user_moblie_no'=>$mobile,
									'user_role'=>'0'                                   
                                    );
        $user_insert     	=   dealermodel::user_accounts($register_users[0]->dealer_schema_name,$dealerdetails);
        
        $billing_data      	=   array(
                                    'dealer_id'=>$id,
                                    'bill_start_date'=>$bill_date['current'],
                                    'bill_end_date'=>$bill_date['exp'],
                                    'bill_status'=>"Active",
                                    'billed_date'=>date("Y-m-d h:i:s"),
                                    'plan_amt'=>$planvalidamount,
                                    'coupen_amount'=>$coupon_amount,
                                    'payable_amount'=>$finalamount
                                        );
            $billing_id     =   billingmodel::dealer_billing_store($register_users[0]->dealer_schema_name,$billing_data);
            $plan_data     	=   subscriptionmodel::fetch_plandata($planid);
            $max_user		=	1;

            //insert new plan details in master (master dealer billing table)
            $master_billdata       = array(
                                        'dealer_id'=>$id,
                                        'invoice_id'=>"",
                                        'subscription_plan_id'=>$planid,
                                        'payment_date'=>Carbon::now(),
                                        'billing_date'=>Carbon::now(),
                                        'payment'=>$planvalidamount,
                                        'max_users'=>1,
                                        'subscription_start_date'=>$bill_date['current'],
                                        'subscription_end_date'=>$bill_date['exp'],
                                        'coupon_amount'=>$coupon_amount,
                                        'payable_amount'=>$finalamount,
                                        'bill_status'=>"",
                                        'current_subscription'=>1,
                                        'period'=>$plan_data['freq_desc'],
                                        'description'=>"Your Registered Plan is ".$plan_data['plan_type_name']." ".$plan_data['freq_desc']." for ".$max_user." Users.",
                                          );

            $master_bill_id        = subscriptionmodel::master_dealer_billing_store($master_billdata);
            
		return response()->json(['Result'=>'1',
									'message'=>'Successfully Registered. Password Activation Link Has Been Sent to Your Email-id!!'
									]);
		}    
		else
		   {
			return response()->json(['Result'=>'0',
									'message'=>'The Entered Contact number is already registered with us!!'
									]);
		  } 
		}   
	}
	//THIS FUNCTION USED FOR CHECK EMAILID EXIST
	public function doApiemailidexist()
	{
		//header('Access-Control-Allow-Origin: *');
		$emailid 	=	Request::input('email');
		if($emailid ==	"")
		{
			return response()->json(['result'=>0,
									'message'=>'Emailid is required']);
		}
		$checkusermail =  dealermodel::selectRaw("Count(*) as Total")
                                     ->where('d_email',"=",$emailid)
                                     ->first();
		if(intval($checkusermail->Total)>0){
			return response()->json(['result'=>0,
									'message'=>'The Entered Email-id is already registered with us!!']);
		}
		else
		{
			return response()->json(['result'=>1,
									'message'=>'Emailid is Valid']);
		}
	}
	//THIS FUNCTION USED FOR CHECK CONTACT NUMBER EXIST
	public function doApicontactexist()
	{
		//header('Access-Control-Allow-Origin: *');
		$mobilenumber 		=	Request::input('mobilenumber');
		if($mobilenumber	==	"")
		{
			return response()->json(['result'=>0,
									'message'=>'Mobilenumber is required']);
		}
		$checkusermail =  dealermodel::selectRaw("Count(*) as Total")
                                     ->where('d_mobile',"=",$mobilenumber)
                                     ->first();
		if(intval($checkusermail->Total)>0){
			return response()->json(['result'=>0,
									'message'=>'The Entered Mobile Number is already registered with us!!']);
		}
		else
		{
			return response()->json(['result'=>1,
									'message'=>'Mobile Number is Valid']);
		}
	}
	
	//THIS FUNCTION USED FOR CHECK CONTACT NUMBER EXIST
	public function doApicoupanexist()
	{
		$coupancode 		=	Request::input('coupancode');
		$plan_id 			=	Request::input('plan_id');
		if(!empty($coupancode) && !empty($plan_id))
		{
			$wherecon 		=	array('coupon_code'=>$coupancode,
										'coupon_validity'=>'Valid',
										'coupon_dealer_id'=>null);	
			$checkcoupan 	=  dealermodel::masterFetchTableDetails($this->coupanTable,
																	$wherecon
																	);
			$wherecoupan 	=	array('subscription_plan_id'=>$plan_id);
			$checkamount 	=  dealermodel::masterFetchTableDetails('master_subscription_plans',
																	$wherecoupan
																	);
			if(!empty($checkcoupan) && count($checkcoupan) >= 1 && count($checkamount) >= 1){
                $todaydate	=	Carbon::now('Asia/Kolkata');
                if($checkcoupan[0]->coupon_start_date<=$todaydate && $checkcoupan[0]->coupon_end_date>=$todaydate)
                {
					if($checkamount[0]->unit_cost >  $checkcoupan[0]->coupon_amount)
					{
						return response()->json(['result'=>1,
											'message'=>'Your Coupan is valid!!',
											'coupanamount'=>$checkcoupan[0]->coupon_amount,
											'coupancode'=>$checkcoupan[0]->coupon_code,
											'coupon_id'=>$checkcoupan[0]->coupon_id]);
					}
					else
					{
						return response()->json(['result'=>2,
											'message'=>'Your Coupan is not applicable here plan amount is lessthan copan amount!!']);
					}
				}
				else
				{
					return response()->json(['result'=>3,
										'message'=>'Your Coupan is expired!!']);
				}
			}
			else
			{
				return response()->json(['result'=>0,
										'message'=>'Your Coupan is not valid!!']);
			}
		}
	}

	/*START OF LOGIN FUNCTION*/
    public function doUserLogin()
    {
        $email          =   Input::get('email');
        $password       =   Input::get('password');
        if($email == "" || $password == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'All fields are required!!'
									]);
		}
        $checkuseremail = 	apimodel::checkEmailidExist($email,$password);
        $cityName 		=	"";
        $stateName 		=	"";
        if(!empty($checkuseremail) && count($checkuseremail) >= 1)
        {
			$resultcityandstate = 	apimodel::getCityAndState($checkuseremail->d_city);
			if(count($resultcityandstate) > 0)
			{
				foreach($resultcityandstate as $key=>$cityvalue)
				{
					$cityName 	= 	(($cityvalue->city_name == null)?'':$cityvalue->city_name);
					$stateName 	= 	(($cityvalue->state_name == null)?'':$cityvalue->state_name);
				}
			}
			//get address user details from schema dealerdetails table
			$address 		=	"";
			$city	 		=	"";
			$pincode 		=	"";
			$schemaname 	=	apimodel::dealerFetchDetails($checkuseremail->dealer_schema_name,$this->dealersubTable);
			if(!empty($schemaname) && count($schemaname) >= 1)
			{
				$address 	=	(($schemaname[0]->Address == null)?'':$schemaname[0]->Address);
				$city 		=	$cityName;
				$pincode 	=	(($schemaname[0]->pincode == null)?'':$schemaname[0]->pincode);
			}
			
			//CHECK PLAN TYPE FOR DELAER
			/*$whereplan 		=	array('dealer_id'=>$checkuseremail->d_id,'current_subscription'=>1);
			$planExp 		=  	dealermodel::masterFetchTableDetails('dealer_billing_details',$whereplan);
			$planexpire 	=	"";
			$planeperiod 	=	"";
			$currentplan 	=	"";
			$plantypename	=	"";
			$totalDuration	=	0;
			if(!empty($planExp) && count($planExp) >= 1)
			{
				$myPlan 	=  	dealermodel::DoCheckDealerplandetails(
																$checkuseremail->d_id,
																$planExp[0]->subscription_start_date,
																$planExp[0]->subscription_end_date
																);
				$plantypename	=	((count($myPlan)>=1)?$myPlan[0]->plan_type_name:'');					
				$currentplan	=	((count($myPlan)>=1)?$myPlan[0]->feature_allowed:'');												
				$planeperiod	=	((count($myPlan)>=1)?$myPlan[0]->period:'');												
				$startTime 		= 	Carbon::parse($myPlan[0]->subscription_end_date);
				$finishTime 	= 	Carbon::now('Asia/Kolkata');
				$totalDuration 	= 	$startTime->diffForHumans($finishTime);
			}
			
			if(strpos($totalDuration,'after') !== false)
			{
				$totalDuration	=	"Yes";
			}
			if(strpos($totalDuration,'before') !== false)
			{
				$totalDuration	=	"No";
			}*/
			
			return response()->json(['Result'=>'1',
										'message'		=>"Successfully logged",
										'user_id'		=>$checkuseremail->d_id,
										'dealer_name'	=>$checkuseremail->dealer_name,
										'dealershipname'=>$checkuseremail->dealership_name,
										'dealer_mobile'	=>$checkuseremail->d_mobile,
										'dealer_email'	=>$checkuseremail->d_email,
										'parent_id'		=>$checkuseremail->parent_id,
										'dealer_img'	=>stripslashes(url($checkuseremail->logo)),
										'dealer_address'=>$address,
										'city'			=>$city,
										'pincode'		=>$pincode
										]);
		}
		else
		{
			return response()->json(['Result'=>'0',
										'message'		=>"Invalid E-Mail Or Password.Please try again."
										]);
		}
    }
/*END OF LOGIN FUNCTION*/

/*START OF COMETCHAT LOGIN FUNCTION*/
    public function doUserLoginCometchat()
    {
        $id          =   Request::input('session_user_id');
        if($id == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'User id is required!!'
									]);
		}
        $checkuserid = 	dealermodel::dealerprofile($id);
        if(!empty($checkuserid) && count($checkuserid) >= 1)
        {
			$sessionid 	=	session(['ses_id'=>$checkuserid->d_id]);
			 return redirect('http://staging.dealerplus.in/cometchat/cometchat_embedded.php?cookiePrefix=cc_&basedata=null&ccmobileauth=1cdfe9b602e143494ca712ee35eadc24');
		}
		else
		{
			return response()->json(['Result'=>'0',
										'message'=>"Invalid Access"
										]);
		}
    }
    
/*START OF CHANGE PASSWORD FUNCTION*/
	public function doChangePassword(Request $req)
	{

		$userid				=	Request::get('id');
		$oldpassword 		=	Request::get('oldpassword');
		$newpassword		=	Request::get('newpassword');
		$confirm_password	=	Request::get('confirm_password');
		$checkuserpassword	= 	apimodel::checkUserPassword($userid);
		if($userid == "" || $oldpassword == "" || $newpassword == "" || $confirm_password == "")
		{
			return response()->json(['Result'=>'0',
									'message'=>'All fields are required!!'
									]);
		}
		$schemaname 		=	$this->getschemaname($userid);
		$checkuserid		= 	apimodel::checkUserIdExist($userid);
		if(!empty($checkuserid->d_id))
		{
				if($checkuserpassword->d_password == $oldpassword && $checkuserpassword->d_password != $newpassword)
				{
					if($newpassword == $confirm_password)
					{
						$updatepassword		  	  =		array('d_password' => $newpassword);
						$whereuserid		  	  =		array('d_id' => $userid);
						$whereschemauserid		  =		array('dealer_table_id' => $userid);	
						$updateschemapassword	  =		array('password_hash' => $newpassword);													
						$updateEmailstatus		  =		apimodel::updateEmailStatus($whereuserid,$updatepassword);
						/*$updateEmailstatus		  =		dealermodel::dealer_schema_update(
																				$schemaname,
																				$this->userAccountTable,
																				$whereschemauserid,
																				$updateschemapassword);*/
						if(!empty($updateEmailstatus) && count($updateEmailstatus) >= 1)
						{
							return response()->json(['Result'=>'1',
													'message'=>"Successfully Password Updated."]
													);
						}
						else
						{
							return response()->json(['Result'=>'0',
													'message'=>"Unable to update Your Password Please Try Again!!"]
													);
						}
					}
					else
					{
						return response()->json(['Result'=>'0',
											'message'		=>"Your Confirm Password is mismatching!!"]
											);
					}
				}
				else
				{
					return response()->json(['Result'=>'0',
											'message'		=>"Invalid Password!!"]
											);
				}
		 }
		 else
		 {
			 return response()->json(['Result'=>'0',
										'message'		=>"Invalid User!!"
										]);
		 }
	}
/*END OF CHANGE PASSWORD FUNCTION*/

/*EDIT USER ACCOUNT FUNCTION */
	public function doEditAccount(){
		$id					=	Request::input('session_user_id');
		$dealername			=	Request::input('delaer_name');    
		$mobile				=	Request::input('mobile_number');    
		$getimage			=	Request::input('profile_image');
		$dealer_address		=	Request::input('dealer_address');
		$dealercity			=	Request::input('city');
		$dealerpincode		=	Request::input('pincode');
		$setuserimage 		= 	'data:image/png;base64,';
		$userimage 			=	'';
		
		/*if($id == "" || $dealername == "" || $mobile == "" || $dealer_address == "" 
		|| $dealercity == ""  || $dealerpincode == ""  || $getimage == "" )
		{ */
		if($id == "" || $dealername == "" || $mobile == "" || $dealer_address == "" 
		|| $getimage == "" )
		{       
				return response()->json(['Result'=>'0',
								'message'		=>"All fields are required!!"]
								);
		}
		if(Request::input('page_name') == "updateprofile")
		{
			$checkuserid			= 	apimodel::checkUserIdExist($id);
			if(!empty($checkuserid->d_id) && count($checkuserid->d_id) >= 1)
			{
				$userimage			=	$setuserimage.$getimage;
				$base64_img_array 	= 	explode(':', $userimage);
				$img_info 			= 	explode(',', end($base64_img_array));
				$img_file_extension = '';
				if (!empty($img_info)) {
					switch ($img_info[0]) {
						case 'image/jpeg;base64':
							$img_file_extension = 'jpeg';
							break;
						case 'image/jpg;base64':
							$img_file_extension = 'jpg';
							break;
						case 'image/gif;base64':
							$img_file_extension = 'gif';
							break;
						case 'image/png;base64':
							$img_file_extension = 'png';
							break;
					}
				}
				//delete exist file name start
				$filename 		=	$checkuserid->logo;
				$deletefilename	=	explode('/',$filename,6);
				if(!empty($deletefilename[5]))
				{
					if(file_exists(public_path($deletefilename[5])))
					{
						unlink(public_path($deletefilename[5]));
					}
				}
				//delete exist file name end
				$nameofimage   = rand(23232,99999).'.'.$img_file_extension;
				$img_file_name = public_path().'/profileimages/'.$nameofimage;
				$img_file = file_put_contents($img_file_name, base64_decode($img_info[1]));
				if (isset($img_file) && $img_file != "") {
					//get city id based on city name
					$cityidupdate 		=	"";
					$resultcityandstate = 	apimodel::searchcityname($dealercity);
					if(count($resultcityandstate) >= 1)
					{
						foreach($resultcityandstate as $key=>$cityvalue)
						{
							$cityidupdate 	= 	$cityvalue->city_id;
						}
					}
					else
					{
							$cityidupdate 	= 	'526';
					}
				
				$updatedata		  	 	=	array('dealer_name' => $dealername,
													'd_mobile' 	=> $mobile,
													'logo' 	=> url('profileimages/'.$nameofimage),
													'd_city'=>$cityidupdate
													);
				$whereuserid 			=	array('d_id'=>$id);
				
				$updateschema 			=	array('phone' 	=> $mobile,
													'logo' 	=> url('profileimages/'.$nameofimage),
													'Address'=>$dealer_address,
													'pincode'=>$dealerpincode,
													'd_city'=>$cityidupdate);
				$schemaname 			=  	$this->getschemaname($id);
				if(!empty($schemaname))
				{
					$updatemaster		=	apimodel::updateEmailStatus($whereuserid,$updatedata);
					$updateschemadata	=	dealermodel::dealerdetails_update(
																		$schemaname,
																		$updateschema,
																		$id);					
					$checkuseremail 	= 	apimodel::checkUserIdExist($id);
					$resultcityandstate = 	apimodel::getCityAndState($checkuseremail->d_city);
					$cityName 			=  	"";
					$stateName 			=	"";
					if(count($resultcityandstate) > 0)
					{
						foreach($resultcityandstate as $key=>$cityvalue)
						{
							$cityName 	= 	$cityvalue->city_name;
							$stateName 	= 	$cityvalue->state_name;
						}
					}
					//get address user details from schema dealerdetails table
					$address 		=	"";
					$city	 		=	"";
					$pincode 		=	"";
					$schemaname 	=	apimodel::dealerFetchDetails($checkuseremail->dealer_schema_name,$this->dealersubTable);
					if(!empty($schemaname) && count($schemaname) >= 1)
					{
						$address 	=	$schemaname[0]->Address;
						$city 		=	$cityName;
						$pincode 	=	$schemaname[0]->pincode;
					}								
					if(!empty($updateschemadata) && !empty($updatemaster) && count($updatemaster) >= 1 && count($updateschemadata) >= 1)
					{
						return response()->json(['Result'=>'1',
												'message'=>"Successfully Profile is Updated.",
												'user_id'		=>$checkuseremail->d_id,
												'dealer_name'	=>$checkuseremail->dealer_name,
												'dealershipname'=>$checkuseremail->dealership_name,
												'dealer_mobile'	=>$checkuseremail->d_mobile,
												'dealer_email'	=>$checkuseremail->d_email,
												'parent_id'		=>$checkuseremail->parent_id,
												'dealer_img'	=>stripslashes(url($checkuseremail->logo)),
												'dealer_address'=>$address,
												'city'			=>$city,
												'pincode'		=>$pincode
												]);
					}
					else
					{
						return response()->json(['Result'=>'0',
												'message'=>"Unable to update Your Profile Please Try Again!!"]
												);
					}	
				}
				} else {
					return response()->json(['Result'=>'0',
											'message'			=>	"Upload Image again!!"
											]);
				}
			}
		}
		return response()->json(['Result'=>'0',
											'message'		=>"Invalid User!!"
											]);
		  
	}



/*START OF FORGET PASSWORD FUNCTION*/
    public function doForgotPassword(Request $req)
    {
        $mailid			=	Request::input('mailid');
        if($mailid == "")
        {
			return response()->json(['Result'=>'0',
										'message'=>"Enter E-Mail id"
										]);
		}
		$checkuseremail = 	apimodel::checkUserEmailidExist($mailid);
        if($checkuseremail->Emailid > 0)
        {
			$getUserResult	=	apimodel::getUserInformation($mailid);
			if(!empty($getUserResult) && count($getUserResult) > 0)
			{
				$change_password_id       =        	Config::get('common.change_password_template_id');
				$email_template_data      =         emailmodel::get_email_templates($change_password_id);
				foreach ($email_template_data as $row) 
				{
					$mail_subject  		  =  $row->email_subject;
					$mail_message  		  =  $row->email_message;
					$mail_params   		  =  $row->email_parameters; 
				}
				$url                      =         url("changepassword/".encrypt($getUserResult->d_id));
				$data              		  =   array(
                                    '0'		=>	$url,
                                    '1'		=>	$getUserResult->dealer_name,
                                    '2'		=>	$getUserResult->d_email,
                                    '3'		=>	"",
                                    '4'		=>	"",
                                    'id'	=>	$getUserResult->d_id
                                );
				$email_template    		  =   emailmodel::emailContentConstruct($mail_subject,$mail_message,$mail_params,$data);
				$email_sent        		  =   emailmodel::email_sending($mailid,$email_template);
				$updatestatus		  	  =	  array($this->emailStatus => 'Inactive');
				$whereemailid		  	  =	  array($this->masteremailId => $mailid);														
				$updateEmailstatus		  =	  apimodel::updateEmailStatus($whereemailid,$updatestatus);
				return response()->json(['Result'=>'1',
										'message'=>"Reset password link sent to your mail id. Reset password and login again."
										]);
			}
			else
			{
				return response()->json(['Result'=>'0',
										'message'		=>"Invalid E-Mail id"
										]);
			}
		}
		else
		{
			return response()->json(['Result'=>'0',
										'message'		=>"Invalid E-Mail id"
										]);
		}
    }
    /*END OF FORGET PASSWORD FUNCTION*/
    
     //GET SCHEMA NAME FUNCTION
    public function getschemaname($id)
    {
		$getdealer_schemaname 	  		=	dealermodel::masterFetchTableDetails(
																		$this->dealerMasterTable,
																		array('d_id'=>$id)
																		);
			$dealer_schemaname			= 	"";
			if(!empty($getdealer_schemaname) && count($getdealer_schemaname) > 0)
			{															
				foreach($getdealer_schemaname as $dealernameselect)
				{
					$dealer_schemaname	= 	$dealernameselect->dealer_schema_name;
				}
				return $dealer_schemaname;
			}
			else
			{
				return false;
			}
	}
	//check coupan is valid or not
	public function doCheckcoupanexist($coupancode,$copan_id)
	{
		if(!empty($coupancode) && !empty($copan_id))
		{
			$wherecon 		=	array('coupon_code'=>$coupancode,
										'coupon_validity'=>'Valid',
										'coupon_dealer_id'=>null);	
			$checkcoupan 	=  dealermodel::masterFetchTableDetails($this->coupanTable,
																	$wherecon
																	);
			if(!empty($checkcoupan) && count($checkcoupan) >= 1){
                $todaydate	=	Carbon::now('Asia/Kolkata');
                if($checkcoupan[0]->coupon_start_date<=$todaydate && $checkcoupan[0]->coupon_end_date>=$todaydate)
                {
					return $checkcoupan[0]->coupon_amount;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}
	}

}
