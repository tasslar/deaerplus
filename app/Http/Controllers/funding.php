<?php
/*
  Module Name : funding 
  Created By  : vinoth 20-02-2017 Version 1.0
  Module 	  : Funding module
  Use of this module is Add funding with frshservice api,
*/
namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\model\fundingmodel;
use App\model\commonmodel;
use App\model\emailmodel;
use App\model\notificationsmodel;
use Illuminate\Support\Facades\Mail;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Validator;
use Exception;
use Session;
use Config;
use Redirect;
use Carbon\Carbon;
use App\model\exportmodel;
use App\model\report;

class funding extends Controller
{
    public $header_data;
    public $session_names;
    public $dmsdealerTable;
    public $masterCityTable;
    public $dmscardealerTable;
    public $login_authecation;
    public $active_menu_name;
    public $dealer_schemaname;
    public $id;
    public $DmsCarListPhotosTable;
    public $DmsCarListVideosTable;
    public $DmsCarListDocumentTable;
    public $MasterVariantTable;
    public $masterModelsTable;
    public $masterMakeTable;
    public $FundingTable;
    public $LoanTable;
   
    public function __construct()
    {
		$this->dmsdealerTable 			=	"dms_dealers";
		$this->dmscardealerTable 		=	"dms_car_listings";
		$this->masterCityTable 			=	"master_city";
        $this->DmsCarListPhotosTable    = 	"dms_car_listings_photos";
        $this->DmsCarListVideosTable    = 	"dms_car_listings_videos";
        $this->DmsCarListDocumentTable  = 	"dms_car_listings_documents";
        $this->MasterVariantTable       = 	"master_variants";
        $this->masterModelsTable		=	"master_models";
        $this->masterMakeTable			=	"master_makes";
        $this->FundingTable				=	"dealer_funding_details";
        $this->LoanTable				=	"dealer_customerloan_details";
		$this->active_menu_name         = 	'fund_menu';
		$this->middleware(function ($request, $next) {
              $this->login_authecation	= 	session()->has( 'ses_dealername' ) ? session()->get( 'ses_dealername' ) :  Redirect::to('login')->send();
              $this->header_data      	= 	commonmodel::commonheaderdata();
              $this->dealer_schemaname	=	Session::get('dealer_schema_name');
              $this->id					=	Session::get('ses_id');
			return $next($request);
        });
    }

    public function index()
    {
        return view('home');
    }

    public function doViewfundingPage()
    {
    	try
		{
			if(Input::has('i'))
			{
				$searchfundingno = Input::get('i');
			}
			else
			{
				$searchfundingno = '';
			}
			$fundingticketid 			=	"";
			if(isset($_REQUEST['FundingTicketid'])){
                $fundingticketid 		= 	decrypt($_REQUEST['FundingTicketid']);
            }
			
			$fundingdetails		=	array();
			$arraywhere			=	array('user_id'=>$this->id);
			$getfundingresult 	=	fundingmodel::doGetfundingdetails($arraywhere);
			if(!empty($getfundingresult) && count($getfundingresult))
			{
				foreach($getfundingresult as $fundingvalue)
				{
					$fundingdata['fundingid']				=	$fundingvalue->dealer_funding_detail_id;
					$fundingdata['dealername']				=	$fundingvalue->dealershipname;
					$fundingdata['dealermobileno']			=	$fundingvalue->dealermobileno;
					$fundingdata['dealermailid']			=	$fundingvalue->dealermailid;
					$fundingdata['requested_amount']		=	$fundingvalue->requested_amount;
					$fundingdata['created_date']			=	$fundingvalue->created_date;
					$fundingdata['dealercity']				=	$fundingvalue->dealercity;
					$fundingdata['branchname']				=	$fundingvalue->branchname;
					$fundingdata['dealer_listing_id']		=	$fundingvalue->dealer_listing_id;
					switch($fundingvalue->status)
					{
						case 0:
						$fundingdata['status']				=	"In Progress";
						break;
						case 1:
						$fundingdata['status']				=	"Approved";
						break;
						case 2:
						$fundingdata['status']				=	"Declined";
						break;
						case 3:
						$fundingdata['status']				=	"Revoked";
						break;
					}
					$fundingdata['dealer_funding_ticket_id']=	$fundingvalue->dealer_funding_ticket_id;
					array_push($fundingdetails,$fundingdata);
				}
			}
			$id           		= 	session::get('ses_id'); 
			$header_data  		= 	$this->header_data;
			$left_menu    		= 	'1';
			$compact_array		= 	array('active_menu_name'=>$this->active_menu_name,
									'left_menu'=>1,
									'fundingdata'=>$fundingdetails,
									'Fundingticket'=>$fundingticketid,
									'searchfundingno'=>$searchfundingno
									);        
			$header_data['title']	=	'Funding';
		}
		catch(Exception $e){
			throw new CustomException($e->getMessage());
		} 
			return view('applied_fund_car_view', compact('compact_array', 'header_data'));
    }
    
