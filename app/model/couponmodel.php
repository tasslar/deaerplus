<?php

/*
Module Name : Coupon 
Created By  : Ahila
Use of this module is manage dealer coupon detail
*/

namespace App\model;
use DB;
use config;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\model\schemaconnection;

class couponmodel extends Model
{
	public $timestamps = false;

	public static function fetchCoupon($ccode)
 	{
  
    $coupon_detail = DB::connection('mastermysql')
                     ->table('dealer_coupons')
                     ->where('coupon_code',$ccode)
                     ->get();
    return $coupon_detail;
    } 
    public static function couponCountUpdate($id,$count)
    {

        
        $updateid      =      DB::connection('mastermysql')
                                  ->table('dealer_coupons')
                                  ->where('coupon_id',$id)
                                  ->update(['coupon_times_used'=>$count]);
      return $updateid;        
    }
}
