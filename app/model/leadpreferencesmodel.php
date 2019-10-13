<?php
/*
	Module Name : preferencemodel 
	Created By  : Naveen 31-03-2017 Version 1.0
	This module handle with Preference
*/

namespace App\model;
use DB;
use Config;
use Illuminate\Database\Eloquent\Model;
use App\model\schemaconnection;

class leadpreferencesmodel extends Model
{
	public static function lead_preferences_insert($dealer_schemaname,$data)
	{
		commonmodel::doschemachange($dealer_schemaname);
		$insertGetId	= 	schemaconnection::dmsmysqlconnection()
								->table('lead_preferences')
								->insertGetId($data);
		return $insertGetId;
	}

	public static function lead_preferences_fetch($dealer_schemaname,$wherecondition)
	{
		commonmodel::doschemachange($dealer_schemaname);
		$insertGetId	= 	schemaconnection::dmsmysqlconnection()
								->table('lead_preferences')
								->where($wherecondition)
								->get(); 
		return $insertGetId;
	}

	public static function lead_preferences_delete($dealer_schemaname,$wherecondition){
		commonmodel::doschemachange($dealer_schemaname);
        $get_fetch_table_details = schemaconnection::dmsmysqlconnection()
                                            ->table('lead_preferences')
                                            ->where($wherecondition)
                                            ->delete();       
        return $get_fetch_table_details;
    }
}