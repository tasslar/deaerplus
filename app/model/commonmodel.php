<?php
namespace App\model;
use DB;
use Config;
use Illuminate\Database\Eloquent\Model;
use App\model\notificationsmodel;
use App\model\buyymodel;
use Session;
use Carbon\Carbon;
class commonmodel extends Model
{
	protected $connection = 'mastermysql';
    
    public static function commonheaderdata()
    {   
        return array('id'=>Session::get('ses_id'),
                'title'=>'',
                'p_id'=>'',
              'dealer_name'=>Session::get('ses_dealername'),
              'logo'=>Session::get('logo'),
              'email_count'=>notificationsmodel::fetchNotificationCount(Session::get('dealer_schema_name'),Session::get('ses_id')),
              'sys_notification_list'=>notificationsmodel::fetchSysNotification(Session::get('dealer_schema_name'),Session::get('ses_id')),
              'dealer_notification'=>notificationsmodel::dealer_notification_count(Session::get('dealer_schema_name'),Session::get('ses_id')),
              'dealer_notification_list'=>notificationsmodel::getDealerNotification(Session::get('dealer_schema_name'),Session::get('ses_id')),
              'dealer_alert_list'=>alertmodel::fetchAlertNotifyList(Session::get('dealer_schema_name'),Session::get('ses_id')),
              'recentcount'=>buyymodel::dealer_recent_count(Session::get('ses_id'),Session::get('dealer_schema_name')),
              'savedcount'=>buyymodel::dealerTableCount(Session::get('ses_id'),Session::get('dealer_schema_name'),'dealer_saved_carlisting',array('dealer_id'=>Session::get('ses_id'),'saved_status'=>1)),
              'alert_count'=>alertmodel::countReceivedAlert(Session::get('ses_id'))
             );
        
    }
    //get all city
	public static function get_master_city()
    {
    	 $master_city_data = DB::connection('mastermysql')->table('master_city')
															->select(DB::raw("master_id,country_id,state_id,city_id,city_name,popular_status"))
															->orderby('popular_status','desc')
															->orderby('city_name')
															->get();
         return $master_city_data;
    }
    public static function master_citys($state)
    {
        
         $master_city = DB::connection('mastermysql')->table('master_city')->select('master_id','country_id','city_name','state_id','city_id')->where('state_id',$state)->get();
         return $master_city;
    }
    public static function get_master_states()
    {
        
         $master_city_data = DB::connection('mastermysql')->table('master_city');
         return $master_city_data;
    }
    public static function get_master_state()
    {
        
         $master_state_data = DB::connection('mastermysql')->table('master_state')->orderby('state_name')->get();
         return $master_state_data;
    }
    public static function master_car_reg_year()
    {
        $master_car_reg_year = DB::connection('mastermysql')->table('master_car_reg_year')->get();
        return $master_car_reg_year;
    }
    public static function master_variants()
    {
        $variants = DB::connection('mastermysql')->table('master_variants');
        return $variants;
    }
    public static function master_category()
    {
        $master_car_reg_year = DB::connection('mastermysql')->table('master_category');
        return $master_car_reg_year;
    }
    public static function document_id_proof()
    {
        $document_id_proof = DB::connection('mastermysql')->table('master_doc_id_proof');
        return $document_id_proof;
    }
    
    public static function dealer_contact_type()
    {
        $document_id_proof = DB::connection('mastermysql')->table('dealer_contact_type');
        return $document_id_proof;
    }
    public static function dealer_employee_type()
    {
        $document_id_proof = DB::connection('mastermysql')->table('dealer_employee_type');
        return $document_id_proof;
    }
    

/*public static function dealer_plan_list()
{
    $plan_list = DB::connection('mastermysql')
                    ->table('master_plans')
                    ->whereNotIn('plan_type_id', [4])->get();
    return $plan_list;
}*/


    public static function get_api_sites()
    {
    	 $master_city_data = DB::connection('mastermysql')->table('master_api_sites')->where('status','Active')->get();
         return $master_city_data;
    }
    public static function get_listing_category()
    {
         $master_category = DB::connection('mastermysql')->table('master_category')->where('status','Active')->get();
         return $master_category;
    }
     public static function get_mater_budget()
    {
    	 $master_city_data = DB::connection('mastermysql')->table('master_budget_varient')->where('status','Active')->get();
         return $master_city_data;
    }
    public static function user_role()
    {
         $master_user = DB::connection('mastermysql')->table('master_user_role')->where('status','Active');
         return $master_user;
    }
    public static function makedropdown()
    {
        return DB::connection('mastermysql')->table('master_makes')->get();
    }
    public static function modeldropdown()
    {
        return DB::connection('mastermysql')->table('master_models')->get();
    }

