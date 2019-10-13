<?php

/*
	Module Name : Sms Model 
  	Created By  : Ahila 01-12-2016
  	Use of this module is get sms template , send sms.
*/
namespace App\model;
use DB;
use Config;
use Response;


use Illuminate\Database\Eloquent\Model;

class smsmodel extends Model
{
	
	public 		$timestamps   		= false;
    protected 	$connection 		= 'dmsmysql';

	/* The function get_sms_templates get sms template 
	   From master_sms_templates.
	*/
	public static function get_sms_templates($sms_template_id)
	{

	        $smsdata=DB::table('master_sms_templates')
	        			->where('sms_type_id','=',$sms_template_id)
	        			->get();
	        return $smsdata;
	}

	public static function smsContentConstruct($sms_subject,$sms_message,$sms_params,$data)
    {       	
		$sms_params_explode = explode(",",$sms_params);			
		if(!empty($data))
		{
			if(!empty($sms_params_explode))
			{
				foreach ($sms_params_explode as $key => $value) 
				{
					$sms_message = str_replace($sms_params_explode[$key],$data[$key], $sms_message); 
					
				}
			}
			else
			{
				foreach ($data as $key => $value) 
				{
					$sms_message = str_replace("##".$key."##",$data[$key], $sms_message); 
					
				}
			}			
		}	
	    $data['sms_subject']  =  $sms_subject;
		$data['sms_message']  =  $sms_message;
		return $data;
	}

	public static function unicel($sms_data)
	{
		$tono=$sms_data['phone'];

		$mobiledata=$sms_data['sms_template_data'];
		foreach ($mobiledata as $row) 
		{
			$sms_subject=$row->sms_subject;
			$sms_message=$row->sms_message;
		}
	

		$smsurl = Config::get('common.smsurl');
		$smsvar1 = Config::get('common.smsvar1');
		$smsvar2 = Config::get('common.smsvar2');
		
		$ch=curl_init($url=sprintf($smsurl));
		$postvars=$smsvar1.$tono.$smsvar2.$sms_message;
	
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$postvars);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch,CURLOPT_TIMEOUT, 3);  
		$content = curl_exec($ch); 
		curl_close($ch);
	}

	public static function sendsms($sms_data)
	{
		$tono=$sms_data['phone'];
		$mobiledata=$sms_data['sms_template_data'];
		foreach ($mobiledata as $row) 
		{
			$sms_subject=$row->sms_subject;
			$sms_message=$row->sms_message;
		}
		$smsurl = 'http://193.105.74.159/api/v3/sendsms/plain?user=cargoji&password=FkBPlqnz&sender=DLRPLS&SMSText='.$sms_message.'&type=longsms&GSM=91'.$tono;
		$smsvar1 = '&type=longsms&GSM=';
		$smsvar2 = '&type=longsms&GSM=';		
		$ch=curl_init();
		//$postvars=$smsvar1.$sms_message.$smsvar2.$tono;
		//$sms_message='test wit var';
		curl_setopt($ch,CURLOPT_URL,'http://193.105.74.159/api/v3/sendsms/plain?user=cargoji&password=FkBPlqnz&sender=DLRPLS');
		curl_setopt($ch, CURLOPT_POSTFIELDS , 1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,'SMSText='.$sms_message.'&type=longsms&GSM=91'.$tono);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 7);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$content = curl_exec($ch); 
		curl_close($ch);

		//return $content;
	}

	public static function sendsmsarray($sms_data)
	{
		$tono=$sms_data['phone'];
		$mobiledata=$sms_data['sms_template_data'];
		
			$sms_subject=$mobiledata['sms_subject'];
			$sms_message=$mobiledata['sms_message'];
		
		$smsurl = 'http://193.105.74.159/api/v3/sendsms/plain?user=cargoji&password=FkBPlqnz&sender=DLRPLS&SMSText='.$sms_message.'&type=longsms&GSM=91'.$tono;
		$smsvar1 = '&type=longsms&GSM=';
		$smsvar2 = '&type=longsms&GSM=';		
		$ch=curl_init();
		//$postvars=$smsvar1.$sms_message.$smsvar2.$tono;
		//$sms_message='test wit var';
		curl_setopt($ch,CURLOPT_URL,'http://193.105.74.159/api/v3/sendsms/plain?user=cargoji&password=FkBPlqnz&sender=DLRPLS');
		curl_setopt($ch, CURLOPT_POSTFIELDS , 1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,'SMSText='.$sms_message.'&type=longsms&GSM=91'.$tono);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 7);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$content = curl_exec($ch); 
		curl_close($ch);

		//return $content;
	} 

}