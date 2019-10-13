<?php

namespace App\model;
use Illuminate\Database\Eloquent\Model;
use App\model\commonmodel;
use App\model\schemaconnection;
use Config;
use Carbon\Carbon;
use DB;

class dealerTransactionHistoryManagement extends Model 
{

public $connection = 'mastermysql';
public $table = 'dealer_transaction_history_management';

public static function schedulerPlanExp()
{

$today = date('Y-m-d',time());
$dealerRec = schemaconnection::masterconnection()
            ->table('dealer_billing_details_copy')
            ->whereRaw("cast(subscription_end_date as date) = '$today'")
            ->whereIn('current_subscription',[0,1])
            ->get(); 

foreach ($dealerRec as $key) 
{
  $x = $key->dealer_id;
  $checkFuturePlan   =   subscriptionmodel::fetch_future_billing($x,5);
  $dealer_data   =   dealermodel::dealerfetch($x);
  $dealer_email  =   $dealer_data[0]->d_email;
  $dealer_plan   =   subscriptionmodel::fetch_dealer_billing($x,1);
  $planData      =   subscriptionmodel::fetch_plan_by_subid($dealer_plan->subscription_plan_id);

  if(count($checkFuturePlan))
   {

    //echo "<br>"."future"."<br>";
    
   } 
   else
   {

    //echo "no future entry"."<br>";


     if(($planData[0]->auto_renew == "Y")||($planData[0]->unit_cost == 0) )
     {
         
         $PlanBillDate=  billingmodel::billing_enddate(Carbon::now(),$planData[0]->frequency_id);
         $master_billdata = array(
                    'dealer_id'  =>    $x,
                    'invoice_id' =>    "",
                    'subscription_plan_id'=>$dealer_plan->subscription_plan_id,
                    'payment_date'  =>  Carbon::now(),
                    'billing_date'  =>  Carbon::now(),
                    'payment'       =>  "",
                    'max_users'     =>  $dealer_plan->max_users,
                    'subscription_start_date'  =>  $PlanBillDate['current'],
                    'subscription_end_date'    =>  $PlanBillDate['exp'],
                    'coupon_amount'   =>     "",
                    'payable_amount'  =>     "",
                    'bill_status'     =>     "",
                    'current_subscription'  =>  config::get('common.cur_sub_key'),
                    'description' =>  "Renewed Plan Into ".$dealer_plan->subscription_plan_id,
                    'period'   =>  "",
                    'carry_forward_users'   =>  "",
                    'carry_forward_amount'  =>  "",
                    'total_amount'     =>    "",
                  );

           $master_bill_id  = subscriptionmodel::master_dealer_billing_store($master_billdata);
       }
       else if($planData[0]->auto_renew == "N") 
       {
          if($planData[0]->downgrade_id !="") 
          {
      
              $toDowngradePlan = $planData[0]->downgrade_id;
              $downplanData    =   subscriptionmodel::fetch_plan_by_subid($toDowngradePlan);
              $downPlanBillDate=  billingmodel::billing_enddate(Carbon::now(),$downplanData[0]->frequency_id);
              $master_billdata = array(
                            'dealer_id'  =>    $x,
                            'invoice_id' =>    "",
                            'subscription_plan_id'=>$toDowngradePlan,
                            'payment_date'  =>  Carbon::now(),
                            'billing_date'  =>  Carbon::now(),
                            'payment'       =>  "",
                            'max_users'     =>  $dealer_plan->max_users,
                            'subscription_start_date'  =>  $downPlanBillDate['current'],
                            'subscription_end_date'    =>  $downPlanBillDate['exp'],
                            'coupon_amount'   =>     "",
                            'payable_amount'  =>     "",
                            'bill_status'     =>     "",
                            'current_subscription'  =>  config::get('common.cur_sub_key'),
                            'description' =>  "Renewed Plan Into Downgrade Id".$toDowngradePlan,
                            'period'   =>  "",
                            'carry_forward_users'   =>  "",
                            'carry_forward_amount'  =>  "",
                            'total_amount'     =>    "",
                          );

               $master_bill_id  = subscriptionmodel::master_dealer_billing_store($master_billdata);
               $email_template_data   =    emailmodel::get_email_templates('19');
               $dealer_downplan   =   subscriptionmodel::fetch_dealer_billing($x,1);

              $downplanData      =   subscriptionmodel::fetch_plan_by_subid($dealer_downplan->subscription_plan_id);
                foreach ($email_template_data as $row) 
                 {
                    $mail_subject  =  $row->email_subject;
                    $mail_message  =  $row->email_message;
                    $mail_params   =  $row->email_parameters; 
                }

              $url               =    url("mailsend/".encrypt($x));

              $data              =    array(
                                        '0'=>$url,
                                        '1'=>$dealer_data[0]->dealer_name,
                                        '2'=>$dealer_data[0]->d_email,
                                        '3'=> "",
                                        '4'=>"",
                                        '5'=>$downplanData[0]->plan_type_name,
                                        '6'=>$downplanData[0]->frequency_desc,
                                        '7'=>$dealer_downplan->subscription_end_date,
                                        '8'=>$dealer_downplan->max_users,
                                        '9'=>$dealer_plan->subscription_end_date,
                                      );

            $emailDownTemplate =  emailmodel::emailContentConstruct($mail_subject,$mail_message,$mail_params,$data);
            $email_sent        =  emailmodel::email_sending($dealer_data[0]->d_email,$emailDownTemplate);


        } //if downgrade
        else
        {
           /* no downgrade id , send mail & curr sub=0*/
          $objNoDowngrade = new dealerTransactionHistoryManagement();
          $updateRec=subscriptionmodel::dealer_subscription_update($x);
          $res = $objRenew->sendingEmailFunction($x,17);
        }
     
      } //elseif autorenew=no
   }//if
}

}//schedulerPlanExp fun end


//Plan Already Expired
public static function schedulerPlanAlreadyExp()
{
    $obj = new dealerTransactionHistoryManagement();
    $today = date('Y-m-d',time());
    $dealerRec = schemaconnection::masterconnection()
                      ->table('dealer_billing_details_copy')
                      ->whereRaw("cast(subscription_end_date as date) < '$today'")
                      ->where('current_subscription',1)
                      ->get(); 

   foreach ($dealerRec as $key) 
   {
        $res = $obj->sendingEmailFunction($key->dealer_id,18);

    }
}


//Scheduler Renew Plan
public static function schedulerPlanRenew()
{
      $objRenew = new dealerTransactionHistoryManagement();
      $today = date('Y-m-d',time()+5*86400);
      $dealerRec = schemaconnection::masterconnection()
                            ->table('dealer_billing_details_copy')
                            ->whereRaw("cast(subscription_end_date as date) = '$today'")
                            ->get(); 
      foreach ($dealerRec as $key) 
      {
        $res = $objRenew->sendingEmailFunction($key->dealer_id,17);
      }
}


public function sendingEmailFunction($dealerId,$emailId)
{
  $x = $dealerId;
  $dealer_data   =   dealermodel::dealerfetch($x);
  $dealer_email  =   $dealer_data[0]->d_email;
  $dealer_plan   =   subscriptionmodel::fetch_dealer_billing($x,1);
  $planData      =   subscriptionmodel::fetch_plan_by_subid($dealer_plan->subscription_plan_id);
  $email_template_data   =    emailmodel::get_email_templates($emailId);
        foreach ($email_template_data as $row) 
        {
            $mail_subject  =  $row->email_subject;
            $mail_message  =  $row->email_message;
            $mail_params   =  $row->email_parameters; 
        }

        $url               =    url("mailsend/".encrypt($x));
        $data              =    array(
                                  '0'=>$url,
                                  '1'=>$dealer_data[0]->dealer_name,
                                  '2'=>$dealer_data[0]->d_email,
                                  '3'=> "",
                                  '4'=>"",
                                  '5'=>$planData[0]->plan_type_name,
                                  '6'=>$planData[0]->frequency_desc,
                                  '7'=>$dealer_plan->subscription_end_date,
                                  '8'=>$dealer_plan->max_users,
                                   );

    $email_template    =     emailmodel::emailContentConstruct($mail_subject,$mail_message,$mail_params,$data);
    
    $email_sent        =     emailmodel::email_sending($dealer_data[0]->d_email,$email_template);
}
}// class end

