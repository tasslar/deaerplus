<?php
namespace App\model;
use DB;
use Config;
use Session;
use App\model\commonmodel;
use App\model\schemaconnection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class inventorymodel extends Model
{
    
    public function __construct()
    {
        Config::set('database.connections.dmsmysql.database', session::get('dealer_schema_name'));
         
    }
    public static function dealerplan()
    { 
        return DB::table('dealer_billing_details')
                ->where('dealer_billing_details.current_subscription','1')
                ->where('dealer_billing_details.dealer_id',session::get('ses_id') )
                ->join('master_subscription_plans','master_subscription_plans.subscription_plan_id','=','dealer_billing_details.subscription_plan_id')
                ->join('master_plans','master_plans.plan_type_id','=','master_subscription_plans.plan_type_id')
                ->first();
        // return  DB::select(DB::raw("select * from master_subscription_plans where subscription_plan_id=(select subscription_plan_id from dealer_billing_details where dealer_id="session::get('d_id')" and current_subscription=1)"));

    }
    
    public static function getdealerplan($id)
    { 
        return DB::table('dealer_billing_details')
                ->where('dealer_billing_details.current_subscription','1')
                ->where('dealer_billing_details.dealer_id',$id)
                ->join('master_subscription_plans','master_subscription_plans.subscription_plan_id','=','dealer_billing_details.subscription_plan_id')
                ->join('master_plans','master_plans.plan_type_id','=','master_subscription_plans.plan_type_id')
                ->first();
    }
    
    
    public static function schema_table($table)
    {           
        $schema_table_data = DB::connection('dmsmysql')->table($table)->get();
        return $schema_table_data;
    }

    public static function schema_table_orderby_desc($table)
    {           
        $schema_table_data = DB::connection('dmsmysql')->table($table)->orderBy('addinventor_id', 'desc')->first();
        return $schema_table_data;
    }

    public static function masterschema_table_where($table,$where)
    {           
        $register_users = DB::connection('mastermysql')->table($table)->where($where)->get();        
        return $register_users;
    }

    public static function schema_table_where_update($table,$param1,$param2,$param3,$param4)
    {           
        $register_users = DB::connection('dmsmysql')->table($table)->where($param1,$param2)->update([$param3=>$param4]);        
        return $register_users;
    }

    public static function master_table($table)
    {           
        $master_table_data = DB::connection('mastermysql')->table($table)->get();
        return $master_table_data;
    }

    public static function master_table_color($table,$param1,$param2)
    {           
        $master_table_data = DB::connection('mastermysql')->table($table)->where($param1,$param2)->get();
        return $master_table_data;
    }

    public static function master_table_where($table,$param1,$param2)
    {           
        $master_table_data = DB::connection('mastermysql')->table($table)->where($param1,$param2)->get();
        return $master_table_data;
    }

    public static function master_table_makeid_model_varient($table,$param1,$param2)
    {           
        $master_table_data = DB::connection('mastermysql')->table($table)->where($param1,$param2)->get();
        return $master_table_data;
    }
    public static function schema_table_where($table,$wherelist)
    {           
        $master_table_data = DB::connection('dmsmysql')->table($table)->where($wherelist)->get();
        return $master_table_data;
    }
    
    public static function schema_table_where_delete($table,$deletecontent)
    {   
        $master_table_get_data = DB::connection('dmsmysql')->table($table)->where($deletecontent)->get();
        $master_table_data = '';
        if(count($master_table_get_data) >= 1){        
            $master_table_data = DB::connection('dmsmysql')->table($table)->where($deletecontent)->delete();
        }
        return $master_table_data;
    }


    public static function schema_table_listing_duplicateid($table,$param1,$param2)
    {           
        $master_table_data = DB::connection('dmsmysql')->table($table)->where($param1,$param2)->get();
        return $master_table_data;
    }

    public static function schema_table_listing_photos_duplicateid($table,$param1,$param2)
    {           
        $master_table_data = DB::connection('dmsmysql')->table($table)->where($param1,$param2)->get();
        return $master_table_data;
    }

    public static function schema_table_listing_videos_duplicateid($table,$param1,$param2)
    {           
        $master_table_data = DB::connection('dmsmysql')->table($table)->where($param1,$param2)->get();
        return $master_table_data;
    }

    public static function schema_table_listing_pricing_duplicateid($table,$param1,$param2)
    {           
        $master_table_data = DB::connection('dmsmysql')->table($table)->where($param1,$param2)->get();
        return $master_table_data;
    }

    public static function schema_table_listing_purchase_duplicateid($table,$param1,$param2)
    {           
        $master_table_data = DB::connection('dmsmysql')->table($table)->where($param1,$param2)->get();
        return $master_table_data;
    }

    public static function schema_table_listing_expense_duplicateid($table,$param1,$param2)
    {           
        $master_table_data = DB::connection('dmsmysql')->table($table)->where($param1,$param2)->get();
        return $master_table_data;
    }

    public static function schema_table_listing_online_duplicateid($table,$param1,$param2)
    {           
        $master_table_data = DB::connection('dmsmysql')->table($table)->where($param1,$param2)->get();
        return $master_table_data;
    }


    public static function schema_table_listing_documents_duplicateid($table,$param1,$param2)
    {           
        $master_table_data = DB::connection('dmsmysql')->table($table)->where($param1,$param2)->get();
        return $master_table_data;
    }

    public static function schema_insert($table,$array)
    {           
        $update_list = DB::connection('dmsmysql')->table($table)->insert($array);
        return $update_list;
    }

    public static function schema_insertId($table,$array)
    {   
        Config::set('database.connections.dmsmysql.database', session::get('dealer_schema_name')); 
        $update_list = DB::connection('dmsmysql')->table($table)->insert($array);
        return $update_list;
    }

    public static function schema_update($table,$whereid,$wherevalue,$array)
    {           
        $update_list = DB::connection('dmsmysql')->table($table)->where($whereid,$wherevalue)->update($array);
        return $update_list;
    }

    public static function schema_delete($table,$wherecondition)
    {           
        $DeleteRecord = DB::connection('dmsmysql')->table($table)->where($wherecondition)->delete();
        return $DeleteRecord;
    }

    public static function schema_update_singlewhere($table,$whereid,$array)
    {           
        $update_list = DB::connection('dmsmysql')->table($table)->where($whereid)->update($array);
        return $update_list;
    }

    public static function schema_update_twowhere($table,$where1,$where2,$array)
    {           
        $update_list = DB::connection('dmsmysql')->table($table)
                                                 ->where($where1)
                                                 ->where($where2)
                                                 ->update($array);
        return $update_list;
    }

    public static function schema_orderby_desc($table,$orderby,$order)
    {           
         $carlist_details = DB::connection('dmsmysql')->table($table)->orderBy($orderby,$order)->get();
         return $carlist_details;
    }

    public static function schema_where_notequal($table,$fieldname,$fieldstatus,$fieldvalue)
    {
        $dms_car_listings_details = DB::connection('dmsmysql')->table($table)
                                                                ->where($fieldname,$fieldvalue)
                                                                ->where($fieldstatus,'0')
                                                                ->where($fieldstatus,'<>','4')
                                                                ->get();
        return $dms_car_listings_details;
    }
    
    public static function schema_where($table,$where,$Value)
    {           
        $carlist_details = DB::connection('dmsmysql')->table($table)
                                                     ->where($where,$Value)
                                                     ->get();
         return $carlist_details;
    }

    public static function schema_whereid($table,$where)
    {           
        $carlist_details = DB::connection('dmsmysql')->table($table)
                                                     ->where($where)
                                                     ->get();
         return $carlist_details;
    }
    
    public static function schema_where_dealercarview($table,$where,$Value)
    {           
        $carlist_details = DB::connection('mastermysql')->table($table)
                                                     ->where($where,$Value)
                                                     ->get();
         return $carlist_details;
    }
    
    public static function schema_where_two($table,$where,$wherestatus,$valueid,$Value)
    {           
        $carlist_details = DB::connection('dmsmysql')->table($table)
                                                     ->where($where,$valueid)
                                                     ->where($wherestatus,$Value)
                                                     ->get();
         return $carlist_details;
    }
    
    public static function schema_where_three($table,$where,$wheretype,$wherestatus,$valueid,$Value)
    {           
        $carlist_details = DB::connection('dmsmysql')->table($table)
                                                     ->where($where,$valueid)
                                                     ->where($wheretype,$Value)
                                                     ->where($wherestatus,'0')
                                                     ->get();
         return $carlist_details;
    }
    
    public static function schema_where_orderby_limit_one($table,$where,$orderby,$Value)
    {           
        $carlist_details = DB::connection('dmsmysql')->table($table)
                                                     ->orderBy($orderby,'asc')
                                                     ->where($where,$Value)
                                                     ->take(1)->get();
         return $carlist_details;
    }
    //Join Table

    public static function schema_join_Threetable($table1,$table2,$table3,$Field1,$Field2,$Field3,$where)
    {           
        $carlist_details    = DB::connection('dmsmysql')
                                            ->table($table1)
                                            ->leftJoin($table2,"$table2.$Field1", '=',"$table1.$Field2")
                                            ->leftJoin($table3,"$table3.$Field3", '=',"$table1.$Field2")
                                            ->where($where)->get();
        return $carlist_details;
    }    

    /*The Function dealerQueriesDetail used to Queries Details
    */
    public static function dealerSellQueriesDetail($id,$dealer_schemaname){  
        commonmodel::doschemachange($dealer_schemaname);      
        $queryfetch = schemaconnection::dmsmysqlconnection()
                            ->table('dealer_contact_message_transactions')
                            ->whereIn('car_id',function($query)use($id){
                                $query -> select('duplicate_id')
                                -> from('dms_car_listings')
                                -> where('dealer_id',$id);
                                })
                            ->groupBy('contact_transactioncode')
                            ->orderBy('thread_id','DESC')
                            ->paginate(10); 
                            /*//*/      
        return $queryfetch; 
    }

	public static function dealerSellQueriesDetailApi($id,$dealer_schemaname){  
        commonmodel::doschemachange($dealer_schemaname);      
        $queryfetch = schemaconnection::dmsmysqlconnection()
                            ->table('dealer_contact_message_transactions')
                            ->whereIn('car_id',function($query)use($id){
                                $query -> select('duplicate_id')
                                -> from('dms_car_listings')
                                -> where('dealer_id',$id);
                                })
                            ->groupBy('contact_transactioncode')
                            ->orderBy('thread_id')
                            ->get(); 
        return $queryfetch; 
    }	
    /*The Function dealerQueriesDetail used to Queries Details
    */
    public static function dealerSellQueriesCount($id,$dealer_schemaname,$car_id){  
        commonmodel::doschemachange($dealer_schemaname);      
        $queryfetch = schemaconnection::dmsmysqlconnection()
                            ->table('dealer_contact_message_transactions')
                            ->whereIn('car_id',$car_id)
                            ->groupBy('contact_transactioncode')
                            ->orderBy('thread_id')
                            ->count();      
        return $queryfetch; 
    }

    /*The Function dealerQueriesWithCode used to get last Queries Details
    */
    public static function dealerQueriesWithCode($dealer_schemaname,$wherecondition){  
        commonmodel::doschemachange($dealer_schemaname);      
        $queryfetch = schemaconnection::dmsmysqlconnection()
                            ->table('dealer_contact_message_transactions')
                            ->where($wherecondition)
                            ->orderBy('thread_id','desc')
                            ->first();       
        return $queryfetch; 
    }
    
    public static function schema_table_where_not($id,$dealer_schemaname,$table,$wherelist)
    {           
        commonmodel::doschemachange($dealer_schemaname);      
        $master_table_data = schemaconnection::dmsmysqlconnection()
                            ->table($table)
                            ->where($wherelist)
                            ->where('status','<>',2)
                            ->where('status','<>',3)
                            ->get();
        return $master_table_data;
    }
    
    public static function schema_table_where_inventory($dealer_schemaname,$table,$wherelist,$orderby,$field)
    {           
        commonmodel::doschemachange($dealer_schemaname);      
        $master_table_data = schemaconnection::dmsmysqlconnection()
                            ->table($table)
                            ->where($wherelist)
                            ->where('car_master_status','<>',3)
                            ->where('car_master_status','<>',4)
                            ->orderby($orderby,$field)
                            ->orderBy('updated_at','desc')
                            ->get();
        return $master_table_data;
    }
   
    /*The Function masterInsertTable used to Insert of param details
    of Master table
    */    
    public static function masterFetchTableDetails($id,$tablename,$wherecondition){

        $get_fetch_table_details = schemaconnection::masterconnection()
                                            ->table($tablename)
                                            ->where($wherecondition)
                                            ->get();       
        return $get_fetch_table_details;
    }
    public static function schema_mongopush_update($table,$where,$dataupdate)
    {           
        $register_users = DB::connection('dmsmysql')->table($table)->where($where)->update($dataupdate);        
        return $register_users;
    }
     //INSERT RECORD FOR CURRENT SCHEMA
    public static function InsertTable($id,$dealer_schemaname,$tablename,$insertrecord){

        commonmodel::doschemachange($dealer_schemaname);
        $insertwithid = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)
                                            ->insertGetId($insertrecord);      
        return $insertwithid; 
    }
     //GET RECORDS FOR CURRENT SCHEMA
    public static function fetchrecordsTable($dealer_schemaname,$tablename)
    {        
        commonmodel::doschemachange($dealer_schemaname);      
        $fetchrecords = schemaconnection::dmsmysqlconnection()
                            ->table($tablename)
                            ->orderBy('thread_id')
                            ->get();       
        return $fetchrecords; 
    }
     //GET RECORDS FOR CURRENT SCHEMA ORDER BY DESC,ASC
    public static function fetchrecordsTableorderby($dealer_schemaname,$tablename,$where,$field,$desc)
    {        
        commonmodel::doschemachange($dealer_schemaname);      
        $fetchrecords = schemaconnection::dmsmysqlconnection()
                            ->table($tablename)
                            ->where($where)
                            ->orderBy('updated_at','desc')
                            ->get();       
        return $fetchrecords; 
    }
     //GET RECORDS FOR CURRENT SCHEMA ORDER BY DESC,ASC
    public static function fetchrecordsparkandsell($dealer_schemaname,$where,$field,$desc)
    {        
        commonmodel::doschemachange($dealer_schemaname);      
        $fetchrecords = schemaconnection::dmsmysqlconnection()
                            ->table('dms_car_listings')
                            ->where($where)
                            ->where('car_master_status','<>',3)
                            ->where('car_master_status','<>',4)
                            ->orderBy('updated_at','desc')
                            ->get();       
        return $fetchrecords; 
    }
    
    //this function used for get myposting details with schema
    public static function schema_mypostings_list($dealer_schemaname,$table,$where,$fieldstatus)
    {           
         commonmodel::doschemachange($dealer_schemaname);      
        $fetchrecords = schemaconnection::dmsmysqlconnection()
                            ->table($table)
                            ->where($where)
                            //->where($fieldstatus,'<>',4)
                            ->orderBy("price","desc")
                            ->get();       
        return $fetchrecords; 
    }
    /*
    *The Function mongoListingFetch used to fetchdetails from mongo with paginate
    */
    public static function mongoListingFetchwithqueries($id,$wherecondition,$orwherecondition){
        $paginatenolisting        = Config::get('common.paginatenolisting');
        $mongo_carlisting_details = mongomodel::where(function($q) use ($wherecondition){
                                        foreach($wherecondition as $key => $value){
                                           if($key!='sell_price'&&$key!='notinlisting_id')
                                            {
                                                if(!empty($value))
                                                {
                                                    $q->wherein($key, $value);
                                                }
                                            }
                                            else if($key=='sell_price')
                                            {
                                                $q->wherebetween($key, $value);
                                            }
                                        }
                                    })->orwhere(function($q) use ($orwherecondition){
                                        foreach($orwherecondition as $key => $value){
                                           if($key!='sell_price')
                                            {
                                                if(!empty($value))
                                                {
                                                    $q->orwherein($key, $value);
                                                }
                                            }
                                        }
                                    })->orderBy('sell_price', 'asc')
                                      ->paginate($paginatenolisting);  

        return $mongo_carlisting_details;
    }
    //get quries api
     public static function mongoListingApiFetchwithqueries($id,$wherecondition,$orwherecondition){
        $mongo_carlisting_details = mongomodel::where(function($q) use ($wherecondition){
                                        foreach($wherecondition as $key => $value){
                                           if($key!='sell_price'&&$key!='notinlisting_id')
                                            {
                                                if(!empty($value))
                                                {
                                                    $q->wherein($key, $value);
                                                }
                                            }
                                            else if($key=='sell_price')
                                            {
                                                $q->wherebetween($key, $value);
                                            }
                                        }
                                    })->orwhere(function($q) use ($orwherecondition){
                                        foreach($orwherecondition as $key => $value){
                                           if($key!='sell_price')
                                            {
                                                if(!empty($value))
                                                {
                                                    $q->orwherein($key, $value);
                                                }
                                            }
                                        }
                                    })->orderBy('sell_price', 'asc')
                                    ->get();  

        return $mongo_carlisting_details;
    }
    public static function schema_whereorderbylimitone($dealer_schemaname,$table,$orderby,$where)
    {           
        commonmodel::doschemachange($dealer_schemaname);      
        $fetchrecords = schemaconnection::dmsmysqlconnection()
                                                    ->table($table)
                                                    ->orderBy($orderby,'asc')
                                                    ->where($where)
                                                    ->take(1)->get();
         return $fetchrecords;
    }

    /*The Function dealerFetchTableDetails used to Fetch of param details of dealers schema table
    */
    public static function inventoryTableDetails($dealer_schemaname,$tablename,$wherecondition,$param,$sortingcolumn,$sortingcond){  
        commonmodel::doschemachange($dealer_schemaname);
        $get_fetch_table_details = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)
                                            ->select($param)
                                            ->where($wherecondition)
                                            ->orderby($sortingcolumn,$sortingcond)
                                            ->paginate(10);      
        return $get_fetch_table_details; 
    }
	//this function used to order by field without where condition
	public static function schemaorderby_details($dealer_schemaname,$tablename,$field,$orderbyfield){  
        commonmodel::doschemachange($dealer_schemaname);
        $get_fetch_table_details = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)
                                            ->orderBy('updated_at','desc')
                                            ->get();       
        return $get_fetch_table_details; 
    }
	
    public static function inventoryImageDetails($dealer_schemaname,$tablename,$wherecondition){  
        commonmodel::doschemachange($dealer_schemaname);
        $get_fetch_table_details = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)
                                            ->where($wherecondition)
                                            ->get();       
        return $get_fetch_table_details; 
    }

    public static function dogetschemaDetails($dealer_schemaname,$tablename,$field,$wherecondition){  
        commonmodel::doschemachange($dealer_schemaname);
        $get_fetch_table_details = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)
                                            ->select(DB::raw($field))
                                            ->where($wherecondition)
                                            ->get();       
        return $get_fetch_table_details; 
    }
    
    public static function dogetschemabranch($dealer_schemaname,$wherecondition){  
        commonmodel::doschemachange($dealer_schemaname);
        $get_fetch_table_details = schemaconnection::dmsmysqlconnection()
                                            ->table('dms_dealer_branches')
                                            ->select('dealer_name','branch_id')
                                            ->where($wherecondition)
                                            ->get();       
        return $get_fetch_table_details; 
    }
    /*The Function dealerTableCount used to Count of param details of dealers schema table*/
    public static function dealerTableCount($dealer_schemaname,$tablename,$wherecondition){        
        commonmodel::doschemachange($dealer_schemaname);
        $get_fetch_table_count = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)
                                            ->where($wherecondition)
                                            ->count();       
        return $get_fetch_table_count; 
    }

    /*The Function masterBiddingCount used to Count dealer Bidding Details
    */
    public static function masterTableCount($tablename,$wherecondition){  
        
        $count = schemaconnection::masterconnection()
                            ->table($tablename)
                            ->where($wherecondition)
                            ->count();
         
        return $count; 
    }

    /*The Function dealerInsertTable used to Insert of param details
    of dealers schema table
    */
    public static function dealerInsertTable($dealer_schemaname,$tablename,$insertrecord){

        commonmodel::doschemachange($dealer_schemaname);
        $insertwithid = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)
                                            ->insertGetId($insertrecord);      
        return $insertwithid; 
    }

    /*The Function dealerFetchTableDetails used to Fetch of param details of dealers schema table
    */
    public static function dealerFetchTableDetails($dealer_schemaname,$tablename,$wherecondition){  
        commonmodel::doschemachange($dealer_schemaname);
        $get_fetch_table_details = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)
                                            ->where($wherecondition)
                                            ->get();       
        return $get_fetch_table_details; 
    }
    
    public static function getviewinventorydetails($dealer_schemaname,$wherecondition){  
        commonmodel::doschemachange($dealer_schemaname);
        $get_fetch_table_details = schemaconnection::dmsmysqlconnection()
                                            ->table('dms_car_listings')
                                            ->leftJoin('dealer_cars_pricing','dealer_cars_pricing.listing_id', '=','dms_car_listings.car_id')
                                             ->select('dms_car_listings.*', 'dealer_cars_pricing.*')
                                             ->addSelect('dms_car_listings.status as carstatus')
                                            ->where('dms_car_listings.car_id',$wherecondition)
                                            ->get();
        return $get_fetch_table_details; 
    }

     /*The Function dealerUpdateTableDetails used to Update of param details of dealers schema table
    */
    public static function dealerUpdateTableDetails($id,$dealer_schemaname,$tablename,$wherecondition,$settabledata){
        commonmodel::doschemachange($dealer_schemaname);
        $updatetables = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)
                                            ->where($wherecondition)
                                            ->update($settabledata);       
        return $updatetables; 
    }

    public static function dealerDeleteTableDetails($dealer_schemaname,$table,$wherecondition)
    {       
        commonmodel::doschemachange($dealer_schemaname);    
        $DeleteRecord = DB::connection('dmsmysql')->table($table)->where($wherecondition)->delete();
        return $DeleteRecord;
    }
    
    
    public static function doApichecklistingexist($schemaname,$wherelist)
    {           
        commonmodel::doschemachange($schemaname);      
        $master_table_data = schemaconnection::dmsmysqlconnection()
                            ->table('dms_car_listings')
                            ->join('dms_car_listings_photos','dms_car_listings_photos.car_id','=','dms_car_listings.car_id')
                            ->join('dealer_cars_pricing','dealer_cars_pricing.listing_id','=','dms_car_listings.car_id')
                            ->where('dms_car_listings.car_id',$wherelist)
                            ->where('car_master_status','<>',3)
                            ->where('car_master_status','<>',4)
                            ->where('car_master_status','<>',5)
                            ->get();
        return $master_table_data;
    }

 }