    public static function variantdropdown()
    {
        return DB::connection('mastermysql')->table('master_variants')->get();
    }

    public static function apisites()
    {
        $master_user = DB::connection('mastermysql')->table('master_api_sites')->where('status','Active')->get();
        return $master_user;
    }

    public static function getAllRecords($table)
    {
        return  DB::connection('mastermysql')->table($table)->get();
    }
    public static function getAllRecordsWhere($table,$where)
    {
        return  DB::connection('mastermysql')->table($table)->where($where)->get();
    } 
    public static function getAllRecordsvalues($table,$where,$field)
    {
        return  DB::connection('mastermysql')->table($table)->where($where)->value($field);
    }   
	//join table 
	public static function master_join_table($table1,$table2,$Field1,$Field2)
	{           
		return $carlist_details   = DB::connection('mastermysql')
                                            ->table($table1)
                                            ->leftJoin($table2,"$table2.$Field1", '=',"$table1.$Field2")
                                            ->get();
	}
	
	//join table  with where condition 
	public static function master_join_table_where($table1,$table2,$Field1,$Field2,$where)
	{           
		return $carlist_details   = DB::connection('mastermysql')
                                            ->table($table1)
                                            ->leftJoin($table2,"$table2.$Field1", '=',"$table1.$Field2")
                                            ->where($where)
                                            ->get();
	}
	
    public static function maskingWithX($name)
    {
        return str_replace(substr($name, 3, strlen($name)),'xxxxxxx',$name);
    }
    
    public static function maskingWithstar($name)
    {		
		return substr($name,0,3).str_repeat("*",3);
    }

    public static function daysBetweenCurrentDate($startdate)
    {
        $post_date =strtotime($startdate);
        $cur_date  =strtotime(date('Y-m-d'));           
        $diff      =$cur_date-$post_date;
        $days      = floor($diff / (60 * 60 * 24));
        return $days;
    }

    public static function daysBetweenExpirydate($startdate)
    {
        $post_date =strtotime($startdate);
        $cur_date  =strtotime(date('Y-m-d'));           
        $diff      =$post_date-$cur_date;
        $days      = floor($diff / (60 * 60 * 24));
        return $days;
    }

    public static function listing_status_msg($listing_status,$expiry_date)
    {    
    	if($listing_status=='Inactive')
        {
          $listing_error_msg = ' This Listing is Not Available';
        }
        elseif($listing_status=='Sold')
        {
          $listing_error_msg = ' This Listing is Sold';
        }
        elseif($listing_status=='Expired') 
        {
          $listing_error_msg=' This Listing is Expired';
        }
        else
        {
          $listing_error_msg='';
        }
        return $listing_error_msg;
    }

    public static function getdatemonthtimeformat($startdate)
    {
		$days		=	 date("d M Y h:i:s",strtotime($startdate));
        return $days;
    }
    
	public static function getdatemonthformat($startdate)
    {
		$days		=	 date("d M Y",strtotime($startdate));
        return $days;
    }
    
	
    public static function doschemachange($dealer_schemaname)
    {
      Config::set('database.connections.dmsmysql.database',$dealer_schemaname);
    }
    
    //GET COUNT NO OF RECORDS WITH WHERE CONDITION
	public static function doschemacounttablewhere($dealer_schemaname,$table,$where)
	{
			
		commonmodel::doschemachange($dealer_schemaname);
		$dealerdata      	=      schemaconnection::dmsmysqlconnection()
									  ->table($table)
									  ->where($where)
									  ->count();
		  return $dealerdata;
	}
	 //GET COUNT NO OF RECORDS WITH WHERE CONDITION
	public static function doschemacounttablewherenotwhere($dealer_schemaname,$table,$where)
	{
			
		commonmodel::doschemachange($dealer_schemaname);
		$dealerdata      	=      schemaconnection::dmsmysqlconnection()
									  ->table($table)
									  ->where($where)
									  ->where('car_master_status','<>',4)
									  ->count();
		  return $dealerdata;
	}
	
