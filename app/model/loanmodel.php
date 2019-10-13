<?php
/*
  Module Name : funding Model 
  Created By  : vinoth 20-02-2017
  Use of this module is Insert,Update,Fetch From table my sql dealer schema, master tables retrive data
*/
namespace App\model;
use App\model\commonmodel;
use App\model\schemaconnection;
use Illuminate\Database\Eloquent\Model;
use Eloquent;
use Config;
use DB;
use Session;
class loanmodel extends Eloquent
{
	protected $connection 	=	"mastermysql";
	protected $table 		=	"dealer_customerloan_details";
	public static function doFetchloanDetails($where)
	{
		$dealer_id 	= 	schemaconnection::masterconnection()
						->table('dealer_customerloan_details')
						->select(DB::raw("dealer_customer_loan_id,customer_id,customername,customermobileno,
						customerpannumber,dealer_ticket_id,dealer_loan_ticket_id,customermailid,customercity,
						branchname,requested_amount,created_date,vehicle_details,
						(CASE WHEN (status = 0) THEN 'In Progress' 
						WHEN (status = 1) THEN 'Approved'
						WHEN (status = 2) THEN 'Declined' 
						ELSE 'Revoked' END) as ticketstatus"))
						->where($where)
						->orderBy('create_at','desc')
						->get(); 
		return $dealer_id;  
	}
    /*The Function used to Fetch from dealerFetchTableDetails of param details of dealers schema table
    */
    public static function dealerFetchTableDetails($dealer_schemaname,$tablename,$wherecondition){  
        commonmodel::doschemachange($dealer_schemaname);
        $get_fetch_table_details = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)
                                            ->where($wherecondition)
                                            ->get();       
        return $get_fetch_table_details; 
    }
    
    public static function dealerFetchcardetailsfunding($dealer_schemaname,$wherecondition,$getexistcarids){  
        commonmodel::doschemachange($dealer_schemaname);
        $get_fetch_table_details = schemaconnection::dmsmysqlconnection()
                                            ->table('dms_car_listings')
                                            ->where($wherecondition)
                                            ->where('car_master_status','<>',3)
                                            ->where('car_master_status','<>',4)
                                            ->whereNotin('car_id',$getexistcarids)
                                            ->get();       
        return $get_fetch_table_details; 
    }
    
    public static function doGetloanexistcar($where)
	{
		$updatedata      =      schemaconnection::masterconnection()
									->table('dealer_customerloan_details')
									->where($where)
									->where('car_id','<>','')
									->get();
		return $updatedata;
	}
	
	public static function doRegisterloanexistcar($where,$getexistcarids)
	{
		$updatedata      =      schemaconnection::masterconnection()
									->table('dealer_customerloan_details')
									->where($where)
									->where('car_id','<>','')
									->where('car_id',$getexistcarids)
									->get();
		return $updatedata;
	}
	
    public static function doRevokeloantable($updatedetails,$where)
	{
		$updatedata      =      schemaconnection::masterconnection()
									->table('dealer_customerloan_details')
									->where($where)
									->update($updatedetails);
		return $updatedata;
	}
    
    public static function doInsertTicketrequest($ticketdata)
	{
		$dealer_id 	= 	schemaconnection::masterconnection()
						->table('dealer_ticket_requests')
						->insertGetId($ticketdata); 
		return $dealer_id;   
	}
	public static function doInsertLoanapplyrequest($ticketdata)
	{
		$dealer_id 	= 	schemaconnection::masterconnection()
						->table('dealer_customerloan_details')
						->insertGetId($ticketdata); 
		return $dealer_id;   
	}
	
	public static function doUpdatedmstable($dealer_schemaname,$updatedetails,$where)
	{
		commonmodel::doschemachange($dealer_schemaname);
		$updatedata      =      schemaconnection::dmsmysqlconnection()
									->table('dms_car_listings')
									->where('car_id',$where)
									->update($updatedetails);

		return $updatedata;

	}
	public static function dealerFetchTablewhereCarid($dealer_schemaname,$wherecondition){  
        commonmodel::doschemachange($dealer_schemaname);
        $get_fetch_table_details = schemaconnection::dmsmysqlconnection()
                                            ->table('dms_car_listings')
                                            ->where('car_id',$wherecondition)
                                            ->get();       
        return $get_fetch_table_details; 
    }
   
   
    public static function dealerFetchbranchname($dealer_schemaname,$value){  
        commonmodel::doschemachange($dealer_schemaname);
        $get_fetch_table_details = schemaconnection::dmsmysqlconnection()
                                            ->table('dms_dealer_branches')
                                            ->where('branch_id',$value)
                                            ->where('dealer_status','Active')
                                            ->get();       
        return $get_fetch_table_details; 
    }
     public static function dealerFetchcustomername($dealer_schemaname,$value){  
        commonmodel::doschemachange($dealer_schemaname);
        $get_fetch_table_details = schemaconnection::dmsmysqlconnection()
                                            ->table('dealer_contact_management')
                                            ->where('contact_management_id',$value)
                                            ->get();       
        return $get_fetch_table_details; 
    }
     public static function dogetcitynamemaster($value){  
        $get_fetch_table_details = schemaconnection::masterconnection()
                                            ->table('master_city')
                                            ->where('city_id',$value)
                                            ->get();       
        return $get_fetch_table_details; 
    }
    public static function dealerFetchTableDetailsgrouby($dealer_schemaname,$tablename,$field){  
        commonmodel::doschemachange($dealer_schemaname);
        $get_fetch_table_details = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)
                                            ->groupby($field)
                                            ->where('car_master_status','<>',3)
                                            ->where('car_master_status','<>',4)
                                            ->where('car_city','<>','')
                                            ->get();       
        return $get_fetch_table_details; 
    }
    public static function dealerFetchTablewherein($tablename,$where,$filed){  
        $get_fetch_table_details = schemaconnection::masterconnection()
                                            ->table($tablename)
                                            ->wherein($filed,$where)
                                            ->get();       
        return $get_fetch_table_details; 
    }
    //schema connection where in 
    public static function dealerschemaFetchTablewherein($dealer_schemaname,$tablename,$where,$filed){  
        commonmodel::doschemachange($dealer_schemaname);
        $get_fetch_table_details = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)
                                            ->wherein($filed,$where)
                                            ->get();       
        return $get_fetch_table_details; 
    }
      
    /*The Function  used to get table Details
    */
    public static function doGetmasterdetails($table,$wherecondition){  
        
        $count = schemaconnection::masterconnection()
                            ->table($table)
                            ->where($wherecondition)
                            ->get();
        return $count; 
    }
    public static function schema_get_customername($dealer_schemaname)
	{           
		commonmodel::doschemachange($dealer_schemaname);
        $get_fetch_table_details = schemaconnection::dmsmysqlconnection()
                                            ->table('dealer_contact_management')
                                            ->where('contact_type_id',1)
                                            ->where('contact_status','active')
                                            ->orderBy('contact_first_name','asc')
                                            ->get();
        return $get_fetch_table_details;
	}
	 public static function masterFetchTableDetails($id,$tablename,$wherecondition){

        $get_fetch_table_details = schemaconnection::masterconnection()
                                            ->table($tablename)
                                            ->where($wherecondition)
                                            ->get();       
        return $get_fetch_table_details;
    }
}
