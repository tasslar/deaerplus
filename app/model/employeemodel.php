<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use Config;
use DB;
use Session;

class employeemodel extends Model
{
	public static function employeetable()
	{
		$id = session::get('ses_id');
		$fetchupdate = DB::connection('mastermysql')->table('dms_dealers')->where('d_id',$id)->get();
		$connection = $fetchupdate[0]->dealer_schema_name;		
		Config::set('database.connections.dmsmysql.database', $connection);
		$table = 'dealer_employee_management';
		$emploee_table = DB::connection('dmsmysql')->table($table);
		return $emploee_table;	
	}
	public static function employeedocumenttable()
	{
		$id = session::get('ses_id');
		$fetchupdate = DB::connection('mastermysql')->table('dms_dealers')->where('d_id',$id)->get();
		$connection = $fetchupdate[0]->dealer_schema_name;		
		Config::set('database.connections.dmsmysql.database', $connection);
		$document = 'dealer_employee_document_management';
		$document_table = DB::connection('dmsmysql')->table($document);
		return $document_table;	
	}
	public static function employee_type()
	{
		$employee_type = DB::connection('mastermysql')->table('dealer_employee_type')->get();
		return $employee_type;
	}
}