	//GET COUNT NO OF RECORDS WITH WHERE CONDITION
	public static function doschemagetlivelisting($dealer_schemaname)
	{
			
		commonmodel::doschemachange($dealer_schemaname);
		$dealerdata      	=      schemaconnection::dmsmysqlconnection()
									  ->table('dms_car_listings')
									  ->where('car_master_status',2)
									  ->get();
		  return $dealerdata;
	}
	//GET COUNT last six month from till date
	public static function doschemacounttablewheresixmonth($dealer_schemaname,$table)
	{	
		commonmodel::doschemachange($dealer_schemaname);
		$dealerdata      	=      schemaconnection::dmsmysqlconnection()
									  ->table($table)
									  ->where('saledate','>=',Carbon::now('Asia/Kolkata')->subMonths(6))
									  ->count();
		  return $dealerdata;

	}
	//GET COUNT last six month from till date
	public static function doschemacounttablewheresixsalesprice($dealer_schemaname,$table)
	{	
		commonmodel::doschemachange($dealer_schemaname);
		$dealerdata      	=      schemaconnection::dmsmysqlconnection()
									  ->table($table)
									  ->select(DB::raw("SUM(saleprice) as soldamount"))
									  ->where('saledate','>',Carbon::now('Asia/Kolkata')->subMonths(6))
									  ->get();
		  return $dealerdata;

	}
	//THIS FUNCTION USED TO GET SIX MONTH RECORDS GROUP BY FIELDS
	public static function doSchemaCountWheresixsalesprice($dealer_schemaname,$table)
	{	
		commonmodel::doschemachange($dealer_schemaname);
		$dealerdata      	=      schemaconnection::dmsmysqlconnection()
									  ->table($table)
									  ->select(DB::raw("saledate,Month(saledate) mongodate,count(Month(saledate)) as countmonth,SUM(saleprice) as soldamount"))
									  ->where('saledate','>',Carbon::now('Asia/Kolkata')->subMonths(6))
									  ->groupby('mongodate')
									  ->get();
		  return $dealerdata;

	}
	//GET COUNT NO OF RECORDS WITH WHERE and WHEREBETWEEN CONDITION
	public static function doschemacountwherebetween($dealer_schemaname,$table,$startdate,$endofdate)
	{	
		commonmodel::doschemachange($dealer_schemaname);
		$dealerdata      	=      schemaconnection::dmsmysqlconnection()
									  ->table($table)
									  ->selectRaw('date(saledate) as date, COUNT(*) as count')
									  ->whereBetween( DB::raw('date(saledate)'), [$startdate, $endofdate] )
									  ->count();
		  return $dealerdata;
	}

	//GET COUNT NO OF RECORDS WITHOUT WHERE CONDITION
	public static function doschemacounttable($dealer_schemaname,$table)
	{
		commonmodel::doschemachange($dealer_schemaname);
		$dealerdata      =      schemaconnection::dmsmysqlconnection()
									  ->table($table)
									  ->count();
		  return $dealerdata;
	}
	
	//GET COUNT NO OF RECORDS WITH WHERE CONDITION
	public static function doschemacountwheretable($dealer_schemaname,$table)
	{
		commonmodel::doschemachange($dealer_schemaname);
		$dealerdata      =      schemaconnection::dmsmysqlconnection()
									  ->table($table)
									  ->where('car_master_status','<>',4)
									  ->count();
		  return $dealerdata;
	}
	
	//GET  RECORDS WITH GROUPBY IN SCHEMA CONNECTION
	public static function doschemagroupbycount($dealer_schemaname,$table,$field)
	{
			
		commonmodel::doschemachange($dealer_schemaname);
		$dealerdata      =      schemaconnection::dmsmysqlconnection()
									  ->table($table)
									  ->select(DB::raw("$field,count(*) as countinventorystatus"))
									  ->groupby($field)
									  ->get();
		  return $dealerdata;
	}
	//GET  RECORDS WITH GROUPBY where not empty IN SCHEMA CONNECTION
	public static function doschemagroupbynotempty($dealer_schemaname,$table,$field)
	{
		commonmodel::doschemachange($dealer_schemaname);
		$dealerdata      =      schemaconnection::dmsmysqlconnection()
									  ->table($table)
									  ->select(DB::raw("$field,count(*) as countinventorystatus"))
									  ->groupby($field)
									  ->where('car_master_status','=',2)
									  ->where($field,'<>','')
									  ->get();
		  return $dealerdata;
	}
	//GET  RECORDS WITH GROUPBY IN MASTER CONNECTION
	public static function domastergroupbycount($table,$field,$where)
	{
		$dealerdata      	=     DB::connection('mastermysql')
									  ->table($table)
									  ->select(DB::raw("$field,count($field) as viewcarcount"))
									  ->where($where)
									  ->groupby($field)
									  ->get();
		  return $dealerdata;
	}
	
	//GET  RECORDS WITH GROUPBY WHEREIN CONDITION MASTER CONNECTION
	public static function domastergroupbywherein($table,$field,$where)
	{
		$dealerdata      	=     DB::connection('mastermysql')
									  ->table($table)
									  ->select(DB::raw("$field,count($field) as viewcarcount"))
									  ->wherein($field,$where)
									  ->groupby($field)
									  ->get();
		  return $dealerdata;
	}
	//Join Table

