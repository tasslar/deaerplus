<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use App\model\commonmodel;
use Config;
use DB;
use Session;
use App\model\schemaconnection;

class transaction_historymodel extends Model
{
	
	public $timestamps      =    false;
    protected $connection   =   'mastermysql';
    protected $collection   =   'dealer_transaction_history_management';
  
    public static function dealer_notification_insert($trans_data)
    {
         $trans_id = schemaconnection::masterconnection()
                                ->table('dealer_transaction_history_management')
                                ->insertGetId($trans_data); 
        return $trans_id; 
        
    }

    public static function fetchSysNotification($id)
    {
    	$trans_data = schemaconnection::masterconnection()
                                ->table('dealer_transaction_history_management')
                                ->where('d_id',$id)
                                ->where('email_type_id','<>',0)
                                ->orderBy('t_id', 'desc')
                                ->take(4)
                                ->get();
        $sys_title=array();
        $sys_notify_data=array();
        foreach($trans_data as $list)
        {
            $sys_title['title']=$list->title;
            $sys_title['tid']=encrypt($list->t_id);
            array_push($sys_notify_data, $sys_title);
                   
        }

        
        return $sys_notify_data; 
    }

public static function fetchNotificationCount($id)
{
	$notifi_count = schemaconnection::masterconnection()
                                ->table('dealer_transaction_history_management')
                                ->where('d_id',$id)
                                ->where('email_type_id','<>',0)
                                ->count();
    return $notifi_count;
        
}

public static function fetchAllNotifications($id)
{
    $notifi_list  = schemaconnection::masterconnection()
                                ->table('dealer_transaction_history_management')
                                ->where('d_id',$id)
                                ->where('email_type_id','<>',0)
                                ->orderBy('t_id', 'desc')
                                ->get();

    return $notifi_list;


}

/*Fetch email temmplate for sid
*/
public static function fetchTemplate($id)
{
    $email_template  = schemaconnection::masterconnection()
                                ->table('dealer_transaction_history_management')
                                ->where('t_id',$id)
                                ->where('email_type_id','<>',0)
                                ->get();

    return $email_template;

}   
}
