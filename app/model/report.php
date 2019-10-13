<?php

namespace App\model;
use Illuminate\Database\Eloquent\Model;
use App\model\schemaconnection;
use DB;
use DateTime;

class report extends Model
{
	//Below are functions for inventory report
	public static function inventoryTableDetails($dealer_schemaname,$tablename,$wherecondition,$param,$start_date,$end_date,$order_list1,$order_list2,$order_list3)
	{
		commonmodel::doschemachange($dealer_schemaname);
		//First Dropdown value
		if($order_list1 == '1')
		{
			$order1 	= "car_id";
			$order2 	= "ASC";
		}
		elseif($order_list1 == '2')
		{
			$order1 	= "car_id";
			$order2 	= "DESC";
		} 
		elseif($order_list1 == '3')
		{
			$order1 	 = "makename";
			$order2 	 = "ASC";
		}
		elseif ($order_list1 == "4") 
		{
			$order1 	= "makename";
			$order2 	= "DESC";
		}
		elseif($order_list1 == "5")
		{
			$order1 	= "model_name";
			$order2 	= "ASC";
		}
		elseif ($order_list1 == "6") 
		{
			$order1 	= "model_name";
			$order2 	= "DESC";
		}
		else
		{
			$order1 	= "car_id";
			$order2 	= "ASC";
		}

		//Second Drop Down Value
		if($order_list2 == '1')
		{
			$order3 	= "car_id";
			$order4 	= "ASC";
		}
		elseif($order_list2 == '2')
		{
			$order3 	= "car_id";
			$order4 	= "DESC";
		} 
		elseif($order_list2 == '3')
		{
			$order3 	 = "makename";
			$order4 	 = "ASC";
		}
		elseif ($order_list2 == "4") 
		{
			$order3 	= "makename";
			$order4 	= "DESC";
		}
		elseif($order_list2 == "5")
		{
			$order3 	= "model_name";
			$order4 	= "ASC";
		}
		elseif ($order_list2 == "6") 
		{
			$order3 	= "model_name";
			$order4 	= "DESC";
		}
		else
		{
			$order3 	= "car_id";
			$order4 	= "ASC";
		}

		//Third drop down value
		if($order_list3 == '1')
		{
			$order5 	= "car_id";
			$order6 	= "ASC";
		}
		elseif($order_list3 == '2')
		{
			$order5 	= "car_id";
			$order6 	= "DESC";
		} 
		elseif($order_list3 == '3')
		{
			$order5 	 = "makename";
			$order6 	 = "ASC";
		}
		elseif ($order_list3 == "4") 
		{
			$order5 	= "makename";
			$order6 	= "DESC";
		}
		elseif($order_list3 == "5")
		{
			$order5 	= "model_name";
			$order6 	= "ASC";
		}
		elseif ($order_list3 == "6") 
		{
			$order5 	= "model_name";
			$order6 	= "DESC";
		}
		else
		{
			$order5 	= "car_id";
			$order6 	= "ASC";
		}
		if(($start_date != "")&&($end_date!=""))
		{
			return schemaconnection::dmsmysqlconnection()
								->table($tablename)
								->leftjoin('dms_dev.master_makes','master_makes.make_id','=',$tablename.'.make')
								->leftjoin('dms_dev.master_models','master_models.model_id','=',$tablename.'.model_id')
								->where($wherecondition)
								->select($param)
								->whereBetween('created_at',[$start_date,$end_date])
								->orderBy($order1,$order2)
								->orderBy($order3,$order4)
								->orderBy($order5,$order6)
								->get();
		}
		else
		{
			return schemaconnection::dmsmysqlconnection()
								->table($tablename)
								->leftjoin('dms_dev.master_makes','master_makes.make_id','=',$tablename.'.make')
								->leftjoin('dms_dev.master_models','master_models.model_id','=',$tablename.'.model_id')
								->select($param)
								->where($wherecondition)
								->orderBy($order1,$order2)
								->orderBy($order3,$order4)
								->orderBy($order5,$order6)
								->get();
		}
	}

	public static function moneyFormat($num)
	{
		$explrestunits 	= "" ;
		if(strlen($num)>3)
		{
			$lastthree 	= substr($num, strlen($num)-3, strlen($num));
			$restunits 	= substr($num, 0, strlen($num)-3);
			$restunits 	= (strlen($restunits)%2 == 1)?"0".$restunits:$restunits;
			$expunit 	= str_split($restunits, 2);
			for($i=0; $i<sizeof($expunit); $i++)
			{
				if($i==0)
				{
					$explrestunits .= (int)$expunit[$i].",";
				}
				else
				{
					$explrestunits .= $expunit[$i].",";
				}
			}
			$thecash 	= $explrestunits.$lastthree;
		} 
		else 
		{
			$thecash = $num;
		}
    	return $thecash;
	}

