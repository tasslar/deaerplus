<?php

/*
	Module Name : Fast Lane API 
  	Created By  : Ahila 06-04-2017
  	Use of this module is Fetching With Reg No.
*/
namespace App\model;
use DB;
use Config;
use Response;
use Illuminate\Database\Eloquent\Model;

class fastlane extends Model
{
	public static function fetch_vehicle_detail($regno='')
	{
		$url = "https://web.fastlaneindia.com/vin/api/v1.2/vehicle?regn_no=".$regno;
        $ch = curl_init();
        $userid = "N009PROD1";
        $pwd = base64_decode("bjlwMWNsYkA3MjQ=");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . base64_encode($userid.":".$pwd),'Accept: application/json'));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST,'DHE-RSA-AES256-SHA');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $content = curl_exec( $ch );
        $errmsg  = curl_error( $ch );
        //print_r($content);
        curl_close($ch);
        return $content;
	} 

}