<?php
/*
  Controlelr  : funding 
  Created By  : vinoth 21-03-2017 Version 1.0
  Module 	  : Funding module
  Use of this module is Add funding with frshservice api,
*/
namespace App\Http\Controllers\api;
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
use Exception;
use Config;
use Redirect;
use Carbon\Carbon;

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
    }
    
    public function doApigetbranch()
    {
		$id 			= 	Input::get('session_user_id');
		$city_id 		= 	Input::get('city_id');
		if($id == "" || $city_id	==	"")
        {
			return response()->json(['Result'=>'0',
									'message'=>'User and city id is required!!'
									]);
		}
		
		$schemaname 	=  	$this->getschemaname($id);
			if(!empty($schemaname))
			{
				$branches 		= 	fundingmodel::dealerFetchbranchDetails($schemaname,
																	array('dealer_city'=>$city_id)
																	);
				return response()->json(['Result'=>'1',
										'branchname'=>$branches
										]);
			}
			return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
    }
    //view car details in addfund page
    public function doApiViewfundingCarCetails()
    {
		$id 			= 	Input::get('session_user_id');
        $city_id		=	Input::get('city_id');
        $branchid		=	Input::get('branch_id');
        
        if($id == "" || $city_id	==	"" || $branchid	==	"")
        {
			return response()->json(['Result'=>'0',
									'message'=>'All fields are required!!'
									]);
		}
		$cardata		=	array();
        $cardetails		=	array();
		if(Input::get('page_name')=='viewallfundinglist')
		{
			$schemaname 	=  $this->getschemaname($id);
			if(!empty($schemaname))
			{
				$wherecondition		=	array('funding_applied'=>'0','car_city'=>$city_id,'branch_id'=>$branchid);
				$carmodel 			= 	fundingmodel::dealerFetchcardetailsfunding($schemaname,
																	$wherecondition
																	);
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
							$cardata['owner_type']       = 	"4 +";
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
   
    public function doregisterApplyfunding()
	{		
		$id 			= 	Input::get('session_user_id');
		$dealershipname	=	input::get('dealershipname');
		$dealername		=	input::get('dealername');
		$emailid		=	input::get('emailid');
		$mobilenumber	=	input::get('mobilenumber');
		$date			=	input::get('date');
		$place			=	input::get('place');
		$branch			=	input::get('branch');
		$fundingamount	=	input::get('fundingamount');
		$carid			=	input::get('appendcarid');
		if($id == "" || $dealershipname	==	"" || $dealername	==	"" || $emailid	==	"" || $mobilenumber	==	""
		|| $date	==	"" || $place	==	""	||	$branch	==	""  || $fundingamount ==	"" || $carid	==	"")
        {
			return response()->json(['Result'=>'0',
									'message'=>'All fields are required!!'
									]);
		}
		$carid			=	collect($carid);
		if(Input::get('page_name')=='applyfunding')
		{
			$schemaname 	=  $this->getschemaname($id);
			if(!empty($schemaname))
			{
				$footeremailtemp		=	"";	
				//GET DEALER DETAILS
				$dealer_wherecondition  =	array('d_id'=>$id);
				$fetchupdate 			= 	fundingmodel::doGetmasterdetails($this->dmsdealerTable,
																				$dealer_wherecondition
																				);
				$dealer_profile_image	=	((count($fetchupdate)>=1)?$fetchupdate[0]->logo:url(config::get('common.profilenoimage')));																
				$from_email				=	((count($fetchupdate)>=1)?$fetchupdate[0]->d_email:'');
				//getbranchname
				$getbranchname	=	fundingmodel::dealerFetchbranchname($schemaname,$branch);
				$branchname		=	((count($getbranchname)>=1)?$getbranchname[0]->dealer_name:'');
				//getcity
				$getcityname	=	fundingmodel::dogetcitynamemaster($place);
				$cityname		=	((count($getcityname)>=1)?$getcityname[0]->city_name:'');
				$dealer_wherecondition	=	array('dealer_id'=>$id);
				$getdealeraddress 		= 	fundingmodel::dealerFetchTableDetails($schemaname,
															'dms_dealerdetails',
															$dealer_wherecondition
															);
				$dealeraddress			=	((count($getdealeraddress)>=1)?$getdealeraddress[0]->Address:'');
        
				$ticketinsert	=	array('dealer_ticket_type_id'=>1,
											'dealer_id'=>$id,
											'dealer_ticket_status_id'=>1);
				
				$insertticketrequesttable	=	fundingmodel::doInsertTicketrequest($ticketinsert);
				if($insertticketrequesttable >= 1)
				{
					//get last record for unique ticket creation
					$getlastid	 			=	fundingmodel::latest('dealer_funding_detail_id')->pluck('dealer_funding_detail_id')->first();
					$maketicketid			=	($getlastid >= 1)?($getlastid+1):$insertticketrequesttable;		
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
														'user_id'=>$id
														);
					$insertdealerfundingtable	=	fundingmodel::doInsertfundingapplyrequest($insertfundingdata);
					if($insertdealerfundingtable >= 1)
					{
						//get make,model,variant
						if(!empty($carid))
						{
							$getmakemodel 	= 	fundingmodel::dealerFetchTablewhereinCarid(
																		$schemaname,
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
									$insertfundingitems	=	array(
																'dealer_funding_detail_id'=>$insertdealerfundingtable,
																'dealer_car_id'=>$value->car_id,
																'dealer_listing_id'=>'',
																'dealer_car_make_name'=>$makename,
																'dealer_car_model_name'=>$modelname,
																'dealer_car_variant_name'=>$variantname,
																'dealer_car_price'=>$fundingamount
																		);
									$insertdealerfundingitems	=	fundingmodel::doInsertFundingItems($insertfundingitems);
									$footeremailtemp  	.=	'<tr><td>'.$i.'</td><td><img src="'.$carimage.'" alt="" class="img-responsive table-img"></td><td><p><b>'.$modelname.' '.$variantname.' '.$value->registration_year.'</b></p><p>Rs.'.$value->price.'</p><p class="list-detail"><span class="text-muted">'.$value->kms_done.' km</span> | <span class="text-muted">'.$value->fuel_type.'</span> | <span class="text-muted">'.$value->registration_year.'</span> | <span class="text-muted">'.$owner_type.' Owner</span></p></td></tr>';
									$i++;
								}
								$footeremailtemp		.=	'</tbody></table></div></div>';
							}
						}
						$updatedmsdata		=	array('funding_applied'=>'1','funding_ticket_number'=>$findingticketid);
						$updatedmstable		=	fundingmodel::doUpdatedmstable($schemaname,$updatedmsdata,$carid);
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
							return response()->json(['Result'=>'1',
										'message'=>'Funding Applied Successfully'
										]);
						}
						else
						{
							return response()->json(['Result'=>'0',
										'message'=>'Funding Applied Failed Try Again'
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
	
	public function doApiViewfundingPage()
    {
		$id 			= 	Input::get('session_user_id');
        if($id == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'User id is required!!'
									]);
		}
		if(Input::get('page_name')=='viewfundingdetails')
		{
			$schemaname 	=  $this->getschemaname($id);
			if(!empty($schemaname))
			{
				$fundingdetails		=	array();
				$arraywhere			=	array('user_id'=>$id);
				$getfundingresult 	=	fundingmodel::doGetfundingdetails($arraywhere);
				if(!empty($getfundingresult) && count($getfundingresult))
				{
					foreach($getfundingresult as $fundingvalue)
					{
						$fundingdata['fundingid']				=	$fundingvalue->dealer_funding_detail_id;
						$fundingdata['dealername']				=	$fundingvalue->dealername;
						$fundingdata['dealershipname']			=	$fundingvalue->dealershipname;
						$fundingdata['dealermobileno']			=	$fundingvalue->dealermobileno;
						$fundingdata['dealermailid']			=	$fundingvalue->dealermailid;
						$fundingdata['requested_amount']		=	$fundingvalue->requested_amount;
						$fundingdata['created_date']			=	$fundingvalue->created_date;
						$fundingdata['dealercity']				=	$fundingvalue->dealercity;
						$fundingdata['branchname']				=	$fundingvalue->branchname;
						$fundingdata['dealer_listing_id']		=	($fundingvalue->dealer_listing_id == null)?"":$fundingvalue->dealer_listing_id;
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
					return response()->json(['Result'=>'1',
										'message'=>'success',
										'viewfundinglist'=>$fundingdetails
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
	
	public function doApifundingrevoke()
    {
        $id 			= 	Input::get('session_user_id');
        $fundingid 		=	Input::get('fundingid');
        if($id == "" || $fundingid == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'User id and funding id is required!!'
									]);
		}
		$schemaname 	=  $this->getschemaname($id);
		if(!empty($schemaname))
		{	
			$wherecondition		=	array('dealer_funding_detail_id'=>$fundingid);
			$updatedata			=	array('status'=>3);
			$updatefetch        = 	fundingmodel::doRevokefundingtable(
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
		$getdealer_schemaname 	  		=	fundingmodel::masterFetchTableDetails('',
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
