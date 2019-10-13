<?php
/*
  Module Name : API Model 
  Created By  : VINOTH 27-12-2016
  This model is user for user login authentication and retrive user details return json data...
*/
namespace App\model;
use Illuminate\Database\Eloquent\Model;
use App\model\dealermodel;
use App\model\commonmodel;
use Config;
use DB;
use Session;

class apimodel extends Model
{
    public function __construct()
    {
        Config::set('database.connections.dmsmysql.database', session::get('dealer_schema_name'));
    }
    public static function checkEmailidExist($emailid,$userpassword)
    {
		$useremailid      =   dealermodel::selectRaw("Count(*) as Total")
                                                ->where('d_email',"=",$emailid)
                                                ->where('d_password',"=",$userpassword)
                                                ->first();
        if($useremailid->Total > 0)
        {
			$getuserresult =   dealermodel::select('dealer_name',
                                                  'd_password','d_id',
                                                  'd_email',
                                                  'dealership_name',
                                                  'dealer_schema_name',
                                                  'd_mobile',
                                                  'd_city',
                                                  'parent_id',
                                                  'logo')
                                                  ->where('d_email',"=",$emailid)
                                                  ->first();
			return $getuserresult;
		}
		else
		{
			return false;
		}   
	}
	public static function getCityAndState($cityid)
	{
        $resultcity    = DB::connection('mastermysql')->table('master_city')
                                            ->leftJoin('master_state','master_state.id', '=','master_city.state_id')
                                            ->where('master_city.master_id',$cityid)->get();
        return $resultcity; 
	}
	public static function searchcityname($cityid)
	{
        $resultcity    = DB::connection('mastermysql')->table('master_city')
                                            ->where('city_name',$cityid)->get();
        return $resultcity; 
	}
	public static function checkUserEmailidExist($emailid)
    {
		$useremailid      =   dealermodel::selectRaw("Count(*) as Emailid")
                                                ->where('d_email',"=",$emailid)
                                                ->first();
		return $useremailid;
	}

	public static function checkUserNameExist($wherecondition)
    {
		$useremailid      =   dealermodel::selectRaw("Count(*) as username")
                                                ->where($wherecondition)
                                                ->first();
		return $useremailid;
	}
	public static function getUserInformation($emailid)
    {
		$useremailid      =   DB::table("dms_dealers")
                                                ->where('d_email',"=",$emailid)
                                                ->first();
		return $useremailid;
	}
	public static function updateEmailStatus($whereemailid,$wherestatus)
    {
		$dms_email_update	=	dealermodel::where($whereemailid)->update($wherestatus);
		return $dms_email_update;
	}
	public static function deleteuserbydealer($whereemailid)
    {
		$dms_email_update	=	dealermodel::where($whereemailid)->delete();
		return $dms_email_update;
	}
	public static function checkUserIdExist($userid)
    {
		$usercurrentid      =   dealermodel::select('d_password',
													'd_id',
													'd_city',
													'dealership_name',
													'dealer_schema_name',
													'dealer_name',
													'parent_id',
													'd_mobile','d_email',
													'logo')
                                                ->where('d_id',"=",$userid)
                                                ->first();
		return $usercurrentid;
	}
	public static function checkUserPassword($userid)
    {
		$checkpassword 		=	dealermodel::select('d_password')
											->where('d_id',"=",$userid)
											->first();
		return $checkpassword;
	}
	
	public static function dealerFetchDetails($dealer_schemaname,$tablename){  
        commonmodel::doschemachange($dealer_schemaname);
        $get_fetch_table_details = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)
                                            ->get();       
        return $get_fetch_table_details; 
    }
	 
}
