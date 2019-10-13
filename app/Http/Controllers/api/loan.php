<?php
/*
  Controller Name : loan 
  Model name	  : loanmodel
  Created By      : vinoth 22-03-2017 Version 1.0
  Module 	      : Funding module
  Use of this module is Add loan with frshservice api,
*/
namespace App\Http\Controllers\api;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\model\loanmodel;
use App\model\commonmodel;
use App\model\emailmodel;
use Illuminate\Support\Facades\Mail;
use App\Exceptions\CustomException;
use Exception;
use Config;
use Redirect;
use Carbon\Carbon;

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
    }   
    
    //view car details in addloan page
    public function doApiViewloanCarCetails()
    {
		$id 			= 	Input::get('session_user_id');
        $city_id		=	Input::get('city_id');
        $branchid		=	Input::get('branch_id');
        $customer_id	=	Input::get('customer_id');
        
        if($id == "" || $city_id	==	"" || $branchid	==	"" || $customer_id ==	"")
        {
			return response()->json(['Result'=>'0',
									'message'=>'All fields are required!!'
									]);
		}
		$cardata		=	array();
        $cardetails		=	array();
		if(Input::get('page_name')=='viewallloanlist')
		{
			$schemaname 	=  $this->getschemaname($id);
			if(!empty($schemaname))
			{
				$whereexistcar 		=	array(	'user_id'=>$id,
												'customer_id'=>$customer_id,
												'city_id'=>$city_id,
												'branch_id'=>$branchid
												);
				//get loan details check exist in loan car details
				$checkexistcarids 	=	loanmodel::doGetloanexistcar($whereexistcar);
				$getexistcarids 	=	$checkexistcarids->pluck('car_id');
				$wherecondition		=	array('car_city'=>$city_id,'branch_id'=>$branchid);
				$carmodel 			= 	loanmodel::dealerFetchcardetailsfunding($schemaname,
																	$wherecondition,
																	$getexistcarids
																	);
				//get car details		
				if(!empty($carmodel) && count($carmodel)>=1)
				{
					foreach($carmodel as $uservalue)
					{		
						$imagefetch 					= 	loanmodel::dealerFetchTableDetails(
																				$schemaname,
																				$this->DmsCarListPhotosTable,
																				array('car_id'=>$uservalue->car_id)
																				);
						$cardata['image'] 				=	((count($imagefetch)>=1)?$imagefetch[0]->s3_bucket_path:url(config::get('common.carnoimage')));
						$cardata['car_id']         		= 	$uservalue->car_id;
						$cardata['listing_id']       	= 	($uservalue->duplicate_id == null)?"":$uservalue->duplicate_id;
						$cardata['inventory_type']     	= 	$uservalue->inventory_type;
						$cardata['dealer_id']         	= 	$uservalue->dealer_id;
						$cardata['price']         		= 	$uservalue->price;
						$cardata['kms_done']         	= 	$uservalue->kms_done;
						$cardata['registration_year']  	= 	$uservalue->registration_year;
						switch($uservalue->owner_type)
						{
							case 'FIRST':
							$cardata['owner_type']      = 	"1";
							break;
							case 'SECOND':
							$cardata['owner_type']      = 	"2";
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
							default:
							$cardata['owner_type']       = 	"1";
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
						switch($uservalue->car_master_status)
						{
							case 0:
							$cardata['carstatus']       = 	"Draft";
							break;
							case 1:
							$cardata['carstatus']       = 	"Ready for Sale";
							break;
							case 2:
							$cardata['carstatus']       = 	"Live";
							break;
							case 3:
							$cardata['carstatus']       = 	"Sold";
							break;
							case 4:
							$cardata['carstatus']       = 	"Delete";
							break;							
						}
						array_push($cardetails, $cardata); 
					}
				}
				return response()->json(['Result'=>'1',
									'message'=>'success',
									'funding_list'=>$cardetails
									]);																
			}
		}
		return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
    }
    
	public function doApiregisterApplyloan()
	{
		$id 			= 	Input::get('session_user_id');
		$customerid		=	input::get('customername');
		$mobilenumber	=	input::get('mobilenumber');
		$emailid		=	input::get('emailid');
		$pannumber		=	input::get('pannumber');
		$date			=	input::get('date');
		$place			=	input::get('place');
		$branch			=	input::get('branch');
		$fundingamount	=	input::get('loanamount');
		$carid			=	input::get('carid');
		if($id == "" || $customerid	==	"" || $mobilenumber	==	"" || $emailid	==	"" || $pannumber	==	""
		|| $date	==	"" || $place	==	""	||	$branch	==	""  || $fundingamount ==	"" || $carid	==	"")
        {
			return response()->json(['Result'=>'0',
									'message'=>'All fields are required!!'
									]);
		}
		if(Input::get('page_name')=='applyloan')
		{
			$schemaname 	=  $this->getschemaname($id);
			if(!empty($schemaname))
			{
				//GET DEALER DETAILS
				$dealer_wherecondition  	=	array('d_id'=>$id);
				$fetchupdate 				= 	loanmodel::doGetmasterdetails($this->dmsdealerTable,
																				$dealer_wherecondition
																				);
				$dealer_wherecondition  	=	array('dealer_id'=>$id);
				$getdealeraddress 			= 	loanmodel::dealerFetchTableDetails($schemaname,
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
				$getbranchname	=	loanmodel::dealerFetchbranchname($schemaname,$branch);
				$branchname		=	((count($getbranchname)>=1)?$getbranchname[0]->dealer_name:'');
				//getcustomername
				$getcustomername=	loanmodel::dealerFetchcustomername($schemaname,$customerid);
				$customername	=	((count($getcustomername)>=1)?$getcustomername[0]->contact_first_name:'');
				$customermobile	=	((count($getcustomername)>=1)?$getcustomername[0]->contact_phone_1:'');
				$customeraddres	=	((count($getcustomername)>=1)?$getcustomername[0]->contact_mailing_address:'');
				//getcity
				$getcityname	=	loanmodel::dogetcitynamemaster($place);
				$cityname		=	((count($getcityname)>=1)?$getcityname[0]->city_name:'');
				$ticketinsert	=	array('dealer_ticket_type_id'=>2,
											'dealer_id'=>$id,
											'dealer_ticket_status_id'=>1);
				$vehicle_details	=	"";
				//get make,model,variant
				if(!empty($carid))
				{
					$getmakemodel 	= 	loanmodel::dealerFetchTablewhereCarid(
																$schemaname,
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
					
							$makeid 			= 	array_pluck($getmakemodel,'make');
							$model_id 			= 	array_pluck($getmakemodel,'model_id');
							$variant_id 		= 	array_pluck($getmakemodel,'variant');
							$makewhere			=	array('make_id'=>$makeid);
							$getmake 	 		=	loanmodel::doGetmasterdetails(
																				$this->masterMakeTable,
																				$makewhere);
							$vehicle_details 	.=	((count($getmake)>=1)?$getmake[0]->makename:'').' ';
							$modelwhere			=	array('model_id'=>$model_id);
							$getmodel 	 		=	loanmodel::doGetmasterdetails(
																				$this->masterModelsTable,
																				$modelwhere);
							$vehicle_details 	.=	((count($getmodel)>=1)?$getmodel[0]->model_name:'').' ';
							$model_name 		=	((count($getmodel)>=1)?$getmodel[0]->model_name:'').' ';
							$varientwhere		=	array('variant_id'=>$variant_id);
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
							$footer_message		=	'<div class="bntdiv"><p class="car-name"><b>'.$model_name.' '.$varientname.'</b></p><p class="text-color">'.$cityname.' - <span class="list-date">'.$datelist.'</span></p><p class="list-detail"><span class="text-muted">'.$carvalue->kms_done.' km</span> | <span class="text-muted">'.$carvalue->fuel_type.'</span> | <span class="text-muted">'.$carvalue->registration_year.'</span> | <span class="text-muted">'.$owner_type.' Owner</span></p><p>Rs.'.$carvalue->price.'</p><p><a href="#" class="btn btn-sm" type="submit">View More</a></p></div></div></div>';
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
														'user_id'=>$id,
														'vehicle_details'=>$vehicle_details,
														'car_id'=>$carid);
					$insertdealerloantable	=	loanmodel::doInsertLoanapplyrequest($insertloandata);
					if($insertdealerloantable >= 1)
					{
						$updatedmsdata		=	array('loan_ticket_number'=>$loanticketid);
						$updatedmstable		=	loanmodel::doUpdatedmstable($schemaname,$updatedmsdata,$carid);
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
						
							return response()->json(['Result'=>'1',
										'message'=>'Loan Applied Successfully'
										]);
						}
						else
						{
							return response()->json(['Result'=>'0',
										'message'=>'Loan Applied Failed Try Again'
										]);
						}
					}
				}
			}
			return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
		}
		return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
	}
	
	public function doApiViewloanPage()
    {
		$id 			= 	Input::get('session_user_id');
        if($id == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'User id is required!!'
									]);
		}
		if(Input::get('page_name')=='viewloandetails')
		{
			$schemaname 	=  $this->getschemaname($id);
			if(!empty($schemaname))
			{
				$fundingdetails		=	array();
				$arraywhere			=	array('user_id'=>$id);
				$getfundingresult 	=	loanmodel::doFetchloanDetails($arraywhere);
				if(!empty($getfundingresult) && count($getfundingresult))
				{
					foreach($getfundingresult as $fundingvalue)
					{
						$fundingdata['dealer_customer_loan_id']		=	$fundingvalue->dealer_customer_loan_id;
						$fundingdata['customername']				=	$fundingvalue->customername;
						$getcustomername							=	loanmodel::dealerFetchcustomername($schemaname,$fundingvalue->customer_id);
						$fundingdata['user_image']					=	((count($getcustomername)>=1)?url($getcustomername[0]->user_image):'');
						$fundingdata['customermobileno']			=	$fundingvalue->customermobileno;
						$fundingdata['customerpannumber']			=	$fundingvalue->customerpannumber;
						$fundingdata['dealer_loan_ticket_id']		=	$fundingvalue->dealer_loan_ticket_id;
						$fundingdata['customermailid']				=	$fundingvalue->customermailid;
						$fundingdata['customercity']				=	$fundingvalue->customercity;
						$fundingdata['branchname']					=	$fundingvalue->branchname;
						$fundingdata['vehicle_details']				=	($fundingvalue->vehicle_details == null)?"":$fundingvalue->vehicle_details;
						$fundingdata['status']						=	$fundingvalue->ticketstatus;
						$fundingdata['created_date']				=	$fundingvalue->created_date;
						$fundingdata['requested_amount']			=	$fundingvalue->requested_amount;
						array_push($fundingdetails,$fundingdata);
					}
					return response()->json(['Result'=>'1',
										'message'=>'success',
										'viewloanlist'=>$fundingdetails
										]);
				}	
			}
			return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
		}	
		return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);	
	}
	
	public function doApiloanrevoke()
    {
        $id 			= 	Input::get('session_user_id');
        $fundingid 		=	Input::get('loanid');
        if($id == "" || $fundingid == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'User id and funding id is required!!'
									]);
		}
		$schemaname 	=  $this->getschemaname($id);
		if(!empty($schemaname))
		{	
			$wherecondition		=	array('dealer_customer_loan_id'=>$fundingid);
			$updatedata			=	array('status'=>3);
			$updatefetch        = 	loanmodel::doRevokeloantable(
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
			return response()->json(['Result'=>'0',
										'message'=>'failure'
										]);
    }
	//GET SCHEMA NAME FUNCTION
    public function getschemaname($id)
    {
		$getdealer_schemaname 	  		=	loanmodel::masterFetchTableDetails('',
																		$this->dmsdealerTable,
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
