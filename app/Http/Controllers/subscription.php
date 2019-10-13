<?php
/*
Module Name : subscription 
Created By  : Ahila
Use of this module is manage  users and  subscription details

Modified By  : Scindia
Change Log   : Code refactoring for subscription computation
*/
namespace App\Http\Controllers;

use Session;
use Redirect;
use Config;
use Request;
use DB;
use Carbon\Carbon;
use App\model\usersmodel;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

use App\model\subscriptionmodel;
use App\model\notificationsmodel;
use App\model\billingmodel;
use App\model\dealerPaymentmodel;
use App\model\commonmodel;
use App\model\emailmodel;
use App\model\dealermodel;
use App\model\smsmodel;
use App\model\couponmodel;

use App\model\transaction_historymodel;
use App\model\creditmodel;
use App\Exceptions\CustomException;
use App\Http\Controllers\payment\techprocess;
use App\Http\Controllers\coupon;
use App\model\dealerTransactionHistoryManagement;

class subscr_plan
{

public $subscr_plan_data;
public $plan_data;
public $credit_data;
public $frequency_data;
public $invoice_id;
public $bill_data;
public $number_of_users;
public $users_added;
public $users_removed;
public $carry_forward_users;
public $compute_for_users;
public $plan_start_date;
public $plan_end_date;
public $plan_remaining_days;
public $plan_total_days;
public $plan_cost_perdayuser;
public $balcost_peruser;
public $balcost_alluser;
public $plan_max_users;


public $credits_available=0;
public $credits_applied=0;
public $credits_to_be_added=0;
public $credit_balance=0;
public $refund_amount=0;

public $coupon_id=NULL;
public $coupon_amount=0;

public $unit_cost=0;
public $total_plan_amount=0;
public $pro_rata_amount=0;
public $subtotal_amount=0;
public $coupon_discount=0;
public $cost_to_pay_now=0;
public function __construct()
{    
                    
}
public function fillSubscriptionData($d_id)
{
  $this->bill_data = subscriptionmodel::fetch_dealer_billing($d_id,1);  
  $this->subscr_plan_data     =subscriptionmodel::fetch_plan_by_subid($this->bill_data->subscription_plan_id);  
  $this->credit_data = creditmodel::fetchCredit($d_id);
  $this->number_of_users = $this->bill_data->max_users;
  $this->plan_start_date    =  Carbon::parse($this->bill_data->subscription_start_date);
  $this->plan_end_date      =  Carbon::parse($this->bill_data->subscription_end_date);
  $plan_change_date  =  Carbon::now();
  $this->unit_cost=$this->subscr_plan_data[0]->unit_cost;
    $this->plan_remaining_days      =  $plan_change_date->diffInDays($this->plan_end_date);
    $this->plan_total_days      =  $this->plan_start_date->diffInDays($this->plan_end_date);
    $this->plan_cost_perdayuser =  ($this->unit_cost)/$this->plan_total_days ;
    $this->balcost_peruser     =  $this->plan_cost_perdayuser*$this->plan_remaining_days;
    $this->balcost_alluser     =   $this->balcost_peruser*$this->number_of_users;

  
}
public function fillPlanData($new_plan_id,$freq_int,$freq_desc,$d_id)
{
    //echo ("test ".$new_plan_id." ".$freq_int." ".$freq_desc);

     $this->subscr_plan_data     =subscriptionmodel::fetch_plan_by_planid($new_plan_id,$freq_int,$freq_desc);  

    $this->unit_cost=$this->subscr_plan_data[0]->unit_cost;
    $this->credit_data = creditmodel::fetchCredit($d_id);
  
 
}

public function getPlanArray()
{
  $plan_array  = array(
                      'cur_startdate'=>$this->plan_start_date,
                      'cur_enddate'=>$this->plan_end_date,
                      'cur_credit'=>$this->credit_data[0]->credit_balance,
                     'dealer_sub_id'     =>  $this->bill_data->subscription_plan_id,
                      'dealer_payment'    =>  $this->bill_data->payment,
                      'dealer_paymentdate'=>  $this->bill_data->subscription_end_date,
                      'plan_type_name'       =>  $this->subscr_plan_data[0]->plan_type_name,
                      'frequency_name'    =>  $this->subscr_plan_data[0]->frequency_desc,
                      'user_count'        =>  $this->number_of_users,
                      'total_plan_amount'   => $this->bill_data->total_amount,
                      'plan_balance_amount'   => round($this->balcost_alluser,2,PHP_ROUND_HALF_UP),
             );
           return $plan_array;
}


}
class subscription extends Controller
{

public $active_menu_name;
public $header_data;
public $side_bar_active;
public $side_bar_customer;
public $p_id;
public $id;
public function __construct()
{    
  $this->active_menu_name     ='manage_menu';   
  $this->side_bar_active      ='subscription';      
  $this->middleware(function ($request, $next) 
    {
      $this->id                   = session::get('ses_id');
      $this->p_id                 = dealermodel::parent_id($this->id);
      $this->login_authecation    = session()
                                      ->has( 'ses_dealername' ) ? session()
                                      ->get( 'ses_dealername' ) :  Redirect::to('login')
                                      ->send();
      $this->header_data      = commonmodel::commonheaderdata();
      $this->header_data['title']='Subscription';
      $this->header_data['p_id']   =$this->p_id;
      return $next($request);
      }
    );                  
}
public function  getCostArray($newplan, $oldplan, $message, $computed_users)
{
  
  
  $cost_data  =  array(
                            'res_msg'=>$message,
                            'pre_rem_days'=>$oldplan->plan_remaining_days,
                            'pre_tot_days'=>$oldplan->plan_total_days,
                            'precost_perdayuser'=>$oldplan->plan_cost_perdayuser,
                            'balcost_peruser'=>$oldplan->balcost_peruser,
                            'balcost_alluser'=>round($oldplan->balcost_alluser,2,PHP_ROUND_HALF_UP),
                            'unit_cost'=>$newplan->unit_cost,
                            'cur_cost'=>$newplan->unit_cost,
                            'total_users'=>$newplan->number_of_users,
                            'users_added_now'=>$newplan->users_added,
                            'carry_users'=>$newplan->carry_forward_users,
                            'nowpaid_cost'=>round($newplan->cost_to_pay_now,2,PHP_ROUND_HALF_UP),
                            'prorata_cost'=>round($newplan->pro_rata_amount,2,PHP_ROUND_HALF_UP),
                            'tot_comput_cost'=>round($newplan->total_plan_amount,2,PHP_ROUND_HALF_UP),
                            'sub_total'=>round($newplan->subtotal_amount,2,PHP_ROUND_HALF_UP),
                            //'user_comput_for'=>$computed_users,
                            'remaining_users'=>$oldplan->number_of_users,
                            'new_planid'=>$newplan->subscr_plan_data[0]->plan_type_id,
                            'new_planname'=>$newplan->subscr_plan_data[0]->plan_type_name,
                            'new_freqid'=>$newplan->subscr_plan_data[0]->frequency_id,
                            'new_freqdesc'=>$newplan->subscr_plan_data[0]->frequency_desc,
                            'new_freq_int'=>$newplan->subscr_plan_data[0]->frequency_interval,
                            'coupon_id'=>$newplan->coupon_id,
                            'coupon_amount'=>$newplan->coupon_amount,
                            'credit_balance'=>round($oldplan->credit_data[0]->credit_balance,2,PHP_ROUND_HALF_UP),
                            'creditsApplied'=>round($newplan->credits_applied,2,PHP_ROUND_HALF_UP),
                            'creditsToBeAdded'=>round($newplan->credits_to_be_added,2,PHP_ROUND_HALF_UP),
                            'new_credit_balance'=>round($newplan->credit_balance,2,PHP_ROUND_HALF_UP),
                            'old_id'=>$oldplan->subscr_plan_data[0]->subscription_plan_id,
                            'new_id'=>$newplan->subscr_plan_data[0]->subscription_plan_id,
              );
      return $cost_data;        
}

public function change_subscription()
{

$header_data           =  $this->header_data;
$header_data['title']  =  'Subscription';
$compact_array         = array(
                            'active_menu_name'=>$this->active_menu_name,
                            'side_bar_active'=>$this->side_bar_active,
                          ); 

    $id                   =     Session::get('ses_id');
    $ses_dealer_name      =     Session::get('ses_dealername');
   
    $new_planid = Request::input('new_planid');
    $new_planval = Request::input('new_planval');
    $new_freq_id = Request::input('new_freq_id');
    $old_subid   = Request::input('old_subscription_id');
    $new_subid = Request::input('new_subscription_id');
    
    $coupon_code = Request::input('coupon_code');
    $coupon      = Request::input('coupon_amount');
    $freq_interval   = Request::input('new_freq_interval');
    $freqq_des   = Request::input('new_freq_desc');
    $max_user    = Request::input('max_user');
  
    $tempCredit   =  0;
    $cou_amount   =  0;
    $calc_payable =  0; 
    $creditAvailable = 0;
    $crditApplied    = 0; 

    $feature_list = subscriptionmodel::fetch_feature();
    $plan_data    = subscriptionmodel::fetch_plan_by_subid($new_subid);
    
    $stat_date    =  Carbon::now();
    $bill_date    =  billingmodel::billing_enddate($stat_date,$new_freq_id);
    
    
    $cost_data    =  $this->subscription_calculate($id,$new_planval,$freq_interval,$freqq_des,$max_user,$old_subid,"",$coupon_code);
   
  
  $creditStrId  =  creditmodel::strCredits($tempCredit,Session::get('ses_id'));

//Insert new plan details in master (master dealer billing table)
  $master_billdata  = array(
                            'dealer_id'  =>    Session::get('ses_id'),
                            'invoice_id' =>    "",
                            'subscription_plan_id'=>$cost_data['new_id'],
                            'payment_date'  =>  Carbon::now(),
                            'billing_date'  =>  Carbon::now(),
                            'payment'       =>  $cost_data['nowpaid_cost'],
                            'max_users'     =>  $cost_data['total_users'],
                            'subscription_start_date'  =>  $bill_date['current'],
                            'subscription_end_date'    =>  $bill_date['exp'],
                           // 'coupon_id'       =>     $cost_data['coupon_id'],
                            'coupon_amount'   =>     $cost_data['coupon_amount'],
                            'payable_amount'  =>     $cost_data['nowpaid_cost'],
                            'bill_status'     =>     "",
                            /*'current_subscription'  =>  config::get('common.cur_sub_key'),*/
                            'current_subscription'  =>  0,
                            'description' =>  "Changed Plan into ".$cost_data['new_planname']." ".$cost_data['new_freqdesc']." for ".$cost_data['total_users']." Users.",
                            'period'   =>  $cost_data['new_freqdesc'],
                            'carry_forward_users'   =>  $cost_data['carry_users'],
                            'carry_forward_amount'  =>  $cost_data['balcost_alluser'],
                            'total_amount'     =>    $cost_data['tot_comput_cost'],
                          );

   $master_bill_id  = subscriptionmodel::master_dealer_billing_store($master_billdata,"","true");

   //Increase count value in count table
   
  $fetchid = $this->sendingPlanEmailSms($plan_data,config::get('common.changeplan_email_template_id'),$bill_date['exp'],$max_user); 
   //$dealer_id = sesssion::get('ses_id');
   $check_user = usersmodel::user_table(Session::get('ses_id'))->update(["status" => "Inactive"]);
   $check_user = usersmodel::user_table(Session::get('ses_id'))->where('user_id',1)->update(["status" =>"Active"]);  
  
try
{

$curCreditData             = creditmodel::strCredits(round($cost_data['new_credit_balance'],2,PHP_ROUND_HALF_UP),Session::get('ses_id'));

$header_data['email_count'] = notificationsmodel::fetchNotificationCount(Session::get('dealer_schema_name'),Session::get('ses_id'));

//Payment Gateway
if($cost_data['nowpaid_cost'] > 0.0)
{

  $requesteddata = array(Session::get('ses_dealername'),Session::get('ses_id'),'9789873916',$master_bill_id ,'1', Carbon::now()->format('d-m-Y'),url('subscriptionPaymentResp'),'Testdata');
  $payment_response = techprocess::paymentrequest($requesteddata);
  Redirect::to($payment_response)->send();
}
else
{
  $update_dealer = subscriptionmodel::dealer_subscription_update(Session::get('ses_id'));
  $updateBillData  =  array(
                        'history_id'=>$master_bill_id,
                        'bill_status'=>"success",
                        'mode'=>"DealerPlus Wallet",
                        'billing_date'=>Carbon::now(),
                        'current_subscription'=>config::get('common.cur_sub_key'),
                      );
    $historyID = subscriptionmodel::updateMasterDealerBilling($updateBillData);
    Session::flash('message',config::get('common.plan_new_change'));
    return redirect('managesubscription');
}


}
catch(\Exception $e)
{
  throw new CustomException($e->getMessage());
}
}


public function subscriptionPaymentResp()
{

  try
  {
     $reponse = $_POST;
     $paymentResponse = techprocess::paymentresponse($reponse);
     if($paymentResponse['txn_msg'] == "success")
     {
        $updateBillData  =  array(
                              'history_id'=>$paymentResponse['clnt_txn_ref'],
                              'payment'=>$paymentResponse['txn_amt'],
                              'billing_date'=>\Carbon\Carbon::createFromFormat('d-m-Y H:i:s', $paymentResponse['tpsl_txn_time'])->format('Y-m-d H:i:s'),
                              'bill_status'=>$paymentResponse['txn_msg'],
                              'mode'=>config::get('common.paymentMode'),
                              'current_subscription'=>config::get('common.cur_sub_key'),
                            ); 
        $currBillingData = subscriptionmodel::fetch_dealer_billing(Session::get('ses_id'),'1');

        $update_dealer = subscriptionmodel::dealer_subscription_update($currBillingData->dealer_id);
     }
     else if($paymentResponse['txn_msg'] == "failure")
     {
      $updateBillData  =  array(
                              'history_id'=>$paymentResponse['clnt_txn_ref'],
                              'payment'=>0.0,
                              'billing_date'=>\Carbon\Carbon::createFromFormat('d-m-Y H:i:s', $paymentResponse['tpsl_txn_time'])->format('Y-m-d H:i:s'),
                              'bill_status'=>$paymentResponse['txn_msg'],
                              'mode'=>config::get('common.paymentMode'),
                              );
     }
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
   if($paymentResponse['txn_msg'] == "success")
   {
   
   Session::flash('message', "Payment process done. And ".config::get('common.plan_new_change'));
   
   }
   else if($paymentResponse['txn_msg'] == "failure")
   {
    Session::flash('message-err', "Payment process failure!!!");
   }
   
   return redirect('managesubscription');

 }
  catch(\Exception $e)
  {
     throw new CustomException($e->getMessage());
  }

}
//To show subscription detail page show
public function subscriptiondetail_show()
{


$header_data           =    $this->header_data;
$header_data['title']  =    'Subscription';
$compact_array         =    array(
                               'active_menu_name'=>$this->active_menu_name,
                               'side_bar_active'=>$this->side_bar_active,
                             );  
  $id                  =     Session::get('ses_id');
  $new_plan            =     Request::input('new_plan');
  $new_planval         =     Request::input('new_planval');
  $new_freq            =     Request::input('new_freq');
  $freq_desc           =     Request::input('new_freq');
  $add_user            =     Request::input('newtot_user');
  $tot_user            =     Request::input('newtot_user');
 
 $payment_data        =     $this->subscription_calculate($id,$new_plan,$new_freq,$freq_desc,$add_user);

 if($payment_data['res_msg'] == 0)
 {
      Session::flash('message-err',$payment_data['message']);
      return redirect('managesubscription');
 }
 elseif($payment_data['res_msg'] == 1)
 {
      $feature_list        =     subscriptionmodel::fetch_feature();  
      $freq                =     $feature_list[$new_plan];
      return view('subscriptiondetail',compact('payment_data','freq','compact_array','header_data'));
 }
 
}


// To show all calculations on active Div in manage subscription
public function subscription_data()
{
   $id                   =     Session::get('ses_id');
   $new_plan             =     Request::Input('plan_val');
   $new_planval             =     Request::Input('plan_val');
   $freq_int             =     Request::Input('freq_int');
   $freq_desc            =     Request::Input('freq_desc');
   $add_user             =     Request::Input('add_user');
   $user_count           =     Request::Input('user_count');
   $tot_user             =     Request::Input('tot_user');
   $old_sub_id           =     Request::Input('sub_id');
   $totParentCount       =     usersmodel::dealerParentCount($id);

   //echo "test";
   
   $cost_data            =     $this->subscription_calculate($id,$new_plan,$freq_int,$freq_desc,$add_user,$old_sub_id);
   return \Response::json($cost_data);
}


//Only calculation for subscription
public function subscription_calculate($id=0,$new_plan="",$freq_int="",$freq_desc="",$add_user=0,$old_sub_id="",$creditData="",$cdata="")
{
  //echo $id;
 
  $user_old_plan=new subscr_plan();
  $user_old_plan->fillSubscriptionData($id);
  
  $user_new_plan=new subscr_plan();
  $user_new_plan->fillPlanData($new_plan,$freq_int,$freq_desc,$id);
  
  $coupon_amount=0;
 
   //In same plan
    if(($user_old_plan->subscr_plan_data[0]->plan_type_name==$new_plan)
    &&($user_old_plan->subscr_plan_data[0]->frequency_interval==$freq_int)
      &&($user_old_plan->subscr_plan_data[0]->frequency_desc==$freq_desc))
    {
      
  
      if($user_old_plan->number_of_users==$add_user)
      {
        //Same user and Same plan
        $message   =  config::get('common.plan_same_change');
        $cost_data =  array(
                          'res_msg'=>0,
                          'message'=>$message,
                          'nowpaid_cost'=>0
                        );

        return \Response::json($cost_data);
      }
      elseif($user_old_plan->number_of_users < $add_user)
      {

        //Same plan But adding users
       
      $user_new_plan->users_added = $add_user - $user_old_plan->number_of_users;
    $user_new_plan->users_removed = 0;
    $user_new_plan->carry_forward_users = $user_old_plan->number_of_users;
    //echo ($user_old_plan->plan_remaining_days." ".$user_old_plan->plan_cost_perdayuser." ".$user_new_plan->unit_cost);
    
    $user_new_plan->pro_rata_amount = ($user_old_plan->plan_remaining_days+1) * $user_old_plan->plan_cost_perdayuser * $user_new_plan->users_added ;
        $user_new_plan->number_of_users = $add_user;
    $user_new_plan->total_plan_amount = $add_user * $user_new_plan->unit_cost; 
    $user_new_plan->subtotal_amount = $user_new_plan->pro_rata_amount;
    $this->computeCostToPayNow($user_new_plan,"",$user_old_plan);
    
    $cost_data1=$this->getCostArray($user_new_plan, $user_old_plan, config::get('common.cur_sub_key'), 10);
  
        return $cost_data1;

        
      }
      elseif($user_old_plan->number_of_users > $add_user)
      {
        //Same plan But decreasing users
        $user_new_plan->users_added = 0;
    $user_new_plan->users_removed = $user_old_plan->number_of_users - $add_user;
    $user_new_plan->carry_forward_users = $add_user;
    
    
    $user_comput_for  =  $user_old_plan->number_of_users - $add_user;
    
    $user_new_plan->cost_to_pay_now = $user_old_plan->plan_remaining_days * $user_old_plan->plan_cost_perdayuser * $add_user ;
    if ($user_old_plan->balcost_alluser > $user_new_plan->cost_to_pay_now)
    {
    $user_new_plan->credits_to_be_added = $user_old_plan->balcost_alluser - $user_new_plan->cost_to_pay_now;
    
    $user_old_plan->balcost_alluser = $user_old_plan->balcost_alluser - $user_new_plan->cost_to_pay_now;
  
    $user_new_plan->cost_to_pay_now=0;
    }
      else 
    {
      
      $user_new_plan->cost_to_pay_now = $user_old_plan->plan_cost_perdayuser * $user_comput_for * $user_old_plan->pre_tot_days;
    
    }
      
        $user_new_plan->number_of_users = $add_user;
    $user_new_plan->total_plan_amount = $add_user * $user_new_plan->unit_cost; 
    
    
    
    $cost_data1=$this->getCostArray($user_new_plan, $user_old_plan, config::get('common.cur_sub_key'), 10);
        return $cost_data1;


      }
    }
    
    //Change to new plan
else
{
    
    $future_entry     =  subscriptionmodel::fetch_future_billing(Session::get('ses_id'),config::get('common.future_sub_key'));
  //echo "after future";
        
    //$old_plan_data    =   subscriptionmodel::fetch_plan_by_subid($user_old_plan);
    
   if(count($future_entry) > 0)
    {
    //echo "inside else if";
        $message   =  "New Plan future entry added already.Not able to add again.";
        $cost_data =  array(
                          'res_msg'=>0,
                          'message'=>$message,
                          'nowpaid_cost'=>0
                        );

        
        return $cost_data;
    }
    else
    {
    
   
    //if(count($user_old_plan->bill_data)>0)
  
      //sub function only for calculation
      //echo "inside change plan";
      $cost_data  =  array();
    $this->changeplan_calculate($user_new_plan,$user_old_plan,$add_user);
      
    $coupon_data=(new coupon)->getCoupon($cdata,$user_new_plan->subtotal_amount);
    if ($coupon_data['validity'] == 1)
    {
      $user_new_plan->coupon_id=$coupon_data['coupon_id'];
      $user_new_plan->coupon_amount=$coupon_data['coupon_amount'];
      $coupon_amount=$coupon_data['coupon_amount'];
    }
           
    $this->computeCostToPayNow($user_new_plan,$coupon_amount,$user_old_plan);
    $cost_data =$this->getCostArray($user_new_plan,$user_old_plan,1,10);
    return $cost_data;
    }
}
}
public function changeplan_calculate($new_plan,$old_plan,$add_user)
{
  $new_plan->number_of_users=$add_user;
  if($add_user < $old_plan->number_of_users)
  {
    $new_plan->carry_forward_users=$add_user;
    
  }
  else
  {
    $new_plan->carry_forward_users=$old_plan->number_of_users;
  }
  
  if($new_plan->subscr_plan_data[0]->apply_group_cost  ==  'N')
   {

        $new_plan->user_comput_for  =     $add_user;
        $new_plan->total_plan_amount  =     $new_plan->user_comput_for * $new_plan->unit_cost;
   }
   else
   {
     $new_plan->total_plan_amount = $new_plan->subscr_plan_data[0]->group_cost;
   }
   if($new_plan->total_plan_amount  >   $old_plan->balcost_alluser)
    {
      $new_plan->subtotal_amount     =   $new_plan->total_plan_amount - $old_plan->balcost_alluser;
      $new_plan->credits_to_be_added   =   0;
    
  }
    else
    {
      $new_plan->subtotal_amount     =   0;
      $new_plan->credits_to_be_added     =   $old_plan->balcost_alluser-$new_plan->total_plan_amount;
    }   
}

public function computeCostToPayNow($newplan,$coupon_amount,$oldplan)
{
  
  $newplan->cost_to_pay_now=$newplan->subtotal_amount;
  
if( $oldplan->credit_data[0]->credit_balance > 0)
{
    if($newplan->subtotal_amount > $coupon_amount)
    {
       $newplan->cost_to_pay_now   =  $newplan->subtotal_amount - $coupon_amount;
    }
    else
    {
    $newplan->cost_to_pay_now =  $newplan->subtotal_amount;
      $coupon_amount  = 0;
    }
    
    if($oldplan->credit_data[0]->credit_balance >= $newplan->cost_to_pay_now)
    {
      $newplan->credits_applied     =  $newplan->cost_to_pay_now;
      $newplan->credit_balance  =  $oldplan->credit_data[0]->credit_balance  -  $newplan->cost_to_pay_now ;
      $newplan->cost_to_pay_now     =  0;
    
      
    }
    else
    {
      $newplan->cost_to_pay_now     =  $newplan->cost_to_pay_now  -   $oldplan->credit_data[0]->credit_balance ;
      $newplan->credit_balance  =  0;
      $newplan->credits_applied     =  $oldplan->credit_data[0]->credit_balance;
    }
  
}
$newplan->credits_to_be_added=$newplan->credits_to_be_added;

$newplan->credit_balance=$newplan->credit_balance + $newplan->credits_to_be_added;
$newplan->credit_balance=$newplan->credit_balance;
$newplan->credits_available=$newplan->credits_available;
$newplan->credits_applied=$newplan->credits_applied;

$oldplan->balcost_alluser=$oldplan->balcost_alluser;
$newplan->pro_rata_amount=$newplan->pro_rata_amount;
$newplan->subtotal_amount=$newplan->subtotal_amount;
$newplan->cost_to_pay_now=$newplan->cost_to_pay_now;

}
public function subscription_activate()
{
  $cost_data             =   $this->subscription_calculate();
  $master_billdata       = array(
                                'dealer_id'=>Session::get('ses_id'),
                                'invoice_id'=>"",
                                'subscription_plan_id'=>$newsub_id[0]->subscription_plan_id,
                                'payment_date'=>Carbon::now(),
                                'billing_date'=>Carbon::now(),
                                'payment'=>$cost_data['cur_cost'],
                                'max_users'=>$user_count,
                                'subscription_start_date'=>$future_end_date['startdate'],
                                'subscription_end_date'=>$future_end_date['exp'],
                                'coupon_amount'=>"",
                                'payable_amount'=>$cost_data['cur_cost'],
                                'bill_status'=>"",
                                'current_subscription'=>config::get('common.future_sub_key'),
                                'description'=>"End date for current plan is ".$exist_plan[0]->subscription_end_date." After that You can change in to ".$new_plan_data['plan_type_name']." ".$new_plan_data['freq_desc']." plan with ".$user_count." Users.",
                                'period'=>$new_plan_data['freq_desc'],
                                'carry_forward_users'=>$cost_data['carry_user'],
                                'carry_forward_amount'=>$cost_data['cur_cost']
                                  );
      $master_bill_id        = subscriptionmodel::master_dealer_billing_store($master_billdata);
      $cost_data['res_msg']  = "5";
      $cost_data['message']  = "test message New Future Entry added.";
      $fetchid               = $this->sendingPlanEmailSms($new_plan_data,config::get('common.futureplan_email_template_id'),$future_end_date['exp'],$user_count);   
      $header_data['email_count'] = notificationsmodel::fetchNotificationCount(Session::get('dealer_schema_name'),Session::get('ses_id'));
      return \Response::json($cost_data);

}

public function subscription_getDetails()
{
  $cost_data        =       $this->subscription_calculate();
  return \Response::json($cost_data);

}


// To show manage subscription page with fetching data.
public function managesubscription()
{

$header_data      = $this->header_data;
$id               =     Session::get('ses_id');
$compact_array    = array(
                     'active_menu_name'=>$this->active_menu_name,
                     'side_bar_active'=>$this->side_bar_active,
            
                      );  

$d_planlist       =   subscriptionmodel::fetchExceptPlan();


$frequency_list   =  array();
        $data     =  array();
        foreach ($d_planlist as $key => $value)
        {

            $plan_type_id  =  $value->plan_type_id;
            $plan_name  =  $value->plan_type_name;
          $fre = subscriptionmodel::fetch_planlist_by_planid($plan_type_id);
            
           $frequency_list[$plan_name]  =  array();

            foreach ($fre as $key)
            {
                
               $data['frequency_id']       =   $key->frequency_id;
               $data['frequency_interval'] =   $key->frequency_interval;
               $data['frequency_desc']     =   $key->frequency_desc;
               $data['frequency_name']     =   $key->frequency_name;
               array_push($frequency_list[$plan_name], $data);
            }

       
        }
    
    $feature_list =  subscriptionmodel::fetch_feature();

$current_plan  = new subscr_plan();
$current_plan->fillSubscriptionData(Session::get('ses_id'));
$cur_plan_details=$current_plan->getPlanArray();
$header_data['email_count'] = notificationsmodel::fetchNotificationCount(Session::get('dealer_schema_name'),Session::get('ses_id'));
return view('manage_subscription',compact('cur_plan_details','feature_list','frequency_list','compact_array','header_data','d_planlist'));
}


//Renew Plan
public function renewplan()
{
   $sub_id=Request::Input('sub_id');
   $user_count=Request::Input('user_count');
   $next_renewdate=Request::Input('next_renewdate');
   $cur_cost=Request::Input('cur_cost');
   
   $planBalCost=Request::Input('planBalCost');
   
   $today_carbon=Carbon::now();
   $today=\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$today_carbon)->format('d-m-Y');
   $plan_data=subscriptionmodel::fetch_plan_by_subid($sub_id);
   
