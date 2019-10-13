<?php

namespace App\model;
use DB;
use Session;
use Config;
use Illuminate\Database\Eloquent\Model;
use App\model\commonmodel;
use App\model\schemaconnection;

class dealermodel extends Model
{
	
    protected $connection = 'mastermysql';
    protected $table = 'dms_dealers';

   
public static function dealer_register($dealerdata)
{
    $dealer_id = schemaconnection::masterconnection()
                    ->table('dms_dealers')
                    ->insertGetId($dealerdata); 
    return $dealer_id;   
}
public static function dms_dealerTable()
{
    $dealer_id = schemaconnection::masterconnection()
                    ->table('dms_dealers');                    
    return $dealer_id;   
}

public static function dealerdetails_get($dealer_schemaname,$id)
{
        
    commonmodel::doschemachange($dealer_schemaname);
    $dealerdata      =      schemaconnection::dmsmysqlconnection()
                                  ->table('dms_dealerdetails')
                                  ->where('dealer_id',"=",$id)
                                  ->get();
      return $dealerdata;

}


public static function dealerdetails_update($dealer_schemaname,$updatedetails,$id)
{
    commonmodel::doschemachange($dealer_schemaname);
    $updatedata      =      schemaconnection::dmsmysqlconnection()
                                ->table('dms_dealerdetails')
                                ->where('dealer_id',"=",$id)
                                ->update($updatedetails);

    return $updatedata;

}

public static function dealer_schema_update($dealer_schemaname,$table,$where,$updatedetails)
{
    commonmodel::doschemachange($dealer_schemaname);
    $updatedata      =      schemaconnection::dmsmysqlconnection()
                                ->table($table)
                                ->where($where)
                                ->update($updatedetails);

    return $updatedata;

}

public static function dealerdetails_store($dealer_schemaname,$dealerdetails)
    {
       
        commonmodel::doschemachange($dealer_schemaname);
        $dealer_detail_id = schemaconnection::dmsmysqlconnection()
                              ->table('dms_dealerdetails')
                              ->insertGetId($dealerdetails);        
        return $dealer_detail_id; 

    }
    public static function user_accounts($dealer_schemaname,$dealerdetails)
    {
       
        commonmodel::doschemachange($dealer_schemaname);
        $dealer_detail_id = schemaconnection::dmsmysqlconnection()
                              ->table('user_account')
                              ->insertGetId($dealerdetails);        
        return $dealer_detail_id; 

    }
    public static function dealerfetch($id)
    {

    	$fetch_dealer = schemaconnection::masterconnection()
                          ->table('dms_dealers')
    					            ->where('d_id','=',$id)
                          ->get();

        
        return $fetch_dealer;
    }
    public static function dealer_search($search_value)
    {
      $paginatenolisting        = Config::get('common.paginatenolisting');
      $fetch_dealer = schemaconnection::masterconnection()
                          ->table('dms_dealers')
                          ->select("dealer_name","dealership_name","landline_no","fax_no","d_mobile","d_email","facebook_link","twitter_link","linkedin_link","logo","d_id","d_city")
                          ->where('d_id','!=',session::get('ses_id'))
                          ->where('dealer_name','like','%'.$search_value.'%')
                          ->paginate($paginatenolisting);

        
        return $fetch_dealer;
    }
    
    public static function doApidealersearch($id,$search_value)
    {
		$fetch_dealer 	= 	schemaconnection::masterconnection()
                          ->table('dms_dealers')
                          ->select("dealer_name","dealership_name","landline_no","fax_no","d_mobile","d_email","facebook_link","twitter_link","linkedin_link","logo","d_id","d_city")
                          ->where('d_id','<>',$id)
                          ->where('dealer_name','like','%'.$search_value.'%')
                          ->get();
        return $fetch_dealer;
    }
    
    public static function autocomplete($term)
    {
        $paginatenolisting        = Config::get('common.paginatenolisting');
        $fetch_dealer = schemaconnection::masterconnection()
                          ->table('dms_dealers')
                          ->select("dealer_name")
                          ->where('d_id','!=',session::get('ses_id'))
                          ->where('dealer_name','like','%'.$term.'%')
                          ->take(5)->get();                          
        
        return $fetch_dealer;

    }
    public static function dealer_city_count()
    {   
        $dealer_city   = schemaconnection::masterconnection()->table('master_city')                        
                        ->select('d_city','city_name',DB::raw('COUNT(*) as count'))
                        ->join('dms_dealers','dms_dealers.d_city','=','master_city.master_id')
                        ->groupBy('d_city','city_name')
                        ->get(); 
       return $dealer_city;
    }
    public static function dealer_search_count($search_value)
    {

      $fetch_dealer = schemaconnection::masterconnection()
                          ->table('dms_dealers')
                          ->select("dealer_name","dealership_name","landline_no","fax_no","d_mobile","d_email","facebook_link","twitter_link","linkedin_link","logo","d_id","d_city")
                           ->where('d_id','!=',session::get('ses_id'))
                          ->where('dealer_name','like','%'.$search_value.'%')
                          ->count();

        
        return $fetch_dealer;
    }
    
