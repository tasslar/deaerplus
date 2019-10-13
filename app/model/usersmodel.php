<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use Config;
use DB;
use Session;

/**
* 
*/
class usersmodel extends Model
{
	
	public static function user_table()
	{
		$id = session::get('ses_id');			
		$fetchupdate = DB::connection('mastermysql')->table('dms_dealers')->where('d_id',$id)->get();
		$connection = $fetchupdate[0]->dealer_schema_name;		
		Config::set('database.connections.dmsmysql.database', $connection);
		$table = 'user_account';
		$fetch_user = DB::connection('dmsmysql')->table($table);		
		return $fetch_user;
	}
	public static function dms_dealers()
	{
		$dms_dealers = DB::connection('mastermysql')->table('dms_dealers');
		return $dms_dealers;
	}
	public static function primary_user()
	{
		$id = session::get('ses_id');			
		$fetchupdate = DB::connection('mastermysql')->table('dms_dealers')->where('d_id',$id)->get();
		$connection = $fetchupdate[0]->dealer_schema_name;		
		Config::set('database.connections.dmsmysql.database', $connection);
		$table = 'user_account';
		$fetch_user = DB::connection('dmsmysql')->table($table);		
		return $fetch_user;	
	}
	public static function select_all_user($dealer_schemaname,$tablename)
    {
        $paginatenolisting        = Config::get('common.paginatenolisting');
        commonmodel::doschemachange($dealer_schemaname);
        $select_user = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)->get();
        return $select_user;    
    }
    public static function useremail_id($email)
    {
        return schemaconnection::masterconnection()
                    ->table('dms_dealers')
                    ->where('d_email',$email)
                    ->first();
    }
    public static function user_type_count($dealer_schemaname,$tablename,$key)
    {
        commonmodel::doschemachange($dealer_schemaname);
        $select_user = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)->where('user_role',$key)->count();      
        return $select_user;    
    }
    public static function user_all_count($dealer_schemaname,$tablename)
    {
        commonmodel::doschemachange($dealer_schemaname);
        $select_user = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)->count();      
        return $select_user;    
    }
    public static function user_type_select($dealer_schemaname,$tablename,$key)
    {
        commonmodel::doschemachange($dealer_schemaname);
        $select_user = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)->where('user_role',$key)->get();      
        return $select_user;    
    }
    public static function user_count($dealer_schemaname,$tablename)
    {
        commonmodel::doschemachange($dealer_schemaname);
        $user_count = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)->count();      
        return $user_count;    
    }
    public static function user_type()
	{
		$user_type = DB::connection('mastermysql')->table('master_user_role')->get();
		return $user_type;
	}

	public static function selectuser($schamea_name,$tablename,$userid)
	{
		commonmodel::doschemachange($schamea_name);
        $select_user = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)
                                            ->where('user_role',$userid)
                                            ->get();      
        return $select_user;
	}
    public static function user_id($schamea_name,$tablename,$userid)
    {
        commonmodel::doschemachange($schamea_name);
        $user_id = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)
                                            ->select('user_id')
                                            ->where('dealer_id',$userid)
                                            ->first();
        return $user_id;
    }
    public static function dealerParentCount($id)
    {
        $dealerCount = schemaconnection::masterconnection()
                          ->table('dms_dealers')
                          ->where('parent_id',$id)
                          ->count();

        return $dealerCount;
    }
    public static function passwordclear($id)
     {
        return  schemaconnection::masterconnection()
                                    ->table('dms_dealers')
                                    ->where('d_id',$id)
                                    ->update(['d_password' => "adminrestpassword"]);
     }
}