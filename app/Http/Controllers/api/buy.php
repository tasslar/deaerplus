<?php
namespace App\Http\Controllers\api;
use App\Http\Requests;
use App\Http\registervalidation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\buyymodel;
use App\model\inventorymodel;
use App\model\shortnerurl;
use App\model\common;
use App\model\commonmodel;
use App\model\dealermodel;
use App\model\emailmodel;
use App\model\fundingmodel;
use App\model\smsmodel;
use App\model\alertmodel;
use App\model\notificationsmodel;
use Illuminate\Support\Facades\Input;
use App\model\mongomodel;
use DB;
use Config;
use Carbon\Carbon;

class buy extends Controller
{
	public $materCityTable;
	public $masterApiSitesTable;
	public $masterCityfiled;
	public $masterSitefiled;
	public $masterMakeIdfiled;
	public $masterModelsTable;
	public $masterMakeTable;
	public $dealerViewedCarsTable;
	public $dealerSavedCarListingTable;
	public $masterMainLoginTable;
	public $dealerfunddingTable;
	public $dealermessageTable;
	public $dealerbiddingTable;
	public $alertcarhistoryTable;
	public function __construct(Request $request)
    {		
		$this->materCityTable				=	"master_city";
        $this->masterApiSitesTable  		= 	"master_api_sites";
        $this->masterCityfiled				=	"city_name";
        $this->masterSitefiled				=	"sitename";
        $this->masterMakeIdfiled        	=	"make_id";
        $this->masterModelsTable			=	"master_models";
        $this->masterMakeTable				=	"master_makes";
        $this->active_menu_name         	= 	"buy_menu";
        $this->dealerViewedCarsTable		=	"dealer_viewed_cars";
        $this->dealerSavedCarListingTable 	= 	"dealer_saved_carlisting";
        $this->masterMainLoginTable 		= 	"dms_dealers";
        $this->dealerfunddingTable 			= 	"dealer_funding_details";
        $this->dealermessageTable 			= 	"dealer_contact_message_transactions";
		$this->dealerbiddingTable			=	"dealer_bidding_details";
		$this->alertcarhistoryTable 		=	"dealer_alert_history";
	}
	/*Get All City and master sites  table*/
    public function doSearchlisting()
    {   
        $make 					= 	commonmodel::makedropdown();        
        $master_city 			= 	commonmodel::get_master_city();
        $car_budget 			= 	commonmodel::get_mater_budget();        
        $api_sites 				= 	commonmodel::get_api_sites();
        $get_listing_category 	= 	commonmodel::get_listing_category();
        $datalisting 			=	array();
        if(!empty($get_listing_category))
        {
			foreach($get_listing_category as $listing)
			{
				$datarole['category_id']			=	$listing->category_id;
				$datarole['category_description']	=	$listing->category_description;
				array_push($datalisting,$datarole);
			}
			$allbodytype 			=	array(array('category_id'=>4,
										'category_description'=>'All Body Type'));
			$get_listing_category 	=	array_merge($datalisting,$allbodytype);
		}
        
    	return response()->json(['Result'	=>'1',
								'message'	=>'success',
								'model_city'=>$master_city,
								'model_make'=>$make,
								'site_names'=>$api_sites,
								'car_budget'=>$car_budget,
								'Vehicle_type'=>$get_listing_category
								]);																	
    }
    /*Get All fetch Model Name table*/
    public function doFetchModel()
    {
        $make_id		=	Input::get('make');
        $wherecondition	=	array($this->masterMakeIdfiled=>$make_id);
        $make 			= 	commonmodel::getAllRecordsWhere($this->masterModelsTable,$wherecondition);
        if(count($make) != 0){
			return response()->json(['Result'	=>'7',
										'message'	=>'success',
										'model_makeid'=>$make
										]);
        }
        else{
            return response()->json(['Result'=>'0',
									'message'=>'failure'
										]);
        }
    }
	/*List All car listing mongo table*/
    public function doSearchCarlisting()
    {
        $city_name					=	"";
        $sortcategory				=	"";
        $sortbyfield				=	"";
        $message					=	"";
        $id                       	= 	urldecode(Input::get('session_user_id'));
        $listing_orwherecondition 	=	array();
        $listing_tag			 	=	array();
        $top_data 					= 	array();
        $topdata 					= 	array();
        $searchallcategory			= 	array();
		$schemaname 				=  $this->getschemaname($id);
		if(!empty($schemaname))
		{
			if(urldecode(Input::get('page_name'))=='searchpage')
			{
				$message 		=	"9";
				$car_sites      =	urldecode(Input::get('car_sites'));
				$city_name      =	urldecode(Input::get('city_name'));
				$radioInline    =	urldecode(Input::get('radioInline'));
				$vehicle_make   =	urldecode(Input::get('vehicle_make'));
				$vehicle_model  =	urldecode(Input::get('vehicle_model'));
				$car_budget     =	urldecode(Input::get('car_budget'));
				$vehicle_type   =	urldecode(Input::get('vehicle_type')); 
				if($id == "" )
				{
					return response()->json(['Result'=>'0',
										'message'=>'User id is required'
											]);
				}
				if($radioInline	==	1)
				{
					if(!empty($car_sites) && $car_sites !== "SelectWebsites" && $car_sites !== "Select Websites")
					{
						$listing_orwherecondition['sitename']  =	explode(',',ltrim($car_sites));
						 $listing_tag  					=	explode(',',ltrim($car_sites));
						 if(!empty($listing_tag) && count($listing_tag) >= 1)
						 {
							 foreach($listing_tag as $tagvalue)
							 {
								 if($tagvalue != "")
								 {
									 $topdata[]				=	"Sites:".$tagvalue;
								 }
							 }
						 }
					}
					 				 
					if($vehicle_make !== "Select Brand" && $vehicle_make != "")
					{
						$wherecondition				=	array($this->masterMakeIdfiled=>$vehicle_make);
						$getResultMakeName 			= 	commonmodel::getAllRecordsWhere($this->masterMakeTable,$wherecondition);
						if(!empty($getResultMakeName) && count($getResultMakeName)>=1)
						{	
							$listing_orwherecondition['make_id']	=	array($vehicle_make);
							foreach($getResultMakeName as $value)
							{
								$topdata[]			=	"Brand:".$value->makename;
							}						
						}
					}
					if($vehicle_model !== "Select Model" && $vehicle_model != "")
					{
						$listing_orwherecondition['model']	=	array($vehicle_model);
						$topdata[]					=	"Model:".$vehicle_model;
					} 
					if($city_name!='' && $city_name	!=='Select City' && $city_name	!=='SelectCity')
					{
						$listing_orwherecondition['car_locality']	=	array($city_name);
						$topdata[]					=	"City:".$city_name;
					}  
					$searchallcategory 				= 	array();
					array_push($top_data,$topdata); 
				}
				
				elseif ($radioInline	==	0) {
					if(!empty($car_sites) && $car_sites !== "SelectWebsites" && $car_sites !== "Select Websites")
					{
						 $listing_orwherecondition['sitename']  	=	explode(',',$car_sites);
						 $listing_tag  					=	explode(',',$car_sites);
						 if(!empty($listing_tag) && count($listing_tag) >= 1)
						 {
							 foreach($listing_tag as $tagvalue)
							 {
								 if($tagvalue != "")
								 {
									 $topdata[]				=	"Sites:".$tagvalue;
								 }
							 }
						 }
					}
					
					if($city_name!='' && $city_name	!=='Select City' && $city_name	!=='SelectCity')
					{
						$listing_orwherecondition['car_locality']	=	array($city_name);
						$topdata[]					=	"City:".$city_name;
					}
				   
					if($car_budget  !==  "Select Budget" && $car_budget != "") {					
						$car_budget_amount			=	"0-0";
						$wherecondition				=	array('budget_varient_name'=>$car_budget);
						$getResultbudget 			= 	commonmodel::getAllRecordsWhere('master_budget_varient',$wherecondition);
						if(!empty($getResultbudget) && count($getResultbudget)>=1)
						{	
							foreach($getResultbudget as $value)
							{
								$car_budget_amount	=	$value->budget_value;
								$topdata[]			=	"Budget:".$value->budget_varient_name;
							}						
						}
					$car_budget_expolde 			= 	explode('-',$car_budget_amount);
					$max_exp_price      			=	$car_budget_expolde[1];
					$min_exp_price     	 			=	$car_budget_expolde[0];
					
					if($max_exp_price == '<')
					  {		
						$listing_orwherecondition['sell_price']  =	array((int) $min_exp_price,(int) 50000000000000000);
					  }
					  else
					  {
						$listing_orwherecondition['sell_price']  =  array((int) $min_exp_price,(int) $max_exp_price);
					  }
					}

					if($vehicle_type !==  "Select Vehicle Types" && $vehicle_type != "" && $vehicle_type !==  "All Body Type")
					{
						$listing_orwherecondition['body_type']	=	array($vehicle_type);
						$topdata[]					=	"BodyType:".$vehicle_type;
					}  
					array_push($top_data,$topdata); 
					$searchallcategory 				= 	array();
				}
			}
			elseif (urldecode(Input::get('page_name'))	==	'detail_searchpage') {
				$message 		=	"1";
				$city_name		=	urldecode(Input::get('city_name'));
				$sortcategory	=	urldecode(Input::get('sorting_category'));
				if($city_name!=	'')
				{
					$listing_orwherecondition['car_locality']	=	array($city_name);
					$topdata[]							=	"City:".$city_name;
				}
				
				$search_listing							=	urldecode(Input::get('search_listing'));
				if($search_listing!='')
				{
					$searchallcategory 					= array('make'=>$search_listing,
																	'model'=>$search_listing,
																	'variant'=>$search_listing
																	);
					$topdata[]					  		=	"Search:".$search_listing;
				}
				array_push($top_data,$topdata); 
			}
			
			switch($sortcategory)
			{
				case 0:
				$sortbyfield				=	"desc";
				$sortcategoryfield			=	"sell_price";
				$mongo_carlisting_details 	= 	buyymodel::doMongofetchCity($id,
																	$listing_orwherecondition,
																	$searchallcategory,
																	$sortcategoryfield,
																	$sortbyfield
																	);
				break;
				case 1:
				$sortbyfield				=	"desc";
				$sortcategoryfield			=	"sell_price";
				$mongo_carlisting_detail 	= 	buyymodel::doMongofetchCity($id,
																	$listing_orwherecondition,
																	$searchallcategory,
																	$sortcategoryfield,
																	$sortbyfield
																	);
				$mongo_carlisting_details 	=	$mongo_carlisting_detail->sortByDesc('sell_price');
				break;
				case 2:
				$sortbyfield				=	"asc";
				$sortcategoryfield			=	"sell_price";
				$mongo_carlisting_detail 	= 	buyymodel::doMongofetchCity($id,
																	$listing_orwherecondition,
																	$searchallcategory,
																	$sortcategoryfield,
																	$sortbyfield
																	);
				$mongo_carlisting_details 	=	$mongo_carlisting_detail->sortBy('sell_price');
				break;
				case 3:
				$sortbyfield				=	"desc";
				$sortcategoryfield			=	"kilometer_run";
				$mongo_carlisting_detail 	= 	buyymodel::doMongofetchCity($id,
																	$listing_orwherecondition,
																	$searchallcategory,
																	$sortcategoryfield,
																	$sortbyfield
																	);
				$mongo_carlisting_details 	=	$mongo_carlisting_detail->sortByDesc('kilometer_run');
				break;	
				case 4:
				$sortbyfield				=	"asc";
				$sortcategoryfield			=	"kilometer_run";
				$mongo_carlisting_detail 	= 	buyymodel::doMongofetchCity($id,
																	$listing_orwherecondition,
																	$searchallcategory,
																	$sortcategoryfield,
																	$sortbyfield
																	);
				$mongo_carlisting_details 	=	$mongo_carlisting_detail->sortBy('kilometer_run');
				break;
				case 5:
				$sortbyfield				=	"desc";
				$sortcategoryfield			=	"registration_year";
				$mongo_carlisting_detail 	= 	buyymodel::doMongofetchCity($id,
																	$listing_orwherecondition,
																	$searchallcategory,
																	$sortcategoryfield,
																	$sortbyfield
																	);
				$mongo_carlisting_details 	=	$mongo_carlisting_detail->sortByDesc('registration_year');
				break;
				case 6:
				$sortbyfield				=	"asc";
				$sortcategoryfield			=	"registration_year";
				$mongo_carlisting_detail 	= 	buyymodel::doMongofetchCity($id,
																	$listing_orwherecondition,
																	$searchallcategory,
																	$sortcategoryfield,
																	$sortbyfield
																	);
				$mongo_carlisting_details 	=	$mongo_carlisting_detail->sortBy('registration_year');
				break;
				case 7:
				$sortbyfield				=	"asc";
				$sortcategoryfield			=	"registration_year";
				$mongo_carlisting_details 	= 	buyymodel::doMongofetchCity($id,
																	$listing_orwherecondition,
																	$searchallcategory,
																	$sortcategoryfield,
																	$sortbyfield
																	);
				break;
				case 8:
				$sortbyfield				=	"asc";
				$sortcategoryfield			=	"registration_year";
				$mongo_carlisting_detail 	= 	buyymodel::doMongofetchCity($id,
																	$listing_orwherecondition,
																	$searchallcategory,
																	$sortcategoryfield,
																	$sortbyfield
																	);
				$mongo_carlisting_details 	=	$mongo_carlisting_detail->sortBy('created_at');
				break;
				default:
				$sortbyfield				=	"desc";
				$sortcategoryfield			=	"sell_price";
				$mongo_carlisting_details 	= 	buyymodel::doMongofetchCity($id,
																	$listing_orwherecondition,
																	$searchallcategory,
																	$sortcategoryfield,
																	$sortbyfield
																	);																
				
			}			
																	
			if(!empty($mongo_carlisting_details) && count($mongo_carlisting_details)>=1)
			{
			$data                     		=	array();
			$listing_details          		=	array();        
			foreach ($mongo_carlisting_details as $key => $value) {
			   $data['make']              	= 	$value["make"];
			   $data['make_id']           	= 	$value["make_id"];
			   $data['model']             	= 	$value["model"];
			   $data['variant']           	= 	$value["variant"];           
			   $data['car_locality']      	= 	$value["car_locality"];
			   $data['registration_year'] 	= 	$value["registration_year"];
			   $data['daysstmt']			=	Carbon::parse($value["created_at"])->diffForHumans();
			   $data['kilometer_run']    	= 	$value["kilometer_run"];
			   $data['fuel_type']         	= 	$value["fuel_type"];
			   $data['owner_type']        	= 	$value["owner_type"];
			   $data['price']             	= 	$value["sell_price"];
			   $data['car_id']            	= 	$value["listing_id"];
			   $data['dealer_id']         	= 	$value["dealer_id"];
			   if($value["listing_selection"] == 1)
			   {
					$data['bid_image']    	= 	stripcslashes(config::get("common.thumbimage"));
				}
				else
				{
					$data['bid_image']    	= 	stripcslashes(config::get("common.whiteimage"));
				}
			   
			   
			   $getdealer_schemaname 	  	=	buyymodel::masterFetchTableDetails('',
																		$this->masterMainLoginTable,
																		array('d_id'=>$id)
																		);
				$dealer_schemaname			= 	"";
				if(!empty($getdealer_schemaname) && count($getdealer_schemaname) > 0 )
				{															
					foreach($getdealer_schemaname as $dealername)
					{
						$dealer_schemaname	= 	$dealername->dealer_schema_name;
					}
				$count_dealer_viewed_cars   =	buyymodel::dealerTableCount($id,
															$dealer_schemaname,
															$this->dealerViewedCarsTable,
															array('car_id'=>$value["listing_id"],
															'dealer_id'=>$id)
															);

			   $count_dealer_saved_cars     =	buyymodel::dealerTableCount($id,
															$dealer_schemaname,
															$this->dealerSavedCarListingTable,
															array('car_id'=>$value["listing_id"],
															'dealer_id'=>$id,'saved_status'=>'1')
															);

			   $data['no_images']           = 	count($value["photos"]);
			   $photos_array                =	array();
			   
			   if(count($value["photos"])>0)
			   {
				foreach ($value["photos"] as $photokey => $photovalue) {
					$photos_array[]			=	$photovalue['s3_bucket_path'];
			   }
				$data['imagelinks'] 		= 	stripcslashes($photos_array[0]);
			   }
			   else
			   {
				$carnoimage 				= 	url(Config::get('common.carnoimage'));
				$data['imagelinks'] 		=	stripcslashes($carnoimage);
			   }
			   
			   $data['saved_car']           = 	$count_dealer_saved_cars;
			   $data['compare_car']         = 	'1';
			   $whereconalert 				=	array("alert_listingid"=>$value["listing_id"]);
			   $checkcaridexist 			= 	buyymodel::masterFetchTableDetails(
																	$id,																
																	$this->alertcarhistoryTable,
																	$whereconalert
																	);
			   if(!empty($checkcaridexist) && count($checkcaridexist)>=1)
			   {
				  if($checkcaridexist[0]->alert_status == 1)
				  {
					  $data['notify_car']   = 	$checkcaridexist[0]->alert_status;
				  }
				  else
				  {
					  $data['notify_car']   = 	$checkcaridexist[0]->alert_status;
				  }
			   }
			   else
			   {
				  $data['notify_car']       =  0;
			   }																		
			   $data['view_car']            = 	$count_dealer_viewed_cars;
			   $data['auction']             = 	(string)$value['listing_selection'];
			   $get_api_sites               = 	buyymodel::masterFetchTableDetails($id,$this->masterApiSitesTable,
													  array($this->masterSitefiled=>$value['sitename']));
			   if(!empty($get_api_sites))
			   {
				  $get_logo_url        		= 	$get_api_sites[0]->logourl;
				  $data['site_id']          = 	$get_api_sites[0]->id;
			   }
			   else
			   {
				  $get_logo_url        		= 	'';
				  $data['site_id']          = 	'';
			   }
			   
			   $data['site_image']         	= 	stripcslashes(url($get_logo_url));
			   array_push($listing_details,$data);
				}
			}
			}	
			
			else
			{
				return response()->json(['Result'=>$message,
										'message'=>'No Records Found!!'
										]);
			}
			 return response()->json(['Result'=>$message,
										'message'=>'success',
										'city_name'=>$city_name,
										'car_listing'=>$listing_details,
										'top_note'=>$topdata
											]); 
		}
		return response()->json(['Result'=>'0',
									'message'=>'Invalid Access'
									]);     
    
    } 
    
    
    
    /*List All car listing mongo table*/
    public function doSearchCarlistingTagfilter()
    {
        if(Input::get('page_name')=='tagsearchpage')
        {
            $car_sites      			=	urldecode(Input::get('tag_values'));
            $id      					=	Input::get('session_user_id');
            $sortcategory   			=	Input::get('sorting_category');	
			$listing_wherecondition 	=	array();
			$likewherecondition 		=	array();
			$topdata 					= 	array();
			$searchallcategory			= 	array();
			$data                     	=	array();
			$listing_details          	=	array();
            if($id == "")
            {
				return response()->json(['Result'=>'0',
									'message'=>'User Id is required'
										]);
			}
            
			$listing_tag  	=	explode(',',$car_sites);
			if(!empty($listing_tag) && count($listing_tag) >= 1)
			{
				foreach($listing_tag as $tagvalue)
				{
					if($tagvalue != "")
					{
						if(strpos($tagvalue,'Sites') !== false)
						{
							$listing_wherecondition['sitename'][]	= 	substr($tagvalue, strpos($tagvalue, ":")+1);
						}
						if(strpos($tagvalue,'ListingType') !== false)
						{
							$listingvalue 	=	substr($tagvalue, strpos($tagvalue, ":")+1);
							if($listingvalue == "Listing")
							{
								$listing_wherecondition['listing_selection'][]	= 	0;
							}
							if($listingvalue == "Auction")
							{
								$listing_wherecondition['listing_selection'][]	= 	1;
							}
						}
						if(strpos($tagvalue,'Brand') !== false)
						{
							$listing_wherecondition['make'][]		= 	substr($tagvalue, strpos($tagvalue, ":")+1); 
						}
						if(strpos($tagvalue,'City') !== false)
						{
							$listing_wherecondition['car_locality'][]	= 	substr($tagvalue, strpos($tagvalue, ":")+1); 
						}
						if(strpos($tagvalue,'Model') !== false)
						{
							$listing_wherecondition['model'][]		= 	substr($tagvalue, strpos($tagvalue, ":")+1); 
						}
						if(strpos($tagvalue,'Year') !== false)
						{
							$listing_wherecondition['registration_year'][]	= 	substr($tagvalue, strpos($tagvalue, ":")+1); 
						}
						if(strpos($tagvalue,'Transmission') !== false)
						{
							$listing_wherecondition['transmission'][]	= 	substr($tagvalue, strpos($tagvalue, ":")+1); 
						}
						if(strpos($tagvalue,'FuelType') !== false)
						{
							$listing_wherecondition['fuel_type'][]	= 	substr($tagvalue, strpos($tagvalue, ":")+1); 
						}
						if(strpos($tagvalue,'BodyType') !== false)
						{
							$listing_wherecondition['body_type'][]	= 	substr($tagvalue, strpos($tagvalue, ":")+1); 
						}
						if(strpos($tagvalue,'Budget') !== false)
						{
							$car_budget					= 	substr($tagvalue, strpos($tagvalue, ":")+1);
							$car_budget_amount			=	"0-0";
							$wherecondition				=	array('budget_varient_name'=>$car_budget);
							$getResultbudget 			= 	commonmodel::getAllRecordsWhere('master_budget_varient',$wherecondition);
							if(!empty($getResultbudget) && count($getResultbudget)>=1)
							{	
								foreach($getResultbudget as $value)
								{
									$car_budget_amount	=	$value->budget_value;
								}						
							}
							$car_budget_expolde 					= 	explode('-',$car_budget_amount);
							$max_exp_price      					=	$car_budget_expolde[1];
							$min_exp_price     	 					=	$car_budget_expolde[0];
							if($max_exp_price == '<')
							{
								$listing_wherecondition['sell_price']  =	array((int) $min_exp_price,(int) 50000000000000000);
							}
							else
							{
								$listing_wherecondition['sell_price']  =  array((int) $min_exp_price,(int)$max_exp_price);
							}
						}
						if(strpos($tagvalue,'Search') !== false)
						{
							$likewherecondition['make'][]		= 	substr($tagvalue, strpos($tagvalue, ":")+1); 
							$likewherecondition['Model'][]		= 	substr($tagvalue, strpos($tagvalue, ":")+1); 
							$likewherecondition['variant'][]	= 	substr($tagvalue, strpos($tagvalue, ":")+1); 
						}
					}
				 }
			}
			
        switch($sortcategory)
        {
			case 0:
			$sortbyfield				=	"desc";
			$sortcategoryfield			=	"sell_price";
			$mongo_carlisting_details 	= 	buyymodel::doSearchMongofetchtag($id,
																$listing_wherecondition,
																$likewherecondition,
																$sortcategoryfield,
																$sortbyfield
																);
			case 1:
			$sortbyfield				=	"desc";
			$sortcategoryfield			=	"sell_price";
			$mongo_carlisting_detail 	= 	buyymodel::doSearchMongofetchtag($id,
																$listing_wherecondition,
																$likewherecondition,
																$sortcategoryfield,
																$sortbyfield
																);
			$mongo_carlisting_details 	=	$mongo_carlisting_detail->sortByDesc('sell_price');
            break;
            case 2:
			$sortbyfield				=	"asc";
			$sortcategoryfield			=	"sell_price";
			$mongo_carlisting_detail 	= 	buyymodel::doSearchMongofetchtag($id,
																$listing_wherecondition,
																$likewherecondition,
																$sortcategoryfield,
																$sortbyfield
																);
			$mongo_carlisting_details 	=	$mongo_carlisting_detail->sortBy('sell_price');
            break;
            case 3:
			$sortbyfield				=	"desc";
			$sortcategoryfield			=	"kilometer_run";
			$mongo_carlisting_detail 	= 	buyymodel::doSearchMongofetchtag($id,
																$listing_wherecondition,
																$likewherecondition,
																$sortcategoryfield,
																$sortbyfield
																);
			$mongo_carlisting_details 	=	$mongo_carlisting_detail->sortByDesc('kilometer_run');
            break;	
            case 4:
			$sortbyfield				=	"asc";
			$sortcategoryfield			=	"kilometer_run";
			$mongo_carlisting_detail 	= 	buyymodel::doSearchMongofetchtag($id,
																$listing_wherecondition,
																$likewherecondition,
																$sortcategoryfield,
																$sortbyfield
																);
			$mongo_carlisting_details 	=	$mongo_carlisting_detail->sortBy('kilometer_run');
            break;
            case 5:
			$sortbyfield				=	"desc";
			$sortcategoryfield			=	"registration_year";
			$mongo_carlisting_detail 	= 	buyymodel::doSearchMongofetchtag($id,
																$listing_wherecondition,
																$likewherecondition,
																$sortcategoryfield,
																$sortbyfield
																);
			$mongo_carlisting_details 	=	$mongo_carlisting_detail->sortByDesc('registration_year');
            break;
            case 6:
			$sortbyfield				=	"asc";
			$sortcategoryfield			=	"registration_year";
			$mongo_carlisting_detail 	= 	buyymodel::doSearchMongofetchtag($id,
																$listing_wherecondition,
																$likewherecondition,
																$sortcategoryfield,
																$sortbyfield
																);
			$mongo_carlisting_details 	=	$mongo_carlisting_detail->sortBy('registration_year');
            break;
            case 7:
			$sortbyfield				=	"asc";
			$sortcategoryfield			=	"registration_year";
			$mongo_carlisting_details 	= 	buyymodel::doSearchMongofetchtag($id,
																$listing_wherecondition,
																$likewherecondition,
																$sortcategoryfield,
																$sortbyfield
																);
			break;
			case 8:
			$sortbyfield				=	"asc";
			$sortcategoryfield			=	"registration_year";
			$mongo_carlisting_detail 	= 	buyymodel::doSearchMongofetchtag($id,
																$listing_wherecondition,
																$likewherecondition,
																$sortcategoryfield,
																$sortbyfield
																);
			$mongo_carlisting_details 	=	$mongo_carlisting_detail->sortBy('created_at');
			break;
            default:
            $sortbyfield				=	"desc";
			$sortcategoryfield			=	"sell_price";
			$mongo_carlisting_details 	= 	buyymodel::doSearchMongofetchtag($id,
																$listing_wherecondition,
																$likewherecondition,
																$sortcategoryfield,
																$sortbyfield
																);																
		}
		if($car_sites == "")
		{
			switch($sortcategory)
			{
				case 1:
				$mongo_carlisting_details 	= 	buyymodel::doSearchgetallMongofetch($id,
																'sell_price',
																'desc'
																);
				$mongo_carlisting_details 	=	$mongo_carlisting_detail->sortByDesc('sell_price');
				break;
				case 2:
				$mongo_carlisting_detail 	= 	buyymodel::doSearchgetallMongofetch($id,
																'sell_price',
																'asc'
																);
				$mongo_carlisting_details 	=	$mongo_carlisting_detail->sortBy('sell_price');
				break;
				case 3:
				$mongo_carlisting_detail 	= 	buyymodel::doSearchgetallMongofetch($id,
																'kilometer_run',
																'desc'
																);
				$mongo_carlisting_details 	=	$mongo_carlisting_detail->sortByDesc('kilometer_run');
				break;	
				case 4:
				$mongo_carlisting_detail 	= 	buyymodel::doSearchgetallMongofetch($id,
																'kilometer_run',
																'asc'
																);
				$mongo_carlisting_details 	=	$mongo_carlisting_detail->sortBy('kilometer_run');
				break;
				case 5:
				$mongo_carlisting_detail 	= 	buyymodel::doSearchgetallMongofetch($id,
																'registration_year',
																'desc'
																);
				$mongo_carlisting_details 	=	$mongo_carlisting_detail->sortByDesc('registration_year');
				break;
				case 6:
				$mongo_carlisting_detail 	= 	buyymodel::doSearchgetallMongofetch($id,
																'registration_year',
																'asc'
																);
				$mongo_carlisting_details 	=	$mongo_carlisting_detail->sortBy('registration_year');
				break;
				case 7:
				$mongo_carlisting_details 	= 	buyymodel::doSearchgetallMongofetch($id,
																'created_at',
																'desc'
																);
				break;
				case 8:
				$mongo_carlisting_detail 	= 	buyymodel::doSearchgetallMongofetch($id,
																'created_at',
																'asc'
																);
				$mongo_carlisting_details 	=	$mongo_carlisting_detail->sortBy('created_at');
				break;
				default:
				$mongo_carlisting_details 	= 	buyymodel::doSearchgetallMongofetch($id,
																'sell_price',
																'desc'
																);														
			}
		}
		
        if(!empty($mongo_carlisting_details) && count($mongo_carlisting_details)>=1)
        {       
			foreach ($mongo_carlisting_details as $key => $value) 
			{
				$data['make']              	= 	$value["make"];
				$data['make_id']           	= 	$value["make_id"];
				$data['model']             	= 	$value["model"];
				$data['variant']           	= 	$value["variant"];           
				$data['car_locality']      	= 	$value["car_locality"];
				$data['registration_year'] 	= 	$value["registration_year"];
				$data['daysstmt']			=	Carbon::parse($value["created_at"])->diffForHumans();
				$data['kilometer_run']    	= 	$value["kilometer_run"];

				$data['fuel_type']         	= 	$value["fuel_type"];

				$data['owner_type']        	= 	$value["owner_type"];
				$data['price']             	= 	$value["sell_price"];				

				$data['car_id']            	= 	$value["listing_id"];


				$data['dealer_id']         	= 	$value["dealer_id"];
				if($value["listing_selection"] == 1)
				{
				$data['bid_image']    		= 	stripcslashes(config::get("common.thumbimage"));
				}
				else
				{
				$data['bid_image']    		= 	stripcslashes(config::get("common.whiteimage"));
				}


				$getdealer_schemaname 	  	=		buyymodel::masterFetchTableDetails('',
																	$this->masterMainLoginTable,
																	array('d_id'=>$id)
																	);
				$dealer_schemaname			= 	"";
				if(!empty($getdealer_schemaname) && count($getdealer_schemaname) > 0 )
				{															
					foreach($getdealer_schemaname as $dealername)
					{
						$dealer_schemaname	= 	$dealername->dealer_schema_name;
					}
					$count_dealer_viewed_cars 	=	buyymodel::dealerTableCount($id,
															$dealer_schemaname,
															$this->dealerViewedCarsTable,
															array('car_id'=>$value["listing_id"],
															'dealer_id'=>$id)
															);

					$count_dealer_saved_cars 	=	buyymodel::dealerTableCount($id,
															$dealer_schemaname,
															$this->dealerSavedCarListingTable,
															array('car_id'=>$value["listing_id"],
															'dealer_id'=>$id,'saved_status'=>'1')
															);

					$data['no_images']          = 	count($value["photos"]);
					$photos_array               =	array();

					if(count($value["photos"])>0)
					{
					foreach ($value["photos"] as $photokey => $photovalue) {
					$photos_array[]			=	$photovalue['s3_bucket_path'];
					}
					$data['imagelinks'] 		= 	$photos_array[0];
					}
					else
					{
					$carnoimage 				= 	Config::get('common.carnoimage');
					$data['imagelinks'] 		=	stripcslashes($carnoimage);
					}

					$data['saved_car']          = 	$count_dealer_saved_cars;
					$data['compare_car']        = 	'1';
					$whereconalert 				=	array("alert_listingid"=>$value["listing_id"]);
					$checkcaridexist 			= 	buyymodel::masterFetchTableDetails(
																	$id,																
																	$this->alertcarhistoryTable,
																	$whereconalert
																	);
					if(!empty($checkcaridexist) && count($checkcaridexist)>=1)
					{
						if($checkcaridexist[0]->alert_status == 1)
						{
						  $data['notify_car']   = 	$checkcaridexist[0]->alert_status;
						}
						else
						{
						  $data['notify_car']   = 	$checkcaridexist[0]->alert_status;
						}
						}
					else
					{
					$data['notify_car']       	=  0;
					}																		
				$data['view_car']            	= 	$count_dealer_viewed_cars;
				$data['auction']             	= 	(string)$value['listing_selection'];
				$get_api_sites               	= 	buyymodel::masterFetchTableDetails($id,$this->masterApiSitesTable,
													array($this->masterSitefiled=>$value['sitename']));
				if(!empty($get_api_sites))
				{
					$get_logo_url        		= 	$get_api_sites[0]->logourl;
					$data['site_id']          	= 	$get_api_sites[0]->id;
				}
				else
				{
					$get_logo_url        		= 	'';
					$data['site_id']          	= 	'';
				}

				$data['site_image']         	= 	stripcslashes(url($get_logo_url));
				
				}
				array_push($listing_details,$data);
			}
		}	
		 return response()->json(['Result'=>1,
									'message'=>'success',
                                    'car_listing'=>$listing_details,
                                    'top_note'=>$listing_tag
										]);
	}
	else
	{
		return response()->json(['Result'=>0,
									'message'=>'Invalid Access'
										]);
	}
    
    }
    
