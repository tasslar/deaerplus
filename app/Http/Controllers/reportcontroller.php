<?php
/*
	Module Name : Report 
	Created By  : HARIKRISHNAN R 28-02-2017 Version 1.0
	This module handle with report generation only
*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Session;
use App\model\schemaconnection;
use App\model\commonmodel;
use App\model\alertmodel;
use App\model\inventorymodel;
use App\model\contactsmodel;
use App\model\report;
use PDF;
use App\model\exportmodel;

class reportcontroller extends Controller
{

	public $dealer_schemaname;
	public $dealer_id;

	public function __construct()
	{
		$this->active_menu_name 			= "reports_menu";
		$this->side_bar_active 				= "";
		$this->dropdown1 	 				= "";
		$this->dropdown2 					= "";
		$this->dropdown3					= "";
		$this->checkbox 					= "";
		$this->middleware(function($request,$next){
			$this->id 						= Session::get('ses_id');
			$this->header_data 				= commonmodel::commonheaderdata();
			$this->dealer_schemaname 		= Session::get('dealer_schema_name');
			$this->dealer_id 				= Session::get('ses_id');
			$this->header_data['title'] 	= '';
			return $next($request);
		});
	}

	public function reports(Request $request)
	{
		$dealer_schemaname 		= $this->dealer_schemaname;
		$dms_car_listings 		= 'dms_car_listings';
		$wherecondition 		= array('dealer_id'=>$this->dealer_id);
		$start_date 			= Input::get('txt_start_date');
		$end_date 				= Input::get('txt_end_date');
		$order_list1 			= Input::get('ddl_ordr_list1');

		switch ($order_list1) {
			case '1':
				$whereConditionDDL 	= "duplicate_id";
				$whereDDL 			= "ASC";
				break;
			case '2':
				$whereConditionDDL 	= "duplicate_id";
				$whereDDL 			= "DESC";
				break;
			case '3':
				$whereConditionDDL 	= "makename";
				$whereDDL 			= "ASC";
				break;
			case '4':
				$whereConditionDDL 	= "makename";
				$whereDDL 			= "DESC";
				break;
			case '5':
				$whereConditionDDL 	= "model_name";
				$whereDDL 			= "ASC";
				break;
			case '6':
				$whereConditionDDL 	= "model_name";
				$whereDDL 			= "DESC";
				break;
			default:
				$whereConditionDDL 	= "duplicate_id";
				$whereDDL 			= "ASC";
				break;
		}

		$first_day_this_month 	= date('Y-m-01');
		$last_day_this_month  	= date('Y-m-t');

		$this->active_menu_name	= "reports_menu";
		$this->side_bar_active 	= "1";
		$this->dropdown1 	 	=  array(
										"1" => "INVENTORY ID ASCENDING", 
										"2" => "INVENTORY ID DESCENDING", 
										"3" => "MAKE ASCENDING",
										"4" => "MAKE DESCENDING", 
										"5" => "MODEL ASCENDING", 
										"6" => "MODEL DESCENDING",
										);
		$header_data			= $this->header_data;
		$header_data["title"] 	= "Reports";

		$compact_array			= array(
										'active_menu_name' 	=> $this->active_menu_name,
										'left_menu' 		=> 1,
										'side_bar_active'  	=> $this->side_bar_active,
										);
		$header_array 			= array(
										'dropdown1' => $this->dropdown1,
										);

		$checkbox 				= array(
							"duplicate_id" 					=> "Inventory ID",
							"registration_number"			=> "Registration Number",
							"engine_number"					=> "Engine Number",
							"chassis_number" 				=> "Chassis Number",
							"registration_year" 			=> "Registration Year",
							"make"	 						=> "Make",
							"model_id" 	=> "Model Name",
							"variant" 						=> "Variant",
							"body_type" 					=> "Body Type",
							"transmission" 					=> "Transmission",
							"kms_done"						=> "Total Distance",
							"mileage" 						=> "Mileage",
							"owner_type" 					=> "Owner Type",
							"colors" 						=> "Color",
							"car_city" 						=> "Car City",
							"dealer_id" 					=> "Dealer Name",
							//"branch_id" 					=> "Branch Name",
							"fuel_type" 					=> "Fuel Type",
							"price" 						=> "Price",
							"created_at" 					=> "Created At",
										);
		$queryparams 		= array();
		$header_title 		= array();
		$sheetArray 		= array();
		$fetchparams        = array();
		if(Input::has('btn_view'))
		{
			$got_inputdata  		= Input::get('chk_name');
			$first_day_this_month 	= $start_date;
			$last_day_this_month 	= $end_date;
			//dd($got_inputdata);
			foreach ($got_inputdata as $key => $value) 
			{
				switch ($value) {
			        case "duplicate_id":
			            $header_title[] = 'Inventory ID';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			    	case "registration_number":
			            $header_title[] = 'Registration Number';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "engine_number":
			            $header_title[] = 'Engine Number';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "chassis_number":
			            $header_title[] = 'Chassis Number';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "registration_year":
			            $header_title[] = 'Registration Year';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "make":
			            $header_title[] = 'Make';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "model_id":
			            $header_title[] = 'Model';
			            $queryparams[] = 	'dms_car_listings.'.$value.' as dmodel_id';
			            $fetchparams[] = 'dmodel_id';
			        break;
			        case "variant":
			            $header_title[] = 'Variant';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "body_type":
			            $header_title[] = 'Body Type';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "transmission":
			            $header_title[] = 'Transmission';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "kms_done":
			            $header_title[] = 'Kilometers Completed';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "mileage":
			            $header_title[] = 'Mileage';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "owner_type":
			            $header_title[] = 'Owner Type';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "colors":
			            $header_title[] = 'Color';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "car_city":
			            $header_title[] = 'Car City';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "dealer_id":
			            $header_title[] = 'Dealer Id';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        // case "branch_id":
			        //     $header_title[] = 'Branch ID';
			        //     $queryparams[] = $value;
			        //     $fetchparams[] = $value;
			        // break;
			        case "fuel_type":
			            $header_title[] = 'Fuel Type';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "price":
			            $header_title[] = 'Price';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "created_at":
			            $header_title[] = 'Created At';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
				}
			}
			//dd($queryparams);
			$fetch_data 	= report::inventoryReportView(
													$dealer_schemaname,
													$queryparams,
													$start_date,
													$end_date,
													$whereConditionDDL,
													$whereDDL);
			
			foreach($fetch_data  as $i => $row)
			{
				$i++;
				$data 			= array();

				foreach ($fetchparams as $j => $values) 
				{
					$data[$values]=$row->$values;
					//dd($data['make']);
				}
				
				//exit();
				if(isset($row->make))
				{
					$data['make'] = report::getMake($row->make);
				}

				if(isset($row->dmodel_id))
				{
					$data['dmodel_id'] = report::getModel($row->dmodel_id);
				}
				//dd($data['dmodel_id']);

				if(isset($row->variant))
				{
					$data['variant'] = report::getVariant($row->variant);
				}

				if(isset($row->colors))
				{
					$data['colors'] = report::getColors($row->colors);
				}

				if(isset($row->car_city))
				{
					$data['car_city'] = report::getCity($row->car_city);
				}

				if(isset($row->dealer_id))
				{
					
					$data['dealer_id'] = report::getDealers($row->dealer_id);
				}

				if(isset($row->branch_id))
				{
					$data['branch_id'] = report::getBranches($row->branch_id);
				}
				
				$sheetArray[] 	= $data;
			}

			return view('/reports',compact('header_data','compact_array','sheetArray','checkbox','first_day_this_month','last_day_this_month','queryparams','header_array','header_title','order_list1','fetchparams'));
		}
		elseif(Input::has('btn_download'))
		{
			$got_inputdata  = Input::get('chk_name');
			//dd($got_inputdata);
			foreach ($got_inputdata as $key => $value) 
			{
				switch ($value) {
			        case "duplicate_id":
			            $header_title[] = 'Inventory ID';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			    	case "registration_number":
			            $header_title[] = 'Registration Number';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "engine_number":
			            $header_title[] = 'Engine Number';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "chassis_number":
			            $header_title[] = 'Chassis Number';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "registration_year":
			            $header_title[] = 'Registration Year';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "make":
			            $header_title[] = 'Make';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "model_id":
			            $header_title[] = 'Model';
			            $queryparams[] = 	'dms_car_listings.'.$value.' as dmodel_id';
			            $fetchparams[] = 'dmodel_id';
			        break;
			        case "variant":
			            $header_title[] = 'Variant';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "body_type":
			            $header_title[] = 'Body Type';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "transmission":
			            $header_title[] = 'Transmission';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "kms_done":
			            $header_title[] = 'Kilometers Completed';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "mileage":
			            $header_title[] = 'Mileage';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "owner_type":
			            $header_title[] = 'Owner Type';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "colors":
			            $header_title[] = 'Color';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "car_city":
			            $header_title[] = 'Car City';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "dealer_id":
			            $header_title[] = 'Dealer Id';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        // case "branch_id":
			        //     $header_title[] = 'Branch ID';
			        //     $queryparams[] = $value;
			        //     $fetchparams[] = $value;
			        // break;
			        case "fuel_type":
			            $header_title[] = 'Fuel Type';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "price":
			            $header_title[] = 'Price';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "created_at":
			            $header_title[] = 'Created At';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
				}
			}
			//dd($queryparams);
			$fetch_data 	= report::inventoryReportView(
													$dealer_schemaname,
													$queryparams,
													$start_date,
													$end_date,
													$whereConditionDDL,
													$whereDDL);


			$sheetArray 		= [];

			$data1 				= array();
			foreach ($header_title as $j => $values) 
			{
				$data1[$values] = $values;
			}
			$sheetArray[] 		= $data1;

			$excelname 			= "Inventory".time();
			$sheetheading 		= "Inventory Report";
			$mergecells 		= "A1:S1";

			foreach($fetch_data  as $i => $row)
			{
				$i++;
				$data 			= array();
				foreach ($fetchparams as $j => $values) 
				{
					$data[$values]=$row->$values;
				}
				if(isset($row->make))
				{
					$data['make'] = report::getMake($row->make);
				}

				if(isset($row->dmodel_id))
				{
					$data['dmodel_id'] = report::getModel($row->dmodel_id);
				}
				//dd($data['dmodel_id']);

				if(isset($row->variant))
				{
					$data['variant'] = report::getVariant($row->variant);
				}

				if(isset($row->colors))
				{
					$data['colors'] = report::getColors($row->colors);
				}

				if(isset($row->car_city))
				{
					$data['car_city'] = report::getCity($row->car_city);
				}

				if(isset($row->dealer_id))
				{
					
					$data['dealer_id'] = report::getDealers($row->dealer_id);
				}

				if(isset($row->branch_id))
				{
					
						$data['branch_id'] = report::getBranches($row->branch_id);
				}

				// foreach ($dealerbranch as $dealerbranchID) 
				// {
				// 	if(isset($row->branch_id))
				// 	{
				// 		if($dealerbranchID->branch_id == $row->branch_id)
				// 		{
				// 			$data['branch_id'] = $dealerbranchID->dealer_name;
				// 		}
				// 	}
				// }
				$sheetArray[] 	= $data;
			}
			exportmodel::generatereport($sheetArray,$sheetheading,$excelname,$mergecells);
			
		}
		else
		{
			return view('/reports',compact('header_data','compact_array','sheetArray','checkbox','first_day_this_month','last_day_this_month','queryparams','header_array','header_title','order_list1','fetchparams'));
		}
	}

	public function inventory_age_report(Request $request)
	{
		$dealer_schemaname 		= $this->dealer_schemaname;
		$dms_car_listings 		= 'dms_car_listings';
		$wherecondition 		= array('dealer_id'=>$this->dealer_id);
		$sort_type 				= $request->get('ddl_sort_type');

		$this->active_menu_name	= "reports_menu";
		$this->side_bar_active 	= "2";
		$header_data			= $this->header_data;
		$header_data["title"] 	= "";
		$header_data["title"] 	= "Reports";

		$compact_array			= array(
										'active_menu_name' 	=> $this->active_menu_name,
										'side_bar_active'  	=> $this->side_bar_active,
										);

		$checkbox 				= array(
										"duplicate_id" 			=> "Inventory ID",
										"inventory_type" 		=> "Inventory Type",
										//"registration_number"	=> "Registration Number",
										//"engine_number"			=> "Engine Number",
										//"chassis_number" 		=> "Chassis Number",
										//"registration_year" 	=> "Registration Year",
										"make"	 				=> "Make",
										"model_id" 				=> "Model Name",
										"variant" 				=> "Variant",
										//"body_type" 			=> "Body Type",
										"transmission" 			=> "Transmission",
										//"kms_done"				=> "Total Distance",
										"mileage" 				=> "Mileage",
										//"owner_type" 			=> "Owner Type",
										"colors" 				=> "Color",
										"car_city" 				=> "Car City",
										"dealer_id" 			=> "Dealer Name",
										"branch_id" 			=> "Branch Name",
										"fuel_type" 			=> "Fuel Type",
										"price" 				=> "Price",
										"created_at" 			=> "Created At",
										);
		$queryparams = array();
		$header_title = array();
		$sheetArray = array();
		$fetchparams = array();
		if(Input::has('btn_generate'))
		{
			$got_inputdata  = Input::get('chk_name');
			//dd($got_inputdata);
			foreach ($got_inputdata as $key => $value) 
			{
				switch ($value) {
			        case "duplicate_id":
			            $header_title[] = 'Inventory ID';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			    	case "inventory_type":
			            $header_title[] = 'Inventory Type';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "make":
			            $header_title[] = 'Make';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "model_id":
			            $header_title[] = 'Model Name';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "variant":
			            $header_title[] = 'Variant';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "transmission":
			            $header_title[] = 'Transmission';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "mileage":
			            $header_title[] = 'Mileage';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "colors":
			            $header_title[] = 'Color';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "car_city":
			            $header_title[] = 'Car City';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "dealer_id":
			            $header_title[] = 'Dealer Id';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "branch_id":
			            $header_title[] = 'Branch ID';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "fuel_type":
			            $header_title[] = 'Fuel Type';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "price":
			            $header_title[] = 'Price';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "created_at":
			            $header_title[] = 'Created At';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
				}
			}
			$fetch_data 	= report::inventoryAgeTableDetails(
													$dealer_schemaname,
													$queryparams,
													$sort_type
													);

			$makename		= report::make();
			$model 			= report::model();
			$variant 		= report::variant();
			$colors 		= report::colors();
			$city 			= report::city();
			$dealername 	= report::dealerdata();
			$dealerbranch 	= report::dealerbranch();
			//dd($fetch_data);

			foreach($fetch_data  as $i => $row)
			{
				$i++;
				$data 			= array();

				foreach ($queryparams as $j => $values) 
				{
					$data[$values]=$row->$values;
				}

				foreach ($makename as $makenameID) 
				{
					if(isset($row->make))
					{
						if($makenameID->make_id == $row->make)
						{
							$data['make'] = $makenameID->makename;
						}
					}
				}

				foreach ($model as $modelnameID) 
				{
					if(isset($row->model_id))
					{
						if($modelnameID->make_id == $row->model_id)
						{
							$data['model_id'] = $modelnameID->model_name;
						}
					}
				}

				foreach ($variant as $variantID) 
				{
					if(isset($row->variant))
					{
						if($variantID->variant_id == $row->variant)
						{
							$data['variant'] = $variantID->variant_name;
						}
					}
				}

				foreach ($colors as $colorsID) 
				{
					if(isset($row->colors))
					{
						if($colorsID->colour_id == $row->colors)
						{
							$data['colors'] = $colorsID->colour_name;
						}
					}
				}

				foreach ($city as $cityID) 
				{
					if(isset($row->car_city))
					{
						if($cityID->master_id == $row->car_city)
						{
							$data['car_city'] = $cityID->city_name;
						}
					}
				}

				foreach ($dealername as $dealerID) 
				{
					if(isset($row->dealer_id))
					{
						if($dealerID->d_id == $row->dealer_id)
						{
							$data['dealer_id'] = $dealerID->dealer_name;
						}
					}
				}

				foreach ($dealerbranch as $dealerbranchID) 
				{
					if(isset($row->branch_id))
					{
						if($dealerbranchID->branch_id == $row->branch_id)
						{
							$data['branch_id'] = $dealerbranchID->dealer_name;
						}
					}
				}
				$sheetArray[] 	= $data;
			}
			//return back()->withInput();
			return view('/report_inventory_age',compact('header_data','compact_array','sheetArray','checkbox','queryparams','header_array','header_title','fetchparams'));
			//return view('report_inventory_age',compact('header_data','compact_array','checkbox','fetch_data1'));
			//dd($fetch_data);
		}
		elseif (Input::has('btn_download')) 
		{
			$got_inputdata  = Input::get('chk_name');
			//dd($got_inputdata);
			foreach ($got_inputdata as $key => $value) 
			{
				switch ($value) {
			        case "duplicate_id":
			            $header_title[] = 'Inventory ID';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			    	case "inventory_type":
			            $header_title[] = 'Inventory Type';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "make":
			            $header_title[] = 'Make';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "model_id":
			            $header_title[] = 'Model Name';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "variant":
			            $header_title[] = 'Variant';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "transmission":
			            $header_title[] = 'Transmission';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "mileage":
			            $header_title[] = 'Mileage';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "colors":
			            $header_title[] = 'Colors';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "car_city":
			            $header_title[] = 'Car City';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "dealer_id":
			            $header_title[] = 'Dealer Id';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "branch_id":
			            $header_title[] = 'Branch ID';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "fuel_type":
			            $header_title[] = 'Fuel Type';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "price":
			            $header_title[] = 'Price';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
			        case "created_at":
			            $header_title[] = 'Created At';
			            $queryparams[] = $value;
			            $fetchparams[] = $value;
			        break;
				}
			}
			$fetch_data 	= report::inventoryAgeTableDetails(
													$dealer_schemaname,
													$queryparams,
													$sort_type
													);

			$makename		= report::make();
			$model 			= report::model();
			$variant 		= report::variant();
			$colors 		= report::colors();
			$city 			= report::city();
			$dealername 	= report::dealerdata();
			$dealerbranch 	= report::dealerbranch();
			//dd($fetch_data);
			$sheetArray 		= [];

			$data1 				= array();
			foreach ($header_title as $j => $values) 
			{
				$data1[$values] = $values;
			}
			$sheetArray[] 		= $data1;

			$excelname 			= "Inventory Ageing".time();
			$sheetheading 		= "Inventory Age Report";
			$mergecells 		= "A1:S1";

			foreach($fetch_data  as $i => $row)
			{
				$i++;
				$data 			= array();

				foreach ($queryparams as $j => $values) 
				{
					$data[$values]=$row->$values;
				}

				foreach ($makename as $makenameID) 
				{
					if(isset($row->make))
					{
						if($makenameID->make_id == $row->make)
						{
							$data['make'] = $makenameID->makename;
						}
					}
				}

				foreach ($model as $modelnameID) 
				{
					if(isset($row->model_id))
					{
						if($modelnameID->make_id == $row->model_id)
						{
							$data['model_id'] = $modelnameID->model_name;
						}
					}
				}

				foreach ($variant as $variantID) 
				{
					if(isset($row->variant))
					{
						if($variantID->variant_id == $row->variant)
						{
							$data['variant'] = $variantID->variant_name;
						}
					}
				}

				foreach ($colors as $colorsID) 
				{
					if(isset($row->colors))
					{
						if($colorsID->colour_id == $row->colors)
						{
							$data['colors'] = $colorsID->colour_name;
						}
					}
				}

				foreach ($city as $cityID) 
				{
					if(isset($row->car_city))
					{
						if($cityID->master_id == $row->car_city)
						{
							$data['car_city'] = $cityID->city_name;
						}
					}
				}

				foreach ($dealername as $dealerID) 
				{
					if(isset($row->dealer_id))
					{
						if($dealerID->d_id == $row->dealer_id)
						{
							$data['dealer_id'] = $dealerID->dealer_name;
						}
					}
				}

				foreach ($dealerbranch as $dealerbranchID) 
				{
					if(isset($row->branch_id))
					{
						if($dealerbranchID->branch_id == $row->branch_id)
						{
							$data['branch_id'] = $dealerbranchID->dealer_name;
						}
					}
				}
				$sheetArray[] 	= $data;
			}
			exportmodel::generatereport($sheetArray,$sheetheading,$excelname,$mergecells);
		}
		else
		{
			return view('/report_inventory_age',compact('header_data','compact_array','sheetArray','checkbox','queryparams','header_array','header_title','fetchparams'));
		}
	}

	public function contact_reports()
	{
		$dealer_schemaname 		= $this->dealer_schemaname;		
		$this->active_menu_name = "reports_menu";
		$this->side_bar_active 	= "3";
		$header_data 			= $this->header_data;
		$header_data["title"] 	= "Contact Report";
		$compact_array			= array(
										'active_menu_name'=>$this->active_menu_name,
										'left_menu'=>11,
										'side_bar_active' =>$this->side_bar_active,
										);
		$queryparams = array();
		$header_title = array();
		$sheetArray = array();
		$fetchparams = array();
		if(Input::has('btn_view'))
		{
			$got_inputdata  = Input::get('cb_alert');
			//dd($got_inputdata);
			foreach ($got_inputdata as $key => $value) {
				switch ($value) {
	                case "contact_type_id":
    	                $header_title[] = 'Type';
    	                $queryparams[] = $value;
    	                $fetchparams[] = $value;
                    break;
                	case "contact_owner":
        	            $header_title[] = 'Owner';
        	            $queryparams[] = $value;
        	            $fetchparams[] = $value;
                    break;
                    case "contact_gender":
        	            $header_title[] = 'Gender';
        	            $queryparams[] = $value;
        	            $fetchparams[] = $value;
                    break;
                    case "contact_lead_source":
        	            $header_title[] = 'Leaed Source';
        	            $queryparams[] = $value;
        	            $fetchparams[] = $value;
                    break;
                    case "contact_phone_1":
        	            $header_title[] = 'Phone No';
        	            $queryparams[] = $value;
        	            $fetchparams[] = $value;
                    break;
                    case "contact_email_1":
        	            $header_title[] = 'Email Id';
        	            $queryparams[] = $value;
        	            $fetchparams[] = $value;
                    break;
                    case "contact_sms_opt_out":
        	            $header_title[] = 'SMS Subcription';
        	            $queryparams[] = $value;
        	            $fetchparams[] = $value;
                    break;
                    case "contact_email_opt_out":
        	            $header_title[] = 'Email Subcription';
        	            $queryparams[] = $value;
        	            $fetchparams[] = $value;
                    break;
            	}
			}

			$fetch_data 	= contactsmodel::contactsreport($dealer_schemaname,$queryparams);
			$fetchContacts 	= report::getContactsReport();
			//dd($fetch_data);

			foreach($fetch_data  as $i => $row)
			{
				$i++;
				$data 			= array();
				foreach ($queryparams as $j => $values) 
				{
					foreach ($fetchContacts as $contacts) 
					{
						if($row->contact_type_id == $contacts->contact_type_id)
						{
							$row->$values=$contacts->contact_type;
						}
					}
					if($values=='contact_sms_opt_out'||$values=='contact_email_opt_out')
					{
						if($row->$values==1)
						$row->$values='Yes';
						else
						$row->$values='No';
					}
					$data[$values]=$row->$values;
				}
				$sheetArray[] 	= $data;
			}
		}
		elseif(Input::has('btn_download'))
		{
			$got_inputdata  	= Input::get('cb_alert');
			//dd($got_inputdata);
			foreach ($got_inputdata as $key => $value) {
				switch ($value) {
	                case "contact_type_id":
    	                $header_title[] = 'Contact Type';
    	                $queryparams[] = $value;
                    break;
                	case "contact_owner":
        	            $header_title[] = 'Owner';
        	            $queryparams[] = $value;
        	            
                    break;
                    case "contact_gender":
        	            $header_title[] = 'Gender';
        	            $queryparams[] = $value;
                    break;
                    case "contact_lead_source":
        	            $header_title[] = 'Leaed Source';
        	            $queryparams[] = $value;
                    break;
                    case "contact_phone_1":
        	            $header_title[] = 'Phone No';
        	            $queryparams[] = $value;
                    break;
                    case "contact_email_1":
        	            $header_title[] = 'Email Id';
        	            $queryparams[] = $value;
                    break;
                    case "contact_sms_opt_out":
        	            $header_title[] = 'SMS Subcription';
        	            $queryparams[] = $value;
                    break;
                    case "contact_email_opt_out":
        	            $header_title[] = 'Email Subcription';
        	            $queryparams[] = $value;
                    break;
            	}
			}
			$fetch_data			= contactsmodel::contactsreport(
												$dealer_schemaname,
												$queryparams);

			$sheetArray 		= [];

			$data1 				= array();
			foreach ($header_title as $j => $values) 
			{
				$data1[$values] = $values;
			}
			$sheetArray[] 		= $data1;

			$excelname 			= "Contact".time();
			$sheetheading 		= "Contact Report";
			$mergecells 		= "A1:H1";

			$fetchContacts 		= report::getContactsReport();

			foreach($fetch_data  as $i => $row)
			{
				$i++;
				$data 			= array();
				foreach ($queryparams as $j => $values) 
				{
					foreach ($fetchContacts as $contacts) 
					{
						if($row->contact_type_id == $contacts->contact_type_id)
						{
							$row->$values=$contacts->contact_type;
						}
					}

					if($values=='contact_sms_opt_out'||$values=='contact_email_opt_out')
					{
						if($row->$values==1)
							$row->$values='Yes';
						else
							$row->$values='No';
					}
					$data[$values]=$row->$values;
				}
				$sheetArray[] 	= $data;
			}
			exportmodel::generatereport($sheetArray,$sheetheading,$excelname,$mergecells);
		}
		return view('/contact_reports',compact('header_data','compact_array','header_title','sheetArray','queryparams','fetchparams'));
	}

	public function sales_reports()
	{
		$dealer_schemaname 		= $this->dealer_schemaname;
		$first_day_this_month 	= date('Y-m-01');
		$last_day_this_month  	= date('Y-m-t');
		$this->active_menu_name = "reports_menu";
		$this->side_bar_active 	= "4";
		$header_data 			= $this->header_data;
		$header_data["title"] 	= "Sales Report";
		$compact_array			= array(
										'active_menu_name'=>$this->active_menu_name,
										'left_menu'=>11,
										'side_bar_active' =>$this->side_bar_active,
										);

		$queryparams 			= array(
										'saledate','registrationno','vinno','makename','model_name','variant_name','registration_year','saleprice','purchaser','salesperson');
		$header_title 			= array(
										'Sold Date','Reg No','Vin No','Make','Model','Variant','Year','Sold Price','Sold Person','Sale Person');
		$sheetArray 			= array();
		if(Input::has('btn_view'))
		{
			$start_date  				= Input::get('txt_start_date');
			$end_date  					= Input::get('txt_end_date');

			$first_day_this_month 		= $start_date;
			$last_day_this_month  		= $end_date;
			$fetch_data 				= report::salesreport(
												$dealer_schemaname,$start_date,$end_date);
			foreach($fetch_data  as $i => $row)
			{
				$i++;
				$data 			= array();
				foreach ($queryparams as $j => $values) 
				{
					$data[$values]=$row->$values;
				}
				$sheetArray[] 	= $data;
			}
			return view('/sales_reports',compact('header_data','compact_array','header_title','sheetArray','queryparams','first_day_this_month','last_day_this_month'));
		}
		elseif(Input::has('btn_download'))
		{
			$start_date  = Input::get('txt_start_date');
			$end_date  = Input::get('txt_end_date');
			$fetch_data = report::salesreport($dealer_schemaname,$start_date,$end_date);

			$excelname 			= "Sales".time();
			$sheetheading 		= "Sales Report";
			$mergecells 		= "A1:J1";
			$sheetArray 		= array();

			$sheetArray 		= [];
			$data1 				= array();
			foreach ($header_title as $j => $values) 
			{
				$data1[$values] = $values;
			}
			$sheetArray[] 		= $data1;

			foreach($fetch_data  as $i => $row)
			{
				$i++;
				$data 			= array();
				foreach ($queryparams as $j => $values) 
				{
					$data[$values]=$row->$values;
				}
				$sheetArray[] 	= $data;
			}
			exportmodel::generatereport($sheetArray,$sheetheading,$excelname,$mergecells);
		}
		else
		{
			return view('/sales_reports',compact('header_data','compact_array','header_title','sheetArray','queryparams','first_day_this_month','last_day_this_month'));
		}
		//dd($sheetArray);
		
	}

	public function alert_reports()
	{
		$dealer_schemaname 		= $this->dealer_schemaname;		
		$this->active_menu_name = "reports_menu";
		$this->side_bar_active 	= "5";
		$header_data 			= $this->header_data;
		$header_data["title"] 	= "Alert Report";
		$compact_array			= array(
										'active_menu_name'=>$this->active_menu_name,
										'left_menu'=>11,
										'side_bar_active' =>$this->side_bar_active,
										);
		$queryparams = array();
		$header_title = array();
		$sheetArray = array();
		$fetchparams = array();
		if(Input::has('btn_view'))
		{
			$got_inputdata  = Input::get('cb_alert');
			//dd($_POST);
			foreach ($got_inputdata as $key => $value) {
				switch ($value) {
	                case "alert_date":
    	                $header_title[] = 'Alert Date';
    	                $queryparams[] = $value;
    	                $fetchparams[] = $value;
                    break;
                	case "Product":
        	            $header_title[] = 'Make';
        	            $header_title[] = 'Model';
        	            $header_title[] = 'Variant';
        	            $header_title[] = 'Year';
        	            $queryparams[] = 'alert_make';
        	            $queryparams[] = 'alert_model';
        	            $queryparams[] = 'alert_variant';
        	            $queryparams[] = 'alert_year';

        	            $fetchparams[] = $value;
                    break;
                    case "alert_city":
        	            $header_title[] = 'Alert City';
        	            $queryparams[] = $value;
        	            $fetchparams[] = $value;
                    break;
                    case "alert_email_status":
        	            $header_title[] = 'Email Status';
        	            $queryparams[] = $value;
        	            $fetchparams[] = $value;
                    break;
                    case "alert_sms_status":
        	            $header_title[] = 'SMS Status';
        	            $queryparams[] = $value;
        	            $fetchparams[] = $value;
                    break;
                    case "alert_type":
        	            $header_title[] = 'Alert Type';
        	            $queryparams[] = $value;
        	            $fetchparams[] = $value;
                    break;
            	}
			}

			$fetch_data = alertmodel::doAlertreportschema($dealer_schemaname,$queryparams);
			foreach($fetch_data  as $i => $row)
			{
				$i++;
				$data 			= array();
				foreach ($queryparams as $j => $values) 
				{
					if($values=='alert_email_status'||$values=='alert_sms_status')
					{
						if($row->$values==1)
						$row->$values='Yes';
						else
						$row->$values='No';
					}
					$data[$values]=$row->$values;
				}
				$sheetArray[] 	= $data;
			}			
		}
		elseif(Input::has('btn_download'))
		{
			$got_inputdata  = Input::get('cb_alert');
			//dd($_POST);
			foreach ($got_inputdata as $key => $value) {
				switch ($value) {
	                case "alert_date":
    	                $header_title[] = 'Alert Date';
    	                $queryparams[] = $value;
                    break;
                	case "Product":
        	            $header_title[] = 'Make';
        	            $header_title[] = 'Model';
        	            $header_title[] = 'Variant';
        	            $header_title[] = 'Year';
        	            $queryparams[] = 'alert_make';
        	            $queryparams[] = 'alert_model';
        	            $queryparams[] = 'alert_variant';
        	            $queryparams[] = 'alert_year';
                    break;
                    case "alert_city":
        	            $header_title[] = 'Alert City';
        	            $queryparams[] = $value;
                    break;
                    case "alert_email_status":
        	            $header_title[] = 'Email Status';
        	            $queryparams[] = $value;
                    break;
                    case "alert_sms_status":
        	            $header_title[] = 'SMS Status';
        	            $queryparams[] = $value;
                    break;
                    case "alert_type":
        	            $header_title[] = 'Alert Type';
        	            $queryparams[] = $value;
                    break;
            	}
			}
			$excelname 			= "Alert".time();
			$sheetheading 		= "Alert Report";
			$mergecells 		= "A1:I1";
			$sheetArray 		= array();

			$sheetArray 		= [];
			$data1 				= array();
			foreach ($header_title as $j => $values) 
			{
				$data1[$values] = $values;
			}
			$sheetArray[] 		= $data1;

			$fetch_data = alertmodel::doAlertreportschema($dealer_schemaname,$queryparams);
			foreach($fetch_data  as $i => $row)
			{
				$i++;
				$data 			= array();
				foreach ($queryparams as $j => $values) 
				{
					if($values=='alert_email_status'||$values=='alert_sms_status')
					{
						if($row->$values==1)
						$row->$values='Yes';
						else
						$row->$values='No';
					}
					$data[$values]=$row->$values;
				}
				$sheetArray[] 	= $data;
			}
			exportmodel::generatereport($sheetArray,$sheetheading,$excelname,$mergecells);
		}
		return view('/alert_reports',compact('header_data','compact_array','header_title','sheetArray','queryparams','fetchparams'));
	}
}