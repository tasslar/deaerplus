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
class fundingmodel extends Eloquent
{
	protected $connection 	=	"mastermysql";
	protected $table 		=	"dealer_funding_details";
    
    public static function doGetfundingdetails($wherecondition){  
        $get_fetch_table_details   = 	DB::connection('mastermysql')
											->table('dealer_funding_details')
                                            ->leftJoin('dealer_funding_items','dealer_funding_items.dealer_funding_detail_id', '=','dealer_funding_details.dealer_funding_detail_id')
                                            ->where($wherecondition)
                                            ->groupBy('dealer_funding_items.dealer_funding_detail_id')
                                            ->orderBy('dealer_funding_details.created_at','desc')
                                            ->get();       
        return $get_fetch_table_details; 
    }
    
    public static function doGetcardetailsfundingisexist($id,$lid){  
        $get_fetch_table_details   = 	DB::connection('mastermysql')
											->table('dealer_funding_details')
                                            ->leftJoin('dealer_funding_items','dealer_funding_items.dealer_funding_detail_id', '=','dealer_funding_details.dealer_funding_detail_id')
                                            ->where('dealer_funding_details.user_id',$id)
                                            ->where('dealer_funding_items.dealer_listing_id',$lid)
                                            ->get();       
        return $get_fetch_table_details; 
    }
    