    /*FINAL FILTER CAR*/
    public function doSearchCarlistingFilter()
    {
        $id                       	= 	urldecode(Input::get('session_user_id'));
        $top_data 					= 	array();
        $topdata 					= 	"";
        $data                     	=	array();
		$listing_details          	=	array(); 
        if(urldecode(Input::get('page_name'))=='finalfilter')
        {
		$schemaname 			=  $this->getschemaname($id);
		if(!empty($schemaname))
		{
            $car_sites      	=	urldecode(Input::get('car_sites'));
            $listing_types  	=	urldecode(Input::get('listing_types'));
            $vehicle_make   	=	urldecode(Input::get('vehicle_make'));
            $vehicle_model  	=	urldecode(Input::get('vehicle_model'));
            $register_year  	=	urldecode(Input::get('register_year'));
            $transmission_type  =	urldecode(Input::get('transmission_type'));
            $fuel_type  		=	urldecode(Input::get('fuel_type'));
            $car_budget     	=	urldecode(Input::get('car_budget'));
            $vehicle_type   	=	urldecode(Input::get('vehicle_type')); 
            $sortcategory   	=	urldecode(Input::get('sorting_category')); 
            $sitearray 			=	array();
            $listingarray 		=	array();
            $listingsitearray 	=	array();
            $makedata 			=	array();
            $modeldata 			=	array();
            $yeardata 			=	array();
            $transmissiondata 	=	array();
            $fueldata 			=	array();
            $dataoftopnote 		=	array();
            if($id == "")
            {
				return response()->json(['Result'=>'0',
									'message'=>'User id is required'
										]);
			}
            
            if(!empty($car_sites) && $car_sites !== "SelectCarSites" && $car_sites !== "Select Car Sites")
            {
				 $listing_tag  		=	explode(',',$car_sites);
				 if(!empty($listing_tag) && count($listing_tag) >= 1)
				 {
					 foreach($listing_tag as $tagvalue)
					 {
						 if($tagvalue 	!=	"")
						 {
							 $sitearray[] =	$tagvalue;
							 $topdata				.=	"Sites:".$tagvalue.',';
						 }
					 }
					 $listingsitearray['sitename'] = $sitearray;
				 }
			 }		

			if($listing_types !== "SelectListingTypes" && $listing_types != "" && $listing_types !== "Select Listing Types")
			{
				$filterarray 	=	explode(',',$listing_types);
				foreach($filterarray as $k=>$val)
				{
					if($val	==	"Listing")
					{
						$listingarray['listing_selection'] = 	0;
						$topdata				.=	"ListingType:".$val.',';
					}
					if($val	==	"Auction")
					{
						$listingarray[] =	1;
						$topdata				.=	"ListingType:".$val.',';
					}
				}
				$listingsitearray['listing_selection'] = $listingarray;
			}
			
			if($vehicle_make !== "SelectMake" && $vehicle_make != "" && $vehicle_make !== "Select Make")
			{
				$vehiclearray 				=	explode(',',$vehicle_make);
				$getResultMakeName 			= 	buyymodel::dealerFetchWherein(
																		$this->masterMakeTable,
																		$this->masterMakeIdfiled,
																		$vehiclearray);
				if(!empty($getResultMakeName) && count($getResultMakeName)>=1)
				{	
					foreach($getResultMakeName as $value)
					{
						$makedata[]	=	$value->makename;
						$topdata			.=	"Brand:".$value->makename.',';
					}	
					$listingsitearray['make'] = $makedata;					
				}
			}
			
			//GET MODEL NAME BASED ON MAKE ID
			if($vehicle_model !== "SelectModel" && $vehicle_model != "" && $vehicle_model !== "Select Model")
			{
				$vehiclearray 				=	explode(',',$vehicle_model);
				$getResultMakeName 			= 	buyymodel::dealerFetchWherein(
																		$this->masterModelsTable,
																		'model_name',
																		$vehiclearray);
				if(!empty($getResultMakeName) && count($getResultMakeName)>=1)
				{	
					foreach($getResultMakeName as $value)
					{
						$modeldata[]	=	$value->model_name;
						$topdata			.=	"Model:".$value->model_name.',';
					}		
					$listingsitearray['model'] = $modeldata;				
				}
			}
            
            //GET REGISTRATION YEAR
			if($register_year !== "SelectYear" && $register_year != "" && $register_year !== "Select Year")
			{
				$vehiclearray 				=	explode(',',$register_year);
				if(!empty($vehiclearray) && count($vehiclearray)>=1)
				{	
					foreach($vehiclearray as $value)
					{
						$yeardata[]	=	$value;
						$topdata			.=	"Year:".$value.',';
					}			
					$listingsitearray['registration_year'] = $yeardata;			
				}
			}
			//GET Transmission YEAR
			if($transmission_type !== "SelectTransmission" && $transmission_type != "" && $transmission_type !== "Select Transmission")
			{
				$vehiclearray 				=	explode(',',$transmission_type);
				if(!empty($vehiclearray) && count($vehiclearray)>=1)
				{	
					foreach($vehiclearray as $value)
					{
						$transmissiondata[]	=	$value;
						$topdata			.=	"Transmission:".$value.',';
					}			
					$listingsitearray['transmission'] = $transmissiondata;						
				}
			}
			//GET FUEL TYPE YEAR
			if($fuel_type !== "SelectFuelType" && $fuel_type != "" && $fuel_type !== "Select Fuel Type")
			{
				$vehiclearray 				=	explode(',',$fuel_type);
				if(!empty($vehiclearray) && count($vehiclearray)>=1)
				{	
					foreach($vehiclearray as $value)
					{
						$fueldata[]	=	$value;
						$topdata				.=	"FuelType:".$value.',';
					}						
					$listingsitearray['fuel_type'] = $fueldata;	
				}
			}
            //GET BODY TYPE YEAR
			if($vehicle_type !== "SelectBodyType" && $vehicle_type != "" && $vehicle_type !== "Select Body Type")
			{
				$vehiclearray 				=	explode(',',$vehicle_type);
				if(!empty($vehiclearray) && count($vehiclearray)>=1)
				{	
					foreach($vehiclearray as $value)
					{
						$bodydata[]	=	$value;
						$topdata				.=	"Type:".$value.',';
					}					
					$listingsitearray['body_type'] = $bodydata;		
				}
			}

			 //GET BUDGET TYPE
			if($car_budget != "" && $car_budget !== "SelectPriceRange" && $car_budget !== "Select Price Range")
			{
				$explode_data			=	array();
				$budget_array         	= 	array();
				$budget_data          	= 	array();
				$where 					=	array('budget_varient_name'=>$car_budget);
				$master_budget_varient	= 	commonmodel::getAllRecordsvalues('master_budget_varient',
																					$where,
																					'budget_value');
				if(!empty($master_budget_varient))
				{
					$explode_data 				= 	explode("-",$master_budget_varient);
					$min_exp_price 				= 	$explode_data[0];
					$max_exp_price 				= 	$explode_data[1];
					if($explode_data[1]=='<')
					{
						$budget_data[]  =	array((int) $min_exp_price,(int)50000000000000000);
					}
					else
					{
						$budget_data[]  =	array((int) $min_exp_price,(int) $max_exp_price);
					}
					$topdata					.=	"Budget:".$car_budget;
					$listingsitearray['sell_price'] = $budget_data;		
				}
			} 
			$topnotedata 	=	explode(',',$topdata);
			foreach($topnotedata as $value)
			{
				if(!empty($value))
				{
					$dataoftopnote[] 	=	$value;
				}
			}
            
        switch($sortcategory)
        {
			case 0:
			$sortbyfield				=	"desc";
			$sortcategoryfield			=	"sell_price";
			$mongo_carlisting_details 	= 	buyymodel::doSearchMongofetchfilter($id,
																$listingsitearray,
																$sortcategoryfield,
																$sortbyfield
																);
			case 1:
			$sortbyfield				=	"desc";
			$sortcategoryfield			=	"sell_price";
			$mongo_carlisting_detail 	= 	buyymodel::doSearchMongofetchfilter($id,
																$listingsitearray,
																$sortcategoryfield,
																$sortbyfield
																);
			$mongo_carlisting_details 	=	$mongo_carlisting_detail->sortByDesc('sell_price');
			
            break;
            case 2:
			$sortbyfield				=	"asc";
			$sortcategoryfield			=	"sell_price";
			$mongo_carlisting_detail 	= 	buyymodel::doSearchMongofetchfilter($id,
																$listingsitearray,
																$sortcategoryfield,
																$sortbyfield
																);
			$mongo_carlisting_details 	=	$mongo_carlisting_detail->sortBy('sell_price');
            break;
            case 3:
			$sortbyfield				=	"desc";
			$sortcategoryfield			=	"kilometer_run";
			$mongo_carlisting_detail 	= 	buyymodel::doSearchMongofetchfilter($id,
																$listingsitearray,
																$sortcategoryfield,
																$sortbyfield
																);
			$mongo_carlisting_details 	=	$mongo_carlisting_detail->sortByDesc('kilometer_run');
            break;	
            case 4:
			$sortbyfield				=	"asc";
			$sortcategoryfield			=	"kilometer_run";
			$mongo_carlisting_detail 	= 	buyymodel::doSearchMongofetchfilter($id,
																$listingsitearray,
																$sortcategoryfield,
																$sortbyfield
																);
			$mongo_carlisting_details 	=	$mongo_carlisting_detail->sortBy('kilometer_run');
            break;
            case 5:
			$sortbyfield				=	"desc";
			$sortcategoryfield			=	"registration_year";
			$mongo_carlisting_detail 	= 	buyymodel::doSearchMongofetchfilter($id,
																$listingsitearray,
																$sortcategoryfield,
																$sortbyfield
																);
			$mongo_carlisting_details 	=	$mongo_carlisting_detail->sortByDesc('registration_year');
            break;
            case 6:
			$sortbyfield				=	"asc";
			$sortcategoryfield			=	"registration_year";
			$mongo_carlisting_detail 	= 	buyymodel::doSearchMongofetchfilter($id,
																$listingsitearray,
																$sortcategoryfield,
																$sortbyfield
																);
			$mongo_carlisting_details 	=	$mongo_carlisting_detail->sortBy('registration_year');
            break;
            case 7:
			$sortbyfield				=	"asc";
			$sortcategoryfield			=	"registration_year";
			$mongo_carlisting_detail 	= 	buyymodel::doSearchMongofetchfilter($id,
																$listingsitearray,
																$sortcategoryfield,
																$sortbyfield
																);
			$mongo_carlisting_details 	=	$mongo_carlisting_detail->sortByDesc('created_at');
			break;
			case 8:
			$sortbyfield				=	"asc";
			$sortcategoryfield			=	"registration_year";
			$mongo_carlisting_detail 	= 	buyymodel::doSearchMongofetchfilter($id,
																$listingsitearray,
																$sortcategoryfield,
																$sortbyfield
																);
			$mongo_carlisting_details 	=	$mongo_carlisting_detail->sortBy('created_at');
			break;
            default:
            $sortbyfield				=	"desc";
			$sortcategoryfield			=	"sell_price";
			$mongo_carlisting_details 	= 	buyymodel::doSearchMongofetchfilter($id,
																$listingsitearray,
																$sortcategoryfield,
																$sortbyfield
																);																
		}

        if(!empty($mongo_carlisting_details) && count($mongo_carlisting_details)>=1)
        {
				foreach ($mongo_carlisting_details as $key => $value) {
				   $data['make']              	= 	$value["make"];
				   $data['make_id']           	= 	$value["make_id"];
				   $data['model']             	= 	$value["model"];
				   $data['variant']           	= 	$value["variant"];           
				   $data['car_locality']      	= 	$value["car_locality"];
				   $data['registration_year'] 	= 	$value["registration_year"];
				   $data['daysstmt']			=	Carbon::parse($value["created_at"])->diffForHumans();
				   $data['kilometer_run']    	= 	$value["kilometer_run"];
				   $data['fuel_type']         	= 	$value["fuel_type"];
				   $data['owner_type']        	= 	$value["owner_type"];
				   $data['price']             	= 	$value["sell_price"];
				   $data['car_id']            	= 	$value["listing_id"];
				   
				   
				   $data['dealer_id']         	= 	$value["dealer_id"];
				   if($value["listing_selection"] == 1)
				   {
						$data['bid_image']    	= 	stripcslashes(config::get("common.thumbimage"));
					}
					else
					{
						$data['bid_image']    	= 	stripcslashes(config::get("common.whiteimage"));
					}
				   
				   
				   $getdealer_schemaname 	  	=		buyymodel::masterFetchTableDetails('',
																			$this->masterMainLoginTable,
																			array('d_id'=>$id)
																			);
					if(!empty($getdealer_schemaname) && count($getdealer_schemaname) > 0 )
					{															
					$count_dealer_viewed_cars   =	buyymodel::dealerTableCount($id,
																$schemaname,
																$this->dealerViewedCarsTable,
																array('car_id'=>$value["listing_id"],
																'dealer_id'=>$id)
																);

				   $count_dealer_saved_cars     =	buyymodel::dealerTableCount($id,
																$schemaname,
																$this->dealerSavedCarListingTable,
																array('car_id'=>$value["listing_id"],
																'dealer_id'=>$id,'saved_status'=>'1')
																);

				   $data['no_images']           = 	count($value["photos"]);
				   $photos_array                =	array();
				   
				   if(count($value["photos"])>0)
				   {
					foreach ($value["photos"] as $photokey => $photovalue) {
						$photos_array[]			=	$photovalue['s3_bucket_path'];
				   }
					$data['imagelinks'] 		= 	$photos_array[0];
				   }
				   else
				   {
					$carnoimage 				= 	Config::get('common.carnoimage');
					$data['imagelinks'] 		=	stripcslashes($carnoimage);
				   }
				   
				   $data['saved_car']           = 	$count_dealer_saved_cars;
				   $data['compare_car']         = 	'1';
				   $whereconalert 				=	array("alert_listingid"=>$value["listing_id"]);
				   $checkcaridexist 			= 	buyymodel::masterFetchTableDetails(
																		$id,																
																		$this->alertcarhistoryTable,
																		$whereconalert
																		);
				   if(!empty($checkcaridexist) && count($checkcaridexist)>=1)
				   {
					  if($checkcaridexist[0]->alert_status == 1)
					  {
						  $data['notify_car']   = 	$checkcaridexist[0]->alert_status;
					  }
					  else
					  {
						  $data['notify_car']   = 	$checkcaridexist[0]->alert_status;
					  }
				   }
				   else
				   {
					  $data['notify_car']       =  0;
				   }																		
				   $data['view_car']            = 	$count_dealer_viewed_cars;
				   $data['auction']             = 	(string)$value['listing_selection'];
				   $get_api_sites               = 	buyymodel::masterFetchTableDetails($id,$this->masterApiSitesTable,
														  array($this->masterSitefiled=>$value['sitename']));
				   if(!empty($get_api_sites))
				   {
					  $get_logo_url        		= 	$get_api_sites[0]->logourl;
					  $data['site_id']          = 	$get_api_sites[0]->id;
				   }
				   else
				   {
					  $get_logo_url        		= 	'';
					  $data['site_id']          = 	'';
				   }
				   
				   $data['site_image']         	= 	stripcslashes(url($get_logo_url));
				   array_push($listing_details,$data);
				}
			}
		}
   
         return response()->json(['Result'=>'1',
									'message'=>'success',
                                    'car_listing'=>$listing_details,
                                    'top_note'=>$dataoftopnote
										]); 
			}
		}  
		return response()->json(['Result'=>0,
									'message'=>'Invalid Access'
										]);   
    
    } 
    
