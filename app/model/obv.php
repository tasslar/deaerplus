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

class obv extends Model
{
	public static function obvprice($longUrl='')
	{
        $postData = array('make'=>'maruti suzuki',
						'model'=>'swift',
						'year'=>'2014',
						'trim'=>'lxi',
						'location'=>'delhi',
						'kms_driven'=>'10000',
						'transaction_type'=>'s',
						'customer_type'=>'dealer',
						'key'=>'bdcbafc4ca86cc93da8ca497e7e11183'
                );
        $jsonData = json_encode($postData);
        //dd($jsonData);
        $curlObj = curl_init();

        curl_setopt($curlObj, CURLOPT_URL, "http://api.orangebookvalue.com/enterprise/v1/obv-price");
        curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
                                            'Connection: Keep-Alive'));
        curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlObj, CURLOPT_POST, 1);
        curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData);

        $response = curl_exec($curlObj);

        // Change the response json string to object
        //$json = json_decode($response);

        curl_close($curlObj);
		    return $response;        
	} 
	
	public static function DoApiobvprice($year,$makename,$model_name,$variant_name,$city_name,$kilometer,$owner,$color)
	{
        $postData = array('make'=>$makename,
						'model'=>$model_name,
						'year'=>$year,
						'trim'=>$variant_name,
						'location'=>$city_name,
						'kms_driven'=>$kilometer,
						'transaction_type'=>'s',
						'customer_type'=>'dealer',
						'key'=>'bdcbafc4ca86cc93da8ca497e7e11183'
                );

        $jsonData = json_encode($postData);
        //dd($jsonData);
        $curlObj = curl_init();

        curl_setopt($curlObj, CURLOPT_URL, "http://api.orangebookvalue.com/enterprise/v1/obv-price");
        curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
                                            'Connection: Keep-Alive'));
        curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
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
