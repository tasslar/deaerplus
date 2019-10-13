<?php
/* 
    Module Name : SELL API   
    Created By  : vinoth 09-01-2017  
    This Api controller is using in sell page for apply loan and etc
*/
namespace App\Http\Controllers\api;
use App\Http\Requests;
use App\Http\registervalidation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\buyymodel;
use App\model\contactsmodel;
use App\model\common;
use App\model\schemamodel;
use App\model\shortnerurl;
use App\model\ibb;
use App\model\fastlane;
use App\model\fileuploadmodel;
use App\model\inventorymodel;
use App\model\dealermodel;
use App\model\commonmodel;
use Illuminate\Support\Facades\Input;
use App\model\mongomodel;
use App\model\fastlanemongo;
use DB;
use Illuminate\Http\File;
use Config;
use Carbon\Carbon;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
//DEFINE CLASS NAME
class sell extends Controller
{
	public $masterBudgetVariantTable;
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
	public $dealercustomerloanTable;
	public $DmsCarListTable;
	public $mongopushstatus;
	public $priceField;
	public $ascendingField;
    public $descendingField;
    public $DuplicateMainId;
    public $DmsCarStatus;
    public $DmsCarListPhotosTable;
    public $MasterVariantTable;
    public $DmsCarListVideosTable;
    public $DmsCarListDocumentTable;
	//CONSTRUCT METHOD
	public function __construct(Request $request)
    {				
        $this->masterBudgetVariantTable 	= 	"master_budget_varient";
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
		$this->dealercustomerloanTable		=	"dealer_customerloan_details";
		$this->DmsCarListTable          	= 	"dms_car_listings";
		$this->mongopushstatus            	= 	"mongopush_status";
		$this->priceField               	= 	"price";
		$this->ascendingField          		= 	"asc";
        $this->descendingField          	= 	"desc";
        $this->DuplicateMainId          	= 	"duplicate_id";
        $this->DmsCarStatus             	= 	"car_master_status";
        $this->DmsCarListPhotosTable    	= 	"dms_car_listings_photos";
        $this->DmsCarListVideosTable    	= 	"dms_car_listings_videos";
        $this->DmsCarListDocumentTable  	= 	"dms_car_listings_documents";
        $this->MasterVariantTable       	= 	"master_variants"; 
		
	}
    