   $plan_enddate=billingmodel::billing_enddate($today_carbon,$plan_data[0]->frequency_id);
  $future_entry=subscriptionmodel::fetch_future_billing(Session::get('ses_id'),config::get('common.future_sub_key'));

  if(count($future_entry)>0)
  {

         $renewplan_data        = array(
                                  'data'=>"false",
                                  'plan'=>$plan_data[0]->plan_type_name,
                                  'paid_users'=>$user_count,
                                  'freq'=>$plan_data[0]->frequency_desc,
                                  'subs_id'=>$sub_id,
                                  'next_renew'=>\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $next_renewdate)->format('d-m-Y'),
                                  'cur_cost'=>$cur_cost,
                                  'message'=>config::get('common.plan_renew_fail'),
                                   );
         return $renewplan_data;

  }
  else
  {
  
  $future_strdate  =    billingmodel::future_startdate(Session::get('ses_id'));
  $future_end_date =    billingmodel::billing_enddate($future_strdate,$plan_data[0]->frequency_id);
  //Insert new plan details in master (master dealer billing table)
    $subval = '5';
    $master_billdata       = array(
                                'dealer_id'=>Session::get('ses_id'),
                                'invoice_id'=>"",
                                'subscription_plan_id'=>$sub_id,
                                'payment_date'=>Carbon::now(),
                                'billing_date'=>Carbon::now(),
                                'payment'=>$cur_cost,
                                'max_users'=>$user_count,
                                'subscription_start_date'=>$future_end_date['startdate'],
                                'subscription_end_date'=>$future_end_date['exp'],
                                'coupon_amount'=>"",
                                'payable_amount'=>$cur_cost,
                                'bill_status'=>"",
                                'current_subscription'=>0,
                                'description'=>"Renewed Plan to ".$plan_data[0]->plan_type_name." ".$plan_data[0]->frequency_desc." for ".$user_count." Users.",
                                'period'=>$plan_data[0]->frequency_desc,
                                'carry_forward_users'=>$user_count,
                                'carry_forward_amount'=>$cur_cost
                                  );
    $master_bill_id        = subscriptionmodel::master_dealer_billing_store($master_billdata,$subval);

    //Payment Gateway
        if($cur_cost > 0.00)
        {  
          
        $fetchDealer      =   dealermodel::dealerfetch(session::get('ses_id'));
        $requesteddata = array(Session::get('ses_dealername'),Session::get('ses_id'),$fetchDealer[0]->d_mobile,$master_bill_id ,'1', Carbon::now()->format('d-m-Y'),url('subscriptionPaymentRespRenew'),'Testdata');
        
        $payment_response = techprocess::paymentrequest($requesteddata);
        return $payment_response;   
        }
        else
        {
            $updateBillData  =  array(
                              'history_id'=>$master_bill_id,
                              'bill_status'=>"N/A",
                              'mode'=>"FREE TRIAL",
                              'billing_date'=>Carbon::now(),
                              'current_subscription'=>config::get('common.future_sub_key'),
                              'description'=>"Renewed to Basic plan with one user",
                            );
          $historyID = subscriptionmodel::updateMasterDealerBilling($updateBillData);
          Session::flash('message',config::get('common.plan_renew_success'));
          //Sending Email & Sms for plan renew
          $fetchid = $this->sendingPlanEmailSms($plan_data,config::get('common.renewplan_email_template_id'),$future_end_date['exp'],$user_count);
        }  
     
  }  

}   


