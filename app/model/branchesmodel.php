<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use Config;
use DB;
use Session;
use App\model\schemaconnection;

class branchesmodel extends Model
 {
	/*The Function masterInsertTable used to Insert of param details
    of Master table
    */    
    public static function masterFetchTableDetails($tablename,$wherecondition){

        $get_fetch_table_details = schemaconnection::masterconnection()
                                            ->table($tablename)
                                            ->where($wherecondition)
                                            ->get();       
        return $get_fetch_table_details;
    }
    
 	public static function branchId()
 	{
 		$id = session::get('ses_id');			
		return $id;					
 	}
 	public static function branch()
    {
    	$id = session::get('ses_id');			
		$fetchupdate = DB::connection('mastermysql')->table('dms_dealers')->where('d_id',$id)->get();
		$connection = $fetchupdate[0]->dealer_schema_name;		
		Config::set('database.connections.dmsmysql.database', $connection);
		$table = 'dms_dealer_branches';		
		$manage_branch = DB::connection('dmsmysql')->table($table);
		return $manage_branch;
    }
    public static function select_branch($dealer_schemaname,$tablename,$edit_id)
    {
        commonmodel::doschemachange($dealer_schemaname);
        $select_branch = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)
                                            ->where('branch_id',$edit_id)->first();      
        return $select_branch;    
    }
    public static function select_all_branch($dealer_schemaname,$tablename)
    {
        commonmodel::doschemachange($dealer_schemaname);
        $select_all_branch = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)->get();      
        return $select_all_branch;    
    }
    
    public static function selectallusers($dealer_schemaname,$searcheuser)
    {
        commonmodel::doschemachange($dealer_schemaname);
        $select_all_branch = schemaconnection::dmsmysqlconnection()
                                            ->table('user_account')
                                            ->where('user_name', 'LIKE', "%$searcheuser%")
                                            ->orwhere('user_moblie_no', 'LIKE', "%$searcheuser%")
                                            ->orwhere('user_email', 'LIKE', "%$searcheuser%")
                                            ->get();      
        return $select_all_branch;    
    }
    
    public static function selectalluserscolumn($dealer_schemaname,$where,$searcheuser)
    {
        commonmodel::doschemachange($dealer_schemaname);
        $select_all_branch = schemaconnection::dmsmysqlconnection()
                                            ->table('user_account')
                                            ->where($where)
                                            ->where('user_name', 'LIKE', "%$searcheuser%")
                                            ->orwhere('user_moblie_no', 'LIKE', "%$searcheuser%")
                                            ->orwhere('user_email', 'LIKE', "%$searcheuser%")
                                            ->get();      
        return $select_all_branch;    
    }
    
    public static function headquarter_count($dealer_schemaname,$tablename)
    {
         commonmodel::doschemachange($dealer_schemaname);
        $insertwithid = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)
                                            ->where('headquarter',1)->count();      
        return $insertwithid; 
    }
    public static function contact_type()
	{		
		$contact_type = DB::connection('mastermysql')->table('dealer_contact_type');
		return $contact_type;
	}
	 //INSERT RECORD FOR CURRENT SCHEMA
    public static function InsertTable($dealer_schemaname,$tablename,$insertrecord){

        commonmodel::doschemachange($dealer_schemaname);
        $insertwithid = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)
                                            ->insertGetId($insertrecord);      
        return $insertwithid; 
    }
    
    //UPDATE RECORD FOR CURRENT SCHEMA
    public static function UpdateTable($dealer_schemaname,$tablename,$updaterecord,$where){

        commonmodel::doschemachange($dealer_schemaname);
        $insertwithid = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)
                                            ->where($where)
                                            ->update($updaterecord);      
        return $insertwithid; 
    }
    //DELETE RECORD FOR CURRENT SCHEMA
    public static function DeleteTable($dealer_schemaname,$tablename,$where){

        commonmodel::doschemachange($dealer_schemaname);
        $insertwithid = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)
                                            ->where($where)
                                            ->delete();      
        return $insertwithid; 
    }
    
    //GET RECORD FOR CURRENT SCHEMA
	public static function branchlist($dealer_schemaname,$table,$where)
	{
		commonmodel::doschemachange($dealer_schemaname);
        $get_fetch_table_details = schemaconnection::dmsmysqlconnection()
                                            ->table($table)
                                            ->where($where)
                                            ->get();       
        return $get_fetch_table_details; 
	}
	//GET RECORD FOR CURRENT SCHEMA
	public static function searchallcolumnemployee($dealer_schemaname,$where,$search)
	{
		commonmodel::doschemachange($dealer_schemaname);
        $get_fetch_table_details = schemaconnection::dmsmysqlconnection()
                                            ->table('dealer_employee_management')
                                            ->where($where)
                                            ->where('employee_first_name', 'LIKE', "%$search%")
                                            ->orwhere('employee_moblie_no', 'LIKE', "%$search%")
                                            ->orwhere('employee_email_1', 'LIKE', "%$search%")
                                            ->orwhere('employee_email_2', 'LIKE', "%$search%")
                                            ->orwhere('employee_mailing_address', 'LIKE', "%$search%")
                                            ->get();
        return $get_fetch_table_details; 
	}
	
	//GET RECORD FOR CURRENT SCHEMA
	public static function searchallcolumncontact($dealer_schemaname,$where,$search)
	{
		commonmodel::doschemachange($dealer_schemaname);
        $get_fetch_table_details = schemaconnection::dmsmysqlconnection()
                                            ->table('dealer_contact_management')
                                            ->where($where)
                                            ->where('contact_first_name', 'LIKE', "%$search%")
                                            ->orwhere('contact_phone_1', 'LIKE', "%$search%")
                                            ->orwhere('contact_email_1', 'LIKE', "%$search%")
                                            ->orwhere('contact_email_2', 'LIKE', "%$search%")
                                            ->orwhere('contact_mailing_address', 'LIKE', "%$search%")
                                            ->get();
        return $get_fetch_table_details; 
	}
	/*The Function masterVariantDetail used to Update bidding details
    */
    public static function masterupdateDetail($table,$wherecondition,$settabledata)
    {
        $queryfetch = schemaconnection::masterconnection()
                    ->table($table)
                    ->where($wherecondition)
                    ->update($settabledata);  
		return $queryfetch;
    }
    
    public static function fetch_dealer_allbilling($id,$offset)
	{
		$billing_data = schemaconnection::masterconnection()
                    ->table('dealer_billing_details')
                    ->where('dealer_id', $id)
                    ->limit(10)
					->offset($offset)
                    ->orderBy('billing_date', 'desc')
                    ->get();
		return $billing_data;  
	}
    
} 