	public static function inventoryreport($dealer_schemaname,$dms_car_listings,$wherecondition,$start_date,$end_date,$order_list1,$order_list2,$order_list3)
	{
		try
		{
			$param 					= array('car_id as Car_Id','duplicate_id as Inventory_Id','inventory_type as Inventory_Type','chassis_number as Chassis_Number','engine_number as Engine_Number','dealer_id as Dealer_Id','branch_id as Branch_Id','fuel_type as Fuel_Type','Variant','Mileage','Transmission','Price','body_type as Body_Type','Colors','registration_number as Registration_Number','registration_year as Registration_Year','owner_type as Owner_Type','Make','dms_car_listings.model_id as Model_Id','Place','kms_done as Kms_Completed','car_city as Car_City','created_at as Created_At','category_id');

			$inventorydata 			= report::inventoryTableDetails($dealer_schemaname,$dms_car_listings,$wherecondition,$param,$start_date,$end_date,$order_list1,$order_list2,$order_list3);
			//dd($inventorydata);

			$dealerdata 			= report::dealerdata();
			$dealerbranch 			= report::dealerbranch();
			$variant 				= report::variant();
			$colors 				= report::colors();
			$make 					= report::make();
			$model 					= report::model();
			$city 					= report::city();
			$category 				= report::category();

			$data 					= array();
			$inventorylistingdata 	= array();
			foreach ($inventorydata as $inventorykey => $inventoryvalue) 
			{
				$pricing_data 					= inventorymodel::dealerFetchTableDetails(
																$dealer_schemaname,
																'dealer_cars_pricing',
																array('listing_id'=>$inventoryvalue->Car_Id)
																);
				$data['Inventory_Id'] 			= $inventoryvalue->Car_Id;
				$data['Inventory_Type'] 		= $inventoryvalue->Inventory_Type;
				$data['Chassis_Number'] 		= $inventoryvalue->Chassis_Number;
				$data['Engine_Number'] 			= $inventoryvalue->Engine_Number;
				foreach ($dealerdata as $dealer) 
				{
					if($dealer->d_id == $inventoryvalue->Dealer_Id)
					{
						$data['Dealer_Name'] 	= $dealer->dealer_name;
					}
				}
				foreach ($dealerbranch as $branch) 
				{
					if($branch->branch_id == $inventoryvalue->Branch_Id)
					{
						$data['Dealer_Branch'] 	= $branch->dealer_name;
					}
				}
				$data['Fuel_Type'] 				= $inventoryvalue->Fuel_Type;
				foreach ($variant as $variants) 
				{
					if($variants->variant_id == $inventoryvalue->Variant)
					{
						$data['Variant'] 		= $variants->variant_name;
					}
				}
				$data['Mileage'] 				= $inventoryvalue->Mileage;
				$data['Transmission'] 			= $inventoryvalue->Transmission;

				//setlocale(LC_MONETARY, 'en_IN');
				$data['Price'] 					= report::moneyFormat($inventoryvalue->Price);

				foreach ($category as $categorys) 
				{
					if($categorys->category_id == $inventoryvalue->category_id)
					{
						$data['Body_Type'] 				= $categorys->category_description;
					}
				}

				foreach ($colors as $color) 
				{
					if($color->colour_id == $inventoryvalue->Colors)
					{
						$data['Colors'] 		= $color->colour_name;
					}
				}
				$data['Registration_Number'] 	= $inventoryvalue->Registration_Number;
				$data['Registration_Year'] 		= $inventoryvalue->Registration_Year;
				$data['Owner_Type'] 			= $inventoryvalue->Owner_Type;
				foreach ($make as $makes) 
				{
					if($makes->make_id == $inventoryvalue->Make)
					{
						$data['Make']			= $makes->makename;
					}
				}
				foreach ($model as $models) 
				{
					if($models->model_id == $inventoryvalue->Model_Id)
					{
						$data['Model_Name'] 	= $models->model_name;
					}
				}
				$data['Place'] 					= $inventoryvalue->Place;
				$data['Kms_Completed'] 			= report::moneyFormat($inventoryvalue->Kms_Completed);
				foreach ($city as $cities) 
				{
					if($cities->city_id == $inventoryvalue->Car_City)
					{
						$data['City'] 			= $cities->city_name;
					}
				}
				$data['Created_At'] 			= $inventoryvalue->Created_At;
				array_push($inventorylistingdata, $data);
			}
			//dd($inventorylistingdata);
			return $inventorylistingdata;
			//dd($inventorylistingdata);
			//// $pdf = PDF::loadView('inventorypdf', $inventorylistingdata);
			// return $pdf->stream('inventorypdf');
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
	}

	public static function dealerdata()
	{
		return schemaconnection::masterconnection()
										->table('dms_dealers')
										->get();
	}

	public static function dealerbranch()
	{
		return schemaconnection::dmsmysqlconnection()
										->table('dms_dealer_branches')
										->get();
	}

	public static function variant()
	{
		return schemaconnection::masterconnection()
										->table('master_variants')
										->get();
	}

	public static function colors()
	{
		return schemaconnection::masterconnection()
										->table('master_colors')
										->get();
	}

	public static function make()
	{
		return schemaconnection::masterconnection()
										->table('master_makes')
										->get();
	}

	public static function model()
	{
		return schemaconnection::masterconnection()
										->table('master_models')
										->get();
	}

	public static function city()
	{
		return schemaconnection::masterconnection()
										->table('master_city')
										->get();
	}

	public static function category()
	{
		return schemaconnection::masterconnection()
										->table('master_category')
										->get();
	}

	//Below is the fucntion for inventory age report
	public static function inventory_age_report($dealer_schemaname,$tablename,$wherecondition,$sort_type)
	{
		try
		{
			$param 					= array('car_id','inventory_type','dealer_id','branch_id','fuel_type','variant','mileage','price','transmission','colors','make','dms_car_listings.model_id','car_city','created_at');
			$inventorydata 			= report::inventoryAgeTableDetails($dealer_schemaname,$tablename,$wherecondition,$sort_type,$param);
			//dd($inventorydata);

			$dealerdata 			= report::dealerdata();
			$dealerbranch 			= report::dealerbranch();
			$variant 				= report::variant();
			$colors 				= report::colors();
			$make 					= report::make();
			$model 					= report::model();
			$city 					= report::city();
			$category 				= report::category();

			$data 					= array();
			$inventorylistingdata 	= array();
			foreach ($inventorydata as $inventorykey => $inventoryvalue) 
			{
				$pricing_data 					= inventorymodel::dealerFetchTableDetails(
																$dealer_schemaname,
																'dealer_cars_pricing',
																array('listing_id'=>$inventoryvalue->car_id)
																);
				$data['Inventory_Id'] 			= $inventoryvalue->car_id;
				$data['Inventory_Type'] 		= $inventoryvalue->inventory_type;
				foreach ($dealerdata as $dealer) 
				{
					if($dealer->d_id == $inventoryvalue->dealer_id)
					{
						$data['Dealer_Name'] 	= $dealer->dealer_name;
					}
				}
				foreach ($dealerbranch as $branch) 
				{
					if($branch->branch_id == $inventoryvalue->branch_id)
					{
						$data['Dealer_Branch'] 	= $branch->dealer_name;
						//dd($data['dealer_branch']);
					}
				}
				$data['Fuel_Type'] 				= $inventoryvalue->fuel_type;
				foreach ($variant as $variants) 
				{
					if($variants->variant_id == $inventoryvalue->variant)
					{
						$data['Variant'] 		= $variants->variant_name;
					}
				}
				$data['Mileage'] 				= $inventoryvalue->mileage;
				$data['Transmission'] 			= $inventoryvalue->transmission;
				$data['Price'] 					= report::moneyFormat($inventoryvalue->price);
				foreach ($colors as $color) 
				{
					if($color->colour_id == $inventoryvalue->colors)
					{
						$data['Colors'] 		= $color->colour_name;
					}
				}
				foreach ($make as $makes) 
				{
					if($makes->make_id == $inventoryvalue->make)
					{
						$data['Make']			= $makes->makename;
					}
				}
				foreach ($model as $models) 
				{
					if($models->model_id == $inventoryvalue->model_id)
					{
						$data['Model_Name'] 			= $models->model_name;
					}
				}
				foreach ($city as $cities) 
				{
					if($cities->city_id == $inventoryvalue->car_city)
					{
						$data['City'] 			= $cities->city_name;
					}
				}
				$data['Created_At'] 			= $inventoryvalue->created_at;
				//dd($days_between);
				$start 							= strtotime($data['Created_At']);
				$end 							= strtotime(date("Y-m-d"));
				$data['days_between']			= ceil(abs($end - $start) / 86400);
				array_push($inventorylistingdata, $data);
			}
			return $inventorylistingdata;
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
	}

	public static function inventoryAgeTableDetails($dealer_schemaname,$queryparams,$sort_type)
	{
		commonmodel::doschemachange($dealer_schemaname);
		//Dropdown value
		if($sort_type == '1')
		{
			$order1	= "ASC";
		}
		elseif($sort_type == '2')
		{
			$order1 	= "DESC";
		}

		if($sort_type!='0')
		{
			commonmodel::doschemachange($dealer_schemaname);
	        $select_doc = schemaconnection::dmsmysqlconnection()
	                                            ->table('dms_car_listings')
	                                            ->select($queryparams)
	                                            ->orderBy('created_at',$order1)
	                                            ->get();
	        return $select_doc; 
		}
		else
		{
			commonmodel::doschemachange($dealer_schemaname);
	        $select_doc = schemaconnection::dmsmysqlconnection()
	                                            ->table('dms_car_listings')
	                                            ->select($queryparams)
	                                            ->get();
			return $select_doc; 
		}
	}

	public static function salesreport($dealer_schemaname,$start_date,$end_date)
	{
		commonmodel::doschemachange($dealer_schemaname);
		return schemaconnection::dmsmysqlconnection()
								->table('dealer_sales')
								->whereBetween('saledate',[$start_date,$end_date])
								->leftjoin($dealer_schemaname.'.dms_car_listings','dms_car_listings.car_id','=','dealer_sales.inventory_id')
								->leftjoin('dms_dev.master_makes','master_makes.make_id','=','dms_car_listings.make')
								->leftjoin('dms_dev.master_models','master_models.model_id','=','dms_car_listings.model_id')
								->leftjoin('dms_dev.master_variants','master_variants.variant_id','=','dms_car_listings.variant')
								->get();
	}

	public static function getContactsReport()
	{
		return schemaconnection::masterconnection()
										->table('dealer_contact_type')
										->get();
	}

	public static function getCarListing()
	{
		return schemaconnection::masterconnection()
										->table('dms_car_listings')
										->get();
	}

	public static function inventoryReportView($dealer_schemaname,$queryparams,$start_date,$end_date,$whereConditionDDL,$whereDDL)
	{
		if($whereConditionDDL == "makename")
        {
			commonmodel::doschemachange($dealer_schemaname);
			$select_doc = schemaconnection::dmsmysqlconnection()
									->table('dms_car_listings')
									->where('dms_car_listings.created_at','>=',$start_date)
									->where('dms_car_listings.created_at','<=',$end_date)
									->leftjoin('dms_dev.master_makes','dms_dev.master_makes.make_id','=','dms_car_listings.make')
									->orderBy('master_makes.'.$whereConditionDDL,$whereDDL)
									->select($queryparams)
									->get();
		}
		elseif($whereConditionDDL == "model_name")
		{
			commonmodel::doschemachange($dealer_schemaname);
			$select_doc = schemaconnection::dmsmysqlconnection()
									->table('dms_car_listings')
									->where('dms_car_listings.created_at','>=',$start_date)
									->where('dms_car_listings.created_at','<=',$end_date)
									->leftjoin('dms_dev.master_models as ddmm','ddmm.model_id','=','dms_car_listings.model_id')
									->orderBy('ddmm.model_name',$whereDDL)
									->select($queryparams)
									->get();
		}
		else
		{
			commonmodel::doschemachange($dealer_schemaname);
			$select_doc = schemaconnection::dmsmysqlconnection()
									->table('dms_car_listings')
									->where('dms_car_listings.created_at','>=',$start_date)
									->where('dms_car_listings.created_at','<=',$end_date)
									->orderBy('dms_car_listings.'.$whereConditionDDL,$whereDDL)
									->select($queryparams)
									->get();
		}
        return $select_doc; 
    }

    public static function getMake($makeid)
	{
		$make = schemaconnection::masterconnection()
										->table('master_makes')
										->select('makename')
										->where('make_id',$makeid)
										->get();
		return $make[0]->makename;
	}

	public static function getModel($modelid)
	{
		$model = schemaconnection::masterconnection()
										->table('master_models')
										->select('model_name')
										->where('model_id',$modelid)
										->get();
										//dd($model);
		return $model[0]->model_name;
	}

	public static function getVariant($variantId)
	{
		$variant =  schemaconnection::masterconnection()
										->table('master_variants')
										->select('variant_name')
										->where('variant_id',$variantId)
										->get();
		return $variant[0]->variant_name;
	}

	public static function getColors($colorid)
	{
		$color =  schemaconnection::masterconnection()
										->table('master_colors')
										->select('colour_name')
										->where('colour_id',$colorid)
										->get();
		return $color[0]->colour_name;
	}

	public static function getCity($master_id)
	{
		$city =  schemaconnection::masterconnection()
										->table('master_city')
										->select('city_name')
										->where('master_id',$master_id)
										->get();
		return $city[0]->city_name;
	}

	public static function getDealers($dealerId)
	{
		$dealers =  schemaconnection::masterconnection()
										->table('dms_dealers')
										->select('dealer_name')
										->where('d_id',$dealerId)
										->get();
		return $dealers[0]->dealer_name;
	}

	public static function getBranches($branchId)
	{
		$branch =  schemaconnection::dmsmysqlconnection()
										->table('dms_dealer_branches')
										->select('dealer_name')
										->where('branch_id',$branchId)
										->get();
		//return $branch[0]->dealer_name;
	}
}