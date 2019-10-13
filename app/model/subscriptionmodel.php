<?php
/*
  Module Name : Subscriptionmodel
  Created By  : Ahila , version 1.0
  Use of this module is maintain related to billing.

  changes scindia

*/
namespace App\model;

use Illuminate\Database\Eloquent\Model;
use Config;
use DB;
use App\model\schemaconnection;
use App\Exceptions\CustomException;

class subscriptionmodel extends Model
{
  
public $timestamps = false;
protected $table = 'master_subscription_plans';
public $plan_data;
public $PAST_SUBSCRIPTION=0;


public static function get_all_subscr_plans()
{
  
   $subscr_plan_data = subscriptionmodel::whereNotIn('enabled', 'N')
                ->get();

  return $subscr_plan_data;  

}

public static function get_subscr_plan_by_id($sub_id)
{
 $subscr_plan_data = schemaconnection::connection('mastermysql')
             ->table($table)
             ->where('subscription_plan_id',$sub_id)
             ->get();
  //$subscr_plan_data->plan_data=Plan::get_plan_by_id($subscr_plan_data['plan_type_id']);
  return $subscr_plan_data;  

}


public static function master_dealer_billing_store($dealer_billingdata,$subval=0,$check="")
{
  //print_r($dealer_billingdata);
  if($subval != '5' && $check != "true")
  {
   $update_dealer = subscriptionmodel::dealer_subscription_update($dealer_billingdata['dealer_id']);
  }
  

  $dealer_billid = schemaconnection::masterconnection()
                    ->table('dealer_billing_details')
                    ->insertGetId($dealer_billingdata); 

  return $dealer_billid;  

}

public static function dealer_futurebilling_store($dealer_billingdata)
{
  //print_r($dealer_billingdata);
  $dealer_billid = schemaconnection::masterconnection()
                    ->table('dealer_billing_details')
                    ->insertGetId($dealer_billingdata); 

  return $dealer_billid;  

}
public static function fetch_future_billing($id,$future_sub)
{
    $billing_data = schemaconnection::masterconnection()
                    ->table('dealer_billing_details')
                    ->where('dealer_id', '=', $id)
                    ->where('current_subscription',5)
                    ->orderBy('history_id', 'desc')
                    ->get();
      return $billing_data;
    
}
public static function fetch_dealer_billing($id,$cur_sub)
{
  
    $billing_data = schemaconnection::masterconnection()
                    ->table('dealer_billing_details')
                    ->where('dealer_id', '=', $id)
                    ->where('current_subscription',$cur_sub)
                    ->orderBy('history_id', 'desc')
                    ->first();
    if(!count($billing_data))
    {
      $billing_data = schemaconnection::masterconnection()
                    ->table('dealer_billing_details')
                    ->where('dealer_id', '=', $id)
                    ->where('current_subscription',0)
                    ->orderBy('history_id', 'desc')
                    ->first();
      
    }
    
     return $billing_data;
}
public static function select_user_list($id,$cur_sub)
{
  $billing_data = schemaconnection::masterconnection()
                    ->table('dealer_billing_details')
                    ->where([
                          ['dealer_id', $id],
                          ['current_subscription',$cur_sub],
                          ])
                    ->first();
  return $billing_data;  
}

public static function fetch_dealer_allbilling($id)
{
  $paginatenolisting        = Config::get('common.paginatenolisting');
  
  $billing_data = schemaconnection::masterconnection()
                    ->table('dealer_billing_details')
                    ->where('dealer_id', $id)
                    ->orderBy('billing_date', 'desc')
                    ->paginate($paginatenolisting);
  return $billing_data;  
}

public static function fetch_history_record($history_id)
{
  $history_data = schemaconnection::masterconnection()
                    ->table('dealer_billing_details')
                    ->where('history_id', $history_id)
                    ->first();
  return $history_data;

}
public static function dealer_subscription_update($id)
{
  
        $updateid      =      schemaconnection::masterconnection()
                                  ->table('dealer_billing_details')
                                  ->where('dealer_id',$id)
                                  ->where('current_subscription','<>','5')
                                  ->where('current_subscription','=','1')
                                  ->update(['current_subscription'=>'0']);
      return $updateid;        
}


 
 public static function fetch_all_plan()
 {
  
    $plan_detail = DB::connection('mastermysql')
                    ->table('master_subscription_plans')
                    ->get();
        return $plan_detail;
  }
 public static function fetchExceptPlan()
 {
  $plan_names = DB::connection('mastermysql')
                               ->table('master_plans')
                               ->whereNotIn('plan_type_id', [4])
                               ->get();
  return $plan_names;
 }
 public static function fetch_plans_name()
    {
  
    $plan_detail = DB::connection('mastermysql')
                      ->table('master_plans')
                      ->get();
        return $plan_detail;
    }

