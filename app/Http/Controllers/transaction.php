<?php
/*
  Module Name : transaction 
  Created By  : Ahila
  Use of this module is manage dealer and user subscriptions

  with scindiya changes code
*/
namespace App\Http\Controllers;

use Session;
use Redirect;
use Config;
use Request;
use Carbon\Carbon;
use App\model\usersmodel;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\model\notificationsmodel;
use App\model\subscriptionmodel;
use App\model\billingmodel;
use App\model\commonmodel;
use App\model\dealermodel;
use App\model\creditmodel;
use App\Exceptions\CustomException;




class transaction extends Controller
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
      $this->side_bar_active        ='transaction';      
      $this->middleware(function ($request, $next) 
        {
          $this->id                     = session::get('ses_id');       $this->p_id                   = dealermodel::parent_id($this->id);
          $this->login_authecation    = session()->has( 'ses_dealername' ) ? session()->get( 'ses_dealername' ) :  Redirect::to('login')->send();
          $this->header_data      = commonmodel::commonheaderdata();
          $this->header_data['title']='Transaction';
          $this->header_data['p_id']   =$this->p_id;
          return $next($request);
          }
        ); 
    }

public function managetransaction()
{
  $header_data          =   $this->header_data;
  $header_data['title'] =   'Transaction';
  $compact_array        =    array(
                                 'active_menu_name'=>$this->active_menu_name,                  
                                 'side_bar_active'=>$this->side_bar_active,
                              ); 
   $id                   =   Session::get('ses_id');
   $ses_dealer_name      =   Session::get('ses_dealername');
   $dealer_schema_name   =   Session::get('dealer_schema_name');
   try
   {
    $curCredit           =    creditmodel::fetchCredit(Session::get('ses_id'));
   

   $cur_bill_data        = subscriptionmodel::fetch_dealer_billing($id,config::get('common.cur_sub_key'));
   
   $current_plan         = subscriptionmodel::fetch_plandata($cur_bill_data->subscription_plan_id);
   
   $cur_detail           = array(
                            'cur_startdate'=>$cur_bill_data->subscription_start_date,
                            'cur_enddate'=>$cur_bill_data->subscription_end_date,
                            'cur_credit'=>$curCredit[0]->credit_balance,
                            );  
   
    
   $fetch_dealerdata     = subscriptionmodel::fetch_dealer_allbilling($id);

   foreach($fetch_dealerdata as $key)
   {

    $key->encryptedkey = encrypt($key->history_id);
    $fetch_plan        = subscriptionmodel::fetch_plandata($key->subscription_plan_id);
    $key->planname     = $fetch_plan['plan_type_name'];
   }
  }
  catch(Exception $e)
  {
    throw new CustomException($e->getMessage());
  }

 return view('manage_transaction',compact('cur_detail','current_plan','fetch_dealerdata','compact_array','header_data'));
}


}