    public static function status_search($search_value)
    {
      $paginatenolisting        = Config::get('common.paginatenolisting');
      $status_search = schemaconnection::masterconnection()
                          ->table('dms_dealers')
                          ->select("dealer_name","dealership_name","landline_no","fax_no","d_mobile","d_email","facebook_link","twitter_link","linkedin_link","logo","d_id","d_city")
                          ->where('d_id','!=',session::get('ses_id'))
                          ->where('status',$search_value)                         
                          ->paginate($paginatenolisting);
        return $status_search;
    }
    public static function status_count($search_value)
    {
      $paginatenolisting        = Config::get('common.paginatenolisting');
      $status_search            = schemaconnection::masterconnection()
                                ->table('dms_dealers')
                                ->select("dealer_name","dealership_name","landline_no","fax_no","d_mobile","d_email","facebook_link","twitter_link","linkedin_link","logo","d_id","d_city")
                                ->where('d_id','!=',session::get('ses_id'))
                                ->where('status',$search_value)                         
                                ->paginate($paginatenolisting);
        return $status_search;
    }
    public static function status()
    {

      $active = schemaconnection::masterconnection()
                          ->table('dms_dealers')
                          ->select("dealer_name","dealership_name","landline_no","fax_no","d_mobile","d_email","facebook_link","twitter_link","linkedin_link","logo","d_id","d_city")
                          ->where('d_id','!=',session::get('ses_id'))
                          ->where('status',Config::get('common.dealer_status_1'))                         
                          ->count();
      $inactive = schemaconnection::masterconnection()
                          ->table('dms_dealers')
                          ->select("dealer_name","dealership_name","landline_no","fax_no","d_mobile","d_email","facebook_link","twitter_link","linkedin_link","logo","d_id","d_city")
                          ->where('d_id','!=',session::get('ses_id'))
                          ->where('status',Config::get('common.dealer_status_2'))                         
                          ->count();
      $status           = array(
                                  'active'  =>$active,

                                  'inactive'=>$inactive 
                              );
        return $status;
    }
    public static function dealer_hqbranch($dealer_schemaname,$tablename)
    {
        Config::set('database.connections.dmsmysql2.database',$dealer_schemaname);
        $headquarter = DB::connection('dmsmysql2')
                                            ->table($tablename)
                                            ->where('headquarter',1)
                                            ->first();
        if($headquarter)
        {
          return $headquarter;
        }                     
        else 
        {
          $headquarter = DB::connection('dmsmysql2')
                                            ->table($tablename)
                                            ->where('headquarter','!=',1)
                                            ->where('branch_id',Config::get('common.branches'))
                                            ->first();
          return $headquarter;
        }                         
    }
    public static function city_search_count($city_id,$status)
    {
      /*if($status && $city_id)
      {        
        $paginatenolisting        = Config::get('common.paginatenolisting');
        $fetch_dealer = schemaconnection::masterconnection()
                            ->table('dms_dealers')
                            ->select("dealer_name","dealership_name","landline_no","fax_no","d_mobile","d_email","facebook_link","twitter_link","linkedin_link","logo","d_id","d_city")
                            ->where('d_id','!=',session::get('ses_id'))
                            ->where('d_city',$city_id)    
                            ->where('status',$status)                      
                            ->paginate($paginatenolisting);

          
          return $fetch_dealer;
        }*/
        /*elseif($city_id && $status="")*/
        /*{*/                     
          $paginatenolisting        = Config::get('common.paginatenolisting');
          
          if ($city_id!=''&&$status!='') {
            $fetch_dealer = schemaconnection::masterconnection()
                            ->table('dms_dealers')
                            ->select("dealer_name","dealership_name","landline_no","fax_no","d_mobile","d_email","facebook_link","twitter_link","linkedin_link","logo","d_id","d_city")
                            ->where('d_id','!=',session::get('ses_id'))
                            ->where('d_city',$city_id)
                            ->where('status',$status)
                            ->paginate($paginatenolisting);                            
          }

          else if ($city_id==''&&$status!='') {
            $fetch_dealer = schemaconnection::masterconnection()
                            ->table('dms_dealers')
                            ->select("dealer_name","dealership_name","landline_no","fax_no","d_mobile","d_email","facebook_link","twitter_link","linkedin_link","logo","d_id","d_city")
                            ->where('d_id','!=',session::get('ses_id'))                            
                            ->where('status',$status)
                            ->paginate($paginatenolisting);                            
          }
          else if ($city_id!=''&&$status=='') {
            $fetch_dealer = schemaconnection::masterconnection()
                            ->table('dms_dealers')
                            ->select("dealer_name","dealership_name","landline_no","fax_no","d_mobile","d_email","facebook_link","twitter_link","linkedin_link","logo","d_id","d_city")
                            ->where('d_id','!=',session::get('ses_id'))                            
                            ->where('d_city',$city_id)
                            ->paginate($paginatenolisting);
          }
          else
          {
            $fetch_dealer = schemaconnection::masterconnection()
                            ->table('dms_dealers')
                            ->select("dealer_name","dealership_name","landline_no","fax_no","d_mobile","d_email","facebook_link","twitter_link","linkedin_link","logo","d_id","d_city")
                            ->where('d_id','!=',session::get('ses_id'))                            
                            ->paginate($paginatenolisting);                           
          }

          
          return $fetch_dealer;
        /*}*/
       /* else
        {          
          $paginatenolisting        = Config::get('common.paginatenolisting');
          $fetch_dealer = schemaconnection::masterconnection()
                            ->table('dms_dealers')
                            ->select("dealer_name","dealership_name","landline_no","fax_no","d_mobile","d_email","facebook_link","twitter_link","linkedin_link","logo","d_id","d_city")
                            ->where('d_id','!=',session::get('ses_id'))
                            ->where('status',$status)    
                            ->paginate($paginatenolisting);

          
           return $fetch_dealer;
        }*/
    }