    public function addfunding()
    {
		try
		{
			$id           	= 	session::get('ses_id'); 
			$header_data 	= 	$this->header_data;
			$left_menu    	= 	'1';
			//get dealer user details from dms_dealers
			$wheredealer	=	array('d_id'=>$id);
			$dealershipassigname 	=	"";
			$dealerdetails  = 	fundingmodel::doGetmasterdetails($this->dmsdealerTable,$wheredealer);
			if(!empty($dealerdetails))
			{
				$assgindealer 	=	$dealerdetails[0]->dealership_name;
				$parent_id 		=	$dealerdetails[0]->parent_id;
				if($assgindealer 	==	"")
				{
					$parentdealer  = 	fundingmodel::doGetmasterdetails($this->dmsdealerTable,array('d_id'=>$parent_id));
					$dealershipassigname 	=	(!empty($parentdealer)?$parentdealer[0]->dealership_name:'Test');
				}
			}
			$cityid 		=	((count($dealerdetails)>=1)?$dealerdetails[0]->d_city:'526');
			$whercity 		=	array('city_id'=>$cityid);
			$sortbycity   	= 	fundingmodel::dealerFetchTableDetailsgrouby(
																			$this->dealer_schemaname,
																			$this->dmscardealerTable,
																			'car_city');
		    $citydata		=	array();
			$citynamesort 	=	$sortbycity->pluck('car_city');
			if(!empty($citynamesort) && count($citynamesort)>=1)
			{
				foreach($citynamesort as $value)
				{
					$citydata[] 	=	$value;
				}
			}
			$dealercity 	=	fundingmodel::dealerFetchTablewherein($this->masterCityTable,$citydata,'city_id');
			$compact_array	= 	array('active_menu_name'=>$this->active_menu_name,
									'left_menu'=>1,
									'side_bar_active'=>1,
									'dealercityname'=>$dealercity,
									'dealershipassigname'=>$dealershipassigname,
									'dealerdetails'=>$dealerdetails
									);        
			$header_data['title']	=	'Funding';
		}
		catch(Exception $e){
			throw new CustomException($e->getMessage());
		} 
			return view('addfund', compact('compact_array', 'header_data'));
	}
    
