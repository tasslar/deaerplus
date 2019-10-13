<?php

namespace App\model;
use Illuminate\Database\Eloquent\Model;

class map extends Model
{
	//Use Google map to get lat and lon
	public static function get_lat_lon($address)
	{
        $prepAddr = str_replace(' ',' ',$address);
        
        $geo_data=array();
        $geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
        $geo = json_decode($geocode, true);
              
        if ($geo['status'] == 'OK') 
        {
		  
    	 $lat = $geo['results'][0]['geometry']['location']['lat'];
    	 $lon = $geo['results'][0]['geometry']['location']['lng'];
              
        }
        array_push($geo_data, $lat,$lon);        
        return $geo_data;

	}

}