//Payment response for renew
public function subscriptionPaymentRespRenew()
{
    try
    {
     $reponse = $_POST;
     $paymentResponse = techprocess::paymentresponse($reponse);
     if($paymentResponse['txn_msg'] == "success")
     {
        $updateBillData  =  array(
                              'history_id'=>$paymentResponse['clnt_txn_ref'],
                              'payment'=>$paymentResponse['txn_amt'],
                              'billing_date'=>\Carbon\Carbon::createFromFormat('d-m-Y H:i:s', $paymentResponse['tpsl_txn_time'])->format('Y-m-d H:i:s'),
                              'bill_status'=>$paymentResponse['txn_msg'],
                              'mode'=>config::get('common.paymentMode'),
                              'current_subscription'=>config::get('common.future_sub_key'),
                              ); 
     }
     else if($paymentResponse['txn_msg'] == "failure")
     {
      $updateBillData  =  array(
                              'history_id'=>$paymentResponse['clnt_txn_ref'],
                              'payment'=>0.0,
                              'billing_date'=>\Carbon\Carbon::createFromFormat('d-m-Y H:i:s', $paymentResponse['tpsl_txn_time'])->format('Y-m-d H:i:s'),
                              'bill_status'=>$paymentResponse['txn_msg'],
                              'mode'=>config::get('common.paymentMode'),
                              'description'=>"Payment Process Cancelled for Plan Renew.",
                              );
     }
     
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
  
   if($paymentResponse['txn_msg'] == "success")
   {
   Session::flash('message', "Payment process done. And ".config::get('common.plan_renew_success'));
   }
   else if($paymentResponse['txn_msg'] == "failure")
   {
    Session::flash('message-err', "Payment process failure!!!");
   }
return redirect('managesubscription');
}
catch(\Exception $e)
{
     throw new CustomException($e->getMessage());
}
}


