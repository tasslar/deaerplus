<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Session;
use Config;

class exportmodel extends Model
{
	public static function generatereport($exceldata,$sheetheading,$excelname,$mergecells)
	{
		Excel::create($excelname, function($excel) use($exceldata,$sheetheading,$excelname,$mergecells)
		{
			$excel->sheet($excelname, function($sheet) use($exceldata,$sheetheading,$mergecells)
			{
				$sheet->mergeCells($mergecells);
				$sheet->row(1, function ($row) 
				{
					$row->setFontSize(20);
					$row->setAlignment('center');
					$row->setFontColor('#000000');
				});
				//dd($sheetheading);
				$sheet->rows(array(array('')));
				$sheet->fromArray($exceldata);
				$sheet->row(1, array($sheetheading." ".date("Y/m/d")));
			});
		})->export('xls');
	}

	public static function getleadsource($leadsourceid)
	{
		if($leadsourceid == "1")
		{
			$name = 'Lead Source';
		}
		elseif($leadsourceid == "2")
		{
			$name = "Advertisement";
		}
		elseif($leadsourceid=="3")
		{
			$name = "Cold call";
		}
		elseif($leadsourceid == "4")
		{
			$name="Employee Referral";
		}
		elseif($leadsourceid == "5")
		{
			$name = "External Referral";
		}
		elseif ($leadsourceid == "6") 
		{
			$name = "Tradeshow";
		}
		else
		{
			$name = "None";
		}
		return $name;
	}

	public static function employeetable($emptypeid)
	{
		$fetchupdate 	= DB::connection('mastermysql')
								->table('dms_dealers')
								->where('d_id',session::get('ses_id'))
								->get();
		$connection 	= $fetchupdate[0]->dealer_schema_name;		
		Config::set('database.connections.dmsmysql.database', $connection);
		if($emptypeid != 0)
		{
			$emploee_table 	= DB::connection('dmsmysql')
								->table('dealer_employee_management')
								->where('employee_type',$emptypeid);
		}
		else
		{
			$emploee_table 	= DB::connection('dmsmysql')
								->table('dealer_employee_management');
		}
		return $emploee_table;	
	}

	public static function branch()
	{
		$fetchupdate 	= DB::connection('mastermysql')
								->table('dms_dealers')
								->where('d_id',session::get('ses_id'))
								->get();
		$connection 	= $fetchupdate[0]->dealer_schema_name;
		Config::set('database.connections.dmsmysql.database', $connection);
		$manage_branch 	= DB::connection('dmsmysql')->table('dms_dealer_branches');
		return $manage_branch;
	}

}