    public static function dealerFetchbranchDetails($dealer_schemaname,$wherecondition){  
        commonmodel::doschemachange($dealer_schemaname);
        $get_fetch_table_details = schemaconnection::dmsmysqlconnection()
                                            ->table('dms_dealer_branches')
                                            ->where($wherecondition)
                                            ->where('dealer_status','Active')
                                            ->orderBy('dealer_name','asc')
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
	public static function dogetcitynamemaster($value){  
	$get_fetch_table_details = schemaconnection::masterconnection()
										->table('master_city')
										->where('city_id',$value)
										->get();       
	return $get_fetch_table_details; 
	}
	public static function dogetcityidmaster($value){  
	$get_fetch_table_details = schemaconnection::masterconnection()
										->table('master_city')
										->where('city_name',$value)
										->get();       
	return $get_fetch_table_details; 
	}
	public static function doInsertTicketrequest($ticketdata)
	{
		$dealer_id 	= 	schemaconnection::masterconnection()
						->table('dealer_ticket_requests')
						->insertGetId($ticketdata); 
		return $dealer_id;   
	}
	public static function doInsertfundingapplyrequest($ticketdata)
	{
		$dealer_id 	= 	schemaconnection::masterconnection()
						->table('dealer_funding_details')
						->insertGetId($ticketdata); 
		return $dealer_id;   
	}
	public static function doInsertFundingItems($ticketdata)
	{
		$dealer_id 	= 	schemaconnection::masterconnection()
						->table('dealer_funding_items')
						->insertGetId($ticketdata); 
		return $dealer_id;   
	}
	
	public static function doRevokefundingtable($updatedetails,$where)
	{
		$updatedata      =      schemaconnection::masterconnection()
									->table('dealer_funding_details')
									->where($where)
									->update($updatedetails);
		return $updatedata;
	}
	
	public static function doUpdatedmstable($dealer_schemaname,$updatedetails,$where)
	{
		commonmodel::doschemachange($dealer_schemaname);
		$updatedata      =      schemaconnection::dmsmysqlconnection()
									->table('dms_car_listings')
									->wherein('car_id',$where)
									->update($updatedetails);

		return $updatedata;
	}
	public static function dealerFetchTablewhereinCarid($dealer_schemaname,$wherecondition){  
        commonmodel::doschemachange($dealer_schemaname);
        $get_fetch_table_details = schemaconnection::dmsmysqlconnection()
                                            ->table('dms_car_listings')
                                            ->wherein('car_id',$wherecondition)
                                            ->get();       
        return $get_fetch_table_details; 
    }
    public static function checkpricesum($dealer_schemaname,$wherecondition){  
        commonmodel::doschemachange($dealer_schemaname);
        $get_fetch_table_details = schemaconnection::dmsmysqlconnection()
                                            ->table('dms_car_listings')
                                            ->select('price')
                                            ->wherein('car_id',$wherecondition)
                                            ->get();       
        return $get_fetch_table_details; 
    }
    public static function dealerFetchTablewhereinlistingid($dealer_schemaname,$wherecondition){  
        commonmodel::doschemachange($dealer_schemaname);
        $get_fetch_table_details = schemaconnection::dmsmysqlconnection()
                                            ->table('dms_car_listings')
                                            ->wherein('duplicate_id',$wherecondition)
                                            ->where('duplicate_id','<>','')
                                            ->get();       
        return $get_fetch_table_details; 
    }
    
    public static function dealergetTodealerTable($dealer_schemaname,$wherecondition){

        Config::set('database.connections.dmsmysql2.database',$dealer_schemaname);
        $insertwithid = DB::connection('dmsmysql2')
                                            ->table('dms_car_listings')
                                            ->wherein('duplicate_id',$wherecondition)
                                            ->where('duplicate_id','<>','')
                                            ->get();      
        return $insertwithid; 
    }
    
    public static function dealergetTodealerphotosTable($dealer_schemaname,$wherecondition){

        Config::set('database.connections.dmsmysql2.database',$dealer_schemaname);
        $insertwithid = DB::connection('dmsmysql2')
                                            ->table('dms_car_listings_photos')
                                            ->where($wherecondition)
                                            ->where('car_id','<>','')
                                            ->get();      
        return $insertwithid; 
    }
    
    public static function dealerFetchTableDetails($dealer_schemaname,$tablename,$wherecondition){  
        commonmodel::doschemachange($dealer_schemaname);
        $get_fetch_table_details = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)
                                            ->where($wherecondition)
                                            ->get();       
        return $get_fetch_table_details; 
    }
    /*this function used to fetch records with where condition and not where condition*/
    public static function dealerFetchTableDetailsnotwhere($dealer_schemaname,$tablename,$wherecondition,$notexistcarid){  
        commonmodel::doschemachange($dealer_schemaname);
        $get_fetch_table_details = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)
                                            ->where($wherecondition)
                                            ->where('car_master_status','<>',3)
                                            ->where('car_master_status','<>',4)
                                            ->whereNotIn('car_id',$notexistcarid)
                                            ->get();       
        return $get_fetch_table_details; 
    }
    
     
    public static function dealerFetchcardetailsfunding($dealer_schemaname,$wherecondition){  
        commonmodel::doschemachange($dealer_schemaname);
        $get_fetch_table_details = schemaconnection::dmsmysqlconnection()
                                            ->table('dms_car_listings')
                                            ->where($wherecondition)
                                            ->where('car_master_status','<>',3)
                                            ->where('car_master_status','<>',4)
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
	
    public static function dealerFetchTableDetailswherein($dealer_schemaname,$tablename,
														$wherecondition,$whereall,$notexistcarid){ 
        commonmodel::doschemachange($dealer_schemaname);
        $get_fetch_table_details = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)
                                            ->where($wherecondition)
                                            ->where(function($q) use ($whereall){
												foreach($whereall as $key => $value){
												if(!empty($value))
												{
													$q->wherein($key,$value);
												}
											}
											})->where('car_master_status','<>',4)
											->where('car_master_status','<>',3)
											->whereNotIn('car_id',$notexistcarid)
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
    
    public static function dealerFetchTablewhereinlike($tablename,$where,$field,$value){  
        $get_fetch_table_details = schemaconnection::masterconnection()
                                            ->table($tablename)
                                            ->wherein($field,$where)
                                            ->where($field,'like','%'.$value.'%')
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
    public static function masterFetchTableDetails($id,$tablename,$wherecondition){

        $get_fetch_table_details = schemaconnection::masterconnection()
                                            ->table($tablename)
                                            ->where($wherecondition)
                                            ->get();       
        return $get_fetch_table_details;
    }

    public static function fetchCity()
    {
        return schemaconnection::masterconnection()
                            ->table('master_city')
                            ->where('status','Active')
                            ->get();
    }
}
