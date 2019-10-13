<?php
/*
Module Name : Coupon 
Created By  : Ahila
Use of this module is manage dealer coupon details 

with scindia code changes
*/
namespace App\Http\Controllers;

use Session;
use Redirect;
use Config;
use Request;
use DB;
use Exception;
use Carbon\Carbon;
use App\model\usersmodel;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\model\billingmodel;
use App\model\commonmodel;
use App\model\couponmodel;
use App\Exceptions\CustomException;


class coupon extends Controller
{

	public function couponMatch()
	{
		$ccode   =  Request::input('c_val');
		$csubtot =  Request::input('c_subtot');
		$cpayamt = Request::input('c_payamt');
		$coupon_data  =  $this->couponValidate($ccode,$csubtot,$cpayamt);
		return \Response::json($coupon_data);;

	}
    public function getCoupon($coupon_value,$subtotal_amount,$cost_to_pay_now=0)
	{
		$coupon_res = $this->couponValidate($coupon_value,$subtotal_amount,$cost_to_pay_now);
		return $coupon_res;
	}
	public static function couponValidate($ccode,$csubtot,$cpayamt=0)
	{
		
		if (($csubtot == 0 )|| ($cpayamt ==0))
		{
			$message      =    config::get('common.invalid_coupon');
			$coupon_data  =    array(
                               'res_msg'=>0,
							   'validity'=>0,
                               'message'=>$message,
                                 'coupon_amt'=>0,
                             );

            return $coupon_data;
		}
		
	    try
		{

		$cdata   =  couponmodel::fetchCoupon($ccode);
		if(count($cdata)=="")
		{
			$message      =    config::get('common.invalid_coupon');
			$coupon_data  =    array(
                               'res_msg'=>0,
							   'validity'=>0,
                               'message'=>$message,
                                 'coupon_amt'=>0,
                             );

            return $coupon_data;
           
		}
		if($cdata[0]->coupon_validity == "Invalid")
		{
			$message      =  config::get('common.invalid_coupon');
			$coupon_data  =  array(
                                'res_msg'=>0,
								'validity'=>0,
                                'message'=>$message,
                                'coupon_amt'=>0,
                          
                             );

            return $coupon_data;
		}
		if(($cdata[0]->coupon_dealer_id != '') && ($cdata[0]->coupon_dealer_id !=0) && ($cdata[0]->coupon_dealer_id != Session::get('ses_id')))
		{
			$message      =    config::get('common.invalid_coupon');
			$coupon_data  =    array(
                                  'res_msg'=>0,
                                  'validity'=>0,
                                'message'=>$message,
                                'coupon_amt'=>0,
                                );

          return $coupon_data;
		}
		$today            =    Carbon::now();
		$c_startdate      =    $cdata[0]->coupon_start_date;
		$c_enddate        =    $cdata[0]->coupon_end_date;
		if(!($c_startdate<$today) && ($today<$c_enddate))
		{
			$message      =    config::get('common.coupon_expired_msg');
			$coupon_data  =    array(
                                  'res_msg'=>0,
                                  'validity'=>0,
                                'message'=>$message,
                                'coupon_amt'=>0,
                          
                                 );

        return $coupon_data;
		}	
		$c_usedcount       =       $cdata[0]->coupon_times_used;
		if($c_usedcount >= $cdata[0]->coupon_max_usage)
		{
			$message       =       config::get('common.invalid_coupon');
			$coupon_data   =  array(
                                 'res_msg'=>0,
                                 'validity'=>0,
                                'message'=>$message,
                                'coupon_amt'=>0,
                              );

           return $coupon_data;
		}

		if($csubtot < $cdata[0]->coupon_min_order_amount)
		{

			$message      =      config::get('common.coupon_minorder_msg');
			$coupon_data  =      array(
                                  'res_msg'=>0,
                                  'validity'=>0,
                                'message'=>$message,
                                'coupon_amt'=>0,
                          
                                 );

           return $coupon_data;
		}

		if(($cdata[0]->coupon_dealer_id == '') && ($cdata[0]->coupon_dealer_id ==0))
		{
			//echo "valid user";
		 	$coupon_data =  array(
	                      'res_msg'=>1,
	                      'validity'=>1,
						  'coupon_id'=>$cdata[0]->coupon_id,
                                'coupon_amt'=>$cdata[0]->coupon_amount,
	                   		'coupon_code'=>$cdata[0]->coupon_code,
	                   		);

		 	return $coupon_data;
		 
		}
		else if($cdata[0]->coupon_dealer_id == Session::get('ses_id'))
		{
			//echo "valid user";
		 	$coupon_data =  array(
	                      'res_msg'=>1,
	                      'validity'=>1,
                          'coupon_amt'=>$cdata[0]->coupon_amount,
	                      'coupon_code'=>$cdata[0]->coupon_code,
	                   		'coupon_id'=>$cdata[0]->coupon_id,
										  );

		 	return $coupon_data;	
		}
		else
		{
			$message         =      config::get('common.invalid_coupon');
			$coupon_data     =      array(
				                          'res_msg'=>0,
				                          'validity'=>0,
										  'message'=>$message,
		                                  'coupon_amt'=>0,
										  'coupon_code'=>$cdata[0]->coupon_code,
                                   		);

        	return $coupon_data;
		}

    }
    catch(Exception $e)
    {
    	throw new CustomException($e->getMessage());
    }	

		
	}//function ending

}