    public function dofetchcarmodeldetails()
    {
		$notexistcarid	=	array();
        $city_id		=	Input::get('city_id');
        $branchid		=	Input::get('branch');
        $car_name		=	Input::get('searchcar');
        $typeofrequest	=	Input::get('typeofrequest');
        $notexistcarid	=	collect(Input::get('appendcar')); 
        $customerid		=	Input::get('customerid');
        $schemaname 	= 	$this->dealer_schemaname;
        $cardata		=	array();
        $cardetails		=	array();
		if(!empty($branchid))
		{
			if($typeofrequest	==	"Loanpage")
			{
				$wherebranch	=	array('car_city'=>$city_id,'branch_id'=>$branchid);
				//$wherebranch	=	array('car_city'=>$city_id,'branch_id'=>$branchid,'loan_applied'=>'0');
			}
			else
			{
				$wherebranch	=	array('car_city'=>$city_id,'branch_id'=>$branchid,'funding_applied'=>'0');
			}
		}
		else
		{
			$cityname		=	"";
			$whercity 		=	array('city_id'=>$city_id);
			$getcityneame   = 	fundingmodel::doGetmasterdetails($this->masterCityTable,$whercity);
			$cityname 		=	((count($getcityneame)>=1)?$getcityneame[0]->city_id:'');
			$branches 		= 	fundingmodel::dealerFetchbranchDetails($schemaname,
																array('dealer_city'=>$cityname)
																);
			return json_encode(array("branch"=>$branches));
		}
		if($typeofrequest	==	"Loanpage")
		{
			$wherecondition	=	array('car_city'=>$city_id,'branch_id'=>$branchid);
		}
		else
		{
			$wherecondition		=	array('funding_applied'=>'0','car_city'=>$city_id,'branch_id'=>$branchid);
		}
		
        $carmodel 			= 	fundingmodel::dealerFetchTableDetailsnotwhere($schemaname,
															$this->dmscardealerTable,
															$wherecondition,
															$notexistcarid
															);
		
		$fetchmake 			= 	array_pluck($carmodel,'make');
		$fetchmodel 		= 	array_pluck($carmodel,'model_id');
		$fetchvariant 		= 	array_pluck($carmodel,'variant');
		
		//get make name
		$checkcarmake 		= 	fundingmodel::dealerFetchTablewherein($this->masterMakeTable,$fetchmake,'make_id');
		$matchcarmake 		= 	array_pluck($checkcarmake,'makename');
		$checkcarmakematch 	= 	fundingmodel::dealerFetchTablewhereinlike($this->masterMakeTable,
																		$matchcarmake,
																		'makename',
																		$car_name);
		$returnmakeid 		= 	array_pluck($checkcarmakematch,'make_id');
		//get model name
		$checkcarmodel 		= 	fundingmodel::dealerFetchTablewherein($this->masterModelsTable,$fetchmodel,'model_id');
		$matchcarmodel 		= 	array_pluck($checkcarmodel,'model_name');
		$checkcarmodelmatch = 	fundingmodel::dealerFetchTablewhereinlike($this->masterModelsTable,
																		$matchcarmodel,
																		'model_name',
																		$car_name);
		//get variant name
		$checkcarvariant 		= 	fundingmodel::dealerFetchTablewherein($this->MasterVariantTable,$fetchvariant,'variant_id');
		$matchcarvariant 		= 	array_pluck($checkcarvariant,'variant_name');
		$checkcarvariantmatch 	= 	fundingmodel::dealerFetchTablewhereinlike($this->MasterVariantTable,
																		$matchcarvariant,
																		'variant_name',
																		$car_name);

		$returnmodelid['make'] 		= 	array_pluck($checkcarmakematch,'make_id');
		$returnmodelid['model_id'] 	= 	array_pluck($checkcarmodelmatch,'model_id');
		$returnmodelid['variant'] 	= 	array_pluck($checkcarvariantmatch,'variant_id');
		
		
		if($car_name 	==	"")
		{
			$carmodel 			= 	fundingmodel::dealerFetchTableDetailsnotwhere($schemaname,
															$this->dmscardealerTable,
															$wherebranch,
															$notexistcarid
															);
		}
		else
		{
			
			//check empty and assign dummy value
			$newreturnallid 	= 	array_flatten($returnmodelid);
			
			if(count($newreturnallid) ==	"" && empty($newreturnallid))
			{
				$returnmodelid['make'] 		= 	array($car_name);
				$returnmodelid['model_id'] 	= 	array($car_name);
				$returnmodelid['variant'] 	= 	array($car_name);
			}
		
			if($typeofrequest	==	"Loanpage")
			{
				$wherecondition		=	array('car_city'=>$city_id,'branch_id'=>$branchid);
				/*$whereexistcar 		=	array(	'user_id'=>$this->id,
												'customer_id'=>$customerid,
												'city_id'=>$city_id,
												'branch_id'=>$branchid
												);
				//get loan details check exist in loan car details
				$checkexistcarids 	=	fundingmodel::doGetloanexistcar($whereexistcar);
				$getexistcarids 	=	$checkexistcarids->pluck('car_id');*/
			}
			else
			{
				$wherecondition	=	array('funding_applied'=>'0','car_city'=>$city_id,'branch_id'=>$branchid);
			}
			
			$carmodel 			= 	fundingmodel::dealerFetchTableDetailswherein($schemaname,
															$this->dmscardealerTable,
															$wherecondition,
															$returnmodelid,
															$notexistcarid
															);
		}
		
		//get car details		
        if(!empty($carmodel) && count($carmodel)>=1)
        {
			foreach($carmodel as $uservalue)
			{		
				$imagefetch 					= 	fundingmodel::dealerFetchTableDetails(
																		$schemaname,
																		$this->DmsCarListPhotosTable,
																		array('car_id'=>$uservalue->car_id)
																		);
				$cardata['image'] 				=	((count($imagefetch)>=1)?$imagefetch[0]->s3_bucket_path:url(config::get('common.carnoimage')));
				$cardata['car_id']         		= 	$uservalue->car_id;
				$cardata['listing_id']       	= 	$uservalue->duplicate_id;
				$cardata['inventory_type']     	= 	$uservalue->inventory_type;
				$cardata['dealer_id']         	= 	$uservalue->dealer_id;
				$cardata['price']         		= 	$uservalue->price;
				$cardata['kms_done']         	= 	$uservalue->kms_done;
				$cardata['registration_year']  	= 	$uservalue->registration_year;
				switch($uservalue->owner_type)
				{
					case 'FIRST':
					$cardata['owner_type']      = 	1;
					break;
					case 'SECOND':
					$cardata['owner_type']      = 	2;
					break;
					case 'THIRD':
					$cardata['owner_type']       = 	3;
					break;
					case 'Fourth':
					$cardata['owner_type']       = 	"4";
					break;
					case 'Four +':
					$cardata['owner_type']       = 	"4 +";
					break;
					default:
					$cardata['owner_type']       = 	"1";
					break;	
				}
				$makewhere					=	array('make_id'=>$uservalue->make);
				$getmake 	 				=	fundingmodel::doGetmasterdetails(
																			$this->masterMakeTable,
																			$makewhere);
				$cardata['make'] 			=	((count($getmake)>=1)?$getmake[0]->makename:'');
				$modelwhere					=	array('model_id'=>$uservalue->model_id);
				$getmodel 	 				=	fundingmodel::doGetmasterdetails(
																			$this->masterModelsTable,
																			$modelwhere);
				$cardata['model'] 			=	((count($getmodel)>=1)?$getmodel[0]->model_name:'');
				$varientwhere				=	array('variant_id'=>$uservalue->variant);
				$getvarient 	 			=	fundingmodel::doGetmasterdetails(
																			$this->MasterVariantTable,
																			$varientwhere);
				$cardata['varient'] 		=	((count($getvarient)>=1)?$getvarient[0]->variant_name:'');
				$cardata['fuel_type']       = 	$uservalue->fuel_type;
				array_push($cardetails, $cardata); 
			}
			echo json_encode(array("carmodel"=>$cardetails));
		}
		else
		{
			echo json_encode(array("result"=>"No Car Founds"));
		}
        
    }
    //add car details in addfund page
    public function doAddfundingCarCetails()
    {
        $car_id			=	Input::get('carid');
        $branch			=	Input::get('branch');
        $cariddata		=	array();
        $caridnewdata 	=	array_flatten($car_id);
        if(!empty($caridnewdata) && count($caridnewdata)>=1)
        {
			foreach($caridnewdata as $caridvalue)
			{
				if($caridvalue != "")
				{
					$cariddata[]	=	$caridvalue;
				}
			}
		}
        $schemaname 	= 	$this->dealer_schemaname;
        $cardata		=	array();
        $cardetails		=	array();
        $carmodel 		= 	fundingmodel::dealerschemaFetchTablewherein($schemaname,
															$this->dmscardealerTable,
															$cariddata,
															'car_id'
															);
        if(!empty($carmodel) && count($carmodel)>=1)
        {
			foreach($carmodel as $uservalue)
			{		
				$imagefetch 					= 	fundingmodel::dealerFetchTableDetails(
																		$schemaname,
																		$this->DmsCarListPhotosTable,
																		array('car_id'=>$uservalue->car_id)
																		);
				$cardata['image'] 				=	((count($imagefetch)>=1)?$imagefetch[0]->s3_bucket_path:url(config::get('common.carnoimage')));
				$cardata['car_id']         		= 	$uservalue->car_id;
				$cardata['branch']         		= 	$branch;
				$cardata['listing_id']       	= 	$uservalue->duplicate_id;
				$cardata['inventory_type']     	= 	$uservalue->inventory_type;
				$cardata['dealer_id']         	= 	$uservalue->dealer_id;
				$cardata['price']         		= 	$uservalue->price;
				$cardata['kms_done']         	= 	$uservalue->kms_done;
				$cardata['registration_year']  	= 	$uservalue->registration_year;
				switch($uservalue->owner_type)
				{
					case 'FIRST':
					$cardata['owner_type']      = 	1;
					break;
					case 'SECOND':
					$cardata['owner_type']      = 	2;
					break;
					case 'THIRD':
					$cardata['owner_type']       = 	3;
					break;
					case 'Fourth':
					$cardata['owner_type']       = 	"4";
					break;
					case 'Four +':
					$cardata['owner_type']       = 	"4 +";
					break;
					default:
					$cardata['owner_type']       = 	"1";
					break;	
				}
				$makewhere					=	array('make_id'=>$uservalue->make);
				$getmake 	 				=	fundingmodel::doGetmasterdetails(
																			$this->masterMakeTable,
																			$makewhere);
				$cardata['make'] 			=	((count($getmake)>=1)?$getmake[0]->makename:'');
				$modelwhere					=	array('model_id'=>$uservalue->model_id);
				$getmodel 	 				=	fundingmodel::doGetmasterdetails(
																			$this->masterModelsTable,
																			$modelwhere);
				$cardata['model'] 			=	((count($getmodel)>=1)?$getmodel[0]->model_name:'');
				$varientwhere				=	array('variant_id'=>$uservalue->variant);
				$getvarient 	 			=	fundingmodel::doGetmasterdetails(
																			$this->MasterVariantTable,
																			$varientwhere);
				$cardata['varient'] 		=	((count($getvarient)>=1)?$getvarient[0]->variant_name:'');
				$cardata['fuel_type']       = 	$uservalue->fuel_type;
				array_push($cardetails, $cardata); 
			}
			echo json_encode($cardetails);
		}
		else
		{
			echo json_encode(array("result"=>"No Cars Added"));
		}
    }
    public function dosearchcarmodeldetails()
    {
        $car_name		=	Input::get('car_name');
        $city_id		=	Input::get('city_id');
        $branch_id		=	Input::get('branch');
        $schemaname 	= 	$this->dealer_schemaname;
        $cardata		=	array();
        $cardetails		=	array();
        $wherecondition	=	array('funding_applied'=>'0','car_city'=>$city_id,'branch_id'=>$branch_id);
        $carmodel 		= 	fundingmodel::dealerFetchTableDetailsnotwhere($schemaname,
															$this->dmscardealerTable,
															$wherecondition
															);
		$fetchmake 			= 	array_pluck($carmodel,'make');
		$fetchmodel 		= 	array_pluck($carmodel,'model_id');
		$fetchvariant 		= 	array_pluck($carmodel,'variant');
		//get make name
		$checkcarmake 		= 	fundingmodel::dealerFetchTablewherein($this->masterMakeTable,$fetchmake,'make_id');
		$matchcarmake 		= 	array_pluck($checkcarmake,'makename');
		$checkcarmakematch 	= 	fundingmodel::dealerFetchTablewhereinlike($this->masterMakeTable,
																		$matchcarmake,
																		'makename',
																		$car_name);
		$returnmakeid 		= 	array_pluck($checkcarmakematch,'make_id');
		//get model name
		$checkcarmodel 		= 	fundingmodel::dealerFetchTablewherein($this->masterModelsTable,$fetchmodel,'model_id');
		$matchcarmodel 		= 	array_pluck($checkcarmodel,'model_name');
		$checkcarmodelmatch = 	fundingmodel::dealerFetchTablewhereinlike($this->masterModelsTable,
																		$matchcarmodel,
																		'model_name',
																		$car_name);
		//get variant name
		$checkcarvariant 		= 	fundingmodel::dealerFetchTablewherein($this->MasterVariantTable,$fetchvariant,'variant_id');
		$matchcarvariant 		= 	array_pluck($checkcarvariant,'variant_name');
		$checkcarvariantmatch 	= 	fundingmodel::dealerFetchTablewhereinlike($this->MasterVariantTable,
																		$matchcarvariant,
																		'variant_name',
																		$car_name);
		$returnmodelid['make'] 		= 	array_pluck($checkcarmakematch,'make_id');
		$returnmodelid['model_id'] 	= 	array_pluck($checkcarmodelmatch,'model_id');
		$returnmodelid['variant'] 	= 	array_pluck($checkcarvariantmatch,'variant_id');
		
		$wherecondition		=	array('funding_applied'=>'0','car_city'=>$city_id,'branch_id'=>$branch_id);
        $fetchcarmodel 		= 	fundingmodel::dealerFetchTableDetailswherein($schemaname,
															$this->dmscardealerTable,
															$wherecondition,
															$returnmodelid
															);
		//print_r($fetchcarmodel); exit;
        if(!empty($fetchcarmodel) && count($fetchcarmodel)>=1)
        {
			foreach($fetchcarmodel as $uservalue)
			{		
				$imagefetch 					= 	fundingmodel::dealerFetchTableDetails(
																		$schemaname,
																		$this->DmsCarListPhotosTable,
																		array('car_id'=>$uservalue->car_id)
																		);
				$cardata['image'] 				=	((count($imagefetch)>=1)?$imagefetch[0]->s3_bucket_path:url(config::get('common.carnoimage')));
				$cardata['car_id']         		= 	$uservalue->car_id;
				$cardata['listing_id']       	= 	$uservalue->duplicate_id;
				$cardata['inventory_type']     	= 	$uservalue->inventory_type;
				$cardata['dealer_id']         	= 	$uservalue->dealer_id;
				$cardata['price']         		= 	$uservalue->price;
				$cardata['kms_done']         	= 	$uservalue->kms_done;
				$cardata['registration_year']  	= 	$uservalue->registration_year;
				switch($uservalue->owner_type)
				{
					case 'FIRST':
					$cardata['owner_type']      = 	1;
					break;
					case 'SECOND':
					$cardata['owner_type']      = 	2;
					break;
					case 'THIRD':
					$cardata['owner_type']       = 	3;
					break;
					case 'Fourth':
					$cardata['owner_type']       = 	"4";
					break;
					case 'Four +':
					$cardata['owner_type']       = 	"4 +";
					break;
					default:
					$cardata['owner_type']       = 	"1";
					break;	
				}
				$makewhere					=	array('make_id'=>$uservalue->make);
				$getmake 	 				=	fundingmodel::doGetmasterdetails(
																			$this->masterMakeTable,
																			$makewhere);
				$cardata['make'] 			=	((count($getmake)>=1)?$getmake[0]->makename:'');
				$modelwhere					=	array('model_id'=>$uservalue->model_id);
				$getmodel 	 				=	fundingmodel::doGetmasterdetails(
																			$this->masterModelsTable,
																			$modelwhere);
				$cardata['model'] 			=	((count($getmodel)>=1)?$getmodel[0]->model_name:'');
				$varientwhere				=	array('variant_id'=>$uservalue->variant);
				$getvarient 	 			=	fundingmodel::doGetmasterdetails(
																			$this->MasterVariantTable,
																			$varientwhere);
				$cardata['varient'] 		=	((count($getvarient)>=1)?$getvarient[0]->variant_name:'');
				$cardata['fuel_type']       = 	$uservalue->fuel_type;
				array_push($cardetails, $cardata); 
			}
			echo json_encode($cardetails);
		}
		else
		{
			echo json_encode(array("result"=>"No Cars Found"));
		}
    }
    public function doregisterApplyfunding(Request $request)
	{
		try
		{
			$messsages 		= 	array(
					'fundingamount.required'=>'Loan Amount',
					'dealershipname.required'=>'Dealership Name',
					'dealername.required'=>'Dealer Name',
					'emailid.required'=>'Customer Emailid',
					'date.required'=>'Date',
					'branch.required'=>'Branch Name',
					'place.required'=>'Place',
					'appendcarid.required'=>'Car Id',
					'mobilenumber.required'=>'Car Id',
				);
			$validationcheck 	=	Validator::make($request->all(),[
					'fundingamount' => 'required',
					'dealershipname' => 'required',
					'dealername' => 'required',
					'emailid' => 'required|email',
					'date' => 'required',
					'branch' => 'required',
					'place' => 'required',
					'appendcarid' => 'required',
					'mobilenumber' => 'required|max:12'
			],$messsages);
        	
        if ($validationcheck->fails())
        {
			$result['error'] = $validationcheck->errors();
			return response()->json($result,400);
        }
		$dealershipname	=	input::get('dealershipname');
		$dealername		=	input::get('dealername');
		$emailid		=	input::get('emailid');
		$mobilenumber	=	input::get('mobilenumber');
		$date			=	input::get('date');
		$place			=	input::get('place');
		$branch			=	input::get('branch');
		$fundingamount	=	input::get('fundingamount');
		$carid			=	input::get('appendcarid');
		$newprice		=	collect($carid);
		//check amount is equal or not
		$getprice 		= 	fundingmodel::checkpricesum(
													$this->dealer_schemaname,
													$newprice
													);
		$amount 		=	0;
		if(!empty($getprice))
		{	
			foreach($getprice as $pricevalue)
			{
				$amount +=	$pricevalue->price;
			}
		}
		
		if(isset($carid))
		{
			foreach($carid as $carids)
			{
				if(empty($carids))
				{
					$result['error'] = "Invalid data";
					return response()->json($result,400);
				}
			}
			if($amount >= $fundingamount)
			{
				
			}
			else
			{
				$result['error'] = "Invalid data";
				return response()->json($result,400);
			}
		}
		
        //GET DEALER DETAILS
        $dealer_wherecondition  =	array('d_id'=>$this->id);
        $fetchupdate 			= 	fundingmodel::doGetmasterdetails($this->dmsdealerTable,
																		$dealer_wherecondition
																		);
		$dealer_profile_image	=	((count($fetchupdate)>=1)?$fetchupdate[0]->logo:url(config::get('common.profilenoimage')));																
		$from_email				=	((count($fetchupdate)>=1)?$fetchupdate[0]->d_email:'');																
		//getbranchname
		$getbranchname			=	fundingmodel::dealerFetchbranchname($this->dealer_schemaname,$branch);
		$branchname				=	((count($getbranchname)>=1)?$getbranchname[0]->dealer_name:'');
		//getcity
		$getcityname			=	fundingmodel::dogetcitynamemaster($place);
		$cityname				=	((count($getcityname)>=1)?$getcityname[0]->city_name:'');
		$ticketinsert			=	array('dealer_ticket_type_id'=>1,
									'dealer_id'=>$this->id,
									'dealer_ticket_status_id'=>1);
									
		$dealer_wherecondition	=	array('dealer_id'=>$this->id);
		$getdealeraddress 		= 	fundingmodel::dealerFetchTableDetails($this->dealer_schemaname,
															'dms_dealerdetails',
															$dealer_wherecondition
															);
        $dealeraddress			=	((count($getdealeraddress)>=1)?$getdealeraddress[0]->Address:'');
										
		$insertticketrequesttable	=	fundingmodel::doInsertTicketrequest($ticketinsert);
		if($insertticketrequesttable >= 1)
		{
			//get last record for unique ticket creation
			$getlastid	 	=	fundingmodel::latest('dealer_funding_detail_id')->pluck('dealer_funding_detail_id')->first();
			$maketicketid	=	($getlastid >= 1)?($getlastid+1):$insertticketrequesttable;		
			$findingticketid		=	commonmodel::dodealercode().'-F'.$maketicketid;
			$insertfundingdata 		=	array('dealer_ticket_id'=>$insertticketrequesttable,
												'dealershipname'=>$dealershipname,
												'dealername'=>$dealername,
												'dealermobileno'=>$mobilenumber,
												'dealer_funding_ticket_id'=>$findingticketid,
												'dealermailid'=>$emailid,
												'city_id'=>$place,
												'dealercity'=>$cityname,
												'branch_id'=>$branch,
												'branchname'=>$branchname,
												'requested_amount'=>$fundingamount,
												'created_date'=>$date,
												'user_id'=>$this->id
												);
			$insertdealerfundingtable	=	fundingmodel::doInsertfundingapplyrequest($insertfundingdata);
			if($insertdealerfundingtable >= 1)
			{
				//get make,model,variant
				$footeremailtemp		=	"";											
				if(!empty($carid))
				{
					$carid			=	collect($carid);
					$getmakemodel 	= 	fundingmodel::dealerFetchTablewhereinCarid(
																$this->dealer_schemaname,
																$carid
																);
					if(!empty($getmakemodel) && count($getmakemodel) >= 1)
					{
						$i 	=	1;
						foreach($getmakemodel as $value)
						{
							$imagefetch 		= 	fundingmodel::dealerFetchTableDetails($this->dealer_schemaname,
																						$this->DmsCarListPhotosTable,
																						array('car_id'=>$value->car_id)
																						);
							$carimage 			=	((count($imagefetch)>=1)?$imagefetch[0]->s3_bucket_path:url(config::get('common.carnoimage')));
							
							$makewhere			=	array('make_id'=>$value->make);
							$getmake 	 		=	fundingmodel::doGetmasterdetails(
																				$this->masterMakeTable,
																				$makewhere);
							$makename 			=	((count($getmake)>=1)?$getmake[0]->makename:'');
							$modelwhere			=	array('model_id'=>$value->model_id);
							$getmodel 	 		=	fundingmodel::doGetmasterdetails(
																				$this->masterModelsTable,
																				$modelwhere);
							$modelname 			=	((count($getmodel)>=1)?$getmodel[0]->model_name:'');
							$varientwhere		=	array('variant_id'=>$value->variant);
							$getvarient 	 	=	fundingmodel::doGetmasterdetails(
																				$this->MasterVariantTable,
																				$varientwhere);
							$variantname 		=	((count($getvarient)>=1)?$getvarient[0]->variant_name:'');
							switch($value->owner_type)
								{
									case 'FIRST':
									$owner_type       	= 	"1";
									break;
									case 'SECOND':
									$owner_type       = 	"2";
									break;
									case 'THIRD':
									$owner_type       = 	"3";
									break;	
									case 'Fourth':
									$owner_type       = 	"4";
									break;	
									case 'Four +':
									$owner_type       = 	"Above 4";
									break;	
									default:
									$owner_type       = 	"1";
									break;							
								}
								$insertfundingitems			=	array(
																'dealer_funding_detail_id'=>$insertdealerfundingtable,
																'dealer_car_id'=>$value->car_id,
																'dealer_listing_id'=>'',
																'dealer_car_make_name'=>$makename,
																'dealer_car_model_name'=>$modelname,
																'dealer_car_variant_name'=>$variantname,
																'dealer_car_price'=>$fundingamount);
								$insertdealerfundingitems	=	fundingmodel::doInsertFundingItems($insertfundingitems);
								
							$footeremailtemp  	.=	'<tr><td>'.$i.'</td><td><img src="'.$carimage.'" alt="" class="img-responsive table-img"></td><td><p><b>'.$modelname.' '.$variantname.' '.$value->registration_year.'</b></p><p>Rs.'.$fundingamount.'</p><p class="list-detail"><span class="text-muted">'.$value->kms_done.' km</span> | <span class="text-muted">'.$value->fuel_type.'</span> | <span class="text-muted">'.$value->registration_year.'</span> | <span class="text-muted">'.$owner_type.' Owner</span></p></td></tr>';
							$i++;
						}
						$footeremailtemp		.=	'</tbody></table></div></div>';
						
					}
				}
				
				$updatedmsdata		=	array('funding_applied'=>'1','funding_ticket_number'=>$findingticketid);
				$updatedmstable		=	fundingmodel::doUpdatedmstable($this->dealer_schemaname,$updatedmsdata,$carid);
				if($updatedmstable >= 1)
				{
					//Mail Send Start
					$maildata               	= 	array('0'=>$findingticketid,
														'1'=>'In Progress',
														'2'=>$dealer_profile_image,
														'3'=>$dealername,
														'4'=>$dealername,
														'5'=>$branchname,
														'6'=>$mobilenumber,
														'7'=>$dealeraddress
														);
					
					
					$queries_email_template_id 	=    config::get('common.funding_email_template_id');
					$email_template_data       	=    emailmodel::get_email_templates($queries_email_template_id);
					
					foreach ($email_template_data as $row) 
					{
					  $mail_subject =  	$row->email_subject;
					  $mail_message =  	$row->email_message;
					  $mail_params  =  	$row->email_parameters; 
					}
					$email_template = 	emailmodel::emailContentConstructLoan($mail_subject,$mail_message,$mail_params,$maildata,$footeremailtemp);
					$email_sent     = 	emailmodel::email_sending($from_email,$email_template);
		
					$result['message'] = "Funding Applied Successfully";
					$result['fundingticketid'] 	= 	encrypt($findingticketid);
					return response()->json($result);
				}
				else
				{
					$result['message'] = "Funding Applied Failed Try Again";
					return response()->json($result);
				}
			}
		}
		}	
	catch(Exception $e){
		throw new CustomException($e->getMessage());
	}
	}
	public function dofundingrevoke()
    {
        $fundingid 		=	Input::get('fundingvalue');
        if($fundingid	==	"")
        {
			return response()->json(['Result'=>'0',
										'message'=>'Failed Please try Again'
										]);
		}
		$wherecondition	=	array('dealer_funding_detail_id'=>$fundingid);
		$updatedata		=	array('status'=>3);
		$updatefetch    = 	fundingmodel::doRevokefundingtable(
																$updatedata,
																$wherecondition
																);
		if($updatefetch >= 1)
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

    public function dofunding_excel()
    {
		try
		{
			$fundingdetails		=	array();
			$arraywhere			=	array('user_id'=>$this->id);
			$fetch_data			= fundingmodel::doGetfundingdetails($arraywhere);
			$fetchCity 			= fundingmodel::fetchCity();
			//dd($fetch_data);

			$excelname 			= "Funding".time();
			$sheetheading 		= "Funding";
			$mergecells 		= "A1:P1";
			$sheetArray 		= array();
			$sheetArray[] 		= array('SL No','Funding Ticket ID','Dealership Name','Dealer Name','Dealer Mobile Number','Dealer Email ID','City','Dealer City','Branch','Requested Amount','Status','Dealer Listing Id','Dealer Car Make Name','Dealer Car Model Name','Dealer Car Variant Name','Dealer Car Price');
			foreach($fetch_data  as $i => $row)
			{

				foreach ($fetchCity as $key => $city) 
				{
					if($city->master_id == $row->city_id)
					{
						$cityName = $city->city_name;
					}
				}
				switch($row->status)
				{
					case 0:
					$fundingStatus				=	"In Progress";
					break;
					case 1:
					$fundingStatus				=	"Approved";
					break;
					case 2:
					$fundingStatus				=	"Declined";
					break;
					case 3:
					$fundingStatus				=	"Revoked";
					break;
				}
				$amount 			= report::moneyFormat($row->requested_amount);
				$dealerCarPrice 	= report::moneyFormat($row->dealer_car_price);

				if($row->branchname == "")
				{
					$branchName = "NA";
				}
				else
				{
					$branchName = $row->branchname;
				}

				$sheetArray[] 	= array(++$i,$row->dealer_funding_ticket_id,$row->dealershipname,$row->dealername,$row->dealermobileno,$row->dealermailid,$cityName,$row->dealercity,$branchName,$amount,$fundingStatus,$row->dealer_listing_id,$row->dealer_car_make_name,$row->dealer_car_model_name,$row->dealer_car_variant_name,$dealerCarPrice);
			}
			exportmodel::generatereport($sheetArray,$sheetheading,$excelname,$mergecells);
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
    }
}
