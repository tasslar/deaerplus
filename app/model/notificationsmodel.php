<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use App\model\commonmodel;
use Config;
use DB;
use Session;
use App\model\schemaconnection;

class notificationsmodel extends Model
{
	
	public $timestamps      =    false;
    //protected $table        =   'dms_dealer_system_notifications';

    
     /*Function Name get_notification_type
    * Created by Ahila 2-1-2016
    * Use of getting the system notification type 
    */
    public static function get_notification_type($notification_type_id){
            $notification_data=DB::table('master_notification_type')
                                ->select('notification_type_id','notification_type_name')
                                ->where('notification_type_id','=',$notification_type_id)
                                ->get();
            return $notification_data;
    }

     /*Function Name email_notification_count
    * Created by Ahila 2-1-2016
    * Use of this module is to Insert the System notification  
    */
    public static function notification_insert($dealer_schemaname,$notification_data)
    {
            
        $table = 'dms_dealer_system_notifications';
    	commonmodel::doschemachange($dealer_schemaname);
                   
    	    $dealer_notification = schemaconnection::dmsmysqlconnection()
                                                ->table($table)
                                                ->insertGetId($notification_data);		
    	   	return $dealer_notification; 
    }

     /*Function Name email_notification_count 
    * Created by Ahila 2-1-2016
    * Use of this module is to Count the System notification  
    */
    
    public static function email_notification_count($dealer_schemaname,$id)
    {
        
        commonmodel::doschemachange($dealer_schemaname);
        $email_value="email";
            
            $email_count=  schemaconnection::dmsmysqlconnection()
                           ->table('dms_dealer_system_notifications')
                           ->where('d_id','=',$id)
                           ->where('notification_type','=',$email_value)
                           ->count();
                         
            return $email_count; 
    }

//Function to get system notification count from schema table and show in header
public static function fetchNotificationCount($dealer_schemaname,$id)
{
    commonmodel::doschemachange($dealer_schemaname);
    $notifi_count = schemaconnection::dmsmysqlconnection()
                                ->table('dms_dealer_system_notifications')
                                ->where('d_id',$id)
                                ->where('status','=','1')
                                ->count();
    return $notifi_count;
        
}

public static function fetchSysNotification($dealer_schemaname,$id)
{
        commonmodel::doschemachange($dealer_schemaname);
        $trans_data = schemaconnection::dmsmysqlconnection()
                                ->table('dms_dealer_system_notifications')
                                ->where('d_id',$id)
                                ->where('status','=','1')
                                ->orderBy('id', 'desc')
                                ->take(5)
                                ->get();
        
        $sys_title=array();
        $sys_notify_data=array();
        foreach($trans_data as $list)
        {
            $sys_title['title']=$list->title;
            $sys_title['tid']=encrypt($list->id);
            $sys_title['created_at']=$list->created_at;
            $sys_title['message']=strip_tags($list->message);
            array_push($sys_notify_data, $sys_title);
                   
        }

        
        return $sys_notify_data; 
    }

public static function fetchAllNotifications($dealer_schemaname,$id)
{
    commonmodel::doschemachange($dealer_schemaname);
    $notifi_list  = schemaconnection::dmsmysqlconnection()
                                ->table('dms_dealer_system_notifications')
                                ->where('d_id',$id)
                                ->orderBy('id','desc')
                                ->get();

    return $notifi_list;


}

/*Fetch email temmplate for dealer id
*/
public static function fetchTemplate($dealer_schemaname,$id)
{
    commonmodel::doschemachange($dealer_schemaname);
    $email_template  = schemaconnection::dmsmysqlconnection()
                                ->table('dms_dealer_system_notifications')
                                ->where('id',$id)
                                ->get();

    return $email_template;

}   

public static function updateSysNotificationStatus($dealer_schemaname)
{
    commonmodel::doschemachange($dealer_schemaname);
    $updateStatus  = schemaconnection::dmsmysqlconnection()
                                ->table('dms_dealer_system_notifications')
                                ->update(['status' => '0']);

    return $updateStatus;
}
 
    /*Function Name get_notification_dealer_type
    * Created by Naveen Babu 5-1-2016
    * Use of getting the notification type from dealer_notification_type
    */
    public static function get_notification_dealer_type($notification_type_id){
            $notification_data=DB::table('dealer_notification_type')
                                ->select('notification_type_id','notification_type_name')
                                ->where('notification_type_id','=',$notification_type_id)
                                ->get();
            return $notification_data;
    }

    /*Function Name dealer_notification_insert
    * Created by Naveen Babu 5-1-2016
    * Use of Insert the value in dealer_system_notifications
    */
    public static function dealer_notification_insert($dealer_schemaname,$notification_data)
    {
            
        $table = 'dealer_system_notifications';
        Config::set('database.connections.dmsmysql2.database',$dealer_schemaname);

        $dealer_notification = DB::connection('dmsmysql2')
                                            ->table($table)
                                            ->insertGetId($notification_data);      
        return $dealer_notification; 
    }

    /*Function Name dealer_notification_count
    * Created by Naveen Babu 5-1-2016
    * Use of Count of notifications
    */
    public static function dealer_notification_count($dealer_schemaname,$id)
    {
        commonmodel::doschemachange($dealer_schemaname);            
        $notification_count=  schemaconnection::dmsmysqlconnection()
                                               ->table('dealer_system_notifications')
                                               ->where('d_id','=',$id)
                                               ->count();
                     
        return $notification_count; 
    }

    public static function getDealerNotification($dealer_schemaname,$id)
    {
        commonmodel::doschemachange($dealer_schemaname);            
        $dealer_notification_get=  schemaconnection::dmsmysqlconnection()
                                               ->table('dealer_system_notifications')
                                               ->where('d_id','=',$id)
                                                ->orderBy('id', 'desc')
                                                ->take(5)
                                               ->get();
        
       $notify_title=array();
       $dealer_notify_data=array();
        foreach($dealer_notification_get as $list)
        {
            
            $notify_title['notification_type_id']=$list->notification_type_id;
            $notify_title['contact_transactioncode']=$list->contact_transactioncode;
            $notify_title['title']=$list->title;
            $notify_title['notification_type']=$list->notification_type;
            $notify_title['message']=$list->message;
            $notify_title['created_at']=$list->created_at;

            array_push($dealer_notify_data, $notify_title);
                   
        }  
        
        return $dealer_notify_data;          
         
    }

    //update dealer notification status for header
    public static function updateDealerNotification($id,$dealer_schemaname,$contact_transactioncode)
    {
        commonmodel::doschemachange($dealer_schemaname);
        $updateStatus  = schemaconnection::dmsmysqlconnection()
                                ->table('dealer_system_notifications')
                                ->where('contact_transactioncode',$contact_transactioncode)
                                ->update(['d_id' => '0','contact_transactioncode' => '0']);

    return $updateStatus;
    }
    
}