	public static function dosschemachecknotexist($dealer_schemaname,$table1,$table2,$Field1,$Field2)
	{           
		commonmodel::doschemachange($dealer_schemaname);
		$carlist_details      =      schemaconnection::dmsmysqlconnection()
											->table($table1)
											->whereNotExists(function($query) use($table1,$table2,$Field1,$Field2)
												{
													$query->select(DB::raw(1))
														  ->from($table2)
														  ->whereRaw($table1.".".$Field2."=".$table2.".".$Field2);
												})
											->where("$table1."."car_master_status",'<>',4)
											->count();
		return $carlist_details;
	}
	//check wherein
	public static function dosschemacheckvaluewherein($dealer_schemaname,$table1,$wherecondition,$wherelive)
	{           
		commonmodel::doschemachange($dealer_schemaname);
		$carlist_details      =      schemaconnection::dmsmysqlconnection()
											->table($table1)
											->wherein('duplicate_id',$wherecondition)
											->where($wherelive)
											->get();
		return $carlist_details;
	}
	//check where and orwher
	public static function dosschemacheckwhere($dealer_schemaname,$table1,$where)
	{           
		commonmodel::doschemachange($dealer_schemaname);
		$carlist_details      =      schemaconnection::dmsmysqlconnection()
											->table($table1)
											->where($where)
											->get();
		return $carlist_details;
	}
	//GET ALL RECORDS COUNT IN MASTER TABLE
	public static function doMastercountrecords($table,$where)
    {
        return  DB::connection('mastermysql')->table($table)
												->where($where)
												->count();
    }
    //GET ALL RECORDS COUNT IN MASTER TABLE
	public static function doMasterrecordswherein($where)
    {
        return  DB::connection('mastermysql')->table('master_city')
											->select(DB::raw("country_id,state_id,city_id,city_name,popular_status"))
											->wherein('city_id',$where)
											->get();
    }
    //GET ALL RECORDS GROUPBY IN MASTER TABLE
	public static function doMastercountrecordsgroupby($table,$where)
    {
        return  DB::connection('mastermysql')->table($table)
												->wherein('car_id',$where)
												->get();
    }
    //GET ALL RECORDS WHEREIN MASTER TABLE
	public static function doMasterWherein($table,$where)
    {
        return  DB::connection('mastermysql')->table($table)
												->wherein($where)
												->count();
    }
    public static function dogetWhereinmakes($where)
    {
        return  DB::connection('mastermysql')->table('master_makes')
												->wherein('make_id',$where)
												->get();
    }
    public static function dogetWhereinmodels($where)
    {
        return  DB::connection('mastermysql')->table('master_models')
												->wherein('model_id',$where)
												->get();
    }
    
    public static function dogetWhereinleadparams($where)
    {
        return  DB::connection('mastermysql')->table('parameter_option_scoring')
												->wherein('option_id',$where)
												->get();
    }
	
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
    
	public static function dosschema_join_records($dealer_schemaname,$table1,$table2,$Field1,$Field2)
	{           
		$carlist_details   = schemaconnection::dmsmysqlconnection()
                                            ->table($table1)
                                            ->select(DB::raw('count("$table2.'.'.$Field1") as countinventorystatus'))
                                            ->rightJoin($table2,"$table2.$Field1", '=',"$table1.$Field2")
                                            ->where("$table1."."car_master_status",'<>',4)
                                            ->groupBy($table2.'.'.$Field1)
											->havingRaw('count("$table2.'.'.$Field1")  >= 6')
                                            ->get();
        return  $carlist_details;                                                                 											
	}
	
	public static function dosschema_join_recordsequal($dealer_schemaname,$table1,$table2,$Field1,$Field2)
	{           
		$carlist_details    = schemaconnection::dmsmysqlconnection()
                                            ->table($table1)
                                            ->select(DB::raw('count("$table2.'.'.$Field1") as countinventorystatus'))
                                            ->rightJoin($table2,"$table2.$Field1", '=',"$table1.$Field2")
                                            ->where("$table1."."car_master_status",'<>',4)
                                            ->groupBy($table2.'.'.$Field1)
											->havingRaw('count("$table2.'.'.$Field1") <= 5')
                                            ->get();
          return  $carlist_details;                                                                 											
	}
	
