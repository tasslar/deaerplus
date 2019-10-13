<?php
/*
  Module Name : Buy Model 
  Created By  : Naveen Babu 01-12-2016
  Use of this module is Insert,Update,Fetch From table my sql dealer schema, master tables and mongo retrive data
*/
namespace App\model;
use App\model\mongomodel;
use App\model\commonmodel;
use App\model\schemaconnection;
use Illuminate\Database\Eloquent\Model;
use Config;
use DB;
use Session;

class buyymodel extends Model
{

    /*
    *The Function mongoListingFetch used to fetchdetails from mongo with paginate
    */
    public static function mongoListingFetch($id,$wherecondition,$orwherecondition){
        $paginatenolisting        = Config::get('common.paginatenolisting');
        $dealer_id                = intval($id);
        //where('dealer_id','<>',$id)                                    ->
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
                                                if($value[1]!='Above')
                                                {
                                                    $q->wherebetween($key, $value);
                                                }
                                                else
                                                {
                                                    $q->where($key,'>', $value[0]);
                                                }
                                            }
                                            else if($key=='notinlisting_id') {
                                                if(!empty($value))
                                                {
                                                    $q->wherenotin('listing_id', $value);
                                                }
                                            }
                                        }
                                    })->where(function($q) use ($orwherecondition){
                                        foreach($orwherecondition as $key => $value){                                          
                                              $q->orwhere($key,'like','%'.$value.'%');
                                           
                                        }
                                    })->where('dealer_id','<>',$dealer_id)
                                      ->where('listing_status','=','Active')
                                      ->orderBy('created_at', 'desc')
                                      ->paginate($paginatenolisting);  

        return $mongo_carlisting_details;
    }
    
    public static function mongoviewsavedcardetails($id,$wherecondition){
        $dealer_id          = 	intval($id);
        $mongo_carlisting_details = mongomodel::where(function($q) use ($wherecondition){
                                        foreach($wherecondition as $key => $value){
                                                if(!empty($value))
                                                {
                                                    $q->wherein('listing_id', $value);
                                                }
											}
                                            })->where('listing_status','=','Active')
										->where('dealer_id','<>',$dealer_id)
                                      ->orderBy('created_at', 'desc')
                                      ->get();  
        return $mongo_carlisting_details;
    }
    
    public static function mongoviewcardetails($id,$listingid){
        $dealer_id          		= 	intval($id);
        $mongo_carlisting_details 	= 	mongomodel::where('listing_id',$listingid)
                                      ->orderBy('created_at', 'desc')
                                      ->get();  
        return $mongo_carlisting_details;
    }
    
    public static function mongodealercardetails($delaerid){
		$dealer_id          		= 	intval($delaerid);
        $mongo_carlisting_details 	= 	mongomodel::where('dealer_id',$dealer_id)
										->where('listing_status','=','Active')
                                      ->orderBy('created_at', 'desc')
                                      ->get();  
        return $mongo_carlisting_details;
    }
    /*
    *The Function mongoListingFetch used to Count of vehicle type from *mongo 
    */
    public static function mongolistingtypecount($id,$wherecondition,$whereconditionsites=array(),$orwhereconditionsites=array()){
        $dealer_id                = intval($id);
        $mongo_carlisting_details = mongomodel::where($wherecondition)
                                                ->where('dealer_id','<>',$dealer_id)
                                                ->where('listing_status','=','Active')
                                                ->where(function($q) use ($whereconditionsites){
                                                    foreach($whereconditionsites as $key => $value){
                                                       if($key!='sell_price'&&$key!='notinlisting_id')
                                                        {
                                                            if(!empty($value))
                                                            {
                                                                $q->wherein($key, $value);
                                                            }
                                                        }
                                                        else if($key=='sell_price')
                                                        {
                                                            if($value[1]!='Above')
                                                            {
                                                                $q->wherebetween($key, $value);
                                                            }
                                                            else
                                                            {
                                                                $q->where($key,'>', $value[0]);
                                                            }
                                                        }
                                                    }
                                                })->where(function($q) use ($orwhereconditionsites){
                                                    foreach($orwhereconditionsites as $key => $value){                                          
                                                          $q->orwhere($key,'like','%'.$value.'%');
                                                       
                                                    }
                                                })->count();

        return $mongo_carlisting_details;
    }

    public static function mongolistingpricecount($id,$wherecondition,$whereconditionsites=array(),$orwhereconditionsites=array()){
        $dealer_id                = intval($id);
        $mongo_carlisting_details = mongomodel::wherebetween('sell_price',$wherecondition)
                                                ->where('dealer_id','<>',$dealer_id)
                                                ->where('listing_status','=','Active')
                                                ->where(function($q) use ($whereconditionsites){
                                                    foreach($whereconditionsites as $key => $value){
                                                       if($key!='sell_price'&&$key!='notinlisting_id')
                                                        {
                                                            if(!empty($value))
                                                            {
                                                                $q->wherein($key, $value);
                                                            }
                                                        }
                                                        else if($key=='sell_price')
                                                        {
                                                            if($value[1]!='Above')
                                                            {
                                                                $q->wherebetween($key, $value);
                                                            }
                                                            else
                                                            {
                                                                $q->where($key,'>', $value[0]);
                                                            }
                                                        }
                                                    }
                                                })          
                                                ->where(function($q) use ($orwhereconditionsites){
                                                    foreach($orwhereconditionsites as $key => $value){                                          
                                                          $q->orwhere($key,'like','%'.$value.'%');
                                                       
                                                    }
                                                })
                                                ->count();

        return $mongo_carlisting_details;
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
                                    })->orderBy('created_at', 'desc')
                                      ->get();  

        return $mongo_carlisting_details;
    }
    /*The Function dealerInsertTable used to Insert of param details
    of dealers schema table
    */
    public static function dealerInsertTable($id,$dealer_schemaname,$tablename,$insertrecord){

        commonmodel::doschemachange($dealer_schemaname);
        $insertwithid = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)
                                            ->insertGetId($insertrecord);      
        return $insertwithid; 
    }

    /*The Function dealerInsertTable used to Insert of param details
    of dealers schema table
    */
    public static function dealerInsertToTable($id,$dealer_schemaname,$tablename,$insertrecord){

        Config::set('database.connections.dmsmysql2.database',$dealer_schemaname);
        $insertwithid = DB::connection('dmsmysql2')
                                            ->table($tablename)
                                            ->insertGetId($insertrecord);      
        return $insertwithid; 
    }
    public static function dealerUpdateToTable($id,$dealer_schemaname,$tablename,$where,$updatedata){

        Config::set('database.connections.dmsmysql2.database',$dealer_schemaname);
        $insertwithid = DB::connection('dmsmysql2')
                                            ->table($tablename)
                                            ->where($where)
                                            ->update($updatedata);      
        return $insertwithid; 
    }
    /*The Function dealerFetchTableDetails used to Fetch of param details of dealers schema table
    */
    public static function dealerFetchTableDetails($id,$dealer_schemaname,$tablename,$wherecondition){  
        commonmodel::doschemachange($dealer_schemaname);
        $get_fetch_table_details = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)
                                            ->where($wherecondition)
                                            ->get();       
        return $get_fetch_table_details; 
    }
	
	public static function dealergetToschemaTable($dealer_schemaname,$tablename,$whare){

        Config::set('database.connections.dmsmysql2.database',$dealer_schemaname);
        $insertwithid = DB::connection('dmsmysql2')
                                            ->table($tablename)
                                            ->where($whare)
                                            ->get();       
        return $insertwithid; 
    }
    
    /*The Function dealerFetchTableDetails used to Fetch of param details of dealers schema table with paginate
    */
    public static function dealerFetchTableDetailswithpaginate($id,$dealer_schemaname,$tablename,$wherecondition)
    { 
        commonmodel::doschemachange($dealer_schemaname);
        $get_fetch_table_details = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)
                                            ->where($wherecondition)
                                            ->paginate(10);       
        return $get_fetch_table_details; 
    }
    /*The Function dealerFetchTableDetails used to Fetch of param details of dealers schema table
    */
    public static function dealerFetchDetails($id,$dealer_schemaname,$tablename){  
        commonmodel::doschemachange($dealer_schemaname);
        $get_fetch_table_details = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)
                                            ->get();       
        return $get_fetch_table_details; 
    }
    
    /*The Function dealerFetchTableDetails used to Fetch of param details of dealers schema table
    */
    public static function dealerFetchDetailsoffsetandlimit($id,$dealer_schemaname,$tablename,$where,$offset){  
        commonmodel::doschemachange($dealer_schemaname);
        $get_fetch_table_details = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)
                                            ->where($where)
                                            ->limit(10)
                                            ->offset($offset)
                                            ->orderby('thread_id','desc')
                                            ->get();       
        return $get_fetch_table_details; 
    }
    /*The Function dealerFetchTableDetails used to Fetch of param details of dealers schema table
    */
    public static function dealerFetchTableDetailsnotwhere($id,$dealer_schemaname,$tablename,$wherecondition){  
        commonmodel::doschemachange($dealer_schemaname);
        $get_fetch_table_details = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)
                                            ->where($wherecondition)
                                            ->where('status','<>',2)
                                            ->where('status','<>',3)
                                            ->get();       
        return $get_fetch_table_details; 
    }
    
    /*The Function dealerFetchTableDetails used to Fetch of param details of dealers schema table
    */
    public static function dealerFetchfreshTableDetailsnotwhere($id,$dealer_schemaname,$tablename,$wherecondition){  
        commonmodel::doschemachange($dealer_schemaname);
        $get_fetch_table_details = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)
                                            ->where($wherecondition)
                                            ->where('ticket_status','<>','Completed')
                                            ->get();       
        return $get_fetch_table_details; 
    }
    /*The Function dealerTableCount used to Count of param details of dealers schema table
    */
    public static function dealerTableCount($id,$dealer_schemaname,$tablename,$wherecondition){        
        commonmodel::doschemachange($dealer_schemaname);
        $get_fetch_table_count = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)
                                            ->where($wherecondition)
                                            ->count();       
        return $get_fetch_table_count; 
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
    
    
    /*The Function dealerBiddingTableDetails used to Bidding Details
    */
    public static function dealerBiddingTableDetails($id,$dealer_schemaname,$tablename,$wherecondition){  
        commonmodel::doschemachange($dealer_schemaname);      
        $get_fetch_table_details = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)
                                            ->where($wherecondition)
                                            ->groupBy('user_id')
                                            ->orderBy('delear_datetime','DESC')
                                            ->get();       
        return $get_fetch_table_details; 
    }
    /*The Function dealerBiddingTableCount used to Count Bidding Details
    */
    public static function dealerBiddingTableCount($id,$dealer_schemaname,$tablename,$wherecondition){  
        commonmodel::doschemachange($dealer_schemaname);      
        $get_fetch_table_details = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)
                                            ->where($wherecondition)
                                            ->groupBy('user_id')
                                            ->get();       
        return $get_fetch_table_details; 
    }
    /*The Function dealerQueriesDetail used to Queries Details
    */
    public static function dealerQueriesDetail($dealer_schemaname){  
        commonmodel::doschemachange($dealer_schemaname); 
        $id = session::get('ses_id');
        $queryfetch = schemaconnection::dmsmysqlconnection()
                            ->table('dealer_contact_message_transactions')
                            ->whereNotIn('car_id',function($query)use($id){
                                $query -> select('duplicate_id')
                                -> from('dms_car_listings')
                                -> where('duplicate_id','<>','NULL')
                                -> where('dealer_id',$id);
                                })
                            ->groupBy('contact_transactioncode')
                            ->orderBy('thread_id','DESC')
                            ->paginate(10);       
        return $queryfetch; 
    }
    //api queries funtion
    public static function doApidealerQueriesDetail($id,$dealer_schemaname){  
        commonmodel::doschemachange($dealer_schemaname); 
        
        $queryfetch = schemaconnection::dmsmysqlconnection()
                            ->table('dealer_contact_message_transactions')
                            ->whereNotIn('car_id',function($query)use($id){
                                $query -> select('duplicate_id')
                                -> from('dms_car_listings')
                                -> where('duplicate_id','<>','NULL')
                                -> where('dealer_id',$id);
                                })
                            ->groupBy('contact_transactioncode')
                            ->orderBy('thread_id')
                            ->get();       
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

    public static function dumm_fuction($dealer_schemaname,$wherecondition){  
        commonmodel::doschemachange($dealer_schemaname);      
        $queryfetch = schemaconnection::dmsmysqlconnection()
                            ->table('dealer_contact_message_transactions')
                            ->where($wherecondition)
                            ->orderBy('thread_id','desc')
                            ->first();       
        return $queryfetch; 
    }
    /*The Function dealerFundingDetail used to Funding Details
    */
    public static function dealerFundingDetail($dealer_schemaname){  
        commonmodel::doschemachange($dealer_schemaname);      
        $queryfetch = schemaconnection::dmsmysqlconnection()
                                        ->table('dealer_funding_details')
                                        ->get();       
        return $queryfetch; 
    }
    /*The Function dealerBiddingDetail used to Bidding Details
    */
    public static function dealerBiddingDetail($dealer_schemaname){  
        commonmodel::doschemachange($dealer_schemaname);      
        
        $queryfetch = schemaconnection::dmsmysqlconnection()
                            ->table('dealer_bidding_details')->where('thread_id', DB::raw("(select max(`thread_id`) from dealer_bidding_details)"))
                            ->groupBy('car_id')
                            ->get();       
        return $queryfetch; 
    }
    
    /*The Function get dealerBiddingDetail for current user Bidding Details
    */
    public static function dealerBiddingcurrentDetail($userid){  
        $queryfetch = schemaconnection::masterconnection()
                            ->table('dealer_bidding_details')
                            ->select(DB::raw('dealer_id,max(bidded_amount) as bidamount,car_id'))
                            ->where('user_id',$userid)
                            ->groupBy('car_id')
                            ->get();       
        return $queryfetch; 
    }

    public static function dealerRecentDetails($id,$dealer_schemaname){  
        commonmodel::doschemachange($dealer_schemaname); 
        $queryfetch = schemaconnection::dmsmysqlconnection()
                            ->table('dealer_viewed_cars')
                            ->where('dealer_id',$id)
                            ->orderBy('auto_id', 'desc')
                            ->groupby('car_id')
                            ->take(10)
                            ->get();   
        return $queryfetch; 
    }

    public static function dealer_recent_count($id,$dealer_schemaname){  
        commonmodel::doschemachange($dealer_schemaname); 
        $queryfetch = schemaconnection::dmsmysqlconnection()
                            ->table('dealer_viewed_cars')
                            ->where('dealer_id',$id)
                            ->orderBy('auto_id', 'desc')
                            ->groupby('car_id')
                            ->take(10)
                            ->get();   
        return count($queryfetch); 
    }

    /*The Function masterBiddingDetail used to all dealer Bidding Details
    */
    public static function masterBiddingDetail($wherecondition){  
        
        $queryfetch = schemaconnection::masterconnection()
            ->table('dealer_bidding_details')
            ->where($wherecondition)
            ->groupBy('user_id')
            ->orderBy('delear_datetime','DESC')
            ->get();        
         
        return $queryfetch; 
    }
    /*The Function masterBiddingCount used to Count dealer Bidding Details
    */
    public static function masterBiddingCount($wherecondition){  
        
        $count = schemaconnection::masterconnection()
                            ->table('dealer_bidding_details')
                            ->where($wherecondition)
                            ->count();
         
        return $count; 
    }
    /*The Function masterBiddingDetail order by amount to all dealer Bidding Details
    */
    public static function masterBiddingamountDetail($where)
    {  
        $queryfetch = schemaconnection::masterconnection()  
        //$queryfetch = schemaconnection::dmsmysqlconnection()
                            ->table('dealer_bidding_details')
                            ->select(DB::raw('user_id,max(bidded_amount) as amount,created_date'))
                            ->where($where)
                            ->groupBy('user_id')
                            ->orderBy('amount','desc')
                            ->get();       
        return $queryfetch; 
    }
     /*The Function dealerBiddingDetail used to get max bid amount Details
    */
    public static function dealermaxbiddingamountdetail($wherecon){  
              
        $queryfetch = schemaconnection::masterconnection()
                            ->table('dealer_bidding_details')
                            ->select(DB::raw('max(bidded_amount) as amount'))
                            ->where($wherecon)
                            ->get();
        return $queryfetch; 
    }
     /*The Function used to get masterBiddingDetail
    */
    public static function masterbiddingdetailtable($wherecondition){  
              
        $queryfetch = schemaconnection::masterconnection()
                            ->table('dealer_bidding_details')
                            ->where($wherecondition)
                            ->get();       
        return $queryfetch; 
    }
    /*The Function masterBidCount used to Count Bidding Details
    */
    public static function masterBidCount($wherecondition){  
        
        $count = schemaconnection::masterconnection()
                            ->table('dealer_bidding_details')
                            ->where($wherecondition)
                            ->groupBy('user_id')
                            ->count();
         
        return $count; 
    }
    /*The Function masterVariantDetail used to Update bidding details
    */
    public static function masterupdatebiddingDetail($wherecondition,$settabledata)
    {
        $queryfetch = schemaconnection::masterconnection()
                    ->table('dealer_bidding_details')
                    ->where($wherecondition)
                    ->update($settabledata);  
		return $queryfetch;
    }
    /*The Function masterVariantDetail used to Variant details
    */
    public static function masterVariantDetail($wherecondition)
    {
        $queryfetch = schemaconnection::masterconnection()
                    ->table('master_car_features')
                    ->where($wherecondition)
                    ->first();
         
        return $queryfetch;
    }
    /*The Function masterInsertTable used to Insert of param details
    of Master table
    */
    public static function masterInsertTable($id,$tablename,$insertrecord){
        $insertwithid = schemaconnection::masterconnection()
                                            ->table($tablename)
                                            ->insertGetId($insertrecord);      
        return $insertwithid; 
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

    public static function masterFetchTablecount($tablename,$wherecondition){

        $get_fetch_table_details = schemaconnection::masterconnection()
                                            ->table($tablename)
                                            ->where($wherecondition)
                                            ->count();       
        return $get_fetch_table_details;
    }
    
    public static function masterFetchTableDelete($tablename,$wherecondition){

        $get_fetch_table_details = schemaconnection::masterconnection()
                                            ->table($tablename)
                                            ->where($wherecondition)
                                            ->delete();       
        return $get_fetch_table_details;
    }

    public static function masterFetchtablerecords($tablename){

        $get_fetch_table_details = schemaconnection::masterconnection()
                                            ->table($tablename)
                                            ->get();       
        return $get_fetch_table_details; 
        
    }


    public static function masterfetchautocomplete($term){

        $get_fetch_table_details = schemaconnection::masterconnection()
                                            ->table('master_city')
                                            ->where('city_name','like','%'.$term.'%')
                                            ->take(10)
                                            ->get();       
        return $get_fetch_table_details; 
    }
    
    //API FUNCTION SEARCH BASED ON CAR SITES AND CAR CITY
    public static function doMongofetchCity($id,$listing_orwherecondition,
											$orwherecondition,
											$sortcategory,$sortbyfield)
	{
		$dealer_id             = 	intval($id);
		$mongo_carlisting_details = 	mongomodel::where(function($q) use ($listing_orwherecondition){
									foreach($listing_orwherecondition as $key => $value){
											if($key!= 'sell_price')
											{
												if(!empty($value))
												{
													$q->wherein($key, $value);
												}
											}
											else if($key=='sell_price')
                                            {
												$q->whereBetween($key, $value);
                                            }
									}
								})->where(function($q) use ($orwherecondition){
									foreach($orwherecondition as $key => $value){
											if(!empty($value))
											{
												$q->orwhere($key,'LIKE', '%'.$value.'%');
											}
									}
								})->where('dealer_id','<>',$dealer_id)
                                ->where('listing_status','=','Active')
                                ->orderBy('created_at', 'desc')
                                ->get();

        return $mongo_carlisting_details;
		
    }
    
    //API FUNCTION SEARCH BASED ON  TAG
    public static function doSearchMongofetchcompare($id,$wherecondition,$likewherecondition,$sortcategory,$sortbyfield)
	{
		$dealer_id             		= 	intval($id);
		$mongo_carlisting_details 	= 	mongomodel::where(function($q) use ($wherecondition){
											foreach($wherecondition as $key => $value){
											if($key	!=	'sell_price' && !empty($value) && count($value) >= 1)
											{
												foreach($value as $tagsearchvalue)
												{
													if($tagsearchvalue != "")
													{
														$q->where($key, $tagsearchvalue);
													}
												}											  
											}
										}
										})->where('dealer_id','<>',$dealer_id)
										->where('listing_status','=','Active')
										->orderBy($sortcategory, $sortbyfield)
										->orderBy('created_at', 'desc')
										->get(); 
        return $mongo_carlisting_details;
		
    }
    
     //API FUNCTION SEARCH BASED ON  TAG
    public static function doSearchMongofetchtag($id,$wherecondition,$likewherecondition,$sortcategory,$sortbyfield)
	{
		$dealer_id             		= 	intval($id);
		$mongo_carlisting_details 	= 	mongomodel::where(function($q) use ($wherecondition){
											foreach($wherecondition as $key => $value){
											if($key	!=	'sell_price' && !empty($value) && count($value) >= 1)
											{
												$q->wherein($key, $value);
											}
											else if($key	==	'sell_price')
											{
												if(!empty($value))
												{
													if($value[1]!='<')
													{
														$q->wherebetween($key, [$value[0],$value[1]]);
													}
													else
													{
														$q->where($key,'>', $value[0]);
													}
												}
											}
										}
										})->where(function($q) use ($likewherecondition){
                                        foreach($likewherecondition as $key => $value){
											foreach($value as $searchvalue)
												{                                          
												$q->orwhere($key,'like','%'.$searchvalue.'%');
											}
                                        }
                                        })->where('dealer_id','<>',$dealer_id)
										->where('listing_status','=','Active')
										->orderBy('created_at', 'desc')
										->get(); 
        return $mongo_carlisting_details;
		
    }
    
     //API FUNCTION SEARCH BASED ON FILTERS
    public static function doSearchMongofetchfilter($id,$wherecondition,$sortcategory,$sortbyfield)
	{
		$dealer_id             		= 	intval($id);
		$mongo_carlisting_details 	= 	mongomodel::where(function($q) use ($wherecondition){
											foreach($wherecondition as $key => $value){
											if(!empty($value))
											{
												if($key	!=	'sell_price')
												{
													$q->wherein($key, $value);
												}
												else if($key	==	'sell_price' && !empty($value) && $value[0][1] != '<')
												{
													$q->wherebetween($key, [$value[0][0],$value[0][1]]);
												}
												else
												{
													$q->where($key,'>', $value[0][0]);
												}												
											}
										}
										})->where('dealer_id','<>',$dealer_id)
										->where('listing_status','=','Active')
										->orderBy('created_at', 'desc')
										->get(); 
        return $mongo_carlisting_details;
		
    }
    
     //API FUNCTION SEARCH BASED ON FILTERS AND TAG
    public static function doSearchgetallMongofetch($id,$sortcategory,$sortbyfield)
	{
		$dealer_id             		= 	intval($id);
		$mongo_carlisting_details 	= 	mongomodel::where('dealer_id','<>',$dealer_id)
										->where('listing_status','=','Active')
										->orderBy('created_at', 'desc')
										->get(); 

        return $mongo_carlisting_details;
		
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
    
    /*
    *The Function mongoListingFetch used to fetchdetails from mongo filter
    */
    public static function mongoFetchfilter(){
        $mongo_carlisting_details = mongomodel::select('sitename')->groupby('sitename')->count();
        return $mongo_carlisting_details;
    }

    public static function pricebetween($value){
        $mongo_carlisting_details = schemaconnection::masterconnection()
                                            ->table('master_budget_varient')
                                            ->where('min_value','<=',$value)
                                            ->where('max_value','>',$value)
                                            ->get();     
        return $mongo_carlisting_details;
    }

    public static function pricebetweenformarketing($value){
        $mongo_carlisting_details = schemaconnection::masterconnection()
                                            ->table('parameter_option_scoring')
                                            ->where('parameter_id',4)
                                            ->where('option_value','<=',$value)
                                            ->where('option_value_2','>',$value)
                                            ->get();     
        return $mongo_carlisting_details;
    }
    //THIS FUNCTION USED FOR CHECK WHEREIN RECORDS IN MASTER CONNECTION
     public static function dealerFetchWherein($tablename,$field,$where){  
        $queryfetch = schemaconnection::masterconnection()
                                            ->table($tablename)
                                            ->wherein($field,$where)
                                            ->get();       
        return $queryfetch; 
    }

}
