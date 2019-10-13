<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Request;
use App\Http\Requests;
use App\model\dealermodel;
use App\model\commonmodel;
use App\model\inventorymodel;
use App\model\dms_dealerdetails;
use App\model\dms_car_listings;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\registervalidation;
use Illuminate\Support\Facades\Input;
use DB;
use File;
use Config;
use Carbon\Carbon;

/**
* 
*/
class master extends Controller
{
	public $materCityTable;
	public $masterMakesTable;
	public $masterModelsTable;
	public $materVariantTable;
	public $materCategoryTable;
	public $materCarFeatureTable;
	public $materColorTable;
	public $materCountryTable;
	public $materEmailTempTable;
	public $masterEmailTypesTable;
	public $masterFeatureTable;
	public $masterMenuTable;
	public $masterPlansTable;
	public $masterPlansFrequencyTable;
	public $masterSchemaUsersTable;
	public $masterStateTable;
	public $masterSubscriptionTable;
	public $masterTextTempTable;
	public $field;
	public $master_car_year;
	public function __construct()
    {		
		$this->materCityTable			=	"master_city";
        $this->masterMakesTable 		= 	"master_makes";
        $this->masterModelsTable		=	"master_models";
        $this->materVariantTable      	= 	"master_variants";
        $this->materCategoryTable      	= 	"master_category";
        $this->materCarFeatureTable     = 	"master_car_features";
        $this->materColorTable     		= 	"master_colors";
        $this->materCountryTable     	= 	"master_country";
        $this->materEmailTempTable     	= 	"master_email_templates";
        $this->masterEmailTypesTable    = 	"master_email_types";
        $this->masterFeatureTable    	= 	"master_features";
		$this->masterMenuTable    		= 	"master_menu";
		$this->masterPlansTable    		= 	"master_plans";
		$this->masterPlansFrequencyTable= 	"master_plan_frequency";
		$this->masterSchemaUsersTable   = 	"master_schema_users";
		$this->masterStateTable   		= 	"master_state";
		$this->masterSubscriptionTable  = 	"master_subscription_plans";
        $this->masterApiSitesTable  	= 	"master_text_template";
        $this->field 					=	"plan_type_id";
        $this->master_car_year			=	"master_car_reg_year";
	}
	