    /*Get All SAVED Car Listing FOR CURRENT USER */
    public function doViewSavedcars()
    { 
 
		$id			=	Input::get('session_user_id');
		$fulldata 	=	array();
		$data 		= 	array();
		if($id == "")
		{
			return response()->json(['Result'=>'0',
									'message'=>'Invalid User!!'
									]);
		}
		$getdealer_schemaname 	  	=	buyymodel::masterFetchTableDetails('',
																	$this->masterMainLoginTable,
																	array('d_id'=>$id)
																	);
      
		$dealer_schemaname			= 	"";
		if(!empty($getdealer_schemaname) && count($getdealer_schemaname) > 0 )
		{															
			foreach($getdealer_schemaname as $dealername)
			{
				$dealer_schemaname	= 	$dealername->dealer_schema_name;
			}
			$wherecondition         =	array('saved_status'	=>	1);
			$queryfetch             = 	buyymodel::dealerFetchTableDetails($id,$dealer_schemaname,
																	$this->dealerSavedCarListingTable,
																	$wherecondition
																	);
			$listing_wherecondition 	=	array();
			$listing_orwherecondition 	=	array();
			$mongo_carlisting_details   = 	array(); 
			if(!empty($queryfetch) && count($queryfetch) >= 1)
			{
				foreach ($queryfetch as $key) {
				  $car_id_array[] 	= 	(string) $key->car_id;
				}
			}
		
			if(!empty($car_id_array) && count($car_id_array) >= 1)
			{
				$listing_wherecondition['listing_id'] =		$car_id_array;
			
				$mongo_carlisting_details             = 	buyymodel::mongoviewsavedcardetails($id,
																				$listing_wherecondition
																				);
			}

			if(!empty($mongo_carlisting_details) && count($mongo_carlisting_details) >=1)
			{
				$data                   =		array();
				$listing_details        =		array();        
				foreach ($mongo_carlisting_details as $key => $value) {
				$data['make']              	= 	$value["make"];
				$data['make_id']           	= 	$value["make_id"];
				$data['model']             	= 	$value["model"];
				$data['variant']           	= 	$value["variant"];           
				$data['car_locality']      	= 	$value["car_locality"];
				$data['registration_year'] 	= 	$value["registration_year"];
				$data['daysstmt']			=	Carbon::parse($value["created_at"])->diffForHumans();
				$data['kilometer_run']     	= 	$value["kilometer_run"];
				$data['fuel_type']         	= 	$value["fuel_type"];
				$data['owner_type']        	= 	$value["owner_type"];
				$data['price']            	= 	$value["sell_price"];
				$data['car_id']            	= 	$value["listing_id"];
           
           
				$data['dealer_id']         	= 	$value["dealer_id"];
				if($value["listing_selection"] == 1)
				{
					$data['bid_image']    	= 	stripcslashes(config::get("common.thumbimage"));
				}
				else
				{
					$data['bid_image']    	= 	stripcslashes(config::get("common.whiteimage"));
				}
           
           
			   $getdealer_schemaname 	  	=	buyymodel::masterFetchTableDetails('',
																		$this->masterMainLoginTable,
																		array('d_id'=>$id)
																		);
				$dealer_schemaname			= 	"";
				if(!empty($getdealer_schemaname) && count($getdealer_schemaname) >= 1 )
				{															
					foreach($getdealer_schemaname as $dealername)
					{
						$dealer_schemaname	= 	$dealername->dealer_schema_name;
					}
				}
				$count_dealer_viewed_cars    =		buyymodel::dealerTableCount($id,
																	$dealer_schemaname,
																	$this->dealerViewedCarsTable,
																	array('car_id'=>$value["listing_id"],
																	'dealer_id'=>$id)
																	);

				$count_dealer_saved_cars     =		buyymodel::dealerTableCount($id,
																	$dealer_schemaname,
																	$this->dealerSavedCarListingTable,
																	array('car_id'=>$value["listing_id"],
																	'dealer_id'=>$id,
																	'saved_status'=>'1')
																	);

			   $data['no_images']           = 	count($value["photos"]);
			   $photos_array                =	array();
           
			   if(count($value["photos"])>0)
			   {
					foreach ($value["photos"] as $photokey => $photovalue) {
					$photos_array[]			=	$photovalue['s3_bucket_path'];
					}
					$data['imagelinks'] 		= 	$photos_array[0];
			   }
				else
				{
					$carnoimage 				= 	Config::get('common.carnoimage');
					$data['imagelinks'] 		=	stripcslashes(url($carnoimage));
				}
			   $data['saved_car']           = 	$count_dealer_saved_cars;
			   $data['compare_car']         = 	'1';
			   $whereconalert 				=	array("alert_listingid"=>$value["listing_id"]);
			   $checkcaridexist 			= 	buyymodel::masterFetchTableDetails(
																	$id,																
																	$this->alertcarhistoryTable,
																	$whereconalert
																	);
			   if(!empty($checkcaridexist) && count($checkcaridexist)>=1)
			   {
				  if($checkcaridexist[0]->alert_status == 1)
				  {
					  $data['notify_car']   = 	$checkcaridexist[0]->alert_status;
				  }
				  else
				  {
					  $data['notify_car']   = 	$checkcaridexist[0]->alert_status;
				  }
			   }
			   else
			   {
				  $data['notify_car']       =  0;
			   }
			   $data['view_car']            = 	$count_dealer_viewed_cars;
			   $data['auction']             = 	(string)$value['listing_selection'];
			   $get_api_sites               = 	buyymodel::masterFetchTableDetails($id,$this->masterApiSitesTable,
													  array($this->masterSitefiled=>$value['sitename']));
			   if(!empty($get_api_sites))
			   {
				  $get_logo_url        		= 	$get_api_sites[0]->logourl;
				  $data['site_id']          = 	$get_api_sites[0]->id;
			   }
			   else
			   {
				  $get_logo_url        		= 	'';
				  $data['site_id']          = 	'';
			   }
			   $data['site_image']         	= 	stripcslashes(url($get_logo_url));
			   array_push($listing_details,$data);

			}
		}
		else
		{
			return response()->json(['Result'=>'1',
									'message'=>'No Records Found!!'
									]);
		}
        
   
         return response()->json(['Result'=>'1',
									'message'=>'success',
                                    'car_listing'=>$listing_details
										]);  
		}
		else
		{
			return response()->json(['Result'=>'0',
									'message'=>'failure'
									]);
		}
    }
    /*Add car and Remove car FOR CURRENT USER */
    public function doApiSaveCar()
    {
        $id 			= 	Input::get('session_user_id');
        $car_id 		=	Input::get('carid');
        if($id == "" || $car_id == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'Invalid Car!!'
									]);
		}
		$getdealer_schemaname 	  	=	buyymodel::masterFetchTableDetails('',
																	$this->masterMainLoginTable,
																	array('d_id'=>$id)
																	);
		$dealer_schemaname			= 	"";
		if(!empty($getdealer_schemaname) && count($getdealer_schemaname) > 0)
		{															
			foreach($getdealer_schemaname as $dealername)
			{
				$dealer_schemaname	= 	$dealername->dealer_schema_name;
			}
			$wherecondition			=	array("dealer_id"=>$id,"car_id"=>$car_id);
			$getSavedCarStatus  	=	buyymodel::dealerFetchTableDetails($id,$dealer_schemaname,
																$this->dealerSavedCarListingTable,
																$wherecondition);
		
        $message 	=	"";                                     
        if(!empty($getSavedCarStatus) && count($getSavedCarStatus) >= 1)
        {
			foreach($getSavedCarStatus as $savedcars)
			{
				if($savedcars->saved_status == "1")
				{
					
					$message			=	"Successfully Removed in Saved Car!!";
					$wherecondition		=	array("car_id"=>$car_id);
					$updatedata			=	array('saved_status'=>0);
					$getSavedCarStatus  =	buyymodel::dealerUpdateTableDetails($id,$dealer_schemaname,
																	$this->dealerSavedCarListingTable,
																	$wherecondition,
																	$updatedata
																	);
				}
				else
				{
					$message			=	"Successfully Added in Saved Car!!";
					$wherecondition		=	array("car_id"=>$car_id);
					$updatedata			=	array('saved_status'=>1);
					$getSavedCarStatus  =	buyymodel::dealerUpdateTableDetails($id,$dealer_schemaname,
																	$this->dealerSavedCarListingTable,
																	$wherecondition,
																	$updatedata
																	);
				}
			}
			
			return response()->json(['Result'=>'3',
									'message'=>$message
									]);
		}
        else
        {
			$message					=	"Successfully Added in Saved Car!!";
			$insertdata					=	array('dealer_id'=>$id,
												'car_id'=>$car_id,
												'saved_status'=>1,
												'created_date'=>date('Y-m-d h:i:s')
												);
			$getSavedCarStatus  		=	buyymodel::dealerInsertToTable($id,$dealer_schemaname,
																	$this->dealerSavedCarListingTable,
																	$insertdata
																	);
			return response()->json(['Result'=>'3',
									'message'=>$message
									]);
			}
		}
		else
		{
			return response()->json(['Result'=>'0',
									'message'=>'failure'
									]);
		}
		
    }
    /*API QUERIES*/
    public function doApiQueriesCar()
    {        
		$id 			= 	Input::get('session_user_id');       
		if($id == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'Invalid User!!'
									]);
		}
		$dealer_schemaname 	=  $this->getschemaname($id);
		$dealer_name 		=  $this->getschemausername($id);
		if(!empty($dealer_schemaname))
		{															
			$fetch_queried_detail      = 	buyymodel::doApidealerQueriesDetail($id,$dealer_schemaname);
			$fetch_queried_details 		=	collect($fetch_queried_detail)->sortByDesc('thread_id');
			$queriesdata                = 	array();
			$listing_orwherecondition   = 	array();
			$listing_wherecondition     = 	array();
			if(!empty($fetch_queried_details) && count($fetch_queried_details) >= 1)
			{
				foreach ($fetch_queried_details as $key)
				{
					$car_id                               = 	(string) $key->car_id;
					$dealer_id                            = 	$key->from_dealer_id;
					$listing_wherecondition['listing_id'] =		array($car_id);
					$mongo_carlisting_details             = 	buyymodel::mongoListingFetchwithqueries($id,
																					$listing_wherecondition,
																					$listing_orwherecondition
																					);
				if(!empty($mongo_carlisting_details) && count($mongo_carlisting_details) >= 1)
				{
					foreach ($mongo_carlisting_details as $userkey => $uservalue) 
					{
						$data['noimages']               	= 	count($uservalue["photos"]);
						$photos_array                   	= 	array();
						if(count($uservalue["photos"])>0)
						{
							foreach ($uservalue["photos"] as $photokey => $photovalue) {
							   $photos_array[]     			=	$photovalue['s3_bucket_path'];
							}
							$data['imagelink']  			= 	$photos_array[0];
						}
						else
						{
							$data['imagelink']  			=	stripcslashes(url(Config::get('common.carnoimage')));
						}
			
						$data['price']                  	= 	$uservalue["sell_price"];
						$to_get_dealer_id               	= 	$key->to_dealer_id;
						if($key->to_dealer_id	==	$id)
						{
								$to_get_dealer_id			=	$dealer_id;
						}
						$to_dealer_name 					=  $this->getschemausername($to_get_dealer_id);

						$codewherecondition             	= 	array('contact_transactioncode'=>$key->contact_transactioncode);
						$latest_message                 	= 	buyymodel::dealerQueriesWithCode($dealer_schemaname,$codewherecondition);
						$data['car_id']                 	= 	$key->car_id;
						$data['status']                 	= 	((count($latest_message)>=1)?$latest_message->status:'');
						$data['from_dealer_id']         	= 	$dealer_name;
						$data['fromdealerid']         		= 	$key->from_dealer_id;
						$data['to_dealer_name']         	= 	$to_dealer_name;
						$data['to_dealer_id']           	= 	$to_get_dealer_id;
						$data['make']                   	= 	$uservalue['make'];
						$data['title']                  	= 	$uservalue['make'].' '.
																	$uservalue['model'].' '.
																	$uservalue['variant'].' '.
																	$uservalue['registration_year'];
						$data['dealer_name']            	= 	$key->dealer_name;
						$data['headertitle']            	= 	$key->title;
						$data['dealer_email']           	= 	$key->dealer_email;
						$data['message']                	= 	$latest_message->message;
						$data['contact_transactioncode']	= 	$key->contact_transactioncode;
						$data['Time']						= 	Carbon::parse($key->delear_datetime)->diffForHumans();
								
						array_push($queriesdata, $data);    
					}
				}
			}
		}
        return response()->json(['Result'=>'1',
									'message'=>'success',
									'queries_list'=>$queriesdata
									]);
		}
		else
		{
			return response()->json(['Result'=>'0',
									'message'=>'failure'
									]);
		}
 
        
    }  
    
    /*API QUERIES*/
    public function doApiQueriesChat()
    {        
		$id 					= 	Input::get('session_user_id');
		$transactioncode		= 	Input::get('contact_transactioncode');      
		if($id == "" || $transactioncode == "")
		{
			return response()->json(['Result'=>'0',
							'message'=>'All fields are required!!'
							]);
		}
		$getdealer_schemaname 	  	=	buyymodel::masterFetchTableDetails('',
															$this->masterMainLoginTable,
															array('d_id'=>$id)
															);
		$queriesdata                = 	array();
		$listing_orwherecondition   = 	array();
		$listing_wherecondition     = 	array();
		if(!empty($getdealer_schemaname) && count($getdealer_schemaname) >= 1)
		{															
			foreach($getdealer_schemaname as $dealername)
			{
				$dealer_schemaname	= 	$dealername->dealer_schema_name;
			}
			$wherecon 				=	array('contact_transactioncode'=>$transactioncode);
			$fetch_queried_detail  	= 	buyymodel::dealerFetchTableDetails($id,
																				$dealer_schemaname,
																				$this->dealermessageTable,
																				$wherecon); 
			$fetch_queried_details  =	$fetch_queried_detail->sortBydesc('thread_id')->first();  
			if(!empty($fetch_queried_details) && count($fetch_queried_details) >= 1)
			{
				if($fetch_queried_details->user_id  ==	$id)
				{
					$from_get_dealer_id =	$id;
					$to_get_dealer_id	=	$fetch_queried_details->to_dealer_id;
				}
				else
				{
					$from_get_dealer_id	=	$id;
					$to_get_dealer_id	=	$fetch_queried_details->from_dealer_id;
				}
				$getfromdealer_schemaname 	  	=	buyymodel::masterFetchTableDetails('',
															$this->masterMainLoginTable,
															array('d_id'=>$from_get_dealer_id)
															);
				$fromdealer_name 	=	"";
				$fromlogo 			=	"";
				$fromdealer_id 		=	"";
				if(!empty($getfromdealer_schemaname) && count($getfromdealer_schemaname) >= 1)
				{
					foreach($getfromdealer_schemaname as $dealername)
					{
						$fromdealer_name 	= 	$dealername->dealer_name;
						$fromlogo 			=	url(stripcslashes($dealername->logo));
						$to_dealer_schema_name 	= 	$dealername->dealer_schema_name;
					}
					if($fetch_queried_details->user_id  !=	$id)
					{
						$whereupdate		=	array('contact_transactioncode'=>$transactioncode);
						$setupdatemessage 	=	array('status'=>0);
						$updatemessage   	=	buyymodel::dealerUpdateToTable($id,
																				$to_dealer_schema_name,
																				$this->dealermessageTable,
																				$whereupdate,
																				$setupdatemessage);
					}
				}
				
				$fetch_master_todealer_schema   = buyymodel::masterFetchTableDetails($id,
																	$this->masterMainLoginTable,
																	array('d_id'=>$to_get_dealer_id)
																	);
				$to_dealer_name 		=	"";
				$to_dealer_logo 		=	"";
				$to_dealer_schema_name 	=	"";
				if(!empty($fetch_master_todealer_schema) && count($fetch_master_todealer_schema) >= 1)
				{
					$to_dealer_name 	= 	$fetch_master_todealer_schema[0]->dealer_name;
					$to_dealer_logo 	= 	$fetch_master_todealer_schema[0]->logo;
				}
				
				
				
				$car_id                               	= 	(string) $fetch_queried_details->car_id;
				$listing_wherecondition['listing_id'] 	= 	array($car_id);
				$mongo_carlisting_details             	= 	buyymodel::mongoListingFetchwithqueries($id,$listing_wherecondition,$listing_orwherecondition);
				if(!empty($mongo_carlisting_details) && count($mongo_carlisting_details) >= 1)
				{
					foreach($mongo_carlisting_details as $uservalue)
					{
						$data['make']           = 	$uservalue['make'];
						$data['model']          = 	$uservalue['model'];
						$data['variant']        = 	$uservalue['variant'];
						$data['price']        	= 	$uservalue['sell_price'];
						$data['location']       = 	$uservalue['car_locality'];
						$data['carposttime']	= 	Carbon::parse($uservalue['created_at'])->diffForHumans();
						if(count($uservalue["photos"])>0)
						{
							foreach ($uservalue["photos"] as $photokey => $photovalue) {
								$photos_array[]		=	$photovalue['s3_bucket_path'];
							}
							$data['carlogo'] 		= 	stripcslashes($photos_array[0]);
						}
					   else
					   {
							$carnoimage 			= 	url(Config::get('common.carnoimage'));
							$data['carlogo'] 		=	stripcslashes($carnoimage);
					   }
					}
				}
				$data['car_id']                 = 	$fetch_queried_details->car_id;
				$data['from_dealer_name']       = 	$fromdealer_name;
				$data['fromdealerid']         	= 	$from_get_dealer_id;
				$data['to_dealer_name']         = 	$to_dealer_name;
				$data['to_dealer_id']           = 	$to_get_dealer_id;
				$data['dealer_email']           = 	$fetch_queried_details->dealer_email;
				$data['dealer_logo']           	= 	$fromlogo;
				$data['end_dealerlogo']         = 	$to_dealer_logo;
				$data['message']                = 	$fetch_queried_details->message;
				$data['mobile']                	= 	$fetch_queried_details->mobile;
				$data['contact_transactioncode']= 	$fetch_queried_details->contact_transactioncode;
				$data['Time']					= 	commonmodel::getdatemonthtimeformat($fetch_queried_details->delear_datetime);
				array_push($queriesdata, $data);    
			
				return response()->json(['Result'=>'1',
								'message'=>'success',
								'queries_list'=>$queriesdata
								]);
			}
			else
			{
				return response()->json(['Result'=>'0',
							'message'=>'No Queries Found!!'
							]);
				
			}
		
		}
		return response()->json(['Result'=>'0',
							'message'=>'failure'
							]);

    }  
    
     /*API QUERIES*/
    public function doApiQueriesChatrefresh()
    {        
		$id 					= 	Input::get('session_user_id');
		$transactioncode		= 	Input::get('contact_transactioncode');      
		$offset					= 	Input::get('page_no');      
		if($id == "" || $transactioncode == "")
		{
			return response()->json(['Result'=>'0',
							'message'=>'All fields are required!!'
							]);
		}
		$getdealer_schemaname 	  	=	buyymodel::masterFetchTableDetails('',
															$this->masterMainLoginTable,
															array('d_id'=>$id)
															);
		$queriesdata                = 	array();
		if(!empty($getdealer_schemaname) && count($getdealer_schemaname) >= 1)
		{		
			$dealer_schemaname 	=	"";													
			foreach($getdealer_schemaname as $dealername)
			{
				$dealer_schemaname	= 	$dealername->dealer_schema_name;
				
			}
			$pageno 				=	$offset*10;
			$wherecon 				=	array('contact_transactioncode'=>$transactioncode);
			/*$fetch_queried  		= 	buyymodel::dealerFetchTableDetails($id,
																				$dealer_schemaname,
																				$this->dealermessageTable,
																				$wherecon);   */           
			$fetch_queried  		= 	buyymodel::dealerFetchDetailsoffsetandlimit($id,
																				$dealer_schemaname,
																				$this->dealermessageTable,
																				$wherecon,
																				$pageno);              
			
			if(!empty($fetch_queried) && count($fetch_queried) >= 1)
			{
				foreach ($fetch_queried as $value){
				$data['id'] 		        	= 	$value->thread_id;
				$data['user_id']                = 	$value->user_id;
				$data['message']                = 	$value->message;
				$data['time']                	= 	Carbon::parse($value->delear_datetime)->diffForHumans();
				array_push($queriesdata, $data);    
			}
				return response()->json(['Result'=>'1',
								'message'=>'success',
								'queries_list'=>$queriesdata
								]);
			}
			else
			{
				return response()->json(['Result'=>'0',
							'message'=>'No Queries Found!!'
							]);
				
			}
		
		}
		return response()->json(['Result'=>'0',
							'message'=>'failure'
							]);

    }  
    
    public function doApiQueriesChatinsert()
    {    
        $id 						= 	Input::get('session_user_id');
        $transactioncode 			= 	Input::get('contact_transactioncode'); 
		$car_id						=	Input::get('car_id');
		$from_dealer_name			=	Input::get('from_dealer_name');
		$fromdealerid				=	Input::get('fromdealerid');
		$todealerschemaname			=	Input::get('to_dealer_name');
		$to_dealer_id				=	Input::get('to_dealer_id');
		$message					=	Input::get('message');
		$mobile						=	Input::get('mobile');
		$notification_type_id  		= 	Input::get('notification_type_id');
		$make  						= 	Input::get('make');
										

		if($id 	==	"" || $transactioncode ==	"" || $car_id == "" || $from_dealer_name == "" || $fromdealerid == "" ||
		$todealerschemaname == "" || $to_dealer_id == "" || $message == "" || $mobile == "" || $notification_type_id == "" || $make == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'All fields are required!!'
									]);
		}
		$schemanamedealer 				=	$this->getschemaname($id);
		if(!empty($schemanamedealer))
		{
			$from_email					=	"";
			$fromdealer_name			=	"";
			$dealer_wherecondition    	= 	array('d_id'=>$id);
			$fetchupdate              	= 	buyymodel::masterFetchTableDetails($id,$this->masterMainLoginTable,$dealer_wherecondition);
			if(!empty($fetchupdate) && count($fetchupdate) >= 1)
			{
				$from_email             = 	$fetchupdate[0]->d_email;
				$fromdealer_name        = 	$fetchupdate[0]->dealer_name;
				$from_profile_image     = 	$fetchupdate[0]->logo;
			}
			$to_dealer_wherecondition 	= 	array('d_id'=>$to_dealer_id);
			$to_schemaname				=	"";
			$to_dealer_namesend			=	"";
			$to_dealer_id_fetch       	= 	buyymodel::masterFetchTableDetails($id,$this->masterMainLoginTable,$to_dealer_wherecondition);
			if(!empty($to_dealer_id_fetch) && count($to_dealer_id_fetch) >= 1)
			{
				$to_dealer_email        = 	$to_dealer_id_fetch[0]->d_email;
				$to_dealer_mobile       = 	$to_dealer_id_fetch[0]->d_mobile;
				$to_dealer_namesend     = 	$to_dealer_id_fetch[0]->dealer_name;
				$to_schemaname  		= 	$to_dealer_id_fetch[0]->dealer_schema_name; 
				$to_dealer_profile  	= 	$to_dealer_id_fetch[0]->logo; 
			}
			$to_schemaname 				=	$this->getschemaname($to_dealer_id);
			$queries_contact_title    	= 	Config::get('common.queries_contact_title');
			$currentdate              	= 	Carbon::now();
			$contact_transactioncode  	= 	$currentdate->format('Ymdhis');
			$data                     	= 	array('from_dealer_id'=>$id,
													'contact_transactioncode'=>$transactioncode,
													'to_dealer_id'=>$to_dealer_id,
													'mobile'=>$mobile,
													'car_id'=>$car_id,
													'dealer_name'=>$from_dealer_name,
													'dealer_email'=>$from_email,
													'message'=>$message,
													'title'=>$queries_contact_title,
													'delear_datetime'=>date('Y-m-d H:i:s'),
													'user_id'=>$id
														);
			$todatainsert               = 	array('from_dealer_id'=>$id,
													'contact_transactioncode'=>$transactioncode,
													'to_dealer_id'=>$to_dealer_id,
													'mobile'=>$mobile,
													'car_id'=>$car_id,
													'dealer_name'=>$from_dealer_name,
													'dealer_email'=>$from_email,
													'message'=>$message,
													'title'=>$queries_contact_title,
													'delear_datetime'=>date('Y-m-d H:i:s'),
													'user_id'=>$id,
													'status'=>1,
														);
			$dealerinsert	=	buyymodel::dealerInsertTable($id,$schemanamedealer,$this->dealermessageTable,$data);
			//exit;
			if($dealerinsert >= 1)
			{
				$todealer 	=	buyymodel::dealerInsertToTable($id,$to_schemaname,$this->dealermessageTable,$todatainsert);
			}
			$notification_type_name			=	"";
			$queries_notification_type_id 	= 	config::get('common.queries_notification_type_id');
			$notification_type       		= 	notificationsmodel::get_notification_dealer_type($queries_notification_type_id);
			$notification_type_name			=	((count($notification_type)>=1)?$notification_type[0]->notification_type_name:'');
			$notificationmessage 			=	'Lead enquiry-'.' '.$fromdealer_name.' '.$queries_contact_title.' '.$message;
			$dealer_notification     		= 	array('user_id'=>$id,
														'd_id'=>$id,
														'notification_type_id'=>$notification_type_id,
														'title'=>$make,
														'notification_type'=>$notification_type_name,
														'message'=>$notificationmessage,        
														'status'=>1,
														'contact_transactioncode'=>$contact_transactioncode
													);
			notificationsmodel::dealer_notification_insert($to_schemaname,$dealer_notification);

			$maildata                		= 	array('0'=>$to_dealer_profile,
													  '1'=>$to_dealer_namesend,
													  '2'=>$fromdealer_name,
													  '3'=>$from_profile_image,
													  '4'=>$message
													  );
			$queries_email_template_id		=   config::get('common.queries_email_template_id');
			$email_template_data      		=   emailmodel::get_email_templates($queries_email_template_id);

			foreach ($email_template_data as $row) 
			{
				$mail_subject  	=  $row->email_subject;
				$mail_message  	=  $row->email_message;
				$mail_params   	=  $row->email_parameters; 
			}

			$send_email       	= 	$to_dealer_email;
			$email_template     = 	emailmodel::emailContentConstruct($mail_subject,$mail_message,$mail_params,$maildata);
			$email_sent         = 	emailmodel::email_sending($send_email,$email_template);
			//Mail End
			//Sms Queries Start			
			$phone              = 	$to_dealer_mobile;
			$smsdata            = 	array($to_dealer_namesend,$fromdealer_name);
			$queries_sms_id     = 	Config::get('common.queries_sms_id');
			$sms_template_data  = 	smsmodel::get_sms_templates($queries_sms_id);

			$sms_template       = 	smsmodel::smsContentConstruct($sms_template_data[0]->sms_subject,$sms_template_data[0]->sms_message,$sms_template_data[0]->sms_parameters,$smsdata);

			$sms_data           = 	array('sms_template_data'=>$sms_template,
									'phone'=>$phone);
			$sms_sent           = 	smsmodel::sendsmsarray($sms_data);
        
			//End SMS
			return response()->json(['Result'=>'1',
									'message'=>'Mail has been sent to dealer!!'
									]);
			}
			else
			{
				return response()->json(['Result'=>'0',
									'message'=>'Invalid Access!!'
									]);
			}
    }
    
	/*GET BIDDING LIST*/
    public function doApiBiddingList()
    { 
		$id 					= 	Input::get('session_user_id');
		
		if($id == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'Invalid User!!'
									]);
		}
		$getdealer_schemaname 	  	=	buyymodel::masterFetchTableDetails('',
																	$this->masterMainLoginTable,
																	array('d_id'=>$id)
																	);
		$dealer_schemaname			= 	"";
		if(!empty($getdealer_schemaname) && count($getdealer_schemaname) > 0)
		{															
			foreach($getdealer_schemaname as $dealername)
			{
				$dealer_schemaname	= 	$dealername->dealer_schema_name;
			}
		$car_id_array             	= 	array();
		$car_id                   	= 	'';
		$data                     	= 	array();
		$biddingdata              	= 	array();
		$listing_wherecondition   	= 	array();
		$listing_orwherecondition 	= 	array();
		$queryfetch               	= 	buyymodel::dealerBiddingcurrentDetail($id);
		if(!empty($queryfetch) && count($queryfetch) >= 1)
		{
		foreach ($queryfetch as $key){
        $car_id                               = 	(string) $key->car_id;
        $listing_wherecondition['listing_id'] =		array($car_id);
        $mongo_carlisting_details             = 	buyymodel::mongoListingFetch($id,
																			$listing_wherecondition,
																			$listing_orwherecondition
																			);
        
        foreach ($mongo_carlisting_details as $userkey => $uservalue) {
            $data['dealer_id']  = 	$key->dealer_id;
            $data['car_id']     = 	$uservalue['listing_id'];

            $data['noimages']   = 	count($uservalue["photos"]);
            $photos_array       =	array();

            if(count($uservalue["photos"])>0)
            {
                foreach ($uservalue["photos"] as $photokey => $photovalue) {
                $photos_array[]     =	$photovalue['s3_bucket_path'];
            }
                $data['imagelink']  = 	$photos_array[0];
            }
            else
            {
                $carnoimage         = 	Config::get('common.carnoimage');
                $data['imagelink']  =	stripcslashes(url($carnoimage));
            }
            $data['daysstmt']		=	Carbon::parse($uservalue["created_at"])->diffForHumans();
           $get_api_sites           = 	buyymodel::masterFetchTableDetails($id,$this->masterApiSitesTable,
                                                  array($this->masterSitefiled=>$uservalue['sitename']));
           if(!empty($get_api_sites))
           {
              $get_logo_url        	= 	$get_api_sites[0]->logourl;
              $data['site_id']      = 	$get_api_sites[0]->id;
           }
           else
           {
              $get_logo_url        	= 	'';
              $data['site_id']      = 	'';
           }
			$data['bid_image']    	= 	stripcslashes(url(config::get("common.wonimage")));
			$data['site_image']     = 	stripcslashes(url($get_logo_url));
            $data['posted'] 		= 	Carbon::parse($uservalue["created_at"])->diffForHumans();
            $closingdate            = 	commonmodel::daysBetweenCurrentDate($uservalue["auction_end_date"]);
            $data['closing_time'] 	= 	$closingdate.' days left';            
            $data['make']           = 	$uservalue['make'];
            $data['model']          = 	$uservalue['model'];
            $data['bidded_amount']  = 	$key->bidamount;
            array_push($biddingdata, $data);                    
        }
        
      }
		}		
		return response()->json(['Result'=>'1',
									'message'=>'success',
									'bidding_list'=>$biddingdata
									]);
		}
		else
		{
			return response()->json(['Result'=>'0',
									'message'=>'failure'
									]);
		}
		
    }
    
    /*VIEW ALL BIDDING LIST FOR INDIVIDUAL CAR ID*/
    public function doApibiddingviewmorelist()
    { 
		$id 					= 	Input::get('session_user_id');
		$car_id 				= 	Input::get('car_id');
		if($id == "" || $car_id == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'Invalid Car!!'
									]);
		}
		$getdealer_schemaname 	  	=	buyymodel::masterFetchTableDetails('',
																	$this->masterMainLoginTable,
																	array('d_id'=>$id)
																	);
		$dealer_schemaname			= 	"";
		if(!empty($getdealer_schemaname) && count($getdealer_schemaname) > 0)
		{															
			foreach($getdealer_schemaname as $dealername)
			{
				$dealer_schemaname	= 	$dealername->dealer_schema_name;
				$dealernamecurrent	= 	$dealername->dealer_name;
			}
			$data                     	= 	array();
		$biddingdata              	= 	array();
		$where						=	array('car_id'=>$car_id);
		$getbiddingresult           = 	buyymodel::masterBiddingamountDetail($where);
		
		if(!empty($getbiddingresult) && count($getbiddingresult) >= 1)
		{
			$position				= 	1;
			$positionnumber			=	"";
			foreach ($getbiddingresult as $biddingvalue){
			
			$getbiddingname 	  	=	buyymodel::masterFetchTableDetails('',
																	$this->masterMainLoginTable,
																	array('d_id'=>$biddingvalue->user_id)
																	);
			$dealerschemaname		= 	"";
			
			if(!empty($getbiddingname) && count($getbiddingname) >= 1)
			{															
				foreach($getbiddingname as $dealernamevalue)
				{
					if($dealernamecurrent	== 	$dealernamevalue->dealer_name)
					{
						$dealerschemaname	= 	$dealernamevalue->dealer_name;
						$positionnumber 	=	$position;
					}
					else
					{
						$dealerschemaname	= 	commonmodel::maskingWithstar($dealernamevalue->dealer_name);
					}
				}
			}
			$position++;
			
				$data['Dealername']    	= 	$dealerschemaname;
				$data['Amount']     	= 	$biddingvalue->amount;				
				$data['Date'] 			= 	commonmodel::getdatemonthtimeformat($biddingvalue->created_date);
				array_push($biddingdata, $data);                    
			}
			
		}
      

			return response()->json(['Result'=>'1',
									'message'=>'success',
									'Position'=>$positionnumber,
									'dealer_bid_list'=>$biddingdata
									]);
		}
		else
		{
			return response()->json(['Result'=>'0',
									'message'=>'failure'
									]);
		}
		
		 
    }
    
    /*ALERT FOR INDIVIDUAL CAR ID*/
    public function doApialertcar()
    { 
		$id 						= 	Input::get('session_user_id');
		$car_id 					= 	Input::get('car_id'); 
		if($id == "" || $car_id == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'All fields are required!!'
									]);
		}
		if(Input::get('page_name')=='alertcarpage')
		{
		$getdealer_schemaname 	  	=	buyymodel::masterFetchTableDetails('',
																	$this->masterMainLoginTable,
																	array('d_id'=>$id)
																	);
		$dealer_schemaname			= 	"";
		$orwherecondition  			=	array();
		if(!empty($getdealer_schemaname) && count($getdealer_schemaname) >= 1)
		{															
			foreach($getdealer_schemaname as $dealername)
			{
				$dealer_schemaname	= 	$dealername->dealer_schema_name;
				$dealeremail		= 	$dealername->d_email;
				$dealermobile		= 	$dealername->d_mobile;				
			}
		
		$listing_wherecondition['listing_id'] =		array($car_id);
        $mongo_carlisting_details             = 	buyymodel::mongoListingFetch($id,
																		$listing_wherecondition,
																		$orwherecondition
																		);
			$makename 		= 	"";
			$modelname 		= 	"";
			$variantname 	= 	"";
			$cityname 		= 	"";
			$fueltypename 	= 	"";
			$registeryear 	= 	"";
			if(!empty($mongo_carlisting_details) && count($mongo_carlisting_details) >= 1)
			{	
				foreach($mongo_carlisting_details as $getrecords)
				{
					$makename		=	$getrecords->make;
					$modelname		=	$getrecords->model;
					$variantname	=	$getrecords->variant;
					$cityname		=	$getrecords->car_locality;
					$fueltypename	=	$getrecords->fuel_type;
					$registeryear	=	$getrecords->registration_year;					
				}
			}
			else
			{
				return response()->json(['Result'=>'1',
								'message'=>'No Records Found!!'
								]);
			}
			$wherecon 			=	array("alert_listingid"=>$car_id);
			$checkcaridexist 	= 	buyymodel::masterFetchTableDetails(
																$id,																
																$this->alertcarhistoryTable,
																$wherecon
																);
			if(!empty($checkcaridexist) && count($checkcaridexist) >= 1)
			{
				foreach($checkcaridexist as $caralert)
				{
					if($caralert->alert_status == "1")
					{
						
						$message			=	"Successfully Removed from Alert Car!!";
						$wherecondition		=	array("alert_listingid"=>$car_id);
						$updatedata			=	array('alert_status'=>0);
						$updateAlertCar     =	buyymodel::dealerUpdateTableDetails($id,$dealer_schemaname,
																		$this->alertcarhistoryTable,
																		$wherecondition,
																		$updatedata
																		);
                        $updateAlertCar     =	buyymodel::masterupdateDetail(
																		$this->alertcarhistoryTable,
																		$wherecondition,
																		$updatedata
																		);																				
																		
					}
					else
					{
						$message			=	"Successfully Added in Alert Car!!";
						$wherecondition		=	array("alert_listingid"=>$car_id);
						$updatedata			=	array('alert_status'=>1);
						$updateAlertCar  =	buyymodel::dealerUpdateTableDetails($id,$dealer_schemaname,
																		$this->alertcarhistoryTable,
																		$wherecondition,
																		$updatedata
																		);
                        $updateAlertCar     =	buyymodel::masterupdateDetail(
																		$this->alertcarhistoryTable,
																		$wherecondition,
																		$updatedata
																		);																		
					}
				}
				return response()->json(['Result'=>'4',
									'message'=>$message
									]);
				
			}
			else{
			$insertrecord		=	array('alert_listingid'	=>	$car_id,
									 'alert_user_id'	=>	$id,
									 'alert_make'		=>	$makename,
									 'alert_model'		=>	$modelname,
									 'alert_variant'	=>	$variantname,
									 'alert_year'		=>	$registeryear,
									 'alert_fueltype'	=>	$fueltypename,
									 'alert_city'		=>	$cityname,
									 'alert_status'		=> 	1,										 
									 'alert_usermailid'	=>	$dealeremail,
									 'alert_mobileno'	=>	$dealermobile
									  );
			$Insertalert 			=	buyymodel::dealerInsertTable($id,
															$dealer_schemaname,
															$this->alertcarhistoryTable,
															$insertrecord
															);
			if($Insertalert >=1 )
			{
			$Insertalert 			=	buyymodel::masterInsertTable($id,
															$this->alertcarhistoryTable,
															$insertrecord
															);
														}
				if($Insertalert >= 1)
				{	
					return response()->json(['Result' 	=>'4',
									'message' 			=>'success'
									]); 
				}
				else
				{
					return response()->json(['Result'=>'0',
								'message'=>'failure'
								]);
				}
			}
			}
			else
			{
				return response()->json(['Result'=>'0',
							'message'=>'failure'
							]);
			}
		}
		else
		{
			return response()->json(['Result'=>'0',
							'message'=>'failure'
							]); 
		}
    }
    
    
    /*GET CAR ALERT HISTORY LIST*/
    public function doApialerthistory()
    { 
		$id 					= 	Input::get('session_user_id');
		
		if($id == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'Invalid User!!'
									]);
		}
		$getdealer_schemaname 	  	=	buyymodel::masterFetchTableDetails($id,
																	$this->masterMainLoginTable,
																	array('d_id'=>$id)
																	);
       																	
		$dealer_schemaname			= 	"";
		if(!empty($getdealer_schemaname) && count($getdealer_schemaname) >= 1)
		{			
			foreach($getdealer_schemaname as $dealername)
			{
				$dealer_schemaname	= 	$dealername->dealer_schema_name;
			}
		$data                     	= 	array();
		$alertdata              	= 	array();
		$wherecondition 			= 	array('alert_user_id'=>$id);
		$queryfetch               	= 	buyymodel::masterFetchtablerecords($this->alertcarhistoryTable);
		
		if(!empty($queryfetch) && count($queryfetch) >= 1)
		{
			foreach ($queryfetch as $alertvalue){        
				$data['car_id']  	= 	$alertvalue->alert_listingid;
				$data['user_id']  	= 	$alertvalue->alert_user_id;
				$data['make']  		= 	$alertvalue->alert_make;
				$data['model']  	= 	$alertvalue->alert_model;
				$data['variant']  	= 	$alertvalue->alert_variant;
				$data['year']  		= 	$alertvalue->alert_year;
				$data['fueltype']  	= 	$alertvalue->alert_fueltype;
				$data['city']  		= 	$alertvalue->alert_city;
				$data['status']  	= 	$alertvalue->alert_status;            
				$data['posted']		=	Carbon::parse($alertvalue->alert_date)->diffForHumans();
				array_push($alertdata, $data);                    
			}
			return response()->json(['Result'=>'1',
									'message'=>'success',
									'alert_history_list'=>$alertdata
									]); 
		}
		else
		{
			return response()->json(['Result'=>'1',
									'message'=>'No Records Found!!'
									]);
		}
	}
	else
		{
			return response()->json(['Result'=>'0',
									'message'=>'Failure'
									]);
		}
    }
    
    /*VIEW ALL AND ADD BIDDING FOR INDIVIDUAL CAR ID*/
    public function doApiaddbiddingviewmorelist()
    { 
		$id 						= 	Input::get('session_user_id');
		$biddingamount 				= 	Input::get('biddingamount');
		$car_id 					= 	Input::get('car_id');
		$dealerid 					= 	Input::get('dealerid');
		$fundPrefix           		= 	Config::get('common.fundPrefix');
        $currentdate          		= 	Carbon::now();
        $ticket_id            		=	$fundPrefix.$currentdate->format('Ymdhis');
		if($id == "" || $biddingamount == "" || $car_id == "" || $dealerid == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'Please Enter Amount!!'
									]);
		}
		$getdealer_schemaname 	  	=	buyymodel::masterFetchTableDetails('',
																	$this->masterMainLoginTable,
																	array('d_id'=>$id)
																	);
		$dealer_schemaname			= 	"";
		if(!empty($getdealer_schemaname) && count($getdealer_schemaname) > 0)
		{															
			foreach($getdealer_schemaname as $dealername)
			{
				$dealer_schemaname	= 	$dealername->dealer_schema_name;
				$dealernamecurrent	= 	$dealername->dealer_name;
			}
			$where					=	array('car_id'=>$car_id);
			$getbiddingamount       = 	buyymodel::dealermaxbiddingamountdetail($where);
			$comparebiddingamount	=	"";
		if(!empty($getbiddingamount))
		{
			foreach($getbiddingamount as $bid)
			{
				$comparebiddingamount 	= 	$bid->amount;
			}			
			if($comparebiddingamount < $biddingamount)
			{
				$whereconditionmat	=	array('user_id'=>$id);
				$getmasterbidding   = 	buyymodel::masterbiddingdetailtable($whereconditionmat);
				if(!empty($getmasterbidding) && count($getmasterbidding) > 0)
				{
					$updatedata				=	array('bidded_amount'=>$biddingamount,
															'ticket_id'	=>	$ticket_id);
					$wherecondition			=	array('user_id'=>$id);
					$revokeStatus  			=	buyymodel::masterupdatebiddingDetail(
																	$wherecondition,
																	$updatedata
																	);
					if($revokeStatus >=1)
					{
					$insertrecord			=	array('ticket_id'	=>	$ticket_id,
												 'dealer_id'		=>	$dealerid,
												 'car_id'			=>	$car_id,
												 'bidded_amount'	=>	$biddingamount,
												 'user_id'			=>	$id,
												 'created_date'		=>	$currentdate
												  );
										  
					$revokeStatus 			=	buyymodel::dealerInsertTable($id,
															$dealer_schemaname,
															$this->dealerbiddingTable,
															$insertrecord
															);
					}
				}
				else
				{
				$insertrecord		=	array('ticket_id'	=>	$ticket_id,
										 'dealer_id'		=>	$dealerid,
										 'car_id'			=>	$car_id,
										 'bidded_amount'	=>	$biddingamount,
										 'user_id'			=>	$id,
										 'created_date'		=>	$currentdate
										  );
										  
				$revokeStatus 			=	buyymodel::dealerInsertTable($id,
															$dealer_schemaname,
															$this->dealerbiddingTable,
															$insertrecord
															);
				$revokeStatus 			=	buyymodel::masterInsertTable($id,
															$this->dealerbiddingTable,
															$insertrecord
															);
				}
				
			if($revokeStatus > 0)
			{
				$data                     	= 	array();
				$biddingdata              	= 	array();
				$where						=	array('car_id'=>$car_id);
				$getbiddingresult           = 	buyymodel::masterBiddingamountDetail($where);
				
				if(!empty($getbiddingresult) && count($getbiddingresult) >= 1)
				{
					$position				= 	1;
					$positionnumber			=	"";
					foreach ($getbiddingresult as $biddingvalue){
					
					$getbiddingname 	  	=	buyymodel::masterFetchTableDetails('',
																			$this->masterMainLoginTable,
																			array('d_id'=>$biddingvalue->user_id)
																			);
					$dealerschemaname		= 	"";
					
					if(!empty($getbiddingname) && count($getbiddingname) >= 1)
					{															
						foreach($getbiddingname as $dealernamevalue)
						{
							if($dealernamecurrent	== 	$dealernamevalue->dealer_name)
							{
								$dealerschemaname	= 	$dealernamevalue->dealer_name;
								$positionnumber 	=	$position;
							}
							else
							{
								$dealerschemaname	= 	commonmodel::maskingWithstar($dealernamevalue->dealer_name);
							}
						}
					}
					$position++;
					
						$data['Dealername']    	= 	$dealerschemaname;
						$data['Amount']     	= 	$biddingvalue->amount;				
						$data['Date'] 			= 	commonmodel::getdatemonthtimeformat($biddingvalue->created_date);
						array_push($biddingdata, $data);                    
					}
					
				}
				
					return response()->json(['Result' 	=>'1',
									'message' 			=>'success',
									'Position' 			=>$positionnumber,
									'dealer_bid_list' 	=>$biddingdata
									]); 
				}
				else
				{
					return response()->json(['Result'=>'0',
									'message'=>'failure'
									]); 
				}
		}
		else
		{
			return response()->json(['Result'=>'0',
								'message'=>'Bidding amount should be high!!'
								]);
		}
		}
		}
		else
		{
			return response()->json(['Result'=>'0',
									'message'=>'failure'
									]);
		}
    }
    
    //FRESHSERVICE TICKET CREATE FUNCTION
    public function doApiFreshticketcreate()
    {
        $id 						= 	Input::get('session_user_id');
        $request_type 				= 	Input::get('request_type');
        $dealershipname 			= 	Input::get('dealershipname');
        $dealermobileno				= 	Input::get('dealermobileno');
        $amount 					= 	Input::get('requested_amount');
        $dealercity 				= 	Input::get('dealercity');
        $dealerarea           		= 	Input::get('dealerarea');
        $dealermailid         		= 	Input::get('dealermailid');
        $dealername           		= 	Input::get('dealername');
        $fundPrefix           		= 	Config::get('common.fundPrefix');
        $currentdate          		= 	Carbon::now();
        $ticket_id            		=	$fundPrefix.$currentdate->format('Ymdhis');
        
        if($id == "" || $request_type == "" || $dealershipname == "" || $dealermobileno == "" || 
				$amount == "" || $dealercity == "" || $dealermailid == "" || $dealerarea == "" || $dealername == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'All fields are required!!'
									]);
		}  
		if(Input::get('page_name')=='addfundingpage')
		{
			$schemaname 		=  $this->getschemaname($id);
			if(!empty($schemaname))
			{
				$ticketcreate	=	freshservice::doApiCreateTicketfreshservice($id,$request_type,$dealershipname,$dealername,$dealermailid,$dealermobileno,
				$amount,$currentdate,$dealercity,$dealerarea);
				if($ticketcreate == true)
				{
					return response()->json(['Result'=>'1',
								'message'=>'Ticket created'
								]);
				}
			}
		}
		return response()->json(['Result'=>'0',
								'message'=>'Invalid Access'
								]);			
    }
    
    /*ADD FRESH SERVICE FUNDING DETAILS*/
    public function doApiaddfreshservice()
    {      
		$email			=	"admin@dealerplus.in";
		$password		=	"FreshDealer";
		$yourdomain 	= 	"dealerplus";
		
		$ticket_data 	= 	json_encode(array("helpdesk_ticket"=>array(
		  "description" => 	"Test tikcet on  the issue ...",
		  "subject" 	=> 	"Support needed..",
		  "email" 		=> 	"vinoth.t@falconnect.in",
		  "priority" 	=> 	1,
		  "status" 		=> 	2,
		  "source"		=>	2,
		  "ticket_type"	=>	"Incident",
		  "custom_field"	=>	array("mobilenumber_107113"=>"9790037458",
										"area_107113"=>"Adyar",
										"city_107113"=>"Chennai",
										"dealername_107113"=>"DealerPlus",
										"dealershipname_107113"=>"Dealer",
										"funddate_107113"=>"07-02-2017",
										"make_107113"=>"honda,maruthi,hyundai")),
		  "cc_emails" 	=> 	array("senthil@falconnect.in", "sk@falconnect.in")
		));
		
		$url 	= 	"https://$yourdomain.freshservice.com/helpdesk/tickets.json";
		$ch 	=	curl_init();
		$header[] = "Content-type: application/json";
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_USERPWD, "$email:$password");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $ticket_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$server_output = curl_exec($ch);
		$info = curl_getinfo($ch);
		
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$headers = substr($server_output, 0, $header_size);
		$response = substr($server_output, $header_size);
		if($info['http_code'] == 200) {
		  echo "Ticket created successfully, the response is given below \n";
		  echo $headers."\n";
		  echo "$response \n";
		} else {
		  if($info['http_code'] == 404) {
			echo "Error, Please check the end point \n";
		  } else {
			echo "Error, HTTP Status Code : " . $info['http_code'] . "\n";
			echo "Headers are ".$headers;
			echo "Response are ".$response;
		  }
		}
		curl_close($ch);
    }
    /*UPDATE FRESH SERVICE FUNDING DETAILS*/
    public function doApiupdatefreshservice()
    {
        $id 			= 	Input::get('session_user_id');
        $ticket_id 		=	Input::get('common_id');
        if($id == "" || $ticket_id == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'Invalid Ticket!!'
									]);
		}
		$getdealer_schemaname 	  	=	buyymodel::masterFetchTableDetails('',
																	$this->masterMainLoginTable,
																	array('d_id'=>$id)
																	);
		$dealer_schemaname			= 	"";
		if(!empty($getdealer_schemaname) && count($getdealer_schemaname) > 0)
		{															
			foreach($getdealer_schemaname as $dealername)
			{
				$dealer_schemaname	= 	$dealername->dealer_schema_name;
			}
			$wherecondition				=	array('common_id'=>$ticket_id);
			$queryfetch             	= 	buyymodel::dealerFetchfreshTableDetailsnotwhere(
																	$id,
																	$dealer_schemaname,
																	'dealer_freshservice_details',
																	$wherecondition
																	);
			if(!empty($queryfetch) && count($queryfetch) >= 1)
			{
				foreach($queryfetch as $checkstatus)
				{
					if($checkstatus->ticket_status == 'Completed')
					{
						$updatedata			=	array('ticket_status'=>'Processing');
						$wherecondition		=	array('common_id'=>$ticket_id);
						$revokeStatus  		=	buyymodel::dealerUpdateTableDetails($id,
																	$dealer_schemaname,
																	'dealer_freshservice_details',
																	$wherecondition,
																	$updatedata
																	);
                      $revokeStatus  		=	buyymodel::masterupdateDetail(
																	'dealer_freshservice_details',
																	$wherecondition,
																	$updatedata
																	);																	
					}
					else
					{
						$updatedata			=	array('ticket_status'=>'Completed');
						$wherecondition		=	array('common_id'=>$ticket_id);
						$revokeStatus  		=	buyymodel::dealerUpdateTableDetails($id,
																	$dealer_schemaname,
																	'dealer_freshservice_details',
																	$wherecondition,
																	$updatedata
																	);
                        $revokeStatus  		=	buyymodel::masterupdateDetail(
																	'dealer_freshservice_details',
																	$wherecondition,
																	$updatedata
																	);																	
					}
				}
				        
				if(!empty($revokeStatus) && count($revokeStatus) >= 1)
				{
					return response()->json(['Result'=>'1',
											'message'=>'success'
											]);
				}
				else
				{
					return response()->json(['Result'=>'0',
											'message'=>'failure'
											]);
				}
			}
			else
			{
				return response()->json(['Result'=>'0',
										'message'=>'failure'
										]);
			}
		}
		else
		{
			return response()->json(['Result'=>'0',
										'message'=>'failure'
										]);
		}
    }
    
    //FILTER API
    public function doApibuyfilter()
    {	
		$id 						= 	Input::get('session_user_id');
		$tag_values 				= 	urldecode(Input::get('tag_values'));
        if($id == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'Userid and Tag values are required!!'
									]);
		}
		$schemaname 				=  $this->getschemaname($id);
		if(!empty($schemaname))
		{
			$nameoffilter 			=	array("Car Sites","Listing Types","Car Make","Car Model","Car Year","Transmission","Fuel Type","Price Range","Body Type");			
			if(!empty($tag_values))
			{
				$listing_tag  			=	explode(',',$tag_values);
			}
			$carsitesname 			=	"";
			$carbrandname 			=	"";
			$carlistingname 		=	"";
			$carmodelname 			=	"";
			$caryearname 			=	"";
			$cartransmissionname 	=	"";
			$carbodytypename 		=	"";
			$carfueltypename 		=	"";
			$carpricename 			=	"";
			$carmakename 			=	"";
			$carmakeid 				=	"";
			if(!empty($listing_tag) && count($listing_tag) >= 1)
			{
				foreach($listing_tag as $tagvalue)
				{
					if($tagvalue != "")
					{
						if(strpos($tagvalue,'Sites') !== false)
						{
							$carsitesname	.= 	substr($tagvalue, strpos($tagvalue, ":")+1).',';
						}
						if(strpos($tagvalue,'Brand') !== false)
						{
							$carmakeid 		= 	substr($tagvalue, strpos($tagvalue, ":")+1);
							$carmakename	.= 	substr($tagvalue, strpos($tagvalue, ":")+1).','; 

							$makewhere		=	array('makename'=>$carmakeid);
							$getmake 	 	=	inventorymodel::masterschema_table_where(
																				$this->masterMakeTable,
																				$makewhere);
							$carbrandname 	.=	((count($getmake)>=1)?$getmake[0]->make_id:'').',';
						}
						if(strpos($tagvalue,'ListingType') !== false)
						{
							$carlistingname .=	substr($tagvalue, strpos($tagvalue, ":")+1).',';
						}
						if(strpos($tagvalue,'Model') !== false)
						{
							$carmodelname	.= 	substr($tagvalue, strpos($tagvalue, ":")+1).','; 
						}
						if(strpos($tagvalue,'Year') !== false)
						{
							$caryearname	.= 	substr($tagvalue, strpos($tagvalue, ":")+1).','; 
						}
						if(strpos($tagvalue,'Transmission') !== false)
						{
							$cartransmissionname	.= 	substr($tagvalue, strpos($tagvalue, ":")+1).','; 
						}
						if(strpos($tagvalue,'FuelType') !== false)
						{
							$carfueltypename	.= 	substr($tagvalue, strpos($tagvalue, ":")+1).','; 
						}
						if(strpos($tagvalue,'BodyType') !== false)
						{
							$carbodytypename	.= 	substr($tagvalue, strpos($tagvalue, ":")+1).','; 
						}
						if(strpos($tagvalue,'Budget') !== false)
						{
							$car_budget					= 	substr($tagvalue, strpos($tagvalue, ":")+1);
							$wherecondition				=	array('budget_varient_name'=>$car_budget);
							$getResultbudget 			= 	commonmodel::getAllRecordsWhere('master_budget_varient',$wherecondition);
							if(!empty($getResultbudget) && count($getResultbudget)>=1)
							{	
								foreach($getResultbudget as $value)
								{
									$carpricename		.=	$value->budget_varient_name;
								}						
							}
						}
					}
				 }
			}

			$sitenames 			=	($carsitesname == "" ?'Select Car Sites':trim($carsitesname,','));
			$brandnames 		=	($carmakename == "" ?'Select Make':trim($carmakename,','));
			$brandid 			=	($carbrandname == "" ?0:trim($carbrandname,','));
			$listingnames 		=	($carlistingname == "" ?'Select Listing Types':trim($carlistingname,','));
			$modelnames 		=	($carmodelname == "" ?'Select Model':trim($carmodelname,','));
			$yearnames 			=	($caryearname == "" ?'Select Year':trim($caryearname,','));
			$transmissionnames 	=	($cartransmissionname == "" ?'Select Transmission':trim($cartransmissionname,','));
			$bodytypenames 		=	($carbodytypename == "" ?'Select Body Type':trim($carbodytypename,','));
			$fueltypenames 		=	($carfueltypename == "" ?'Select Fuel Type':trim($carfueltypename,','));
			$pricetypenames 	=	($carpricename == "" ?'Select Price Range':$carpricename);
			$carsite			=	array('id'=>0,'count'=>0,'name'=>$sitenames);
			$maketype			=	array('id'=>$brandid,'count'=>0,'name'=>$brandnames);
			$listtype			=	array('id'=>0,'count'=>0,'name'=>$listingnames);
			$modeltype			=	array('id'=>0,'count'=>0,'name'=>$modelnames);
			$yeartype			=	array('id'=>0,'count'=>0,'name'=>$yearnames);
			$transmissiontype	=	array('id'=>0,'count'=>0,'name'=>$transmissionnames);
			$fueltype			=	array('id'=>0,'count'=>0,'name'=>$fueltypenames);
			$budgettype			=	array('id'=>0,'count'=>0,'name'=>$pricetypenames);
			$bodytype			=	array('id'=>0,'count'=>0,'name'=>$bodytypenames);
			return response()->json(['Result'			=>	'5',
									'filter_index'		=>	$nameoffilter,
									'Car Sites'			=>	[$carsite],
									'Listing Types'		=>	[$listtype],
									'Car Make'			=>	[$maketype],
									'Car Model'			=>	[$modeltype],
									'Car Year'			=>	[$yeartype],
									'Transmission'		=>	[$transmissiontype],
									'Fuel Type'			=>	[$fueltype],
									'Price Range'		=>	[$budgettype],
									'Body Type'			=>	[$bodytype]
									]);
		}
		return response()->json(['Result'=>'0',
									'message'=>'Invalid Access'
									]);
	}
	
	 //FILTER API
    public function doApisearchfilter()
    {	
      
        $id 						= 	Input::get('session_user_id');
        $filtertype 				=	Input::get('filtertype');
        if($id == "" || $filtertype == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'Userid and filter type is required!!'
									]);
		}
		$schemaname 				=  $this->getschemaname($id);
		if(!empty($schemaname))
		{
			if($filtertype 	==	"Car Sites")
			{
				$api_sites					= 	commonmodel::get_api_sites();
				$site_data       			= 	array();
				$site_array 				= 	array();
				$fetchdata					=	array();

				foreach ($api_sites as $key => $value) {
					$site_data['sitename'] 	= 	$value->sitename;
					$site_data['count']     = 	mongomodel::where('sitename',$site_data['sitename'])->count();
					$site_data['name'] 		= 	$value->sitename;
          
					array_push($site_array, $site_data);
				}
				$sorted		=	collect($site_array)->sortByDesc('count');
				$grouped 	=	$sorted->values()->all();
				return response()->json(['Result'	=>	'1',
									'detail_filter'	=>	$grouped
									]);
			}
			if($filtertype 	==	"Listing Types")
			{
				$listingtype        		= 	config::get('common.listingtype');
				$listingtype_array  		= 	array();
				$listingtype_data   		= 	array();
				foreach ($listingtype as $key => $value) {
					$listingtype_data['id'] 	= 	(int) $key;
					$listingtype_data['count']  = 	mongomodel::where('listing_selection',$listingtype_data['id'])->count();
					$listingtype_data['name'] 	= 	$value;
					
					array_push($listingtype_array, $listingtype_data);
				}
				$sorted		=	collect($listingtype_array)->sortByDesc('count');
				$grouped 	=	$sorted->values()->all();
				return response()->json(['Result'	=>	'1',
									'detail_filter'	=>	$grouped
									]);
			}
			//GET MAKE TYPE AND COUNT
			if($filtertype 	==	"Car Make")
			{
				$make              			= 	commonmodel::makedropdown();
				$make_data       			= 	array();
				$make_array 				= 	array();
				foreach ($make as $key => $value) {
					$make_data['id'] 		=	(string) $value->make_id;          
					$make_data['count']     = 	mongomodel::where('make_id',$make_data['id'])->count();
					$make_data['name'] 		= 	$value->makename;          
					array_push($make_array, $make_data);
				}
				$sorted		=	collect($make_array)->sortByDesc('count');
				$grouped 	=	$sorted->values()->all();
				return response()->json(['Result'	=>	'1',
									'detail_filter'	=>	$grouped
									]);
			}
			//GET MODEL TYPE AND COUNT
			if($filtertype 	==	"Car Model")
			{
				$model_data       			= 	array();
				$model_array 				= 	array();
				$make_id 					=	Input::get('make_id');
				if(!empty($make_id))
				{
					$vehiclearray 			=	explode(',',$make_id);
					$getResultModelName 	= 	buyymodel::dealerFetchWherein(
																		$this->masterModelsTable,
																		'make_id',
																		$vehiclearray);
					if(!empty($getResultModelName) && count($getResultModelName)>=1)
					{	
						foreach($getResultModelName as $value)
						{
							$model_data['id'] 		=	(string) $value->model_id;          
							$model_data['count']    = 	mongomodel::where('model',$value->model_name)->count();
							$model_data['name'] 	= 	$value->model_name;          
							array_push($model_array, $model_data);
						}						
					}
					$sorted		=	collect($model_array)->sortByDesc('count');
					$grouped 	=	$sorted->values()->all();
				}
				return response()->json(['Result'	=>	'1',
									'detail_filter'	=>	$grouped
									]);
			}
			//GET YEAR AND COUNT
			if($filtertype 	==	"Car Year")
			{
				$master_car_reg_year		= 	commonmodel::master_car_reg_year();
				$reg_year_data      		= 	array();
				$reg_year_array     		= 	array();
				foreach ($master_car_reg_year as $key => $value) {
					$reg_year_data['year']	= 	(string) $value->master_reg_year;
					$reg_year_data['count'] = 	mongomodel::where('registration_year',
																$reg_year_data['year'])
																->count();
					$reg_year_data['name']	= 	(string) $value->master_reg_year;
					
					array_push($reg_year_array, $reg_year_data);
				}
				$sorted		=	collect($reg_year_array)->sortByDesc(['year']);
				$grouped 	=	$sorted->values()->all();
				return response()->json(['Result'	=>	'1',
									'detail_filter'	=>	$grouped
									]);
			}
			//GET TRANSMISSION TYPE AND COUNT
			if($filtertype 	==	"Transmission")
			{
				$transmission       		= 	config::get('common.transmission_type');
				$transmission_array  		= 	array();
				$transmission_data   		= 	array();
				foreach ($transmission as $key => $value) {
					$transmission_data['id']  	= 	(int) $key;
					$transmission_data['count']	= 	mongomodel::where('transmission',$value)->count();
					$transmission_data['name'] 	= 	$value;
					array_push($transmission_array, $transmission_data);
				}
				$sorted		=	collect($transmission_array)->sortByDesc('count');
				$grouped 	=	$sorted->values()->all();
				return response()->json(['Result'	=>	'1',
									'detail_filter'	=>	$grouped
									]);
			}
			//GET BUDGET TYPE AND COUNT
			if($filtertype 	==	"Price Range")
			{
				$listing_wherecondition =	array();
				$master_budget_varient 	= 	commonmodel::get_mater_budget();
				$budget_array         	= 	array();
				$budget_data          	= 	array();
				foreach ($master_budget_varient as $key => $value) {
					$budget_data['value'] = $value->budget_value;
					$explode_data 				= 	explode("-",$value->budget_value);
					$budget_data['minvalue'] 	= 	$explode_data[0];
					$budget_data['maxvalue'] 	= 	$explode_data[1];
					$budget_data['sell_price']	= 	array($explode_data[0],$explode_data[1]);
					if($explode_data[1]=='>')
					{
					$budget_data['count']       = 	buyymodel::mongolistingpricecount($id,array((int) $explode_data[0],50000000000000000),$listing_wherecondition);
					$budget_data['name'] 		= 	$value->budget_varient_name;
					}
					else
					{
					$budget_data['count']       = 	buyymodel::mongolistingpricecount($id,array((int) $explode_data[0],(int) $explode_data[1]),$listing_wherecondition);
					$budget_data['name'] 		= 	$value->budget_varient_name;
					}
					array_push($budget_array, $budget_data);
				}
				$sorted		=	collect($budget_array)->sortByDesc('count');
				$grouped 	=	$sorted->values()->all();
				return response()->json(['Result'	=>	'1',
									'detail_filter'	=>	$grouped
									]);
			}
					
			 //GET FUEL TYPE AND COUNT
			if($filtertype 	==	"Fuel Type")
			{
				$fuel_type          		= 	config::get('common.fuel_type');
				$fuel_array         		= 	array();
				$fuel_data          		= 	array();
				foreach ($fuel_type as $key => $value) {
					$fuel_data['id']        = 	(int) $key;
					$fuel_data['count']     = 	mongomodel::where('fuel_type',$value)->count();
					$fuel_data['name'] 		= 	$value;
					array_push($fuel_array, $fuel_data);	
				}
				$sorted		=	collect($fuel_array)->sortByDesc('count');
				$grouped 	=	$sorted->values()->all();
				return response()->json(['Result'	=>'1',
									'detail_filter'	=>$grouped
									]);
			}
			//GET BODY TYPE AND COUNT
			if($filtertype 	==	"Body Type")
			{
				$listing_category   		= 	commonmodel::get_listing_category();
				$listing_data       		= 	array();
				$listing_category_array 	= 	array();
				foreach ($listing_category as $key => $value) {
					$listing_data['count']	= 	mongomodel::where('body_type',$value->category_description)->count();
					$listing_data['name'] 	= 	$value->category_description;
					array_push($listing_category_array, $listing_data);
				}
				$sorted		=	collect($listing_category_array)->sortByDesc('count');
				$grouped 	=	$sorted->values()->all();
				return response()->json(['Result'	=>	'1',
									'detail_filter'	=>	$grouped
									]);
			}
		}
		return response()->json(['Result'=>'0',
									'message'=>'Invalid Access'
									]);
	}
	
	 //FILTER SELECTED API LIST REMAIN UNSELECTED
    public function doApilistunselectedfilter()
    {	
        $id 						= 	Input::get('session_user_id');
        $filtertype 				=	Input::get('filtertype');
        $selectedfilter 			=	Input::get('selected_filter');
        if($id == "" || $filtertype == "" || $selectedfilter == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'Select atleast one category!!'
									]);
		}
		$filterarray		=	array();
		$schemaname 		=  $this->getschemaname($id);
		if(!empty($schemaname))
		{
			if(!empty($selectedfilter))
			{
				$filterarray 	=	explode(',',$selectedfilter);
			}
			if($filtertype 	==	"Car Sites")
			{
				$site_data       			= 	array();
				$site_array 				= 	array();
				$fetchdata					=	array();
				foreach ($filterarray as $key => $value) {
					$site_data['sitename'] 	= 	$value;
					$site_data['count']     = 	mongomodel::where('sitename',$site_data['sitename'])->count();
					$site_data['name'] 		= 	$value;
					array_push($site_array, $site_data);
				}
				return response()->json(['Result'	=>	'2',
									'Car Sites'		=>	$site_array
									]);
			}
			if($filtertype 	==	"Listing Types")
			{
				if(!empty($selectedfilter))
				{
					$newfilter		=	array();
					$filter			=	array();
					$listingtype_array	=	array();
					$filterarray 	=	explode(',',$selectedfilter);
					foreach($filterarray as $k=>$val)
					{
						if($val	==	"Listing")
						{
							$filter['name']	=	0;
						}
						if($val	==	"Auction")
						{
							$filter['name']	=	1;
						}
						array_push($newfilter,$filter);
					}
				}
				$newlisting 	=	array_flatten($newfilter);
				foreach($newlisting as $val)
				{
					$listingtype_data['id'] 		= 	(int) $val;
					$listingtype_data['count']  	= 	mongomodel::where('listing_selection',$listingtype_data['id'])->count();
					if($val	==	0)
					{
						$listingtype_data['name'] 	= 	"Listing";
					}
					if($val	==	1)
					{
						$listingtype_data['name'] 	= 	"Auction";
					}
					array_push($listingtype_array, $listingtype_data);
				}
				return response()->json(['Result'	=>	'2',
									'Listing Types'	=>	$listingtype_array
									]);
			}
			//GET MAKE TYPE AND COUNT
			if($filtertype 	==	"Car Make")
			{
				$make              			= 	commonmodel::makedropdown();
				if(!empty($selectedfilter))
				{
					$filterarray 	=	explode(',',$selectedfilter);
				}
				$make_data['id']			=	"";
				$make_data       			= 	array();
				$make_array 				= 	array();
				foreach ($filterarray as 	$value) {
					if($value != "")
					{
					$where					=	array('makename'=>$value);
					$getmakeid 				=	commonmodel::getAllRecordsvalues($this->masterMakeTable,$where,$this->masterMakeIdfiled);          
					if(!empty($getmakeid))
					{
						$make_data['id']	=	$getmakeid;
					}
					$make_data['count'] 	= 	mongomodel::where('make_id',$make_data['id'])->count();
					$make_data['name'] 		= 	$value;          
				}
					array_push($make_array, $make_data);
					
				}
				return response()->json(['Result'	=>	'2',
									'Car Make'	=>	$make_array
									]);
			}
			//GET MODEL TYPE AND COUNT
			if($filtertype 	==	"Car Model")
			{
				if(!empty($selectedfilter))
				{
					$filterarray 	=	explode(',',$selectedfilter);
				}
				$make_data       			= 	array();
				$make_array 				= 	array();
				foreach ($filterarray as 	$value) {
					$make_data['id'] 		=	(string) $value;          
					$make_data['count']     = 	mongomodel::where('model',$make_data['id'])->count();
					$make_data['name'] 		= 	$value;          
					array_push($make_array, $make_data);
				}
				return response()->json(['Result'	=>	'2',
									'Car Model'	=>	$make_array
									]);
			}
			//GET YEAR AND COUNT
			if($filtertype 	==	"Car Year")
			{
				if(!empty($selectedfilter))
				{
					$filterarray 	=	explode(',',$selectedfilter);
				}
				$reg_year_data      		= 	array();
				$reg_year_array     		= 	array();
				foreach ($filterarray as 	$value) {
					$reg_year_data['year']	= 	(string) $value;
					$reg_year_data['count'] = 	mongomodel::where('registration_year',
																$reg_year_data['year'])
																->count();
					$reg_year_data['name']	= 	(string) $value;
					
					array_push($reg_year_array, $reg_year_data);
				}
				return response()->json(['Result'	=>	'2',
									'Car Year'	=>	$reg_year_array
									]);
			}
			//GET TRANSMISSION TYPE AND COUNT
			if($filtertype 	==	"Transmission")
			{
				if(!empty($selectedfilter))
				{
					$filterarray 	=	explode(',',$selectedfilter);
				}
				$transmission_array  		= 	array();
				$transmission_data   		= 	array();
				foreach ($filterarray as	$value) {
					$transmission_data['id']  	= 	$value;
					$transmission_data['count']	= 	mongomodel::where('transmission',$value)->count();
					$transmission_data['name'] 	= 	$value;
					array_push($transmission_array, $transmission_data);
				}
				return response()->json(['Result'	=>	'2',
									'Transmission'	=>	$transmission_array
									]);
			}
			//GET BUDGET TYPE AND COUNT
			if($filtertype 	==	"Price Range")
			{
				$explode_data			=	array();
				$budget_array         	= 	array();
				$budget_data          	= 	array();
				if(!empty($selectedfilter))
				{
					$selectedfilter		=	ltrim($selectedfilter);
					$filterarray 		=	explode(',',$selectedfilter);
				}
				$listing_wherecondition =	array();
				foreach($filterarray as $budgetvalue)
				{
					$where 						=	array('budget_varient_name'=>$budgetvalue);
					$master_budget_varient[] 	= 	commonmodel::getAllRecordsWhere('master_budget_varient',$where);
				}
				if(!empty($master_budget_varient) && count($master_budget_varient) >= 1)
				{
					foreach($master_budget_varient as $masterbudget)
					{
						foreach($masterbudget as $value)
						{
							$budget_data['value'] 		= 	$value->budget_value;
							$explode_data 				= 	explode("-",$value->budget_value);
							$budget_data['minvalue'] 	= 	$explode_data[0];
							$budget_data['maxvalue'] 	= 	$explode_data[1];
							$budget_data['sell_price']	= 	array($explode_data[0],$explode_data[1]);
							if($explode_data[1]=='>')
							{
								$budget_data['count']   = 	buyymodel::mongolistingpricecount($id,array((int) $explode_data[0],50000000000000000),$listing_wherecondition);
								$budget_data['name'] 	= 	$value->budget_varient_name;
							}
							else
							{
								$budget_data['count']   = 	buyymodel::mongolistingpricecount($id,array((int) $explode_data[0],(int) $explode_data[1]),$listing_wherecondition);
								$budget_data['name'] 	= 	$value->budget_varient_name;
							}
							array_push($budget_array, $budget_data);
						}
					}
				}
				return response()->json(['Result'	=>	'2',
									'Price Range'	=>	$budget_array
									]);
			}
					
			 //GET FUEL TYPE AND COUNT
			if($filtertype 	==	"Fuel Type")
			{
				if(!empty($selectedfilter))
				{
					$filterarray 	=	explode(',',$selectedfilter);
				}
				$fuel_array         		= 	array();
				$fuel_data          		= 	array();
				foreach ($filterarray 	as	$value) {
					$fuel_data['id']        = 	$value;
					$fuel_data['count']     = 	mongomodel::where('fuel_type',$value)->count();
					$fuel_data['name'] 		= 	$value;
					array_push($fuel_array, $fuel_data);	
				}
				return response()->json(['Result'	=>	'2',
									'Fuel Type'	=>	$fuel_array
									]);
			}
			//GET BODY TYPE AND COUNT
			if($filtertype 	==	"Body Type")
			{
				if(!empty($selectedfilter))
				{
					$filterarray 	=	explode(',',$selectedfilter);
				}
				$listing_data       		= 	array();
				$listing_category_array 	= 	array();
				foreach ($filterarray as  $value) {
					$listing_data['count']	= 	mongomodel::where('body_type',$value)->count();
					$listing_data['name'] 	= 	$value;
					array_push($listing_category_array, $listing_data);
				}
				return response()->json(['Result'	=>	'2',
									'Body Type'	=>	$listing_category_array
									]);
			}
		}
		return response()->json(['Result'=>'0',
									'message'=>'Invalid Access'
									]);
	}
	//COMPARE CAR FUNCTION
	public function doApiComparecar()
	{
		$id                           	= 	Input::get('session_user_id');     
		$car_id                       	= 	Input::get('car_id');
		if($id == "" || $car_id == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'Userid and carid is required!!'
									]);
		}
		$schemaname 	=  $this->getschemaname($id);
		if(!empty($schemaname))
		{
			$wherecondition               	=	array();
			$caridvalue						=	explode(',',$car_id);
			$listing_orwherecondition     	= 	array();
			$photosdata 					=	array();
			$photosdetails 					=	array();
			$videosdata 					=	array();
			$videosdetails 					=	array();
			$carimages 		 				=	array();
			$carimagesdetails 				=	array();
			$carmodeldetails 				=	array();
			$getcarmodeldetails 			=	array();
			$carspecification 				=	array();
			$carspecificationdetails 		=	array();
			$carengine 						=	array();
			$carenginedetails 				=	array();
			$carinterior 					=	array();
			$carinteriordetails 			=	array();
			$carcomport 					=	array();
			$carcomportdetails 				=	array();
			$carsafety 						=	array();
			$carsafetydetails 				=	array();
			$carexterior 					=	array();
			$carexteriordetails 			=	array();
			$carentertainment 				=	array();
			$carentertainmentdetails 		=	array();
			$cardiemention 					=	array();
			$cardiementiondetails 			=	array();
			$sortbyfield					=	"desc";
			$sortcategoryfield				=	"sell_price";
			$getcardetailsmongo				=	array();
			if(!empty($caridvalue) && count($caridvalue) >= 1)
			{
				foreach($caridvalue as $valueofcarid)
				{
					$car_id_value					=	(string)$valueofcarid;
					$wherecondition['listing_id'] 	=	array($car_id_value);
					$getcardetailsmongo             = 	buyymodel::doSearchMongofetchcompare($id,
																			$wherecondition,
																			$listing_orwherecondition,
																			$sortcategoryfield,
																			$sortbyfield
																		);
			 
			$variant_id                   	=	'';
			$make_id                      	=	'';
			$auction_end_time             	=	array();
			$detail_list_data             	=	array();
			if(!empty($getcardetailsmongo) && count($getcardetailsmongo)>=1)
			{
				foreach ($getcardetailsmongo as $detailsmongo) 
				{
					if(count($detailsmongo["photos"]) >= 1)
					{
						foreach ($detailsmongo["photos"] as $photokey => $photovalue) {
							$carimages['image_url']			=	$detailsmongo["photos"][0]['s3_bucket_path'];
							$carallimagesdetails[$photokey]	=	$photovalue['s3_bucket_path'];
							$carallimagesnames[$photokey]	=	$photovalue['profile_pic_name'];
							$carmodeldetails['allimages']	=	$carallimagesdetails;
							$carmodeldetails['imagenames']	=	$carallimagesnames;
						}
					}
					else
					{
						$carnoimage                     = 	Config::get('common.carnoimage');
						$carimages['image_url'] 		=	array(url($carnoimage));
						$carmodeldetails['allimages']	=	array(url($carnoimage));
						$carmodeldetails['imagenames']	=	"";
					}
					$carimages['Price']         		= 	$detailsmongo['sell_price'];
					$carimages['Make']					=	$detailsmongo['make'];
					$carimages['Model']					=	$detailsmongo['model'];
					$carimages['Variant']				=	$detailsmongo['variant'];
					$carimages['listing_id']    		= 	$detailsmongo['listing_id'];
					array_push($carimagesdetails,$carimages);
				  //car model details result
					$carmodeldetails['imagecount']		=	count($detailsmongo['photos']);
					$carmodeldetails['videocount']		=	count($detailsmongo['videos']);
					$carmodeldetails['Make']			=	$detailsmongo['make'];
					$carmodeldetails['Model']			=	$detailsmongo['model'];
					$carmodeldetails['Variant']			=	$detailsmongo['variant'];
					$carmodeldetails['Year']			=	$detailsmongo['registration_year'];
					$carmodeldetails['FuelType']		=	$detailsmongo['fuel_type'];
					$carmodeldetails['listing_id']    	= 	$detailsmongo['listing_id'];
					$carmodeldetails['Mileage']      	= 	$detailsmongo['mileage'];
					$carmodeldetails['Kilometers']      = 	$detailsmongo['kilometer_run'];
					$carmodeldetails['OwnerType']      	= 	$detailsmongo['owner_type'];
					$carmodeldetails['Price']         	= 	$detailsmongo['sell_price'];
					$carmodeldetails['SeatingCapacity'] = 	$detailsmongo['seating_capacity'];
					$carmodeldetails['Location']  		= 	$detailsmongo['car_locality'];
					$carmodeldetails['dealer_id']  		= 	$detailsmongo['dealer_id'];
					$carmodeldetails['transmission']	=	$detailsmongo['transmission'];
					$carmodeldetails['insurance']		=	(count($detailsmongo['documents']) >=1?'Yes':'No');

					array_push($getcarmodeldetails,$carmodeldetails);
					//car specification result
					$carspecification['Color']			=	$detailsmongo['colors'];
					$carspecification['GearBox']		=	$detailsmongo['gear_box'];
					$carspecification['DriveType']		=	$detailsmongo['drive_type'];
					$carspecification['SeatingCapacity']=	$detailsmongo['seating_capacity'];
					$carspecification['SteeringType']	=	$detailsmongo['steering_type'];
					$carspecification['TurningRadius']	=	$detailsmongo['turning_radius'];
					$carspecification['Acceleration']	=	$detailsmongo['acceleration'];
					$carspecification['TyreType']		=	$detailsmongo['tyre_type'];
					$carspecification['Nofdoors']		=	$detailsmongo['no_of_doors'];
					$carspecification['top_speed']		=	$detailsmongo['top_speed'];
					array_push($carspecificationdetails,$carspecification);
					//car engine details
					$carengine['EngineType']			=	$detailsmongo['engine_type'];
					$carengine['Displacement']			=	$detailsmongo['displacement'];
					$carengine['MaxPower']				=	$detailsmongo['max_power'];
					$carengine['MaxTorque']				=	$detailsmongo['max_torque'];
					$carengine['Noofcylinder']			=	$detailsmongo['no_of_cylinder'];
					$carengine['Valuespercylinder']		=	$detailsmongo['valves_per_cylinder'];
					$carengine['ValueConfiguration']	=	$detailsmongo['valve_configuration'];
					$carengine['FuelSupplySystem']		=	$detailsmongo['fuel_supply_system'];
					$carengine['TurboCharger']			=	$detailsmongo['turbo_charger'];
					$carengine['SuperCharger']			=	$detailsmongo['super_charger'];
					array_push($carenginedetails,$carengine);
				  
					//car INTERIOR details
					$carinterior['AirConditioner']		=	$detailsmongo['air_conditioner'];
					$carinterior['AdjustableSteering']	=	$detailsmongo['adjustable_steering'];
					$carinterior['LeatherSteeringWheel']=	$detailsmongo['leather_steering_wheel'];
					$carinterior['Heater']				=	$detailsmongo['heater'];
					$carinterior['DigitalClock']		=	$detailsmongo['digital_clock'];
					array_push($carinteriordetails,$carinterior);
				  
					//car comfort details
					$carcomport['AirConditioner']		=	$detailsmongo['air_conditioner'];
					$carcomport['PowerSteering']		=	$detailsmongo['power_steering'];
					$carcomport['PowerWindowsFront']	=	$detailsmongo['power_windows_front'];
					$carcomport['rear_seat_headrest']	=	$detailsmongo['rear_seat_headrest'];
					$carcomport['PowerWindowsear']		=	$detailsmongo['power_windows_rear'];
					$carcomport['RemoteTrunkOpener']	=	$detailsmongo['remote_trunk_opener'];
					$carcomport['RemoteFuellidopener']	=	$detailsmongo['remote_fuel_lid_opener'];
					$carcomport['LowFuelWarningLight']	=	$detailsmongo['low_fuel_warning_light'];
					$carcomport['RearReadingLamp']		=	$detailsmongo['rear_reading_lamp'];
					$carcomport['RearSeatCentreArmRest']=	$detailsmongo['rear_seat_centre_arm_rest'];
					$carcomport['HeightAdjustableFrontSeatBelts']=	$detailsmongo['height_adjustable_front_seat_belts'];
					$carcomport['CupHoldersFront']		=	$detailsmongo['cup_holders_front'];
					$carcomport['RearAcvents']			=	$detailsmongo['rear_ac_vents'];
					$carcomport['ParkingSensors']		=	$detailsmongo['parking_sensors'];
					$carcomport['cup_holders_rear']		=	$detailsmongo['cup_holders_rear'];
					array_push($carcomportdetails,$carcomport);
					
					//car SAFETY details
					$carsafety['AntiLockBrakingSystem']	=	$detailsmongo['anti_lock_braking_system'];
					$carsafety['CentralLocking']		=	$detailsmongo['central_locking'];
					$carsafety['ChildSafetyLock']		=	$detailsmongo['child_safety_lock'];
					$carsafety['DriverAirbags']			=	$detailsmongo['driver_airbags'];
					$carsafety['PassengerAirbag']		=	$detailsmongo['passenger_airbag'];
					$carsafety['RearSeatBelts']			=	$detailsmongo['rear_seat_belts'];
					$carsafety['SeatBeltWarning']		=	$detailsmongo['seat_belt_warning'];
					$carsafety['AdjustableSeats']		=	$detailsmongo['adjustable_seats'];
					$carsafety['CrashSensor']			=	$detailsmongo['crash_sensor'];
					$carsafety['AntiTheftDevice']		=	$detailsmongo['anti_theft_device'];
					$carsafety['Immobilizer']			=	$detailsmongo['immobilizer'];
					array_push($carsafetydetails,$carsafety);
				  
					//car EXTERIOR details
					$carexterior['AdjustableHeadLights']=	$detailsmongo['adjustable_head_lights'];
					$carexterior['RearViewMirror']		=	$detailsmongo['power_adjustable_exterior_rear_view_mirror'];
					$carexterior['ElectricFoldingRearMirror']	=	$detailsmongo['electric_folding_rear_view_mirror'];
					$carexterior['RainSensingWipers']	=	$detailsmongo['rain_sensing_wipers'];
					$carexterior['RearWindowWiper']		=	$detailsmongo['rear_window_wiper'];
					$carexterior['AlloyWheels']			=	$detailsmongo['alloy_wheels'];
					$carexterior['FrontFogLights']		=	$detailsmongo['front_fog_lights'];
					$carexterior['rear_window_defogger']=	$detailsmongo['rear_window_defogger'];
					$carexterior['tinted_glass']		=	$detailsmongo['tinted_glass'];
					array_push($carexteriordetails,$carexterior);
					//car ENTERTAINMENT details
					$carentertainment['Cdplayer']		=	$detailsmongo['cdplayer'];
					$carentertainment['Radio']			=	$detailsmongo['radio'];
					$carentertainment['Audio']			=	$detailsmongo['audio'];
					$carentertainment['Bluetooth']		=	$detailsmongo['bluetooth'];
					array_push($carentertainmentdetails,$carentertainment);
					// CAR DIEMENTION DETAILS
					$cardiemention['Length']			=	$detailsmongo['length'];
					$cardiemention['Width']				=	$detailsmongo['width'];
					$cardiemention['Height']			=	$detailsmongo['height'];
					$cardiemention['WheelBase']			=	$detailsmongo['wheel_base'];
					$cardiemention['GrossWeight']		=	$detailsmongo['gross_weight'];
					array_push($cardiementiondetails,$cardiemention);
				}//end foreach
				}
			}
			return response()->json(['Result'=>'1',
										'message'=>'success',
										'carimagesdetails'=>$carimagesdetails,
										'carmodeldetails'=>$getcarmodeldetails,
										'carspecification'=>$carspecificationdetails,
										'carenginedetails'=>$carenginedetails,
										'carinteriordetails'=>$carinteriordetails,
										'carcomportdetails'=>$carcomportdetails,
										'carsafetydetails'=>$carsafetydetails,
										'carexteriordetails'=>$carexteriordetails,
										'carentertainmentdetails'=>$carentertainmentdetails,
										'cardiemention'=>$cardiementiondetails
										]);
			}
			return response()->json(['Result'=>'0',
										'message'=>'Failure!!'
										]);
			}
			return response()->json(['Result'=>'0',
										'message'=>'Invalid Access!!'
										]);
		}
		
	//VIEW CAR DETAILS FUNCTION
	public function doApiviewcardetails()
	{
		$id                           	= 	Input::get('session_user_id');     
		$car_id                       	= 	Input::get('car_id');
		if($id == "" || $car_id == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'Userid and carid is required!!'
									]);
		}
		$wherecondition 				=	(string) $car_id;
		$photosdata 					=	array();
		$photosdetails 					=	array();
		$videosdata 					=	array();
		$videosdetails 					=	array();
		$carimages 		 				=	array();
		$carimagesdetails 				=	array();
		$carmodeldetails 				=	array();
		$getcarmodeldetails 			=	array();
		$carspecification 				=	array();
		$carspecificationdetails 		=	array();
		$carengine 						=	array();
		$carenginedetails 				=	array();
		$carinterior 					=	array();
		$carinteriordetails 			=	array();
		$carcomport 					=	array();
		$carcomportdetails 				=	array();
		$carsafety 						=	array();
		$carsafetydetails 				=	array();
		$carexterior 					=	array();
		$carexteriordetails 			=	array();
		$carentertainment 				=	array();
		$carentertainmentdetails 		=	array();
		$cardiemention 					=	array();
		$cardiementiondetails 			=	array();
		$cardealerinfo 		 			=	array();
		$cardealerinfodetails 		 	=	array();
		$cardealermessage 		 		=	array();
		$cardealermessagedetails 		=	array();
		$getdealer_schemaname 	  		=	buyymodel::masterFetchTableDetails($id,
																	$this->masterMainLoginTable,
																	array('d_id'=>$id)
																	);
		if(!empty($getdealer_schemaname) && count($getdealer_schemaname) > 0)
		{
			if(is_numeric($car_id))
			{
				$checkcarid 			=	$this->doviewcardetails($id,$car_id);
				if($checkcarid 	==	"No Records Found")
				{
					return response()->json(['Result'=>'0',
									'message'=>'No Record Founds'
									]);
				}
				return response()->json($checkcarid);
			}
			$currentdealer 					=	array();
			$dealercityname 				=	"";
			foreach($getdealer_schemaname as $dealername)
			{
				$dealer_schemaname			= 	$dealername->dealer_schema_name;
				$dealer_name                = 	$dealername->dealer_name;
				$d_email                    = 	$dealername->d_email;
				$placewhere					=	array('master_id'=>$dealername->d_city);
				$getplace 	 				=	inventorymodel::masterschema_table_where(
																			'master_city',
																			$placewhere);
				$dealercityname 			=	((count($getplace)>=1)?$getplace[0]->city_name:'');
				$gettodaydate 				=	Carbon::now('Asia/Kolkata')->format('Y-m-d');
				$currentdealer 				=	array('dealershipname'=>$dealername->dealership_name,
														'dealername'=>$dealer_name,
														'dealeremailid'=>$d_email,
														'dealermobile'=>$dealername->d_mobile,
														'dealercity'=>$dealercityname,
														'todaydate'=>$gettodaydate);
			}
			
			//CHECK FUNDING TICKET ID IS EXIST OR NOT STRAT
			$fundingticket      			=   "";
			$getfundingticketid 			= 	fundingmodel::doGetcardetailsfundingisexist($id, $car_id);
			if (!empty($getfundingticketid) && count($getfundingticketid)) {
				$getticketid 				= 	collect($getfundingticketid)->toArray();
				$fundingticket  			=   $getticketid[0]->dealer_funding_ticket_id;
			}
			if(!empty($fundingticket))
			{
				$fundingdetails 			=	array('result'=>1,'fundingticketid'=>$fundingticket);
			}
			else
			{
				$fundingdetails 			=	array('result'=>0,'fundingticketid'=>$fundingticket);
			}
			$reportingdetails 				=	array();
			//REPORTING CHECK EXIT OR NOT
			$saveddata 						= 	array('dealer_listing_id' => $car_id, 
														'dealer_id' => $id
													);
			$saved_dealer_car 				= 	buyymodel::masterFetchTableDetails($id,
															'dealer_reported_listings', 
															$saveddata
															);
			
			if(!empty($saved_dealer_car) && count($saved_dealer_car) >= 1)
			{
				$reportingvalue 			=	((count($saved_dealer_car)>=1)?$saved_dealer_car[0]->report_listing_type_type_id:''); 					
				switch($reportingvalue)
				{
					case 1:
						$reportingname      = 	"Car Not Available";
						break;
					case 2:
						$reportingname      = 	"Inaccurate Price";
						break;
					case 3:
						$reportingname      = 	"Scam";
						break;	
					case 4:
						$reportingname      = 	"Others";
						break;	
					default:
						$reportingname      = 	"";
				}
				$reportingdetail 			=	array(array('reportingid'=>1,
														'reportingname'=>'Car Not Available'),
												array('reportingid'=>2,
														'reportingname'=>'Inaccurate Price'),
												array('reportingid'=>3,
														'reportingname'=>'Scam'),
												array('reportingid'=>4,
														'reportingname'=>'Others'));
				$selectedreport 			=	array(
														'reportingid'=>$reportingvalue,
														'reportingname'=>$reportingname);
				$reportingdetails 			=	array($selectedreport,$reportingdetail);
														
			}
			else
			{
				$reportingdetail 			=	array(array('reportingid'=>1,
														'reportingname'=>'Car Not Available'),
												array('reportingid'=>2,
														'reportingname'=>'Inaccurate Price'),
												array('reportingid'=>3,
														'reportingname'=>'Scam'),
												array('reportingid'=>4,
														'reportingname'=>'Others'));
				$selectedreport 			=	array(
														'reportingid'=>"",
														'reportingname'=>"");
				$reportingdetails 			=	array($selectedreport,$reportingdetail);
			}
			
			$getcardetailsmongo             = 	buyymodel::mongoviewcardetails($id,
																		$wherecondition
																	);
			
			$viewed_insert_array          	= 	array('dealer_id'=>$id,'car_id'=>$car_id);
			$inserviewcount 				=	buyymodel::dealerInsertTable($id,$dealer_schemaname,
													$this->dealerViewedCarsTable,
													$viewed_insert_array
												);
			if($inserviewcount >= 1)
			{
					buyymodel::masterInsertTable($id,$this->dealerViewedCarsTable,$viewed_insert_array);
			}
			$variant_id                   	=	'';
			$make_id                      	=	'';
			$auction_end_time             	=	array();
			$detail_list_data             	=	array();
			if(!empty($getcardetailsmongo) && count($getcardetailsmongo)>=1)
			{
				foreach ($getcardetailsmongo as $detailsmongo) {

				$queries_contact_title    		= 	Config::get('common.queries_contact_title');
				$contact_array 					= 	array('user_id'=>$id,
																'car_id'=>$car_id,
																'title'=>$queries_contact_title
															);

				$detail_list_data['contactmessagestatus']    = 	buyymodel::dealerTableCount($id,
																			$dealer_schemaname,
																			$this->dealermessageTable,
																			$contact_array);

				$queries_testdrive_title    	= 	Config::get('common.queries_testdrive_title');
				$contact_array['title'] 		= 	$queries_testdrive_title;
				$detail_list_data['test_drive_status']	= 	buyymodel::dealerTableCount($id,
																				$dealer_schemaname,
																				$this->dealermessageTable,
																				$contact_array);

				$get_dealer_saved_cars     		=	buyymodel::dealerFetchTableDetails($id,$dealer_schemaname,
																			$this->dealerSavedCarListingTable,
																			array('car_id'=>$detailsmongo["listing_id"])
																			);
				$carimages['savedcars']			=	((count($get_dealer_saved_cars)>=1)?$get_dealer_saved_cars[0]->saved_status:'');
				$get_api_sites               	= 	buyymodel::masterFetchTableDetails($id,
																				$this->masterApiSitesTable,
																				array('sitename'=>$detailsmongo['sitename'])
																				);
			  if(count($get_api_sites)>=1)
			  {
					$detail_list_data['site_image']	= 	stripcslashes(url($get_api_sites[0]->logourl));
			  }
			  else
			  {
					$detail_list_data['site_image'] = 	'';
			  }
			  //images  result
			  if(count($detailsmongo["photos"]) >= 1)
			  {
				  foreach ($detailsmongo["photos"] as $photokey => $photovalue) {
						$photosdata[]				=	$photovalue['s3_bucket_path'];
						$photosname[]				=	$photovalue['profile_pic_name'];
				  }
				  $carimages['image_url'] 			= 	$photosdata;
				  $carimages['image_name'] 			= 	$photosname;
			  }
			  else
			  {
				$carnoimage                     	= 	Config::get('common.carnoimage');
				$carimages['image_name'] 			= 	"";
				$carimages['image_url'] 			=	array(url($carnoimage));
			  }
			  $video_array                      	=	array();
			  if(count($detailsmongo["videos"]) >= 1)
			  {
				  foreach ($detailsmongo["videos"] as $vediokey => $videovalue) {
					  $videosdata[]					=	$videovalue['video_url_fullpath'];
				  }
				  $carimages['video_url']			= 	$videosdata;
			  }
			  else
			  {
				  $carimages['video_url']			=	$videosdata;
			  }
			  $whereconalert 				=	array("alert_listingid"=>$detailsmongo["listing_id"]);
			  $checkcaridexist 				= 	buyymodel::masterFetchTableDetails(
																	$id,																
																	$this->alertcarhistoryTable,
																	$whereconalert
																	);
			   if(!empty($checkcaridexist) && count($checkcaridexist)>=1)
			   {
					if($checkcaridexist[0]->alert_status == 1)
					{
						$carimages['alert_status']   	= 	$checkcaridexist[0]->alert_status;
					}
					else
					{
						$carimages['alert_status']   	= 	0;
					}
			   }
			   else
			   {
					$carimages['alert_status']   	= 	0;
			   }
			   
			  array_push($carimagesdetails,$carimages);
			  //car model details result
			  $carmodeldetails['imagecount']		=	count($detailsmongo['photos']);
			  $carmodeldetails['videocount']		=	count($detailsmongo['videos']);
			  $carmodeldetails['Make']				=	$detailsmongo['make'];
			  $carmodeldetails['Model']				=	$detailsmongo['model'];
			  $carmodeldetails['Variant']			=	$detailsmongo['variant'];
			  $carmodeldetails['Year']				=	$detailsmongo['registration_year'];
			  $carmodeldetails['Fuel Type']			=	$detailsmongo['fuel_type'];
			  $carmodeldetails['listing_id']    	= 	$detailsmongo['listing_id'];
			  $carmodeldetails['dealer_id']  		= 	$detailsmongo['dealer_id'];
			  $carmodeldetails['Mileage']      		= 	$detailsmongo['mileage'];
			  $carmodeldetails['Kilometers']      	= 	$detailsmongo['kilometer_run'];
			  $carmodeldetails['OwnerType']      	= 	$detailsmongo['owner_type'];
			  $carmodeldetails['Price']         	= 	$detailsmongo['sell_price'];
			  $carmodeldetails['site_image']		=	$detail_list_data['site_image'];
			  $carmodeldetails['SeatingCapacity']  	= 	$detailsmongo['seating_capacity'];
			  $carmodeldetails['Location']  		= 	$detailsmongo['car_locality'];
			  $carmodeldetails['transmission']		=	$detailsmongo['transmission'];
			  $carmodeldetails['Date']  			= 	commonmodel::getdatemonthtimeformat($detailsmongo['created_at']);
			  $expiry_date 							= 	commonmodel::daysBetweenExpirydate($detailsmongo['listing_expiry_date']);
			  $carmodeldetails['soldstatus'] 		= 	commonmodel::listing_status_msg($detailsmongo['listing_status'], $expiry_date);
			  
			  array_push($getcarmodeldetails,$carmodeldetails);
			  //car specification result
			  $carspecification['Color']			=	$detailsmongo['colors'];
			  $carspecification['Gear Box']			=	$detailsmongo['gear_box'];
			  $carspecification['Drive Type']		=	$detailsmongo['drive_type'];
			  $carspecification['Seating Capacity']	=	$detailsmongo['seating_capacity'];
			  $carspecification['Steering Type']	=	$detailsmongo['steering_type'];
			  $carspecification['Turning Radius']	=	$detailsmongo['turning_radius'];
			  $carspecification['Acceleration']		=	$detailsmongo['acceleration'];
			  $carspecification['Tyre Type']		=	$detailsmongo['tyre_type'];
			  $carspecification['No of doors']		=	$detailsmongo['no_of_doors'];
			  $carspecification['Top Speed']		=	$detailsmongo['top_speed'];
			  array_push($carspecificationdetails,$carspecification);
			  //car engine details
			  $carengine['Engine Type']				=	$detailsmongo['engine_type'];
			  $carengine['Displacement']			=	$detailsmongo['displacement'];
			  $carengine['Max Power']				=	$detailsmongo['max_power'];
			  $carengine['Max Torque']				=	$detailsmongo['max_torque'];
			  $carengine['No of cylinder']			=	$detailsmongo['no_of_cylinder'];
			  $carengine['Valves per cylinder']		=	$detailsmongo['valves_per_cylinder'];
			  $carengine['Valve Configuration']		=	$detailsmongo['valve_configuration'];
			  $carengine['Fuel Supply System']		=	$detailsmongo['fuel_supply_system'];
			  $carengine['Turbo Charger']			=	$detailsmongo['turbo_charger'];
			  $carengine['Super Charger']			=	$detailsmongo['super_charger'];
			  array_push($carenginedetails,$carengine);
			  
			  //car INTERIOR details
			  $carinterior['Air Conditioner']		=	$detailsmongo['air_conditioner'];
			  $carinterior['Adjustable Steering']	=	$detailsmongo['adjustable_steering'];
			  $carinterior['Leather Steering Wheel']=	$detailsmongo['leather_steering_wheel'];
			  $carinterior['Heater']				=	$detailsmongo['heater'];
			  $carinterior['Digital Clock']			=	$detailsmongo['digital_clock'];
			  array_push($carinteriordetails,$carinterior);
			  
			  //car comfort details
			  $carcomport['Power Steering']			=	$detailsmongo['power_steering'];
			  $carcomport['Power Windows Front']	=	$detailsmongo['power_windows_front'];
			  $carcomport['Power Windows Rear']		=	$detailsmongo['power_windows_rear'];
			  $carcomport['Remote Trunk Opener']	=	$detailsmongo['remote_trunk_opener'];
			  $carcomport['Remote Fuel lid opener']	=	$detailsmongo['remote_fuel_lid_opener'];
			  $carcomport['Low Fuel Warning Light']	=	$detailsmongo['low_fuel_warning_light'];
			  $carcomport['Rear Reading Lamp']		=	$detailsmongo['rear_reading_lamp'];
			  $carcomport['Rear Seat Centre Arm Rest']	=	$detailsmongo['rear_seat_centre_arm_rest'];
			  $carcomport['Height Adjustable Front Seat Belts']=	$detailsmongo['height_adjustable_front_seat_belts'];
			  $carcomport['Cup Holders Front']		=	$detailsmongo['cup_holders_front'];
			  $carcomport['Rear Ac vents']			=	$detailsmongo['rear_ac_vents'];
			  $carcomport['Parking Sensors']		=	$detailsmongo['parking_sensors'];
			  $carcomport['Rear Seat Headrest']		=	$detailsmongo['rear_seat_headrest'];
			  array_push($carcomportdetails,$carcomport);
			  //car SAFETY details
			  $carsafety['Anti Lock Braking System']=	$detailsmongo['anti_lock_braking_system'];
			  $carsafety['Central Locking']			=	$detailsmongo['central_locking'];
			  $carsafety['Child Safety Lock']		=	$detailsmongo['child_safety_lock'];
			  $carsafety['Driver Airbags']			=	$detailsmongo['driver_airbags'];
			  $carsafety['Passenger Airbag']		=	$detailsmongo['passenger_airbag'];
			  $carsafety['Rear Seat Belts']			=	$detailsmongo['rear_seat_belts'];
			  $carsafety['Seat Belt Warning']		=	$detailsmongo['seat_belt_warning'];
			  $carsafety['Adjustable Seats']		=	$detailsmongo['adjustable_seats'];
			  $carsafety['Crash Sensor']			=	$detailsmongo['crash_sensor'];
			  $carsafety['Anti Theft Device']		=	$detailsmongo['anti_theft_device'];
			  $carsafety['Immobilizer']				=	$detailsmongo['immobilizer'];
			  array_push($carsafetydetails,$carsafety);
			  
			  //car EXTERIOR details
			  $carexterior['Adjustable Head Lights']=	$detailsmongo['adjustable_head_lights'];
			  $carexterior['Power adjustable exterior rear view mirror']		=	$detailsmongo['power_adjustable_exterior_rear_view_mirror'];
			  $carexterior['Electric Folding Rear Mirror']	=	$detailsmongo['electric_folding_rear_view_mirror'];
			  $carexterior['Rain Sensing Wipers']	=	$detailsmongo['rain_sensing_wipers'];
			  $carexterior['Rear Window Wiper']		=	$detailsmongo['rear_window_wiper'];
			  $carexterior['Alloy Wheels']			=	$detailsmongo['alloy_wheels'];
			  $carexterior['Front Fog Lights']		=	$detailsmongo['front_fog_lights'];
			  $carexterior['Rear window Defogger']	=	$detailsmongo['rear_window_defogger'];
			  $carexterior['Tinted Glass']			=	$detailsmongo['tinted_glass'];
			  array_push($carexteriordetails,$carexterior);
			  //car ENTERTAINMENT details
			  $carentertainment['CD Player']			=	$detailsmongo['cdplayer'];
			  $carentertainment['Radio']			=	$detailsmongo['radio'];
			  $carentertainment['Audio']			=	$detailsmongo['audio'];
			  $carentertainment['Bluetooth']		=	$detailsmongo['bluetooth'];
			  array_push($carentertainmentdetails,$carentertainment);
			  // CAR DIEMENTION DETAILS
			  $cardiemention['Length']				=	$detailsmongo['length'];
			  $cardiemention['Width']				=	$detailsmongo['width'];
			  $cardiemention['Height']				=	$detailsmongo['height'];
			  $cardiemention['Wheel Base']			=	$detailsmongo['wheel_base'];
			  $cardiemention['Gross Weight']		=	$detailsmongo['gross_weight'];
			  array_push($cardiementiondetails,$cardiemention);
				//get dealer info 
				if(empty($detailsmongo['branch_id']) && $detailsmongo['branch_id'] == 0)
				{
					$cardealerinfo['Mobile Number']	=	$detailsmongo['car_owner_mobile'];
					$cardealerinfo['Dealer Address']=	$detailsmongo['car_locality'];
					array_push($cardealerinfodetails,$cardealerinfo);
				}
				else
				{
					$cardealerinfo['Mobile Number']	=	$detailsmongo['car_owner_mobile'];
					$cardealerinfo['Dealer Address']=	$detailsmongo['branch_address'];
					array_push($cardealerinfodetails,$cardealerinfo);
				}
			//MESSAGE DEALER INFO
			$cardealermessage['Car Owner Name']		=	$detailsmongo['car_owner_name'];
			$cardealermessage['Car Owner Email']	=	$detailsmongo['car_owner_email'];
			$cardealermessage['Mobile Number']		=	$detailsmongo['car_owner_mobile'];
			if($detailsmongo['test_drive'] != null && $detailsmongo['test_drive'] != 0)
			{
				$cardealermessage['testdrive_dealerpoint']	=	$detailsmongo['testdrive_dealerpoint'];
				$cardealermessage['testdrive_doorstep']		=	$detailsmongo['testdrive_doorstep'];
			}
			else
			{
				$cardealermessage['testdrive_dealerpoint']	=	"No";
				$cardealermessage['testdrive_doorstep']		=	"No";
			}
			
			array_push($cardealermessagedetails,$cardealermessage);
			}//endforeach
			return response()->json(['Result'=>'1',
									'message'=>'success',
									'carimagesdetails'=>$carimagesdetails,
									'carmodeldetails'=>$getcarmodeldetails,
									'carspecification'=>$carspecificationdetails,
									'carenginedetails'=>$carenginedetails,
									'carinteriordetails'=>$carinteriordetails,
									'carcomportdetails'=>$carcomportdetails,
									'carsafetydetails'=>$carsafetydetails,
									'carexteriordetails'=>$carexteriordetails,
									'carentertainmentdetails'=>$carentertainmentdetails,
									'cardiemention'=>$cardiementiondetails,
									'dealerinfo'=>$cardealerinfodetails,
									'dealermessage'=>$cardealermessagedetails,
									'fundingdetails'=>[$fundingdetails],
									'currentdealerdetails'=>[$currentdealer],
									'reportingdetails'=>$reportingdetails
									]);
			}else
			{
				return response()->json(['Result'=>'0',
									'message'=>'success',
									'carimagesdetails'=>$carimagesdetails,
									'carmodeldetails'=>$getcarmodeldetails,
									'carspecification'=>$carspecificationdetails,
									'carenginedetails'=>$carenginedetails,
									'carinteriordetails'=>$carinteriordetails,
									'carcomportdetails'=>$carcomportdetails,
									'carsafetydetails'=>$carsafetydetails,
									'carexteriordetails'=>$carexteriordetails,
									'carentertainmentdetails'=>$carentertainmentdetails,
									'cardiemention'=>$cardiementiondetails,
									'dealerinfo'=>$cardealerinfodetails,
									'dealermessage'=>$cardealermessagedetails,
									'fundingdetails'=>[$fundingdetails],
									'currentdealerdetails'=>[$currentdealer],
									'reportingdetails'=>$reportingdetails
									]);
			}
		
		}
		return response()->json(['Result'=>'0',
									'message'=>'Failure!!'
									]);
	}
	public function doviewcardetails($id,$car_id)
	{
		$photosdata 					=	array();
		$photosdetails 					=	array();
		$videosdata 					=	array();
		$videosdetails 					=	array();
		$carimages 		 				=	array();
		$carimagesdetails 				=	array();
		$carmodeldetails 				=	array();
		$getcarmodeldetails 			=	array();
		$carspecification 				=	array();
		$carspecificationdetails 		=	array();
		$carengine 						=	array();
		$carenginedetails 				=	array();
		$carinterior 					=	array();
		$carinteriordetails 			=	array();
		$carcomport 					=	array();
		$carcomportdetails 				=	array();
		$carsafety 						=	array();
		$carsafetydetails 				=	array();
		$carexterior 					=	array();
		$carexteriordetails 			=	array();
		$carentertainment 				=	array();
		$carentertainmentdetails 		=	array();
		$cardiemention 					=	array();
		$cardiementiondetails 			=	array();
		$cardealerinfo 		 			=	array();
		$cardealerinfodetails 		 	=	array();
		$cardealermessage 		 		=	array();
		$cardealermessagedetails 		=	array();
		$getdealer_schemaname 	  		=	buyymodel::masterFetchTableDetails($id,
																	$this->masterMainLoginTable,
																	array('d_id'=>$id)
																	);
		if(!empty($getdealer_schemaname) && count($getdealer_schemaname) > 0)
		{
			$d_mobile 	=	"";
			foreach($getdealer_schemaname as $dealername)
			{
				$dealer_schemaname			= 	$dealername->dealer_schema_name;
				$dealer_name                = 	$dealername->dealer_name;
				$d_email                    = 	$dealername->d_email;
				$d_mobile                   = 	$dealername->d_mobile;
			}
			$wherecar 						=	array('car_id'=>$car_id);
			$getcardetailsmongo 			=	buyymodel::dealerFetchTableDetails(
																			$id,
																			$dealer_schemaname,
																			'dms_car_listings',
																			$wherecar
																			);			
			$variant_id                   	=	'';
			$make_id                      	=	'';
			$auction_end_time             	=	array();
			$detail_list_data             	=	array();
			
			$currentdealer 					=	array();
			$dealercityname 				=	"";
			foreach($getdealer_schemaname as $dealername)
			{
				$dealer_schemaname			= 	$dealername->dealer_schema_name;
				$dealer_name                = 	$dealername->dealer_name;
				$d_email                    = 	$dealername->d_email;
				$placewhere					=	array('master_id'=>$dealername->d_city);
				$getplace 	 				=	inventorymodel::masterschema_table_where(
																			'master_city',
																			$placewhere);
				$dealercityname 			=	((count($getplace)>=1)?$getplace[0]->city_name:'');
				$gettodaydate 				=	Carbon::now('Asia/Kolkata')->format('Y-m-d');
				$currentdealer 				=	array('dealershipname'=>$dealername->dealership_name,
														'dealername'=>$dealer_name,
														'dealeremailid'=>$d_email,
														'dealermobile'=>$dealername->d_mobile,
														'dealercity'=>$dealercityname,
														'todaydate'=>$gettodaydate);
			}
			
			if(!empty($getcardetailsmongo) && count($getcardetailsmongo)>=1)
			{
				foreach($getcardetailsmongo as $detailsmongo) 
				{
					$queries_contact_title  = 	Config::get('common.queries_contact_title');
					$contact_array 			= 	array('user_id'=>$id,
													'car_id'=>$car_id,
													'title'=>$queries_contact_title
												);

					$detail_list_data['contactmessagestatus']	= 	buyymodel::dealerTableCount($id,
																				$dealer_schemaname,
																				$this->dealermessageTable,
																				$contact_array);
					$queries_testdrive_title = 	Config::get('common.queries_testdrive_title');
					$contact_array['title']  = 	$queries_testdrive_title;
					$detail_list_data['test_drive_status']	= 	buyymodel::dealerTableCount($id,
																					$dealer_schemaname,
																					$this->dealermessageTable,
																					$contact_array);

					$get_dealer_saved_cars  =	buyymodel::dealerFetchTableDetails($id,$dealer_schemaname,
																				$this->dealerSavedCarListingTable,
																				array('car_id'=>$detailsmongo->duplicate_id)
																				);
					$carimages['savedcars']	=	((count($get_dealer_saved_cars)>=1)?$get_dealer_saved_cars[0]->saved_status:'');
					$get_api_sites      	= 	buyymodel::masterFetchTableDetails($id,
																			$this->masterApiSitesTable,
																			array('sitename'=>'')
																			);
					if(count($get_api_sites)>=1)
					{
						$detail_list_data['site_image']	= 	stripcslashes(url($get_api_sites[0]->logourl));
					}
					else
					{
						$detail_list_data['site_image'] = 	'';
					}
					$imagefetch 			= 	buyymodel::dealerFetchTableDetails($id,
																			$dealer_schemaname,
																			'dms_car_listings_photos',
																			array('car_id'=>$car_id)
																			);
					//images  result
					if(!empty($imagefetch) && count($imagefetch) >= 1)
					{
					  foreach ($imagefetch as $photokey => $photovalue) {
							$photosdata[]				=	$photovalue->s3_bucket_path;
							$photosname[]				=	$photovalue->profile_pic_name;
						}
						  $carimages['image_url'] 		= 	$photosdata;
						  $carimages['image_name'] 		= 	$photosname;
					}
					else
					{
						$carnoimage                     = 	Config::get('common.carnoimage');
						$carimages['image_name'] 		= 	"";
						$carimages['image_url'] 		=	array(url($carnoimage));
					}
					$videosfetch 						= 	buyymodel::dealerFetchTableDetails($id,
																			$dealer_schemaname,
																			'dms_car_listings_videos',
																			array('car_id'=>$car_id)
																			);
					$video_array                      	=	array();
					if(!empty($videosfetch) && count($videosfetch) >= 1)
					{
						foreach ($videosfetch as $vediokey => $videovalue) {
						  $videosdata[]					=	$videovalue->video_url_fullpath;
						}
						$carimages['video_url']			= 	$videosdata;
					}
					else
					{
						$carimages['video_url']			=	$videosdata;
					}
					$carimages['alert_status']   		= 	"";
					array_push($carimagesdetails,$carimages);
					
					$getfeatures 						= 	buyymodel::dealerFetchTableDetails($id,
																			$dealer_schemaname,
																			'dealer_listing_features',
																			array('listing_id'=>$car_id)
																			);
					//car model details result
					$carmodeldetails['imagecount']		=	count($imagefetch);
					$carmodeldetails['videocount']		=	count($videosfetch);
					$makewhere							=	array($this->masterMakeIdfiled=>$detailsmongo->make);
					$getmake 	 						=	inventorymodel::masterschema_table_where(
																				$this->masterMakeTable,
																				$makewhere);
					$carmodeldetails['Make'] 			=	((count($getmake)>=1)?$getmake[0]->makename:'');
					$modelwhere							=	array('model_id'=>$detailsmongo->model_id);
					$getmodel 	 						=	inventorymodel::masterschema_table_where(
																				$this->masterModelsTable,
																				$modelwhere);
					$carmodeldetails['Model'] 			=	((count($getmodel)>=1)?$getmodel[0]->model_name:'');
					$varientwhere						=	array('variant_id'=>$detailsmongo->variant);
					$getvarient 	 					=	inventorymodel::masterschema_table_where(
																				'master_variants',
																				$varientwhere);
					$carmodeldetails['Variant'] 		=	((count($getvarient)>=1)?$getvarient[0]->variant_name:'');
					$carmodeldetails['Year']			=	$detailsmongo->registration_year;
					$carmodeldetails['Fuel Type']		=	$detailsmongo->fuel_type;
					$carmodeldetails['listing_id']    	= 	$detailsmongo->duplicate_id;
					$carmodeldetails['dealer_id']  		= 	$detailsmongo->dealer_id;
					$carmodeldetails['Mileage']      	= 	$detailsmongo->mileage;
					$carmodeldetails['Kilometers']      = 	$detailsmongo->kms_done;
					$carmodeldetails['OwnerType']      	= 	$detailsmongo->owner_type;
					$carmodeldetails['Price']         	= 	$detailsmongo->price;
					$carmodeldetails['transmission']	=	$detailsmongo->transmission;
					$carmodeldetails['site_image']		=	"";
					$carmodeldetails['SeatingCapacity'] = 	((count($getfeatures)>=1)?$getfeatures[0]->seating_capacity:'');
					
                    $placewhere							=	array('master_id'=>$detailsmongo->car_city);
					$getplace 	 						=	inventorymodel::masterschema_table_where(
																				'master_city',
																				$placewhere);
					$carmodeldetails['Location'] 		=	((count($getplace)>=1)?$getplace[0]->city_name:'');
					$carmodeldetails['Date']  			= 	commonmodel::getdatemonthtimeformat($detailsmongo->created_at);
					switch($detailsmongo->car_master_status)
					{
						case 3:
						$carmodeldetails['soldstatus'] 		= 	"This Listing is Sold";
						break;
						default:
						$carmodeldetails['soldstatus'] 		= 	"";
					}
					
					array_push($getcarmodeldetails,$carmodeldetails);
					
					
					$reportingdetail 			=	array(array('reportingid'=>1,
														'reportingname'=>'Car Not Available'),
													array('reportingid'=>2,
															'reportingname'=>'Inaccurate Price'),
													array('reportingid'=>3,
															'reportingname'=>'Scam'),
													array('reportingid'=>4,
															'reportingname'=>'Others'));
					$selectedreport 			=	array(
														'reportingid'=>"",
														'reportingname'=>"");
					$reportingdetails 			=	array($selectedreport,$reportingdetail);

					//car specification result
					$colorwhere							=	array('colour_id'=>$detailsmongo->colors);
					$getcolor 	 						=	inventorymodel::masterschema_table_where(
																				'master_colors',
																				$colorwhere);
					$carspecification['Color'] 			=	((count($getcolor)>=1)?$getcolor[0]->colour_name:'');
					
					$carspecification['Gear Box']		=	((count($getfeatures)>=1)?$getfeatures[0]->gear_box:'');
					$carspecification['Drive Type']		=	((count($getfeatures)>=1)?$getfeatures[0]->drive_type:'');
					$carspecification['Seating Capacity']	=	((count($getfeatures)>=1)?$getfeatures[0]->seating_capacity:'');
					$carspecification['Steering Type']	=	((count($getfeatures)>=1)?$getfeatures[0]->steering_type:'');
					$carspecification['Turning Radius']	=	((count($getfeatures)>=1)?$getfeatures[0]->turning_radius:'');
					$carspecification['Acceleration']	=	((count($getfeatures)>=1)?$getfeatures[0]->acceleration:'');
					$carspecification['Tyre Type']		=	((count($getfeatures)>=1)?$getfeatures[0]->tyre_type:'');
					$carspecification['No of doors']	=	((count($getfeatures)>=1)?$getfeatures[0]->no_of_doors:'');
					$carspecification['Top Speed']		=	((count($getfeatures)>=1)?$getfeatures[0]->top_speed:'');
					array_push($carspecificationdetails,$carspecification);
					//car engine details
					$carengine['Engine Type']			=	((count($getfeatures)>=1)?$getfeatures[0]->engine_type:'');
					$carengine['Displacement']			=	((count($getfeatures)>=1)?$getfeatures[0]->displacement:'');
					$carengine['Max Power']				=	((count($getfeatures)>=1)?$getfeatures[0]->max_power:'');
					$carengine['Max Torque']			=	((count($getfeatures)>=1)?$getfeatures[0]->max_torque:'');
					$carengine['No of cylinder']		=	((count($getfeatures)>=1)?$getfeatures[0]->no_of_cylinder:'');
					$carengine['Values per cylinder']	=	((count($getfeatures)>=1)?$getfeatures[0]->valves_per_cylinder:'');
					$carengine['Value Configuration']	=	((count($getfeatures)>=1)?$getfeatures[0]->valve_configuration:'');
					$carengine['Fuel Supply System']	=	((count($getfeatures)>=1)?$getfeatures[0]->fuel_supply_system:'');
					$carengine['Turbo Charger']			=	((count($getfeatures)>=1)?$getfeatures[0]->turbo_charger:'');
					$carengine['Super Charger']			=	((count($getfeatures)>=1)?$getfeatures[0]->super_charger:'');
					array_push($carenginedetails,$carengine);
					
					//car INTERIOR details
					$carinterior['Air Conditioner']		=	((count($getfeatures)>=1)?$getfeatures[0]->air_conditioner:'');
					$carinterior['Adjustable Steering']	=	((count($getfeatures)>=1)?$getfeatures[0]->adjustable_steering:'');
					$carinterior['Leather Steering Wheel']=	((count($getfeatures)>=1)?$getfeatures[0]->leather_steering_wheel:'');
					$carinterior['Heater']				=	((count($getfeatures)>=1)?$getfeatures[0]->heater:'');
					$carinterior['Digital Clock']		=	((count($getfeatures)>=1)?$getfeatures[0]->digital_clock:'');
					array_push($carinteriordetails,$carinterior);

					//car comfort details
					$carcomport['Power Steering']		=	((count($getfeatures)>=1)?$getfeatures[0]->power_steering:'');
					$carcomport['Power Windows Front']	=	((count($getfeatures)>=1)?$getfeatures[0]->power_windows_front:'');
					$carcomport['Power Windows Rear']	=	((count($getfeatures)>=1)?$getfeatures[0]->power_windows_rear:'');
					$carcomport['Remote Trunk Opener']	=	((count($getfeatures)>=1)?$getfeatures[0]->remote_trunk_opener:'');
					$carcomport['Remote Fuel lid opener']	=	((count($getfeatures)>=1)?$getfeatures[0]->remote_fuel_lid_opener:'');
					$carcomport['Low Fuel Warning Light']	=	((count($getfeatures)>=1)?$getfeatures[0]->low_fuel_warning_light:'');
					$carcomport['Rear Reading Lamp']	=	((count($getfeatures)>=1)?$getfeatures[0]->rear_reading_lamp:'');
					$carcomport['Rear Seat Centre Arm Rest']	=	((count($getfeatures)>=1)?$getfeatures[0]->rear_seat_centre_arm_rest:'');
					$carcomport['Height Adjustable Front Seat Belts']=	((count($getfeatures)>=1)?$getfeatures[0]->height_adjustable_front_seat_belts:'');
					$carcomport['Cup Holders Front']	=	((count($getfeatures)>=1)?$getfeatures[0]->cup_holders_front:'');
					$carcomport['Rear Ac vents']		=	((count($getfeatures)>=1)?$getfeatures[0]->rear_ac_vents:'');
					$carcomport['Parking Sensors']		=	((count($getfeatures)>=1)?$getfeatures[0]->parking_sensors:'');
					$carcomport['Rear Seat Headrest']	=	((count($getfeatures)>=1)?$getfeatures[0]->rear_seat_headrest:'');
					array_push($carcomportdetails,$carcomport);
					
					//car SAFETY details
					$carsafety['Anti Lock Braking System']=	((count($getfeatures)>=1)?$getfeatures[0]->anti_lock_braking_system:'');
					$carsafety['Central Locking']		=	((count($getfeatures)>=1)?$getfeatures[0]->central_locking:'');
					$carsafety['Child Safety Lock']		=	((count($getfeatures)>=1)?$getfeatures[0]->child_safety_lock:'');
					$carsafety['Driver Airbags']		=	((count($getfeatures)>=1)?$getfeatures[0]->driver_airbags:'');
					$carsafety['Passenger Airbag']		=	((count($getfeatures)>=1)?$getfeatures[0]->passenger_airbag:'');
					$carsafety['Rear Seat Belts']		=	((count($getfeatures)>=1)?$getfeatures[0]->rear_seat_belts:'');
					$carsafety['Seat Belt Warning']		=	((count($getfeatures)>=1)?$getfeatures[0]->seat_belt_warning:'');
					$carsafety['Adjustable Seats']		=	((count($getfeatures)>=1)?$getfeatures[0]->adjustable_seats:'');
					$carsafety['Crash Sensor']			=	((count($getfeatures)>=1)?$getfeatures[0]->crash_sensor:'');
					$carsafety['Anti Theft Device']		=	((count($getfeatures)>=1)?$getfeatures[0]->anti_theft_device:'');
					$carsafety['Immobilizer']			=	((count($getfeatures)>=1)?$getfeatures[0]->immobilizer:'');
					array_push($carsafetydetails,$carsafety);
          
					//car EXTERIOR details
					$carexterior['Adjustable Head Lights']=	((count($getfeatures)>=1)?$getfeatures[0]->adjustable_head_lights:'');
					$carexterior['Power adjustable exterior rear view mirror']	=	((count($getfeatures)>=1)?$getfeatures[0]->power_adjustable_exterior_rear_view_mirror:'');
					$carexterior['Electric Folding Rear Mirror']	=	((count($getfeatures)>=1)?$getfeatures[0]->electric_folding_rear_view_mirror:'');
					$carexterior['Rain Sensing Wipers']	=	((count($getfeatures)>=1)?$getfeatures[0]->rain_sensing_wipers:'');
					$carexterior['Rear Window Wiper']		=	((count($getfeatures)>=1)?$getfeatures[0]->rear_window_wiper:'');
					$carexterior['Alloy Wheels']			=	((count($getfeatures)>=1)?$getfeatures[0]->alloy_wheels:'');
					$carexterior['Front Fog Lights']		=	((count($getfeatures)>=1)?$getfeatures[0]->front_fog_lights:'');
					$carexterior['Rear window Defogger']	=	((count($getfeatures)>=1)?$getfeatures[0]->rear_window_defogger:'');
					$carexterior['Tinted Glass']			=	((count($getfeatures)>=1)?$getfeatures[0]->tinted_glass:'');
					array_push($carexteriordetails,$carexterior);
					
					//car ENTERTAINMENT details
					$carentertainment['CD Player']		=	((count($getfeatures)>=1)?$getfeatures[0]->cdplayer:'');
					$carentertainment['Radio']			=	((count($getfeatures)>=1)?$getfeatures[0]->radio:'');
					$carentertainment['Audio']			=	((count($getfeatures)>=1)?$getfeatures[0]->audio:'');
					$carentertainment['Bluetooth']		=	((count($getfeatures)>=1)?$getfeatures[0]->bluetooth:'');
					array_push($carentertainmentdetails,$carentertainment);
					
					// CAR DIEMENTION DETAILS
					$cardiemention['Length']			=	((count($getfeatures)>=1)?$getfeatures[0]->length:'');
					$cardiemention['Width']				=	((count($getfeatures)>=1)?$getfeatures[0]->width:'');
					$cardiemention['Height']			=	((count($getfeatures)>=1)?$getfeatures[0]->height:'');
					$cardiemention['Wheel Base']		=	((count($getfeatures)>=1)?$getfeatures[0]->wheel_base:'');
					$cardiemention['Gross Weight']		=	((count($getfeatures)>=1)?$getfeatures[0]->gross_weight:'');
					array_push($cardiementiondetails,$cardiemention);
					//get dealer info 
					if(empty($detailsmongo->branch_id) && $detailsmongo->branch_id == 0)
					{
						$cardealerinfo['Mobile Number']	=	$d_mobile;
						$cardealerinfo['Dealer Address']=	((count($getplace)>=1)?$getplace[0]->city_name:'');
						array_push($cardealerinfodetails,$cardealerinfo);
					}
					else
					{
						$getbranch 						= 	buyymodel::dealerFetchTableDetails($id,
																			$dealer_schemaname,
																			'dms_dealer_branches',
																			array('branch_id'=>$detailsmongo->branch_id)
																			);
						$cardealerinfo['Mobile Number']	=	$d_mobile;
						$cardealerinfo['Dealer Address']=	((count($getbranch)>=1)?$getbranch[0]->branch_address:'');
						array_push($cardealerinfodetails,$cardealerinfo);
					}
					//MESSAGE DEALER INFO
					$cardealermessage['Car Owner Name']		=	$dealer_name;
					$cardealermessage['Car Owner Email']	=	$d_email;
					$cardealermessage['Mobile Number']		=	$d_mobile;
					$getpricingtable 						= 	buyymodel::dealerFetchTableDetails($id,
																			$dealer_schemaname,
																			'dealer_cars_pricing',
																			array('listing_id'=>$car_id)
																			);
					if(!empty($getpricingtable) && count($getpricingtable) >= 1)
					{
						$cardealermessage['testdrive_dealerpoint']	=	((count($getpricingtable)>=1)?$getpricingtable[0]->testdrive_dealerpoint:'');
						$cardealermessage['testdrive_doorstep']		=	((count($getpricingtable)>=1)?$getpricingtable[0]->testdrive_doorstep:'');
					}
					else
					{
						$cardealermessage['testdrive_dealerpoint']	=	"No";
						$cardealermessage['testdrive_doorstep']		=	"No";
					}

					array_push($cardealermessagedetails,$cardealermessage);
					$fundingdetails =	array('result'=>0,'fundingticketid'=>'');
					$successresult 	=	array('Result'=>'1',
											'message'=>'success',
											'carimagesdetails'=>$carimagesdetails,
											'carmodeldetails'=>$getcarmodeldetails,
											'carspecification'=>$carspecificationdetails,
											'carenginedetails'=>$carenginedetails,
											'carinteriordetails'=>$carinteriordetails,
											'carcomportdetails'=>$carcomportdetails,
											'carsafetydetails'=>$carsafetydetails,
											'carexteriordetails'=>$carexteriordetails,
											'carentertainmentdetails'=>$carentertainmentdetails,
											'cardiemention'=>$cardiementiondetails,
											'dealerinfo'=>$cardealerinfodetails,
											'dealermessage'=>$cardealermessagedetails,
											'fundingdetails'=>[$fundingdetails],
											'currentdealerdetails'=>[$currentdealer],
											'reportingdetails'=>$reportingdetails);
					return $successresult;
				}
			}
			return "No Records Found";
		}
	}
	public function doApisharelisting()
    {
		$id 		= 	Input::get('session_user_id');
		$car_id 	= 	Input::get('car_id');
		$mailto 	= 	Input::get('mailto');
		$mailfrom 	= 	Input::get('mailfrom');
		$comments 	= 	Input::get('comments');
		if($id 	==	"" || $car_id ==	"" || $mailto == "" || $mailfrom == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'All fields are required!!'
									]);
		}
		$schemanamedealer 			=	$this->getschemaname($id);
		if(!empty($schemanamedealer))
		{
			$listing_wherecondition 	= 	array();
			$listing_orwherecondition 	=	array();
			$listing_wherecondition['listing_id'] 	= 	array($car_id);
			$mongo_carlisting_details   = 	buyymodel::mongoListingFetchwithqueries($id,
																			$listing_wherecondition,
																			$listing_orwherecondition
																			); 
																			
			if(!empty($mongo_carlisting_details) && count($mongo_carlisting_details) >= 1)
			{
				$listing_link      		= 	url('guestlistingpage/'.$car_id);
				$shorturl           	= 	shortnerurl::shorturl($listing_link);
				foreach ($mongo_carlisting_details as $key) 
				{
					$make             	= 	$key['make'];
					$sell_price       	= 	$key['sell_price'];
					$variant          	= 	$key['variant'];
					$model            	= 	$key['model'];
					$registration_year	= 	$key['registration_year'];
					$car_locality     	= 	$key['car_locality'];
					$created_date     	= 	$key['created_at'];
					$listing_status   	= 	$key['listing_status'];            
					$kilometer_run    	= 	$key['kilometer_run'];
					$owner_type    		= 	$key['owner_type'];
					$body_type    		= 	$key['body_type'];
					$sell_price    		= 	$key['sell_price'];
					$photos_array     	= 	array();
					if(count($key["photos"])>0)
					{
						foreach ($key["photos"] as $photokey => $photovalue) {
							$photos_array[] 	= 	$photovalue['s3_bucket_path'];
						}
						$imagelinks 	= 	$photos_array[0];
					}
					else
					{
						$carnoimage     = 	url(Config::get('common.carnoimage'));
						$imagelinks     = 	$carnoimage;
					}
            
				$daysstmt         		= 	Carbon::parse($key['created_at'])->diffForHumans(); 
				$productinfo 			= 	$model.' '.$variant.' '.$registration_year;
				$productcity 			= 	$car_locality;
				$noofdays 				= 	$daysstmt;
				$kmdone 				= 	$kilometer_run;
				$vehicletype 			= 	$body_type;
				$registrationyear 		= 	$registration_year;
				$noowner 				= 	$owner_type;
				$productprice 			= 	$sell_price;		
				$maildata 				= 	array('',
													$imagelinks,
													$productinfo,
													$productcity,
													$noofdays,
													$kmdone,
													$vehicletype,
													$registrationyear,
													$noowner,
													$productprice,
													$shorturl,
													$comments
													);

				$queries_email_template_id = 	14;
				
				$email_template_data       = 	emailmodel::get_email_templates($queries_email_template_id);      
				foreach ($email_template_data as $row) 
				{
					$mail_subject  			=  	$row->email_subject;
					$mail_message  			=  	$row->email_message;
					$mail_params   			=  	$row->email_parameters; 
				}
				$email_template    			= 	emailmodel::emailContentConstruct($mail_subject,
																					$mail_message,
																					$mail_params,
																					$maildata);
				$email_sent        			= 	emailmodel::email_sending($mailto,$email_template);
			}
			return response()->json(['Result'=>'1',
									'message'=>'Car Details is shared successfully!!'
									]);
			}
			return response()->json(['Result'=>'0',
									'message'=>'Sorry unable to share your listing. Please Try Again Later..!'
									]);
        }
		else
		{
			return response()->json(['Result'=>'0',
									'message'=>'Authentication Error!!'
									]);
		}
    }
	
	public function doApiregisterApplyfundingBuy() 
	{
		$id 			= 	input::get('session_user_id');
		$dealershipname = 	input::get('dealershipname');
		$dealername 	= 	input::get('dealername');
		$emailid 		= 	input::get('emailid');
		$mobilenumber 	= 	input::get('mobilenumber');
		$date 			= 	input::get('date');
		$place 			= 	input::get('place');
		$fundingamount 	= 	input::get('fundingamount');
		$listingid 		= 	input::get('listingid');
		$makename 		= 	input::get('make');
		$modelname 		=	input::get('model_name');
		$variantname 	= 	input::get('variant');
		$ownerid 		= 	input::get('ownerid');
		
		if($id 	==	"" || $dealershipname ==	"" || $dealername == "" || $emailid == "" || $mobilenumber == "" ||
		$date == "" || $place == "" || $fundingamount == "" || $listingid == "" || $makename == "" ||
		$modelname == "" || $variantname == "" || $ownerid == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'All fields are required!!'
									]);
		}
		$schemanamedealer 				=	$this->getschemaname($id);
		if(!empty($schemanamedealer))
		{			
            //CHECK FUNDING TICKET ID IS EXIST OR NOT STRAT
            $fundingticketid    		= 	"";
            $getfundingticketid 		= 	fundingmodel::doGetcardetailsfundingisexist($id, $listingid);

            if (!empty($getfundingticketid) && count($getfundingticketid)) {
                $fundingticketid 		= 	(count($getfundingticketid) >= 1 ? $getfundingticketid[0]->dealer_funding_ticket_id : '');
                $result['result'] 		=   "1";
                $result['message']      =   "Funding Applied Successfully";
                $result['fundticketid'] =   $fundingticketid;
                return response()->json($result);
            }
            
            $getcityname 				= 	fundingmodel::dogetcityidmaster($place);

            $cityid 					= 	((count($getcityname) >= 1) ? $getcityname[0]->city_id : '526');
            $ticketinsert 				= 	array('dealer_ticket_type_id' => 1,
														'dealer_id' => $id,
														'dealer_ticket_status_id' => 1
														);

            //GET DEALER DETAILS
            $dealer_wherecondition 		=	array('d_id' => $id);
            $fetchupdate 				= 	fundingmodel::doGetmasterdetails('dms_dealers',
																	$dealer_wherecondition
																	);
            $dealer_profile_image 		= 	((count($fetchupdate) >= 1) ? $fetchupdate[0]->logo : url(config::get('common.profilenoimage')));
            $from_email 				= 	((count($fetchupdate) >= 1) ? $fetchupdate[0]->d_email : '');

            $dealer_wherecondition 		= 	array('dealer_id' => $id);
            $getdealeraddress 			= 	fundingmodel::dealerFetchTableDetails($schemanamedealer,
																	'dms_dealerdetails', $dealer_wherecondition
																);
            $dealeraddress = ((count($getdealeraddress) >= 1) ? $getdealeraddress[0]->Address : '');

            $insertticketrequesttable 	= 	fundingmodel::doInsertTicketrequest($ticketinsert);
            if ($insertticketrequesttable >= 1) {
                //get last record for unique ticket creation
                $getlastid 				= 	fundingmodel::latest('dealer_funding_detail_id')
													->pluck('dealer_funding_detail_id')->first();
                $maketicketid 			= 	($getlastid >= 1) ? ($getlastid + 1) : $insertticketrequesttable;
                $findingticketid		= 	commonmodel::dodealercode() . '-F' . $maketicketid;
                $insertfundingdata 		=	array('dealer_ticket_id' => $insertticketrequesttable,
														'dealershipname' => $dealershipname,
														'dealername' => $dealername,
														'dealermobileno' => $mobilenumber,
														'dealer_funding_ticket_id' => $findingticketid,
														'dealermailid' => $emailid,
														'city_id' => $cityid,
														'dealercity' => $place,
														'branch_id' => "",
														'branchname' => "",
														'requested_amount' => $fundingamount,
														'created_date' => $date,
														'user_id' => $id
													);
                $insertdealerfundingtable 	= 	fundingmodel::doInsertfundingapplyrequest($insertfundingdata);
                if ($insertdealerfundingtable >= 1) {
						$insertfundingitems 	= 	array(
														'dealer_funding_detail_id' => $insertdealerfundingtable,
														'dealer_car_id' => "",
														'dealer_listing_id' => $listingid,
														'dealer_car_make_name' => $makename,
														'dealer_car_model_name' => $modelname,
														'dealer_car_variant_name' => $variantname,
														'dealer_car_price' => $fundingamount
													);
                    $insertdealerfundingitems 	= 	fundingmodel::doInsertFundingItems($insertfundingitems);
                    if ($insertdealerfundingitems >= 1) {
                        //get make,model,variant
                        $footeremailtemp 	= 	"";
                        $branchid 			= 	"";
                        $branchname 		= 	"";
                        if (!empty($listingid)) {
                            $carid 			= 	collect($listingid);
                            $getownerdetail =	 fundingmodel::doGetmasterdetails('dms_dealers', array('d_id' => $ownerid)
                            );
                            $dealerschemacon 	= 	((count($getownerdetail) >= 1) ? $getownerdetail[0]->dealer_schema_name : '');
                            $getmakemodel 		= 	fundingmodel::dealergetTodealerTable($dealerschemacon, $carid
                            );
                            if (!empty($getmakemodel) && count($getmakemodel) >= 1) {
                                $i = 1;
                                foreach ($getmakemodel as $value) {
                                    $imagefetch = 	fundingmodel::dealergetTodealerphotosTable($dealerschemacon,array('car_id' => $value->car_id)
                                    );
                                    $carimage 	= 	((count($imagefetch) >= 1) ? $imagefetch[0]->s3_bucket_path : url(config::get('common.carnoimage')));
                                    $branchid 	= 	$value->branch_id;
                                    switch ($value->owner_type) {
                                        case 'FIRST':
                                            $owner_type = "1";
                                            break;
                                        case 'SECOND':
                                            $owner_type = "2";
                                            break;
                                        case 'THIRD':
                                            $owner_type = "3";
                                            break;
                                        case 'Fourth':
                                            $owner_type = "4";
                                            break;
                                        case 'Four +':
                                            $owner_type = "Above 4";
                                            break;
                                        default:
										$owner_type = "1";
										break;
                                    }
                                    $footeremailtemp .= '<tr><td>' . $i . '</td><td><img src="' . $carimage . '" alt="" class="img-responsive table-img"></td><td><p><b>' . $modelname . ' ' . $variantname . ' ' . $value->registration_year . '</b></p><p>Rs.' . $fundingamount . '</p><p class="list-detail"><span class="text-muted">' . $value->kms_done . ' km</span> | <span class="text-muted">' . $value->fuel_type . '</span> | <span class="text-muted">' . $value->registration_year . '</span> | <span class="text-muted">' . $owner_type . ' Owner</span></p></td></tr>';
                                    $i++;
                                }
                                //getbranchname	
                                $getbranchname 	= 	fundingmodel::dealerFetchbranchname($schemanamedealer, $branchid);
                                $branchname 	= 	((count($getbranchname) >= 1) ? $getbranchname[0]->dealer_name : '');
                            }
                        }
                        $footeremailtemp .= '</tbody></table></div></div>';
                        //Mail Send Start
                        $maildata = array('0' => $findingticketid,
                            '1' => 'In Progress',
                            '2' => $dealer_profile_image,
                            '3' => $dealername,
                            '4' => $dealername,
                            '5' => $branchname,
                            '6' => $mobilenumber,
                            '7' => $dealeraddress
                        );

                        $queries_email_template_id 	=	config::get('common.funding_email_template_id');
                        $email_template_data 		= 	emailmodel::get_email_templates($queries_email_template_id);

                        foreach ($email_template_data as $row) {
                            $mail_subject 	= 	$row->email_subject;
                            $mail_message 	= 	$row->email_message;
                            $mail_params 	= 	$row->email_parameters;
                        }
                        $email_template 	= 	emailmodel::emailContentConstructLoan($mail_subject, $mail_message, $mail_params, $maildata, $footeremailtemp);
                        $email_sent 		= 	emailmodel::email_sending($from_email, $email_template);
                        //$email_sent     	= 	emailmodel::email_sending_cc($from_email,$email_template,$ownermail);
                        $dealer_info 		= 	dealermodel::dealerprofile($id);
                        $getownerinfo 		= 	dealermodel::dealerprofile($ownerid);
                        $ownername 			=	(count($getownerinfo)>=1?$getownerinfo->dealer_name:'');
                        $ownermail 			=	(count($getownerinfo)>=1?$getownerinfo->d_email:'');
                        $maildata 			= 	array($ownername,
														$listingid,
														$emailid,
														$mobilenumber
													);
                        $email_template_data 	= 	emailmodel::get_email_templates(config::get('common.funding_request'));
                        foreach ($email_template_data as $row) 
                        {
                            $mail_subject 	= 	$row->email_subject;
                            $mail_message 	= 	$row->email_message;
                            $mail_params 	= 	$row->email_parameters;
                        }                        
                        $email_template 	= 	emailmodel::emailContentConstruct(
																			$mail_subject, 
																			$mail_message, 
																			$mail_params, 
																			$maildata
																			);
                        $email_sent 		= 	emailmodel::email_sending($ownermail,$email_template);
                        
                        $result['result']      	=   "1";
                        $result['message']      =   "Funding Applied Successfully";
                        $result['fundticketid'] =   $findingticketid;
                        return response()->json($result);
                    } else {
						$result['result']      	=   "0";
                        $result['message']		= 	"Unable to apply Funding Please Try Again Later...";
                        return response()->json($result);
                    }
                }
            }
		}
		return response()->json(['Result'=>'0',
									'message'=>'Invalid access'
									]);
    }
	
	public function doApiajaxcontactdealermessage()
    {
        $id 						= 	Input::get('session_user_id');
        $dealer_id 					= 	Input::get('dealer_id'); 
		$modelvariant				=	Input::get('make_model_variant');
		$car_dealerid				=	Input::get('car_id');
		$dealer_name				=	Input::get('contact_dealer_name');
		$dealer_email				=	Input::get('contact_dealer_mailid');
		$message					=	Input::get('contact_dealer_message');
		if($id 	==	"" || $dealer_id ==	"" || $modelvariant == "" || $car_dealerid == "" || $dealer_name == "" || $dealer_email == "" || $message == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'All fields are required!!'
									]);
		}
		//CHECK MAIL IS ALREADY SENT OR NOT START
		$schemanamedealer 			=	$this->getschemaname($id);
		if(!empty($schemanamedealer))
		{
			$where 					=	array('user_id'=>$id,'car_id'=>$car_dealerid);
			$checkmail 				= 	buyymodel::dealerFetchTableDetails($id,
																		$schemanamedealer,
																		$this->dealermessageTable,
																		$where);
			if(!empty($checkmail) && count($checkmail) >=1 )
			{
				return response()->json(['Result'=>'1',
									'message'=>'Message has been sent to the Dealer!!'
									]);
			}
		
		
		//CHECK MAIL IS ALREADY SENT OR NOT  END
        $queries_contact_title    	= 	Config::get('common.queries_contact_title');
        $currentdate            	= 	Carbon::now();
        $contact_transactioncode	= 	$currentdate->format('Ymdhis');
        $dealer_wherecondition    	= 	array('d_id'=>$id);
        $fetchupdate 				= 	buyymodel::masterFetchTableDetails($id,$this->masterMainLoginTable,$dealer_wherecondition);
		
        if(!empty($fetchupdate) && count($fetchupdate) >= 1)
        {
			$dealer_schemaname		= 	$fetchupdate[0]->dealer_schema_name; 
			$fromdealer_name        = 	$fetchupdate[0]->dealer_name;
			$from_email             = 	$fetchupdate[0]->d_email;
			$from_mobileno          = 	$fetchupdate[0]->d_mobile;
			$dealer_profile_image   = 	$fetchupdate[0]->logo;
		}
		else
		{
			return response()->json(['Result'=>'0',
									'message'=>'Authentication error!!'
									]);
		}
        $to_dealer_wherecondition 	= 	array('d_id'=>$dealer_id);
        $to_dealer_id_fetch 		= 	buyymodel::masterFetchTableDetails($id,$this->masterMainLoginTable,$to_dealer_wherecondition);        
        
        if(!empty($to_dealer_id_fetch) && count($to_dealer_id_fetch) >= 1)
        {
			$to_dealer_name				= 	$to_dealer_id_fetch[0]->dealer_name;
			$to_dealer_email 			= 	$to_dealer_id_fetch[0]->d_email;
			$to_dealer_mobile 			= 	$to_dealer_id_fetch[0]->d_mobile;
			$to_dealer_schema_name 		= 	$to_dealer_id_fetch[0]->dealer_schema_name;
			$todealer_profile_image   	= 	$to_dealer_id_fetch[0]->logo;
		}
		else
		{
			return response()->json(['Result'=>'0',
									'message'=>'Authentication error!!'
									]);
		}
        $data 		= 	array('from_dealer_id'		=>	$id,
						  'contact_transactioncode'	=>	$contact_transactioncode,
						  'to_dealer_id'			=>	$dealer_id,
						  'mobile'					=>	$from_mobileno,
						  'car_id'					=>	$car_dealerid,
						  'dealer_name'				=>	$dealer_name,
						  'dealer_email'			=>	$dealer_email,
						  'message'					=>	$message,
						  'title'					=>	$queries_contact_title,
						  'delear_datetime'			=>	date('Y-m-d H:i:s'),
						  'user_id'=>$id,
                      );
        
		$todata 	= 	array('from_dealer_id'		=>	$id,
						  'contact_transactioncode'	=>	$contact_transactioncode,
						  'to_dealer_id'			=>	$dealer_id,
						  'mobile'					=>	$from_mobileno,
						  'car_id'					=>	$car_dealerid,
						  'dealer_name'				=>	$dealer_name,
						  'dealer_email'			=>	$dealer_email,
						  'message'					=>	$message,
						  'title'					=>	$queries_contact_title,
						  'delear_datetime'			=>	date('Y-m-d H:i:s'),
						  'user_id'					=>	$id,
						  'status'					=>	1
                      );
													
        $theard_id                = 	buyymodel::dealerInsertTable($id,$dealer_schemaname,$this->dealermessageTable,$data);
        $last_theard_id           = 	buyymodel::dealerInsertToTable($id,$to_dealer_schema_name,$this->dealermessageTable,$todata);

		$queries_notification_type_id 	= 	config::get('common.receive_queries_notification_type_id');
        $notification_type         		= 	notificationsmodel::get_notification_dealer_type($queries_notification_type_id);
        $dealer_notification       		= 	array( 'user_id'=>$id,
                                            'd_id'=>$dealer_id,
                                            'notification_type_id'=>$queries_notification_type_id,
                                            'title'=>$modelvariant,
                                            'notification_type'=>($notification_type == ""?'':$notification_type[0]->notification_type_name),
                                            'message'=>$message,        
                                            'status'=>1,
                                            'contact_transactioncode'=>$contact_transactioncode);
        notificationsmodel::dealer_notification_insert($to_dealer_schema_name,$dealer_notification);

        $maildata                   = array('0'=>$todealer_profile_image,
                                            '1'=>$to_dealer_name,
                                            '2'=>$fromdealer_name,
                                            '3'=>$dealer_profile_image,
                                            '4'=>$message
                                            );
        $queries_email_template_id =    config::get('common.queries_email_template_id');
        $email_template_data       =    emailmodel::get_email_templates($queries_email_template_id);

        foreach ($email_template_data as $row) 
        {
          $mail_subject  	=  $row->email_subject;
          $mail_message  	=  $row->email_message;
          $mail_params   	=  $row->email_parameters; 
        }

        $send_email        	= 	$to_dealer_email;
        $email_template    	= 	emailmodel::emailContentConstruct($mail_subject,$mail_message,$mail_params,$maildata);
        $email_sent        	= 	emailmodel::email_sending($send_email,$email_template);
        //Mail End
        //Sms Queries Start
        $phone              = 	$to_dealer_mobile;
        $smsdata            = 	array($to_dealer_name,$fromdealer_name);
        $queries_sms_id     = 	Config::get('common.queries_sms_id');
        $sms_template_data  = 	smsmodel::get_sms_templates($queries_sms_id);

        $sms_template       = 	smsmodel::smsContentConstruct($sms_template_data[0]->sms_subject,$sms_template_data[0]->sms_message,$sms_template_data[0]->sms_parameters,$smsdata);

        $sms_data           = 	array('sms_template_data'=>$sms_template,
                                  'phone'=>$phone);
        $sms_sent           = 	smsmodel::sendsmsarray($sms_data);
        //End SMS
        return response()->json(['Result'=>'1',
									'message'=>'Message Sent Successfully. Please visit My Queries.'
									]);
		}
		else
		{
			return response()->json(['Result'=>'0',
									'message'=>'Invalid access'
									]);
		}
    }
    
    public function doApitestdriveupdate()
    {
		$id 						= 	Input::get('session_user_id');
        $dealer_id 					= 	Input::get('dealer_id'); 
		$modelvariant				=	Input::get('make_model_variant');
		$car_dealerid				=	Input::get('car_id');
		$message					=	Input::get('contact_dealer_message');
		$test_drive 				=	Input::get('test_drive');
		if($id 	==	"" || $dealer_id ==	"" || $modelvariant == "" || $car_dealerid == "" || $test_drive == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'All fields are required!!'
									]);
		}
		//CHECK TEST DRIVE
		$schemanamedealer 			=	$this->getschemaname($id);
		if(!empty($schemanamedealer))
		{
			$where 					=	array('user_id'=>$id,'car_id'=>$car_dealerid);
			$checkmail 				= 	buyymodel::dealerFetchTableDetails($id,
																		$schemanamedealer,
																		$this->dealermessageTable,
																		$where);
			if(!empty($checkmail) && count($checkmail) >=1 )
			{
				return response()->json(['Result'=>'1',
									'message'=>'Test Drive is already has been sent!!'
									]);
			}
			else
			{
				$queries_testdrive_title  	= 	Config::get('common.queries_testdrive_title');
				$currentdate              	= 	Carbon::now();
				$contact_transactioncode  	= 	$currentdate->format('Ymdhis');
				$dealer_wherecondition    	= 	array('d_id'=>$id);
				$from_mobileno 				=	"";
				$from_email 				=	"";
				$fromdealer_name 			=	"";
				$dealer_schemaname 			=	"";
				$dealer_profile_image 		=	"";
				$to_dealer_mobile 			=	"";
				$to_dealer_name 			=	"";
				$to_dealer_email 			=	"";
				$to_dealer_schema_name 		=	"";
				$to_dealer_profile_image 	=	"";
				$fetchupdate              	= 	buyymodel::masterFetchTableDetails($id,$this->masterMainLoginTable,$dealer_wherecondition);
				if(!empty($fetchupdate) && count($fetchupdate) >= 1)
				{
					$dealer_schemaname      = 	$fetchupdate[0]->dealer_schema_name; 
					$fromdealer_name        = 	$fetchupdate[0]->dealer_name;
					$from_email             = 	$fetchupdate[0]->d_email;
					$from_mobileno          = 	$fetchupdate[0]->d_mobile;
					$dealer_profile_image   = 	$fetchupdate[0]->logo;
				}
				else
				{
					return response()->json(['Result'=>'0',
											'message'=>'Failure!!'
											]);
				}
				
				$to_dealer_wherecondition 		= 	array('d_id'=>$dealer_id);
				$to_dealer_id_fetch       		= 	buyymodel::masterFetchTableDetails($id,$this->masterMainLoginTable,$to_dealer_wherecondition);
				if(!empty($to_dealer_id_fetch) && count($to_dealer_id_fetch) >= 1)
				{
					$to_dealer_name           	= 	$to_dealer_id_fetch[0]->dealer_name;
					$to_dealer_email          	= 	$to_dealer_id_fetch[0]->d_email;
					$to_dealer_mobile         	= 	$to_dealer_id_fetch[0]->d_mobile;
					$to_dealer_schema_name    	= 	$to_dealer_id_fetch[0]->dealer_schema_name;
					$to_dealer_profile_image   	= 	$to_dealer_id_fetch[0]->logo;
				}
				else
				{
					return response()->json(['Result'=>'0',
											'message'=>'Failure!!'
											]);
				}
				$data                     	= 	array('from_dealer_id'=>$id,
															'contact_transactioncode'=>$contact_transactioncode,
															'to_dealer_id'=>$dealer_id,
															'mobile'=>$from_mobileno,
															'car_id'=>$car_dealerid,
															'dealer_name'=>$fromdealer_name,
															'dealer_email'=>$from_email,
															'message'=>$message,
															'title'=>$queries_testdrive_title,
															'delear_datetime'=>date('Y-m-d H:i:s'),
															'user_id'=>$id,
															);

				$testdrive_data         	= 	array('listing_dealer_id'=>$dealer_id,
													  'car_id'=>$car_dealerid,
													  'test_drive'=>$test_drive,
													  'title'=>$modelvariant,
													  'user_id'=>$id,
													  );
				$testdrivetable          	= 	'dealer_testdrive';          
				$theard_id               	= 	buyymodel::dealerInsertTable($id,$dealer_schemaname,$this->dealermessageTable,$data);

				buyymodel::dealerInsertTable($id,$dealer_schemaname,$testdrivetable,$testdrive_data);
				
				$data['status']				=	1;				
				$last_theard_id          	= 	buyymodel::dealerInsertToTable($id,
																				$to_dealer_schema_name,
																				$this->dealermessageTable,$data);
				
				buyymodel::dealerInsertToTable($id,$to_dealer_schema_name,$testdrivetable,$testdrive_data);

				$queries_notification_type_id 	= 	config::get('common.receive_queries_notification_type_id');
				$notification_type       		= 	notificationsmodel::get_notification_dealer_type($queries_notification_type_id);
				$notification_message 			= 	'Test drive-' . ' '.$fromdealer_name.' '.$modelvariant. ' ' .$message;
				$dealer_notification     		= 	array( 'user_id'=>$id,
														'd_id'=>$dealer_id,
														'notification_type_id'=>$queries_notification_type_id,
														'title'=>$modelvariant,
														'notification_type'=>$notification_type[0]->notification_type_name,
														'message'=>$message,        
														'status'=>1
													);
				notificationsmodel::dealer_notification_insert($to_dealer_schema_name,$dealer_notification);

				$maildata                		= 	array('0'=>$to_dealer_profile_image,
														  '1'=>$to_dealer_name,
														  '2'=>$fromdealer_name,
														  '3'=>$dealer_profile_image,
														  '4'=>$message
														  );
				$queries_email_template_id		=   config::get('common.queries_email_template_id');
				$email_template_data      		=   emailmodel::get_email_templates($queries_email_template_id);

				foreach ($email_template_data as $row) 
				{
				$mail_subject  =  $row->email_subject;
				$mail_message  =  $row->email_message;
				$mail_params   =  $row->email_parameters; 
				}

				$send_email              = 	$to_dealer_email;
				$email_template          = 	emailmodel::emailContentConstruct($mail_subject,$mail_message,$mail_params,$maildata);
				$email_sent              = 	emailmodel::email_sending($send_email,$email_template);
				//Mail End
				//Sms Queries Start
				$phone                   = 	$to_dealer_mobile;
				$queries_sms_id          = 	Config::get('common.queries_sms_id');
				$sms_template_data       = 	smsmodel::get_sms_templates($queries_sms_id);
				$sms_data                = 	array('sms_template_data'=>$sms_template_data,
													'phone'=>$phone
													);
				$sms_sent                = 	smsmodel::sendsms($sms_data); 
				//End SMS
				return response()->json(['Result'=>'1',
											'message'=>'Successfully Applied For Test Drive. Please visit My Queries.'
											]);
			}
		}
		else
		{
			return response()->json(['Result'=>'0',
									'message'=>'Authentication Error!!'
									]);
		}
    }
    
    //SHOW ALERT HISTORY IN BUY MOBILE MODULE
    public function doApiAlertShowHistory()
	{
		$id 			= 	Input::get('session_user_id');
        if($id == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'User id is required!!'
									]);
		}
		$alertdetails	=	array();
		$schemaname 	=  $this->getschemaname($id);
		if(!empty($schemaname))
		{
			$alertlistData         	=     alertmodel::fetchAllAlert($id);
			if(!empty($alertlistData) && count($alertlistData) >= 1)
			{
				foreach ($alertlistData as $value)
				{
					$dealername 					=  	$this->getschemausername($value->alert_source_dealer_id);
					$alertdata['alertid']			=	$value->alertid;
					$alertdata['dealername']		=	($dealername != ""?$dealername:"All");
					$alertdata['alert_type']		=	($value->alert_type == null ? '':$value->alert_type);
					$alertdata['alert_listingid']	=	$value->alert_listingid;
					$alertdata['alert_date']		=	$value->alert_date;
					$alertdata['alert_city']		=	$value->alert_city;
					$alertdata['alert_product']		=	$value->alert_model.' '.$value->alert_variant;
					$alertdata['alert_usermailid']	=	$value->alert_usermailid;
					$alertdata['alert_mobileno']	=	$value->alert_mobileno;
					$alertdata['alert_status']		=	$value->alert_status;
					$alertdata['alert_email_status']=	$value->alert_email_status;
					$alertdata['alert_sms_status']	=	$value->alert_sms_status;
					array_push($alertdetails,$alertdata);
				}
			}
			return response()->json(['Result'=>'1',
									'message'=>'success',
									'alert_history'=>$alertdetails
									]);
		}
		else
		{
			return response()->json(['Result'=>'0',
									'message'=>'Invalid Access'
									]);
		}
	}
	//THIS FUNCTION USED FOR REMOVE ALERT HISTORY FROM SCHEMA AND MASTER
	public function doApiAlertRevoke()
    {
        $id 			= 	Input::get('session_user_id');
        $alertid 		=	Input::get('alertid');
        if($id == "" || $alertid == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'User id and Alert id is required!!'
									]);
		}
		$schemaname 	=  $this->getschemaname($id);
		if(!empty($schemaname))
		{	
			$alerttype			=	"";
			$alert_listingid	=	"";
			$alert_user_id		=	"";
			$alertdetails		=	array();
			$getalertid			= 	alertmodel::dofetchAlertid($alertid);
			if(!empty($getalertid) && count($getalertid))
			{
				foreach($getalertid as $value)
				{
					$alerttype			=	$value->alert_type;
					$alert_listingid	=	$value->alert_listingid;
					$alert_user_id		=	$value->alert_user_id;
				}				
				$wherealert		=	array('alert_type'=>$alerttype,
											'alert_listingid'=>$alert_listingid,
											'alert_user_id'=>$alert_user_id
											);
				$updatefetch        = 	alertmodel::doAlertdeleteschema($schemaname,$wherealert);
				
				/*if($updatefetch 	>= 	1)
				{*/
					$deletefetch        = 	alertmodel::delAlert($alertid);
					$alertlistData      =   alertmodel::fetchAllAlert($id);
					if(!empty($alertlistData) && count($alertlistData) >= 1)
					{
						foreach ($alertlistData as $value)
						{
							$dealername 					=  	$this->getschemausername($value->alert_source_dealer_id);
							$alertdata['alertid']			=	$value->alertid;
							$alertdata['dealername']		=	($dealername != ""?$dealername:"All");
							$alertdata['alert_type']		=	($value->alert_type == null ? '':$value->alert_type);
							$alertdata['alert_listingid']	=	$value->alert_listingid;
							$alertdata['alert_date']		=	commonmodel::getdatemonthformat($value->alert_date);
							$alertdata['alert_city']		=	$value->alert_city;
							$alertdata['alert_product']		=	$value->alert_model.' '.$value->alert_variant;
							$alertdata['alert_usermailid']	=	$value->alert_usermailid;
							$alertdata['alert_mobileno']	=	$value->alert_mobileno;
							$alertdata['alert_status']		=	$value->alert_status;
							$alertdata['alert_email_status']=	$value->alert_email_status;
							$alertdata['alert_sms_status']	=	$value->alert_sms_status;
							array_push($alertdetails,$alertdata);
						}
					}
					return response()->json(['Result'=>'1',
											'message'=>'success',
											'alert_history'=>$alertdetails
											]);
				/*}
				else
				{
						return response()->json(['Result'=>'0',
												'message'=>'failure'
												]);
				}	*/						
			}
			return response()->json(['Result'=>'0',
										'message'=>'failure'
										]);
		}
			return response()->json(['Result'=>'0',
										'message'=>'failure'
										]);
    }
    //THIS FUNCTION USED FOR UPDATE STATUS FOR ALERT,EMAIL AND SMS
    public function doApiAlertStatusRevoke()
    {
        $id 			= 	Input::get('session_user_id');
        $alertid 		=	Input::get('alertid');
        $alertstatus 	=	Input::get('alertstatus');
        if($id == "" || $alertid == "" || $alertstatus	==	"")
        {
			return response()->json(['Result'=>'0',
									'message'=>'All fields are required!!'
									]);
		}
		$schemaname 	=  $this->getschemaname($id);
		if(!empty($schemaname))
		{	
			switch($alertstatus)
			{
				case 0:
				$field 			=	'alert_status';
				break;
				case 1:
				$field 			=	'alert_email_status';
				break;
				case 2:
				$field 			=	'alert_sms_status';
				break;
			}
			$alerttype			=	"";
			$alert_listingid	=	"";
			$alert_user_id		=	"";
			$getalertid			= 	alertmodel::dofetchAlertid($alertid);
			if(!empty($getalertid) && count($getalertid))
			{
				foreach($getalertid as $value)
				{
					$alerttype			=	$value->alert_type;
					$alert_listingid	=	$value->alert_listingid;
					$alert_user_id		=	$value->alert_user_id;
				}	
				$wherealert				=	array('alert_type'=>$alerttype,
											'alert_listingid'=>$alert_listingid,
											'alert_user_id'=>$alert_user_id
											);
				$getfetchdata        	= 	alertmodel::dofetchAlertstatusSchema($schemaname,$wherealert,$field);
				$getstatusvalue			=	((count($getfetchdata)>=1)?$getfetchdata->$field:'0');
				if($getstatusvalue	==	0)
				{
					$updatedata			=	array($field=>1);
					$updatefetch        = 	alertmodel::doUpdateAlertstatusSchema($schemaname,$wherealert,$updatedata);
					$message			=	"Added Successfully";
					if($updatefetch >= 1)
					{
						$updatemaster   = 	alertmodel::doUpdateAlertstatus($alertid,$updatedata);
					}
				}
				else
				{
					$updatedata			=	array($field=>0);
					$updatefetch        = 	alertmodel::doUpdateAlertstatusSchema($schemaname,$wherealert,$updatedata);
					$message			=	"Removed Successfully";
					if($updatefetch >= 1)
					{
						$updatemaster   = 	alertmodel::doUpdateAlertstatus($alertid,$updatedata);
					}
				}
				if($updatemaster 	>= 	1)
				{
						return response()->json(['Result'=>'6',
												'message'=>$message
												]);
				}
				else
				{
						return response()->json(['Result'=>'0',
												'message'=>'failure'
												]);
				}							
			}
			return response()->json(['Result'=>'0',
										'message'=>'failure'
										]);
		}
			return response()->json(['Result'=>'0',
										'message'=>'failure'
										]);
    }
    
    //SHOW ALERT IN BUY MOBILE MODULE
    public function doApiAlertShowTopPage()
	{
		$id 			= 	Input::get('session_user_id');
        if($id == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'User id is required!!'
									]);
		}
		$alertdetails	=	array();
		$schemaname 	=  $this->getschemaname($id);
		if(!empty($schemaname))
		{
			$alertlistData			=	alertmodel::fetchAlertNotifyList($schemaname,$id);
			if(!empty($alertlistData) && count($alertlistData) >= 1)
			{
				foreach ($alertlistData as $value)
				{
					$alertdata['alert_title']		=	($value['alert_title'] == null ? '':$value['alert_title']);
					$alertdata['alert_type']		=	($value['alert_type'] == null ? '':$value['alert_type']);
					$alertdata['alert_listingid']	=	($value['alert_listingid'] == null ? '':$value['alert_listingid']);
					array_push($alertdetails,$alertdata);
				}
			}
			return response()->json(['Result'=>'1',
									'message'=>'success',
									'alert_history'=>$alertdetails
									]);
		}
		else
		{
			return response()->json(['Result'=>'0',
									'message'=>'Invalid Access'
									]);
		}	
	}
	
	public function doApireportlisting() 
	{
		$id 							= 	Input::get('session_user_id');
        $car_id 						=	Input::get('carid');
        $report_listing_type_type_id 	=	Input::get('report_listing_type_type_id');
        $reported_dealer_id 			= 	Input::get('dealer_id');
        if($id == "" || $car_id == "" || $report_listing_type_type_id	==	"" || $reported_dealer_id == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'All fields are required!!'
									]);
		}
		$schemaname 	=  $this->getschemaname($id);
		if(!empty($schemaname))
		{	
			$dealer_saved_cars_tablename 	= 	'dealer_reported_listings';
			$saveddata 						= 	array('dealer_listing_id' => $car_id, 
														'dealer_id' => $id, 
														'reported_dealer_id' => $reported_dealer_id
													);
			$saved_dealer_car 				= 	buyymodel::masterFetchTableDetails($id,
															$dealer_saved_cars_tablename, 
															$saveddata
															);
			$insertrecord 					=	array('dealer_id' => $id,
													'dealer_listing_id' => $car_id,
													'report_listing_type_type_id' => $report_listing_type_type_id,
													'reported_dealer_id' => $reported_dealer_id
													);
			switch($report_listing_type_type_id)
			{
				case 1:
				$reportListingType = "Car Not Available";
				break;
				case 2:
				$reportListingType = "Inaccurate Price";
				break;
				case 3:
				$reportListingType = "Scam";
				break;
				case 4:
				$reportListingType = "Car Not Available";
				break;
			}
			//get car model make from mongo
			$returncar 			= 	mongomodel::where('listing_id',$car_id)->get();
			$dealerDetails 		= 	dealermodel::dealerfetch($reported_dealer_id);
			$reportedDealerName = 	(count($dealerDetails)>=1?$dealerDetails[0]->dealer_name:'');
			$reportedEmail 		= 	(count($dealerDetails)>=1?$dealerDetails[0]->d_email:'');
			//Mail Send Start
			$maildata 			= array(  '0' => $reportedDealerName,
										'1' => $car_id,
										'2' => $reportListingType,
										'3' => (count($returncar)>=1?$returncar[0]->model:''),
										'4' => (count($returncar)>=1?$returncar[0]->variant:''),
										'5' => (count($returncar)>=1?$returncar[0]->registration_year:'')
										);
			$email_template_data 	= 	emailmodel::get_email_templates(config::get('common.listingreport_email_id'));
			
			if(count($email_template_data) >= 1)
			{
				foreach ($email_template_data as $row) 
				{
					$mail_subject 	= 	$row->email_subject;
					$mail_message 	= 	$row->email_message;
					$mail_params 	= 	$row->email_parameters;
				}
				$email_template 	= 	emailmodel::emailContentConstruct($mail_subject, 
																			$mail_message, 
																			$mail_params, 
																			$maildata
																			);
                $email_sent 		= 	emailmodel::email_sending($reportedEmail, $email_template);
			}	
			if (count($saved_dealer_car) >= 1)
			{
				$saved_dealer_car_status = buyymodel::masterupdateDetail($dealer_saved_cars_tablename,
																			$saveddata,
																			$insertrecord
																		);
				
				return response()->json(['Result'=>'1',
									'message'=>'success',
									'reporting'=>'Report Added Successfully'
									]);
			}else{
				buyymodel::masterInsertTable($id, $dealer_saved_cars_tablename, $insertrecord);
				return response()->json(['Result'=>'1',
									'message'=>'success',
									'reporting'=>'Report Added Successfully'
									]);
			}
		}
        else
		{
			return response()->json(['Result'=>'0',
									'message'=>'Invalid Access'
									]);
		}	
    }
	
	//SHOW ALERT IN BUY MOBILE MODULE
    public function doApiNotificationShowTopPage()
	{
		$id 			= 	Input::get('session_user_id');
        if($id == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'User id is required!!'
									]);
		}
		$alertdetails	=	array();
		$schemaname 	=  $this->getschemaname($id);
		if(!empty($schemaname))
		{
			$alertlistData			=	notificationsmodel::getDealerNotification($schemaname,$id);
			if(!empty($alertlistData) && count($alertlistData) >= 1)
			{
				foreach ($alertlistData as $value)
				{
					$alertdata['title']				=	($value['title'] == null ? '':$value['title']);
					$alertdata['notification_type']	=	($value['notification_type'] == null ? '':$value['notification_type']);
					$alertdata['message']			=	($value['message'] == null ? '':$value['message']);
					//$alertdata['contact_transactioncode']	=	($value['contact_transactioncode'] == null ? '':$value['contact_transactioncode']);
					$alertdata['created_at']		=	commonmodel::getdatemonthformat($value['created_at']);
					array_push($alertdetails,$alertdata);
				}
			}
			return response()->json(['Result'=>'1',
									'message'=>'success',
									'notification_history'=>$alertdetails
									]);
		}
		else
		{
			return response()->json(['Result'=>'0',
									'message'=>'Invalid Access'
									]);
		}	
	}
    
     //GET SCHEMA NAME FUNCTION
    public function getschemaname($id)
    {
		$getdealer_schemaname 	  		=	buyymodel::masterFetchTableDetails('',
																		$this->masterMainLoginTable,
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
	//GET SCHEMA USER NAME FUNCTION
    public function getschemausername($id)
    {
		$getdealer_schemaname 	  		=	buyymodel::masterFetchTableDetails('',
																		$this->masterMainLoginTable,
																		array('d_id'=>$id)
																		);
			$dealer_schemaname			= 	"";
			if(!empty($getdealer_schemaname) && count($getdealer_schemaname) > 0)
			{															
				foreach($getdealer_schemaname as $dealernameselect)
				{
					$dealer_schemaname	= 	$dealernameselect->dealer_name;
				}
				return $dealer_schemaname;
			}
			else
			{
				return false;
			}
	}
}
