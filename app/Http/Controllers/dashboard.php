<?php
/*
  Module Name : Commonmodel
  Created By  : vinoth 08-02-2017 version 1.0
*/
namespace App\Http\Controllers;
use Request;
use Config;
use Redirect; 
use DB;
use Session;
use File;
use Exception;
use Cookie;
use DateTime;
use Validator;
use Carbon\Carbon;
use App\Exceptions\CustomException;
use App\model\commonmodel;
use App\model\schemamodel;
use App\model\dealermodel;
use App\start\globals;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class dashboard extends Controller
{   	
	public $login_authecation;
	public $p_id;
	public $id;
	public function __construct(Request $req)
	{
	        
        $this->middleware(function ($request, $next) 
        {   
			$this->id               	= 	session::get('ses_id');
			$this->p_id                 = 	dealermodel::parent_id($this->id);
			$this->login_authecation    = 	session()->has( 'ses_dealername' ) ? session()->get( 'ses_dealername' ) :  Redirect::to('login')->send();          
			return $next($request);
        });	        	         
	}
    
    public function doDashboard()
    {
		try
		{
			$dealercontactTable     =   "dealer_contact_management";
			$dealerinventoryTable   =   "dms_car_listings";
			$dealerfundingTable     =   "dealer_funding_details";
			$DmsCarListPhotosTable  =   "dms_car_listings_photos";
			$caridfield             =   "car_id";
			$DmsCarListDocumentTable= 	"dms_car_listings_documents";
			$DealerCarPricingTable  = 	"dealer_cars_pricing";
			$dealerviewedcarstable 	=	"dealer_viewed_cars";
			$ses_dealer_schema_name =   Session::get('dealer_schema_name');
			$id                     =   Session::get('ses_id');
			
			//get count leads data from contact table
			$wherelead              =   array('contact_type_id'=>2);
			$countleads             =   commonmodel::doschemacounttablewhere($ses_dealer_schema_name,
																	$dealercontactTable,
																	$wherelead);
			$wherecustomer          =   array('contact_type_id'=>1);
			$countcustomer          =   commonmodel::doschemacounttablewhere($ses_dealer_schema_name,
																	$dealercontactTable,
																	$wherecustomer);																
			$countinventory         =   commonmodel::doschemacountwheretable($ses_dealer_schema_name,
																	$dealerinventoryTable);
			$wherefunding			=	array('user_id'=>$id);                                                                                                                              
			$countfunding           =   count(commonmodel::doGetfundingdetails($wherefunding));
			
			$wherelive              =   array('car_master_status'=>2);
			$countlivestock         =   commonmodel::doschemacounttablewhere($ses_dealer_schema_name,
																	$dealerinventoryTable,
																	$wherelive);

			
			$getalllive         	=   commonmodel::doschemagetlivelisting($ses_dealer_schema_name);
			
			$wheredraft             =   array('car_master_status'=>0);
			$countdraft             =   commonmodel::doschemacounttablewhere($ses_dealer_schema_name,
																			$dealerinventoryTable,
																			$wheredraft);
			$soldwhere             	=   array('car_master_status'=>3);
			$soldcount             	=   commonmodel::doschemacounttablewhere($ses_dealer_schema_name,
																			$dealerinventoryTable,
																			$soldwhere);
			$startdate 				= 	new Carbon('first day of this month');
			$endofdate				=	Carbon::now('Asia/Kolkata');
			$countsold              =   commonmodel::doschemacountwherebetween($ses_dealer_schema_name,
																			'dealer_sales',
																			$startdate,
																			$endofdate);
			$countqueries           =   commonmodel::dealerSellQueriesDetail($id,$ses_dealer_schema_name);
			$countqueries 			=	count($countqueries);
			$wheresell              =   array('inventory_type'=>'PARKANDSELL');
			$countparksell          =   commonmodel::doschemacounttablewherenotwhere($ses_dealer_schema_name,
																			$dealerinventoryTable,
																			$wheresell);
			$whereown               =   array('inventory_type'=>'OWN');
			$countown               =   commonmodel::doschemacounttablewherenotwhere($ses_dealer_schema_name,
																			$dealerinventoryTable,
																			$whereown);
			$countallphotos         =   commonmodel::doschemacounttable($ses_dealer_schema_name,
																	$DmsCarListPhotosTable);
			$countalldocuments      =   commonmodel::doschemacounttable($ses_dealer_schema_name,
																	$DmsCarListDocumentTable);
			$countallprciinglist    =   commonmodel::doschemacounttable($ses_dealer_schema_name,
																	$DealerCarPricingTable);
																	
			$countphotosnotsingle   =   commonmodel::dosschemachecknotexist($ses_dealer_schema_name,
																			$dealerinventoryTable,
																			$DmsCarListPhotosTable,
																			$caridfield,
																			$caridfield
																			);
			$counphotosallrecords   =   commonmodel::dosschema_join_records($ses_dealer_schema_name,
																			$dealerinventoryTable,
																			$DmsCarListPhotosTable,
																			$caridfield,
																			$caridfield
																			);                                                                         
			$counphotoswithfive   	=   commonmodel::dosschema_join_recordsequal($ses_dealer_schema_name,
																			$dealerinventoryTable,
																			$DmsCarListPhotosTable,
																			$caridfield,
																			$caridfield
																			); 
			$countdocumentnotsingle =   commonmodel::dosschemachecknotexist($ses_dealer_schema_name,
																			$dealerinventoryTable,
																			$DmsCarListDocumentTable,
																			$caridfield,
																			$caridfield
																			);																	
			$coundocumentsallrecords=   commonmodel::dosschema_join_records($ses_dealer_schema_name,
																			$dealerinventoryTable,
																			$DmsCarListDocumentTable,
																			$caridfield,
																			$caridfield
																			);
			$coundocumentwithfive   =   commonmodel::dosschema_join_recordsequal($ses_dealer_schema_name,
																			$dealerinventoryTable,
																			$DmsCarListDocumentTable,
																			$caridfield,
																			$caridfield
																			); 
			$countgroupbystatus     =   commonmodel::doschemagroupbycount($ses_dealer_schema_name,
																			$dealerinventoryTable,
																			'car_master_status'
																			);
			$getviewcarsduplicateid	=	commonmodel::doschemagroupbynotempty(
																				$ses_dealer_schema_name,
																				$dealerinventoryTable,
																				'duplicate_id');
			$getduplicatevalues		=	array();
			$getduplicateid			=	array();	
			$getduplicateid			=	(count($getviewcarsduplicateid) >= 1)?$getviewcarsduplicateid->pluck('duplicate_id'):$getduplicateid;
			if(!empty($getduplicateid))
			{
				foreach($getduplicateid as $duplicateid)
				{
					$getduplicatevalues[]	=	$duplicateid;
				}
			}
			$countnoofviewcars     	=   commonmodel::domastergroupbywherein($dealerviewedcarstable,
																			'car_id',
																			$getduplicatevalues
																			);
			$countviewcars			=	(count($countnoofviewcars) >= 1)?$countnoofviewcars->sum('viewcarcount'):0;

			//get six month sales count
			$countsoldsixmonth      =   commonmodel::doschemacounttablewheresixmonth($ses_dealer_schema_name,
																			'dealer_sales');
			//get six month sales amount
			$countsoldprciesixmonth =   commonmodel::doschemacounttablewheresixsalesprice($ses_dealer_schema_name,
																			'dealer_sales');
			$soldoutamount 	=	0; 
			if(!empty($countsoldprciesixmonth))
			{
				$soldoutamount	=	$countsoldprciesixmonth[0]->soldamount;
			}
			$inventorystatus 			=	array();
			$dyanmicinventorystatus 	=	array();
			$statusfields 				= 	array();
			if(!empty($countgroupbystatus) && count($countgroupbystatus)>=1)
			{
				foreach($countgroupbystatus as $status)
				{
					if($status->car_master_status == 0)
					{
						$statusfields[] =    array('value'=>$status->countinventorystatus,
														'color'=>'#F7464A',
														'highlight'=>'#FF5A5E',
														'label'=>'Draft');
						$inventorystatus['label']	=	 "Draft";
						$inventorystatus['color']	=	 0;
					}
					else if($status->car_master_status == 1)
					{
						$statusfields[] =    array('value'=>$status->countinventorystatus,
														'color'=>'#46BFBD',
														'highlight'=>'#5AD3D1',
														'label'=>'Ready for Sale');
						$inventorystatus['label']	=	 "Ready for Sale";
						$inventorystatus['color']	=	 1; 
					}
					else if($status->car_master_status == 2)
					{
						$statusfields[] =    array('value'=>$status->countinventorystatus,
														'color'=>'#FDB45C',
														'highlight'=>'#FFC870',
														'label'=>'Live');
						$inventorystatus['label']	=	 "Live";
						$inventorystatus['color']	=	 2; 
					}
					else if($status->car_master_status == 3)
					{
						$statusfields[] =    array('value'=>$status->countinventorystatus,
														'color'=>'#949FB1',
														'highlight'=>'#A8B3C5',
														'label'=>'Sold');
						$inventorystatus['label']	=	 "Sold";
						$inventorystatus['color']	=	 3; 
					}
					else if($status->car_master_status == 4)
					{
						$statusfields[] =    array('value'=>$status->countinventorystatus,
														'color'=>'#4D5360',
														'highlight'=>'#616774',
														'label'=>'Delete'); 
						$inventorystatus['label']	=	 "Delete";
						$inventorystatus['color']	=	 4;
					}
					array_push($dyanmicinventorystatus,$inventorystatus);
				}
			}
			$carviewrecords 		=	array();
			$totalcarlistid 		=	array();
			$collection 			= 	collect($countnoofviewcars);
			$sorted 				= 	$collection->sortByDesc('viewcarcount');
			$carviewrecordsnum 		=	(!empty($sorted) && count($sorted) >= 1)?$sorted->take(5):$totalcarlistid;
			$carviewrecords 		=	(!empty($sorted) && count($sorted) >= 1)?$sorted->take(5)->pluck('car_id'):$totalcarlistid;
			if(!empty($carviewrecords) && count($carviewrecords)>=1)
			{
				foreach($carviewrecords as $carid)
				{
					$totalcarlistid[] 	= 	$carid;
				}
			}
			$wherelive              =   array('car_master_status'=>2);
			$fetchcardetails 		=   commonmodel::dosschemacheckvaluewherein($ses_dealer_schema_name,
																			$dealerinventoryTable,
																			$carviewrecords,
																			$wherelive
																			);
			$data 				=	array();
			$finalresult 		=	array();
			$initialize  		=	1;	
			$piechart 			=	array();
			$piechartcolor 		=	array();
			$piechartdyncolor 	=	array();
			if(!empty($carviewrecordsnum) && count($carviewrecordsnum)>=1)
			{
				foreach($carviewrecordsnum as $carduplicateid)
				{
					if(!empty($fetchcardetails) && count($fetchcardetails)>=1)
					{
						foreach($fetchcardetails as $caridvalue)
						{
							 $orwhere 		= 	array('car_id'=>$caridvalue->car_id,'profile_pic_name'=>'profile_pic');
							 $fetchphoto 	=   commonmodel::dosschemacheckwhere($ses_dealer_schema_name,
																					$DmsCarListPhotosTable,
																					$orwhere
																					);
							 $wheremodel 	= 	array('model_id'=>$caridvalue->model_id);
							 $fetchmodel 	=   commonmodel::getAllRecordsWhere('master_models',
																					$wheremodel
																					);
							 $data['model'] =	((count($fetchmodel)>=1)?$fetchmodel[0]->model_name:'');
							 $wherevarient 	= 	array('variant_id'=>$caridvalue->variant);
							 $fetchvarient 	=   commonmodel::getAllRecordsWhere('master_variants',
																					$wherevarient
																					);
							 $data['varient'] =	((count($fetchvarient)>=1)?$fetchvarient[0]->variant_name:'');
							//get car id and check car id is matching
							if($carduplicateid->car_id == $caridvalue->duplicate_id)
							{
								if($initialize == 1)
								{
									$piechart[] 	=	array('value'=>$carduplicateid->viewcarcount,
																	'color'=>'#F7464A',
																	'highlight'=>'#616774',
																	'label'=>$fetchmodel[0]->model_name.' - '.$fetchvarient[0]->variant_name.' - '.$caridvalue->registration_year);
									$piechartcolor['label'] 	=	$fetchmodel[0]->model_name.' - '.$fetchvarient[0]->variant_name.' - '.$caridvalue->registration_year;
									$piechartcolor['color'] 	=	$initialize;
									$piechartcolor['countcar'] 	=	$carduplicateid->viewcarcount;
									$piechartcolor['car_idnew'] =	$carduplicateid->car_id;
									if($countviewcars 	==	0)
									{
										$piechartcolor['progress'] =	0;
									}
									else
									{
										$piechartcolor['progress'] =	round(($carduplicateid->viewcarcount/$countviewcars)*100);
									}
								}
								if($initialize == 2)
								{
									$piechart[] 	=	array('value'=>$carduplicateid->viewcarcount,
																	'color'=>'#46BFBD',
																	'highlight'=>'#616774',
																	'label'=>$fetchmodel[0]->model_name.' - '.$fetchvarient[0]->variant_name.' - '.$caridvalue->registration_year);
									$piechartcolor['label'] 	=	$fetchmodel[0]->model_name.' - '.$fetchvarient[0]->variant_name.' - '.$caridvalue->registration_year;
									$piechartcolor['color'] 	=	$initialize;
									$piechartcolor['countcar'] 	=	$carduplicateid->viewcarcount;
									$piechartcolor['car_idnew'] =	$carduplicateid->car_id;
									if($countviewcars 	==	0)
									{
										$piechartcolor['progress'] =	0;
									}
									else
									{
										$piechartcolor['progress'] =	round(($carduplicateid->viewcarcount/$countviewcars)*100);
									}
								}
								if($initialize == 3)
								{
									$piechart[] 	=	array('value'=>$carduplicateid->viewcarcount,
																	'color'=>'#FDB45C',
																	'highlight'=>'#616774',
																	'label'=>$fetchmodel[0]->model_name.' - '.$fetchvarient[0]->variant_name.' - '.$caridvalue->registration_year);
									$piechartcolor['label'] 	=	$fetchmodel[0]->model_name.' - '.$fetchvarient[0]->variant_name.' - '.$caridvalue->registration_year;
									$piechartcolor['color'] 	=	$initialize;
									$piechartcolor['countcar'] 	=	$carduplicateid->viewcarcount;
									$piechartcolor['car_idnew'] =	$carduplicateid->car_id;
									if($countviewcars 	==	0)
									{
										$piechartcolor['progress'] =	0;
									}
									else
									{
										$piechartcolor['progress'] =	round(($carduplicateid->viewcarcount/$countviewcars)*100);
									}
								}
								if($initialize == 4)
								{
									$piechart[] 	=	array('value'=>$carduplicateid->viewcarcount,
																	'color'=>'#949FB1',
																	'highlight'=>'#616774',
																	'label'=>$fetchmodel[0]->model_name.' - '.$fetchvarient[0]->variant_name.' - '.$caridvalue->registration_year);
									$piechartcolor['label'] 	=	$fetchmodel[0]->model_name.' - '.$fetchvarient[0]->variant_name.' - '.$caridvalue->registration_year;
									$piechartcolor['color'] 	=	$initialize;
									$piechartcolor['countcar'] 	=	$carduplicateid->viewcarcount;
									$piechartcolor['car_idnew'] =	$carduplicateid->car_id;
									if($countviewcars 	==	0)
									{
										$piechartcolor['progress'] =	0;
									}
									else
									{
										$piechartcolor['progress'] =	round(($carduplicateid->viewcarcount/$countviewcars)*100);
									}
								}
								if($initialize == 5)
								{
									$piechart[] 	=	array('value'=>$carduplicateid->viewcarcount,
																	'color'=>'#4D5360',
																	'highlight'=>'#616774',
																	'label'=>$fetchmodel[0]->model_name.' - '.$fetchvarient[0]->variant_name.' - '.$caridvalue->registration_year);
									$piechartcolor['label'] 	=	$fetchmodel[0]->model_name.' - '.$fetchvarient[0]->variant_name.' - '.$caridvalue->registration_year;
									$piechartcolor['color'] 	=	$initialize;
									$piechartcolor['countcar'] 	=	$carduplicateid->viewcarcount;
									$piechartcolor['car_idnew'] =	$carduplicateid->car_id;
									if($countviewcars 	==	0)
									{
										$piechartcolor['progress'] =	0;
									}
									else
									{
										$piechartcolor['progress'] =	round(($carduplicateid->viewcarcount/$countviewcars)*100);
									}
								}
								if(!empty($piechartcolor))
								{
									foreach($piechartcolor as $piechat)
									{
										if($piechat != "")
										{
											array_push($piechartdyncolor,$piechartcolor);
										}
									}
								}
					
								 $data['kmsdone']   			=  	$caridvalue->kms_done;
								 $data['fuel_type']   			=  	$caridvalue->fuel_type;
								 $data['registration_year']   	=  	$caridvalue->registration_year;
								 $data['owner_type']   			=  	$caridvalue->owner_type;
								 $data['price']   				=  	$caridvalue->price;
								 $data['car_id']   				=  	$caridvalue->car_id;
								 if(!empty($fetchphoto) && count($fetchphoto) >= 1)
								 {
									 $data['image']   			=  	$fetchphoto[0]->s3_bucket_path;
								 }
								 else
								 {
									 $data['image']   			=  	Config::get('common.carnoimage');
								 }
								 if($initialize ==	1)
								 {
									 $data['id']   				=  	$initialize;
									 $data['individualcount']	=	$carduplicateid->viewcarcount;
								 }
								 if($initialize ==	2)
								 {
									 $data['id']   				=  	$initialize;
									 $data['individualcount']	=	$carduplicateid->viewcarcount;
								 }
								 if($initialize ==	3)
								 {
									 $data['id']   				=  	$initialize;
									 $data['individualcount']	=	$carduplicateid->viewcarcount;
								 }
								 if($initialize ==	4)
								 {
									 $data['id']   				=  	$initialize;
									 $data['individualcount']	=	$carduplicateid->viewcarcount;
								 }
								 if($initialize ==	5)
								 {
									 $data['id']   				=  	$initialize;
									 $data['individualcount']	=	$carduplicateid->viewcarcount;
								 }
								 
								 $initialize++;
								 array_push($finalresult,$data);
							}
						}
					}
				}//endforeach
			}//endif
			
			//CHECK DIVISIBLE ERROR
			if($countinventory == 0)
			{
				$roundofparksell 		= 	0;
				$roundofown 			= 	0;
				$roundofsold 			= 	0;
				$roundofphotos 			=	0;
				$roundofdocuments 		=	0;
			}
			else
			{
				$roundofparksell 		= 	round(($countparksell/$countinventory)*100);
				$roundofown 			= 	round(($countown/$countinventory)*100);
				$roundofsold 			= 	round(($soldcount/$countinventory)*100);
				$roundofphotos 			=	round(((count($counphotosallrecords)+count($counphotoswithfive))/$countinventory)*100);
				$roundofdocuments 		=	round(((count($coundocumentsallrecords)+count($coundocumentwithfive))/$countinventory)*100);
			}
			//remove duplicate array
			$newpiechartdyncolor 	= 	array_map("unserialize", array_unique(array_map("serialize", $piechartdyncolor)));		
			
			 //GET LAST SIX MONTH YEAR AND MONTH FORMAT                                                                        
			 $datethismonth	 		= 	Carbon::now('Asia/Kolkata')->format('M Y');
			 $datelastmonth	 		= 	Carbon::now('Asia/Kolkata')->submonth()->format('M Y');
			 $datelasttwomonth		= 	Carbon::now('Asia/Kolkata')->submonths(2)->format('M Y');
			 $datelastthreemonth	= 	Carbon::now('Asia/Kolkata')->submonths(3)->format('M Y');
			 $datelastfourmonth		= 	Carbon::now('Asia/Kolkata')->submonths(4)->format('M Y');
			 $datelastfivemonth		= 	Carbon::now('Asia/Kolkata')->submonths(5)->format('M Y');
			 $showlastsixmonth		=	array($datelastfivemonth,$datelastfourmonth,$datelastthreemonth
										,$datelasttwomonth,$datelastmonth,$datethismonth);
											  
			//get six month count and sales amount
			 $countsoldprciesixmonthamount	=   commonmodel::doSchemaCountWheresixsalesprice($ses_dealer_schema_name,
																			'dealer_sales');
			 $datethismonth	 	= 	Carbon::now('Asia/Kolkata')->format('m');
			 $datelastmonth	 	= 	Carbon::now('Asia/Kolkata')->submonth()->format('m');
			 $datelasttwomonth	= 	Carbon::now('Asia/Kolkata')->submonths(2)->format('m');
			 $datelastthreemonth= 	Carbon::now('Asia/Kolkata')->submonths(3)->format('m');
			 $datelastfourmonth	= 	Carbon::now('Asia/Kolkata')->submonths(4)->format('m');
			 $datelastfivemonth	= 	Carbon::now('Asia/Kolkata')->submonths(5)->format('m');
			 $firstmonth	=	0;$secoundmonth	=	0;$thirdmonth	=	0;
			 $fourthmonth	=	0;$fithmonth	=	0;$sixmonth		=	0;
			 $firstsold		=	0;$secoundsold	=	0;$thirdsold	=	0;
			 $fourthsold	=	0;$fithsold		=	0;$sixsold		=	0;
			 if(!empty($countsoldprciesixmonthamount) && count($countsoldprciesixmonthamount) >= 1)
			 {
				 foreach($countsoldprciesixmonthamount as $getsalemonth)
				 {//count sold
					$firstmonth		=	($datethismonth 	== 	$getsalemonth->mongodate)?$getsalemonth->countmonth:$firstmonth;
					$secoundmonth	=	($datelastmonth 	== 	$getsalemonth->mongodate)?$getsalemonth->countmonth:$secoundmonth;
					$thirdmonth		=	($datelasttwomonth 	== 	$getsalemonth->mongodate)?$getsalemonth->countmonth:$thirdmonth;
					$fourthmonth	=	($datelastthreemonth == $getsalemonth->mongodate)?$getsalemonth->countmonth:$fourthmonth;
					$fithmonth		=	($datelastfourmonth == 	$getsalemonth->mongodate)?$getsalemonth->countmonth:$fithmonth;
					$sixmonth		=	($datelastfivemonth == 	$getsalemonth->mongodate)?$getsalemonth->countmonth:$sixmonth;
					//amount sold
					$firstsold		=	($datethismonth 	== 	$getsalemonth->mongodate)?$getsalemonth->soldamount:$firstsold;
					$secoundsold	=	($datelastmonth 	== 	$getsalemonth->mongodate)?$getsalemonth->soldamount:$secoundsold;
					$thirdsold		=	($datelasttwomonth 	== 	$getsalemonth->mongodate)?$getsalemonth->soldamount:$thirdsold;
					$fourthsold		=	($datelastthreemonth == $getsalemonth->mongodate)?$getsalemonth->soldamount:$fourthsold;
					$fithsold		=	($datelastfourmonth == 	$getsalemonth->mongodate)?$getsalemonth->soldamount:$fithsold;
					$sixsold		=	($datelastfivemonth == 	$getsalemonth->mongodate)?$getsalemonth->soldamount:$sixsold;
				 }
			}
			//CONVERT INDIAN CURRENCY FORMAT
			$convertsoldprice 		=	$this->moneyFormatIndia($soldoutamount);
			$drawgraphsoldcount 	=	array($sixmonth,$fithmonth,
										$fourthmonth,$thirdmonth,$secoundmonth,$firstmonth);
			$drawgraphsoldamount 	=	array($sixsold,$fithsold,
										$fourthsold,$thirdsold,$secoundsold,$firstsold); 

			$currentdate 			= 	Carbon::now('Asia/Kolkata');
			$setdateformat 			=	Carbon::setToStringFormat('jS \o\f F, Y');
			$contact_value          = 	encrypt(0);  
			$compact_array   		=   array('currentdate'=>$currentdate,
												'contact_value'	=>$contact_value,
												'dyanmicinventorystatus'=>$dyanmicinventorystatus,
												'leadcount'=>$countleads,
												'custmoercount'=>$countcustomer,
												'inventorycount'=>$countinventory,
												'fundingcount'=>$countfunding,
												'livecount'=>$countlivestock,
												'draftcount'=>$countdraft,
												'soldcount'=>$countsold,
												'soldcountinventory'=>$soldcount,
												'quriescount'=>$countqueries,
												'parksellcount'=>$countparksell,
												'owncount'=>$countown,
												'roundofparksell'=>$roundofparksell,
												'roundofown'=>$roundofown,
												'roundofsold'=>$roundofsold,
												'photoscount'=>$countallphotos,
												'documentcount'=>$countalldocuments,
												'pricingcount'=>$countallprciinglist,
												'inventorystatus'=>json_encode($statusfields),
												'piechart'=>json_encode($piechart),
												'newpiechartdyncolor'=>$newpiechartdyncolor,
												'roundofphotos'=>$roundofphotos,
												'photoscountallrecords'=>count($counphotosallrecords),
												'photosnorecordscount'=>$countphotosnotsingle,
												'photoscountwithfive'=>count($counphotoswithfive),
												'roundofdocuments'=>$roundofdocuments,
												'documentnorecordscount'=>$countdocumentnotsingle,
												'documentscountallrecords'=>count($coundocumentsallrecords),
												'documentscountwithfive'=>count($coundocumentwithfive),
												'viewcarscount'=>$countviewcars,
												'viewcardetails'=>$carviewrecords,
												'carvieweddetails'=>$finalresult,
												'countsoldsixmonth'=>$countsoldsixmonth,
												'soldpriceamount'=>$convertsoldprice,
												'getalllive'=>$getalllive,
												'showlastsixmonth'=>json_encode($showlastsixmonth),
												'graphsoldcount'=>json_encode($drawgraphsoldcount),
												'graphsoldamount'=>json_encode($drawgraphsoldamount)
												);
			$active_menu_name       =   'dashboard_menu';
			$header_data            =   commonmodel::commonheaderdata();
			$header_data['title']	=	'Dashboard';
			$compact_array          =   array('active_menu_name'=>$active_menu_name)+$compact_array;
			
			return view('dashboard',compact('compact_array','header_data'));
		}
		
		catch(\Exception $e){
			throw new CustomException($e->getMessage());
			/*$error 			= 	$e->getMessage();
			$header_data 	= 	commonmodel::commonheaderdata();
			$createdate    	=   'error_exceptionlog_'.date("y-m-d");
			if(file_exists(public_path('/custom_logs/')))
			{
				 $original 	= 	public_path('/custom_logs/');
				 $filename 	= 	File::append($original.'/'.$createdate.'.txt',$error."\r\n");
				 $realpath 	= 	url('/custom_logs/'.$createdate.'.txt');
				 $nameoffile	=	$createdate.'.txt';
				 $result 	= 	Storage::put("/custom_logs/".$nameoffile, file_get_contents($realpath),'public');
			}
			else
			{
				 File::makeDirectory(public_path('/custom_logs/'), 0777, true, true);
				 $original 	= 	public_path('/custom_logs/');
				 $filename 	= 	File::put($original.'/'.$createdate.'.txt',$error);
				 $realpath 	= 	url('/custom_logs/'.$createdate.'.txt');
				 $nameoffile	=	$createdate.'.txt';
				 $result 	= 	Storage::put("/custom_logs/".$nameoffile, file_get_contents($realpath),'public');
			}
			return view('errors/503',compact('error','header_data'));*/
		} 
    }

    public function moneyFormatIndia($num){
        $explrestunits = "" ;
        if(strlen($num)>3){
            $lastthree = substr($num, strlen($num)-3, strlen($num));
            $restunits = substr($num, 0, strlen($num)-3);
            $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; 
            $expunit = str_split($restunits, 2);
            for($i=0; $i<sizeof($expunit); $i++){
                if($i==0)
                {
                    $explrestunits .= (int)$expunit[$i].",";
                }else{
                    $explrestunits .= $expunit[$i].",";
                }
            }
            $thecash = $explrestunits.$lastthree;
        } else {
            $thecash = $num;
        }
        return $thecash; 
    }
}