	public function doMasterCity()
	{
		$make_id		=	Input::get('29');
        $wherecondition	=	array('state_id'=>$make_id);        
		$cityname 		=	commonmodel::getAllRecordsWhere($this->materCityTable,$wherecondition);
		return response()->json(['result'=>3,
								'city_name'=>$cityname
								]);
	}
	public function dogetMasterCity()
	{
		//header('Access-Control-Allow-Origin: *');
		$master_city_data = DB::connection('mastermysql')->table('master_city')
															->select(DB::raw("country_id,state_id,city_id,city_name,popular_status"))
															->orderby('popular_status','desc')
															->orderby('city_name')
															->get();
		return response()->json([$master_city_data]);
		
	}
	public function doRegisterYear()
	{
		$id 		=	input::get('session_user_id');
		if($id 		== 	"")
		{
			return response()->json(['Result'=>'0',
										'message'=>'All Fields are required'
										]);
		}
		$schemaname 	=  	$this->getschemaname($id);
		if(!empty($schemaname))
		{
			$year 			=	commonmodel::getAllRecords($this->master_car_year);
			$where 			=	array('status'=>'Active');
			$make 			=	commonmodel::getAllRecordsWhere($this->masterMakesTable,$where);
			$category 		=	commonmodel::getAllRecordsWhere($this->materCategoryTable,$where);
			$Ownership 		= 	array(array("id"=>1,"owner"=>"FIRST"),array("id"=>2,"owner"=>"SECOND"),
								array("id"=>3,"owner"=>"THIRD"),array("id"=>4,"owner"=>"Fourth"),
								array("id"=>"4 +","owner"=>"Four +"));
			$Cartype 		= 	array(array("id"=>3,"type"=>"Excellent"),
											array("id"=>2,"type"=>"Medium"),
											array("id"=>1,"type"=>"Good")
											);
			$wherecolor 	=	array('enabled'=>'Y');
			$color 			=	commonmodel::getAllRecordsWhere($this->materColorTable,$wherecolor);
			//CHECK PLAN TYPE FOR DELAER
			$whereplan 		=	array('dealer_id'=>$id,'current_subscription'=>1);
			$planExp 		=  	dealermodel::masterFetchTableDetails('dealer_billing_details',$whereplan);
			$planexpire 	=	"";
			$currentplan 	=	"";
			$plantypename	=	"";
			$totalDuration	=	0;
			if(!empty($planExp) && count($planExp) >= 1)
			{
				$myPlan 	=  	dealermodel::DoCheckDealerplandetails(
																$id,
																$planExp[0]->subscription_start_date,
																$planExp[0]->subscription_end_date
																);
				$plantypename	=	((count($myPlan)>=1)?$myPlan[0]->plan_type_name:'');	
				if($plantypename == "")
				{
					$plantypename 	=	"TRIAL";
				}				
				$currentplan	=	((count($myPlan)>=1)?$myPlan[0]->feature_allowed:'');												
				$startTime 		= 	Carbon::parse($myPlan[0]->subscription_end_date);
				$finishTime 	= 	Carbon::now('Asia/Kolkata');
				$totalDuration 	= 	$startTime->diffForHumans($finishTime);
			}
			
			if(strpos($totalDuration,'after') !== false)
			{
				$totalDuration	=	"Yes";
			}
			if(strpos($totalDuration,'before') !== false)
			{
				$totalDuration	=	"No";
			}
			if($totalDuration == 0 || $totalDuration 	==	"")
			{
				$totalDuration	=	"No";
			}
			$where 		=	array('status'=>'Active');
			$bodytype	=	commonmodel::getAllRecordsWhere($this->materCategoryTable,$where);
			$plandetails 		=	array('PlanName'=>$plantypename,	
										'PlanTypeAllow'	=>$totalDuration);
			return response()->json(['Result'=>'1',
									'Year'=>$year,
									'Make'=>$make,
									'Category'=>$category,
									'Owenertype'=>$Ownership,
									'Bodytype'=>$bodytype,
									'Cartype'=>$Cartype,
									'Color'=>$color,
									'planDetails'=>[$plandetails]
											]);	
		}
		else
		{
			return response()->json(['Result'=>'0',
										'message'=>'Failure'
										]);
		}
	}
	public function doMasterMake()
	{
		$where 	=	array('status'=>'Active');
		return response()->json(commonmodel::getAllRecordsWhere($this->masterMakesTable,$where));		
	}
	public function doMasterModelApi()
	{
		$makeid 	=	input::get('make_id');
		if($makeid == "")
		{
			return response()->json(['Result'=>'0',
										'message'=>'Make id is required'
										]);
		}
		$where 		=	array('make_id'=>$makeid,'status'=>'Active');
		return response()->json(commonmodel::getAllRecordsWhere($this->masterModelsTable,$where));
	}
	public function doMasterBranch()
	{
		$user_id 	=	input::get('session_user_id');
		$city_id 	=	input::get('city_id');
		if($user_id == "" || $city_id == "")
		{
			return response()->json(['Result'=>'0',
										'message'=>'All Fields are required'
										]);
		}
		$schemaname 	=  $this->getschemaname($user_id);
		if(!empty($schemaname))
		{
			$where 			=	array('dealer_city'=>$city_id,'dealer_status'=>'Active');
			$branchdetails 	=	inventorymodel::dogetschemabranch($schemaname,
																		$where);
			return response()->json(['Result'=>'1',
									'message'=>'Success',
									'branchname'=>$branchdetails
									]);
		}
		else
		{
			return response()->json(['Result'=>'0',
									'message'=>'Invalid Access'
									]);
		}			
		
	}
	public function doMasterVariantsApi()
	{
		$modelid 	=	input::get('model_id');
		if($modelid == "")
		{
			return response()->json(['Result'=>'0',
										'message'=>'Model id is required'
										]);
		}
		$where 		=	array('model_id'=>$modelid,'status'=>'Active');
		return response()->json(commonmodel::getAllRecordsWhere($this->materVariantTable,$where));
	}
	
