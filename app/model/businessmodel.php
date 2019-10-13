<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use Config;
use DB;
use Session;
use App\model\schemaconnection;

class businessmodel extends Model
 {
 	public static function company_type()
	{		
		$company_type = schemaconnection::masterconnection()->table('master_company_type')->get();
		return $company_type;
	}
	public static function lineof_business()
	{		
		$lineof_business = schemaconnection::masterconnection()->table('master_lineof_business')->get();
		return $lineof_business;
	}
	public static function car_listings()
	{
		$id = session::get('ses_id');			
		$fetchupdate = DB::connection('mastermysql')->table('dms_dealers')->where('d_id',$id)->get();
		$connection = $fetchupdate[0]->dealer_schema_name;		
		Config::set('database.connections.dmsmysql.database', $connection);
		$table = 'dms_car_listings';		
		$manage_branch = DB::connection('dmsmysql')->table($table);
		return $manage_branch;
	}
	public static function car_listings_images()
	{
		$id = session::get('ses_id');			
		$fetchupdate = DB::connection('mastermysql')->table('dms_dealers')->where('d_id',$id)->get();
		$connection = $fetchupdate[0]->dealer_schema_name;		
		Config::set('database.connections.dmsmysql.database', $connection);
		$table = 'dms_car_listings_photos';		
		$manage_branch = DB::connection('dmsmysql')->table($table);
		return $manage_branch;
	}	
	public static function dealercar_listings_images($dealer_id)
	{
		$id = session::get('ses_id');			
		$fetchupdate = DB::connection('mastermysql')->table('dms_dealers')->where('d_id',$dealer_id)->get();
		$connection = $fetchupdate[0]->dealer_schema_name;		
		Config::set('database.connections.dmsmysql.database', $connection);
		$table = 'dms_car_listings_photos';		
		$manage_branch = DB::connection('dmsmysql')->table($table);
		return $manage_branch;
	}			
	public static function business_domain($check_name)
	{
		$business_domain = schemaconnection::masterconnection()->table('dms_dealers')->where('profile_name',$check_name)->where('d_id','!',session::get('ses_id'))->count();  
		return $business_domain;
	}
	public static function documents_table_insert($dealer_schemaname,$table,$insertrecord)
    {
        commonmodel::doschemachange($dealer_schemaname);
        $last_id = schemaconnection::dmsmysqlconnection()
                                            ->table($table)
                                            ->insertGetId($insertrecord);
        $document_link = schemaconnection::dmsmysqlconnection()
                                            ->table($table)
                                            ->where('id',$last_id)
                                            ->first();
			$document = array(
								'link'      => $document_link->file_url,
								'filename'  => $document_link->file_name
							);                                            
        return $document; 
    }
    public static function documents_update($dealer_schemaname,$table,$insertrecord,$file_id)
    {
    	commonmodel::doschemachange($dealer_schemaname);
        $last_id = schemaconnection::dmsmysqlconnection()
                                            ->table($table)
                                            ->where('file_id',$file_id)
                                            ->update($insertrecord);
        $document_link = schemaconnection::dmsmysqlconnection()
                                            ->table($table)
                                            ->where('file_id',$file_id)
                                            ->first();
			$document = array(
								'link'      => $document_link->file_url,
								'filename'  => $document_link->file_name
							);                                            
        return $document;
    }
    public static function documents_count($dealer_schemaname,$table,$file_id)
    {
    	commonmodel::doschemachange($dealer_schemaname);
        $documents_count = schemaconnection::dmsmysqlconnection()
                                            ->table($table)
                                            ->where('file_id',$file_id)
                                            ->count();
        return $documents_count;
    }
    public static function dealercar_listings($dealer_id)
	{
		$id = session::get('ses_id');			
		$fetchupdate = DB::connection('mastermysql')->table('dms_dealers')->where('d_id',$dealer_id)->get();
		$connection = $fetchupdate[0]->dealer_schema_name;		
		Config::set('database.connections.dmsmysql.database', $connection);
		$table = 'dms_car_listings';		
		$manage_branch = DB::connection('dmsmysql')->table($table);
		return $manage_branch;
	}
    public static function documents_get($dealer_schemaname,$table,$file_id)
    {
    	commonmodel::doschemachange($dealer_schemaname);
        $documents_get = schemaconnection::dmsmysqlconnection()
                                            ->table($table)
                                            ->where($file_id)                               
                                            ->first();
        return $documents_get;
    }	

 }