	/*The Function dealerQueriesDetail used to Queries Details
    */
    public static function dealerSellQueriesDetail($id,$dealer_schemaname){  
        commonmodel::doschemachange($dealer_schemaname);      
        $queryfetch = schemaconnection::dmsmysqlconnection()
                            ->table('dealer_contact_message_transactions')
                            ->groupBy('contact_transactioncode')
                            ->orderBy('thread_id','desc')
                            ->get(); 
        return $queryfetch; 
    }
    
    
	 //Join three Table start

    public static function schema_join_Threetable($table1,$table2,$table3,$Field1,$Field2,$Field3)
    {           
        $carlist_details    = 	DB::connection('mastermysql')
                                            ->table($table1)
                                            ->leftJoin($table2,"$table2.$Field1", '=',"$table1.$Field1")
                                            ->leftJoin($table3,"$table3.$Field3", '=',"$table2.$Field2")
                                            ->get();
        return $carlist_details;
    }
    //Join three Table end function
    //GET COUNT NO OF RECORDS WITH WHERE and WHEREBETWEEN CONDITION
	public static function doschemagetwherebetween($dealer_schemaname,$table,$where,$startdate,$endofdate)
	{	
		commonmodel::doschemachange($dealer_schemaname);
		$dealerdata      	=      schemaconnection::dmsmysqlconnection()
									  ->table($table)
									  ->whereBetween('mongopushdate',[$startdate,$endofdate])
									  ->where($where)
									  ->get();
		  return $dealerdata;
	}
	
	 //GET RECORD FOR CURRENT SCHEMA
	public static function doWherenotExists($dealer_schemaname,$table,$where,$filed,$value)
	{
		commonmodel::doschemachange($dealer_schemaname);
        $get_fetch_table_details = schemaconnection::dmsmysqlconnection()
                                            ->table($table)
                                            ->where($where)
                                            ->where($filed,'<>',$value)
                                            ->get();       
        return $get_fetch_table_details; 
	}
	
	 public static function dealerFetchcitynamegrouby($dealer_schemaname){  
        commonmodel::doschemachange($dealer_schemaname);
        $get_fetch_table_details = schemaconnection::dmsmysqlconnection()
                                            ->table('dms_car_listings')
                                            ->groupby('car_city')
                                            ->where('car_master_status','<>',4)
                                            ->where('car_city','<>','')
                                            ->where('branch_id','<>','')
                                            ->get();       
        return $get_fetch_table_details; 
    }

	//GET dodealercode for dealers
	public static function dodealercode()
	{
		$queryfetch = schemaconnection::masterconnection()
										->table('dms_dealers')
                                        ->orderby('d_id', 'desc')->first();
 		$currentdate= Carbon::now();
 		$autono 	= $queryfetch->d_id++;
 		$lengthid 	=  strlen($autono);
 		for ($i=$lengthid; $i < 6; $i++) { 
 			$autono = '0'.$autono;
 		}
        return $currentdate->format('y').$currentdate->format('m').$autono;
	}

	//GET domodelwithwherein for dealers
	public static function domodelwithwherein($make_id)
	{
		$queryfetch = schemaconnection::masterconnection()
										->table('master_models')
										->wherein('make_id',$make_id)
										->get();                                        
        return $queryfetch;
	}

	public static function doreplacetoNA($value)
	{
		if($value=='0'||$value=='')
		{
			return 'N/A';
		}
		else
		{
			return $value;
		}
	}
	//money convert
	public static function convert_number_to_words($getNumberWords)
	{		
        $bar = $getNumberWords;
        $bar = ucwords($bar);             
        $bar = ucwords(strtolower($bar));     
        return $bar;
	}
	public static function checkdatecontent($value)
	{
		$emptydata = '';
		if(date('Y-m-d', strtotime($value))=='-0001-11-30')
		{
			return $emptydata;
		}
		else
		{
			return $value;
		}
	}
	public static function dogetMasterCity()
	{
		$master_city_data = DB::connection('mastermysql')->table('master_city')
															->select(DB::raw("country_id,state_id,city_id,city_name,popular_status"))
															->orderby('popular_status','desc')
															->orderby('city_name')
															->get();
		return $master_city_data;
		
	}
	public static function discountcalc($price,$tax,$discount,$type,$subtotal)
	{
			$price  = $price + $price*($tax*(1/100));
			$fixedprice =  $price;
			if($type == "Amount")
			{
				$discount = $price - $discount;
				return $fixedprice - $discount;
			}
			else
			{
				$discount = $fixedprice - $subtotal;
				return $discount;				
			}			
			
	}
	public static function overalldiscount($overalldiscount,$type,$discount)
	{
		if($type == "Amount")
		{
			return $discount;
		}
		else
		{
			return $overalldiscount*($discount/100);
		}
	}
}