//Common Function to send mail , sms , notification Count
public function sendingPlanEmailSms($plan_data,$emailtype_id,$bill_enddate,$max_user)
{

  $dealer_data   =   dealermodel::dealerfetch(Session::get('ses_id'));
  $dealer_email  =   $dealer_data[0]->d_email;
  $dealer_schema =   $dealer_data[0]->dealer_schema_name;
  //$renewplan_template_id   =    config::get('common.renewplan_email_template_id');
  $email_template_data   =    emailmodel::get_email_templates($emailtype_id);
  $emailRenewTemplate    =    emailmodel::get_email_templates('18');


        foreach ($email_template_data as $row) 
            {
                $mail_subject  =  $row->email_subject;
                $mail_message  =  $row->email_message;
                $mail_params   =  $row->email_parameters; 
            }

            $url               =    url("mailsend/".encrypt(Session::get('ses_id')));

            $data              =    array(
                                          '0'=>$url,
                                          '1'=>$dealer_data[0]->dealer_name,
                                          '2'=>$dealer_data[0]->d_email,
                                          '3'=> "",
                                          '4'=>"",
                                          '5'=>$plan_data[0]->plan_type_name,
                                          '6'=>$plan_data[0]->frequency_desc,
                                          '7'=>$bill_enddate,
                                          '8'=>$max_user
                                         );

            $email_template    =     emailmodel::emailContentConstruct($mail_subject,$mail_message,$mail_params,$data);
            $email_sent        =     emailmodel::email_sending($dealer_data[0]->d_email,$email_template);

            //Insert change plan notification
            $notification_type_id  =  Config::get('common.notification_type_id');
            $notification_data     =  notificationsmodel::get_notification_type($notification_type_id);
            $changeplan_title      =  $mail_subject;
            $changeplan_message   =  $email_template['mail_message'];
            $notify_data              =  array(
                                        'd_id'=>$dealer_data[0]->d_id,
                                        'notification_type_id'=>$notification_data['0']->notification_type_id,
                                        'notification_type'=>$notification_data['0']->notification_type_name,
                                        'title'=>$changeplan_title,
                                        'message'=>$changeplan_message,
                                        'status'=>"1"
                                        
                                  );


            $notification_sent_id  = notificationsmodel::notification_insert($dealer_schema,$notify_data);

  //Transaction history management - dealer notification(For change plan)
      $trans_data    =  array(
                                  'd_id'=>$dealer_data[0]->d_id,
                                  'email_type_id'=>$emailtype_id,
                                  'title'=>$mail_subject,
                                  'message'=>$email_template['mail_message'],
                                  'sent_status'=>$email_sent,
                                  'transaction_date'=>Carbon::now(),
                                  'tosend_date'=>""

                                );
      $trans_id        =   transaction_historymodel::dealer_notification_insert($trans_data);
//Transaction history management - dealer notification(For REnew plan)
      foreach ($emailRenewTemplate as $row) 
            {
                $mail_subject  =  $row->email_subject;
                $mail_message  =  $row->email_message;
                $mail_params   =  $row->email_parameters; 
            }

            $url               =    url("mailsend/".encrypt(Session::get('ses_id')));

            $data              =    array(
                                          '0'=>$url,
                                          '1'=>$dealer_data[0]->dealer_name,
                                          '2'=>$dealer_data[0]->d_email,
                                          '3'=> "",
                                          '4'=>"",
                                          '5'=>$plan_data[0]->plan_type_name,
                                          '6'=>$plan_data[0]->frequency_desc,
                                          '7'=>$bill_enddate,
                                          '8'=>$max_user
                                           );

            $email_template    =     emailmodel::emailContentConstruct($mail_subject,$mail_message,$mail_params,$data);
            
            $trans_futureentry      =  array(
                                  'd_id'=>$dealer_data[0]->d_id,
                                  'email_type_id'=>"",
                                  'title'=>$mail_subject,
                                  'message'=>$email_template['mail_message'],
                                  'sent_status'=>"New",
                                  'transaction_date'=>"",
                                  'tosend_date'=>$bill_enddate->subDays(Config::get('common.before_bill_enddate'))
                                  );
      
      
      $trans_futureid  =   transaction_historymodel::dealer_notification_insert($trans_futureentry);

           
    //ChangePlan SMS Sending to mobile
    $smsdata                   = array($dealer_data[0]->dealer_name,
                                       $plan_data[0]->plan_type_name
                                      );

    $changeplan_sms_id  =    Config::get('common.changeplan_sms_id');
    $sms_template_data  =    smsmodel::get_sms_templates($changeplan_sms_id);
    $sms_template       =    smsmodel::smsContentConstruct($sms_template_data[0]->sms_subject,$sms_template_data[0]->sms_message,$sms_template_data[0]->sms_parameters,$smsdata);
    
    $sms_data           =    array('sms_template_data'=>$sms_template,
                                    'phone'=>$dealer_data[0]->d_mobile);
    
    $sms_sent           =    smsmodel::sendsmsarray($sms_data);

}

//Schecduler checking function
public function schedulercheck()
{
  //dealerTransactionHistoryManagement::where('t_id','752')->update(array('update_status'=>'READ'));

  //Plan Exp
  /*$result = dealerTransactionHistoryManagement::schedulerPlanExp();
  echo "Successfully updated";*/

  //Plan Renew
  $result = dealerTransactionHistoryManagement::schedulerPlanRenew();
  echo "Successfully renew updated...";

  //plan expiring for autorenew = yes
  /*$result = dealerTransactionHistoryManagement::schedulerPlanExpTime();
  dd($result);*/

  //plan already exp
  /*$result = dealerTransactionHistoryManagement::schedulerPlanAlreadyExp();
  echo "successfully updated";*/
  


        
}

}


