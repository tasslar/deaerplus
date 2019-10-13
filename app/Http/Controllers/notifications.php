<?php

/*
  Module Name : Notifications
  Created By  : A.Ahila
  Use of this module is to show System and dealer notifications
 */

namespace App\Http\Controllers;
use Session;
use Redirect;
use Request;
use App\model\dealermodel;
use App\model\commonmodel;
use App\model\alertmodel;
use App\model\transaction_historymodel;
use App\model\emailmodel;
use App\model\notificationsmodel;
use App\Exceptions\CustomException;


class notifications extends Controller 
{

public function __construct()
{    
  $this->active_menu_name         = 'manage_menu';
  $this->side_bar_active      ='';      
  $this->middleware(function ($request, $next) 
    {
      $this->id                   = Session::get('ses_id');
      $this->p_id                 = dealermodel::parent_id($this->id);
      $this->login_authecation    = Session()
                                      ->has( 'ses_dealername' ) ? session()
                                      ->get( 'ses_dealername' ) :  Redirect::to('login')
                                      ->send();
      $this->header_data          =  commonmodel::commonheaderdata();
      $this->header_data['title'] =  '';
      $this->header_data['p_id']  =   $this->p_id;
      return $next($request);
      }
    );                  
}

public function sysNotificationShow()
{
$header_data           =  $this->header_data;
$header_data['title']  =  'System Notification';
$compact_array         = array(
                            'active_menu_name'=>$this->active_menu_name,
                            'side_bar_active'=>$this->side_bar_active,
                          ); 

try
{
    
    $updateStatus   = notificationsmodel::updateSysNotificationStatus(Session::get('dealer_schema_name'));
    $sysnotify_data = notificationsmodel::fetchAllNotifications(Session::get('dealer_schema_name'),Session::get('ses_id'));

    foreach($sysnotify_data as $key)
    {
      $key->encryptedkey = encrypt($key->id);
      $key->stripemsg    = strip_tags($key->message);
    }
}
catch(Exception $e)
{
   throw new CustomException($e->getMessage());
}
return view('notification_system',compact('header_data','compact_array','sysnotify_data'));
}


/*public function showSysTemplate($transid)
{
 $id       = decrypt($transid);
 
    try
    {
      
        $updateStatus= notificationsmodel::updateSysNotificationStatus(Session::get('dealer_schema_name'),$id);
        //$sysTemp  = notificationsmodel::fetchTemplate(Session::get('dealer_schema_name'),$id);
        $data     = array(
                    'mail_message'=>$sysTemp[0]->message
                    );
    }
    catch(Exception $e)
    {
      throw new CustomException($e->getMessage());
    }
   return redirect('notification_system');
  //return view('email_template',compact('data'));

}
*/
}//class closed