	public function doMasterModel()
	{
		return response()->json(commonmodel::getAllRecords($this->masterModelsTable));
	}
	public function doMasterVariants()
	{
		return response()->json(commonmodel::getAllRecords($this->materVariantTable));
	}
	public function doMasterCategory()
	{
		$where 		=	array('status'=>'Active');
		return response()->json(commonmodel::getAllRecordsWhere($this->materCategoryTable,$where));
	}
	public function doMasterOwnerType()
	{
		$Ownership 	= 	array(array("FIRST"=>"1"),array("SECOND"=>"2"),array("THIRD"=>"3"),
							array("Fourth"=>"4"),array("Four +"=>"4 +"));
		return response()->json($Ownership);
	}
	public function doMasterCarType()
	{
		$Ownership 	= 	array(array("3"=>"Excellent"),array("2"=>"Medium"),array("1"=>"Good"));
		return response()->json($Ownership);
	}
	
	public function doMasterCustomerType()
	{
		$Ownership 	= 	array(array("id"=>1,"nametype"=>"Customer"),
							array("id"=>5,"nametype"=>"Dealer"),
							array("id"=>4,"nametype"=>"Broker"),
							array("id"=>2,"nametype"=>"Car Wale"),
							array("id"=>3,"nametype"=>"OLX"),
							array("id"=>6,"nametype"=>"Quickr"),
							array("id"=>7,"nametype"=>"Others")
							);
		return response()->json(['nametype'=>$Ownership]);
	}
	
	public function doMasterCarTransmission()
	{
		$variant_id		=	Input::get('variant_id'); 
		$id				=	Input::get('session_user_id'); 
		if($id == ""	||	$variant_id == "")
		{
			return response()->json(['Result'=>'0',
										'message'=>'variant id is required'
										]);
		}
		$where 			=	array('variant_id'=>$variant_id);
        $variant_cat 	= 	commonmodel::getAllRecordsWhere($this->materVariantTable,$where)->first();
        $getvariantid 	=	((count($variant_cat)>=1)?$variant_cat->category_id:'');
        $wherecate 		=	array('category_id'=>$getvariantid);        
        $category_tbl 	= 	commonmodel::getAllRecordsWhere($this->materCategoryTable,$wherecate)->first(); 
        $wherefeature 	=	array('variant_id'=>$variant_id);       
        $features 		= 	commonmodel::getAllRecordsWhere($this->materCarFeatureTable,$wherefeature)->first();
        $getfeatureid 	=	((count($features)>=1)?$features->Transmission_Type:'');
        $transmission 	=	array($getfeatureid);
		return response()->json(['Body_type'=>$category_tbl,
								'Fuel_type'=>$variant_cat,
								'Transmission_type'=>$transmission]);
	}
	public function doMasterCarFeatures()
	{
		return response()->json(commonmodel::getAllRecords($this->materCarFeatureTable));
	}
	public function doMasterColors()
	{
		$where 		=	array('enabled'=>'Y');
		return response()->json(commonmodel::getAllRecordsWhere($this->materColorTable,$where));
	}
	public function doMasterCountry()
	{
		return response()->json(commonmodel::getAllRecords($this->materCountryTable));
	}
	public function doMasterEmailTemplates()
	{
		return response()->json(commonmodel::getAllRecords($this->materEmailTempTable));
	}
	public function doMasterEmailTypes()
	{
		return response()->json(commonmodel::getAllRecords($this->masterEmailTypesTable));
	}
	/*public function master_features()
	{
		return response()->json(commonmodel::getAllRecords($this->masterFeatureTable));
	}
	public function master_menu()
	{
		return response()->json(commonmodel::getAllRecords($this->masterMenuTable));
	}*/
	
