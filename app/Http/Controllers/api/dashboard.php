<?php
/* 
    Module Name : DASHBOARD API   
    Created By  : vinoth 02-02-2017  
    This Api controller is using in dashboard page 
*/
namespace App\Http\Controllers\api;
use App\Http\Requests;
use App\Http\registervalidation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\buyymodel;
use App\model\common;
use App\model\schemamodel;
use App\model\dealermodel;
use App\model\inventorymodel;
use App\model\commonmodel;
use Illuminate\Support\Facades\Input;
use App\model\mongomodel;
use DB;
use Config;
use Carbon\Carbon;
//DEFINE CLASS NAME

class dashboard extends Controller
{
	public $masterMainLoginTable;
	//CONSTRUCT METHOD
	public function __construct(Request $request)
    {				
         $this->masterMainLoginTable 	= 	"dms_dealers";
	}
	
	/*THIS FUNCTION USED FOR GET USER ROLE DETAILS*/
    public function doApidashboard()
    {          
		$id 			= 	Input::get('session_user_id');
		if($id == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'User id is required!!'
									]);
		}
		
		$schemaname 	=  	$this->getschemaname($id);
			if(!empty($schemaname))
			{
				$getallcityid 			=	array();
				$getallcityids 			=	array();
				$cityidresult 			=	array();
				$getallcityid   		= 	commonmodel::dealerFetchcitynamegrouby(
																$schemaname
																);
				$cityidresult			=	array_pluck($getallcityid,'car_city');
				$getallcityids			=	collect($cityidresult);
				$getallcitynames   		= 	commonmodel::doMasterrecordswherein(
																$getallcityids
																);
				$dealercontactTable     =   "dealer_contact_management";
				$dealerinventoryTable   =   "dms_car_listings";
				$dealerfundingTable     =   "dealer_funding_details";
				$DmsCarListPhotosTable  =   "dms_car_listings_photos";
				$caridfield             =   "car_id";
				$DmsCarListDocumentTable= 	"dms_car_listings_documents";
				$DealerCarPricingTable  = 	"dealer_cars_pricing";
				$dealerviewedcarstable 	=	"dealer_viewed_cars";
				$ses_dealer_schema_name =   $schemaname;
				//get dealer contact type table
				$newcontactarray		=	array();
				$datacontact			=	array();
				$datacontact1			=	array(array('contact_type_id'=>0,'contact_type'=>'All'));
				$getdealercontacttype 	=	commonmodel::dealer_contact_type()->get();
				if(!empty($getdealercontacttype) && count($getdealercontacttype) >=1 )
				{
					foreach($getdealercontacttype as $type)
					{
						$datacontact['contact_type_id']	=	$type->contact_type_id;
						$datacontact['contact_type']	=	$type->contact_type;
						array_push($newcontactarray,$datacontact);
					}
				}
				$dealer_contact_type 	=	array_merge($datacontact1,$newcontactarray);
				//$dealer_contact_type 	=	$newcontactarray;
				
				//GET EMPLOYEE TYPE
				$newemployeearray		=	array();
				$dataemployee			=	array();
				$dataemployee1			=	array(array('employee_type_id'=>0,'employee_type'=>'All'));
				$getdealeremployeetype 	=	commonmodel::dealer_employee_type()->get();
				
				if(!empty($getdealeremployeetype) && count($getdealeremployeetype) >=1 )
				{
					foreach($getdealeremployeetype as $type)
					{
						$dataemployee['employee_type_id']	=	$type->employee_type_id;
						$dataemployee['employee_type']		=	$type->employee_type;
						array_push($newemployeearray,$dataemployee);
					}
				}
				$getnewemployeearray 	=	array_merge($dataemployee1,$newemployeearray);
				//$getnewemployeearray 	=	$newemployeearray;
				
				$newrolearray			=	array();
				$datarole				=	array();
				$datarole1				=	array(array('master_role_id'=>0,'master_role_name'=>'All'));
				$getdealerroletype 		=	commonmodel::user_role()->get();
				if(!empty($getdealerroletype) && count($getdealerroletype) >=1 )
				{
					foreach($getdealerroletype as $type)
					{
						$datarole['master_role_id']		=	$type->master_role_id;
						$datarole['master_role_name']	=	$type->master_role_name;
						array_push($newrolearray,$datarole);
					}
				}
				$user_role_list 		=	array_merge($datarole1,$newrolearray);
				//$user_role_list 		=	$newrolearray;
				//get count leads data from contact table
				$countinventory        	=   commonmodel::doschemacountwheretable($ses_dealer_schema_name,
                                                                $dealerinventoryTable);
				$wherelead              =   array('contact_type_id'=>2);
				$countleads             =   commonmodel::doschemacounttablewhere($ses_dealer_schema_name,
																		$dealercontactTable,
																		$wherelead);
				$wherecustomer          =   array('contact_type_id'=>1);
				$countcustomer          =   commonmodel::doschemacounttablewhere($ses_dealer_schema_name,
																	$dealercontactTable,
																	$wherecustomer);
				                                                                      
				$wherefunding			=	array('user_id'=>$id);                                                                                                                              
				$countfunding           =   commonmodel::doGetfundingdetails($wherefunding);
				$countfunding           =   count($countfunding);
				$wherelive              =   array('car_master_status'=>2);
				$countlivestock         =   commonmodel::doschemacounttablewhere($ses_dealer_schema_name,
																		$dealerinventoryTable,
																		$wherelive);
				$wheredraft             =   array('car_master_status'=>0);
				$countdraft             =   commonmodel::doschemacounttablewhere($ses_dealer_schema_name,
																				$dealerinventoryTable,
																				$wheredraft);
				$startdate 				= 	new Carbon('first day of this month');
				$endofdate				=	Carbon::now('Asia/Kolkata');
				$countsold              =   commonmodel::doschemacountwherebetween($ses_dealer_schema_name,
                                                                        'dealer_sales',
                                                                        $startdate,
                                                                        $endofdate);
				$countqueries           =   commonmodel::dealerSellQueriesDetail($id,$ses_dealer_schema_name);
				$countqueries 			=	count($countqueries);
				//get six month sales count
				$countsoldsixmonth      =   commonmodel::doschemacounttablewheresixmonth($ses_dealer_schema_name,
                                                                        'dealer_sales');
				//get six month sales amount
				$countsoldprciesixmonth =   commonmodel::doschemacounttablewheresixsalesprice($ses_dealer_schema_name,
																				'dealer_sales'
																				);
				
				 //get live,draft,ready,delete
				$soldwhere             	=   array('car_master_status'=>3);
				$soldcount             	=   commonmodel::doschemacounttablewhere($ses_dealer_schema_name,
                                                                        $dealerinventoryTable,
                                                                        $soldwhere);
				$wheresell              =   array('inventory_type'=>'PARKANDSELL');
				$countparksell          =   commonmodel::doschemacounttablewherenotwhere($ses_dealer_schema_name,
                                                                        $dealerinventoryTable,
                                                                        $wheresell);
				$whereown               =   array('inventory_type'=>'OWN');
				$countown               =   commonmodel::doschemacounttablewherenotwhere($ses_dealer_schema_name,
                                                                        $dealerinventoryTable,
                                                                        $whereown);	
                $whereready             =   array('car_master_status'=>1);
				$countready             =   commonmodel::doschemacounttablewhere($ses_dealer_schema_name,
                                                                        $dealerinventoryTable,
                                                                        $whereready);
                $wheredelete            =   array('car_master_status'=>4);
				$countdelete            =   commonmodel::doschemacounttablewhere($ses_dealer_schema_name,
                                                                        $dealerinventoryTable,
                                                                        $wheredelete);
                //get count all photos,documents,pricing 
                $countallphotos         =   commonmodel::doschemacounttable($ses_dealer_schema_name,
                                                                $DmsCarListPhotosTable);
                $countalldocuments      =   commonmodel::doschemacounttable($ses_dealer_schema_name,
                                                                $DmsCarListDocumentTable);
				$countallprciinglist    =   commonmodel::doschemacounttable($ses_dealer_schema_name,
                                                                $DealerCarPricingTable);
                
                //count photos list
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
                //photos graph
                $photosgraph 			=	array($countphotosnotsingle,count($counphotosallrecords),
											count($counphotoswithfive));
                //get documents count
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
                 //documents graph
                $documentsgraph 		=	array($countdocumentnotsingle,count($coundocumentsallrecords),
											count($coundocumentwithfive));
                //pricing graph
                $pricinggraph 			=	array($countown,$countparksell);
                //inevntory graph
                $inventorygraph 		=	array($countdraft,$countready,$countlivestock,
											$soldcount,$countdelete);
				//GET CAR DETAILS 
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
				$carviewrecords 		=	array();
				$totalcarlistid 		=	array();
				$collection 			= 	collect($countnoofviewcars);
				$sorted 				= 	$collection->sortByDesc('viewcarcount');
				$carviewrecordsnum 		=	(!empty($sorted) && count($sorted) >= 1)?$sorted->take(5):$totalcarlistid;
				$carviewrecords 		=	(!empty($sorted) && count($sorted) >= 1)?$sorted->take(5)->pluck('car_id'):$totalcarlistid;
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
								 $modelname 	=	((count($fetchmodel)>=1)?$fetchmodel[0]->model_name:'');
								 $wherevarient 	= 	array('variant_id'=>$caridvalue->variant);
								 $fetchvarient 	=   commonmodel::getAllRecordsWhere('master_variants',
																						$wherevarient
																						);
								 $varientname 	=	((count($fetchvarient)>=1)?$fetchvarient[0]->variant_name:'');
								 $yearname   	=  	$caridvalue->registration_year;
								 $data['nameofcar']	=	$modelname.'-'.$varientname.'-'.$yearname;	
								//get car id and check car id is matching
								if($carduplicateid->car_id == $caridvalue->duplicate_id)
								{
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
										 $data['individualcount']	=	$carduplicateid->viewcarcount;
									 }
									 if($initialize ==	2)
									 {
										 $data['individualcount']	=	$carduplicateid->viewcarcount;
									 }
									 if($initialize ==	3)
									 {
										 $data['individualcount']	=	$carduplicateid->viewcarcount;
									 }
									 if($initialize ==	4)
									 {
										 $data['individualcount']	=	$carduplicateid->viewcarcount;
									 }
									 if($initialize ==	5)
									 {
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
				 $countsoldprciesixmonthamount	=   commonmodel::doSchemaCountWheresixsalesprice($ses_dealer_schema_name,'dealer_sales');
				 $datethismonth	 	= 	Carbon::now('Asia/Kolkata')->format('m');
				 $datelastmonth	 	= 	Carbon::now('Asia/Kolkata')->subMonth()->format('m');
				 $datelasttwomonth	= 	Carbon::now('Asia/Kolkata')->subMonths(2)->format('m');
				 $datelastthreemonth= 	Carbon::now('Asia/Kolkata')->subMonths(3)->format('m');
				 $datelastfourmonth	= 	Carbon::now('Asia/Kolkata')->subMonths(4)->format('m');
				 $datelastfivemonth	= 	Carbon::now('Asia/Kolkata')->subMonths(5)->format('m');
				 		
				 $firstmonth	=	0;$secoundmonth	=	0;$thirdmonth	=	0;
				 $fourthmonth	=	0;$fithmonth	=	0;$sixmonth		=	0;
				 $firstsold		=	0;$secoundsold	=	0;$thirdsold	=	0;
				 $fourthsold	=	0;$fithsold		=	0;$sixsold		=	0;
				 if(!empty($countsoldprciesixmonthamount) && count($countsoldprciesixmonthamount) >= 1)
				 {
					 foreach($countsoldprciesixmonthamount as $getsalemonth)
					 {
						 //amount sold
						$firstsold		=	($datethismonth 	== 	$getsalemonth->mongodate)?$getsalemonth->soldamount:$firstsold;
						$secoundsold	=	($datelastmonth 	== 	$getsalemonth->mongodate)?$getsalemonth->soldamount:$secoundsold;
						$thirdsold		=	($datelasttwomonth 	== 	$getsalemonth->mongodate)?$getsalemonth->soldamount:$thirdsold;
						$fourthsold		=	($datelastthreemonth == $getsalemonth->mongodate)?$getsalemonth->soldamount:$fourthsold;
						$fithsold		=	($datelastfourmonth == 	$getsalemonth->mongodate)?$getsalemonth->soldamount:$fithsold;
						$sixsold		=	($datelastfivemonth == 	$getsalemonth->mongodate)?$getsalemonth->soldamount:$sixsold;
					 }
				 }
				 
				$drawgraphsoldamount 	=	array($sixsold,$fithsold,
											$fourthsold,$thirdsold,$secoundsold,$firstsold);
				$maxsoldamount 			=	max($drawgraphsoldamount);
				$minsoldamount 			=	min($drawgraphsoldamount);
				$soldoutamount 	=	0; 
				if(!empty($countsoldprciesixmonth))
				{
					$soldoutamount		=	($countsoldprciesixmonth[0]->soldamount != "")?$countsoldprciesixmonth[0]->soldamount:0;
				}
				$convertamount 			=	$this->moneyFormatIndia($soldoutamount);
				$inventorytype 			=	array(array('inventory_type'=>'All'),
											array('inventory_type'=>'Park and Sell'),
											array('inventory_type'=>'Own'),
											array('inventory_type'=>'Draft'),
											array('inventory_type'=>'Sold'),
											array('inventory_type'=>'Deleted'));
				$currendate 			= 	Carbon::now('Asia/Kolkata');
				$currentdate 			= 	commonmodel::getdatemonthformat($currendate);
				$dashboard 				=	array(
											'leadcount'=>$countleads,
                                            'custmoercount'=>$countcustomer,
                                            'inventorycount'=>$countinventory,
                                            'fundingcount'=>$countfunding,
                                            'livecount'=>$countlivestock,
                                            'draftcount'=>$countdraft,
                                            'countsold'=>$countsold,
                                            'quriescount'=>$countqueries,
                                            'soldamount'=>$convertamount,
                                            'currentdate'=>$currentdate,
                                            'totalsold'=>$countsoldsixmonth,
                                            'inventorycount'=>$countinventory,
											'parksellcount'=>$countparksell,
											'parksellpercentage'=>$roundofparksell,
											'owncount'=>$countown,
											'ownpercentage'=>$roundofown,
											'soldcount'=>$soldcount,
											'soldpercentage'=>$roundofsold,
											'photospercentage'=>$roundofphotos,
											'photosgraph'=>$photosgraph,
											'documentpercentage'=>$roundofdocuments,
											'documentsgraph'=>$documentsgraph,
											'pricinggraph'=>$pricinggraph,
											'inventorygraph'=>$inventorygraph,
											'maxsoldamount'=>$maxsoldamount,
											'minsoldamount'=>$minsoldamount,
											'viewcarscount'=>$countviewcars,
											'drawgraphsoldamount'=>$drawgraphsoldamount,
											'showlastsixmonth'=>$showlastsixmonth,
											'cardetails'=>$finalresult
                                            );
                                            
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
				if($plantypename 	==	"")
				{
					$plantypename 	=	"TRIAL";
				}					
				$currentplan	=	((count($myPlan)>=1)?$myPlan[0]->feature_allowed:'');	
				$startTime 		= 	(count($myPlan)>=1)?Carbon::parse($myPlan[0]->subscription_end_date):'';
				$finishTime 	= 	Carbon::now('Asia/Kolkata');
				if(!empty($startTime))
				{
					$totalDuration 	= 	$startTime->diffForHumans($finishTime);
				}
			}
			
			if(strpos($totalDuration,'after') !== false)
			{
				$totalDuration	=	"Yes";
			}
			if(strpos($totalDuration,'before') !== false)
			{
				$totalDuration	=	"No";
			}
			if($totalDuration  	==	0 || $totalDuration 	==	"")
			{
				$totalDuration	=	"No";
			}
			//get id proof
			$document_id_proof 	=	commonmodel::document_id_proof()->get();
			$plandetails 		=	array('PlanName'=>$plantypename,	
										'PlanTypeAllow'	=>$totalDuration);
			
				return response()->json(['Result'=>'1',
											'message'=>'success',
											'User_role_list'=>$user_role_list,
											'dealer_contact_type' =>$dealer_contact_type,
											'inventory_type'=>$inventorytype,
											'employee_types'=>$getnewemployeearray,
											'dashboard'=>[$dashboard],
											'dealer_city'=>$getallcitynames,
											'planDetails'=>[$plandetails],
											'document_proof'=>$document_id_proof
											]);	
			}
			return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
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
    
    public function doApidealerserach()
    {          
		$id 			= 	Input::get('session_user_id');
		$page_name 		= 	Input::get('page_name');
		$search_dealer 	= 	Input::get('search_dealer');
		if($id == "" || $page_name 	==	"" || $search_dealer ==	"")
        {
			return response()->json(['Result'=>'0',
									'message'=>'All fields are required!!'
									]);
		}
		if($page_name 	==	"searchdealers")
		{
			$schemaname 	=  	$this->getschemaname($id);
			if(!empty($schemaname))
			{			
				$dealerdata 			=	array();
				$dealer_search         	= 	dealermodel::doApidealersearch($id,$search_dealer);               
				if(!empty($dealer_search) && count($dealer_search) >= 1)
				{
					foreach($dealer_search as $dealer)
					{
						$data['dealer_name'] 	=	$dealer->dealer_name;
						$data['dealership_name']=	$dealer->dealership_name;
						$data['id'] 			=	$dealer->d_id;
						$data['logo'] 			=	($dealer->logo == ""?(url(Config::get('common.profilenoimage'))):$dealer->logo);
						$data['d_mobile'] 		=	$dealer->d_mobile;
						$data['d_email'] 		=	$dealer->d_email;
						$citywhere				=	array('city_id'=>$dealer->d_city);
						$getcity 	 			=	commonmodel::getAllRecordsWhere(
																				'master_city',
																				$citywhere);
						$data['city'] 			=	((count($getcity)>=1)?$getcity[0]->city_name:'');
						$car_listing_count  	= 	buyymodel::mongodealercardetails(
																	$dealer->d_id
																	);      
						$data['dealercarno']	= 	count($car_listing_count);
						array_push($dealerdata,$data);
					}
				}
				return response()->json(['Result'=>'2',
										'message'=>'success',
										'dealerdetails'=>$dealerdata
										]);
			}
		}
		return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
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
