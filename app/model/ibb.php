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

class ibb extends Model
{
	public static function ibbprice($longUrl='')
	{
		    $apikey = 'tNeqXRtxPYHdL5n4RgHVRV1X4D0777I8VgSGyeLg';
        $postData = array('for' => 'cprice',
                  'month'=>'0',
                  'year'=>'2010',
                  'make'=>'Maruti Suzuki',
                  'model'=>'Alto 800',
                  'variant'=>'LXI',
                  'location'=>'Chennai',
                  'kilometer'=>'1000',
                  'owner'=>'2',
                  'color'=>'white',
                  "userid"=>"CholaDMS"
                );
        $jsonData = json_encode($postData);

        $curlObj = curl_init();

        curl_setopt($curlObj, CURLOPT_URL, 'http://partner.stageibb.com/api/CholaDMS?access_token=tNeqXRtxPYHdL5n4RgHVRV1X4D0777I8VgSGyeLg');
        curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curlObj, CURLOPT_HEADER, 0);
        curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/text'));
        curl_setopt($curlObj, CURLOPT_POST, 1);
        curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData);

        $response = curl_exec($curlObj);

        // Change the response json string to object
        //$json = json_decode($response);

        curl_close($curlObj);
		    return $response;        
	} 
	
	public static function DoApiibbprice($year,$makename,$model_name,$variant_name,$city_name,$kilometer,$owner,$color)
	{
		$apikey 	= 	'tNeqXRtxPYHdL5n4RgHVRV1X4D0777I8VgSGyeLg';
        $postData 	= 	array('for' => 'cprice',
							  'month'=>'0',
							  'year'=>$year,
							  'make'=>$makename,
							  'model'=>$model_name,
							  'variant'=>$variant_name,
							  'location'=>$city_name,
							  'kilometer'=>$kilometer,
							  'owner'=>$owner,
							  'color'=>$color,
							  "userid"=>"CholaDMS"
							);
        $jsonData = json_encode($postData);

        $curlObj = curl_init();

        curl_setopt($curlObj, CURLOPT_URL, 'http://partner.stageibb.com/api/CholaDMS?access_token=tNeqXRtxPYHdL5n4RgHVRV1X4D0777I8VgSGyeLg');
        curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curlObj, CURLOPT_HEADER, 0);
        curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/text'));
        curl_setopt($curlObj, CURLOPT_POST, 1);
        curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData);

        $response = curl_exec($curlObj);

        // Change the response json string to object
        //$json = json_decode($response);

        curl_close($curlObj);
		    return $response;        
	}

  public static function fetch_ibb_make($make_id)
  {
    $queryfetchdata  = '';
    $queryfetch = schemaconnection::masterconnection()
                                  ->table('master_makes')
                                  ->where('make_id',$make_id)
                                  ->get();        
    if(count($queryfetch)>0)
    {
      return $queryfetch[0]->ibb_make;
    }
    else
    {
      return $queryfetchdata;
    }
  }

  public static function fetch_ibb_model($model_id)
  {
    $queryfetchdata  = '';
    $queryfetch = schemaconnection::masterconnection()
                                  ->table('master_models')
                                  ->where('model_id',$model_id)
                                  ->get(); 

    if(count($queryfetch)>0)
    {
      return $queryfetch[0]->ibb_model;
    }
    else
    {
      return $queryfetchdata;
    }       
  }

  public static function fetch_ibb_variant($variant_id)
  {
    $queryfetchdata  = '';
    $queryfetch = schemaconnection::masterconnection()
                                  ->table('master_variants')
                                  ->where('variant_id',$variant_id)
                                  ->get(); 

    if(count($queryfetch)>0)
    {
      return $queryfetch[0]->ibb_variants;
    }
    else
    {
      return $queryfetchdata;
    }       
  }  

}