	public function doMasterPlans()
	{
		return response()->json(commonmodel::getAllRecords($this->masterPlansTable));
	}
	public function doMasterPlanFrequency()
	{
		return response()->json(commonmodel::getAllRecords($this->masterPlansFrequencyTable));
	}
	
	public function doMasterPlandatails()
	{
        $planid 		=	Input::get('plan_id');
        if($planid == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'Plan id is required!!'
									]);
		}																
		$where 		=	array('plan_type_id'=>$planid);
		$mastersub 	=	commonmodel::master_join_table_where($this->masterSubscriptionTable,
															$this->masterPlansFrequencyTable,
															'frequency_id',
															'frequency_id',
															$where);        
		return response()->json(['plan'=>$mastersub]);
		
	}
	//get plan details
	public function doApimasterplandetails()
	{
		$mastersub 	=	commonmodel::schema_join_Threetable(
															$this->masterPlansTable,
															$this->masterSubscriptionTable,
															$this->masterPlansFrequencyTable,
															'plan_type_id',
															'frequency_id',
															'frequency_id'
															);
		$basicdata 		=	array();
		$basicdetails 	=	array();
		$golddata 		=	array();
		$golddetails 	=	array();
		$premiumdata 	=	array();
		$predetails 	=	array();
		$freedata 		=	array();
		$freedetails 	=	array();
		if(!empty($mastersub) && count($mastersub) >=1)
		{
			foreach($mastersub as $plan)
			{
				if($plan->plan_type_id == 1)
				{
					$basicdetails	=	"BASIC";
					$basicdata[] 	=	$plan;
				}
				if($plan->plan_type_id == 2)
				{
					$golddetails	=	"GOLD";
					$golddata[] 	=	$plan;
				}
				if($plan->plan_type_id == 3)
				{
					$premiumdata	=	"PREMIUM";
					$predetails[] 	=	$plan;
				}
				if($plan->plan_type_id == 4)
				{
					$freedata		=	"FREE";
					$freedetails[] 	=	$plan;
				}
			}
		}
		return response()->json(array(array('planname'=>$basicdetails,'answer'=>'','plans'=>$basicdata),
										array('planname'=>$golddetails,'answer'=>'','plans'=>$golddata),
										array('planname'=>$premiumdata,'answer'=>'','plans'=>$predetails),
										array('planname'=>$freedata,'answer'=>'','plans'=>$freedetails)));
	}
	//end function 
	
	public function doMasterSchemaUsers()
	{
		return response()->json(commonmodel::getAllRecords($this->masterSchemaUsersTable));
	}
	
	public function doMasterState()
	{
		$statename 	= 	commonmodel::getAllRecords($this->masterStateTable);
		return response()->json(["result"=>1,
								"statename"=>$statename
								]);
	}
	public function doMasterSubscriptionPlans()
	{
		return response()->json(commonmodel::getAllRecords($this->masterSubscriptionTable));
	}
	/*public function master_text_template()
	{
		//return response()->json(commonmodel::getAllRecords($this->masterSubscriptionTable));
		$master_text_template = DB::connection('mastermysql')
										->table('master_text_template')
										->get();
		echo json_encode($master_text_template);
	}*/
	//GET SCHEMA NAME FUNCTION
    public function getschemaname($id)
    {
		$getdealer_schemaname 	  		=	inventorymodel::masterFetchTableDetails('',
																		'dms_dealers',
																		array('d_id'=>$id)
																		);
			$dealer_schemaname			= 	"";
			if(!empty($getdealer_schemaname) && count($getdealer_schemaname) > 0)
			{															
				foreach($getdealer_schemaname as $dealernameselect)
				{
					$dealer_schemaname	= 	$dealernameselect->dealer_schema_name;
				}
				return $dealer_schemaname;
			}
			else
			{
				return false;
			}
	}
}