    /*THIS FUNCTION USED FOR VIEW INVENTORY LIST CATEGORY BASED ON INPUT TYPE DETAILS*/
    public function doApiviewinventorydashboard()
    {          
        $id 					= 	Input::get('session_user_id');
        $inventory_type 		= 	Input::get('inventory_type_id');
        $sorting_id 			= 	Input::get('sorting_id');
        if($id == "" || $inventory_type == "" || $sorting_id =="")
        {
			return response()->json(['Result'=>'0',
									'message'=>'User id and inventory type id is required!!'
									]);
		}
		if(Input::get('page_name')=='viewinventorydashboard')
		{
			$schemaname 	=  $this->getschemaname($id);
			if(!empty($schemaname))
			{
				switch($inventory_type)
				{
					case 0:
						$getresult 		=	inventorymodel::schemaorderby_details($schemaname,
																$this->DmsCarListTable,
																$this->priceField,
																$this->descendingField
																);
					break;
					case 1:
						$wherecon 		=	array('inventory_type'=>'PARKANDSELL');
						$getresult 		=	inventorymodel::fetchrecordsparkandsell($schemaname,
																$wherecon,
																$this->priceField,
																$this->descendingField
																);
						
					break;
					case 2:
						$wherecon 		=	array('inventory_type'=>'OWN');
						$getresult 		=	inventorymodel::fetchrecordsparkandsell($schemaname,
																$wherecon,
																$this->priceField,
																$this->descendingField
																);
					break;
					case 3:
						$wherecon 		=	array($this->DmsCarStatus=>0);
						$getresult 		=	inventorymodel::fetchrecordsTableorderby($schemaname,
																$this->DmsCarListTable,
																$wherecon,
																$this->priceField,
																$this->descendingField
																);
					break;
					case 4:
						$wherecon 		=	array($this->DmsCarStatus=>3);
						$getresult 		=	inventorymodel::fetchrecordsTableorderby($schemaname,
																$this->DmsCarListTable,
																$wherecon,
																$this->priceField,
																$this->descendingField
																);
					break;
					case 5:
						$wherecon 		=	array($this->DmsCarStatus=>4);
						$getresult 		=	inventorymodel::fetchrecordsTableorderby($schemaname,
																$this->DmsCarListTable,
																$wherecon,
																$this->priceField,
																$this->descendingField
																);
					break;
					default:
						$getresult 		=	inventorymodel::schemaorderby_details($schemaname,
																$this->DmsCarListTable,
																$this->priceField,
																$this->descendingField
																);
				}
				
				switch($sorting_id)
				{
					case 0:
						$getresult 		=	$getresult->sortByDesc('price');
					break;
					case 1:
						$getresult 		=	$getresult->sortBy('price');
					break;
					case 2:
						$getresult 		=	$getresult->sortByDesc('mileage');
					break;
					case 3:
						$getresult 		=	$getresult->sortBy('mileage');
					break;
					case 4:
						$getresult 		=	$getresult->sortBy('registration_year');
					break;
					case 5:
						$getresult 		=	$getresult->sortByDesc('registration_year');
					break;
					default:
						$getresult 		=	$getresult->sortByDesc('price');
				}
				$queriesdata 	= 	array();
				$data 			= 	array();
				if(!empty($getresult) && count($getresult) >= 1)
				{
					foreach($getresult as $uservalue)
					{		
						$imagefetch 				= 	inventorymodel::inventoryImageDetails(
																				$schemaname,
																				$this->DmsCarListPhotosTable,
																				array('car_id'=>$uservalue->car_id)
																				);
						if(count($imagefetch) >=	1)
						{
							$data['image'] 			= 	$imagefetch[0]->s3_bucket_path;
						}
						else
						{
							$data['image'] 			= 	config::get('common.carnoimage');   
						}		
						$data['car_id']         	= 	$uservalue->car_id;
						$data['listing_id']       	= 	($uservalue->duplicate_id == null)?"":$uservalue->duplicate_id;
						$data['inventory_type']     = 	$uservalue->inventory_type;
						$data['dealer_id']         	= 	$uservalue->dealer_id;
						$data['price']         		= 	$uservalue->price;
						$data['kms_done']         	= 	$uservalue->kms_done;
						$data['registration_year']  = 	$uservalue->registration_year;
						$data['millege']  			= 	$uservalue->mileage;
						switch($uservalue->owner_type)
						{
							case 'FIRST':
							$data['owner_type']       = 	"1";
							break;
							case 'SECOND':
							$data['owner_type']       = 	"2";
							break;
							case 'THIRD':
							$data['owner_type']       = 	"3";
							break;	
							case 'Fourth':
							$data['owner_type']       = 	"4";
							break;	
							case 'Four +':
							$data['owner_type']       = 	"4 +";
							break;							
						}
						$makewhere					=	array($this->masterMakeIdfiled=>$uservalue->make);
						$getmake 	 				=	inventorymodel::masterschema_table_where(
																					$this->masterMakeTable,
																					$makewhere);
						$data['make'] 				=	((count($getmake)>=1)?$getmake[0]->makename:'');
						$modelwhere					=	array('model_id'=>$uservalue->model_id);
						$getmodel 	 				=	inventorymodel::masterschema_table_where(
																					$this->masterModelsTable,
																					$modelwhere);
                        $data['model'] 				=	((count($getmodel)>=1)?$getmodel[0]->model_name:'');
                        $varientwhere				=	array('variant_id'=>$uservalue->variant);
						$getvarient 	 			=	inventorymodel::masterschema_table_where(
																					$this->MasterVariantTable,
																					$varientwhere);
                        $data['varient'] 			=	((count($getvarient)>=1)?$getvarient[0]->variant_name:'');
                        $colorwhere					=	array('colour_id'=>$uservalue->colors);
						$getcolor 	 				=	inventorymodel::masterschema_table_where(
																					'master_colors',
																					$colorwhere);
                        $data['colors'] 			=	((count($getcolor)>=1)?$getcolor[0]->colour_name:'');																																											
						$data['fuel_type']         	= 	$uservalue->fuel_type;
						$data['statuc_number']      = 	$uservalue->car_master_status;
						$data['imagecount'] 		= 	inventorymodel::dealerTableCount(
																				$schemaname,
																				$this->DmsCarListPhotosTable,
																				array('car_id'=>$uservalue->car_id)
																				);
						$data['videoscount'] 		= 	inventorymodel::dealerTableCount(
																				$schemaname,
																				$this->DmsCarListVideosTable,
																				array('car_id'=>$uservalue->car_id)
																				);
						$data['documentcount'] 		= 	inventorymodel::dealerTableCount(
																				$schemaname,
																				$this->DmsCarListDocumentTable,
																				array('car_id'=>$uservalue->car_id)
																				);
						$viewcount 					=	 inventorymodel::masterschema_table_where(
																				$this->dealerViewedCarsTable,
																				array(
																				'dealer_id'=>$id,
																				'car_id'=>$uservalue->car_id)
																				);
						$data['viewscount']			=	count($viewcount);
						//get status name
						switch($uservalue->car_master_status)
						{
							case 0:
							$data['carstatus']       = 	"Draft";
							break;
							case 1:
							$data['carstatus']       = 	"Ready for Sale";
							break;
							case 2:
							$data['carstatus']       = 	"Live";
							break;
							case 3:
							$data['carstatus']       = 	"Sold";
							break;
							case 4:
							$data['carstatus']       = 	"Deleted";
							break;							
						}
						array_push($queriesdata, $data); 
					}
				}
					return response()->json(['Result'=>'1',
									'message'=>'success',
									'inventory_dashboard'=>$queriesdata
									]);																
			}
			else
			{
				return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
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
    
    /*THIS FUNCTION USED FOR VIEW INVENTORY ALL CATEGORY DETAILS*/
    public function doApiviewinventorylist()
    {          
        $id 						= 	Input::get('session_user_id');
        if($id == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'User id is required!!'
									]);
		}
		if(Input::get('page_name')=='viewallinventory')
		{
			$schemaname 	=  $this->getschemaname($id);
			if(!empty($schemaname))
			{
				$wherecon 		=	array('funding_applied'=>1);
				$getresult 		=	inventorymodel::schema_table_where_inventory($schemaname,
																$this->DmsCarListTable,
																$wherecon,
																$this->priceField,
																$this->descendingField
																);	
				/*$getresult 		=	inventorymodel::dealerFetchTableDetails($schemaname,
																$this->DmsCarListTable,
																$wherecon
																);*/
				$queriesdata 	= 	array();
				$data 			= 	array();
				if(!empty($getresult) && count($getresult) >= 1)
				{
					foreach($getresult as $uservalue)
					{		
						$imagefetch 				= 	inventorymodel::inventoryImageDetails(
																				$schemaname,
																				$this->DmsCarListPhotosTable,
																				array('car_id'=>$uservalue->car_id)
																				);
						if(count($imagefetch) >=	1)
						{
							$data['image'] 			= 	$imagefetch[0]->s3_bucket_path;
						}
						else
						{
							$data['image'] 			= 	config::get('common.carnoimage');   
						}		
						$data['car_id']         	= 	$uservalue->car_id;
						$data['listing_id']       	= 	($uservalue->duplicate_id == null)?"":$uservalue->duplicate_id;
						$data['inventory_type']     = 	$uservalue->inventory_type;
						$data['dealer_id']         	= 	$uservalue->dealer_id;
						$data['price']         		= 	$uservalue->price;
						$data['kms_done']         	= 	$uservalue->kms_done;
						$data['registration_year']  = 	$uservalue->registration_year;
						switch($uservalue->owner_type)
						{
							case 'FIRST':
							$data['owner_type']       = 	"1";
							break;
							case 'SECOND':
							$data['owner_type']       = 	"2";
							break;
							case 'THIRD':
							$data['owner_type']       = 	"3";
							break;	
							case 'Fourth':
							$data['owner_type']       = 	"4";
							break;	
							case 'Four +':
							$data['owner_type']       = 	"4 +";
							break;							
						}
						$makewhere					=	array($this->masterMakeIdfiled=>$uservalue->make);
						$getmake 	 				=	inventorymodel::masterschema_table_where(
																					$this->masterMakeTable,
																					$makewhere);
						$data['make'] 				=	((count($getmake)>=1)?$getmake[0]->makename:'');
						$modelwhere					=	array('model_id'=>$uservalue->model_id);
						$getmodel 	 				=	inventorymodel::masterschema_table_where(
																					$this->masterModelsTable,
																					$modelwhere);
                        $data['model'] 				=	((count($getmodel)>=1)?$getmodel[0]->model_name:'');
                        $varientwhere				=	array('variant_id'=>$uservalue->variant);
						$getvarient 	 			=	inventorymodel::masterschema_table_where(
																					$this->MasterVariantTable,
																					$varientwhere);
                        $data['varient'] 			=	((count($getvarient)>=1)?$getvarient[0]->variant_name:'');
                        $colorwhere					=	array('colour_id'=>$uservalue->colors);
						$getcolor 	 				=	inventorymodel::masterschema_table_where(
																					'master_colors',
																					$colorwhere);
                        $data['colors'] 			=	((count($getcolor)>=1)?$getcolor[0]->colour_name:'');																																											
						$data['fuel_type']         	= 	$uservalue->fuel_type;
						$data['statuc_number']      = 	$uservalue->car_master_status;
						$data['imagecount'] 		= 	inventorymodel::dealerTableCount(
																				$schemaname,
																				$this->DmsCarListPhotosTable,
																				array('car_id'=>$uservalue->car_id)
																				);
						$data['videoscount'] 		= 	inventorymodel::dealerTableCount(
																				$schemaname,
																				$this->DmsCarListVideosTable,
																				array('car_id'=>$uservalue->car_id)
																				);
						$data['documentcount'] 		= 	inventorymodel::dealerTableCount(
																				$schemaname,
																				$this->DmsCarListDocumentTable,
																				array('car_id'=>$uservalue->car_id)
																				);
						$viewcount 					=	 inventorymodel::masterschema_table_where(
																				$this->dealerViewedCarsTable,
																				array(
																				'dealer_id'=>$id,
																				'car_id'=>$uservalue->car_id)
																				);
						$data['viewscount']			=	count($viewcount);
						//get status name
						switch($uservalue->car_master_status)
						{
							case 0:
							$data['carstatus']       = 	"Draft";
							break;
							case 1:
							$data['carstatus']       = 	"Ready for Sale";
							break;
							case 2:
							$data['carstatus']       = 	"Live";
							break;
							case 3:
							$data['carstatus']       = 	"Sold";
							break;
							case 4:
							$data['carstatus']       = 	"Deleted";
							break;							
						}
						array_push($queriesdata, $data); 
					}
					
				}
				return response()->json(['Result'=>'1',
									'message'=>'success',
									'inventory_list'=>$queriesdata
									]);																
			}
		}
		return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
		
    }
    //THIS FUNCTION USED FOR DELETE INVENTORY 
    public function doApiinventorydelete()
    {          
        $id 						= 	Input::get('session_user_id');
        $car_id 					= 	Input::get('car_id');
        $status 					= 	Input::get('status');
        $inventory_type 			= 	Input::get('inventory_type_id');
        if($id == "" || $car_id == "" || $status ==	"" || $inventory_type == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'User id and Car id is required!!'
									]);
		}
		if(Input::get('page_name')=='deleteinventory')
		{
			$schemaname 			=  $this->getschemaname($id);
			if(!empty($schemaname))
			{
				$where 				=	array('car_id'=>$car_id);
				$setdata 			=	array($this->DmsCarStatus => $status);
				$updateinventory 	=	inventorymodel::dealerUpdateTableDetails($id,
															$schemaname,
															$this->DmsCarListTable,
															$where,
															$setdata
															);
				if(!empty($updateinventory) && count($updateinventory) >= 1)
				{
				
				switch($inventory_type)
				{
					case 0:
						$getresult 		=	inventorymodel::schemaorderby_details($schemaname,
																$this->DmsCarListTable,
																$this->priceField,
																$this->descendingField
																);
					break;
					case 1:
						$wherecon 		=	array('inventory_type'=>'PARKANDSELL');
						$getresult 		=	inventorymodel::fetchrecordsparkandsell($schemaname,
																$wherecon,
																$this->priceField,
																$this->descendingField
																);
					break;
					case 2:
						$wherecon 		=	array('inventory_type'=>'OWN');
						$getresult 		=	inventorymodel::fetchrecordsparkandsell($schemaname,
																$wherecon,
																$this->priceField,
																$this->descendingField
																);
					break;
					case 3:
						$wherecon 		=	array($this->DmsCarStatus=>0);
						$getresult 		=	inventorymodel::fetchrecordsTableorderby($schemaname,
																$this->DmsCarListTable,
																$wherecon,
																$this->priceField,
																$this->descendingField
																);
					break;
					case 4:
						$wherecon 		=	array($this->DmsCarStatus=>3);
						$getresult 		=	inventorymodel::fetchrecordsTableorderby($schemaname,
																$this->DmsCarListTable,
																$wherecon,
																$this->priceField,
																$this->descendingField
																);
					break;
					case 5:
						$wherecon 		=	array($this->DmsCarStatus=>4);
						$getresult 		=	inventorymodel::fetchrecordsTableorderby($schemaname,
																$this->DmsCarListTable,
																$wherecon,
																$this->priceField,
																$this->descendingField
																);
					break;
					
				}
				
				$queriesdata 	= 	array();
				$data 			= 	array();
				if(!empty($getresult) && count($getresult) >= 1)
				{
					foreach($getresult as $uservalue)
					{		
						$imagefetch 				= 	inventorymodel::inventoryImageDetails(
																				$schemaname,
																				$this->DmsCarListPhotosTable,
																				array('car_id'=>$uservalue->car_id)
																				);
						if(count($imagefetch) >=	1)
						{
							$data['image'] 			= 	$imagefetch[0]->s3_bucket_path;
						}
						else
						{
							$data['image'] 			= 	config::get('common.carnoimage');   
						}		
						$data['car_id']         	= 	$uservalue->car_id;
						$data['listing_id']       	= 	($uservalue->duplicate_id == null)?"":$uservalue->duplicate_id;
						$data['inventory_type']     = 	$uservalue->inventory_type;
						$data['dealer_id']         	= 	$uservalue->dealer_id;
						$data['price']         		= 	$uservalue->price;
						$data['kms_done']         	= 	$uservalue->kms_done;
						$data['registration_year']  = 	$uservalue->registration_year;
						switch($uservalue->owner_type)
						{
							
							case 'FIRST':
							$data['owner_type']       = 	"1";
							break;
							case 'SECOND':
							$data['owner_type']       = 	"2";
							break;
							case 'THIRD':
							$data['owner_type']       = 	"3";
							break;	
							case 'Fourth':
							$data['owner_type']       = 	"4";
							break;	
							case 'Four +':
							$data['owner_type']       = 	"4 +";
							break;						
						}
						$makewhere					=	array($this->masterMakeIdfiled=>$uservalue->make);
						$getmake 	 				=	inventorymodel::masterschema_table_where(
																					$this->masterMakeTable,
																					$makewhere);
						$data['make'] 				=	((count($getmake)>=1)?$getmake[0]->makename:'');
						$modelwhere					=	array('model_id'=>$uservalue->model_id);
						$getmodel 	 				=	inventorymodel::masterschema_table_where(
																					$this->masterModelsTable,
																					$modelwhere);
                        $data['model'] 				=	((count($getmodel)>=1)?$getmodel[0]->model_name:'');
                        $varientwhere				=	array('variant_id'=>$uservalue->variant);
						$getvarient 	 			=	inventorymodel::masterschema_table_where(
																					$this->MasterVariantTable,
																					$varientwhere);
                        $data['varient'] 			=	((count($getvarient)>=1)?$getvarient[0]->variant_name:'');
                        $colorwhere					=	array('colour_id'=>$uservalue->colors);
						$getcolor 	 				=	inventorymodel::masterschema_table_where(
																					'master_colors',
																					$colorwhere);
                        $data['colors'] 			=	((count($getcolor)>=1)?$getcolor[0]->colour_name:'');																																											
						$data['fuel_type']         	= 	$uservalue->fuel_type;
						$data['statuc_number']      = 	$uservalue->car_master_status;
						$data['imagecount'] 		= 	inventorymodel::dealerTableCount(
																				$schemaname,
																				$this->DmsCarListPhotosTable,
																				array('car_id'=>$uservalue->car_id)
																				);
						$data['videoscount'] 		= 	inventorymodel::dealerTableCount(
																				$schemaname,
																				$this->DmsCarListVideosTable,
																				array('car_id'=>$uservalue->car_id)
																				);
						$data['documentcount'] 		= 	inventorymodel::dealerTableCount(
																				$schemaname,
																				$this->DmsCarListDocumentTable,
																				array('car_id'=>$uservalue->car_id)
																				);
						$viewcount 					=	 inventorymodel::masterschema_table_where(
																				$this->dealerViewedCarsTable,
																				array(
																				'dealer_id'=>$id,
																				'car_id'=>$uservalue->car_id)
																				);
						$data['viewscount']			=	count($viewcount);
						//get status name
						switch($uservalue->car_master_status)
						{
							case 0:
							$data['carstatus']       = 	"Draft";
							break;
							case 1:
							$data['carstatus']       = 	"Ready for Sale";
							break;
							case 2:
							$data['carstatus']       = 	"Live";
							break;
							case 3:
							$data['carstatus']       = 	"Sold";
							break;
							case 4:
							$data['carstatus']       = 	"Deleted";
							break;							
						}
						array_push($queriesdata, $data); 
					}
				}
					return response()->json(['Result'=>'1',
									'message'=>'success',
									'inventory_dashboard'=>$queriesdata
									]);	
				}
				else
				{
					return response()->json(['Result'=>'0',
									'message'=>'failure',
									]);
				}
																				
			}
		}
		return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
		
    }
    /*THIS FUNCTION USED FOR VIEW MY POSTING DETAILS*/
    public function doApimypostlist()
    {          
        $id 						= 	Input::get('session_user_id');
        if($id == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'User id is required!!'
									]);
		}
		if(Input::get('page_name')=='viewmypost')
		{
			$schemaname 	=  $this->getschemaname($id);
			if(!empty($schemaname))
			{
				$wherecon       =   array("mongopush_status"=>"success"
                                          );
				$CarlistDetails = inventorymodel::schema_mypostings_list(
																$schemaname,
                                                                $this->DmsCarListTable,
                                                                $wherecon,
                                                                $this->DmsCarStatus
                                                                );
				$queriesdata 	= 	array();
				$data 			= 	array();
			if(!empty($CarlistDetails) && count($CarlistDetails)>=1){
                foreach($CarlistDetails as $listkey=>$val)
                {
                    $ColumnPhoto = "photo_id";
                    $wherecon 	 =	array("car_id"=>$val->car_id);
                    $getimageurl = inventorymodel::schema_whereorderbylimitone(
																$schemaname,
                                                                $this->DmsCarListPhotosTable,
                                                                $ColumnPhoto,
                                                                $wherecon
                                                                );
                    if(!empty($getimageurl) && count($getimageurl) >= 1)
					{
						foreach($getimageurl as $image)
						{
							$data['imageurl']  	= 	stripcslashes($image->s3_bucket_path);
						}
					}
					else
					{
						$data['imageurl'] 		= 	stripcslashes(Config::get('common.carnoimage'));
					}
					$data['car_id'] 			= 	$val->car_id;                                                              
                    $data['year'] 				= 	$val->registration_year;
                    $data['price'] 				= 	$val->price;
                    $data['kms'] 				= 	$val->kms_done;
                    switch($val->owner_type)
						{
							case 'FIRST':
							$data['owner_type']       = 	"1";
							break;
							case 'SECOND':
							$data['owner_type']       = 	"2";
							break;
							case 'THIRD':
							$data['owner_type']       = 	"3";
							break;	
							case 'Fourth':
							$data['owner_type']       = 	"4";
							break;	
							case 'Four +':
							$data['owner_type']       = 	"4 +";
							break;								
						}
                    $data['fuel_type'] 			= 	$val->fuel_type;
                    $makewhere					=	array($this->masterMakeIdfiled=>$val->make);
					$getmake 	 				=	inventorymodel::masterschema_table_where(
																				$this->masterMakeTable,
																				$makewhere);
					$data['make'] 				=	((count($getmake)>=1)?$getmake[0]->makename:'');
					$modelwhere					=	array('model_id'=>$val->model_id);
					$getmodel 	 				=	inventorymodel::masterschema_table_where(
																				$this->masterModelsTable,
																				$modelwhere);
					$data['model'] 				=	((count($getmodel)>=1)?$getmodel[0]->model_name:'');
					$varientwhere				=	array('variant_id'=>$val->variant);
					$getvarient 	 			=	inventorymodel::masterschema_table_where(
																				$this->MasterVariantTable,
																				$varientwhere);
					$data['varient'] 			=	((count($getvarient)>=1)?$getvarient[0]->variant_name:'');
					$colorwhere					=	array('colour_id'=>$val->colors);
					$getcolor 	 				=	inventorymodel::masterschema_table_where(
																				'master_colors',
																				$colorwhere);
					$data['colors'] 			=	((count($getcolor)>=1)?$getcolor[0]->colour_name:'');
                    
                    
                    if($val->mongopushdate == "")
					{
						$data['mongopushdate']  =   "";
					}else
					{
						$data['mongopushdate']  = commonmodel::getdatemonthformat($val->mongopushdate);
					}                                                                
					
                    array_push($queriesdata, $data);
                 }
            }				
			return response()->json(['Result'=>'1',
									'message'=>'success',
									'myposting_list'=>$queriesdata
									]);															
			}
		}
			return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
    }
    
    /*view posting details invidual car*/
    public function doApimypostdetails()
    {          
        $id 						= 	Input::get('session_user_id');
        $car_id                     = 	Input::get('car_id');
        if($id == "" || $car_id == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'User id and car id is required!!'
									]);
		}
		if(Input::get('page_name')=='viewmypostdetails')
		{
			$schemaname 	=  $this->getschemaname($id);
			if(!empty($schemaname))
			{
				$wherecon       =   array("mongopush_status"=>"success",
											'car_id'=>$car_id
                                          );
				$CarlistDetails = inventorymodel::schema_mypostings_list(
																$schemaname,
                                                                $this->DmsCarListTable,
                                                                $wherecon,
                                                                $this->DmsCarStatus
                                                                );
				$modeldetails	= 	array();
				$listingdetails	= 	array();
				$data 			= 	array();
				$listingdata 	=	array();
				$listingtype 	=	array();
			if(!empty($CarlistDetails) && count($CarlistDetails)>=1){
                foreach($CarlistDetails as $listkey=>$val)
                {
                    $ColumnPhoto = "photo_id";
                    $wherecon 	 =	array("car_id"=>$val->car_id);
                    $getimageurl = inventorymodel::schema_whereorderbylimitone(
																$schemaname,
                                                                $this->DmsCarListPhotosTable,
                                                                $ColumnPhoto,
                                                                $wherecon
                                                                );
                    if(!empty($getimageurl) && count($getimageurl) >= 1)
					{
						foreach($getimageurl as $image)
						{
							$data['imageurl']  	= 	stripcslashes($image->s3_bucket_path);
						}
					}
					else
					{
						$data['imageurl'] 		= 	stripcslashes(url(Config::get('common.carnoimage')));
					}
					                                                                
                    $data['year'] 				= 	$val->registration_year;
                    $data['duplicate_id']       = 	($val->duplicate_id == null)?"":$val->duplicate_id;
                    $data['price'] 				= 	$val->price;
                    $data['kms'] 				= 	$val->kms_done;
                    switch($val->owner_type)
						{
							case 'FIRST':
							$data['owner']       = 	"1";
							break;
							case 'SECOND':
							$data['owner']       = 	"2";
							break;
							case 'THIRD':
							$data['owner']       = 	"3";
							break;	
							case 'Fourth':
							$data['owner']       = 	"4";
							break;	
							case 'Four +':
							$data['owner']       = 	"4 +";
							break;							
						}
                    $data['fuel_type'] 			= 	$val->fuel_type;
                    $data['plan'] 				= 	'Free';
                    $data['mileage'] 			= 	$val->mileage;
                    $placewhere					=	array('master_id'=>$val->car_city);
					$getplace 	 				=	inventorymodel::masterschema_table_where(
																				'master_city',
																				$placewhere);
					$data['place'] 				=	((count($getplace)>=1)?$getplace[0]->city_name:'');
                    $makewhere					=	array($this->masterMakeIdfiled=>$val->make);
					$getmake 	 				=	inventorymodel::masterschema_table_where(
																				$this->masterMakeTable,
																				$makewhere);
					$data['make'] 				=	((count($getmake)>=1)?$getmake[0]->makename:'');
					$modelwhere					=	array('model_id'=>$val->model_id);
					$getmodel 	 				=	inventorymodel::masterschema_table_where(
																				$this->masterModelsTable,
																				$modelwhere);
					$data['model'] 				=	((count($getmodel)>=1)?$getmodel[0]->model_name:'');
					$varientwhere				=	array('variant_id'=>$val->variant);
					$getvarient 	 			=	inventorymodel::masterschema_table_where(
																				$this->MasterVariantTable,
																				$varientwhere);
					$data['varient'] 			=	((count($getvarient)>=1)?$getvarient[0]->variant_name:'');
					$colorwhere					=	array('colour_id'=>$val->colors);
					$getcolor 	 				=	inventorymodel::masterschema_table_where(
																				'master_colors',
																				$colorwhere);
					$data['colors'] 			=	((count($getcolor)>=1)?$getcolor[0]->colour_name:'');
					$seatwhere					=	array('listing_id'=>$val->car_id);
					$getseat 	 				=	inventorymodel::dealerFetchTableDetails($schemaname,
																				'dealer_listing_features',
																				$seatwhere);
					$data['seat'] 				=	((count($getseat)>=1)?$getseat[0]->seating_capacity:'');
					
					$where 						=	array("car_id"=>$val->car_id);
                    $getimagescount 			= 	inventorymodel::dealerFetchTableDetails(
                                                                $schemaname,
                                                                $this->DmsCarListPhotosTable,
                                                                $where
                                                                );
                    if(!empty($getimagescount))
					{
						$data['imagecount']  	= 	count($getimagescount);
					}
					$where 						=	array("car_id"=>$val->car_id);
                    $videoscount 				= 	inventorymodel::dealerFetchTableDetails(
                                                                $schemaname,
                                                                $this->DmsCarListVideosTable,
                                                                $where
                                                                );
                    if(!empty($videoscount))
					{
						$data['videoscount']  	= 	count($videoscount);
					}
					$where 						=	array("car_id"=>$val->car_id);
                    $documentcount 				= 	inventorymodel::dealerFetchTableDetails(
                                                                $schemaname,
                                                                $this->DmsCarListDocumentTable,
                                                                $where
                                                                );
                    if(!empty($documentcount))
					{
						$data['documentcount']  = 	count($documentcount);
					}
                    $viewscount 				= 	inventorymodel::master_table_where(                                                                
                                                                $this->dealerViewedCarsTable,
                                                                "car_id",
                                                                $val->car_id
                                                                );
                    if(!empty($viewscount))
					{
						$data['viewscount']  	= 	count($viewscount);
					}
                    if($val->mongopushdate == "")
					{
						$data['mongopushdate']  =   "";
					}else
					{
						$data['mongopushdate']  = commonmodel::getdatemonthformat($val->mongopushdate);
					} 
					//GET LISTING TYPE 
					$wherecon 		=	array('inventory_id'=>$val->car_id);
					$carlisttype 	= 	inventorymodel::dealerFetchTableDetails(
																$schemaname,
                                                                'dealer_listing_details',
                                                                $wherecon
                                                                );                                                               
                    if(!empty($carlisttype) && count($carlisttype) >=1)
					{
						foreach($carlisttype as $litingtype)
						{
							$data['listing_id'] 	=	$litingtype->id;
							$data['car_id'] 		=	$val->car_id;
							$data['listing_site']	=	$litingtype->listing_site;
							if($litingtype->listing_status == "Active")
							{
								$data['listing_status'] 	=	"1";
							}
							else
							{
								$data['listing_status'] 	=	"0";
							}
							
							$wherelist 				=	array('sitename'=>$litingtype->listing_site);
							$listingimage 			=	inventorymodel::masterschema_table_where(
																$this->masterApiSitesTable,
																$wherelist);
                            $data['list_image'] 	=	((count($listingimage)>=1)?url($listingimage[0]->logourl):'');
							$data['createddate'] 	=	commonmodel::getdatemonthformat($litingtype->createddate);
							//array_push($listingtype, $listingdata);
							array_push($listingdetails, $data);
						}
					}
					array_push($modeldetails, $data);
                 }
                }
                $mergedata 		=	array_merge($listingdetails,$listingtype);
                return response()->json(['Result'=>'1',
									'message'=>'success',
									'myposting_list'=>$modeldetails,
									'myposting_details'=>$listingdetails
									]);	
			}
		}
			return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
			
    }
    
    //THIS FUNCTION USED FOR LISTING TYPE DELETE AND REPOST IN MYPOSTING DETAILS PAGE
    public function doApipostingstatus()
    {
        $id 			= 	Input::get('session_user_id');
        $listing_id 	=	Input::get('listing_id');
        if($id == "" || $listing_id == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'Invalid User id or Listing id!!'
									]);
		}
		if(Input::get('page_name')=='mypostdetailsdelete')
		{
			$schemaname 	=  $this->getschemaname($id);
			if(!empty($schemaname))
			{
				$where 		=	array('id'=>$listing_id);
				$getmypost 	=	inventorymodel::dealerFetchTableDetails(
                                                                $schemaname,
                                                                'dealer_listing_details',
                                                                $where
                                                                );
                $getstatus 	=	((count($getmypost)>=1)?$getmypost[0]->listing_status:'');
                if($getstatus == "Active")
                {
					$where 			=	array('id'=>$listing_id);
					$setdata 		=	array('listing_status'=>'Inactive');
					$updatemypost 	=	inventorymodel::dealerUpdateTableDetails($id,
                                                                $schemaname,
                                                                'dealer_listing_details',
                                                                $where,
                                                                $setdata
                                                                );
				}
				else
				{
					$where 			=	array('id'=>$listing_id);
					$setdata 		=	array('listing_status'=>'Active');
					$updatemypost 	=	inventorymodel::dealerUpdateTableDetails($id,
                                                                $schemaname,
                                                                'dealer_listing_details',
                                                                $where,
                                                                $setdata
                                                                );
					
				}
				        
					if(!empty($updatemypost) && count($updatemypost) >= 1)
					{
						return response()->json(['Result'=>'2',
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
		}
		return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
		
    }
    
    /*REVOKE LOAN  */
    public function doApicustomername()
    {
        $id 			= 	Input::get('session_user_id');
        $customertype 	=	Input::get('customertype');
        if($id == "" || $customertype == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'Invalid User!!'
									]);
		}
		$schemaname 	=  $this->getschemaname($id);
		if(!empty($schemaname))
		{	
			$wherecondition	=	array('contact_type_id'=>$customertype);
			$branchdetails 	=	inventorymodel::dogetschemaDetails($schemaname,
																		'dealer_contact_management',
																		'contact_first_name',
																		$wherecondition);
			return response()->json(['Result'=>'1',
										'message'=>$branchdetails
										]);
		}
		else
		{
			return response()->json(['Result'=>'0',
										'message'=>'failure'
										]);
		}
    }
    
    /*ADD INVENTORY */
    public function doApiAddInventory()
    {	
		$id 			= 	input::get('session_user_id');
		$jsondata 		= 	input::get('basicData');
        $registerYear 	= 	$jsondata[0]['registerYear'];
        $makeId 		=	$jsondata[0]['makeId'];
        $modalId 		=	$jsondata[0]['modalId'];
        $vaientId 		=	$jsondata[0]['vaientId'];
        $bodyType 		=	$jsondata[0]['bodyType'];
        $transmissionId =	$jsondata[0]['transmissionId'];
        $totalDistance 	=	$jsondata[0]['totalDistance'];
        $millege 		=	$jsondata[0]['millege'];
        $ownerShip 		=	$jsondata[0]['ownerShip'];
        $carStatusId 	=	$jsondata[0]['carStatusId'];
        $colorId 		=	$jsondata[0]['colorId'];
        $cityId 		=	$jsondata[0]['cityId'];
        $branch 		=	$jsondata[0]['branch'];
        $fuelType 		=	$jsondata[0]['fuelType'];
        if($id == "" || $registerYear == "" || $makeId == "" || $modalId == ""  || $vaientId == ""  || $bodyType == ""
			|| $transmissionId == "" || $totalDistance == "" || $millege == "" || $ownerShip == "" || $carStatusId == ""
			 || $colorId == "" || $cityId == "" || $fuelType == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'basic!!'
									]);
		}
		if(input::get('PricingType')	==	"own")
		{
			if(Input::get('customerId') == "" || Input::get('name') == "" || Input::get('purchasePrice') == ""
			 || Input::get('purchaseDate') == "" || Input::get('markupName') == "" || Input::get('markupValue') == "" || Input::get('markupTotal') == "")
			{
				return response()->json(['Result'=>'0',
										'message'=>'own!!'
										]);
			}
		}
		
		if(input::get('PricingType')	==	"park")
		{
			if(Input::get('customerId') == "" || Input::get('name') == "" || Input::get('fromDate') == "" || Input::get('startingKm') == ""
			 || Input::get('customerAskingPrice') == "" || Input::get('dealerPrice') == "" || Input::get('markupName') == "" || Input::get('markupValue') == "" || Input::get('markupTotal') == "")
			{
				return response()->json(['Result'=>'0',
										'message'=>'parksell!!'
										]);
			}
		}
		$Typeofinventory=	input::get('PricingType');
		if($Typeofinventory == "park")
		{
			$PricingType=	"PARKANDSELL";
		}
		if($Typeofinventory == "own")
		{
			$PricingType=	"OWN";
		}
		$Pricingtotal	=	input::get('markupTotal');
		$purchaseDate	=	input::get('purchaseDate');
		$purchasePrice	=	input::get('purchasePrice');
		$purchasenameid	=	input::get('customerId');
		$purchasename	=	input::get('name');
		$keysRecieved	=	input::get('keysRecieved');
		$documentRecieved	=	input::get('documentRecieved');
		$testDrive		=	input::get('testDrive');
		$testdealerpoint=	input::get('testDrivedealerpoint');
		$testdoorpoint	=	input::get('testDrivedoorstep');
		$markupName		=	input::get('markupName');
		$testdoorpoint	=	input::get('markup_percentage');
		$markupValue	=	input::get('markupValue');
		$markupTotal	=	input::get('markupTotal');
		$fromDate		=	input::get('fromDate');
		$startingKm		=	input::get('startingKm');
		$fuelIndication	=	input::get('fuelIndication');
		$customerAskingPrice	=	input::get('customerAskingPrice');
		$dealerPrice	=	input::get('dealerPrice');
		$schemaname 	=  $this->getschemaname($id);
		if(!empty($schemaname))
		{	
			$insertbasicdata	=	array('addinventor_id'=>0,
											'inventory_type'=>$PricingType,
											'dealer_id'=>$id,
											'branch_id'=>$branch,
											'fuel_type'=>$fuelType,
											'category_id'=>$bodyType,
											'variant'=>$vaientId,
											'mileage'=>$millege,
											'transmission'=>$transmissionId,
											'price'=>$Pricingtotal,
											'colors'=>$colorId,
											'status'=>$carStatusId,
											'registration_year'=>$registerYear,
											'owner_type'=>$ownerShip,
											'make'=>$makeId,
											'model_id'=>$modalId,
											'kms_done'=>$totalDistance,
											'car_city'=>$cityId,
											'updated_at'=>Carbon::now()
									);
			$insertbasicinfo 	= 	inventorymodel::dealerInsertTable($schemaname,
																	$this->DmsCarListTable,
																	$insertbasicdata);
			if($insertbasicinfo >= 1)
			{
				$insertpricingdata	=	array('listing_id'=>$insertbasicinfo,
											'ownpurchase_date'=>$purchaseDate,
											'ownpurchased_from'=>$purchasenameid,
											'ownreceived_from_name'=>$purchasename,
											'ownpurchased_price'=>$purchasePrice,
											'ownkey_received'=>$keysRecieved,
											'owndocuments_received'=>$documentRecieved,
											'inventory_type'=>$PricingType,
											'test_drive'=>$testDrive,
											'testdrive_dealerpoint'=>$testdealerpoint,
											'testdrive_doorstep'=>input::get('testDrivedoorstep'),
											'markup_condition'=>$markupName,
											'markup_value'=>$markupValue,
											'markup_percentage'=>$markupValue,
											'saleprice'=>$markupTotal,
											'user_id'=>$id,
											'purchase_date'=>$fromDate,
											'starting_kms'=>$startingKm,
											'received_from_own'=>$purchasenameid,
											'received_from_name'=>$purchasename,
											'fuel_indication'=>$fuelIndication,
											'customer_asking_price'=>$customerAskingPrice,
											'dealer_markup_price'=>$dealerPrice,
											'keys_available'=>$keysRecieved,
											'documents_received'=>$documentRecieved
									);
					$insertbasicprice 	= 	inventorymodel::dealerInsertTable($schemaname,
													'dealer_cars_pricing',
													$insertpricingdata);
					$Inserttransport 	= 	array(
													'car_id'        =>$insertbasicinfo, 
													'car_primary_id'=>'',
													'expense_desc'  =>'Refurbishment Cost',
													'expense_amount'=>Input::get('refurbishment')
												);
					$Inserttrans  		= 	inventorymodel::dealerInsertTable(
												$schemaname,'dealer_car_expenses',$Inserttransport
												);
					$Inserttransport 	= 	array(
													'car_id'        =>$insertbasicinfo, 
													'car_primary_id'=>'',
													'expense_desc'  =>'Transport Cost',
													'expense_amount'=>Input::get('transport')
												);
					$Inserttrans  		= 	inventorymodel::dealerInsertTable(
												$schemaname,'dealer_car_expenses',$Inserttransport
												);
					$array 	=	Input::get('AddExpense');
					if(!empty(Input::get('AddExpense')) && count(Input::get('AddExpense') >= 1) && $insertbasicprice >= 1){
						$expenses	=	Input::get('AddExpense');
						foreach($expenses as $key=>$value){
							if(!empty($value['expenseName']))
							{
								$InsertExpenseData 	= 	array(
															'car_id'        =>$insertbasicinfo, 
															'car_primary_id'=>'',
															'expense_desc'  =>$value['expenseName'],
															'expense_amount'=>$value['expensePrice']
															);
								$InsertExpense  	= 	inventorymodel::dealerInsertTable(
															$schemaname,'dealer_car_expenses',$InsertExpenseData
															);
							}
						}
					}
					return response()->json(['Result'=>'1',
										'message'=>'success',
										'car_id'=>$insertbasicinfo
										]);
				
			}
			return response()->json(['Result'=>'0',
										'message'=>'Please Try Again'
										]);
		}
		else
		{
			return response()->json(['Result'=>'0',
										'message'=>'failure'
										]);
		}
    }
    
    /*ADD INVENTORY */
    public function doApiViewInventoryDetails()
    {	
		$id 			= 	input::get('session_user_id');
		$car_id 		= 	input::get('car_id');
		if($id == "" || $car_id	==	"")
        {
			return response()->json(['Result'=>'0',
									'message'=>'User and car id is required!!'
									]);
		}
		$viewdata		=	array();
		$schemaname 	=  $this->getschemaname($id);
		if(!empty($schemaname))
		{	
			$getresult 		= 	inventorymodel::getviewinventorydetails(
																	$schemaname,
																	$car_id
																	);
			$getexpense 	= 	inventorymodel::dealerFetchTableDetails(
																	$schemaname,
																	'dealer_car_expenses',
																	array('car_id'=>$car_id)
																	);
			
			if(!empty($getresult) && count($getresult) >=1 )
			{
				foreach($getresult as $viewinventory)
				{
					$view['car_id']				=	$viewinventory->car_id;
					$view['inventory_type']		=	$viewinventory->inventory_type;
					if($viewinventory->inventory_type == "PARKANDSELL")
					{
						$view['inventory_type']	=	"park";
					}
					if($viewinventory->inventory_type == "OWN")
					{
						$view['inventory_type']	=	"own";
					}
					$view['chassis_number']		=	(int)$viewinventory->chassis_number;
					$view['engine_number']		=	(int)$viewinventory->engine_number;
					$view['fuel_type']			=	$viewinventory->fuel_type;
					$view['owner_type']			=	$viewinventory->owner_type;
					switch($viewinventory->owner_type)
					{
						case 'FIRST':
						$view['owner_id']       = 	"1";
						break;
						case 'SECOND':
						$view['owner_id']       = 	"2";
						break;
						case 'THIRD':
						$view['owner_id']       = 	"3";
						break;	
						case 'Fourth':
						$view['owner_id']       = 	"4";
						break;	
						case 'Four +':
						$view['owner_id']       = 	"4 +";
						break;							
					}
					$view['make']				=	$viewinventory->make;
					$makewhere					=	array($this->masterMakeIdfiled=>$viewinventory->make);
					$getmake 	 				=	inventorymodel::masterschema_table_where(
																				$this->masterMakeTable,
																				$makewhere);
					$view['makename'] 			=	((count($getmake)>=1)?$getmake[0]->makename:'');
					$modelwhere					=	array('model_id'=>$viewinventory->model_id);
					$getmodel 	 				=	inventorymodel::masterschema_table_where(
																				$this->masterModelsTable,
																				$modelwhere);
					$view['model_id']			=	$viewinventory->model_id;
					$view['modelname'] 			=	((count($getmodel)>=1)?$getmodel[0]->model_name:'');
					$varientwhere				=	array('variant_id'=>$viewinventory->variant);
					$getvarient 	 			=	inventorymodel::masterschema_table_where(
																				$this->MasterVariantTable,
																				$varientwhere);
					$view['variant']			=	$viewinventory->variant;
					$view['varientname'] 		=	((count($getvarient)>=1)?$getvarient[0]->variant_name:'');
					$colorwhere					=	array('colour_id'=>$viewinventory->colors);
					$getcolor 	 				=	inventorymodel::masterschema_table_where(
																				'master_colors',
																				$colorwhere);
					$view['colorname'] 			=	((count($getcolor)>=1)?$getcolor[0]->colour_name:'');																																															
					$view['car_city']			=	$viewinventory->car_city;
					$citywhere					=	array('city_id'=>$viewinventory->car_city);
					$getcity 	 				=	inventorymodel::masterschema_table_where(
																				'master_city',
																				$citywhere);
					$view['cityname'] 			=	((count($getcity)>=1)?$getcity[0]->city_name:'');					
					$view['branch_id']			=	$viewinventory->branch_id;
					$branchwhere				=	array('branch_id'=>$viewinventory->branch_id);
					$getbranch 	 				=	inventorymodel::dealerFetchTableDetails($schemaname,
																				'dms_dealer_branches',
																				$branchwhere);
					$view['branchname'] 		=	((count($getbranch)>=1)?$getbranch[0]->dealer_name:'');
					$catewhere					=	array('category_id'=>$viewinventory->category_id);
					$getcategory 	 			=	inventorymodel::masterschema_table_where(
																				'master_category',
																				$catewhere);
					$view['categoryname'] 		=	((count($getcategory)>=1)?$getcategory[0]->category_description:'');
					$view['category_id']		=	$viewinventory->category_id;
					$view['carstatus']			=	$viewinventory->carstatus;
					switch($viewinventory->carstatus)
					{
						case '3':
						$view['carstatusname']  = 	"Excellent";
						break;
						case '2':
						$view['carstatusname']  = 	"Medium";
						break;
						case '1':
						$view['carstatusname']  = 	"Good";
						break;	
					}
					$view['mileage']			=	(int)$viewinventory->mileage;
					$view['transmission']		=	$viewinventory->transmission;
					$view['price']				=	$viewinventory->price;
					$view['colors']				=	$viewinventory->colors;
					$view['registration_number']=	(int)$viewinventory->registration_number;
					$view['registration_year']	=	$viewinventory->registration_year;
					$view['kms_done']			=	(int)$viewinventory->kms_done;
					$view['pricing_id']			=	$viewinventory->pricing_id;
					$view['ownpurchase_date']		=	$viewinventory->ownpurchase_date;
					$view['ownpurchased_from']		=	$viewinventory->ownpurchased_from;
					$view['ownreceived_from_name']	=	$viewinventory->ownreceived_from_name;
					$view['ownpurchased_price']		=	(int)$viewinventory->ownpurchased_price;
					$view['ownkey_received']		=	$viewinventory->ownkey_received;
					$view['owndocuments_received']	=	$viewinventory->owndocuments_received;
					$view['test_drive']			=	$viewinventory->test_drive;
					$view['testdrive_dealerpoint']	=	$viewinventory->testdrive_dealerpoint;
					$view['testdrive_doorstep']		=	$viewinventory->testdrive_doorstep;
					$view['markup_condition']	=	$viewinventory->markup_condition;
					$view['markup_percentage']	=	(int)$viewinventory->markup_percentage;
					$view['markup_value']		=	(int)$viewinventory->markup_value;
					$view['saleprice']			=	$viewinventory->saleprice;
					$view['purchase_date']		=	$viewinventory->purchase_date;
					$view['starting_kms']		=	(int)$viewinventory->starting_kms;
					$view['received_from_own']	=	$viewinventory->received_from_own;
					$view['received_from_name']	=	$viewinventory->received_from_name;
					$view['fuel_indication']	=	$viewinventory->fuel_indication;
					$view['fuel_capacity']		=	$viewinventory->fuel_capacity;
					$view['customer_asking_price']	=	(int)$viewinventory->customer_asking_price;
					$view['dealer_markup_price']=	(int)$viewinventory->dealer_markup_price;
					$view['keys_available']		=	$viewinventory->keys_available;
					$view['documents_received']	=	$viewinventory->documents_received;
				}
			}
			
			if(!empty($getexpense) && count($getexpense) >=1 )
			{
				$i = 0;
				$count = 1;
				foreach($getexpense as $key=>$expense)
				{
					if($expense->expense_desc == "Refurbishment Cost")
					{
						$view['refurbishment_cost'] = 	(int)$expense->expense_amount;
					}
					if($expense->expense_desc == "Transport Cost")
					{
						$view['transport_cost'] 	= 	(int)$expense->expense_amount;
					}
					
					if($expense->expense_desc !== "Refurbishment Cost" && $expense->expense_desc !== "Transport Cost")
					{
						$expnseval[$i]['expenseName'] 	=	$expense->expense_desc;
						$expnseval[$i]['id'] 			=	$expense->expense_id;
						$expnseval[$i]['expensePrice']	=	$expense->expense_amount;
						$view['otherexpense']			=	$expnseval;
						$view['expencecount']	=	$count;
						$count++;
						$i++;
					}else
					{
						$view['otherexpense']	=	array();
						$view['expencecount']	=	array();
					}
					
				}
			}
			
			array_push($viewdata,$view);
			return response()->json(['Result'=>'1',
								'viewinventory'=>$viewdata
								]);
		}
		else
		{
			return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
		}
    }
    
    /*UPDATE INVENTORY */
    public function doApiUpdateInventory()
    {	
		$id 			= 	input::get('session_user_id');
		$jsondata 		= 	input::get('basicData');
		$carid 			= 	input::get('carid');
        $registerYear 	= 	$jsondata[0]['registerYear'];
        $makeId 		=	$jsondata[0]['makeId'];
        $modalId 		=	$jsondata[0]['modalId'];
        $vaientId 		=	$jsondata[0]['vaientId'];
        $bodyType 		=	$jsondata[0]['bodyType'];
        $transmissionId =	$jsondata[0]['transmissionId'];
        $totalDistance 	=	$jsondata[0]['totalDistance'];
        $millege 		=	$jsondata[0]['millege'];
        $ownerShip 		=	$jsondata[0]['ownerShip'];
        $carStatusId 	=	$jsondata[0]['carStatusId'];
        $colorId 		=	$jsondata[0]['colorId'];
        $cityId 		=	$jsondata[0]['cityId'];
        $branch 		=	$jsondata[0]['branch'];
        $fuelType 		=	$jsondata[0]['fuelType'];
        if($id == "" || $carid == "" || $registerYear == "" || $makeId == "" || $modalId == ""  || $vaientId == ""  || $bodyType == ""
			|| $transmissionId == "" || $totalDistance == "" || $millege == "" || $ownerShip == "" || $carStatusId == ""
			 || $colorId == "" || $cityId == "" || $fuelType == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'All fields are required!!'
									]);
		}
		if(input::get('PricingType')	==	"own")
		{
			if(Input::get('customerId') == "" || Input::get('name') == "" || Input::get('purchasePrice') == ""
			 || Input::get('purchaseDate') == "" || Input::get('AddExpense') == ""
			   || Input::get('markupName') == "" || Input::get('markupValue') == "" || Input::get('markupTotal') == "")
			{
				return response()->json(['Result'=>'0',
										'message'=>'All fields are required!!'
										]);
			}
		}
		
		if(input::get('PricingType')	==	"park")
		{
			if(Input::get('customerId') == "" || Input::get('name') == "" || Input::get('fromDate') == "" || Input::get('startingKm') == ""
			 || Input::get('customerAskingPrice') == "" || Input::get('dealerPrice') == "" || Input::get('AddExpense') == ""
			   || Input::get('markupName') == "" || Input::get('markupValue') == "" || Input::get('markupTotal') == "")
			{
				return response()->json(['Result'=>'0',
										'message'=>'All fields are required!!'
										]);
			}
		}
		$Typeofinventory=	input::get('PricingType');
		if($Typeofinventory == "park")
		{
			$PricingType=	"PARKANDSELL";
		}
		if($Typeofinventory == "own")
		{
			$PricingType=	"OWN";
		}
		$Pricingtotal	=	input::get('markupTotal');
		$purchaseDate	=	input::get('purchaseDate');
		$purchasePrice	=	input::get('purchasePrice');
		$purchasenameid	=	input::get('customerId');
		$purchasename	=	input::get('name');
		$keysRecieved	=	input::get('keysRecieved');
		$documentRecieved	=	input::get('documentRecieved');
		$testDrive		=	input::get('testDrive');
		$testdealerpoint=	input::get('testDrivedealerpoint');
		$testdoorpoint	=	input::get('testDrivedoorstep');
		$markupName		=	input::get('markupName');
		$testdoorpoint	=	input::get('markup_percentage');
		$markupValue	=	input::get('markupValue');
		$markupTotal	=	input::get('markupTotal');
		$fromDate		=	input::get('fromDate');
		$startingKm		=	input::get('startingKm');
		$fuelIndication	=	input::get('fuelIndication');
		$customerAskingPrice	=	input::get('customerAskingPrice');
		$dealerPrice	=	input::get('dealerPrice');
		$schemaname 	=  $this->getschemaname($id);
		if(!empty($schemaname))
		{	
			$updatebasicdata	=	array('addinventor_id'=>0,
											'inventory_type'=>$PricingType,
											'dealer_id'=>$id,
											'branch_id'=>$branch,
											'fuel_type'=>$fuelType,
											'category_id'=>$bodyType,
											'variant'=>$vaientId,
											'mileage'=>$millege,
											'transmission'=>$transmissionId,
											'price'=>$Pricingtotal,
											'colors'=>$colorId,
											'status'=>$carStatusId,
											'registration_year'=>$registerYear,
											'owner_type'=>$ownerShip,
											'make'=>$makeId,
											'model_id'=>$modalId,
											'kms_done'=>$totalDistance,
											'car_city'=>$cityId,
											'updated_at'=>Carbon::now()
									);
			$whereupdate 		=	array('car_id'=>$carid);
			$upddatebasicinfo 	= 	inventorymodel::dealerUpdateTableDetails($id,
																	$schemaname,
																	$this->DmsCarListTable,
																	$whereupdate,
																	$updatebasicdata);
																	
			$updatepricingdata	=	array('listing_id'=>$carid,
										'ownpurchase_date'=>$purchaseDate,
										'ownpurchased_from'=>$purchasenameid,
										'ownreceived_from_name'=>$purchasename,
										'ownpurchased_price'=>$purchasePrice,
										'ownkey_received'=>$keysRecieved,
										'owndocuments_received'=>$documentRecieved,
										'inventory_type'=>$PricingType,
										'test_drive'=>$testDrive,
										'testdrive_dealerpoint'=>$testdealerpoint,
										'testdrive_doorstep'=>input::get('testDrivedoorstep'),
										'markup_condition'=>$markupName,
										'markup_value'=>$markupValue,
										'markup_percentage'=>$markupValue,
										'saleprice'=>$markupTotal,
										'user_id'=>$id,
										'purchase_date'=>$fromDate,
										'starting_kms'=>$startingKm,
										'received_from_own'=>$purchasenameid,
										'received_from_name'=>$purchasename,
										'fuel_indication'=>$fuelIndication,
										'customer_asking_price'=>$customerAskingPrice,
										'dealer_markup_price'=>$dealerPrice,
										'keys_available'=>$keysRecieved,
										'documents_received'=>$documentRecieved
								);
					
					$wherepricing 		=	array('listing_id'=>$carid);
					$updatebasicprice 	= 	inventorymodel::dealerUpdateTableDetails($id,
													$schemaname,
													'dealer_cars_pricing',
													$wherepricing,
													$updatepricingdata);
													
					$wheredelete 		=	array('car_id'=>$carid);
					$deleteoldexpense 	= 	inventorymodel::dealerDeleteTableDetails($schemaname,
																				'dealer_car_expenses',
																				$wheredelete);
					$Inserttransport 	= 	array(
													'car_id'        =>$carid, 
													'car_primary_id'=>'',
													'expense_desc'  =>'Refurbishment Cost',
													'expense_amount'=>Input::get('refurbishment')
												);
					$Inserttrans  		= 	inventorymodel::dealerInsertTable(
												$schemaname,'dealer_car_expenses',$Inserttransport
												);
					$Inserttransport 	= 	array(
													'car_id'        =>$carid, 
													'car_primary_id'=>'',
													'expense_desc'  =>'Transport Cost',
													'expense_amount'=>Input::get('transport')
												);
					$Inserttrans  		= 	inventorymodel::dealerInsertTable(
												$schemaname,'dealer_car_expenses',$Inserttransport
												);
					$array 				=	Input::get('AddExpense');
					if(!empty(Input::get('AddExpense'))){
						$expenses	=	Input::get('AddExpense');
						foreach($expenses as $key=>$value){
							if(!empty($value['expenseName']))
							{
								$InsertExpenseData 	= 	array(
															'car_id'        =>$carid, 
															'car_primary_id'=>'',
															'expense_desc'  =>$value['expenseName'],
															'expense_amount'=>$value['expensePrice']
															);
								$InsertExpense  	= 	inventorymodel::dealerInsertTable(
															$schemaname,'dealer_car_expenses',$InsertExpenseData
															);
							}
						}
					}
					return response()->json(['Result'=>'1',
										'message'=>'success',
										'car_id'=>$carid
										]);
				
		}
		else
		{
			return response()->json(['Result'=>'0',
										'message'=>'failure'
										]);
		}
    }
    //quries function
    public function doApiQueriesReceived()
    {
        $id 			= 	Input::get('session_user_id');
        if($id == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'User id is required!!'
									]);
		}  
		$queriesdata    = 	array();
        $schemaname 	=  $this->getschemaname($id);
		if(!empty($schemaname))
		{
			$dealer_name 				=  	$this->getschemausername($id);
			$fetch_queried_detail      = 	inventorymodel::dealerSellQueriesDetailApi($id,$schemaname);
			$fetch_queried_details 		=	collect($fetch_queried_detail)->sortByDesc('thread_id');
			$listing_orwherecondition   = 	array();
			$listing_wherecondition     = 	array();
			if(!empty($fetch_queried_details) && count($fetch_queried_details) >= 1)
			{
				foreach ($fetch_queried_details as $key){
					$car_id                               = 	(string) $key->car_id;
					$dealer_id                            = 	$key->from_dealer_id;
					$listing_wherecondition['listing_id'] = 	array($car_id);
					$mongo_carlisting_details             = 	inventorymodel::mongoListingApiFetchwithqueries(
																			$id,
																			$listing_wherecondition,
																			$listing_orwherecondition
																			);
			if(!empty($mongo_carlisting_details) && count($mongo_carlisting_details) >= 1)
			{
				foreach ($mongo_carlisting_details as $userkey => $uservalue) {
					$data['noimages']               = 	count($uservalue["photos"]);
					$photos_array                   = 	array();
					if(count($uservalue["photos"]) >0 )
					{
						foreach($uservalue["photos"] as $photokey => $photovalue) {
						   $photos_array[]  		= 	$photovalue['s3_bucket_path'];
						}
						$data['imagelink']  		= 	$photos_array[0];
					}
					else
					{
						$carnoimage         		= 	Config::get('common.carnoimage');
						$data['imagelink']  		=	stripcslashes(url($carnoimage));
					}
					$data['listing_type']           = 	$uservalue['listing_type'];
					$data['price']                  = 	$uservalue['sell_price'];
					$to_get_dealer_id				=	($key->to_dealer_id == $id?$dealer_id:$key->to_dealer_id);
					$fetch_master_todealer_schema 	=  	$this->getschemausername($to_get_dealer_id);
					$to_dealer_name 				= 	($fetch_master_todealer_schema == ""?'':$fetch_master_todealer_schema);
					$codewherecondition             = 	array('contact_transactioncode'=>$key->contact_transactioncode);
					$latest_message                 = 	inventorymodel::dealerQueriesWithCode(
																				$schemaname,
																				$codewherecondition
																				);
					$data['car_id']                 = 	$key->car_id;
					$data['status']                 = 	((count($latest_message)>=1)?$latest_message->status:'');
					$data['from_dealer_id']         = 	$to_dealer_name;
					$data['to_dealer_name']         = 	$dealer_name;
					$data['to_dealer_id']           = 	$to_get_dealer_id;
					$data['make']                   = 	$uservalue['make'].' '
															.$uservalue['model'].' '
															.$uservalue['variant'].' '
															.$uservalue['registration_year'];
					$data['title']                  = 	$key->title;
					$data['dealer_name']            = 	$key->dealer_name;
					$data['dealer_email']           = 	$key->dealer_email;
					$data['message']                = 	$latest_message->message;
					$data['contact_transactioncode']= 	$key->contact_transactioncode;
					$data['days']					=	Carbon::parse($latest_message->delear_datetime)->diffForHumans(); 
					array_push($queriesdata, $data);    
						}
					}
				}
			}
			return response()->json(['Result'=>'1',
									'message'=>'success',
									'mysellqueries'=>$queriesdata
									]);
		}
		return response()->json(['Result'=>'0',
									'message'=>'Invalid Access'
									]);
    }
    
    /*THIS FUNCTION USED FOR VIEW BASIC INFO WHEN UPLOAD IMAGES*/
    public function doApiViewBasicinfodetails()
    {          
        $id 						= 	Input::get('session_user_id');
        $car_id 					= 	Input::get('car_id');
        if($id == "" || $car_id	==	"")
        {
			return response()->json(['Result'=>'0',
									'message'=>'User and car id is required!!'
									]);
		}
		$schemaname 	=  $this->getschemaname($id);
		if(!empty($schemaname))
		{
			$wherecon 		=	array('car_id'=>$car_id);
			$getresult 		=	inventorymodel::schema_table_where_inventory($schemaname,
															$this->DmsCarListTable,
															$wherecon,
															$this->priceField,
															$this->descendingField
															);	
			$queriesdata 	= 	array();
			$data 			= 	array();
			if(!empty($getresult) && count($getresult) >= 1)
			{
				foreach($getresult as $uservalue)
				{		
					$imagefetch 				= 	inventorymodel::inventoryImageDetails(
																			$schemaname,
																			$this->DmsCarListPhotosTable,
																			array('car_id'=>$car_id)
																			);
					if(count($imagefetch) >=	1)
					{
						$profilephotos	=	array('profile_pic','front_view','front_wind','front_underbody','right_side',
													'Right_quarter','front_right','rear','left_side','left_quarter',
													'engine_compartment','dashboard','odometer','ABCpedals','frontdoor',
													'frontright_tyre','rearright_tyre','Boot_Dicky','FrontLeft_Tyre',
													'Odometer_reading');
						foreach($imagefetch as $images)
						{
							$data[$images->profile_pic_name]['image'] 		= 	$images->s3_bucket_path;
							$data[$images->profile_pic_name]['nameimage'] 	= 	$images->profile_pic_name;
							$array[]	=	$images->profile_pic_name;
						}
						$notmatchphotos	=	array_diff($profilephotos,$array);
						foreach($notmatchphotos as $photos)
						{
							$data[$photos]['image'] 		= 	"images/compare.jpg";
							$data[$photos]['nameimage'] 	= 	$photos;
						}
					}
					else
					{
						$data['profile_pic']['image']		= 	"images/compare.jpg";   
						$data['profile_pic']['nameimage'] 	= 	"profile_pic";
						$data['front_view']['image']		= 	"images/compare.jpg";   
						$data['front_view']['nameimage'] 	= 	"front_view";
						$data['front_wind']['image']		= 	"images/compare.jpg";   
						$data['front_wind']['nameimage'] 	= 	"front_wind";
						$data['front_underbody']['image']		= 	"images/compare.jpg";   
						$data['front_underbody']['nameimage'] 	= 	"front_underbody";
						$data['right_side']['image']		= 	"images/compare.jpg";   
						$data['right_side']['nameimage'] 	= 	"right_side";
						$data['Right_quarter']['image']		= 	"images/compare.jpg";   
						$data['Right_quarter']['nameimage'] = 	"Right_quarter";
						$data['front_right']['image']		= 	"images/compare.jpg";   
						$data['front_right']['nameimage'] 	= 	"front_right";
						$data['rear']['image']				= 	"images/compare.jpg";   
						$data['rear']['nameimage']			= 	"rear";
						$data['left_side']['image']			= 	"images/compare.jpg";   
						$data['left_side']['nameimage']		= 	"left_side";
						$data['left_quarter']['image']		= 	"images/compare.jpg";   
						$data['left_quarter']['nameimage']	= 	"left_quarter";
						$data['engine_compartment']['image']	= 	"images/compare.jpg";   
						$data['engine_compartment']['nameimage']= 	"engine_compartment";
						$data['dashboard']['image']			= 	"images/compare.jpg";   
						$data['dashboard']['nameimage']		= 	"dashboard";
						$data['odometer']['image']			= 	"images/compare.jpg";   
						$data['odometer']['nameimage']		= 	"odometer";
						$data['ABCpedals']['image']			= 	"images/compare.jpg";   
						$data['ABCpedals']['nameimage']		= 	"ABCpedals";
						$data['frontdoor']['image']			= 	"images/compare.jpg";   
						$data['frontdoor']['nameimage']		= 	"frontdoor";
						$data['frontright_tyre']['image']	= 	"images/compare.jpg";   
						$data['frontright_tyre']['nameimage']= 	"frontright_tyre";
						$data['rearright_tyre']['image']	= 	"images/compare.jpg";   
						$data['rearright_tyre']['nameimage']= 	"rearright_tyre";
						$data['Boot_Dicky']['image']		= 	"images/compare.jpg";   
						$data['Boot_Dicky']['nameimage']	= 	"Boot_Dicky";
						$data['FrontLeft_Tyre']['image']	= 	"images/compare.jpg";   
						$data['FrontLeft_Tyre']['nameimage']= 	"FrontLeft_Tyre";
						$data['Odometer_reading']['image']	= 	"images/compare.jpg";   
						$data['Odometer_reading']['nameimage']= 	"Odometer_reading";
					}		
					$data['car_id']         	= 	$uservalue->car_id;
					$data['inventory_type']     = 	$uservalue->inventory_type;
					$data['dealer_id']         	= 	$uservalue->dealer_id;
					$data['price']         		= 	$uservalue->price;
					$data['kms_done']         	= 	$uservalue->kms_done;
					$data['registration_year']  = 	$uservalue->registration_year;
					switch($uservalue->owner_type)
					{
						case 'FIRST':
						$data['owner_type']       = 	"1";
						break;
						case 'SECOND':
						$data['owner_type']       = 	"2";
						break;
						case 'THIRD':
						$data['owner_type']       = 	"3";
						break;	
						case 'Fourth':
						$data['owner_type']       = 	"4";
						break;	
						case 'Four +':
						$data['owner_type']       = 	"4 +";
						break;							
					}
					$makewhere					=	array($this->masterMakeIdfiled=>$uservalue->make);
					$getmake 	 				=	inventorymodel::masterschema_table_where(
																				$this->masterMakeTable,
																				$makewhere);
					$data['make'] 				=	((count($getmake)>=1)?$getmake[0]->makename:'');
					$modelwhere					=	array('model_id'=>$uservalue->model_id);
					$getmodel 	 				=	inventorymodel::masterschema_table_where(
																				$this->masterModelsTable,
																				$modelwhere);
					$data['model'] 				=	((count($getmodel)>=1)?$getmodel[0]->model_name:'');
					$varientwhere				=	array('variant_id'=>$uservalue->variant);
					$getvarient 	 			=	inventorymodel::masterschema_table_where(
																				$this->MasterVariantTable,
																				$varientwhere);
					$data['varient'] 			=	((count($getvarient)>=1)?$getvarient[0]->variant_name:'');
					$colorwhere					=	array('colour_id'=>$uservalue->colors);
					$getcolor 	 				=	inventorymodel::masterschema_table_where(
																				'master_colors',
																				$colorwhere);																																															
					$data['fuel_type']         	= 	$uservalue->fuel_type;
					
					$citywhere					=	array('city_id'=>$uservalue->car_city);
					$getcity 	 				=	inventorymodel::masterschema_table_where(
																				'master_city',
																				$citywhere);
					$data['city'] 				=	((count($getcity)>=1)?$getcity[0]->city_name:'');
					$waterwhere					=	array('d_id'=>$id);
					$getwaterlogo 	 			=	inventorymodel::masterschema_table_where(
																				$this->masterMainLoginTable,
																				$waterwhere);
					$data['company_logo'] 		=	((count($getwaterlogo)>=1)?$getwaterlogo[0]->company_logo:'');
					$dealerplan      			= 	inventorymodel::getdealerplan($id);
					$data['watermark_logo'] 	=	"";
					if(!empty($dealerplan) && count($dealerplan) >= 1)
					{
						$dealerplans     		= 	$dealerplan->plan_type_id;
						
						if($dealerplans !== 1)
						{
							$dealer_deatails 			= 	dealermodel::dealerprofile($id);
							$data['watermark_logo']		= 	$dealer_deatails->watermark_logo;   
						}
						else
						{
							$data['watermark_logo'] 	= 	url(Config::get('common.watermark'));   
						}
					}
					
					//$data['watermark_logo'] 	=	((count($getwaterlogo)>=1)?$getwaterlogo[0]->watermark_logo:'');
					$data['mobile'] 			=	((count($getwaterlogo)>=1)?$getwaterlogo[0]->d_mobile:'');
					$data['transmission'] 		=	$uservalue->transmission;
					array_push($queriesdata, $data); 
				}
				return response()->json(['Result'=>'1',
								'message'=>'success',
								'basic_infoimage'=>$queriesdata
								]);
			}
			return response()->json(['Result'=>'0',
								'message'=>'No Records'
								]);																
		}
		return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
		
    }
   
    /*THIS FUNCTION USED FOR VIEW BASIC INFO WHEN UPLOAD IMAGES*/
    public function doApiImageupload()
    {          
        $id 					= 	Input::get('session_user_id');
        $car_id 				= 	Input::get('car_id');
		$imageTypeData          = 	Input::get('imageTypeData');        
		$userimage              = 	Input::get('image');
		$position               = 	Input::get('position');
		$number                 = 	Input::get('number');
		$watermark_image        = 	Input::get('watermark_logo');
		
        if($id == "" || $car_id	==	"" || $imageTypeData == "" || $position == "" || $number == "" || $watermark_image =="")
        {
			return response()->json(['Result'=>'0',
									'message'=>'All fields are required!!'
									]);
		}
		$schemaname 	=  $this->getschemaname($id);
		if(!empty($schemaname))
		{
			$where				=	array('profile_pic_name'=>$imageTypeData,'car_id'=>$car_id);
			$checkiamgeexists 	= 	schemamodel::schema_countwhere($schemaname,
															$this->DmsCarListPhotosTable,
															$where
															); 
			if(!empty($userimage))
			{
				$base64_img_array   =   explode(':', $userimage);
				$img_info           =   explode(',', end($base64_img_array));
				$img_file_extension = '';
				if (!empty($img_info)) {
					switch ($img_info[0]) {
						case 'image/jpeg;base64':
							$img_file_extension = 'jpeg';
							break;
						case 'image/jpg;base64':
							$img_file_extension = 'jpg';
							break;
						case 'image/gif;base64':
							$img_file_extension = 'gif';
							break;
						case 'image/png;base64':
							$img_file_extension = 'png';
							break;
					}
				}
				
				$nameofimage   		= 	rand(23232,99999).'.'.$img_file_extension;
				$uploadPath      	= 	"uploadimages/".$schemaname."/photos/";
				$img_file_name   	= 	public_path().'/'.$uploadPath.$nameofimage;
				$img_file        	= 	file_put_contents($img_file_name, base64_decode($img_info[1]));
				$img_file_name   	= 	fileuploadmodel::imageresize($img_file_name);
				$water_mark      	= 	fileuploadmodel::watermark($img_file_name,$position,$watermark_image,$number);             
				$realpath       	= 	url('uploadimages'.'/'.$schemaname.'/photos/'.$nameofimage);            
				if(!empty($car_id) && !empty($imageTypeData))
				{
					if(!empty($checkiamgeexists) && count($checkiamgeexists))
					{
						$result 	= 	Storage::delete("/uploadimages/".$schemaname."/inventory/".$id.'/listing_images/'.$checkiamgeexists[0]->photo_link);
						sleep(2);
						$result 	= 	Storage::put("/uploadimages/".$schemaname."/inventory/".$id.'/listing_images/'.$nameofimage, file_get_contents($realpath),'public');                       
						unlink($img_file_name);             
						$updateData = array (
										'profile_pic_name'=>$imageTypeData,
										'photo_link'=>$nameofimage,
										'photo_link_fullpath'=>$realpath, 
										'folder_path'=>'',  
										's3_bucket_path'=>Config::get('common.s3bucketpath').$schemaname."/inventory/".$id.'/listing_images/'.$nameofimage
									);
						
						$whereupdate 		=  	array('car_id'=>$car_id,'profile_pic_name'=>$imageTypeData);
						$Profile_pic_where 	= 	array('profile_pic_name'=>$imageTypeData);
						$insertimage     	= 	schemamodel::dealerUpdateTableDetails($schemaname,
																	$this->DmsCarListPhotosTable,
																	$whereupdate,
																	$updateData
																	);
						return response()->json(['Result'=>'1',
									'message'=>'success',
									'Image_upload'=>'Updated Successfully'
									]);                  
					}   
					else
					{
						$result 		= 	Storage::put("/uploadimages/".$schemaname."/inventory/".$id.'/listing_images/'.$nameofimage, file_get_contents($realpath),'public');                        
						unlink($img_file_name);
						$InsertData 	= 	array (
												'car_id'=>$car_id,
												'profile_pic_name'=>$imageTypeData,
												'photo_link'=>$nameofimage,
												'photo_link_fullpath'=>$realpath, 
												'folder_path'=>'',                  
												's3_bucket_path'=>Config::get('common.s3bucketpath').$schemaname."/inventory/".$id.'/listing_images/'.$nameofimage,
												);        
						$insertimage	= 	schemamodel::InsertTable($id,$schemaname,
																$this->DmsCarListPhotosTable,
																$InsertData
																);
						return response()->json(['Result'=>'1',
									'message'=>'success',
									'Image_upload'=>'Inserted Successfully'
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
		return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
		
    }
    /*THIS FUNCTION USED FOR CHECK DOCUMENT IS EXIST OR NOT*/
    public function doApiViewDocumentdetails()
    {          
        $id 						= 	Input::get('session_user_id');
        $car_id 					= 	Input::get('car_id');
        if($id == "" || $car_id	==	"")
        {
			return response()->json(['Result'=>'0',
									'message'=>'User and car id is required!!'
									]);
		}
		$schemaname 	=  $this->getschemaname($id);
		if(!empty($schemaname))
		{
			$wherecon 		=	array('car_id'=>$car_id);
			$getresult 		=	inventorymodel::dealerFetchTableDetails($schemaname,
															$this->DmsCarListDocumentTable,
															$wherecon
															);	
			$queriesdata 	= 	array();
			$profilephotos	=	array('0','1','2','3','4','5');
			if(!empty($getresult) && count($getresult) >= 1)
			{
				foreach($getresult as $key=>$uservalue)
				{
					$data['documentno'] 		= 	$uservalue->document_number;
					$data['documentname'] 		= 	$uservalue->document_link;
					$data['documentdownload'] 	= 	$uservalue->s3_bucket_path;
					$array[]	=	$uservalue->document_number;
					
					array_push($queriesdata, $data);
				}
				$notmatchphotos		=	array_diff($profilephotos,$array);
				foreach($notmatchphotos as $photos)
				{
					$data['documentno'] 		= 	$photos;
					$data['documentname'] 		= 	"";
					$data['documentdownload'] 	= 	"";
					array_push($queriesdata, $data);
				}
				return response()->json(['Result'=>'1',
						'message'=>'success',
						'basicdocument'=>$queriesdata
						]);
			}
			else
			{
				foreach($profilephotos as $photos)
				{
					$data['documentno'] 		= 	$photos;
					$data['documentname'] 		= 	"";
					$data['documentdownload'] 	= 	"";
					array_push($queriesdata, $data);
				}
				return response()->json(['Result'=>'1',
						'message'=>'success',
						'basicdocument'=>$queriesdata
						]);
			}
		}
		return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
		
    }
    
    /*THIS FUNCTION USED UPLOAD DOCUMENTS*/
    public function doApiDocumentupload()
    {          
        $id 		= 	Input::get('session_user_id');
        $car_id 	= 	Input::get('car_id');
		$document  	= 	Input::file('document');
        if($id == "" || $car_id	==	"")
        {
			return response()->json(['Result'=>'0',
									'message'=>'All fields are required!!'
									]);
		}
		$schemaname 	=  $this->getschemaname($id);
		if(!empty($schemaname))
		{
			if(!empty($document))
			{
				$data 			=	"";
				$checkformat 	=	"";
				foreach($document as $key=>$documentname)
				{
					$checkformat 	=	$documentname->getClientOriginalExtension();
					if($checkformat == "jpg" || $checkformat == "jpeg" || $checkformat == "png" || $checkformat == "pdf"  || $checkformat == "docx" || $checkformat == "doc")
					{
						$WhereDcoument 		= 	array('car_id'=>$car_id,'document_number'=>$key);
						$getresult 			=	inventorymodel::dealerFetchTableDetails($schemaname,
															$this->DmsCarListDocumentTable,
															$WhereDcoument
															);	
						$extension   		= 	$documentname->getClientOriginalExtension();
						$destinationPath   	= 	"uploadimages/".$schemaname."/documents";
						if(count($getresult) <=	0)
						{
							$image_upload_result	= 	fileuploadmodel::any_upload($documentname,$destinationPath,$extension);
							$fileContents 			= 	public_path("/uploadimages/".$schemaname."/documents/").$image_upload_result;
							$result 				= 	Storage::put("/uploadimages/".$schemaname.'/inventory/'.$car_id."/documents/".$image_upload_result, 
														file_get_contents($fileContents),
														'public');
							$s3_bucket_path 	=	'https://s3-ap-southeast-1.amazonaws.com/dealerplus/uploadimages/'.$schemaname.'/inventory/'.$car_id.'/documents/'.$image_upload_result;
							unlink($fileContents);
							$InsertDocuments      	= 	array('car_id'=>$car_id, 
														  'inventory_primary_id'=>'',
														  'document_number'=>$key, 
														  'document_link'=>$image_upload_result,
														  'full_folder_path'=>url("/uploadimages/".$schemaname."/documents/".$image_upload_result),     
														  'folder_path'=>url("/uploadimages/".$schemaname."/documents/".$image_upload_result),
														  's3_bucket_path'=>$s3_bucket_path,      
														  );
							$data[$key]		=	stripcslashes($s3_bucket_path);
							inventorymodel::dealerInsertTable($schemaname,
																$this->DmsCarListDocumentTable,
																$InsertDocuments
																);
						}
						else
						{
							Storage::delete("/uploadimages/".$schemaname.'/inventory/'.$car_id."/documents/".$getresult[0]->document_link);
							$image_upload_result  	= 	fileuploadmodel::any_upload($documentname,$destinationPath,$extension);

							$fileContents 	= 	public_path("/uploadimages/".$schemaname."/documents/").$image_upload_result;
							$result 		= 	Storage::put("/uploadimages/".$schemaname.'/inventory/'.$car_id."/documents/".$image_upload_result, file_get_contents($fileContents),'public');
							$s3_bucket_path =	'https://s3-ap-southeast-1.amazonaws.com/dealerplus/uploadimages/'.$schemaname.'/inventory/'.$car_id.'/documents/'.$image_upload_result;
							unlink($fileContents);
							$InsertDocuments      = array('car_id'=>$car_id, 
														  'inventory_primary_id'=>'',
														  'document_number'=>$key, 
														  'document_link'=>$image_upload_result,
														  'full_folder_path'=>url("/uploadimages/".$schemaname."/documents/".$image_upload_result),     
														  'folder_path'=>url("/uploadimages/".$schemaname."/documents/".$image_upload_result),
														  's3_bucket_path'=>$s3_bucket_path,      
														  );
							$data[$key]		=	stripcslashes($s3_bucket_path);
							$WhereDcoument	= 	array('car_id' => $car_id,'document_id' =>$getresult[0]->document_id);
							
							inventorymodel::dealerUpdateTableDetails(
												$id,
												$schemaname,
												$this->DmsCarListDocumentTable,
												$WhereDcoument,
												$InsertDocuments
												);
						}
					}
					else
					{
						if($key== 0)
						{
							return response()->json(['Result'=>'0',
										'message'=>'Rc Document is UnSupported File.Supported Formats are doc,docx,pdf,jpg,jpeg,png!!'
										]);
						}
						else if($key== 1)
						{
							return response()->json(['Result'=>'0',
										'message'=>'Insurance Document is UnSupported File.Supported Formats are doc,docx,pdf,jpg,jpeg,png!!'
										]);
						}
						else if($key== 2)
						{
							return response()->json(['Result'=>'0',
										'message'=>'Rto Document is UnSupported File.Supported Formats are doc,docx,pdf,jpg,jpeg,png!!'
										]);
						}
						else if($key== 3)
						{
							return response()->json(['Result'=>'0',
										'message'=>'FC Document is UnSupported File.Supported Formats are doc,docx,pdf,jpg,jpeg,png!!'
										]);
						}
						else if($key== 4)
						{
							return response()->json(['Result'=>'0',
										'message'=>'NOC Document is UnSupported File.Supported Formats are doc,docx,pdf,jpg,jpeg,png!!'
										]);
						}
						else
						{
							return response()->json(['Result'=>'0',
										'message'=>'Permit Document is UnSupported File.Supported Formats are doc,docx,pdf,jpg,jpeg,png!!'
										]);
						}
					}
				}
				return response()->json(['Result'=>'1',
										'message'=>'Successfully Uploaded!!',
										'document'=>$data
										]);
			}
			return response()->json(['Result'=>'0',
										'message'=>'Please Upload document!!'
										]);
		}
		return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
		
    }
      //ADD INVENTORY LISTING SUBMIT FUNCTION
    public function doApilistingsubmitcheckprice()
    {   
        $id 						= 	Input::get('session_user_id');
        $car_id 					= 	Input::get('car_id');
        if($id == "" || $car_id	==	"")
        {
			return response()->json(['Result'=>'0',
									'message'=>'User and car id is required!!'
									]);
		}
		$schemaname 	=  $this->getschemaname($id);
		if(!empty($schemaname))
		{
			$wherecar 			=	array('car_id'=>$car_id);
			$getresult 			=	inventorymodel::inventoryImageDetails($schemaname,
															'dms_car_listings',
															$wherecar
															);
			$getresultprice 	= 	(count($getresult)>=1?$getresult[0]->price:'');
			return response()->json(['Result'=>'1',
								'message'=>'success',
								'price'=>$getresultprice
								]);
			
		}
		return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
		
    }
    
    /*THIS FUNCTION USED FOR CHECK Hypothacation IS EXIST OR NOT*/
    public function doApiViewHypothacation()
    {          
        $id 						= 	Input::get('session_user_id');
        $car_id 					= 	Input::get('car_id');
        if($id == "" || $car_id	==	"")
        {
			return response()->json(['Result'=>'0',
									'message'=>'User and car id is required!!'
									]);
		}
		$schemaname 	=  $this->getschemaname($id);
		if(!empty($schemaname))
		{
			$wherecon 		=	array('listing_id'=>$car_id);
			$getresult 		=	inventorymodel::dealerFetchTableDetails($schemaname,
															'dealer_hypothacation_details',
															$wherecon
															);	
			if(!empty($getresult) && count($getresult) >= 1)
			{
				foreach($getresult as $key=>$uservalue)
				{
					$data['hypotype'] 		= 	$uservalue->hypothacation_type;
					$data['financiername'] 	= 	$uservalue->finacier_name;
					$data['fullname'] 		= 	$uservalue->fla_finacier_name;
					$data['from_date'] 		= 	Carbon::parse($uservalue->from_date)->format('Y-m-d');
				}
			}
			else
			{
				$data['hypotype'] 		= 	"";
				$data['financiername'] 	= 	"";
				$data['fullname'] 		= 	"";
				$data['from_date'] 		= 	"";
			}
			$getresultins 		=	inventorymodel::dealerFetchTableDetails($schemaname,
															'dealer_insurance_details',
															$wherecon
															);	
			if(!empty($getresultins) && count($getresultins) >= 1)
			{
				foreach($getresultins as $key=>$uservalue)
				{
					$data['company'] 		= 	$uservalue->comp_cd_desc;
					$data['fullinsurname'] 	= 	$uservalue->fla_insurance_name;
					$data['typedesc'] 		= 	$uservalue->insurance_type_desc;
					$data['frominsurance'] 	= 	Carbon::parse($uservalue->insurance_from)->format('Y-m-d');
					$data['uptoinsurance'] 	= 	Carbon::parse($uservalue->insurance_upto)->format('Y-m-d');
				}
			}
			else
			{
				$data['company'] 		= 	"";
				$data['fullinsurname'] 	= 	"";
				$data['typedesc'] 		= 	"";
				$data['frominsurance'] 	= 	"";
				$data['uptoinsurance'] 	= 	"";
			}
			return response()->json(['Result'=>'1',
						'message'=>'success',
						'basicinsurance'=>[$data]
						]);
		}
		return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
		
    }
    
    /*THIS FUNCTION USED FOR ADD Hypothacation*/
    public function doApiAddHypothacation()
    {          
        $id 						= 	Input::get('session_user_id');
        $car_id 					= 	Input::get('car_id');
        $hypotype 					= 	Input::get('hypotype');
        $financiername 				= 	Input::get('financiername');
        $fullname 					= 	Input::get('fullname');
        $fromdate 					= 	Input::get('fromdate');
        $insurancecompany 			= 	Input::get('insurancecompany');
        $insurancename 				= 	Input::get('insurancename');
        $insurancetype 				= 	Input::get('insurancetype');
        $frominsurancedate 			= 	Input::get('frominsurancedate');
        $uptodate 					= 	Input::get('uptodate');
        if($id == "" || $car_id	==	"")
        {
			return response()->json(['Result'=>'0',
									'message'=>'User and car id is required!!'
									]);
		}
		$schemaname 	=  $this->getschemaname($id);
		if(!empty($schemaname))
		{
			$wherecon 		=	array('listing_id'=>$car_id);
			$getresult 		=	inventorymodel::dealerFetchTableDetails($schemaname,
															'dealer_hypothacation_details',
															$wherecon
															);
			$hypomessage 	= 	"";
			$insurmessage 	= 	"";	
			if(!empty($getresult) && count($getresult) >= 1)
			{
				$hypomessage 	=	"Hypotication Updated successfully";
				$updatehypo     = 	array( 
										  'hypothacation_type'=>$hypotype,
										  'finacier_name'=>$financiername, 
										  'fla_finacier_name'=>$fullname,
										  'from_date'=>$fromdate
										  );
				$Where		= 	array('listing_id' => $car_id);
				inventorymodel::dealerUpdateTableDetails(
									$id,
									$schemaname,
									'dealer_hypothacation_details',
									$Where,
									$updatehypo
									);
			}
			else
			{
				$hypomessage 	=	"Hypotication Inserted Successfully";
				$updatehypo	= 	array('listing_id'=>$car_id, 
										'hypothacation_type'=>$hypotype,
										'finacier_name'=>$financiername, 
										'fla_finacier_name'=>$fullname,
										'from_date'=>$frominsurancedate
									  );
				inventorymodel::dealerInsertTable($schemaname,
												'dealer_hypothacation_details',
												$updatehypo
												);
			}
			//insurance insert and update
			$whereinsurance 	=	array('listing_id'=>$car_id);
			$getinsresult 		=	inventorymodel::dealerFetchTableDetails($schemaname,
															'dealer_insurance_details',
															$whereinsurance
															);	
			if(!empty($getinsresult) && count($getinsresult) >= 1)
			{
				$insurmessage 	= 	"Insurance Updated successfully";	
				$updatehypo     = 	array( 
										  'comp_cd_desc'=>$insurancecompany,
										  'fla_insurance_name'=>$insurancename, 
										  'insurance_type_desc'=>$insurancetype,
										  'insurance_from'=>$frominsurancedate,
										  'insurance_upto'=>$uptodate
										  );
				$Where		= 	array('listing_id' => $car_id);
				inventorymodel::dealerUpdateTableDetails(
									$id,
									$schemaname,
									'dealer_insurance_details',
									$Where,
									$updatehypo
									);
			}
			else
			{
				$insurmessage 	= 	"Insurance Inserted Successfully";
				$updatehypo     = 	array(
											'listing_id'=>$car_id,
										  'comp_cd_desc'=>$insurancecompany,
										  'fla_insurance_name'=>$insurancename, 
										  'insurance_type_desc'=>$insurancetype,
										  'insurance_from'=>$fromdate,
										  'insurance_upto'=>$uptodate
										  );
				inventorymodel::dealerInsertTable($schemaname,
												'dealer_insurance_details',
												$updatehypo
												);
			}
			return response()->json(['Result'=>'1',
						'hypomessage'=>$hypomessage,
						'insmessage'=>$insurmessage
						]);
		}
		return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
		
    }
    
    /*THIS FUNCTION USED FOR CHECK CERTIFICATION AND WARRANTY IS EXIST OR NOT*/
    public function doApiViewcertificatewarranty()
    {    		
        $id 						= 	Input::get('session_user_id');
        $car_id 					= 	Input::get('car_id');
        if($id == "" || $car_id	==	"")
        {
			return response()->json(['Result'=>'0',
									'message'=>'User and car id is required!!'
									]);
		}
		$schemaname 	=  $this->getschemaname($id);
		if(!empty($schemaname))
		{
			$wherecon 		=	array('listing_id'=>$car_id);
			$getresult 		=	inventorymodel::dealerFetchTableDetails($schemaname,
															'dms_listing_certification_warranty_inspection',
															$wherecon
															);	
			$queriesdata 	= 	array();
			if(!empty($getresult) && count($getresult) >= 1)
			{
				foreach($getresult as $key=>$uservalue)
				{
					switch($uservalue->inspectionagency)
					{
						case 1:
						$data['inspectionagency'] 	= 	"Self";
						$data['inspectionagencyid'] = 	$uservalue->inspectionagency;
						break;
						case 2:
						$data['inspectionagency'] 	= 	"TrustMark";
						$data['inspectionagencyid'] = 	$uservalue->inspectionagency;
						break;
						case 3:
						$data['inspectionagency'] 	= 	"Others";
						$data['inspectionagencyid'] = 	$uservalue->inspectionagency;
						break;
						default:
						$data['inspectionagency'] 	= 	"";
						$data['inspectionagencyid'] = 	"";
						break;
					}
					
					$data['inspectiondate'] 	= 	$uservalue->inspectiondate;
					$data['certificateid'] 		= 	$uservalue->certificateid;
					$data['certificateurl'] 	= 	$uservalue->certificateurl;
					$data['certificatereport'] 	= 	($uservalue->certificatereport == null?'':$uservalue->certificatereport);
					switch($uservalue->serviceagency)
					{
						case 1:
						$data['serviceagency'] 	= 	"Self";
						$data['serviceagencyid']= 	$uservalue->serviceagency;
						break;
						case 2:
						$data['serviceagency'] 	= 	"Others";
						$data['serviceagencyid']= 	$uservalue->serviceagency;
						break;
						default:
						$data['serviceagency'] 	= 	"";
						$data['serviceagencyid'] = 	"";
						break;
					}
					$data['servicedate'] 		= 	$uservalue->servicedate;
					$data['serviceid'] 			= 	$uservalue->serviceid;
					$data['serviceurl'] 		= 	$uservalue->serviceurl;
					$data['servicereport'] 		= 	($uservalue->servicereport == null?'':$uservalue->servicereport);
					array_push($queriesdata, $data);
				}
				return response()->json(['Result'=>'1',
						'message'=>'success',
						'basiccertificate'=>$queriesdata
						]);
			}
			else
			{
				$data['inspectionagency'] 	= 	"";
				$data['inspectionagencyid'] = 	"";
				$data['inspectiondate'] 	= 	"";
				$data['certificateid'] 		= 	"";
				$data['certificateurl'] 	= 	"";
				$data['certificatereport'] 	= 	"";
				$data['serviceagency'] 		= 	"";
				$data['serviceagencyid'] 	= 	"";
				$data['servicedate'] 		= 	"";
				$data['serviceid'] 			= 	"";
				$data['serviceurl'] 		= 	"";
				$data['servicereport'] 		= 	"";
				return response()->json(['Result'=>'1',
						'message'=>'success',
						'basiccertificate'=>[$data]
						]);
			}
		}
		return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
    }
    /*THIS FUNCTION USED FOR ADD Certificatewarranty*/
    public function doApiAddcertificatewarranty()
    {          
        $id 						= 	Input::get('session_user_id');
        $car_id 					= 	Input::get('car_id');
        $inspectionagency 			= 	Input::get('inspectionagency');
        $inspectiondate 			= 	Input::get('inspectiondate');
        $certificateid 				= 	Input::get('certificateid');
        $certificateurl 			= 	Input::get('certificateurl');
        $certificatereport 			= 	Input::file('certificatereport');
        $serviceagency 				= 	Input::get('serviceagency');
        $servicedate 				= 	Input::get('servicedate');
        $serviceid 					= 	Input::get('serviceid');
        $serviceurl 				= 	Input::get('serviceurl');
        $servicereport 				= 	Input::file('servicereport');
        if($id == "" || $car_id	==	"")
        {
			return response()->json(['Result'=>'0',
									'message'=>'User and car id is required!!'
									]);
		}
		$schemaname 	=  $this->getschemaname($id);
		if(!empty($schemaname))
		{
			$wherecon 		=	array('listing_id'=>$car_id);
			$getresult 		=	inventorymodel::dealerFetchTableDetails($schemaname,
															'dms_listing_certification_warranty_inspection',
															$wherecon
															);
			$certificatereportdocument 	=	"";
			$servicereportdocument 	=	"";
			if(!empty($certificatereport))
			{
				$checkformat 	=	$certificatereport->getClientOriginalExtension();
				if($checkformat == "jpg" || $checkformat == "jpeg" || $checkformat == "png" || $checkformat == "pdf"  || $checkformat == "docx" || $checkformat == "doc")
				{
					$extension   		= 	$certificatereport->getClientOriginalExtension();
					$destinationPath   	= 	"uploadimages/".$schemaname."/documents";
					$image_upload_result= 	fileuploadmodel::any_upload($certificatereport,$destinationPath,$extension);
					$fileContents       = 	public_path("/uploadimages/".$schemaname."/documents/").$image_upload_result;
					$result             = 	Storage::put("/uploadimages/".$schemaname.'/inventory/'.$car_id."/certificatedocuments/".$image_upload_result, file_get_contents($fileContents),'public');
					unlink($fileContents);
					$s3_bucket_path 	=	'https://s3-ap-southeast-1.amazonaws.com/dealerplus/uploadimages/'.$schemaname.'/inventory/'.$car_id.'/certificatedocuments/'.$image_upload_result;
					$certificatereportdocument 	=	$s3_bucket_path;
				}
				else
				{
						return response()->json(['Result'=>'1',
									'message'=>'Certificate report is UnSupported File.Supported Formats are doc,docx,pdf,jpg,jpeg,png!!'
									]);
				}
			}
			if(!empty($servicereport))
			{
				$checkformat 	=	$servicereport->getClientOriginalExtension();
				if($checkformat == "jpg" || $checkformat == "jpeg" || $checkformat == "png" || $checkformat == "pdf"  || $checkformat == "docx" || $checkformat == "doc")
				{
					$extension   		= 	$servicereport->getClientOriginalExtension();
					$destinationPath   	= 	"uploadimages/".$schemaname."/documents";
					$image_upload_result= 	fileuploadmodel::any_upload($servicereport,$destinationPath,$extension);
					$fileContents       = 	public_path("/uploadimages/".$schemaname."/documents/").$image_upload_result;
					$result             = 	Storage::put("/uploadimages/".$schemaname.'/inventory/'.$car_id."/certificatedocuments/".$image_upload_result, file_get_contents($fileContents),'public');
					unlink($fileContents);
					$s3_bucket_path 	=	'https://s3-ap-southeast-1.amazonaws.com/dealerplus/uploadimages/'.$schemaname.'/inventory/'.$car_id.'/certificatedocuments/'.$image_upload_result;
					$servicereportdocument 	=	$s3_bucket_path;
				}
				else
				{
						return response()->json(['Result'=>'1',
									'message'=>'Service warranty Certificate report is UnSupported File.Supported Formats are doc,docx,pdf,jpg,jpeg,png!!'
									]);
				}
			}
			
					
			if(!empty($getresult) && count($getresult) >= 1)
			{
				$getcertidocument 	= 	$getresult[0]->certificatereport;
				$getservdocument 	= 	$getresult[0]->servicereport;
				if($certificatereportdocument 	==	"")
				{
					$certificatereportdocument 	=	$getcertidocument;
				}
				if($servicereportdocument 	==	"")
				{
					$servicereportdocument 	=	$getservdocument;
				}
				$updatehypo      	= 	array( 
										  'inspectionagency'=>$inspectionagency,
										  'inspectiondate'=>$inspectiondate, 
										  'certificateid'=>$certificateid,
										  'certificateurl'=>$certificateurl,
										  'serviceagency'=>$serviceagency,
										  'servicedate'=>$servicedate,
										  'serviceid'=>$serviceid,
										  'serviceurl'=>$serviceurl,
										  'certificatereport'=>$certificatereportdocument,
										  'servicereport'=>$servicereportdocument,
										  'user_id'=>$id
										  );
				$Where		= 	array('listing_id' => $car_id);
				inventorymodel::dealerUpdateTableDetails(
									$id,
									$schemaname,
									'dms_listing_certification_warranty_inspection',
									$Where,
									$updatehypo
									);
				return response()->json(['Result'=>'1',
						'message'=>'Updated successfully'
						]);
			}
			else
			{
				$updatehypo      = 	array( 
											'listing_id'=>$car_id,
										  'inspectionagency'=>$inspectionagency,
										  'inspectiondate'=>$inspectiondate, 
										  'certificateid'=>$certificateid,
										  'certificateurl'=>$certificateurl,
										  'serviceagency'=>$serviceagency,
										  'servicedate'=>$servicedate,
										  'serviceid'=>$serviceid,
										  'serviceurl'=>$serviceurl,
										  'certificatereport'=>$certificatereport,
										  'servicereport'=>$servicereport,
										  'user_id'=>$id
										  );
				inventorymodel::dealerInsertTable($schemaname,
												'dms_listing_certification_warranty_inspection',
												$updatehypo
												);
				return response()->json(['Result'=>'1',
						'message'=>'Inserted Successfully'
						]);
			}
		}
		return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
    }
    
    /*THIS FUNCTION USED FOR CHECK Engine specification and features IS EXIST OR NOT*/
    public function doApiViewenginefeatures()
    {          
        $id 						= 	Input::get('session_user_id');
        $car_id 					= 	Input::get('car_id');
        if($id == "" || $car_id	==	"")
        {
			return response()->json(['Result'=>'0',
									'message'=>'User and car id is required!!'
									]);
		}
		$schemaname 	=  $this->getschemaname($id);
		if(!empty($schemaname))
		{
			$wherecon 		=	array('listing_id'=>$car_id);
			$getresult 		=	inventorymodel::dealerFetchTableDetails($schemaname,
															'dealer_listing_features',
															$wherecon
															);	
			if(!empty($getresult) && count($getresult) >= 1)
			{
				foreach($getresult as $key=>$uservalue)
				{
					//car specification
					$spec['Gear Box'] 			= 	$uservalue->gear_box;
					$spec['Drive type'] 		= 	$uservalue->drive_type;
					$spec['Seating Capacity'] 	= 	$uservalue->seating_capacity;
					$spec['Steering type'] 		= 	$uservalue->steering_type;
					$spec['Turning Radius'] 	= 	$uservalue->turning_radius;
					$spec['Top Speed'] 			= 	$uservalue->top_speed;
					$spec['Acceleration'] 		= 	$uservalue->acceleration;
					$spec['Tyre type'] 			= 	$uservalue->tyre_type;
					$spec['No of doors'] 		= 	$uservalue->no_of_doors;
					//engine specification
					$engine['Engine Type'] 		= 	$uservalue->engine_type;
					$engine['Displacement'] 	= 	$uservalue->displacement;
					$engine['Max Power'] 		= 	$uservalue->max_power;
					$engine['Max Torque'] 		= 	$uservalue->max_torque;
					$engine['No Of Cylinder'] 	= 	$uservalue->no_of_cylinder;
					$engine['Valves per Cylinder'] 	= 	$uservalue->valves_per_cylinder;
					$engine['Valve configuration'] 	= 	$uservalue->valve_configuration;
					$engine['Fuel Supply System'] 	= 	$uservalue->fuel_supply_system;
					$engine['Turbo Charger'] 	= 	$uservalue->turbo_charger;
					$engine['Super Charger'] 	= 	$uservalue->super_charger;
					//DIMENSIONS
					$dimensions['Length'] 		= 	$uservalue->length;
					$dimensions['Width'] 		= 	$uservalue->width;
					$dimensions['Height'] 		= 	$uservalue->height;
					$dimensions['Wheel Base'] 	= 	$uservalue->wheel_base;
					$dimensions['Gross Weight'] = 	$uservalue->gross_weight;
					//Car Interior
					$interior['Air Conditioner'] 		= 	$uservalue->air_conditioner;
					$interior['Adjustable Steering']	= 	$uservalue->adjustable_steering;
					$interior['Leather Steering Wheel'] = 	$uservalue->leather_steering_wheel;
					$interior['Heater'] 				= 	$uservalue->heater;
					$interior['Digital Clock'] 			= 	$uservalue->digital_clock;
					//Car Comfort
					$comfort['Power steering'] 			= 	$uservalue->power_steering;
					$comfort['Power windows front'] 	= 	$uservalue->power_windows_front;
					$comfort['Power windows rear'] 		= 	$uservalue->power_windows_rear;
					$comfort['Remote trunk opener'] 	= 	$uservalue->remote_trunk_opener;
					$comfort['Remote fuel lid opener'] 	= 	$uservalue->remote_fuel_lid_opener;
					$comfort['Low fuel warning light'] 	= 	$uservalue->low_fuel_warning_light;
					$comfort['Rear reading lamp'] 		= 	$uservalue->rear_reading_lamp;
					$comfort['Rear seat headrest'] 		= 	$uservalue->rear_seat_headrest;
					$comfort['Rear seat centre arm rest'] 	= 	$uservalue->rear_seat_centre_arm_rest;
					$comfort['Height adjustable front seat belts'] = 	$uservalue->height_adjustable_front_seat_belts;
					$comfort['Cup holders front'] 		= 	$uservalue->cup_holders_front;
					$comfort['Cup holders rear'] 		= 	$uservalue->cup_holders_rear;
					$comfort['Rear ac vents'] 			= 	$uservalue->rear_ac_vents;
					$comfort['Parking sensors'] 		= 	$uservalue->parking_sensors;
					//Car Safety
					$safety['Anti lock braking system'] = 	$uservalue->anti_lock_braking_system;
					$safety['Central locking'] 			= 	$uservalue->central_locking;
					$safety['Child safety lock'] 		= 	$uservalue->child_safety_lock;
					$safety['Driver airbags'] 			= 	$uservalue->driver_airbags;
					$safety['Passenger airbag'] 		= 	$uservalue->passenger_airbag;
					$safety['Rear seat belts'] 			= 	$uservalue->rear_seat_belts;
					$safety['Seat belt warning'] 		= 	$uservalue->seat_belt_warning;
					$safety['Adjustable seats'] 		= 	$uservalue->adjustable_seats;
					$safety['Crash sensor'] 			= 	$uservalue->crash_sensor;
					$safety['Anti theft device'] 		= 	$uservalue->anti_theft_device;
					$safety['Immobilizer'] 				= 	$uservalue->immobilizer;
					//Car Exterior
					$exterior['Adjustable head lights'] = 	$uservalue->adjustable_head_lights;
					$exterior['Power adjustable exterior rear view mirror']	= 	$uservalue->power_adjustable_exterior_rear_view_mirror;
					$exterior['Electric folding rear view mirror'] = 	$uservalue->electric_folding_rear_view_mirror;
					$exterior['Rain sensing wipers'] 	= 	$uservalue->rain_sensing_wipers;
					$exterior['Rear window wiper'] 		= 	$uservalue->rear_window_wiper;
					$exterior['Alloy wheels'] 			= 	$uservalue->alloy_wheels;
					$exterior['Tinted glass'] 			= 	$uservalue->tinted_glass;
					$exterior['Front fog lights'] 		= 	$uservalue->front_fog_lights;
					$exterior['Rear window defogger'] 	= 	$uservalue->rear_window_defogger;
					//Car Entertainment
					$entertainment['CD Player'] 		= 	$uservalue->cdplayer;
					$entertainment['Radio']				= 	$uservalue->radio;
					$entertainment['Audio'] 			= 	$uservalue->audio;
					$entertainment['Bluetooth'] 		= 	$uservalue->bluetooth;
					//Car Overview
					$overview['Overview'] 				= 	$uservalue->overviewdescription;
				}
			}
			else
			{
				$spec['Gear Box'] 			= 	"";
				$spec['Drive type'] 		= 	"";
				$spec['Seating Capacity'] 	= 	"";
				$spec['Steering type'] 		= 	"";
				$spec['Turning Radius'] 	= 	"";
				$spec['Top Speed'] 			= 	"";
				$spec['Acceleration'] 		= 	"";
				$spec['Tyre type'] 			= 	"";
				$spec['No of doors'] 		= 	"";
				//engine specification
				$engine['Engine Type'] 		= 	"";
				$engine['Displacement'] 	= 	"";
				$engine['Max Power'] 		= 	"";
				$engine['Max Torque'] 		= 	"";
				$engine['No Of Cylinder'] 	= 	"";
				$engine['Valves per Cylinder'] 	= 	"";
				$engine['Valve configuration'] 	= 	"";
				$engine['Fuel Supply System'] 	= 	"";
				$engine['Turbo Charger'] 	= 	"";
				$engine['Super Charger'] 	= 	"";
				//DIMENSIONS
				$dimensions['Length'] 		= 	"";
				$dimensions['Width'] 		= 	"";
				$dimensions['Height'] 		= 	"";
				$dimensions['Wheel Base'] 	= 	"";
				$dimensions['Gross Weight'] = 	"";
				//Car Interior
				$interior['Air Conditioner'] 		= 	"";
				$interior['Adjustable Steering']	= 	"";
				$interior['Leather Steering Wheel'] = 	"";
				$interior['Heater'] 				= 	"";
				$interior['Digital Clock'] 			= 	"";
				//Car Comfort
				$comfort['Power steering'] 			= 	"";
				$comfort['Power windows front'] 	= 	"";
				$comfort['Power windows rear'] 		= 	"";
				$comfort['Remote trunk opener'] 	= 	"";
				$comfort['Remote fuel lid opener'] 	= 	"";
				$comfort['Low fuel warning light'] 	= 	"";
				$comfort['Rear reading lamp'] 		= 	"";
				$comfort['Rear seat headrest'] 		= 	"";
				$comfort['Rear seat centre arm rest'] 	= 	"";
				$comfort['Height adjustable front seat belts'] = 	"";
				$comfort['Cup holders front'] 		= 	"";
				$comfort['Cup holders rear'] 		= 	"";
				$comfort['Rear ac vents'] 			= 	"";
				$comfort['Parking sensors'] 		= 	"";
				//Car Safety
				$safety['Anti lock braking system'] = 	"";
				$safety['Central locking'] 			= 	"";
				$safety['Child safety lock'] 		= 	"";
				$safety['Driver airbags'] 			= 	"";
				$safety['Passenger airbag'] 		= 	"";
				$safety['Rear seat belts'] 			= 	"";
				$safety['Seat belt warning'] 		= 	"";
				$safety['Adjustable seats'] 		= 	"";
				$safety['Crash sensor'] 			= 	"";
				$safety['Anti theft device'] 		= 	"";
				$safety['Immobilizer'] 				= 	"";
				//Car Exterior
				$exterior['Adjustable head lights'] = 	"";
				$exterior['Power adjustable exterior rear view mirror']	= 	"";
				$exterior['Electric folding rear view mirror'] = 	"";
				$exterior['Rain sensing wipers'] 	= 	"";
				$exterior['Rear window wiper'] 		= 	"";
				$exterior['Alloy wheels'] 			= 	"";
				$exterior['Tinted glass'] 			= 	"";
				$exterior['Front fog lights'] 		= 	"";
				$exterior['Rear window defogger'] 	= 	"";
				//Car Entertainment
				$entertainment['CD Player'] 		= 	"";
				$entertainment['Radio']				= 	"";
				$entertainment['Audio'] 			= 	"";
				$entertainment['Bluetooth'] 		= 	"";
				//Car Overview
				$overview['Overview'] 				= 	"";
			}
			return response()->json(['Result'=>'1',
						'message'=>'success',
						'Car Specification'=>[$spec],
						'Car Engine'=>[$engine],
						'Dimensions'=>[$dimensions],
						'Car Interior'=>[$interior],
						'Car Comfort'=>[$comfort],
						'Safety'=>[$safety],
						'Car Exterior'=>[$exterior],
						'Entertainment'=>[$entertainment],
						'Overview'=>[$overview]
						]);
		}
		return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
		
    }
    
    /*THIS FUNCTION USED FOR ADD Hypothacation*/
    public function doApiAddenginefeatures()
    {          
        $id 						= 	Input::get('session_user_id');
        $car_id 					= 	Input::get('car_id');
        $gear_box 					= 	Input::get('gear_box');
        $drive_type 				= 	Input::get('drive_type');
        $seating_capacity 			= 	Input::get('seating_capacity');
        $steering_type 				= 	Input::get('steering_type');
        $turning_radius 			= 	Input::get('turning_radius');
        $top_speed 					= 	Input::get('top_speed');
        $acceleration 				= 	Input::get('acceleration');
        $tyre_type 					= 	Input::get('tyre_type');
        $no_of_doors 				= 	Input::get('no_of_doors');
        $engine_type 				= 	Input::get('engine_type');
        $displacement 				= 	Input::get('displacement');
        $max_power 					= 	Input::get('max_power');
        $max_torque 				= 	Input::get('max_torque');
        $no_of_cylinder 			= 	Input::get('no_of_cylinder');
        $valves_per_cylinder 		= 	Input::get('valves_per_cylinder');
        $valve_configuration 		= 	Input::get('valve_configuration');
        $fuel_supply_system 		= 	Input::get('fuel_supply_system');
        $turbo_charger 				= 	Input::get('turbo_charger');
        $super_charger 				= 	Input::get('super_charger');
        $length 					= 	Input::get('length');
        $width 						= 	Input::get('width');
        $height 					= 	Input::get('height');
        $wheel_base 				= 	Input::get('wheel_base');
        $gross_weight 				= 	Input::get('gross_weight');
        $air_conditioner 			= 	Input::get('air_conditioner');
        $adjustable_steering 		= 	Input::get('adjustable_steering');
        $leather_steering_wheel 	= 	Input::get('leather_steering_wheel');
        $heater 					= 	Input::get('heater');
        $digital_clock 				= 	Input::get('digital_clock');
        $power_steering 			= 	Input::get('power_steering');
        $power_windows_front 		= 	Input::get('power_windows_front');
        $power_windows_rear 		= 	Input::get('power_windows_rear');
        $remote_trunk_opener 		= 	Input::get('remote_trunk_opener');
        $remote_fuel_lid_opener 	= 	Input::get('remote_fuel_lid_opener');
        $low_fuel_warning_light 	= 	Input::get('low_fuel_warning_light');
        $rear_reading_lamp 			= 	Input::get('rear_reading_lamp');
        $rear_seat_headrest 		= 	Input::get('rear_seat_headrest');
        $rear_seat_centre_arm_rest 	= 	Input::get('rear_seat_centre_arm_rest');
        $height_adjustable_front_seat_belts = 	Input::get('height_adjustable_front_seat_belts');
        $cup_holders_front 			= 	Input::get('cup_holders_front');
        $cup_holders_rear 			= 	Input::get('cup_holders_rear');
        $rear_ac_vents 				= 	Input::get('rear_ac_vents');
        $parking_sensors 			= 	Input::get('parking_sensors');
        $anti_lock_braking_system 	= 	Input::get('anti_lock_braking_system');
        $central_locking 			= 	Input::get('central_locking');
        $child_safety_lock 			= 	Input::get('child_safety_lock');
        $driver_airbags 			= 	Input::get('driver_airbags');
        $passenger_airbag 			= 	Input::get('passenger_airbag');
        $rear_seat_belts 			= 	Input::get('rear_seat_belts');
        $seat_belt_warning 			= 	Input::get('seat_belt_warning');
        $adjustable_seats 			= 	Input::get('adjustable_seats');
        $crash_sensor 				= 	Input::get('crash_sensor');
        $anti_theft_device 			= 	Input::get('anti_theft_device');
        $immobilizer 				= 	Input::get('immobilizer');
        $adjustable_head_lights 	= 	Input::get('adjustable_head_lights');
        $power_adjustable_exterior_rear_view_mirror = 	Input::get('power_adjustable_exterior_rear_view_mirror');
        $electric_folding_rear_view_mirror = 	Input::get('electric_folding_rear_view_mirror');
        $rain_sensing_wipers 		= 	Input::get('rain_sensing_wipers');
        $rear_window_wiper 			= 	Input::get('rear_window_wiper');
        $alloy_wheels 				= 	Input::get('alloy_wheels');
        $tinted_glass 				= 	Input::get('tinted_glass');
        $front_fog_lights 			= 	Input::get('front_fog_lights');
        $rear_window_defogger 		= 	Input::get('rear_window_defogger');
        $cdplayer 					= 	Input::get('cdplayer');
        $radio 						= 	Input::get('radio');
        $audio 						= 	Input::get('audio');
        $bluetooth 					= 	Input::get('bluetooth');
        $overviewdescription 		= 	Input::get('overviewdescription');
        
        if($id == "" || $car_id	==	"")
        {
			return response()->json(['Result'=>'0',
									'message'=>'User and car id is required!!'
									]);
		}
		$schemaname 	=  $this->getschemaname($id);
		if(!empty($schemaname))
		{
			$wherecon 		=	array('listing_id'=>$car_id);
			$getresult 		=	inventorymodel::dealerFetchTableDetails($schemaname,
															'dealer_listing_features',
															$wherecon
															);
			if(!empty($getresult) && count($getresult) >= 1)
			{
				$updatefea 	= 	array( 
									  'gear_box'=>$gear_box,
									  'drive_type'=>$drive_type, 
									  'seating_capacity'=>$seating_capacity,
									  'steering_type'=>$steering_type,
									  'turning_radius'=>$turning_radius,
									  'top_speed'=>$top_speed,
									  'acceleration'=>$acceleration,
									  'tyre_type'=>$tyre_type,
									  'no_of_doors'=>$no_of_doors,
									  'engine_type'=>$engine_type,
									  'displacement'=>$displacement,
									  'max_power'=>$max_power,
									  'max_torque'=>$max_torque,
									  'no_of_cylinder'=>$no_of_cylinder,
									  'valves_per_cylinder'=>$valves_per_cylinder,
									  'valve_configuration'=>$valve_configuration,
									  'fuel_supply_system'=>$fuel_supply_system,
									  'turbo_charger'=>$turbo_charger,
									  'super_charger'=>$super_charger,
									  'length'=>$length,
									  'width'=>$width,
									  'height'=>$height,
									  'wheel_base'=>$wheel_base,
									  'gross_weight'=>$gross_weight,
									  'air_conditioner'=>$air_conditioner,
									  'adjustable_steering'=>$adjustable_steering,
									  'leather_steering_wheel'=>$leather_steering_wheel,
									  'heater'=>$heater,
									  'digital_clock'=>$digital_clock,
									  'power_steering'=>$power_steering,
									  'power_windows_front'=>$power_windows_front,
									  'power_windows_rear'=>$power_windows_rear,
									  'remote_trunk_opener'=>$remote_trunk_opener,
									  'remote_fuel_lid_opener'=>$remote_fuel_lid_opener,
									  'low_fuel_warning_light'=>$low_fuel_warning_light,
									  'rear_reading_lamp'=>$rear_reading_lamp,
									  'rear_seat_headrest'=>$rear_seat_headrest,
									  'rear_seat_centre_arm_rest'=>$rear_seat_centre_arm_rest,
									  'height_adjustable_front_seat_belts'=>$height_adjustable_front_seat_belts,
									  'cup_holders_front'=>$cup_holders_front,
									  'cup_holders_rear'=>$cup_holders_rear,
									  'rear_ac_vents'=>$rear_ac_vents,
									  'parking_sensors'=>$parking_sensors,
									  'anti_lock_braking_system'=>$anti_lock_braking_system,
									  'central_locking'=>$central_locking,
									  'child_safety_lock'=>$child_safety_lock,
									  'driver_airbags'=>$driver_airbags,
									  'passenger_airbag'=>$passenger_airbag,
									  'rear_seat_belts'=>$rear_seat_belts,
									  'seat_belt_warning'=>$seat_belt_warning,
									  'adjustable_seats'=>$adjustable_seats,
									  'crash_sensor'=>$crash_sensor,
									  'anti_theft_device'=>$anti_theft_device,
									  'immobilizer'=>$immobilizer,
									  'adjustable_head_lights'=>$adjustable_head_lights,
									  'power_adjustable_exterior_rear_view_mirror'=>$power_adjustable_exterior_rear_view_mirror,
									  'electric_folding_rear_view_mirror'=>$electric_folding_rear_view_mirror,
									  'rain_sensing_wipers'=>$rain_sensing_wipers,
									  'rear_window_wiper'=>$rear_window_wiper,
									  'alloy_wheels'=>$alloy_wheels,
									  'tinted_glass'=>$tinted_glass,
									  'front_fog_lights'=>$front_fog_lights,
									  'rear_window_defogger'=>$rear_window_defogger,
									  'cdplayer'=>$cdplayer,
									  'cdplayer'=>$cdplayer,
									  'radio'=>$radio,
									  'audio'=>$audio,
									  'bluetooth'=>$bluetooth,
									  'overviewdescription'=>$overviewdescription
									  );
				$Where		= 	array('listing_id' => $car_id);
				inventorymodel::dealerUpdateTableDetails(
									$id,
									$schemaname,
									'dealer_listing_features',
									$Where,
									$updatefea
									);
				return response()->json(['Result'=>'1',
						'message'=>'Updated Successfully'
						]);
			}
			else
			{
				$insertfeat		= 	array(
									'listing_id'=>$car_id, 
									'gear_box'=>$gear_box,
									'drive_type'=>$drive_type, 
									'seating_capacity'=>$seating_capacity,
									'steering_type'=>$steering_type,
									'turning_radius'=>$turning_radius,
									'top_speed'=>$top_speed,
									'acceleration'=>$acceleration,
									'tyre_type'=>$tyre_type,
									'no_of_doors'=>$no_of_doors,
									'engine_type'=>$engine_type,
									'displacement'=>$displacement,
									'max_power'=>$max_power,
									'max_torque'=>$max_torque,
									'no_of_cylinder'=>$no_of_cylinder,
									'valves_per_cylinder'=>$valves_per_cylinder,
									'valve_configuration'=>$valve_configuration,
									'fuel_supply_system'=>$fuel_supply_system,
									'turbo_charger'=>$turbo_charger,
									'super_charger'=>$super_charger,
									'length'=>$length,
									'width'=>$width,
									'height'=>$height,
									'wheel_base'=>$wheel_base,
									'gross_weight'=>$gross_weight,
									'air_conditioner'=>$air_conditioner,
									'adjustable_steering'=>$adjustable_steering,
									'leather_steering_wheel'=>$leather_steering_wheel,
									'heater'=>$heater,
									'digital_clock'=>$digital_clock,
									'power_steering'=>$power_steering,
									'power_windows_front'=>$power_windows_front,
									'power_windows_rear'=>$power_windows_rear,
									'remote_trunk_opener'=>$remote_trunk_opener,
									'remote_fuel_lid_opener'=>$remote_fuel_lid_opener,
									'low_fuel_warning_light'=>$low_fuel_warning_light,
									'rear_reading_lamp'=>$rear_reading_lamp,
									'rear_seat_headrest'=>$rear_seat_headrest,
									'rear_seat_centre_arm_rest'=>$rear_seat_centre_arm_rest,
									'height_adjustable_front_seat_belts'=>$height_adjustable_front_seat_belts,
									'cup_holders_front'=>$cup_holders_front,
									'cup_holders_rear'=>$cup_holders_rear,
									'rear_ac_vents'=>$rear_ac_vents,
									'parking_sensors'=>$parking_sensors,
									'anti_lock_braking_system'=>$anti_lock_braking_system,
									'central_locking'=>$central_locking,
									'child_safety_lock'=>$child_safety_lock,
									'driver_airbags'=>$driver_airbags,
									'passenger_airbag'=>$passenger_airbag,
									'rear_seat_belts'=>$rear_seat_belts,
									'seat_belt_warning'=>$seat_belt_warning,
									'adjustable_seats'=>$adjustable_seats,
									'crash_sensor'=>$crash_sensor,
									'anti_theft_device'=>$anti_theft_device,
									'immobilizer'=>$immobilizer,
									'adjustable_head_lights'=>$adjustable_head_lights,
									'power_adjustable_exterior_rear_view_mirror'=>$power_adjustable_exterior_rear_view_mirror,
									'electric_folding_rear_view_mirror'=>$electric_folding_rear_view_mirror,
									'rain_sensing_wipers'=>$rain_sensing_wipers,
									'rear_window_wiper'=>$rear_window_wiper,
									'alloy_wheels'=>$alloy_wheels,
									'tinted_glass'=>$tinted_glass,
									'front_fog_lights'=>$front_fog_lights,
									'rear_window_defogger'=>$rear_window_defogger,
									'cdplayer'=>$cdplayer,
									'cdplayer'=>$cdplayer,
									'radio'=>$radio,
									'audio'=>$audio,
									'bluetooth'=>$bluetooth,
									'overviewdescription'=>$overviewdescription
									    );
				inventorymodel::dealerInsertTable($schemaname,
												'dealer_listing_features',
												$insertfeat
												);
				return response()->json(['Result'=>'1',
						'message'=>'Inserted Successfully'
						]);
			}
		}
		return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
		
    }
    //ADD INVENTORY LISTING SUBMIT FUNCTION
    public function doApilistingsubmit()
    {   
        $id 						= 	Input::get('session_user_id');
        $car_id 					= 	Input::get('car_id');
        $dealer_selection 			= 	Input::get('dealer_selection');
        if($id == "" || $car_id	==	"")
        {
			return response()->json(['Result'=>'0',
									'message'=>'User and car id is required!!'
									]);
		}
		$schemaname 	=  $this->getschemaname($id);
		if(!empty($schemaname))
		{
			$getresult 			=	inventorymodel::doApichecklistingexist($schemaname,
															$car_id
															);
			if(count($getresult) == 0)
			{
				return response()->json(['Result'=>'0',
									'message'=>'Basic Info and Images are mandatory!!'
									]);
			}
			
			$getresultprice 	= 	(count($getresult)>=1?$getresult[0]->price:'');
			if($getresultprice  == 0)
			{
				return response()->json(['Result'=>'0',
									'message'=>'Sell Price should be greater than zero!!'
									]);
			}
			
			$whereonline		=	array('car_id'=>$car_id,'dealer_selection'=>$dealer_selection);
            $checkonlineportal 	=	inventorymodel::dealerFetchTableDetails($schemaname,
															'dealer_online_portal',
															$whereonline
															);		
			if(!empty($getresult) && count($getresult) >= 1)
			{
				if(count($checkonlineportal) >= 1)
				{
					$updatebasicdata 	= 	array(
													'portal_primary_id'=>'',
													'dealer_selection'=>$dealer_selection,
													'auction_price'=>0,
													'other_min_price'=>0,
													'other_start_date'=>0,
													'other_end_date'=>0
												);
					$whereupdate 		=	array('car_id'=>$car_id);
					$upddatebasicinfo 	= 	inventorymodel::dealerUpdateTableDetails($id,
																	$schemaname,
																	'dealer_online_portal',
																	$whereupdate,
																	$updatebasicdata);
				}
				else
				{
					$InsertPoratlDatainsert 	= 	array(
															'car_id'=>$car_id, 
															'portal_primary_id'=>'',
															'dealer_selection'=>$dealer_selection,
															'auction_price'=>0,
															'other_min_price'=>0,
															'other_start_date'=>0,
															'other_end_date'=>0
														);
					$insertportal   = 	inventorymodel::InsertTable($id,
																	$schemaname,
																	'dealer_online_portal',
																	$InsertPoratlDatainsert
																	);
				}
				$success 	=	$this->doAPimongopush($id,$car_id);
				if($success >= 1)
				{
					return response()->json(['Result'=>'1',
							'message'=>'Successfully Posted Your Listing'
							]);
				}
				else
				{
					return response()->json(['Result'=>'0',
							'message'=>'Already Posted Your Listing'
							]);
				}
			}
			return response()->json(['Result'=>'0',
								'message'=>'Basic Info and Images are mandatory'
								]);																
		}
		return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
		
    }
    public function doAPimongopush($id,$carid)
    {   
        $duplicate_id 		= 	$carid;
        $schemaname 		=   $this->getschemaname($id);
        $maintable 			= 	new schemamodel;
        $WhereDmsListing 	= 	array('car_id'=>$duplicate_id);
        $car_listing       	= 	schemamodel::dogetschemarecords($schemaname,
                                                            $this->DmsCarListTable,
                                                            $WhereDmsListing
                                                            );
        $WhereDmsListing 	= 	array('car_id'=>$duplicate_id);
        $car_photos       	= 	schemamodel::schema_countwhere($schemaname,
                                                            $this->DmsCarListPhotosTable,
                                                            $WhereDmsListing
                                                            );

        $WhereDmsListing 	= 	array('listing_id'=>$duplicate_id);
        $car_pricing       	= 	schemamodel::dogetschemarecords($schemaname,
                                                            'dealer_cars_pricing',
                                                            $WhereDmsListing
                                                            );
        $car_listing_main_view 	= 	array();
        if(count($car_listing) >=1 && count($car_photos) >= 1 && count($car_pricing) >= 1)
        {
			$mongo_data 	= 	array();
			$main_id 		= 	$car_listing->car_id;
			$Wherecarid 	= 	array('car_id'=>$car_listing->car_id);
																
			$car_listing_main_view['car_list']     	= 	schemamodel::dogetschemarecords($schemaname,
																$this->DmsCarListTable,
																$Wherecarid
																);
			$car_listing_main_view['photos']       	= 	schemamodel::schema_countwhere($schemaname,
																$this->DmsCarListPhotosTable,
																$Wherecarid
																);

			$car_listing_main_view['videos']       	= 	schemamodel::dogetschemarecords($schemaname,
																'dms_car_listings_videos',
																$Wherecarid
																);

			$car_listing_main_view['documents']    	= 	schemamodel::schema_countwhere($schemaname,
																'dms_car_listings_documents',
																$Wherecarid
																);
			$Wherelisting_id = 	array('listing_id'=>$car_listing->car_id);        
			$car_listing_main_view['pricing']     	= 	schemamodel::dogetschemarecords($schemaname,
																'dealer_cars_pricing',
																$Wherelisting_id
																);

			$car_listing_main_view['expense']     	= 	schemamodel::schema_countwhere($schemaname,
																'dealer_car_expenses',
																$Wherecarid
																);
			$car_listing_main_view['online']     	= 	schemamodel::dogetschemarecords($schemaname,
																'dealer_online_portal',
																$Wherecarid
															);

			$car_listing_main_view['features']     	= 	schemamodel::dogetschemarecords($schemaname,
																						'dealer_listing_features',
																						$Wherelisting_id
																						);
            if(!empty($car_listing_main_view) && count($car_listing_main_view) >= 1)
            {
				foreach($car_listing_main_view as $mongokey => $value)
				{
					if($mongokey == 'car_list')
					{
						$mongo_data['car_id']          	= 	$value->car_id;
						$mongo_data['duplicate_id']     = 	$value->duplicate_id;
						$mongo_data['inventory_type']   = 	$value->inventory_type;
						$mongo_data['dealer_id']        = 	$value->dealer_id;
						$mongo_data['addinventor_id']   = 	$value->addinventor_id;
						$mongo_data['branch_id']        = 	$value->branch_id;
						$makewhere						=	array($this->masterMakeIdfiled=>$value->make);
						$getmake 	 					=	inventorymodel::masterschema_table_where(
																				$this->masterMakeTable,
																				$makewhere);
						$mongo_data['make_name'] 		=	((count($getmake)>=1)?$getmake[0]->makename:'');
						$mongo_data['make_id']			=	$value->make;
						$modelwhere						=	array('model_id'=>$value->model_id);
						$getmodel 	 					=	inventorymodel::masterschema_table_where(
																				$this->masterModelsTable,
																				$modelwhere);
						$mongo_data['model_name'] 		=	((count($getmodel)>=1)?$getmodel[0]->model_name:'');                
                        $mongo_data['model_id']			=	$value->model_id;
                        $varientwhere					=	array('variant_id'=>$value->variant);
						$getvarient 	 				=	inventorymodel::masterschema_table_where(
																				$this->MasterVariantTable,
																				$varientwhere);
						$mongo_data['variant_name'] 	=	((count($getvarient)>=1)?$getvarient[0]->variant_name:'');
                        $mongo_data['variant_id']       = 	$value->variant;
                        $mongo_data['category_id']      = 	$value->category_id;
                        $mongo_data['mileage']          = 	$value->mileage;
                        $mongo_data['price']            = 	$value->price;
                        $mongo_data['body_type']        = 	$value->body_type;                        
                        $mongo_data['colors']           = 	$value->colors;                        
                        $mongo_data['status']           = 	$value->status;
                        $mongo_data['registration_year']= 	$value->registration_year;                        
                        $mongo_data['owner_type']       = 	$value->owner_type;
                        $mongo_data['place']            = 	$value->place;
                        $mongo_data['kms_done']         = 	$value->kms_done;                        
                        $mongo_data['car_city']         = 	$value->car_city;                        
                        $mongo_data['fuel_type']        = 	$value->fuel_type;
                        $mongo_data['transmission']     = 	$value->transmission;
                        $mongo_data['created_at']       = 	$value->created_at;
                        $mongo_data['updated_at']       = 	$value->updated_at;
                    }
                    
                    if($mongokey == 'photos'){
                        $mongo_data['photos'] 			= 	collect($value)->toArray();
                    }
                    
                    if($mongokey == 'videos'){
                        $mongo_data['videos']	 		= 	collect($value)->toArray();
                    }

                    if($mongokey == 'documents'){
                        $mongo_data['documents']	 	= 	collect($value)->toArray();
                    }
                    if($mongokey == 'pricing'){
                        $mongo_data['pricing'] 			= 	$value;
                    }

                    if($mongokey == 'expense'){
                        $mongo_data['expense']			= 	collect($value)->toArray();
                    }

                    if($mongokey == 'online'){
                        $mongo_data['online'] 			= 	$value;
                    }

                    if($mongokey == 'features'){
                        $mongo_data['features'] 		= 	$value;
                    }
                }
            }
            
            if($mongo_data['duplicate_id']	==	'')
            {
                $mongo_id 	= 	'DPLD'.Carbon::now()->format('Ymdhis');
                $mongodb_carlisting 	= 	new mongomodel;
            }
            else
            {
                $mongo_id 	=   $mongo_data['duplicate_id'];
                $mongodb_carlisting = array();
            }
            $cur	=	Carbon::now();
            $mongodb_carlisting['listing_expiry_date'] 	= 	$cur->addDays(config::get('common.listing_expiry_days'))->format('Y-m-d');            
            $mongodb_carlisting['listing_id']     	= 	$mongo_id;
            $mongodb_carlisting['addinventor_id'] 	= 	$mongo_data['addinventor_id'];
            $mongodb_carlisting['duplicate_id']   	= 	$mongo_id;
            $mongodb_carlisting['inventory_type'] 	= 	$mongo_data['inventory_type'];
            $mongodb_carlisting['dealer_id']      	= 	$mongo_data['dealer_id'];
            $mongodb_carlisting['branch_id']      	= 	$mongo_data['branch_id'];
            $mongodb_carlisting['model_id']       	= 	$mongo_data['model_id'];
            $mongodb_carlisting['category_id']    	= 	$mongo_data['category_id'];
            $mongodb_carlisting['mileage']        	= 	$mongo_data['mileage'];
            $mongodb_carlisting['transmission']   	= 	$mongo_data['transmission'];
            
            $branchaddress 		= 	inventorymodel::dealerFetchTableDetails(
																	$schemaname,
																	'dms_dealer_branches',
																	array('branch_id'=>$mongo_data['branch_id'])
																);
           $mongodb_carlisting['branch_address']	=	((count($branchaddress)>=1)?$branchaddress[0]->branch_address:''); 
            
            $body_type_name 	= 	buyymodel::masterFetchTableDetails($id,
																	'master_category',
																	array('category_id'=>$mongo_data['category_id'])
																	); 
            $mongodb_carlisting['body_type']		=	((count($body_type_name)>=1)?$body_type_name[0]->category_description:''); 
            
            $colorwhere								=	array('colour_id'=>$mongo_data['colors']);
			$getcolor 	 							=	inventorymodel::masterschema_table_where(
																				'master_colors',
																				$colorwhere);
			$mongodb_carlisting['colors']			=	((count($getcolor)>=1)?$getcolor[0]->colour_name:'');

            
            $mongodb_carlisting['status']           = 	$mongo_data['status'];
            $mongodb_carlisting['registration_year']= 	$mongo_data['registration_year'];
            $mongodb_carlisting['owner_type']      	= 	$mongo_data['owner_type'];
            $mongodb_carlisting['make_id']          = 	$mongo_data['make_id'];
            $mongodb_carlisting['make']             = 	$mongo_data['make_name'];
            $mongodb_carlisting['model_id']         = 	$mongo_data['model_id'];
            $mongodb_carlisting['model']            = 	$mongo_data['model_name'];
            $mongodb_carlisting['variant_id']       = 	$mongo_data['variant_id'];
            $mongodb_carlisting['variant']          = 	$mongo_data['variant_name'];
            $mongodb_carlisting['kilometer_run']    = 	$mongo_data['kms_done'];
            
            $fetchdealer_details 					= 	inventorymodel::master_table_where(
																			'dms_dealers',
																			'd_id',
																			$mongo_data['dealer_id']
																			);
			if(count($fetchdealer_details)	>=	1)
			{
				$mongodb_carlisting['car_owner_name']   = 	$fetchdealer_details[0]->dealer_name;
				$mongodb_carlisting['car_owner_email']  = 	$fetchdealer_details[0]->d_email;
				$mongodb_carlisting['car_owner_mobile'] = 	$fetchdealer_details[0]->d_mobile;
			}
            $citywhere								=	array('city_id'=>$mongo_data['car_city']);
			$getcity 	 							=	inventorymodel::masterschema_table_where(
																		'master_city',
																		$citywhere);
			$mongodb_carlisting['car_locality'] 	=	((count($getcity)>=1)?$getcity[0]->city_name:'');            
			$mongodb_carlisting['car_city'] 		=	((count($getcity)>=1)?$getcity[0]->city_name:'');            
            $mongodb_carlisting['fuel_type']    	= 	$mongo_data['fuel_type'];
            if(count($mongo_data['photos']) >=1){
                $mongodb_carlisting['photos'] 		= 	$mongo_data['photos'];
            }
            else{
                $mongodb_carlisting['photos'] 		= 	array();
            }
            
            if(count($mongo_data['videos']) >=1){
                $mongodb_carlisting['videos'] 		= 	$mongo_data['videos'];
            }
            else{
                $mongodb_carlisting['videos'] 		= 	array();
            }
            if(count($mongo_data['documents']) >=1){
                $mongodb_carlisting['documents']	= 	$mongo_data['documents'];
            }
            else{
                $mongodb_carlisting['documents']	= 	array();
            }
			
            if(count($mongo_data['pricing']) >=1)
            {
                $mongodb_carlisting['sell_price']            	= 	intval($mongo_data['pricing']->saleprice);
                $mongodb_carlisting['ownpurchase_date']      	= 	$mongo_data['pricing']->ownpurchase_date;
                $mongodb_carlisting['ownpurchased_from']     	= 	$mongo_data['pricing']->ownpurchased_from;
                $mongodb_carlisting['ownreceived_from_name'] 	= 	$mongo_data['pricing']->ownreceived_from_name;
                $mongodb_carlisting['ownpurchased_price']    	= 	$mongo_data['pricing']->ownpurchased_price;
                $mongodb_carlisting['ownkey_received'] 			= 	$mongo_data['pricing']->ownkey_received;
                $mongodb_carlisting['owndocuments_received']	= 	$mongo_data['pricing']->owndocuments_received;
                $mongodb_carlisting['test_drive']          		= 	$mongo_data['pricing']->test_drive;
                $mongodb_carlisting['testdrive_dealerpoint']    = 	$mongo_data['pricing']->testdrive_dealerpoint;
                $mongodb_carlisting['testdrive_doorstep']       = 	$mongo_data['pricing']->testdrive_doorstep;
                $mongodb_carlisting['markup_percentage']        = 	$mongo_data['pricing']->markup_percentage;
                $mongodb_carlisting['markup_condition']        	= 	$mongo_data['pricing']->markup_condition;
                $mongodb_carlisting['markup_percentage']        = 	$mongo_data['pricing']->markup_percentage;
                $mongodb_carlisting['markup_value']        		= 	$mongo_data['pricing']->markup_value;
                $mongodb_carlisting['purchase_date']        	= 	$mongo_data['pricing']->purchase_date;
                $mongodb_carlisting['starting_kms']        		= 	$mongo_data['pricing']->starting_kms;
                $mongodb_carlisting['received_from_own']        = 	$mongo_data['pricing']->received_from_own;
                $mongodb_carlisting['received_from_name']       = 	$mongo_data['pricing']->received_from_name;
                $mongodb_carlisting['fuel_indication']        	= 	$mongo_data['pricing']->fuel_indication;
                $mongodb_carlisting['fuel_capacity']        	= 	$mongo_data['pricing']->fuel_capacity;
                $mongodb_carlisting['customer_asking_price']    = 	$mongo_data['pricing']->customer_asking_price;
                $mongodb_carlisting['dealer_markup_price']      = 	$mongo_data['pricing']->dealer_markup_price;
                $mongodb_carlisting['keys_available']        	= 	$mongo_data['pricing']->keys_available;
                $mongodb_carlisting['documents_received']       = 	$mongo_data['pricing']->documents_received;
            }
            else{
                $mongo_data['pricing'] 	= 	array();
            }
			
            if(count($mongo_data['expense']) >=1)
            {
				$mongodb_carlisting['expense'] 					= 	$mongo_data['expense'];
            }
            else
            {
                $mongodb_carlisting['expense'] 					= 	array();
            }
			
            if(count($mongo_data['features']) >=1){
                $mongodb_carlisting['overviewdescription']    	= 	$mongo_data['features']->overviewdescription;
                $mongodb_carlisting['gear_box']               	= 	$mongo_data['features']->gear_box;
                $mongodb_carlisting['drive_type']             	= 	$mongo_data['features']->drive_type;
                $mongodb_carlisting['seating_capacity']       	= 	$mongo_data['features']->seating_capacity;
                $mongodb_carlisting['steering_type']          	= 	$mongo_data['features']->steering_type;
                $mongodb_carlisting['turning_radius']         	= 	$mongo_data['features']->turning_radius;
                $mongodb_carlisting['top_speed']              	= 	$mongo_data['features']->top_speed;
                $mongodb_carlisting['acceleration']           	= 	$mongo_data['features']->acceleration;
                $mongodb_carlisting['tyre_type']              	= 	$mongo_data['features']->tyre_type;
                $mongodb_carlisting['no_of_doors']            	= 	$mongo_data['features']->no_of_doors;
                $mongodb_carlisting['engine_type']            	= 	$mongo_data['features']->engine_type;
                $mongodb_carlisting['displacement']           	= 	$mongo_data['features']->displacement;
                $mongodb_carlisting['max_power']              	= 	$mongo_data['features']->max_power;
                $mongodb_carlisting['max_torque']             	= 	$mongo_data['features']->max_torque;
                $mongodb_carlisting['no_of_cylinder']         	= 	$mongo_data['features']->no_of_cylinder;
                $mongodb_carlisting['valves_per_cylinder']    	= 	$mongo_data['features']->valves_per_cylinder;
                $mongodb_carlisting['valve_configuration']    	= 	$mongo_data['features']->valve_configuration;
                $mongodb_carlisting['fuel_supply_system']     	= 	$mongo_data['features']->fuel_supply_system;
                $mongodb_carlisting['turbo_charger']          	= 	$mongo_data['features']->turbo_charger;
                $mongodb_carlisting['super_charger']          	= 	$mongo_data['features']->super_charger;
                $mongodb_carlisting['length']                 	= 	$mongo_data['features']->length;
                $mongodb_carlisting['width']                  	= 	$mongo_data['features']->width;
                $mongodb_carlisting['height']                 	= 	$mongo_data['features']->height;
                $mongodb_carlisting['wheel_base']             	= 	$mongo_data['features']->wheel_base;
                $mongodb_carlisting['gross_weight']          	= 	$mongo_data['features']->gross_weight;
                $mongodb_carlisting['air_conditioner']        	= 	$mongo_data['features']->air_conditioner;
                $mongodb_carlisting['adjustable_steering']    	= 	$mongo_data['features']->adjustable_steering;
                $mongodb_carlisting['leather_steering_wheel'] 	= 	$mongo_data['features']->leather_steering_wheel;
                $mongodb_carlisting['heater']                 	= 	$mongo_data['features']->heater;
                $mongodb_carlisting['digital_clock']          	= 	$mongo_data['features']->digital_clock;
                $mongodb_carlisting['power_steering']         	= 	$mongo_data['features']->power_steering;
                $mongodb_carlisting['power_windows_front']    	= 	$mongo_data['features']->power_windows_front;
                $mongodb_carlisting['power_windows_rear']     	= 	$mongo_data['features']->power_windows_rear;
                $mongodb_carlisting['remote_trunk_opener']    	= 	$mongo_data['features']->remote_trunk_opener;
                $mongodb_carlisting['remote_fuel_lid_opener'] 	= 	$mongo_data['features']->remote_fuel_lid_opener;
                $mongodb_carlisting['low_fuel_warning_light'] 	= 	$mongo_data['features']->low_fuel_warning_light;
                $mongodb_carlisting['rear_reading_lamp']      	= 	$mongo_data['features']->rear_reading_lamp;
                $mongodb_carlisting['rear_seat_headrest']     	= 	$mongo_data['features']->rear_seat_headrest;
                $mongodb_carlisting['rear_seat_centre_arm_rest']= 	$mongo_data['features']->rear_seat_centre_arm_rest;
                $mongodb_carlisting['height_adjustable_front_seat_belts'] = $mongo_data['features']->height_adjustable_front_seat_belts;
                $mongodb_carlisting['cup_holders_front']      	= 	$mongo_data['features']->cup_holders_front;
                $mongodb_carlisting['cup_holders_rear']       	= 	$mongo_data['features']->cup_holders_rear;
                $mongodb_carlisting['rear_ac_vents']          	= 	$mongo_data['features']->rear_ac_vents;
                $mongodb_carlisting['parking_sensors']        	= 	$mongo_data['features']->parking_sensors;
                $mongodb_carlisting['anti_lock_braking_system'] = 	$mongo_data['features']->anti_lock_braking_system;
                $mongodb_carlisting['central_locking']        	= 	$mongo_data['features']->central_locking;
                $mongodb_carlisting['child_safety_lock']      	= 	$mongo_data['features']->child_safety_lock;
                $mongodb_carlisting['driver_airbags']         	= 	$mongo_data['features']->driver_airbags;
                $mongodb_carlisting['passenger_airbag']       	= 	$mongo_data['features']->passenger_airbag;
                $mongodb_carlisting['rear_seat_belts']        	= 	$mongo_data['features']->rear_seat_belts;
                $mongodb_carlisting['seat_belt_warning']      	= 	$mongo_data['features']->seat_belt_warning;
                $mongodb_carlisting['adjustable_seats']       	= 	$mongo_data['features']->adjustable_seats;
                $mongodb_carlisting['crash_sensor']           	= 	$mongo_data['features']->crash_sensor;
                $mongodb_carlisting['anti_theft_device']      	= 	$mongo_data['features']->anti_theft_device;
                $mongodb_carlisting['immobilizer']            	= 	$mongo_data['features']->immobilizer;
                $mongodb_carlisting['adjustable_head_lights'] 	= 	$mongo_data['features']->adjustable_head_lights;
                $mongodb_carlisting['power_adjustable_exterior_rear_view_mirror'] = $mongo_data['features']->power_adjustable_exterior_rear_view_mirror;
                $mongodb_carlisting['electric_folding_rear_view_mirror'] = $mongo_data['features']->electric_folding_rear_view_mirror;
                $mongodb_carlisting['rain_sensing_wipers']    	= 	$mongo_data['features']->rain_sensing_wipers;
                $mongodb_carlisting['rear_window_wiper']      	= 	$mongo_data['features']->rear_window_wiper;
                $mongodb_carlisting['alloy_wheels']           	= 	$mongo_data['features']->alloy_wheels;
                $mongodb_carlisting['tinted_glass']           	= 	$mongo_data['features']->tinted_glass;
                $mongodb_carlisting['front_fog_lights']       	= 	$mongo_data['features']->front_fog_lights;
                $mongodb_carlisting['rear_window_defogger']   	= 	$mongo_data['features']->rear_window_defogger;
                $mongodb_carlisting['cdplayer']               	= 	$mongo_data['features']->cdplayer;
                $mongodb_carlisting['radio']                  	= 	$mongo_data['features']->radio;
                $mongodb_carlisting['audio']                  	= 	$mongo_data['features']->audio;
                $mongodb_carlisting['bluetooth']              	= 	$mongo_data['features']->bluetooth;
            }
            else{
                $mongo_data['features'] = array();
            }
            
            if(count($mongo_data['online']) >=1){
                $mongodb_carlisting['online_portal_id']         = 	$mongo_data['online']->online_portal_id;
                $mongodb_carlisting['portal_primary_id']        = 	$mongo_data['online']->portal_primary_id;
                $mongodb_carlisting['listing_selection']		=	($mongo_data['online']->dealer_selection == "listing"?0:1);
                $mongodb_carlisting['auction_price']            = 	$mongo_data['online']->auction_price;
                $mongodb_carlisting['auction_startdate']        = 	$mongo_data['online']->auction_startdate;
                $mongodb_carlisting['auction_end_date']         = 	$mongo_data['online']->auction_end_date;
                $mongodb_carlisting['inviation']                = 	$mongo_data['online']->inviation;
                $mongodb_carlisting['listing_olx']              = 	$mongo_data['online']->listing_olx;
                $mongodb_carlisting['listing_carwale']          = 	$mongo_data['online']->listing_carwale;
                $mongodb_carlisting['listing_cardekho']         = 	$mongo_data['online']->listing_cardekho;
                $mongodb_carlisting['listing_quickr']           = 	$mongo_data['online']->listing_quickr;
                $mongodb_carlisting['listing_olx']              = 	$mongo_data['online']->auction_price;
                $mongodb_carlisting['listing_carwale']          = 	$mongo_data['online']->listing_carwale;
                $mongodb_carlisting['listing_cardekho']         = 	$mongo_data['online']->listing_cardekho;
                $mongodb_carlisting['other_auction_type']       = 	$mongo_data['online']->other_auction_type;
                $mongodb_carlisting['other_min_price']          = 	$mongo_data['online']->other_min_price;
                $mongodb_carlisting['other_start_date']         = 	$mongo_data['online']->other_start_date;
                $mongodb_carlisting['other_end_date']           = 	$mongo_data['online']->other_end_date;
                $mongodb_carlisting['auctioninviation']         = 	$mongo_data['online']->other_min_price;
            }else{
                $mongo_data['online'] 	= 	array();
            }
            $mongodb_carlisting['listing_status'] 	= 	'Active';
            $mongodb_carlisting['sitename'] 		= 	'Dealerplus';
            if($mongo_data['duplicate_id']	==	'')
            {
                $mongodb_carlisting->save();
				if($mongodb_carlisting)
				{
					$arryupdate     	=   array("duplicate_id"=>$mongo_id,"mongopushdate"=>Carbon::now(),
												"mongopush_status"=>"success","car_master_status"=>2); 
					$whereupdate    	=   array("car_id"=>$duplicate_id); 
					$update_data 		= 	inventorymodel::dealerUpdateTableDetails($id,
																			$schemaname,
																			$this->DmsCarListTable,
																			$whereupdate,
																			$arryupdate);
					$listing_details 	= 	array( 'inventory_id'=>$duplicate_id,
											  'listing_id'=>$mongo_id,
											  'listing_site'=>'Dealerplus',
											  'listing_status'=>'Active',
											  'user_id'=>$id,
											  'createddate'=>Carbon::now()->format('Y-m-d'),
											);
					inventorymodel::InsertTable($id,$schemaname,'dealer_listing_details',$listing_details);
					$job 				= 	new \App\Jobs\TestQueue($mongo_data['make_name'],$mongo_data['model_name'],$mongo_data['variant_name'],$mongo_id,$id);
					dispatch($job);
					return 1;
				}
				else
				{
					$arryupdate     	=   array("mongopushdate"=>Carbon::now(),
                                            "mongopush_status"=>"failure"); 
					$whereupdate    	=   array("car_id"=>$duplicate_id); 
					$update_data 		= 	inventorymodel::dealerUpdateTableDetails($id,
																			$schemaname,
																			$this->DmsCarListTable,
																			$whereupdate,
																			$arryupdate
																			);
					return 0;
				}
            }
            else
            {
                $mongo_id 	=   $mongo_data['duplicate_id'];
                mongomodel::where('listing_id',$mongo_id)->update($mongodb_carlisting);
                return 1;
            }
        }
        else{
                return 0;
        }
    }
    
    public function doApiIbbprice()
    {
        $id 			= 	Input::get('session_user_id');
        $year 			= 	Input::get('year');
        $make 			= 	Input::get('makeid');
        $model 			= 	Input::get('modalid');
        $variant 		= 	Input::get('varientid');
        $location 		= 	Input::get('city');
        $kilometer 		= 	Input::get('kilometer');
        $owner 			= 	Input::get('owner');
        $color 			= 	Input::get('color');
        if($id == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'User Id is required!!'
									]);
		}
		$schemaname 	=  $this->getschemaname($id);
		if(!empty($schemaname))
		{	
			$makewhere					=	array($this->masterMakeIdfiled=>$make);
			$getmake 	 				=	inventorymodel::masterschema_table_where(
																	$this->masterMakeTable,
																	$makewhere);
			$makename 					=	((count($getmake)>=1)?$getmake[0]->ibb_make:'');

			$modelwhere					=	array('model_id'=>$model);
			$getmodel 	 				=	inventorymodel::masterschema_table_where(
																	$this->masterModelsTable,
																	$modelwhere);
			$model_name  				=	((count($getmodel)>=1)?$getmodel[0]->ibb_model:'');                
			
			$varientwhere				=	array('variant_id'=>$variant);
			$getvarient 	 			=	inventorymodel::masterschema_table_where(
																	$this->MasterVariantTable,
																	$varientwhere);
			$variant_name 				=	((count($getvarient)>=1)?$getvarient[0]->ibb_variants:'');
			
			$wherecity 					=	array('city_id'=>$location);
			$getcity       				=  	commonmodel::getAllRecordsWhere('master_city',$wherecity);
			$city_name 					=	((count($getcity)>=1)?$getcity[0]->city_name:'');
			
			$wherecolor 				=	array('colour_id'=>$color);
			$getcolor       			=  	commonmodel::getAllRecordsWhere('master_colors',$wherecolor);
			$color_name 				=	((count($getcolor)>=1)?$getcolor[0]->colour_name:'');
			
			/*$ibbpricedetails 			=	ibb::DoApiibbprice($year,
																$makename,
																$model_name,
																$variant_name,
																$city_name,
																$kilometer,
																$owner,
																$color_name
																);*/
			$ibbpricedetails 			=	ibb::ibbprice();
			$ibbprice 					=	json_decode($ibbpricedetails); 
			if($ibbprice->status == 0 && $ibbprice->message	==	"failure")
			{
				return response()->json(['Result'=>'0',
										'PriceList'=>"No Data Available"
										]);
			}
			else
			{
				return response()->json(['Result'=>'1',
										'PriceList'=>[$ibbprice]
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
    
     //VIEW MARKET DETAILS
    public function doviewmarket()
    {   
        $id 						= 	Input::get('session_user_id');
        $car_id 					= 	Input::get('car_id');
        if($id == "" || $car_id	==	"")
        {
			return response()->json(['Result'=>'0',
									'message'=>'All fields are required!!'
									]);
		}
		$schemaname 	=  $this->getschemaname($id);
		if(!empty($schemaname))
		{
			$where 			=	array('car_id'=>$car_id);
			$getresult 		=	inventorymodel::dealerFetchTableDetails($schemaname,
													$this->DmsCarListTable,
													$where
													);
			$queriesdata 	= 	array();
			$smsdata 		= 	array();
			$emaildata 		= 	array();
			if(!empty($getresult) && count($getresult) >= 1)
			{
				foreach($getresult as $uservalue)
				{		
					$imagefetch 				= 	inventorymodel::inventoryImageDetails(
																			$schemaname,
																			$this->DmsCarListPhotosTable,
																			array('car_id'=>$uservalue->car_id)
																			);
					if(count($imagefetch) >=	1)
					{
						$data['image'] 			= 	$imagefetch[0]->s3_bucket_path;
					}
					else
					{
						$data['image'] 			= 	url(config::get('common.carnoimage'));   
					}		
					$pricefilter 				= 	buyymodel::pricebetweenformarketing($uservalue->price);
					$pricefilter_id 			=	((count($pricefilter)>=1)?$pricefilter[0]->option_id:0);
        
					$getfeature 				= 	inventorymodel::inventoryImageDetails(
																			$schemaname,
																			'dealer_listing_features',
																			array('listing_id'=>$uservalue->car_id)
																			);
                    $data['seatnos'] 			=	((count($getfeature)>=1)?$getfeature[0]->seating_capacity:'');																			
					$data['car_id']         	= 	$uservalue->car_id;
					$data['listing_id']       	= 	($uservalue->duplicate_id == null)?"":$uservalue->duplicate_id;
					$data['inventory_type']     = 	$uservalue->inventory_type;
					$data['dealer_id']         	= 	$uservalue->dealer_id;
					$data['price']         		= 	$uservalue->price;
					$data['kms_done']         	= 	$uservalue->kms_done;
					$data['registration_year']  = 	$uservalue->registration_year;
					$data['millege']  			= 	$uservalue->mileage;
					switch($uservalue->owner_type)
					{
						case 'FIRST':
						$data['owner_type']     = 	"1";
						break;
						case 'SECOND':
						$data['owner_type']     = 	"2";
						break;
						case 'THIRD':
						$data['owner_type']     = 	"3";
						break;	
						case 'Fourth':
						$data['owner_type']     = 	"4";
						break;	
						case 'Four +':
						$data['owner_type']     = 	"4 +";
						break;							
					}
					$makewhere					=	array($this->masterMakeIdfiled=>$uservalue->make);
					$getmake 	 				=	inventorymodel::masterschema_table_where(
																				$this->masterMakeTable,
																				$makewhere);
					$data['make'] 				=	((count($getmake)>=1)?$getmake[0]->makename:'');
					$data['make_id'] 			=	$uservalue->make;
					$data['model_id'] 			=	$uservalue->model_id;
					$modelwhere					=	array('model_id'=>$uservalue->model_id);
					$getmodel 	 				=	inventorymodel::masterschema_table_where(
																				$this->masterModelsTable,
																				$modelwhere);
					$data['model'] 				=	((count($getmodel)>=1)?$getmodel[0]->model_name:'');
					$varientwhere				=	array('variant_id'=>$uservalue->variant);
					$getvarient 	 			=	inventorymodel::masterschema_table_where(
																				$this->MasterVariantTable,
																				$varientwhere);
					$data['varient'] 			=	((count($getvarient)>=1)?$getvarient[0]->variant_name:'');
					$colorwhere					=	array('colour_id'=>$uservalue->colors);
					$getcolor 	 				=	inventorymodel::masterschema_table_where(
																				'master_colors',
																				$colorwhere);
					$data['colors'] 			=	((count($getcolor)>=1)?$getcolor[0]->colour_name:'');																																											
					$data['fuel_type']         	= 	$uservalue->fuel_type;
					$data['car_city']         	= 	$uservalue->car_city;
					array_push($queriesdata, $data); 
				}
				$dealer_contact_type			= 	commonmodel::dealer_contact_type()->get();
				if(!empty($dealer_contact_type) && count($dealer_contact_type) >= 1)
				{
					foreach($dealer_contact_type as $fetch)
					{
						$sms['contact_type'] 	= 	$fetch->contact_type;
						$sms['contact_type_id']	= 	$fetch->contact_type_id;
						$sms['count'] 			= 	contactsmodel::marketingsmsstatuscount(
																		$schemaname,
																		$data['car_city'],
																		$data['make_id'],
																		$data['model_id'],
																		$pricefilter_id,
																		$sms['contact_type_id']
																		);
						array_push($smsdata, $sms);
						$email['contact_type'] 		= 	$fetch->contact_type;
						$email['contact_type_id']	= 	$fetch->contact_type_id;
						$email['count'] 			= 	contactsmodel::marketingemailstatuscount(
																				$schemaname,
																				$data['car_city'],
																				$data['make_id'],
																				$data['model_id'],
																				$pricefilter_id,
																				$sms['contact_type_id']
																				);
						array_push($emaildata, $email);
					}
				}

				return response()->json(['Result'=>'1',
										'message'=>'success',
										'marketview'=>$queriesdata,
										'smsdata' 	=>$smsdata,
										'emaildata' =>$emaildata	
										]);	
			}	
			return response()->json(['Result'=>'0',
										'message'=>'Not Found!!'
										]);			
		}
		return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
		
    }
    
    public function doApiMarketingsmsandmail()
    {
		$id 						= 	Input::get('session_user_id');
        $car_id 					= 	Input::get('car_id');
        if($id == "" || $car_id	==	"")
        {
			return response()->json(['Result'=>'0',
									'message'=>'All fields are required!!'
									]);
		}
		$schemaname 	=  $this->getschemaname($id);
		if(!empty($schemaname))
		{
			$phoneno	=	array();
			$emailids	=	array();
			$fetch_master_dealer_schema	= 	buyymodel::masterFetchTableDetails($id,
																$this->masterMainLoginTable,
																array('d_id'=>$id)
																);
			$dealer  	=	array();
			if(count($fetch_master_dealer_schema)>= 1)
			{
				$dealer['dealer_schemaname']	= 	$fetch_master_dealer_schema[0]->dealer_schema_name;
				$dealer['dealer_name']          = 	$fetch_master_dealer_schema[0]->dealer_name;
				$dealer['d_email']              = 	$fetch_master_dealer_schema[0]->d_email;  
				$dealer['dealership_name']      = 	$fetch_master_dealer_schema[0]->dealership_name;
				$dealer['d_mobile']             = 	$fetch_master_dealer_schema[0]->d_mobile;
				$dealer['d_city']               = 	$fetch_master_dealer_schema[0]->d_city;
			}
			
			$where 				=	array('car_id'=>$car_id);
			$getresult 			=	inventorymodel::dealerFetchTableDetails($schemaname,
													$this->DmsCarListTable,
													$where
													);
			if(!empty($getresult) && count($getresult) >= 1)
			{
				foreach($getresult as $uservalue)
				{		
					$imagefetch 				= 	inventorymodel::inventoryImageDetails(
																			$schemaname,
																			$this->DmsCarListPhotosTable,
																			array('car_id'=>$uservalue->car_id)
																			);
					if(count($imagefetch) >=	1)
					{
						$data['image'] 			= 	$imagefetch[0]->s3_bucket_path;
					}
					else
					{
						$data['image'] 			= 	url(config::get('common.carnoimage'));   
					}		       
					$data['car_id']         	= 	$uservalue->car_id;
					$data['inventory_id']       = 	$uservalue->car_id;
					$data['listing_id']       	= 	($uservalue->duplicate_id == null)?"":$uservalue->duplicate_id;
					$data['inventory_type']     = 	$uservalue->inventory_type;
					$data['dealer_id']     		= 	$uservalue->dealer_id;
					$data['price']         		= 	$uservalue->price;
					$data['kilometer_run']      = 	$uservalue->kms_done;
					$data['registration_year']  = 	$uservalue->registration_year;
					$data['mileage']  			= 	$uservalue->mileage;
					$data['body_type']  		= 	$uservalue->body_type;
					switch($uservalue->owner_type)
					{
						case 'FIRST':
						$data['owner_type']     = 	"1";
						break;
						case 'SECOND':
						$data['owner_type']     = 	"2";
						break;
						case 'THIRD':
						$data['owner_type']     = 	"3";
						break;	
						case 'Fourth':
						$data['owner_type']     = 	"4";
						break;	
						case 'Four +':
						$data['owner_type']     = 	"4 +";
						break;							
					}
					$data['created_at'] 		= 	Carbon::parse($uservalue->created_at)->diffForHumans();
					$makewhere					=	array($this->masterMakeIdfiled=>$uservalue->make);
					$getmake 	 				=	inventorymodel::masterschema_table_where(
																				$this->masterMakeTable,
																				$makewhere);
					$data['make'] 				=	((count($getmake)>=1)?$getmake[0]->makename:'');
					$modelwhere					=	array('model_id'=>$uservalue->model_id);
					$getmodel 	 				=	inventorymodel::masterschema_table_where(
																				$this->masterModelsTable,
																				$modelwhere);
					$data['model'] 				=	((count($getmodel)>=1)?$getmodel[0]->model_name:'');
					$varientwhere				=	array('variant_id'=>$uservalue->variant);
					$getvarient 	 			=	inventorymodel::masterschema_table_where(
																				$this->MasterVariantTable,
																				$varientwhere);
					$data['variant'] 			=	((count($getvarient)>=1)?$getvarient[0]->variant_name:'');																																										
					$data['variant_id']         = 	$uservalue->variant;
					$data['fuel_type']         	= 	$uservalue->fuel_type;
					$data['transmission']       = 	$uservalue->transmission;					
					$citywhere					=	array('city_id'=>$uservalue->car_city);
					$getcity 	 				=	inventorymodel::masterschema_table_where(
																				'master_city',
																				$citywhere);
					$data['car_locality'] 		=	((count($getcity)>=1)?$getcity[0]->city_name:'');
                    
					$colorwhere					=	array('colour_id'=>$uservalue->colors);
					$getcolor 	 				=	inventorymodel::masterschema_table_where(
																				'master_colors',
																				$colorwhere);
					$data['colors'] 			=	((count($getcolor)>=1)?$getcolor[0]->colour_name:'');
					$listing_id         = 	$data['car_id'];
					$listing_link       =	url('guestlistingpage/'.$listing_id);
					$shorturl           = 	shortnerurl::shorturl($listing_link);        
					$shorturl 			=	"";
					$sms_data 			= 	array();
					$email_data 		= 	array();
					$productinfo 		= 	$data['make'].' '.$data['model'].' '.$data['registration_year'];
					$productcity 		= 	$data['car_locality'];
					$noofdays 			= 	Carbon::parse($uservalue->created_at)->diffForHumans();
					$kmdone 			= 	$data['kilometer_run'];
					$vehicletype 		=	$data['body_type'];
					$registrationyear 	= 	$data['registration_year'];
					$noowner 			= 	$data['owner_type'];
					$productprice 		= 	$data['price'];
					
					$maildata 			= 	array('',
												$data['image'],
												$productinfo,
												$productcity,
												$noofdays,
												$kmdone,
												$vehicletype,
												$registrationyear,
												$noowner,
												$productprice,
												$shorturl
												);
        
        
				if(!empty(Input::get('sms')))
				{
					foreach(Input::get('sms') as $value)
					{
						$sms_data[] = $value;
					}
				}
				//print_r($sms_data);
				if(!empty(Input::get('email')))
				{
					foreach(Input::get('email') as $fetch)
					{
						$email_data[] = $fetch;                
					}   
				} 

				$job 	= 	new \App\Jobs\marketingqueue($data,$sms_data,$email_data,$dealer,$shorturl,$maildata);
				dispatch($job);
				return response()->json(['Result'=>'1',
									'message'=>'Successfully send!!'
									]);
				}
			}
			return response()->json(['Result'=>'0',
									'message'=>'No Founds!!'
									]);
		}
		return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
	}       
	
	 //VIEW MARKET DETAILS
    public function doViewSold()
    {   
        $id 						= 	Input::get('session_user_id');
        $car_id 					= 	Input::get('car_id');
        if($id == "" || $car_id	==	"")
        {
			return response()->json(['Result'=>'0',
									'message'=>'All fields are required!!'
									]);
		}
		$schemaname 	=  $this->getschemaname($id);
		if(!empty($schemaname))
		{	
			$expense_info 	=	array();
			$where 			=	array('car_id'=>$car_id);
			$getresult 		=	inventorymodel::dealerFetchTableDetails($schemaname,
													$this->DmsCarListTable,
													$where
													);
			$queriesdata 	= 	array();
			$documentdata	=	array();
			if(!empty($getresult) && count($getresult) >= 1)
			{
				foreach($getresult as $uservalue)
				{
					$data['car_id'] 	= 	$uservalue->car_id;
					$data['vininfo']    = 	$uservalue->chassis_number;
					$data['registration']    = 	$uservalue->registration_number;
					$expense_info 		= 	inventorymodel::inventoryImageDetails($schemaname,
																			'dealer_car_expenses',
																			array('car_id'=>$uservalue->car_id)
																			);
																			
					$pricing_info 		= 	inventorymodel::inventoryImageDetails($schemaname,
																			'dealer_cars_pricing',
																			array('listing_id'=>$uservalue->car_id)
																			);

					if($uservalue->inventory_type 	==	'PARKANDSELL' )
					{
						$purchased_price	=	(count($pricing_info)>=1?$pricing_info[0]->customer_asking_price:'');
					}
					else
					{
						$purchased_price	=	(count($pricing_info)>=1?$pricing_info[0]->ownpurchased_price:'');
					}
        
					$getoriginalprice 		=	inventorymodel::inventoryImageDetails($schemaname,
																					'dealer_sales',
																					array('inventory_id'=>$uservalue->car_id)
																					);
					$data['saleprice'] 		=	(count($getoriginalprice)>=1?$getoriginalprice[0]->saleprice:$uservalue->price);
					$data['purchaseprice'] 	=	(count($getoriginalprice)>=1?$getoriginalprice[0]->purchaseprice:$purchased_price);
					$data['saledate']     	= 	(count($getoriginalprice)>=1?$getoriginalprice[0]->saledate:'');
					$data['salesperson']    = 	(count($getoriginalprice)>=1?$getoriginalprice[0]->salesperson:'');
					$data['purchaser']    	= 	(count($getoriginalprice)>=1?$getoriginalprice[0]->purchaser:'');
					$data['markupprice']    = 	(count($pricing_info)>=1?$pricing_info[0]->dealer_markup_price:'');
					array_push($queriesdata, $data);
					unset($data); 
				}
					$getdocument 	=	inventorymodel::inventoryImageDetails($schemaname,
																		'dealer_sales_documents',
																		array('inventory_id'=>$car_id)
																	);
					$arraydocument	=	array(0,1,2,3,4,5);
					if(!empty($getdocument) && count($getdocument)>=1)
					{
						foreach($getdocument as $document)
						{
							$data['document_no'] 	=	$document->document_no;
							$data['document_name'] 	=	$document->document_name;
							$data['filename'] 		=	$document->filename;
							$data['file_path'] 		=	$document->file_path;
							$documentno[] 			=	$document->document_no;
							array_push($documentdata,$data);
						}						
						$documentdiff	=	array_diff($arraydocument,$documentno);
						foreach($documentdiff as $photos)
						{
							$emptydata['document_no'] 	= 	$photos;
							$emptydata['document_name'] = 	"";
							$emptydata['filename'] 		= 	"";
							$emptydata['file_path'] 	= 	"";
							array_push($documentdata,$emptydata);
						}
						unset($emptydata);
					}
					else
					{
						foreach($arraydocument as $value)
						{
							$emptydata['document_no'] 	= 	$value;
							$emptydata['document_name'] = 	"";
							$emptydata['filename'] 		= 	"";
							$emptydata['file_path'] 	= 	"";
							array_push($documentdata,$emptydata);
						}
					}
					return response()->json(['Result'=>'1',
										'message'=>'success',
										'soldview'=>$queriesdata,
										'expensedata'=>$expense_info,
										'documents'=>$documentdata	
										]);	
			}
			return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
			}	
		return response()->json(['Result'=>'0',
										'message'=>'Invalid Access!!'
										]);			
	}		
	/*THIS FUNCTION USED UPLOAD sold DOCUMENTS*/
    public function doApiApplySold()
    {          
        $id 			= 	Input::get('session_user_id');
        $car_id 		= 	Input::get('car_id');
        $vinno 			= 	Input::get('vinno');
        $registrationno = 	Input::get('registrationno');
        $purchaseprice 	= 	Input::get('purchaseprice');
        $saleprice 		= 	Input::get('saleprice');
        $saledate 		= 	Input::get('saledate');
        $salesperson 	= 	Input::get('salesperson');
        $purchasername 	= 	Input::get('purchasername');
		$document  		= 	Input::file('document');
		$documentnameall= 	Input::get('documentname');
		
        if($id == "" || $car_id	==	"" || $saledate ==	"" || $salesperson == "" || $purchasername == "" )
        {
			return response()->json(['Result'=>'0',
									'message'=>'All fields are required!!'
									]);
		}
		$schemaname 	=  $this->getschemaname($id);
		if(!empty($schemaname))
		{
			//check exist in sales for thi car
			$getoriginalprice 	=	inventorymodel::inventoryImageDetails($schemaname,
																			'dealer_sales',
																			array('inventory_id'=>$car_id)
																			);
			$getsalesid 		=	(count($getoriginalprice)>=1?$getoriginalprice[0]->id:'');
			if(!empty($getoriginalprice) && count($getoriginalprice) >= 1)
			{
				$InsertDocuments 	= 	array('saledate'=>$saledate, 
											  'salesperson'=>$salesperson,
											  'purchaser'=>$purchasername     
											  );
				$WhereDcoument		= 	array('inventory_id' => $car_id);
				$updatesales  		=	inventorymodel::dealerUpdateTableDetails(
											$id,
											$schemaname,
											'dealer_sales',
											$WhereDcoument,
											$InsertDocuments
										);
				//update car master table
				$Insertcar 			= 	array('car_master_status'=>3);
				$Wherecar			= 	array('car_id'	=> $car_id);
				$updatesales  		=	inventorymodel::dealerUpdateTableDetails(
											$id,
											$schemaname,
											'dms_car_listings',
											$Wherecar,
											$Insertcar
										);
			}
			else
			{
				$InsertDocuments 	= 	array(	'inventory_id'=>$car_id,
												'vinno'=>$vinno,
												'registrationno'=>$registrationno,
												'purchaseprice'=>$purchaseprice,
												'saleprice'=>$saleprice,
												'saledate'=>$saledate, 
												'salesperson'=>$salesperson,
												'purchaser'=>$purchasername     
											  );
				$getsalesid 		=	inventorymodel::dealerInsertTable($schemaname,
													'dealer_sales',
													$InsertDocuments
													);
				//update car master table
				$Insertcar 			= 	array('car_master_status'=>3);
				$Wherecar			= 	array('car_id'	=> $car_id);
				$updatesales  		=	inventorymodel::dealerUpdateTableDetails(
											$id,
											$schemaname,
											'dms_car_listings',
											$Wherecar,
											$Insertcar
										);
			}
			if(!empty($document))
			{
				$data 			=	"";
				$checkformat 	=	"";
				foreach($document as $key=>$documentname)
				{
					$checkformat 	=	$documentname->getClientOriginalExtension();
					if($checkformat == "jpg" || $checkformat == "jpeg" || $checkformat == "png" || $checkformat == "pdf"  || $checkformat == "docx" || $checkformat == "doc")
					{
						$WhereDcoument 		= 	array('inventory_id'=>$car_id,'document_no'=>$key);
						$getresult 			=	inventorymodel::dealerFetchTableDetails($schemaname,
															'dealer_sales_documents',
															$WhereDcoument
															);	
						$extension   		= 	$documentname->getClientOriginalExtension();
						$destinationPath   	= 	"uploadimages/".$schemaname."/documents";
						if(count($getresult) <=	0)
						{
							$image_upload_result= 	fileuploadmodel::any_upload($documentname,$destinationPath,$extension);
							$fileContents 		= 	public_path("/uploadimages/".$schemaname."/documents/").$image_upload_result;
							$result 			= 	Storage::put("/uploadimages/".$schemaname.'/saledocument/'.$image_upload_result, 
														file_get_contents($fileContents),
														'public');
							$s3_bucket_path 	=	'https://s3-ap-southeast-1.amazonaws.com/dealerplus/uploadimages/'.$schemaname.'/saledocument/'.$image_upload_result;
							unlink($fileContents);
							$InsertDocuments      	= 	array('inventory_id'=>$car_id, 
														  'sales_id'=>$getsalesid,
														  'document_no'=>$key, 
														  'document_name'=>$documentnameall[$key],
														  'filename'=>$image_upload_result,
														  'file_path'=>url("/uploadimages/".$schemaname."/documents/".$image_upload_result)     
														  );
							$data[$key]			=	stripcslashes($s3_bucket_path);
							inventorymodel::dealerInsertTable($schemaname,
																'dealer_sales_documents',
																$InsertDocuments
																);
						}
						else
						{
							Storage::delete("/uploadimages/".$schemaname.'/saledocument/'.$getresult[0]->filename);
							$image_upload_result  	= 	fileuploadmodel::any_upload($documentname,$destinationPath,$extension);

							$fileContents 	= 	public_path("/uploadimages/".$schemaname."/documents/").$image_upload_result;
							$result 		= 	Storage::put("/uploadimages/".$schemaname.'/saledocument/'.$image_upload_result, file_get_contents($fileContents),'public');
							$s3_bucket_path =	'https://s3-ap-southeast-1.amazonaws.com/dealerplus/uploadimages/'.$schemaname.'/saledocument/'.$image_upload_result;
							unlink($fileContents);
							$InsertDocuments      	= 	array('inventory_id'=>$car_id, 
														  'sales_id'=>$getsalesid,
														  'document_no'=>$key, 
														  'document_name'=>$documentnameall[$key],
														  'filename'=>$image_upload_result,
														  'file_path'=>url("/uploadimages/".$schemaname."/documents/".$image_upload_result)     
														  );
							$data[$key]		=	stripcslashes($s3_bucket_path);
							$WhereDcoument	= 	array('inventory_id' => $car_id,'document_no' =>$getresult[0]->document_no);
							
							inventorymodel::dealerUpdateTableDetails(
												$id,
												$schemaname,
												'dealer_sales_documents',
												$WhereDcoument,
												$InsertDocuments
												);
						}
					}
					else
					{
						if($key== 0)
						{
							return response()->json(['Result'=>'0',
										'message'=>'Document 1 is UnSupported File.Supported Formats are doc,docx,pdf,jpg,jpeg,png!!'
										]);
						}
						else if($key== 1)
						{
							return response()->json(['Result'=>'0',
										'message'=>'Document 2 is UnSupported File.Supported Formats are doc,docx,pdf,jpg,jpeg,png!!'
										]);
						}
						else if($key== 2)
						{
							return response()->json(['Result'=>'0',
										'message'=>'Document 3 is UnSupported File.Supported Formats are doc,docx,pdf,jpg,jpeg,png!!'
										]);
						}
						else if($key== 3)
						{
							return response()->json(['Result'=>'0',
										'message'=>'Document 4 is UnSupported File.Supported Formats are doc,docx,pdf,jpg,jpeg,png!!'
										]);
						}
						else if($key== 4)
						{
							return response()->json(['Result'=>'0',
										'message'=>'Document 5 is UnSupported File.Supported Formats are doc,docx,pdf,jpg,jpeg,png!!'
										]);
						}
						else
						{
							return response()->json(['Result'=>'0',
										'message'=>'Document 6 is UnSupported File.Supported Formats are doc,docx,pdf,jpg,jpeg,png!!'
										]);
						}
					}
				}
				return response()->json(['Result'=>'1',
										'message'=>'Successfully Uploaded!!',
										'document'=>$data
										]);
			}
			return response()->json(['Result'=>'1',
										'message'=>'Successfully Updated!!'
										]);
		}
		return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
		
    }
    
    //GET VIN INFO FROM FAST LANE API
    public function doApiViewvinInfo()
    {
        $id 				= 	Input::get('session_user_id');
        $registernumber 	= 	Input::get('registerNumber');
        $registernumber		=	strtoupper($registernumber);        
        if($id 	==	"" || $registernumber 	==	"")
        {
			return response()->json(['Result'=>'0',
									'message'=>'User Id is required!!'
									]);
		}
		$schemaname 		=  	$this->getschemaname($id);
		if(!empty($schemaname))
		{	
			//CHECK REGISTER NUMBER IS AVAILABLE OR NOT
			$checkregnum 				=	fastlanemongo::where('regn_no',$registernumber)->get();
			if(!empty($checkregnum) && count($checkregnum) >= 1)
			{
				foreach($checkregnum as $getvininfo)
				{
					$makewhere				=	array('ibb_make'=>$getvininfo->vehicle['fla_maker_desc']);
					$getmake 	 			=	inventorymodel::masterschema_table_where(
																		$this->masterMakeTable,
																		$makewhere);
					$modelwhere				=	array('ibb_model'=>$getvininfo->vehicle['fla_model_desc']);
					$getmodel 	 			=	inventorymodel::masterschema_table_where(
																		$this->masterModelsTable,
																		$modelwhere);
					$varientwhere			=	array('ibb_variants'=>$getvininfo->vehicle['fla_variant']);
					$getvarient 	 		=	inventorymodel::masterschema_table_where(
																		$this->MasterVariantTable,
																		$varientwhere);
					$wherecity 				=	array('city_name'=>$getvininfo->vehicle['c_city']);
					$getcity       			=  	commonmodel::getAllRecordsWhere('master_city',$wherecity);
					$wherecolor 			=	array('colour_name'=>$getvininfo->vehicle['color']);
					$getcolor       		=  	commonmodel::getAllRecordsWhere('master_colors',$wherecolor);
					
					
					$data['vehicle']['makename'] 		=	((count($getmake)>=1)?$getmake[0]->makename:'');
					$data['vehicle']['makeid'] 			=	((count($getmake)>=1)?$getmake[0]->make_id:'');
					$data['vehicle']['modelname']  		=	((count($getmodel)>=1)?$getmodel[0]->model_name:'');
					$data['vehicle']['modelid']  		=	((count($getmodel)>=1)?$getmodel[0]->model_id:'');
					$data['vehicle']['variantname'] 	=	((count($getvarient)>=1)?$getvarient[0]->variant_name:'');
					$data['vehicle']['variantid'] 		=	((count($getvarient)>=1)?$getvarient[0]->variant_id:'');
					$data['vehicle']['cityname'] 		=	((count($getcity)>=1)?$getcity[0]->city_name:'');
					$data['vehicle']['cityid'] 			=	((count($getcity)>=1)?$getcity[0]->city_id:'');
					$data['vehicle']['color'] 			=	((count($getcolor)>=1)?$getcolor[0]->colour_name:'');
					$data['vehicle']['colorid'] 		=	((count($getcolor)>=1)?$getcolor[0]->colour_id:'');
					$data['vehicle']['fla_maker_desc'] 	=	$getvininfo->vehicle['fla_maker_desc'];
					$data['vehicle']['fla_model_desc'] 	=	$getvininfo->vehicle['fla_model_desc'];
					$data['vehicle']['fla_variant'] 	=	$getvininfo->vehicle['fla_variant'];
					$data['vehicle']['fuel_type_desc'] 	=	$getvininfo->vehicle['fuel_type_desc'];
					$data['vehicle']['regn_no'] 		=	$getvininfo->regn_no;
					$data['vehicle']['rto_cd'] 			=	$getvininfo->vehicle['rto_cd'];
					$data['vehicle']['rto_name'] 		=	$getvininfo->vehicle['rto_name'];
					$data['vehicle']['chasi_no'] 		=	$getvininfo->vehicle['chasi_no'];
					$data['vehicle']['eng_no'] 			=	$getvininfo->vehicle['eng_no'];
					$data['vehicle']['regn_dt'] 		=	date('Y-m-d',strtotime($getvininfo->vehicle['regn_dt']));
					$data['vehicle']['purchase_dt'] 	=	date('Y-m-d',strtotime($getvininfo->vehicle['purchase_dt']));
					$data['vehicle']['vh_class_desc'] 	=	$getvininfo->vehicle['vh_class_desc'];
					$data['vehicle']['fla_vh_class_desc'] 	=	$getvininfo->vehicle['fla_vh_class_desc'];
					switch($getvininfo->vehicle['owner_sr'])
					{
						case 1:
						$data['vehicle']['owner_sr'] 	=	'1';
						break;
						case 2:
						$data['vehicle']['owner_sr'] 	=	'2';
						break;
						case 3:
						$data['vehicle']['owner_sr'] 	=	'3';
						break;
						case 4:
						$data['vehicle']['ownerid'] 	=	'4';
						break;
						case 5:
						$data['vehicle']['ownerid'] 	=	'4 +';
						break;
					}
					$data['vehicle']['owner_cd_desc'] 	=	$getvininfo->vehicle['owner_cd_desc'];
					$data['vehicle']['regn_type'] 		=	$getvininfo->vehicle['regn_type'];
					$data['vehicle']['regn_type_desc'] 	=	$getvininfo->vehicle['regn_type_desc'];
					$data['vehicle']['c_city'] 			=	$getvininfo->vehicle['c_city'];
					$data['vehicle']['c_pincode'] 		=	$getvininfo->vehicle['c_pincode'];
					$data['vehicle']['p_city'] 			=	$getvininfo->vehicle['p_city'];
					$data['vehicle']['p_pincode'] 		=	$getvininfo->vehicle['p_pincode'];
					$data['vehicle']['vehicle_cd'] 		=	$getvininfo->vehicle['vehicle_cd'];
					$data['vehicle']['maker_desc'] 		=	$getvininfo->vehicle['maker_desc'];
					$data['vehicle']['series'] 			=	$getvininfo->vehicle['series'];
					$data['vehicle']['maker_model'] 	=	$getvininfo->vehicle['maker_model'];
					$data['vehicle']['fla_sub_variant']	=	$getvininfo->vehicle['fla_sub_variant'];
					$data['vehicle']['fuel_type_desc'] 	=	$getvininfo->vehicle['fuel_type_desc'];
					$data['vehicle']['color'] 			=	$getvininfo->vehicle['color'];
					$data['vehicle']['fla_fuel_type_desc'] =	$getvininfo->vehicle['fla_fuel_type_desc'];
					$data['vehicle']['cubic_cap'] 		=	$getvininfo->vehicle['cubic_cap'];
					$data['vehicle']['fla_cubic_cap'] 	=	$getvininfo->vehicle['fla_cubic_cap'];
					$data['vehicle']['manu_yr'] 		=	$getvininfo->vehicle['manu_yr'];
					$data['vehicle']['seat_cap'] 		=	$getvininfo->vehicle['seat_cap'];
					$data['vehicle']['fla_seat_cap'] 	=	$getvininfo->vehicle['fla_seat_cap'];
					$data['hypth']['hp_type'] 			=	$getvininfo->hypth['hp_type'];
					$data['hypth']['fncr_name'] 		=	$getvininfo->hypth['fncr_name'];
					$data['hypth']['fla_fncr_name'] 	=	$getvininfo->hypth['fla_fncr_name'];
					$data['hypth']['from_dt'] 			=	$getvininfo->hypth['from_dt'];
					$data['insurance']['comp_cd_desc'] 	=	$getvininfo->insurance['comp_cd_desc'];
					$data['insurance']['fla_ins_name'] 	=	$getvininfo->insurance['fla_ins_name'];
					$data['insurance']['ins_type_desc'] =	$getvininfo->insurance['ins_type_desc'];
					$data['insurance']['ins_from'] 		=	$getvininfo->insurance['ins_from'];
					$data['insurance']['ins_upto'] 		=	$getvininfo->insurance['ins_upto'];
					
				}
				return response()->json(['Result'=>'1',
										'VinInfo'=>[$data]
										]);
			}
			$vininfidetails 			=	fastlane::fetch_vehicle_detail($registernumber);
			$getvininfo 				=	json_decode($vininfidetails); 
			if($getvininfo->status == 101 && $getvininfo->description	==	"Record not found")
			{
				return response()->json(['Result'=>'0',
										'VinInfo'=>"No Data Available"
										]);
			}
			else
			{
				$datainsert 			=	new fastlanemongo;
				$datainsert['regn_no'] 	=	$getvininfo->results[0]->vehicle->regn_no;
				$datainsert['success'] 	=	"100";
				foreach($getvininfo->results[0] as $key=>$vehicle)
				{
					if($key 	==	"vehicle")
					{
						$datainsert['vehicle'] 	=	$vehicle;
					}
					if($key 	==	"hypth")
					{
						$datainsert['hypth'] 	=	$vehicle;
					}
					if($key 	==	"insurance")
					{
						$datainsert['insurance'] 	=	$vehicle;
					}
				}
				$datainsert['fastlane_status']=	"Active";
				$datainsert->save();
				$getvininfo 	=	fastlanemongo::orderBy('created_at','desc')->first();
				if(!empty($getvininfo->vehicle))
				{
					$makewhere				=	array('ibb_make'=>$getvininfo->vehicle['fla_maker_desc']);
					$getmake 	 			=	inventorymodel::masterschema_table_where(
																		$this->masterMakeTable,
																		$makewhere);
					$modelwhere				=	array('ibb_model'=>$getvininfo->vehicle['fla_model_desc']);
					$getmodel 	 			=	inventorymodel::masterschema_table_where(
																		$this->masterModelsTable,
																		$modelwhere);
					$varientwhere			=	array('ibb_variants'=>$getvininfo->vehicle['fla_variant']);
					$getvarient 	 		=	inventorymodel::masterschema_table_where(
																		$this->MasterVariantTable,
																		$varientwhere);
					$wherecity 				=	array('city_name'=>$getvininfo->vehicle['c_city']);
					$getcity       			=  	commonmodel::getAllRecordsWhere('master_city',$wherecity);
					$wherecolor 			=	array('colour_name'=>$getvininfo->vehicle['color']);
					$getcolor       		=  	commonmodel::getAllRecordsWhere('master_colors',$wherecolor);
					
					$data['vehicle']['makename'] 		=	((count($getmake)>=1)?$getmake[0]->makename:'');
					$data['vehicle']['makeid'] 			=	((count($getmake)>=1)?$getmake[0]->make_id:'');
					$data['vehicle']['modelname']  		=	((count($getmodel)>=1)?$getmodel[0]->model_name:'');
					$data['vehicle']['modelid']  		=	((count($getmodel)>=1)?$getmodel[0]->model_id:'');
					$data['vehicle']['variantname'] 	=	((count($getvarient)>=1)?$getvarient[0]->variant_name:'');
					$data['vehicle']['variantid'] 		=	((count($getvarient)>=1)?$getvarient[0]->variant_id:'');
					$data['vehicle']['cityname'] 		=	((count($getcity)>=1)?$getcity[0]->city_name:'');
					$data['vehicle']['cityid'] 			=	((count($getcity)>=1)?$getcity[0]->city_id:'');
					$data['vehicle']['color'] 			=	((count($getcolor)>=1)?$getcolor[0]->colour_name:'');
					$data['vehicle']['colorid'] 		=	((count($getcolor)>=1)?$getcolor[0]->colour_id:'');
					$data['vehicle']['fla_maker_desc'] 	=	$getvininfo->vehicle['fla_maker_desc'];
					$data['vehicle']['fla_model_desc'] 	=	$getvininfo->vehicle['fla_model_desc'];
					$data['vehicle']['fla_variant'] 	=	$getvininfo->vehicle['fla_variant'];
					$data['vehicle']['fuel_type_desc'] 	=	$getvininfo->vehicle['fuel_type_desc'];
					$data['vehicle']['regn_no'] 		=	$getvininfo->regn_no;
					$data['vehicle']['rto_cd'] 			=	$getvininfo->vehicle['rto_cd'];
					$data['vehicle']['rto_name'] 		=	$getvininfo->vehicle['rto_name'];
					$data['vehicle']['chasi_no'] 		=	$getvininfo->vehicle['chasi_no'];
					$data['vehicle']['eng_no'] 			=	$getvininfo->vehicle['eng_no'];
					$data['vehicle']['regn_dt'] 		=	date('Y-m-d',strtotime($getvininfo->vehicle['regn_dt']));
					$data['vehicle']['purchase_dt'] 	=	date('Y-m-d',strtotime($getvininfo->vehicle['purchase_dt']));
					$data['vehicle']['vh_class_desc'] 	=	$getvininfo->vehicle['vh_class_desc'];
					$data['vehicle']['fla_vh_class_desc'] 	=	$getvininfo->vehicle['fla_vh_class_desc'];
					switch($getvininfo->vehicle['owner_sr'])
					{
						case 1:
						$data['vehicle']['owner_sr'] 	=	'1';
						break;
						case 2:
						$data['vehicle']['owner_sr'] 	=	'2';
						break;
						case 3:
						$data['vehicle']['owner_sr'] 	=	'3';
						break;
						case 4:
						$data['vehicle']['ownerid'] 	=	'4';
						break;
						case 5:
						$data['vehicle']['ownerid'] 	=	'4 +';
						break;
					}
					$data['vehicle']['owner_cd_desc'] 	=	$getvininfo->vehicle['owner_cd_desc'];
					$data['vehicle']['regn_type'] 		=	$getvininfo->vehicle['regn_type'];
					$data['vehicle']['regn_type_desc'] 	=	$getvininfo->vehicle['regn_type_desc'];
					$data['vehicle']['c_city'] 			=	$getvininfo->vehicle['c_city'];
					$data['vehicle']['c_pincode'] 		=	$getvininfo->vehicle['c_pincode'];
					$data['vehicle']['p_city'] 			=	$getvininfo->vehicle['p_city'];
					$data['vehicle']['p_pincode'] 		=	$getvininfo->vehicle['p_pincode'];
					$data['vehicle']['vehicle_cd'] 		=	$getvininfo->vehicle['vehicle_cd'];
					$data['vehicle']['maker_desc'] 		=	$getvininfo->vehicle['maker_desc'];
					$data['vehicle']['series'] 			=	$getvininfo->vehicle['series'];
					$data['vehicle']['maker_model'] 	=	$getvininfo->vehicle['maker_model'];
					$data['vehicle']['fla_sub_variant']	=	$getvininfo->vehicle['fla_sub_variant'];
					$data['vehicle']['fuel_type_desc'] 	=	$getvininfo->vehicle['fuel_type_desc'];
					$data['vehicle']['color'] 			=	$getvininfo->vehicle['color'];
					$data['vehicle']['fla_fuel_type_desc'] =	$getvininfo->vehicle['fla_fuel_type_desc'];
					$data['vehicle']['cubic_cap'] 		=	$getvininfo->vehicle['cubic_cap'];
					$data['vehicle']['fla_cubic_cap'] 	=	$getvininfo->vehicle['fla_cubic_cap'];
					$data['vehicle']['manu_yr'] 		=	$getvininfo->vehicle['manu_yr'];
					$data['vehicle']['seat_cap'] 		=	$getvininfo->vehicle['seat_cap'];
					$data['vehicle']['fla_seat_cap'] 	=	$getvininfo->vehicle['fla_seat_cap'];
					$data['hypth']['hp_type'] 			=	$getvininfo->hypth['hp_type'];
					$data['hypth']['fncr_name'] 		=	$getvininfo->hypth['fncr_name'];
					$data['hypth']['fla_fncr_name'] 	=	$getvininfo->hypth['fla_fncr_name'];
					$data['hypth']['from_dt'] 			=	$getvininfo->hypth['from_dt'];
					$data['insurance']['comp_cd_desc'] 	=	$getvininfo->insurance['comp_cd_desc'];
					$data['insurance']['fla_ins_name'] 	=	$getvininfo->insurance['fla_ins_name'];
					$data['insurance']['ins_type_desc'] =	$getvininfo->insurance['ins_type_desc'];
					$data['insurance']['ins_from'] 		=	$getvininfo->insurance['ins_from'];
					$data['insurance']['ins_upto'] 		=	$getvininfo->insurance['ins_upto'];					

					return response()->json(['Result'=>'1',
											'VinInfo'=>[$data]
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
    //GET SCHEMA NAME FUNCTION
    public function getschemaname($id)
    {
		$getdealer_schemaname 	  		=	inventorymodel::masterFetchTableDetails('',
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
		$getdealer_schemaname 	  		=	inventorymodel::masterFetchTableDetails('',
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