    public static function primaryuser($id)
    {

        $fetch_primaryuser = schemaconnection::masterconnection()
                          ->table('dms_dealers')
                          ->where('d_id','=',$id)->where('parent_id','0')
                          ->first();

        
        return $fetch_primaryuser;
    }
    public static function dealerprofile($id)
    {      
        $dealerprofile = schemaconnection::masterconnection()
                          ->table('dms_dealers')
                          ->where('d_id','=',$id)
                          ->first();

        
        return $dealerprofile;
    }
    public static function parent_id($id)
    {
      if(!empty($id))
      {
		$dealerprofile = schemaconnection::masterconnection()
                          ->table('dms_dealers')
                          ->where('d_id','=',$id)
                          ->first();
         if(count($dealerprofile) >= 1)
         {         
			$parent_id     = 	$dealerprofile->parent_id;
			return $parent_id;
		 }
      }
        return false;
    }

    public static function dealerupdate($id,$updatedealer)
    {
        $updatedata      =      schemaconnection::masterconnection()
                                ->table('dms_dealers')
                                ->where('d_id',"=",$id)
                                ->update($updatedealer);

        return $updatedata;
    }
    public static function fetch_dealer()
    {
        $updatedata     =      schemaconnection::masterconnection()->table('dms_dealers');
        return $updatedata;
    }
    
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
    public static function primaryuser_id($id)
    {
        $updatedata      =      schemaconnection::masterconnection()
                                ->table('dms_dealers')
                                ->select('d_id')
                                ->where('d_id',$id)
                                ->first();

        return $updatedata;
    }
    //dealer plan details and expiary or not
    public static function DoCheckDealerplandetails($id,$expirystart,$expiryend)
    {
        $myPlan     = schemaconnection::masterconnection()
                        ->table('dealer_billing_details')
                        ->join('master_subscription_plans','master_subscription_plans.subscription_plan_id','=','dealer_billing_details.subscription_plan_id')
                        ->join('master_plans','master_plans.plan_type_id','=','master_subscription_plans.plan_type_id')
                        ->join('master_plan_features','master_plan_features.plan_type_id','=','master_plans.plan_type_id')
                        ->where('dealer_id',$id)
                        ->where('current_subscription','1')
                        ->where('subscription_start_date','>=',$expirystart)
                        ->where('subscription_end_date','<=',$expiryend)
                        ->where('feature_id','14')
                        ->get();
        return $myPlan;
    } 
}
