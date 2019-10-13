<?php

/*
  Module Name : Alert
  Created By  : A.Ahila
  Use of this module is to show alert details

 */

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use Config;
use App\model\commonmodel;
use DB;
use App\model\schemaconnection;

class alertmodel extends Model {

    public $timestamps = false;
    protected $table;

    public function __construct() {
        $this->table = "dealer_alert_history";
    }

    public static function fetchAllAlert($id) {
        $alertData = schemaconnection::masterconnection()
                ->table('dealer_alert_history')
                ->where('alert_user_id', $id)
                ->orderBy('alertid', 'desc')
                ->get();

        return $alertData;
    }
	
	public static function delAlert($id)
	{
		$alt_rec = schemaconnection::masterconnection()
						->table('dealer_alert_history')
						->where('alertid',$id)
						->delete();
		return $alt_rec;
	}
	
    //To show on header 
    public static function fetchAlertNotifyList($schemaname, $id) {
        $dealerAlertGet = DB::table('dealer_alert_history')
                ->join('dealer_alerts_received', 'dealer_alert_history.alertid', '=', 'dealer_alerts_received.alert_id')
                ->where('dealer_alerts_received.alert_subscriber_dealer_id', '=', $id)
                ->get();
        $alert_title = array();
        $dealer_alert_data = array();
        foreach ($dealerAlertGet as $list) {

            $notify_title['alert_title'] = $list->alert_model . " " . $list->alert_variant;
            $notify_title['alert_type'] = $list->alert_type;
            $notify_title['alert_listingid'] = $list->alert_source_listing_id;
            array_push($dealer_alert_data, $notify_title);
        }

        return $dealer_alert_data;
    }

    public static function countReceivedAlert($id) {
        $dealerReceivedCount = DB::table('dealer_alert_history')
                ->join('dealer_alerts_received', 'dealer_alert_history.alertid', '=', 'dealer_alerts_received.alert_id')
                ->where('dealer_alerts_received.alert_subscriber_dealer_id', '=', $id)
                ->count();

        return $dealerReceivedCount;
    }

    public static function countAllAlert($id) {
        $alertCount = schemaconnection::masterconnection()
                ->table('dealer_alert_history')
                ->where('alert_user_id', $id)
                ->count();

        return $alertCount;
    }

    public static function getAlertDetails($alertid)
    {
        return schemaconnection::masterconnection()
                ->table('dealer_alert_history')
                ->where('alertid', $alertid)
                ->get();
    }

    public static function getSchemaAlert($alertType,$listId,$userId)
    {
        return schemaconnection::dmsmysqlconnection()
                ->table('dealer_alert_history')
                ->where('alert_type', $alertType)
                ->where('alert_listingid',$listId)
                ->where('alert_user_id',$userId)
                ->get();
    }

    public static function deleteSchemaAlert($alertType,$listId,$userId)
    {
        return schemaconnection::dmsmysqlconnection()
                ->table('dealer_alert_history')
                ->where('alert_type', $alertType)
                ->where('alert_listingid',$listId)
                ->where('alert_user_id',$userId)
                ->delete();
    }

    public static function updateAlertSchemaStatus($alertType,$listId,$userId,$val,$type) 
    {
        $val = ($val == 0) ? 1 : 0;

        if ($type == "status_one") {
            $field = "alert_status";
        } else if ($type == "status_two") {
            $field = "alert_email_status";
        } else if ($type == "status_three") {
            $field = "alert_sms_status";
        }

        $alt_id = schemaconnection::dmsmysqlconnection()
                ->table('dealer_alert_history')
                ->where('alert_type', $alertType)
                ->where('alert_listingid',$listId)
                ->where('alert_user_id',$userId)
                ->update([$field => $val]);
        return $alt_id;
    }

    public static function updateAlertStatus($id, $val, $type) {
        $val = ($val == 0) ? 1 : 0;

        if ($type == "status_one") {
            $field = "alert_status";
        } else if ($type == "status_two") {
            $field = "alert_email_status";
        } else if ($type == "status_three") {
            $field = "alert_sms_status";
        }

        $alt_id = schemaconnection::masterconnection()
                ->table('dealer_alert_history')
                ->where('alertid', $id)
                ->update([$field => $val]);
        return $alt_id;
    }

    public static function deleteAlert($id) {
        $alt_rec = schemaconnection::masterconnection()
                ->table('dealer_alert_history')
                ->where('alertid', $id)
                ->delete();
        return $alt_rec;
    }

    //get alert id
    public static function dofetchAlertid($id) {
        $alertData = schemaconnection::masterconnection()
                ->table('dealer_alert_history')
                ->where('alertid', $id)
                ->orderBy('alertid', 'desc')
                ->get();

        return $alertData;
    }

    //get alert status
    public static function dofetchAlertstatus($where, $field) {
        $alertData = schemaconnection::masterconnection()
                ->table('dealer_alert_history')
                ->where($where)
                ->pluck($field);

        return $alertData;
    }

    //get alert status
    public static function dofetchAlertstatusSchema($schemaname, $where, $field) {
        commonmodel::doschemachange($schemaname);
        $alertData = schemaconnection::dmsmysqlconnection()
                ->table('dealer_alert_history')
                ->select(DB::raw($field))
                ->where($where)
                ->first();
        return $alertData;
    }

    //update in alert table
    public static function doUpdateAlertstatus($id, $updaterecords) {
        $dealer_detail_id = schemaconnection::masterconnection()
                ->table('dealer_alert_history')
                ->where('alertid', $id)
                ->update($updaterecords);
        return $dealer_detail_id;
    }

    //update in schema alert table
    public static function doUpdateAlertstatusSchema($schemaname, $where, $updaterecords) {
        commonmodel::doschemachange($schemaname);
        $dealer_detail_id = schemaconnection::dmsmysqlconnection()
                ->table('dealer_alert_history')
                ->where($where)
                ->update($updaterecords);
        return $dealer_detail_id;
    }

    //delete alert in schema
    public static function doAlertdeleteschema($schemaname, $where) {
        commonmodel::doschemachange($schemaname);
        $dealer_detail_id = schemaconnection::dmsmysqlconnection()
                ->table('dealer_alert_history')
                ->where($where)
                ->delete();
        return $dealer_detail_id;
    }

    //delete alert in schema
    public static function doAlertreportschema($schemaname, $param) {
        commonmodel::doschemachange($schemaname);
        $dealer_detail_id = schemaconnection::dmsmysqlconnection()
                ->table('dealer_alert_history')
                ->select($param)
                ->get();
        return $dealer_detail_id;
    }

}