 public static function fetch_plandata($sub_id)
 {
  
    $plan_detail = DB::connection('mastermysql')
             ->table('master_subscription_plans')
             ->where('subscription_plan_id',$sub_id)
             ->get();


    $plan_name   = DB::connection('mastermysql')
             ->table('master_plans')
             ->select('plan_type_name')
             ->where('plan_type_id',$plan_detail[0]->plan_type_id)
             ->get();

    $frequency_period = DB::connection('mastermysql')
             ->table('master_plan_frequency')
             ->select('frequency_name','frequency_desc','frequency_interval')
             ->where('frequency_id',$plan_detail[0]->frequency_id)
             ->get();

    $plan_data = array(
              'plan_type_name'=>$plan_name[0]->plan_type_name,
              'frequency_name'=>$frequency_period[0]->frequency_name,
              'freq_interval'=>$frequency_period[0]->frequency_interval,
              'freq_desc'=>$frequency_period[0]->frequency_desc,
              'plan_detail'=>$plan_detail
              );
    //echo $plan_data['plan_detail'][0]->total_cost;
    //echo $plan_data['plan_detail'][0]->apply_group_cost;

    return $plan_data;
}
public static function fetch_planlist_by_planid($plan_type_id)
 {
     
  $plan_details = DB::connection('mastermysql')
             ->table('subscription_plan_view')
             ->where(['plan_type_id'=>$plan_type_id,
       'display_after_login' => 'Y',
       'enabled' => 'Y'])
       ->get();
    return $plan_details;
}


public static function fetch_plan_by_subid($sub_id)
 {
     
  $plan_details = DB::connection('mastermysql')
             ->table('subscription_plan_view')
             ->where('subscription_plan_id',$sub_id)
       ->get();

    return $plan_details;
}
public static function fetch_plan_by_planid($plan_name,$freq_id,$freq_desc)
 {
     
  $plan_details = DB::connection('mastermysql')
             ->table('subscription_plan_view')
             ->where(
              ['plan_type_name' => $plan_name,
              'frequency_desc'=> $freq_desc])
              ->get();
    
    
    return $plan_details;
}

public static function fetch_feature()
{
  $d_planlist = DB::connection('mastermysql')
                    ->table('master_plans')
                    ->whereNotIn('plan_type_id', [4])
                    ->get();
  foreach ($d_planlist as $key => $value)
        {

            $plan_list=$value->plan_type_id;
            $plan_name=$value->plan_type_name;

             $fre=DB::table('master_plan_feature_type')
                   ->select('master_plan_features.feature_id','master_plan_feature_type.feature_desc','master_plan_features.feature_allowed','master_plan_features.plan_feature_desc','master_plan_features.plan_type_id')
                   ->join('master_plan_features','master_plan_features.feature_id','=','master_plan_feature_type.feature_id')
                   ->where(['plan_type_id' => $plan_list, 'master_plan_feature_type.enabled'=>'Y'])
                   ->get();

           $feature_list[$plan_name]=array();

           foreach($fre as $key)
           {
              $data['plan_type_id']=$key->plan_type_id;
              $data['feature_id']=$key->feature_id;
              $data['feature_desc']=$key->feature_desc;
              $data['feature_allowed']=$key->feature_allowed;
              $data['plan_feature_desc']=$key->plan_feature_desc;
              array_push($feature_list[$plan_name], $data);
           }

        }

       return $feature_list;
}

public static function fetch_freqid($freq_int,$freq_desc)
{
  $fre_id=DB::connection('mastermysql')
             ->table('master_plan_frequency')
             ->select('frequency_id')
             ->where([
              ['frequency_interval', '=', $freq_int],
              ['frequency_desc', '=', $freq_desc],
              ])->get();
  
      
   return $fre_id;

}
 public static function fetch_subid($plan_id,$fre_id)
 {
    $sub_id=DB::connection('mastermysql')
             ->table('master_subscription_plans')
             ->select('subscription_plan_id')
             ->where([
              ['plan_type_id', '=', $plan_id],
              ['frequency_id', '=', $fre_id],
              ])->get();
          
   return $sub_id;
 }

public static function updateMasterDealerBilling($updateData)
{
     $updateBillId      =      schemaconnection::masterconnection()
                                  ->table('dealer_billing_details')
                                  ->where('history_id',$updateData['history_id'])
                                  ->update($updateData);
      return $updateBillId;  
}
public static function fetch_plan($plan_id,$frequency_id)
{
    $plan_data    =      DB::table('master_subscription_plans')
                               ->where('plan_type_id',$plan_id)
                               ->where('frequency_id',$frequency_id)
                               ->get();
    return $plan_data;
}

}
