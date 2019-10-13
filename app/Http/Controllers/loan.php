<?php
/*
  Module Name : loan 
  Created By  : vinoth 13-03-2017 Version 1.0
  Module 	  : Funding module
  Use of this module is Add loan with frshservice api,
*/
namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\model\loanmodel;
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

class loan extends Controller
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
   
    public function doViewloanPage()
    {
    	try
		{
			$loanid 			=	"";
			if(isset($_REQUEST['Loanid'])){
                $loanid 		= 	decrypt($_REQUEST['Loanid']);
            }

			$loanresult			=	array();
			$arraywhere			=	array('user_id'=>$this->id);
			$getloanresult 		=	loanmodel::doFetchloanDetails($arraywhere);
			$id           		= 	session::get('ses_id'); 
			$header_data  		= 	$this->header_data;
			$left_menu    		= 	'2';
			$compact_array		= 	array('active_menu_name'=>$this->active_menu_name,
									'left_menu'=>2,
									'loanid'=>$loanid,
									'loandata'=>$getloanresult
									);        
			$header_data['title']	=	'Loan';
		}
		catch(Exception $e){
			throw new CustomException($e->getMessage());
		} 
			return view('applied_loan_view', compact('compact_array', 'header_data'));
    }
   
    public function doapplyloan()
    {
		try
		{
			$id           	= 	session::get('ses_id'); 
			$header_data 	= 	$this->header_data;
			$left_menu    	= 	'1';
			$cityid			=	"";
			//$cityname		=	"";
			//get dealer user details from dms_dealers
			$wheredealer	=	array('d_id'=>$id);
			$dealerdetails  = 	loanmodel::doGetmasterdetails($this->dmsdealerTable,$wheredealer);
			$cityid 		=	((count($dealerdetails)>=1)?$dealerdetails[0]->d_city:'526');
			$whercity 		=	array('city_id'=>$cityid);
			//$getcityneame   = 	fundingmodel::doGetmasterdetails($this->masterCityTable,$whercity);
			//$cityname 		=	((count($getcityneame)>=1)?$getcityneame[0]->city_name:'Chennai');
			$sortbycity   	= 	loanmodel::dealerFetchTableDetailsgrouby(
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
			$dealercity 	=	loanmodel::dealerFetchTablewherein($this->masterCityTable,$citydata,'city_id');
			$compact_array	= 	array('active_menu_name'=>$this->active_menu_name,
									'left_menu'=>1,
									'side_bar_active'=>1,
									//'cityname'=>$cityname,
									'dealercityname'=>$dealercity,
									'dealerdetails'=>$dealerdetails
									);        
			$header_data['title']	=	'Loan';
		}
		catch(Exception $e){
			throw new CustomException($e->getMessage());
		} 
			return view('addfund', compact('compact_array', 'header_data'));
	}
	
	public function doloanforcustomer()
    {
		try
		{
			$id    			=	session::get('ses_id'); 
			$header_data  	= 	$this->header_data;
			$header_data['title']	=	'Loan';
			$left_menu    	= 	'2';
			$cityid			=	"";
			//get dealer user details from dms_dealers
			$wheredealer	=	array('d_id'=>$id);
			$dealerdetails  = 	loanmodel::doGetmasterdetails($this->dmsdealerTable,$wheredealer);
			$cityid 		=	((count($dealerdetails)>=1)?$dealerdetails[0]->d_city:'526');
			$whercity 		=	array('city_id'=>$cityid);
			$sortbycity   	= 	loanmodel::dealerFetchTableDetailsgrouby(
																			$this->dealer_schemaname,
																			$this->dmscardealerTable,
																			'car_city');
			$customername   = 	loanmodel::schema_get_customername($this->dealer_schemaname);
		    $citydata		=	array();
			$citynamesort 	=	$sortbycity->pluck('car_city');
			if(!empty($citynamesort) && count($citynamesort)>=1)
			{
				foreach($citynamesort as $value)
				{
					$citydata[] 	=	$value;
				}
			}
			$dealercity 	=	loanmodel::dealerFetchTablewherein($this->masterCityTable,$citydata,'city_id');
			$compact_array	= 	array('active_menu_name'=>$this->active_menu_name,
									'left_menu'=>2,
									'side_bar_active'=>1,
									'customername'=>$customername,
									'dealercityname'=>$dealercity,
									'dealerdetails'=>$dealerdetails
									);
		}
		catch(Exception $e){
			throw new CustomException($e->getMessage());
		} 
			return view('applyloanforcustomer', compact('compact_array', 'header_data'));
	}
    
    public function doloanforcustomername()
    {
		try
		{
			$schemaname 	= 	$this->dealer_schemaname;
			$wherecustomer 	=	array();
			$customername 	= 	loanmodel::dealerFetchTableDetails($schemaname,
																'dealer_contact_management',
																array('dealer_city'=>$cityname)
																);
			echo json_encode($customername);
		}
		catch(Exception $e){
			throw new CustomException($e->getMessage());
		} 
	}
	public function doregisterApplyloan(Request $request)
	{
		try
		{
			$messsages 		= 	array(
					'fundingamount.required'=>'Loan Amount',
					'customername.required'=>'Customer Name',
					'pannumber.required'=>'Customer Pannumber',
					'emailid.required'=>'Customer Emailid',
					'date.required'=>'Date',
					'branch.required'=>'Branch Name',
					'place.required'=>'Place',
					'carid.required'=>'Car Id',
					'mobilenumber.required'=>'Car Id',
				);
			$validationcheck 	=	Validator::make($request->all(),[
					'fundingamount' => 'required',
					'customername' => 'required',
					'pannumber' => 'required',
					'emailid' => 'required|email',
					'date' => 'required',
					'branch' => 'required',
					'place' => 'required',
					'carid' => 'required',
					'mobilenumber' => 'required|max:12'
			],$messsages);
        	
        if ($validationcheck->fails())
        {
			$result['error'] 	= 	$validationcheck->errors();
			$result['errormsg'] = 	"All Fields are required or Invalid data sending...";
			return response()->json($result,422);
        }

		$customerid		=	input::get('customername');
		$mobilenumber	=	input::get('mobilenumber');
		$emailid		=	input::get('emailid');
		$pannumber		=	input::get('pannumber');
		$date			=	input::get('date');
		$place			=	input::get('place');
		$branch			=	input::get('branch');
		$fundingamount	=	input::get('fundingamount');
		$carid			=	input::get('carid');
		$amount 		=	"";
		//check amount is equal or not
		if(isset($carid))
		{
			foreach($carid as $caridvalue)
			{
				$checkcarid	=	$caridvalue;
				if($checkcarid 	==	"")
				{
					$result['errormsg'] = 	"All Fields are required or Invalid data sending...";
					return response()->json($result,400);
				}
			}
			$getprice 	= 	loanmodel::dealerFetchTablewhereCarid(
														$this->dealer_schemaname,
														$checkcarid
														);
			if(!empty($getprice))
			{
				$amount  	=	(count($getprice)>=1?$getprice[0]->price:'');
			}
			if($amount >= $fundingamount)
			{
				
			}
			else
			{
				$result['errormsg'] = 	"Please enter value less than or equal to Rs.".$amount."";
				return response()->json($result,400);
			}			
		}
		
		$whereexistcar 		=	array(	'user_id'=>$this->id,
												'customer_id'=>$customerid,
												'city_id'=>$place,
												'branch_id'=>$branch
												);
		//get loan details check exist in loan car details
		$checkexistcarids 	=	loanmodel::doRegisterloanexistcar($whereexistcar,$checkcarid);
		if(!empty($checkexistcarids) && count($checkexistcarids) >= 1)
		{
			$getlasttiketid 	=	(count($checkexistcarids)>=1?$checkexistcarids[0]->dealer_loan_ticket_id:'');
			$result['errormsg'] = 	"Loan is already applied for this car Please refer loan tiket id ".$getlasttiketid."";
			return response()->json($result,400);
		}
        //GET DEALER DETAILS
        $dealer_wherecondition  	=	array('d_id'=>$this->id);
        $fetchupdate 				= 	loanmodel::doGetmasterdetails($this->dmsdealerTable,
																		$dealer_wherecondition
																		);
		$dealer_wherecondition  	=	array('dealer_id'=>$this->id);
		$getdealeraddress 			= 	loanmodel::dealerFetchTableDetails($this->dealer_schemaname,
															'dms_dealerdetails',
															$dealer_wherecondition
															);
        $dealeraddress				=	((count($getdealeraddress)>=1)?$getdealeraddress[0]->Address:'');
        															
		$fromdealer_name 			=	"";
		$from_email 				=	"";
		$from_mobileno 				=	"";
		$dealer_profile_image 		=	url(config::get('common.profilenoimage'));
		if(!empty($fetchupdate) && count($fetchupdate) >= 1)
		{
			$fromdealer_name        = 	$fetchupdate[0]->dealer_name;
			$from_email             = 	$fetchupdate[0]->d_email;
			$from_mobileno          = 	$fetchupdate[0]->d_mobile;
			$dealer_profile_image   = 	$fetchupdate[0]->logo;
		}
        
		//getbranchname
		$getbranchname	=	loanmodel::dealerFetchbranchname($this->dealer_schemaname,$branch);
		$branchname		=	((count($getbranchname)>=1)?$getbranchname[0]->dealer_name:'');
		//getcustomername
		$getcustomername=	loanmodel::dealerFetchcustomername($this->dealer_schemaname,$customerid);
		$customername	=	((count($getcustomername)>=1)?$getcustomername[0]->contact_first_name:'');
		$customermobile	=	((count($getcustomername)>=1)?$getcustomername[0]->contact_phone_1:'');
		$customeraddres	=	((count($getcustomername)>=1)?$getcustomername[0]->contact_mailing_address:'');
		//getcity
		$getcityname	=	loanmodel::dogetcitynamemaster($place);
		$cityname		=	((count($getcityname)>=1)?$getcityname[0]->city_name:'');
		$ticketinsert	=	array('dealer_ticket_type_id'=>2,
									'dealer_id'=>$this->id,
									'dealer_ticket_status_id'=>1);
		$vehicle_details	=	"";
		
		//get make,model,variant
		if(!empty($carid))
		{
			foreach($carid as $caridvalue)
			{
				$carid	=	$caridvalue;
			}
			$getmakemodel 	= 	loanmodel::dealerFetchTablewhereCarid(
														$this->dealer_schemaname,
														$carid
														);
			if(!empty($getmakemodel) && count($getmakemodel) >= 1)
			{
				foreach($getmakemodel as $carvalue)
				{
					$imagefetch 		= 	loanmodel::dealerFetchTableDetails($this->dealer_schemaname,
																				$this->DmsCarListPhotosTable,
																				array('car_id'=>$carvalue->car_id)
																				);
					$carimage 			=	((count($imagefetch)>=1)?$imagefetch[0]->s3_bucket_path:url(config::get('common.carnoimage')));
					$makewhere			=	array('make_id'=>$carvalue->make);
					$getmake 	 		=	loanmodel::doGetmasterdetails(
																		$this->masterMakeTable,
																		$makewhere);
					$vehicle_details 	.=	((count($getmake)>=1)?$getmake[0]->makename:'').' ';
					$modelwhere			=	array('model_id'=>$carvalue->model_id);
					$getmodel 	 		=	loanmodel::doGetmasterdetails(
																		$this->masterModelsTable,
																		$modelwhere);
					$vehicle_details 	.=	((count($getmodel)>=1)?$getmodel[0]->model_name:'').' ';
					$model_name 		=	((count($getmodel)>=1)?$getmodel[0]->model_name:'').' ';
					$varientwhere		=	array('variant_id'=>$carvalue->variant);
					$getvarient 	 	=	loanmodel::doGetmasterdetails(
																		$this->MasterVariantTable,
																		$varientwhere);
					$citywhere			=	array('city_id'=>$carvalue->car_city);
					$getcity 	 		=	loanmodel::doGetmasterdetails('master_city',
																		$citywhere);
					$cityname 			=	((count($getcity)>=1)?$getcity[0]->city_name:'');
				
					$vehicle_details 	.=	((count($getvarient)>=1)?$getvarient[0]->variant_name:'');
					$varientname 		=	((count($getvarient)>=1)?$getvarient[0]->variant_name:'');
					$datelist			=	Carbon::parse($carvalue->created_at)->diffForHumans();
					$owner_type 		=	"";
					switch($carvalue->owner_type)
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
					$footer_message		=	'<div class="bntdiv"><p class="car-name"><b>'.$model_name.' '.$varientname.'</b></p><p class="text-color">'.$cityname.' - <span class="list-date">'.$datelist.'</span></p><p class="list-detail"><span class="text-muted">'.$carvalue->kms_done.' km</span> | <span class="text-muted">'.$carvalue->fuel_type.'</span> | <span class="text-muted">'.$carvalue->registration_year.'</span> | <span class="text-muted">'.$owner_type.' Owner</span></p><p>Rs.'.$fundingamount.'</p></div></div></div>';
					//<p><a href="#" class="btn btn-sm" type="submit">View More</a></p>
				}
			}
		}
		
		$insertticketrequesttable 	=	loanmodel::doInsertTicketrequest($ticketinsert);
		if($insertticketrequesttable >= 1)
		{
			//get last record for unique ticket creation
			$getlastid	 	=	loanmodel::latest('dealer_customer_loan_id')->pluck('dealer_customer_loan_id')->first();
			$maketicketid	=	($getlastid >= 1)?($getlastid+1):$insertticketrequesttable;
			$loanticketid			=	commonmodel::dodealercode().'-L'.$maketicketid;
			$insertloandata 		=	array('customer_id'=>$customerid,
												'customername'=>$customername,
												'customermobileno'=>$mobilenumber,
												'customerpannumber'=>$pannumber,
												'dealer_ticket_id'=>$insertticketrequesttable,
												'dealer_loan_ticket_id'=>$loanticketid,
												'customermailid'=>$emailid,
												'city_id'=>$place,
												'customercity'=>$cityname,
												'branch_id'=>$branch,
												'branchname'=>$branchname,
												'requested_amount'=>$fundingamount,
												'created_date'=>$date,
												'user_id'=>$this->id,
												'vehicle_details'=>$vehicle_details,
												'car_id'=>$carid);
			$insertdealerloantable	=	loanmodel::doInsertLoanapplyrequest($insertloandata);
			if($insertdealerloantable >= 1)
			{
				$updatedmsdata		=	array('loan_ticket_number'=>$loanticketid);
				//$updatedmsdata		=	array('loan_applied'=>'1','loan_ticket_number'=>$loanticketid);
				$updatedmstable		=	loanmodel::doUpdatedmstable($this->dealer_schemaname,$updatedmsdata,$carid);
				if($updatedmstable >= 1)
				{
					 //Mail Send Start
						$maildata                   = 	array('0'=>$loanticketid,
															'1'=>'In Progress',
															'2'=>$dealer_profile_image,
															'3'=>$customername,
															'4'=>$fromdealer_name,
															'5'=>$branchname,
															'6'=>$from_mobileno,
															'7'=>$dealeraddress,
															'8'=>$customermobile,
															'9'=>$customeraddres,
															'10'=>$carimage,
															);
						$queries_email_template_id =    config::get('common.loan_email_template_id');
						$email_template_data       =    emailmodel::get_email_templates($queries_email_template_id);
						
						foreach ($email_template_data as $row) 
						{
						  $mail_subject =  	$row->email_subject;
						  $mail_message =  	$row->email_message;
						  $mail_params  =  	$row->email_parameters; 
						}
						$email_template = 	emailmodel::emailContentConstructLoan($mail_subject,$mail_message,$mail_params,$maildata,$footer_message);
						$email_sent     = 	emailmodel::email_sending($from_email,$email_template);
						//$email_sent     = 	emailmodel::email_sending_cc($from_email,$email_template,$emailid);
						
					$result['message'] 	= 	"Loan Applied Successfully";
					$result['loanid'] 	= 	encrypt($loanticketid);
					return response()->json($result);
				}
				else
				{
					$result['message'] = "Loan Applied Failed Try Again";
					return response()->json($result);
				}
			}
			}
		}
		catch(Exception $e){
			throw new CustomException($e->getMessage());
		} 
	}
	
    /*public function autocompletecity(Request $request)
    {
		$term		=	$request->term;
		$id			=	'';
		$tablename 	= 	'master_city';
		$wherecondition 	= 	array('city_name'=>'%'.$term.'%');
		$data 		= 	buyymodel::masterfetchautocomplete($term);
		$result		=	array();
		 if(count($data)>=1)
		 {
			foreach ($data as $key => $v){
				$result[]	=	['value' =>$v->city_name];
			}
			return response()->json($result);
		}
		else
		{
			$result[]	=	['value' =>"Result Not found"];
			return response()->json($result);
		}
    }*/
    
    //add car details in addfund page
    public function doAddfundingCarCetails()
    {
        $car_id			=	Input::all();
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
        $carmodel 		= 	loanmodel::dealerschemaFetchTablewherein($schemaname,
															$this->dmscardealerTable,
															$cariddata,
															'car_id'
															);
        if(!empty($carmodel) && count($carmodel)>=1)
        {
			foreach($carmodel as $uservalue)
			{		
				$imagefetch 					= 	loanmodel::dealerFetchTableDetails(
																		$schemaname,
																		$this->DmsCarListPhotosTable,
																		array('car_id'=>$uservalue->car_id)
																		);
				$cardata['image'] 				=	((count($imagefetch)>=1)?$imagefetch[0]->s3_bucket_path:config::get('common.carnoimage'));
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
					$cardata['owner_type']       = 	"1";
					break;
					case 'SECOND':
					$cardata['owner_type']       = 	"2";
					break;
					case 'THIRD':
					$cardata['owner_type']       = 	"3";
					break;						
					case 'Fourth':
					$cardata['owner_type']       = 	"4";
					break;
					case 'Four +':
					$cardata['owner_type']       = 	"4 +";
					break;	
				}
				$makewhere					=	array('make_id'=>$uservalue->make);
				$getmake 	 				=	loanmodel::doGetmasterdetails(
																			$this->masterMakeTable,
																			$makewhere);
				$cardata['make'] 			=	((count($getmake)>=1)?$getmake[0]->makename:'');
				$modelwhere					=	array('model_id'=>$uservalue->model_id);
				$getmodel 	 				=	loanmodel::doGetmasterdetails(
																			$this->masterModelsTable,
																			$modelwhere);
				$cardata['model'] 			=	((count($getmodel)>=1)?$getmodel[0]->model_name:'');
				$varientwhere				=	array('variant_id'=>$uservalue->variant);
				$getvarient 	 			=	loanmodel::doGetmasterdetails(
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
	public function doloanrevokepage()
    {
        $fundingid 		=	Input::get('fundingvalue');
        if($fundingid	==	"")
        {
			return false;
		}
		$wherecondition	=	array('dealer_customer_loan_id'=>$fundingid);
		$updatedata		=	array('status'=>3);
		$updatefetch    = 	loanmodel::doRevokeloantable(
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

    public function doexport_excel_loan()
    {
    	try
		{
			$loanresult			= array();
			$arraywhere			= array('user_id'=>$this->id);
			$fetch_data			= loanmodel::doFetchloanDetails($arraywhere);
			//dd($fetch_data);

			$excelname 			= "Loan".time();
			$sheetheading 		= "Loan";
			$mergecells 		= "A1:L1";
			$sheetArray 		= array();
			$sheetArray[] 		= array('SL No','Customer Name','Customer Mobile Number','Customer Email','Customer PAN','Vehicle Details','Amount','Date','City','Branch Name','Loan Ticket ID','Ticket Status');
			foreach($fetch_data  as $i => $row)
			{
				$amount = report::moneyFormat($row->requested_amount);

				if($row->customerpannumber == "")
				{
					$panNumber = "NA";
				}
				else
				{
					$panNumber = $row->customerpannumber;
				}

				$sheetArray[] 	= array(++$i,$row->customername,$row->customermobileno,$row->customermailid,$panNumber,$row->vehicle_details,$amount,$row->created_date,$row->customercity,$row->branchname,$row->dealer_loan_ticket_id,$row->ticketstatus);
			}
			exportmodel::generatereport($sheetArray,$sheetheading,$excelname,$mergecells);
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
    }
        
}
