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

class shortnerurl extends Model
{
	
	public 		$timestamps   		= false;
    protected 	$connection 		= 'dmsmysql';

	public static function shorturl($longUrl)
	{
		//$apiKey = 'AIzaSyD-irCCdNTZKdkZtW-2Ar_-SsGYfbh692Q';
		$apikey = 'AIzaSyBgZR5ry4sKdz3YCx1_WEFTivzT1H85whU';
		$longUrl = $longUrl;
		//$longUrl = 'https://www.facebook.com/dialog/share?app_id=140586622674265&display=popup&href=http%3A%2F%2Fapp.dealerplus.in%2Fdashboard&picture=https://s3-ap-southeast-1.amazonaws.com/dealerplus/uploadimages/dmschema_14876824222/photos/32342.jpg&title=Naveen&description=New%20Listing%20Car';
		$postData = array('longUrl' => $longUrl);
		$jsonData = json_encode($postData);

		$curlObj = curl_init();

		curl_setopt($curlObj, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url?key='.$apikey);
		curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curlObj, CURLOPT_HEADER, 0);
		curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
		curl_setopt($curlObj, CURLOPT_POST, 1);
		curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData);

		$response = curl_exec($curlObj);

		// Change the response json string to object
		$json = json_decode($response);

		curl_close($curlObj);
		return $json->id;
	} 

}