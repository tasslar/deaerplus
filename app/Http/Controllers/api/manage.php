<?php

namespace App\Http\Controllers\api;

/*
  Module Name : Manage 
  Created By  : Vinoth  27-01-2016
  Use of this module is Branches
*/
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\model\branchesmodel;
use App\model\commonmodel;
use App\model\leadpreferencesmodel;
use App\model\parameter_option_scoring;
use App\model\apimodel;
use App\model\buyymodel;
use App\model\schemamodel;
use App\model\creditmodel;
use App\model\dealermodel;
use App\model\usersmodel;
use App\model\subscriptionmodel;
use App\model\inventorymodel;
use App\model\emailmodel;
use App\model\notificationsmodel;
use App\model\dms_master_dealer_data;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\model\mongomodel;
use App\User;
use Config;
use Redirect;
use Session;
use File;
use Image;

class manage extends Controller
{	
	public $masterMainLoginTable;
	public $dmsbranchtable;
	public $userAccountTable;
	public $contactManageTable;
	public $contactdocumentTable;
	public $DmsCarListTable;
	public $DmsCarListPhotosTable;
	public $DealeremployeeTable;
	public $DealeremployeedocTable;
	public function __construct()
    {    
    	$this->masterMainLoginTable 	= 	"dms_dealers";
    	$this->dmsbranchtable 			= 	"dms_dealer_branches";
		$this->userAccountTable			=	"user_account";
		$this->contactManageTable		=	"dealer_contact_management";
		$this->contactdocumentTable		=	"dealer_contact_document_management";
		$this->DmsCarListTable          = 	"dms_car_listings";
		$this->DmsCarListPhotosTable    = 	"dms_car_listings_photos";
		$this->DealeremployeeTable    	= 	"dealer_employee_management";
		$this->DealeremployeedocTable   = 	"dealer_employee_document_management";
    }
    
	/*The Function used for Add Branch */

	public function doApiaddbranch()
	{					
		
		$id 					= 	Input::get('session_user_id');
		$dealer_name 			= 	Input::get('dealer_name');
		$mobilenumber 			= 	Input::get('mobilenumber');
        $branch_address 		= 	Input::get('branch_address');
        $dealer_city 			= 	Input::get('dealer_city');
        $dealer_pincode 		= 	Input::get('dealer_pincode');
        $dealer_mail           	= 	Input::get('dealer_mail');
        $head_quater           	= 	Input::get('head_quater');
        $dealer_service         = 	Input::get('dealer_service');
        if($id == "" || $dealer_name == "" || $mobilenumber== "" || 
        $branch_address == "" || $dealer_mail == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'All Fields are required!!'
									]);
		}
		
		if(Input::get('page_name')=='addbranch')
		{
			//get city id and state id
			$wherecity 			=	array('city_name'=>$dealer_city,'status'=>'Active');
			$getcity       		=  	commonmodel::getAllRecordsWhere('master_city',$wherecity);
			$dealer_city_id 	=	((count($getcity)>=1)?$getcity[0]->city_id:'526');
			$dealer_state_id 	=	((count($getcity)>=1)?$getcity[0]->state_id:'31');
			$schemaname 	=  	$this->getschemaname($id);
			if(!empty($schemaname))
			{	
				//check branch name is exist
				$wherebranch 	=	array('dealer_name'=>$dealer_name);
				$branchresult 	=	branchesmodel::branchlist(
															$schemaname,
															$this->dmsbranchtable,
															$wherebranch);
				if(!empty($branchresult) && count($branchresult) >= 1)
				{
					return response()->json(['Result'=>'0',
										'message'=>'This Branch Name is already registered with us!!'
										]);
				}
				
				//check email id is exist
				$whereemail 	=	array('dealer_mail'=>$dealer_mail);
				$emailresult 	=	branchesmodel::branchlist(
															$schemaname,
															$this->dmsbranchtable,
															$whereemail);
				if(!empty($emailresult) && count($emailresult) >= 1)
				{
					return response()->json(['Result'=>'0',
										'message'=>'This Email id is already registered with us!!'
										]);
				}
				
				//check mobile number id is exist
				$wheremobile 	=	array('dealer_contact_no'=>$mobilenumber);
				$mobileresult 	=	branchesmodel::branchlist(
															$schemaname,
															$this->dmsbranchtable,
															$wheremobile);
				if(!empty($mobileresult) && count($mobileresult) >= 1)
				{
					return response()->json(['Result'=>'0',
										'message'=>'This Mobile number is already registered with us!!'
										]);
				}
				
				if($head_quater == 1)
				{
					$where 			=	array('headquarter'=>$head_quater);
					$getresult 		=	branchesmodel::branchlist($schemaname,
																	$this->dmsbranchtable,
																	$where
																		);
					if(!empty($getresult) && count($getresult) >= 1)
					{
						return response()->json(['Result'=>'0',
											'message'=>'Head Quater is already assigned'
											]);
					}
				}
				$insertrecord		=	array('dealer_id'	=>	$id,
										 'dealer_name'		=>	$dealer_name,
										 'dealer_contact_no'=>	$mobilenumber,
										 'branch_address'	=>	$branch_address,
										 'dealer_state'		=>	$dealer_state_id,
										 'dealer_city'		=>	$dealer_city_id,
										 'dealer_pincode'	=>	$dealer_pincode,									 
										 'dealer_mail'		=>	$dealer_mail,
										 'dealer_service'	=>	$dealer_service,
										 'headquarter'		=>	$head_quater
										  );
				$insertresult 		=	branchesmodel::InsertTable(
																$schemaname,
																$this->dmsbranchtable,
																$insertrecord
																);
				if($insertresult >= 1)
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
		}
		return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
		
	}
	
	/*The Function used for Edit Branch */

	public function doApieditbranch()
	{					
		$id 					= 	Input::get('session_user_id');
		$branchid 				= 	Input::get('branchid');
		$dealer_name 			= 	Input::get('dealer_name');
		$mobilenumber 			= 	Input::get('mobilenumber');
        $branch_address 		= 	Input::get('branch_address');
        $dealer_city 			= 	Input::get('dealer_city');
        $dealer_pincode 		= 	Input::get('dealer_pincode');
        $dealer_mail           	= 	Input::get('dealer_mail');
        $dealer_service         = 	Input::get('dealer_service');
        $head_quater           	= 	Input::get('head_quater');
        $dealerstate 			=	"";
        if($id == "" || $branchid == "" || $dealer_name == "" || $mobilenumber== "" || $branch_address == "" || $dealer_mail == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'All Fields are required!!'
									]);
		}
		if(Input::get('page_name')=='editbranch')
		{
			//get city id and state id
			$wherecity 			=	array('city_name'=>$dealer_city,'status'=>'Active');
			$getcity       		=  	commonmodel::getAllRecordsWhere('master_city',$wherecity);
			$dealer_city_id 	=	((count($getcity)>=1)?$getcity[0]->city_id:'526');
			$dealer_state_id 	=	((count($getcity)>=1)?$getcity[0]->state_id:'31');
			$schemaname 		=  	$this->getschemaname($id);
			if(!empty($schemaname))
			{	
				//check branch name is exist
				$wherebranch 	=	array('dealer_name'=>$dealer_name);
				$branchresult 	=	commonmodel::doWherenotExists(
															$schemaname,
															$this->dmsbranchtable,
															$wherebranch,
															'branch_id',
															$branchid);
				$branchexist 	=	((count($branchresult)>=1)?$branchresult[0]->dealer_name:'');
				
				if($branchexist	==	$dealer_name)
				{
					return response()->json(['Result'=>'0',
										'message'=>'This Branch Name is already registered with us!!'
										]);
				}
				//check email id is exist
				$whereemail 	=	array('dealer_mail'=>$dealer_mail);
				$emailresult 	=	commonmodel::doWherenotExists(
															$schemaname,
															$this->dmsbranchtable,
															$whereemail,
															'branch_id',
															$branchid);
				$emailidexist 	=	((count($emailresult)>=1)?$emailresult[0]->dealer_mail:'');
				
				if($emailidexist	==	$dealer_mail)
				{
					return response()->json(['Result'=>'0',
										'message'=>'This Email id is already registered with us!!'
										]);
				}
				//check mobile number id is exist
				$wheremobile 	=	array('dealer_contact_no'=>$mobilenumber);
				$mobileresult 	=	commonmodel::doWherenotExists(
															$schemaname,
															$this->dmsbranchtable,
															$wheremobile,
															'branch_id',
															$branchid);
				$mobilenumexist 	=	((count($mobileresult)>=1)?$mobileresult[0]->dealer_contact_no:'');
				
				if($mobilenumexist	==	$mobilenumber)
				{
					return response()->json(['Result'=>'0',
										'message'=>'This Mobile number is already registered with us!!'
										]);
				}	
				$wherecondition 	=	array('branch_id'=>$branchid);
				$updaterecord		=	array('dealer_id'	=>	$id,
										 'dealer_name'		=>	$dealer_name,
										 'dealer_contact_no'=>	$mobilenumber,
										 'branch_address'	=>	$branch_address,
										 'dealer_state'		=>	$dealer_state_id,
										 'dealer_city'		=>	$dealer_city_id,
										 'dealer_pincode'	=>	$dealer_pincode,									 
										 'dealer_mail'		=>	$dealer_mail,
										 'dealer_service'	=>	$dealer_service,
										 'headquarter'		=>	$head_quater
										  );
				$updateresult 		=	branchesmodel::UpdateTable(
																$schemaname,
																$this->dmsbranchtable,
																$updaterecord,
																$wherecondition
																);
				if($updateresult >= 1)
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
		}	
			return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);	
		}
	
    /*The Function used for view allbranch*/
	public function doApibranchlist()
	{	
		$id						=	Input::get('session_user_id');
		if($id == "")
		{
			return response()->json(['Result'=>'0',
								'message'=>'Userid are required'
									]);
		}
		if(Input::get('page_name')	==	'viewbranchlist')
		{
			$schemaname 	=  $this->getschemaname($id);
			if(!empty($schemaname))
			{
				//$where 			=	array('dealer_status'=>'Active');
				$getresult 		=	branchesmodel::select_all_branch(
															$schemaname,
															$this->dmsbranchtable
																);
				$queriesdata 	= 	array();
				$data 			= 	array();
				//get headquarter is set or not
				$where 			=	array('headquarter'=>1);
				$gethead 		=	branchesmodel::branchlist($schemaname,
																	$this->dmsbranchtable,
																	$where
																		);
				$head_id 		=	((count($gethead)>=1)?$gethead[0]->headquarter:'');
				if(!empty($getresult) && count($getresult) >= 1)
				{
					foreach($getresult as $uservalue)
					{	
						$wherecity 			=	array('city_id'=>$uservalue->dealer_city,'status'=>'Active');
						$getcity       		=  	commonmodel::getAllRecordsWhere('master_city',$wherecity);
						$data['branch_id']        	= 	($uservalue->branch_id == null?'':$uservalue->branch_id);			
						$data['dealer_name']       	= 	($uservalue->dealer_name == null?'':$uservalue->dealer_name);			
						$data['dealer_contact_no']  = 	($uservalue->dealer_contact_no == null?'':$uservalue->dealer_contact_no);			
						$data['branch_address']  	= 	($uservalue->branch_address == null?'':$uservalue->branch_address);			
						$data['dealer_mail']  		= 	($uservalue->dealer_mail == null?'':$uservalue->dealer_mail);			
						$data['dealer_state']  		= 	($uservalue->dealer_state == null?'':$uservalue->dealer_state);			
						$data['dealer_city'] 		=	((count($getcity)>=1)?$getcity[0]->city_name:'');
						$data['dealer_pincode']  	= 	($uservalue->dealer_pincode == null?'':$uservalue->dealer_pincode);
						$data['dealer_status']  	= 	($uservalue->dealer_status == null?'':$uservalue->dealer_status);
						$data['dealer_service']  	= 	($uservalue->dealer_service == null?'':$uservalue->dealer_service);
						$data['head_quater']      	= 	$uservalue->headquarter;				
						array_push($queriesdata, $data); 
					}
				}
				return response()->json(['Result'=>'2',
									'message'=>'success',
									'headquarter'=>$head_id,
									'branch_list'=>$queriesdata
									]);	
			}	
			return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);	
		}
		else
		{
			return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
		}	

	}
	
	 /*The Function used for delete branch*/
	public function doApideletebranch()
	{	
		$id						=	Input::get('session_user_id');
		$recordid				=	Input::get('branchid');
		if($id == "" || $recordid == "")
		{
			return response()->json(['Result'=>'0',
								'message'=>'Userid are required'
									]);
		}
		if(Input::get('page_name')	==	'deletebranch')
		{
			$schemaname 	=  $this->getschemaname($id);
			if(!empty($schemaname))
			{
				$where 			=	array('branch_id'=>$recordid);
				//$update			=	array('dealer_status'=>'Inactive');
				$getresult 		=	branchesmodel::DeleteTable(
															$schemaname,
															$this->dmsbranchtable,
															$where
																);
				if($getresult)
				{
					return response()->json(['Result'=>'3',
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
		else
		{
			return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
		}	
	}
	
	/*THIS FUNCTION USED FOR ADD NEW USER */

	public function doApiaddnewuser()
	{					
		
		$id 					= 	Input::get('session_user_id');
		$dealername 			= 	Input::get('dealer_name');
		$mobilenumber 			= 	Input::get('mobilenumber');
        $dealer_mail           	= 	Input::get('dealer_mail');
        $user_role           	= 	Input::get('user_role');
        $dealer_state 			=	"";
        if($id == "" || $dealername == "" || $mobilenumber== "" || $dealer_mail == "" || $user_role == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'All Fields are required!!'
									]);
		}
		if(Input::get('page_name')=='addnewuser')
		{
			$whereemail 			=	array('d_email'=>$dealer_mail);
			$checkusernameandemail 	= 	apimodel::checkUserEmailidExist($whereemail);	
			if(!empty($checkusernameandemail->Emailid))
			{
				return response()->json(['Result'=>'0',
									'message'=>'The Entered Email-id is already exist!!'
									]);
			}
			else
			{
				$schemaname 			=  	$this->getschemaname($id);
				if(!empty($schemaname))
				{
					//CHECK USER PLAN MAX USERS
					$checkmaxuser  			= 	subscriptionmodel::select_user_list($id,1); 
					$getmaxuser 			=	(count($checkmaxuser)>=1 ?$checkmaxuser->max_users:'1');
					$whereuserlist 			=	array('status'=>'Active');
					$getalluserresult 		=	branchesmodel::branchlist(
																	$schemaname,
																	$this->userAccountTable,
																	$whereuserlist);
					$getalluserresult 		=	count($getalluserresult);
					if($getmaxuser 	==	1)
					{
						return response()->json(['Result'=>'0',
											'message'=>'Failed ! For You Plan User Limit is Exceeded..'
											]);
					}
					if($getalluserresult == $getmaxuser)
					{
						return response()->json(['Result'=>'0',
											'message'=>'Failed ! For You Plan User Limit is Exceeded..'
											]);
					}
				//check mobile name is exist
				$wheremobile 	=	array('user_moblie_no'=>$mobilenumber);
				$mobileresult 	=	branchesmodel::branchlist(
															$schemaname,
															$this->userAccountTable,
															$wheremobile);
				if(!empty($mobileresult) && count($mobileresult) >= 1)
				{
					return response()->json(['Result'=>'0',
										'message'=>'This Mobile Number is already registered with us!!'
										]);
				}
				//check email id is exist
				$whereemail 	=	array('user_email'=>$dealer_mail);
				$emailresult 	=	branchesmodel::branchlist(
															$schemaname,
															$this->userAccountTable,
															$whereemail);
				if(!empty($emailresult) && count($emailresult) >= 1)
				{
					return response()->json(['Result'=>'0',
										'message'=>'This Email id is already registered with us!!'
										]);
				}
				
				$dealer         		=   dealermodel::dealerfetch($id);
				if(count($dealer) >= 1)
				{
					$dms_logo           =  	Config::get('common.profilenoimage');
					$userid            	=   $dealer[0]->d_id;
					$dealer_name    	=   $dealer[0]->dealer_name;
					$phone          	=   $dealer[0]->d_mobile;
					$email          	=   $dealer[0]->d_email;
					$dealership_name 	=  	$dealer[0]->dealership_name;
					$dealer_code 		=  	$dealer[0]->dealer_code;
					$dealer_schema_name =  	$dealer[0]->dealer_schema_name;
					$dealerdata 		= 	array(
											'parent_id'		=>	$id,
											'dealer_name'	=>	$dealername,							
											'd_mobile'		=>	$mobilenumber,
											'd_email'		=>	$dealer_mail,
											'dealer_code' 	=>	$dealer_code,
											'dealer_schema_name'=>$dealer_schema_name,
											'logo'        	=> $dms_logo,
												);			
					$master_dealer		= 	dealermodel::dealer_register($dealerdata);
					
					//check weather data is inert or not
				if($master_dealer >= 1)
				{
					//user account data insert
					$user_data 			= 	array(
												'dealer_table_id'	=>	$master_dealer,
												'dealer_id'			=>	$id, 
												'branch_id'			=>	'', 
												'user_name'			=>	$dealername,
												'user_moblie_no'	=>	$mobilenumber,
												'user_email'		=>	$dealer_mail, 
												'user_role'			=>	$user_role,
												'creates_date'		=>	Carbon::now()
											);
                    												
					$adduser 			= 	branchesmodel::InsertTable($schemaname,
																$this->userAccountTable,
																$user_data);
																
							
					//Welcome Mail sending process               
					$welcome_email_template_id =   config::get('common.welcome_email_template_id');
					$email_template_data       =   emailmodel::get_email_templates($welcome_email_template_id);
					foreach ($email_template_data as $row) 
						{
							$mail_subject  =  $row->email_subject;
							$mail_message  =  $row->email_message;
							$mail_params   =  $row->email_parameters; 
						}
					$url                   =    url("mailsend/".encrypt($userid));
					
					$data                  =    array(
														'0'=>	$url,
														'1'=>	$dealername,
														'2'=>	$dealer_mail,
														'3'=> 	"",
														'4'=>	"",
														'5'=>	$schemaname,
														'6'=>	$userid,
													);

					$email_template    =     emailmodel::emailContentConstruct($mail_subject,$mail_message,$mail_params,$data);
					$email_sent        =     emailmodel::email_sending($dealer_mail,$email_template);										
				
					return response()->json(['Result'=>'1',
											'message'=>'Successfully Registered. Password Activation Link Has Been Sent to Your Email-id.'
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
			}	
		return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
	}
	
	
	/*The Function used for Update User */

	public function doApiupdateuser()
	{					
		$id 					= 	Input::get('session_user_id');
		$user_id 				= 	Input::get('user_id');
		$user_name 				= 	Input::get('user_name');
		$user_moblie_no 		= 	Input::get('user_moblie_no');
		
        if($id == "" || $user_id == "" || $user_name == "" || $user_moblie_no== "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'All Fields are required!!'
									]);
		}
		if(Input::get('page_name')=='updateuser')
		{
			$schemaname 		=  	$this->getschemaname($id);
			if(!empty($schemaname))
			{
				//check mobile name is exist
				$wheremobile 	=	array('user_moblie_no'=>$user_moblie_no);
				$mobileresult 	=	commonmodel::doWherenotExists(
															$schemaname,
															$this->userAccountTable,
															$wheremobile,
															'user_id',
															$user_id);
				$mobilenumexist =	((count($mobileresult)>=1)?$mobileresult[0]->user_moblie_no:'');
				
				if($mobilenumexist	==	$user_moblie_no)
				{
					return response()->json(['Result'=>'0',
										'message'=>'This Mobile Number is already registered with us!!'
										]);
				}
											
				$wherecondition 	=	array('user_id'=>$user_id);								
				$updaterecord		=	array('user_name'	=>	$user_name,
										 'user_moblie_no'	=>	$user_moblie_no
										  );
				$updateresult 		=	branchesmodel::UpdateTable(
																$schemaname,
																$this->userAccountTable,
																$updaterecord,
																$wherecondition
																);
				if($updateresult >= 1)
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
		}
		return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);	
	}
	
	/*The Function used for view all user*/
	public function doApiviewuserdetails()
	{	
		$id						=	Input::get('session_user_id');
		$role_id				=	Input::get('role_id');
		if($id == "" || $role_id == "")
		{
			return response()->json(['Result'=>'0',
								'message'=>'Userid are required'
									]);
		}
		
		if(Input::get('page_name')	==	'viewuserlist')
		{
			$schemaname 	=  $this->getschemaname($id);
			if(!empty($schemaname))
			{
				if($role_id == 0)
				{
					//$where 			=	array('status'=>'Active');
					$getresult 		=	branchesmodel::select_all_branch(
															$schemaname,
															$this->userAccountTable
																);
					$getresult 		=	$getresult->sortBy('user_name');
				}
				else
				{
					$where 			=	array('user_role'=>$role_id);
					//$where 			=	array('user_role'=>$role_id,'status'=>'Active');
					$getresult 		=	branchesmodel::branchlist(
															$schemaname,
															$this->userAccountTable,
															$where
																);
																
					$getresult 			=	$getresult->sortBy('user_name');
				}
				//CHECK USER PLAN MAX USERS
				$checkmaxuser  			= 	subscriptionmodel::select_user_list($id,1); 
				$getmaxuser 			=	(count($checkmaxuser)>=1 ?$checkmaxuser->max_users:'1');
				$whereuserlist 			=	array('status'=>'Active');
				$getalluserresult 		=	branchesmodel::branchlist(
																$schemaname,
																$this->userAccountTable,
																$whereuserlist);
				$getalluserresult 		=	count($getalluserresult);
				
				if($getmaxuser 	==	1)
				{
					$usercount 			=	($getmaxuser  == 1?0:1);
				}
				if($getalluserresult == $getmaxuser)
				{
					$usercount 			=	($getalluserresult == $getmaxuser?0:1);
				}
				else
				{
					$usercount 			=	1;
				}
				
				$queriesdata 	= 	array();
				$data 			= 	array();
				if(!empty($getresult) && count($getresult) >= 1)
				{
					foreach($getresult as $uservalue)
					{	
						$data['branch_id']        	= 	($uservalue->branch_id == null ?'':$uservalue->branch_id);
						$data['user_email']        	= 	($uservalue->user_email == null ?'':$uservalue->user_email);
						$data['user_role']       	= 	($uservalue->user_role == null ?'':$uservalue->user_role);
						$data['user_id']       		= 	($uservalue->user_id == null ?'':$uservalue->user_id);
						$data['user_name']       	= 	($uservalue->user_name == null ?'':$uservalue->user_name);
						$whereactive				=	array('master_role_id'=>$uservalue->user_role);
						$getrolename				=	commonmodel::getAllRecordsWhere('master_user_role',$whereactive);
						$data['role_name'] 			=	((count($getrolename)>=1)?$getrolename[0]->master_role_name:'');				
						$data['user_moblie_no']     = 	($uservalue->user_moblie_no == null ?'':$uservalue->user_moblie_no);
						$data['status']     		= 	($uservalue->status == null ?'':$uservalue->status);				
						array_push($queriesdata, $data); 
					}
				}
				return response()->json(['Result'=>'1',
									'message'=>'success',
									'user_count'=>$usercount,
									'totaluser'=>$getalluserresult,
									'user_list'=>$queriesdata
									]);	
			}
		}
			return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);		
	}
	
	/*The Function used for view all user*/
	public function doApisearchuserdetails()
	{	
		$id						=	Input::get('session_user_id');
		$role_id				=	Input::get('role_id');
		$searcheuser			=	Input::get('searcheuser');
		if($id == "" || $role_id == "" || $searcheuser == "")
		{
			return response()->json(['Result'=>'0',
								'message'=>'Userid are required'
									]);
		}
		
		$schemaname 	=  $this->getschemaname($id);
		if(!empty($schemaname))
		{
			if($role_id == 0)
			{
				//$where 			=	array('status'=>'Active');
				$getresult 		=	branchesmodel::selectallusers(
														$schemaname,
														$searcheuser
															);
			}
			else
			{
				$where 			=	array('user_role'=>$role_id);
				//$where 			=	array('user_role'=>$role_id,'status'=>'Active');
				$getresult 		=	branchesmodel::selectalluserscolumn(
														$schemaname,
														$where,
														$searcheuser
															);
			}
			
			$queriesdata 	= 	array();
			$data 			= 	array();
			if(!empty($getresult) && count($getresult) >= 1)
			{
				foreach($getresult as $uservalue)
				{	
					$data['branch_id']        	= 	($uservalue->branch_id == null ?'':$uservalue->branch_id);
					$data['user_email']        	= 	($uservalue->user_email == null ?'':$uservalue->user_email);
					$data['user_role']       	= 	($uservalue->user_role == null ?'':$uservalue->user_role);
					$data['user_id']       		= 	($uservalue->user_id == null ?'':$uservalue->user_id);
					$data['user_name']       	= 	($uservalue->user_name == null ?'':$uservalue->user_name);
					$whereactive				=	array('master_role_id'=>$uservalue->user_role);
					$getrolename				=	commonmodel::getAllRecordsWhere('master_user_role',$whereactive);
					$data['role_name'] 			=	((count($getrolename)>=1)?$getrolename[0]->master_role_name:'');				
					$data['user_moblie_no']     = 	($uservalue->user_moblie_no == null ?'':$uservalue->user_moblie_no);
					$data['status']     		= 	($uservalue->status == null ?'':$uservalue->status);				
					array_push($queriesdata, $data); 
				}
			}
			return response()->json(['Result'=>'1',
								'message'=>'success',
								'user_list'=>$queriesdata
								]);	
		}
			return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);		
	}
	 /*The Function used for delete user*/
	public function doApiInvokestatususer()
	{	
		$id						=	Input::get('session_user_id');
		$user_id				=	Input::get('user_id');
		if($id == "" || $user_id == "")
		{
			return response()->json(['Result'=>'0',
								'message'=>'Id is required'
									]);
		}
		if(Input::get('page_name')	==	'invokestatususer')
		{
			$schemaname 			=  $this->getschemaname($id);
			if(!empty($schemaname))
			{
				$whereuser 			=	array('user_id'=>$user_id);
				//$whereuser 			=	array('user_id'=>$user_id,'status'=>'Active');
				$getresult 			=	branchesmodel::branchlist(
															$schemaname,
															$this->userAccountTable,
															$whereuser
																);
				$useremail 			=	((count($getresult)>=1)?$getresult[0]->user_email:'');
				if(!empty($useremail))
				{
					$getstatus 		=	((count($getresult)>=1)?$getresult[0]->status:'');
					if($getstatus 	==	"Active")
					{
						$whereupuser	=	array('d_email'=>$useremail);
						$updateuser		=	array('status'=>'Inactive');
						$update 		=	apimodel::updateEmailStatus($whereupuser,$updateuser);
						
						$where 			=	array('user_id'=>$user_id);
						$updaterecord	=	array('status'	=>	'Inactive');
						$updateresult 	=	branchesmodel::UpdateTable(
																$schemaname,
																$this->userAccountTable,
																$updaterecord,
																$where
																);
					}else
					{
						//CHECK USER PLAN MAX USERS
						$checkmaxuser  			= 	subscriptionmodel::select_user_list($id,1); 
						$getmaxuser 			=	(count($checkmaxuser)>=1 ?$checkmaxuser->max_users:'1');
						$whereuserlist 			=	array('status'=>'Active');
						$getalluserresult 		=	branchesmodel::branchlist(
																		$schemaname,
																		$this->userAccountTable,
																		$whereuserlist);
						$getalluserresult 		=	count($getalluserresult);
						if($getmaxuser 	==	1)
						{
							return response()->json(['Result'=>'0',
												'message'=>'Failed ! For You Plan User Limit is Exceeded..'
												]);
						}
						if($getalluserresult == $getmaxuser)
						{
							return response()->json(['Result'=>'0',
												'message'=>'Failed ! For You Plan User Limit is Exceeded..'
												]);
						}
					
						$whereupuser	=	array('d_email'=>$useremail);
						$updateuser		=	array('status'=>'Active');
						$update 		=	apimodel::updateEmailStatus($whereupuser,$updateuser);
						
						$where 			=	array('user_id'=>$user_id);
						$updaterecord	=	array('status'	=>	'Active');
						$updateresult 	=	branchesmodel::UpdateTable(
																$schemaname,
																$this->userAccountTable,
																$updaterecord,
																$where
																);
					}
					$whereuserlist 			=	array('status'=>'Active');
					$getalluserresult 		=	branchesmodel::branchlist(
																		$schemaname,
																		$this->userAccountTable,
																		$whereuserlist);
					$getalluserresult 		=	count($getalluserresult);
					return response()->json(['Result'=>'3',
									'message'=>'success',
									'totaluser'=>$getalluserresult
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
										'message'=>'Invalid Access'
										]);
		}	
	}
	
	/*The Function used for delete user*/
	public function doApideleteuser()
	{	
		$id						=	Input::get('session_user_id');
		$user_id				=	Input::get('user_id');
		if($id == "" || $user_id == "")
		{
			return response()->json(['Result'=>'0',
								'message'=>'Id is required'
									]);
		}
		if(Input::get('page_name')	==	'deleteuser')
		{
			$schemaname 			=  $this->getschemaname($id);
			if(!empty($schemaname))
			{
				$whereuser 			=	array('user_id'=>$user_id);
				$getresult 			=	branchesmodel::branchlist(
															$schemaname,
															$this->userAccountTable,
															$whereuser
																);
				$useremail 			=	((count($getresult)>=1)?$getresult[0]->user_email:'');
				if(!empty($useremail))
				{
					$whereupuser	=	array('d_email'=>$useremail);
					$deleteuser 	=	apimodel::deleteuserbydealer($whereupuser);
				}
				$where 				=	array('user_id'=>$user_id);
				$deleteresult 		=	branchesmodel::DeleteTable(
															$schemaname,
															$this->userAccountTable,
															$where
															);
				
				if(!empty($deleteresult) && count($deleteresult) >= 1)
				{
					return response()->json(['Result'=>'4',
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
		else
		{
			return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
		}	
	}
	
	/*The Function used for Add NEW CONTACT */

	public function doApiaddcontact()
	{					
		$id 					= 	Input::get('session_user_id');
		$contact_type 			= 	Input::get('contact_type');
		$contactowner 			= 	Input::get('contactowner');
		$contactname 			= 	Input::get('contactname');
        $contactnumber 			= 	Input::get('contactnumber');
        $contactpannumber 		= 	Input::get('contactpannumber');
        $contactmailid			= 	Input::get('contactmailid');
        $contactaddress 		= 	Input::get('contactaddress');
        $contact_image 			= 	Input::get('contact_image');
        $contact_gender 		= 	Input::get('contact_gender');
		$contact_sms    		= 	Input::get('contact_sms');
        $contact_email 			= 	Input::get('contact_email');
        $cantactnoimage 		= 	Config::get('common.no_contact_image');
        $setuserimage 			= 	'data:image/png;base64,';
        $contactimage			=	"";  
        $contactnewimage		=	"";        
        $userimage 				=	'';
        if($id == "" || $contact_type == "" || $contactowner == "" || $contact_gender == "" || $contactname== "" ||
         $contactnumber== "" || $contactpannumber	==	""	||  $contactmailid == "" || $contactaddress == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'All Fields are required!!'
									]);
		}
		if(Input::get('page_name')=='addcontact')
		{
			$schemaname 		=  	$this->getschemaname($id);
			if(!empty($schemaname))
			{	
				//check mobile name is exist
				$wheremobile 	=	array('contact_phone_1'=>$contactnumber);
				$mobileresult 	=	branchesmodel::branchlist(
															$schemaname,
															$this->contactManageTable,
															$wheremobile);
				if(!empty($mobileresult) && count($mobileresult) >= 1)
				{
					return response()->json(['Result'=>'0',
										'message'=>'This Mobile Number is already registered with us!!'
										]);
				}
				//check email id is exist
				$whereemail 	=	array('contact_email_1'=>$contactmailid);
				$emailresult 	=	branchesmodel::branchlist(
															$schemaname,
															$this->contactManageTable,
															$whereemail);
				if(!empty($emailresult) && count($emailresult) >= 1)
				{
					return response()->json(['Result'=>'0',
										'message'=>'This Email id is already registered with us!!'
										]);
				}
								
				if(!empty($contact_image))
				{
					$userimage			=	$setuserimage.$contact_image;
					$base64_img_array 	= 	explode(':', $userimage);
					$img_info 			= 	explode(',', end($base64_img_array));
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
					$contactimage   = 	rand(23232,99999).'.'.$img_file_extension;
					if(file_exists(public_path('/uploadimages/'.$schemaname.'/contacts/')))
					{
						
					}
					else
					{
						File::makeDirectory(public_path('/uploadimages/'.$schemaname.'/contacts/'), 0777, true, true);
					}
					//check file is exist or not otherwise create file
					if(file_exists(public_path('/uploadimages/'.$schemaname.'/contacts/'.$id.'/')))
					{
						$img_file_name 		= 	public_path().'/uploadimages/'.$schemaname.'/contacts/'.$id.'/'.$contactimage;
						$img_file 			= 	file_put_contents($img_file_name, base64_decode($img_info[1]));
						$contactnewimage 	=	url('uploadimages/'.$schemaname.'/contacts/'.$id.'/'.$contactimage);
					}
					else
					{
						File::makeDirectory(public_path('/uploadimages/'.$schemaname.'/contacts/'.$id.'/'), 0777, true, true);
						$img_file_name 		= 	public_path().'/uploadimages/'.$schemaname.'/contacts/'.$id.'/'.$contactimage;
						$img_file 			= 	file_put_contents($img_file_name, base64_decode($img_info[1]));
						$contactnewimage 	=	url('uploadimages/'.$schemaname.'/contacts/'.$id.'/'.$contactimage);
					}
				}
				else
				{
					$contactnewimage  	=	url($cantactnoimage);
				}
				
			$insertrecord		=	array('dealer_id'			=>	$id,
									 'contact_type_id'			=>	$contact_type,
									 'contact_owner'			=>	$contactowner,
									 'contact_first_name'		=>	$contactname,
									 'contact_phone_1'			=>	$contactnumber,
									 'contact_mailing_address'	=>	$contactaddress,
									 'contact_email_1'			=>	$contactmailid,									 
									 'user_image'				=>	$contactnewimage,
									 'contact_gender'			=>	$contact_gender,
									 'contact_email_opt_out'	=>	$contact_email,
									 'contact_sms_opt_out'		=>	$contact_sms,
									 'pan_number'				=>	$contactpannumber
									  );
			$insertresult 		=	branchesmodel::InsertTable(
															$schemaname,
															$this->contactManageTable,
															$insertrecord
															);
			if($insertresult >= 1)
			{
				$contactrecord	=	array('contact_management_id'  =>	$insertresult);
				$insertcontact 	=	branchesmodel::InsertTable(
															$schemaname,
															$this->contactdocumentTable,
															$contactrecord
															);
					return response()->json(['Result'=>'1',
											'message'=>'success',
											'Contactid'=>$insertresult
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
	public function doApiLeaddetails()
    { 
		$contact_id = 	Input::get('contact_id');
		$id 		= 	Input::get('session_user_id');
		$buycity 	= 	Input::get('buycity');
		$buymake 	= 	Input::get('buymake');
		$buymodel 	= 	Input::get('buymodel');
		$pricefliter= 	Input::get('pricefliter');
		$timeline 	= 	Input::get('timeline');
		if($id == "" || $contact_id == "" || $buycity == "" || $buymake	==	"" || 
		$buymodel ==	"" || $pricefliter == "" || $timeline == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'All Fields are required!!'
									]);
		}
		$schemaname 		=  	$this->getschemaname($id);
		if(!empty($schemaname))
		{
			leadpreferencesmodel::lead_preferences_delete($schemaname,array('lead_id'=>$contact_id));
			$insertregion['lead_option_id']	=	1;
			$insertmake['lead_option_id']	=	2;
			$insertmodel['lead_option_id']	=	3;
			$insertpricefilter['lead_option_id']=	4;
			$inserttimeline['lead_option_id']	=	5;
			$insertregion['lead_id']			=	$contact_id;
			$insertmake['lead_id']				=	$contact_id;
			$insertmodel['lead_id']				=	$contact_id;
			$insertpricefilter['lead_id']		=	$contact_id;
			$inserttimeline['lead_id']			=	$contact_id;
			$insertregionvalue 		= 	array();
			$insertmakevalue 		= 	array();
			$insertmodelvalue 		= 	array();
			$insertpricefiltervalue = 	array();
			$inserttimelinevalue 	= 	array();
		  
			if(!empty($buycity))
			{
				$buycity 		=	explode(',',$buycity);
				foreach ($buycity as $key){
					$insertregionvalue[] = 'r'.$key.'r';          
				}				
				$insertregion['lead_option_value'] = implode(',', $insertregionvalue);
				leadpreferencesmodel::lead_preferences_insert($schemaname,$insertregion);
			}
			if(!empty($buymake))
			{
				$buymake 		=	explode(',',$buymake);
				foreach ($buymake as $key){
					$insertmakevalue[] = 'm'.$key.'m';
				}
				$insertmake['lead_option_value'] = implode(',', $insertmakevalue);
				leadpreferencesmodel::lead_preferences_insert($schemaname,$insertmake);
			}
			if(!empty($buymodel))
			{
				$buymodel 		=	explode(',',$buymodel);
				foreach ($buymodel as $key){
					$insertmodelvalue[] = 'mo'.$key.'mo';
				}
				$insertmodel['lead_option_value'] = implode(',', $insertmodelvalue);
				leadpreferencesmodel::lead_preferences_insert($schemaname,$insertmodel);
			}

			if(!empty($pricefliter))
			{
				$pricefliter 		=	explode(',',$pricefliter);
				foreach ($pricefliter as $key){
					$insertpricefiltervalue[] = 'f'.$key.'f';
				}
				$insertpricefilter['lead_option_value'] = implode(',', $insertpricefiltervalue);
				leadpreferencesmodel::lead_preferences_insert($schemaname,$insertpricefilter);
			}
			if(!empty($timeline))
			{
				$inserttimelinevalue = 't'.$timeline.'t';
				$inserttimeline['lead_option_value'] = $inserttimelinevalue;
				leadpreferencesmodel::lead_preferences_insert($schemaname,$inserttimeline);
			}
			return response()->json(['Result'=>'1',
										'message'=>'Lead Added successfully..'
										]);	
		}
		return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);	
    }
    
    public function doApicontactDocument()
    { 
		$contact_id 		= 	Input::get('contact_id');
		$id 				= 	Input::get('session_user_id');
		$document_dob 		= 	Input::get('document_dob');
		$document_id_type 	= 	Input::get('document_id_type');
		$document_id_number = 	Input::get('document_id_number');
		$contact_image 		= 	Input::get('document_image');
		$cantactnoimage 	= 	Config::get('common.no_contact_image');
		if($id == "" || $contact_id == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'All Fields are required!!'
									]);
		}
		$schemaname 		=  	$this->getschemaname($id);
		if(!empty($schemaname))
		{
			//check id is exist or not
			$wheredocument 		=	array('contact_management_id'=>$contact_id);
			$getdocumentresult 	=	branchesmodel::branchlist(
															$schemaname,
															$this->contactdocumentTable,
															$wheredocument
															);
			if(!empty($getdocumentresult) && count($getdocumentresult) >= 1)
			{
				if(!empty($contact_image))
				{
					$imgdata 	= 	base64_decode($contact_image);
					$f 		 	= 	finfo_open();
					$mime_type 	= 	finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE);
					$userimage 	=	"";
					$img_file_extension =	"";
					switch($mime_type) 
					{
						case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
							$userimage	=	'data:'.$mime_type.';base64,'.$contact_image;
							$img_file_extension = 'xlsx';
							break;
						case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
							$userimage	=	'data:'.$mime_type.';base64,'.$contact_image;
							$img_file_extension = 'docx';
							break;
						case 'application/vnd.oasis.opendocument.text':
							$userimage	=	'data:'.$mime_type.';base64,'.$contact_image;
							$img_file_extension = 'odt';
							break;
						case 'text/html':
							$userimage	=	'data:'.$mime_type.';base64,'.$contact_image;
							$img_file_extension = 'htm';
							break;
						case 'image/jpeg':
							$userimage	=	'data:'.$mime_type.';base64,'.$contact_image;
							$img_file_extension = 'jpeg';
							break;
						case 'image/jpg':
							$userimage	=	'data:'.$mime_type.';base64,'.$contact_image;
							$img_file_extension = 'jpg';
							break;
						case 'image/png':
							$userimage	=	'data:'.$mime_type.';base64,'.$contact_image;
							$img_file_extension = 'png';
							break;
						case 'application/pdf':
							$userimage	=	'data:'.$mime_type.';base64,'.$contact_image;
							$img_file_extension = 'pdf';
							break;
					}
					
					$base64_img_array 	= 	explode(':', $userimage);
					$img_info 			= 	explode(',', end($base64_img_array));
					$contactimage   	= 	rand(23232,99999).'.'.$img_file_extension;
					if(file_exists(public_path('/uploadimages/'.$schemaname.'/contacts/')))
					{
						
					}
					else
					{
						File::makeDirectory(public_path('/uploadimages/'.$schemaname.'/contacts/'), 0777, true, true);
					}
					if(file_exists(public_path('/uploadimages/'.$schemaname.'/contacts/'.$id)))
					{
						
					}
					else
					{
						File::makeDirectory(public_path('/uploadimages/'.$schemaname.'/contacts/'.$id.'/'), 0777, true, true);
					}
					
					//check file is exist or not otherwise create file
					if(file_exists(public_path('/uploadimages/'.$schemaname.'/contacts/'.$id.'/document/')))
					{
						$img_file_name 		= 	public_path().'/uploadimages/'.$schemaname.'/contacts/'.$id.'/document/'.$contactimage;
						$img_file 			= 	file_put_contents($img_file_name, base64_decode($img_info[1]));
						$contactnewimage 	=	url('uploadimages/'.$schemaname.'/contacts/'.$id.'/document/'.$contactimage);
					}
					else
					{
						File::makeDirectory(public_path('/uploadimages/'.$schemaname.'/contacts/'.$id.'/document/'), 0777, true, true);
						$img_file_name 		= 	public_path().'/uploadimages/'.$schemaname.'/contacts/'.$id.'/document/'.$contactimage;
						$img_file 			= 	file_put_contents($img_file_name, base64_decode($img_info[1]));
						$contactnewimage 	=	url('uploadimages/'.$schemaname.'/contacts/'.$id.'/document/'.$contactimage);
					}
				}
				else
				{
					$contactnewimage  	=	url($cantactnoimage);
				}
													
				$insertrecord		=	array('contact_management_id'=>	$contact_id,
									 'document_id_type'			=>	$document_id_type,
									 'document_id_number'		=>	$document_id_number,
									 'document_dob'				=>	$document_dob,
									 'doc_link_fullpath'		=>	$contactnewimage,
									 'document_name'			=>	$contactimage
									  );
				$updateresult 		=	branchesmodel::UpdateTable(
																$schemaname,
																$this->contactdocumentTable,
																$insertrecord,
																$wheredocument
																);		
				if($updateresult)
				{
					return response()->json(['Result'=>'1',
											'message'=>'Successfully Updated Documents'
											]);
				}
			}
			else
			{
				if(!empty($contact_image))
				{
					$imgdata 	= 	base64_decode($contact_image);
					$f 		 	= 	finfo_open();
					$mime_type 	= 	finfo_buffer($f, $imgdata, FILEINFO_MIME_TYPE);
					$userimage 	=	"";
					$img_file_extension =	"";
					switch($mime_type) 
					{
						case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
							$userimage	=	'data:'.$mime_type.';base64,'.$contact_image;
							$img_file_extension = 'xlsx';
							break;
						case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
							$userimage	=	'data:'.$mime_type.';base64,'.$contact_image;
							$img_file_extension = 'docx';
							break;
						case 'application/vnd.oasis.opendocument.text':
							$userimage	=	'data:'.$mime_type.';base64,'.$contact_image;
							$img_file_extension = 'odt';
							break;
						case 'text/html':
							$userimage	=	'data:'.$mime_type.';base64,'.$contact_image;
							$img_file_extension = 'htm';
							break;
						case 'image/jpeg':
							$userimage	=	'data:'.$mime_type.';base64,'.$contact_image;
							$img_file_extension = 'jpeg';
							break;
						case 'image/jpg':
							$userimage	=	'data:'.$mime_type.';base64,'.$contact_image;
							$img_file_extension = 'jpg';
							break;
						case 'image/png':
							$userimage	=	'data:'.$mime_type.';base64,'.$contact_image;
							$img_file_extension = 'png';
							break;
						case 'application/pdf':
							$userimage	=	'data:'.$mime_type.';base64,'.$contact_image;
							$img_file_extension = 'pdf';
							break;
					}
					$base64_img_array 	= 	explode(':', $userimage);
					$img_info 			= 	explode(',', end($base64_img_array));
					$contactimage   	= 	rand(23232,99999).'.'.$img_file_extension;
					if(file_exists(public_path('/uploadimages/'.$schemaname.'/contacts/')))
					{
						
					}
					else
					{
						File::makeDirectory(public_path('/uploadimages/'.$schemaname.'/contacts/'), 0777, true, true);
					}
					if(file_exists(public_path('/uploadimages/'.$schemaname.'/contacts/'.$id)))
					{
						
					}
					else
					{
						File::makeDirectory(public_path('/uploadimages/'.$schemaname.'/contacts/'.$id.'/'), 0777, true, true);
					}
					//check file is exist or not otherwise create file
					if(file_exists(public_path('/uploadimages/'.$schemaname.'/contacts/'.$id.'/document/')))
					{
						$img_file_name 		= 	public_path().'/uploadimages/'.$schemaname.'/contacts/'.$id.'/document/'.$contactimage;
						$img_file 			= 	file_put_contents($img_file_name, base64_decode($img_info[1]));
						$contactnewimage 	=	url('uploadimages/'.$schemaname.'/contacts/'.$id.'/document/'.$contactimage);
					}
					else
					{
						File::makeDirectory(public_path('/uploadimages/'.$schemaname.'/contacts/'.$id.'/document/'), 0777, true, true);
						$img_file_name 		= 	public_path().'/uploadimages/'.$schemaname.'/contacts/'.$id.'/document/'.$contactimage;
						$img_file 			= 	file_put_contents($img_file_name, base64_decode($img_info[1]));
						$contactnewimage 	=	url('uploadimages/'.$schemaname.'/contacts/'.$id.'/document/'.$contactimage);
					}
				}
				else
				{
					$contactnewimage  	=	url($cantactnoimage);
				}										
				$insertrecord		=	array('contact_management_id'=>	$contact_id,
									 'document_id_type'			=>	$document_id_type,
									 'document_id_number'		=>	$document_id_number,
									 'document_dob'				=>	$document_dob,
									 'doc_link_fullpath'		=>	$contactnewimage,
									 'document_name'			=>	$contactimage
									  );
				$insertresult 		=	branchesmodel::InsertTable(
															$schemaname,
															$this->contactdocumentTable,
															$insertrecord
															);
				if($insertresult >= 1)
				{
					return response()->json(['Result'=>'1',
											'message'=>'Successfully added'
											]);
				}
				else
				{
					return response()->json(['Result'=>'0',
											'message'=>'Please try again'
											]);
				}
			}
		}
		return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);	
    }
    public function doApitestDocument(Request $res)
    { 
		$contact_image 	= 	$res->input('document_image');
		return response()->json(['Result'=>'1',
										'message'=>$contact_image
										]);
		print_r($contact_image);
		exit;
		$contact_id 	= 	Input::get('contact_id');
		$contact_image 	= 	Input::get('document_image');
		$update 		=	mongomodel::where('listing_id',$contact_id)->get();	
		if(!empty($update))
		{
			foreach($update as $key=>$value)
			{
				if(count($value["photos"])>=1)
				{					
					//foreach($update as $key=>$valu)
					for($i = 0;$i<count($value["photos"]);$i++)
					{
						$update 	=	mongomodel::where('listing_id',$contact_id)->update(
						array('photos.'.$i.'.s3_bucket_path'=>'https://s3-ap-southeast-1.amazonaws.com/dealerplus/uploadimages/dmschema_1495696310151/inventory/4/listing_images/50906.jpeg'));
						
						//echo $i;
							//$update 	=	mongomodel::where('listing_id',$contact_id)->update(
							/*$arr = array(''.$valu.'[photos].'.$key.'.s3_bucket_path'=>'https://s3-ap-southeast-1.amazonaws.com/dealerplus/uploadimages/dmschema_1495696310151/inventory/4/listing_images/50906.jpeg');
							echo "<pre>";
							print_r($arr);
							for($i = 0;$i<=$count;$i++)
					{
						$update 	=	mongomodel::where('listing_id',$contact_id)->update(
						array('photos.'.$i.'.s3_bucket_path'=>'https://s3-ap-southeast-1.amazonaws.com/dealerplus/uploadimages/dmschema_1495696310151/inventory/4/listing_images/50906.jpeg')
						);
					}*/
					}
				}
			}
		}	
		exit;
		return response()->json(['Result'=>'1',
										'message'=>$contact_image->getClientOriginalExtension()
										]);
		if(is_array($contact_image))
		{
			echo "yes array";
		}
		if(is_file($contact_image))
		{
			echo "yes file";
		}
		print_r($contact_image);exit;
    }
    public function dotestemail()
    {
		$message 	=	"forget link";	
		Mail::raw('Text to e-mail', function($message)
		{
			$message->from('support@dealerplus.in', 'Laravel');

			$message->to('vinoth.t@falconnect.in')->cc('vinoth.t@falconnect.in');
		});
		//mail('vinoth.t@falconnect.in','dawer','waer','rwercwervwer');	
		/*Mail::send('emails.welcome', ['title' =>'email test', 'message' => $message], function ($message)
		{
			$message->from('vinoth.t@falconnect.in', 'Scotch.IO');
			$message->to('vinoth.t@falconnect.in');
		});*/

	}
	/*The Function used for Edit Contact */

	public function doApiupdatecontact()
	{					
		$id 					= 	Input::get('session_user_id');
		$contact_id 			= 	Input::get('contact_id');
		$contact_type 			= 	Input::get('contact_type');
		$contactowner 			= 	Input::get('contactowner');
		$contactname 			= 	Input::get('contactname');
        $contactnumber 			= 	Input::get('contactnumber');
        $contactpannumber 		= 	Input::get('contactpannumber');
        $contactmailid			= 	Input::get('contactmailid');
        $contactaddress 		= 	Input::get('contactaddress');
        $contact_image 			= 	Input::get('contact_image');
        $contact_gender 		= 	Input::get('contact_gender');
		$contact_sms    		= 	Input::get('contact_sms');
        $contact_email 			= 	Input::get('contact_email');
        $cantactnoimage 		= 	Config::get('common.no_contact_image');
        $setuserimage 			= 	'data:image/png;base64,';
        $contactimage			=	"";  
        $contactnewimage		=	"";        
        $userimage 				=	'';
        if($id == "" || $contact_id == "" || $contact_type == "" || $contactowner == "" || $contactname== "" ||
         $contactnumber== "" || $contactpannumber	==	""	||  $contactmailid == "" || $contactaddress == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'All Fields are required!!'
									]);
		}
		if(Input::get('page_name')=='editcontact')
		{
			$schemaname 		=  	$this->getschemaname($id);
			if(!empty($schemaname))
			{
				//check mobile name is exist
				$wheremobile 	=	array('contact_phone_1'=>$contactnumber);
				$mobileresult 	=	commonmodel::doWherenotExists(
															$schemaname,
															$this->contactManageTable,
															$wheremobile,
															'contact_management_id',
															$contact_id);
				$mobilenumexist =	((count($mobileresult)>=1)?$mobileresult[0]->contact_phone_1:'');
				
				if($mobilenumexist	==	$contactnumber)
				{
					return response()->json(['Result'=>'0',
										'message'=>'This Mobile Number is already registered with us!!'
										]);
				}
				
				//check email id is exist
				$whereemailid 	=	array('contact_email_1'=>$contactmailid);
				$emailidresult 	=	commonmodel::doWherenotExists(
															$schemaname,
															$this->contactManageTable,
															$whereemailid,
															'contact_management_id',
															$contact_id);
				$emailidexist =	((count($emailidresult)>=1)?$emailidresult[0]->contact_email_1:'');
				
				if($emailidexist	==	$contactmailid)
				{
					return response()->json(['Result'=>'0',
										'message'=>'This Email id is already registered with us!!'
										]);
				}

				if(!empty($contact_image))
				{
					$userimage			=	$setuserimage.$contact_image;
					$base64_img_array 	= 	explode(':', $userimage);
					$img_info 			= 	explode(',', end($base64_img_array));
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
					
					$where 			=	array('contact_management_id'=>$contact_id,'contact_status'=>'active');
					$getresult 		=	branchesmodel::branchlist(
															$schemaname,
															$this->contactManageTable,
															$where
																);
					$imageexplode 	=	((count($getresult)>=1)?$getresult[0]->user_image:'');
					$deletefilename	=	explode('/',$imageexplode,6);
					if(!empty($deletefilename[5]))
					{
						if(file_exists(public_path($deletefilename[5])))
						{
							unlink(public_path($deletefilename[5]));
						}
					}					
					$contactimage   	= 	rand(23232,99999).'.'.$img_file_extension;
					$img_file_name 		= 	public_path().'/uploadimages/'.$schemaname.'/contacts/'.$id.'/'.$contactimage;
					$img_file 			= 	file_put_contents($img_file_name, base64_decode($img_info[1]));
					$contactnewimage 	=	url('uploadimages/'.$schemaname.'/contacts/'.$id.'/'.$contactimage);
				}
				else
				{
					$contactnewimage  	=	url($cantactnoimage);
				}				
					$where 				=	array('contact_management_id'=>$contact_id);
					$updaterecord		=	array('dealer_id'			=>	$id,
											 'contact_type_id'			=>	$contact_type,
											 'contact_owner'			=>	$contactowner,
											 'contact_first_name'		=>	$contactname,
											 'contact_phone_1'			=>	$contactnumber,
											 'contact_mailing_address'	=>	$contactaddress,
											 'contact_email_1'			=>	$contactmailid,
											 'contact_gender'			=>	$contact_gender,									 
											 'user_image'				=>	$contactnewimage,
											 'contact_email_opt_out'	=>	$contact_email,
											'contact_sms_opt_out'		=>	$contact_sms,
											 'pan_number'				=>	$contactpannumber
											  );
											  
					
					$updateresult 		=	branchesmodel::UpdateTable(
																	$schemaname,
																	$this->contactManageTable,
																	$updaterecord,
																	$where
																	);
				if($updateresult >= 1)
				{
					return response()->json(['Result'=>'1',
											'message'=>'success',
											'Contactid'=>$contact_id
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
	
	/*The Function used for view all contact*/
	public function doApiviewcontact()
	{	
		$id						=	Input::get('session_user_id');
		$contact_type			=	Input::get('contact_type');
		if($id == "" || $contact_type == "")
		{
			return response()->json(['Result'=>'0',
								'message'=>'Userid are required'
									]);
		}
		if(Input::get('page_name')	==	'viewcontactlist')
		{
			$schemaname 	=  $this->getschemaname($id);
			if(!empty($schemaname))
			{
				if($contact_type == 0)
				{
					$where 			=	array('contact_status'=>'active');
					$getresult 		=	branchesmodel::branchlist(
															$schemaname,
															$this->contactManageTable,
															$where
																);
				}
				else
				{
					$where 			=	array('contact_type_id'=>$contact_type,'contact_status'=>'active');
					$getresult 		=	branchesmodel::branchlist(
															$schemaname,
															$this->contactManageTable,
															$where
																);
				}
				
				$queriesdata 	= 	array();
				$data 			= 	array();			
				if(!empty($getresult) && count($getresult) >= 1)
				{
					foreach($getresult as $uservalue)
					{	
						$data['address']        	= 	$uservalue->contact_mailing_address;
						if(!empty($uservalue->user_image))
						{
							$data['contactimage']   = 	url(stripcslashes($uservalue->user_image));
						}
						else
						{
							$data['contactimage']   = 	url(Config::get('common.profilenoimage'));
						}
						$data['contact_email']      = 	$uservalue->contact_email_opt_out;
						$data['contact_gender']     = 	$uservalue->contact_gender;
						$data['contact_id']       	= 	$uservalue->contact_management_id;
						$data['contact_owner']      = 	$uservalue->contact_owner;
						$data['contact_sms']      	= 	$uservalue->contact_sms_opt_out;
						$data['contact_type_id']    = 	$uservalue->contact_type_id;
						$data['email']        		= 	$uservalue->contact_email_1;
						$wherecon 					=	array('contact_type_id'=>$uservalue->contact_type_id);
						$getnameofcontact 			= 	commonmodel::getAllRecordsWhere('dealer_contact_type',
																						$wherecon);
			            if(count($getnameofcontact) >= 1)
			            {
							$data['contact_type_name']  = 	$getnameofcontact[0]->contact_type;
						}
						$data['name']        		= 	$uservalue->contact_first_name;			
						$data['mobilenum']  		= 	$uservalue->contact_phone_1;
						$data['pan_number']    		= 	$uservalue->pan_number;
						$getprefercences	= 	leadpreferencesmodel::lead_preferences_fetch(
																$schemaname,
																array('lead_id'=>$uservalue->contact_management_id)
																);
						$regionfetch 	= 	array();
						$model     		= 	array();
						$makefetch 		= 	array();
						$modelfetch 	= 	array();
						$pricefilterfetch = 	array();
						$budgetfetch 	= 	array();
						$timelinefetch 	= 	array();
						$data['lead_makeid'] 	=	"";
						$data['lead_cityid'] 	=	"";
						$data['lead_modelid'] 	=	"";
						$data['lead_prcie'] 	=	"";
						$data['lead_time'] 		=	"";
						$citynames 				=	"";
						$lead_makeid 			=	"";
						$lead_modelid 			=	"";
						$lead_prcie 			=	"";
						if(!empty($getprefercences) && count($getprefercences) >= 1)
						{
							foreach ($getprefercences as $key => $value) 
							{
								$paramid  	= 	$value->lead_option_id;
								switch ($paramid) {
									case 1:
										$cityids 		= 	str_replace('r','',$value->lead_option_value);
										break;
									case 2:
										$lead_makeid 	= 	str_replace('m','',$value->lead_option_value);
										break;
									case 3:
										$lead_modelid 	= 	str_replace('mo','',$value->lead_option_value);
										break;
									case 4:
										$lead_prcie 	= 	str_replace('f','',$value->lead_option_value);
										break;
									case 5:
										$data['lead_time'] = 	str_replace('t','',$value->lead_option_value);
										break;
								}
								$citynames 					=	explode(',',$cityids);
								$getcity 	 				=	commonmodel::doMasterrecordswherein(
																		$citynames);
								$data['lead_cityname']		=	(count($getcity->pluck('city_name'))>=1?$getcity->pluck('city_name'):[]);
								$data['lead_cityid'] 		=	explode(',',$cityids);
								$makenames 					=	explode(',',$lead_makeid);
								$data['lead_makeid'] 		=	explode(',',$lead_makeid);
								$data['lead_modelid'] 		=	explode(',',$lead_modelid);
								$getmakes 	 				=	commonmodel::dogetWhereinmakes(
																		$makenames);
							
								$data['lead_makename']		=	(count($getmakes)>=1?$getmakes->pluck('makename'):[]);
								$modelnames 				=	explode(',',$lead_modelid);
								$getmodels 	 				=	commonmodel::dogetWhereinmodels(
																		$modelnames);
								$data['lead_modelname']		=	(count($getmodels->pluck('model_name'))>=1?$getmodels->pluck('model_name'):[]);
								
								$pricenames 				=	explode(',',$lead_prcie);
								$data['lead_prcie'] 		=	explode(',',$lead_prcie);
								$getpricenames 	 			=	commonmodel::dogetWhereinleadparams(
																		$pricenames);
								$data['lead_pricename']		=	(count($getpricenames->pluck('option_desc'))>=1?$getpricenames->pluck('option_desc'):[]);
								
								$getleadtime				= 	commonmodel::getAllRecordsWhere('parameter_option_scoring',array('option_id'=>$data['lead_time']));
								$data['lead_timename']		= 	(count($getleadtime)>=1?$getleadtime[0]->option_desc:'');
								
							}
						}
						else
						{
							$data['lead_cityname'] 	= 	[];
							$data['lead_cityid'] 	= 	[];
							$data['lead_makeid'] 	= 	[];
							$data['lead_modelid'] 	= 	[];
							$data['lead_makename'] 	= 	[];
							$data['lead_modelname'] = 	[];
							$data['lead_timename'] 	= 	"";
							$data['lead_prcie'] 	= 	[];
							$data['lead_time'] 		= 	"";
							$data['lead_pricename'] = 	[];
						}
						//get document details
						$wheredocument 		=	array('contact_management_id'=>$uservalue->contact_management_id);
						$getdocument 		=	branchesmodel::branchlist(
															$schemaname,
															$this->contactdocumentTable,
															$wheredocument);
						if(!empty($getdocument) && count($getdocument) >= 1)
						{
							foreach($getdocument as $document)
							{
								$data['dealer_document_management_id'] 	= 	($document->dealer_document_management_id == null?'':$document->dealer_document_management_id);
								$data['contact_management_id'] 	= 	($document->contact_management_id == null?'':$document->contact_management_id);
								$data['document_id_type'] 		= 	($document->document_id_type == null?'':$document->document_id_type);
								$data['document_id_number'] 	= 	($document->document_id_number == null?'':$document->document_id_number);
								$data['document_dob'] 			= 	($document->document_dob == null?'':$document->document_dob);
								$data['doc_link_fullpath'] 		= 	($document->doc_link_fullpath == null ?'':$document->doc_link_fullpath);
								$data['document_name'] 			= 	($document->document_name == null ?'':$document->document_name);
							}
						}
						else
						{
							$data['dealer_document_management_id'] 	= 	"";
							$data['contact_management_id'] 	= 	"";
							$data['document_id_type'] 	= 	"";
							$data['document_id_number'] = 	"";
							$data['document_dob'] 		= 	"";
							$data['doc_link_fullpath'] 	= 	"";
							$data['document_name'] 		= 	"";
						}
						array_push($queriesdata, $data); 
					}
				}
				return response()->json(['Result'=>'1',
									'message'=>'success',
									'contact_list'=>$queriesdata
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
	public function viewleadbasicinfo()
	{
		$id		=	Input::get('session_user_id');
		if($id == "")
		{
			return response()->json(['Result'=>'0',
								'message'=>'user id is required'
									]);
		}
		$schemaname 		=  $this->getschemaname($id);
		if(!empty($schemaname))
		{
			$queriesdata 	=	parameter_option_scoring::get();
			$leadarray 		=	array();
			if(!empty($queriesdata) && count($queriesdata) >= 1)
			{
				$where 	=	array('status'=>'Active');
				foreach($queriesdata as $value)
				{
					if($value->option_id ==	1)
					{
						$data['option_id'] 		=	$value->option_id;
						$data['option_desc'] 	=	commonmodel::dogetMasterCity();
						$data['parameter_id'] 	=	$value->parameter_id;
						$data['option_value'] 	=	$value->option_value;
						$data['option_value_2'] =	$value->option_value_2;
					}
					else if($value->option_id ==	2)
					{
						$data['option_id'] 		=	$value->option_id;
						$data['option_desc'] 	=	commonmodel::getAllRecordsWhere('master_makes',$where);
						$data['parameter_id'] 	=	$value->parameter_id;
						$data['option_value'] 	=	$value->option_value;
						$data['option_value_2'] =	$value->option_value_2;
					}
					else
					{
						$data['option_id'] 		=	$value->option_id;
						$data['option_desc'] 	=	$value->option_id;
						$data['parameter_id'] 	=	$value->option_desc;
						$data['option_value'] 	=	$value->option_value;
						$data['option_value_2'] =	$value->option_value_2;
					}
					array_push($leadarray, $data); 
				}
			}
			return response()->json(['Result'=>'1',
								'message'=>'success',
								'leadbasickeyvalue'=>$leadarray
								]);	
		}		
		return response()->json(['Result'=>'0',
									'message'=>'Invalid Access'
									]);
	}
	
	
	/*The Function used for view all contact*/
	public function doApisearchviewcontact()
	{	
		$id						=	Input::get('session_user_id');
		$contact_type			=	Input::get('contact_type');
		$searchcontact			=	Input::get('searchcontact');
		if($id == "" || $contact_type == "" || $searchcontact == "")
		{
			return response()->json(['Result'=>'0',
								'message'=>'Userid are required'
									]);
		}
		$schemaname 	=  $this->getschemaname($id);
		if(!empty($schemaname))
		{
			if($contact_type == 0)
			{
				$where 			=	array('contact_status'=>'active');
				$getresult 		=	branchesmodel::searchallcolumncontact(
														$schemaname,
														$where,
														$searchcontact
															);
			}
			else
			{
				$where 			=	array('contact_type_id'=>$contact_type,'contact_status'=>'active');
				$getresult 		=	branchesmodel::searchallcolumncontact(
														$schemaname,
														$where,
														$searchcontact
															);
			}
			$queriesdata 	= 	array();
			$data 			= 	array();
			if(!empty($getresult) && count($getresult) >= 1)
			{
				foreach($getresult as $uservalue)
				{	
					$data['address']        	= 	$uservalue->contact_mailing_address;
						if(!empty($uservalue->user_image))
						{
							$data['contactimage']   = 	url(stripcslashes($uservalue->user_image));
						}
						else
						{
							$data['contactimage']   = 	url(Config::get('common.profilenoimage'));
						}
						$data['contact_email']      = 	$uservalue->contact_email_opt_out;
						$data['contact_gender']     = 	$uservalue->contact_gender;
						$data['contact_id']       	= 	$uservalue->contact_management_id;
						$data['contact_owner']      = 	$uservalue->contact_owner;
						$data['contact_sms']      	= 	$uservalue->contact_sms_opt_out;
						$data['contact_type_id']    = 	$uservalue->contact_type_id;
						$data['email']        		= 	$uservalue->contact_email_1;
						$wherecon 					=	array('contact_type_id'=>$uservalue->contact_type_id);
						$getnameofcontact 			= 	commonmodel::getAllRecordsWhere('dealer_contact_type',
																						$wherecon);
			            if(count($getnameofcontact) >= 1)
			            {
							$data['contact_type_name']  = 	$getnameofcontact[0]->contact_type;
						}
						$data['name']        		= 	$uservalue->contact_first_name;			
						$data['mobilenum']  		= 	$uservalue->contact_phone_1;
						$data['pan_number']    		= 	$uservalue->pan_number;
						$getprefercences	= 	leadpreferencesmodel::lead_preferences_fetch(
																$schemaname,
																array('lead_id'=>$uservalue->contact_management_id)
																);
						$regionfetch 	= 	array();
						$model     		= 	array();
						$makefetch 		= 	array();
						$modelfetch 	= 	array();
						$pricefilterfetch = 	array();
						$budgetfetch 	= 	array();
						$timelinefetch 	= 	array();
						$data['lead_makeid'] 	=	"";
						$data['lead_cityid'] 	=	"";
						$data['lead_modelid'] 	=	"";
						$data['lead_prcie'] 	=	"";
						$data['lead_time'] 		=	"";
						$citynames 				=	"";
						$lead_makeid 			=	"";
						$lead_modelid 			=	"";
						$lead_prcie 			=	"";
						if(!empty($getprefercences) && count($getprefercences) >= 1)
						{
							foreach ($getprefercences as $key => $value) 
							{
								$paramid  	= 	$value->lead_option_id;
								switch ($paramid) {
									case 1:
										$cityids 		= 	str_replace('r','',$value->lead_option_value);
										break;
									case 2:
										$lead_makeid 	= 	str_replace('m','',$value->lead_option_value);
										break;
									case 3:
										$lead_modelid 	= 	str_replace('mo','',$value->lead_option_value);
										break;
									case 4:
										$lead_prcie 	= 	str_replace('f','',$value->lead_option_value);
										break;
									case 5:
										$data['lead_time'] = 	str_replace('t','',$value->lead_option_value);
										break;
								}
								$citynames 					=	explode(',',$cityids);
								$data['lead_cityid'] 		=	explode(',',$cityids);
								$getcity 	 				=	commonmodel::doMasterrecordswherein(
																		$citynames);
								$data['lead_cityname']		=	(count($getcity->pluck('city_name'))>=1?$getcity->pluck('city_name'):[]);
								$makenames 					=	explode(',',$lead_makeid);
								$data['lead_makeid'] 		=	explode(',',$lead_makeid);
								$data['lead_modelid'] 		=	explode(',',$lead_modelid);
								$getmakes 	 				=	commonmodel::dogetWhereinmakes(
																		$makenames);
								$data['lead_makename']		=	(count($getmakes)>=1?$getmakes->pluck('makename'):[]);
								$modelnames 				=	explode(',',$lead_modelid);
								$getmodels 	 				=	commonmodel::dogetWhereinmodels(
																		$modelnames);
								$data['lead_modelname']		=	(count($getmodels->pluck('model_name'))>=1?$getmodels->pluck('model_name'):[]);
								$pricenames 				=	explode(',',$lead_prcie);
								$data['lead_prcie'] 		=	explode(',',$lead_prcie);
								$getpricenames 	 			=	commonmodel::dogetWhereinleadparams(
																		$pricenames);
								$data['lead_pricename']		=	(count($getpricenames->pluck('option_desc'))>=1?$getpricenames->pluck('option_desc'):[]);
								
								$getleadtime				= 	commonmodel::getAllRecordsWhere('parameter_option_scoring',array('option_id'=>$data['lead_time']));
								$data['lead_timename']		= 	(count($getleadtime)>=1?$getleadtime[0]->option_desc:'');
								
							}
						}
						else
						{
							$data['lead_cityname'] 	= 	[];
							$data['lead_cityid'] 	= 	[];
							$data['lead_makeid'] 	= 	[];
							$data['lead_modelid'] 	= 	[];
							$data['lead_makename'] 	= 	[];
							$data['lead_modelname'] = 	[];
							$data['lead_timename'] 	= 	"";
							$data['lead_prcie'] 	= 	[];
							$data['lead_time'] 		= 	"";
							$data['lead_pricename'] = 	[];
						}
						//get document details
						$wheredocument 		=	array('contact_management_id'=>$uservalue->contact_management_id);
						$getdocument 		=	branchesmodel::branchlist(
															$schemaname,
															$this->contactdocumentTable,
															$wheredocument);
						if(!empty($getdocument) && count($getdocument) >= 1)
						{
							foreach($getdocument as $document)
							{
								$data['dealer_document_management_id'] 	= 	($document->dealer_document_management_id == null?'':$document->dealer_document_management_id);
								$data['contact_management_id'] 	= 	($document->contact_management_id == null?'':$document->contact_management_id);
								$data['document_id_type'] 		= 	($document->document_id_type == null?'':$document->document_id_type);
								$data['document_id_number'] 	= 	($document->document_id_number == null?'':$document->document_id_number);
								$data['document_dob'] 			= 	($document->document_dob == null?'':$document->document_dob);
								$data['doc_link_fullpath'] 		= 	($document->doc_link_fullpath == null ?'':$document->doc_link_fullpath);
								$data['document_name'] 			= 	($document->document_name == null ?'':$document->document_name);
							}
						}
						else
						{
							$data['dealer_document_management_id'] 	= 	"";
							$data['contact_management_id'] 	= 	"";
							$data['document_id_type'] 	= 	"";
							$data['document_id_number'] = 	"";
							$data['document_dob'] 		= 	"";
							$data['doc_link_fullpath'] 	= 	"";
							$data['document_name'] 		= 	"";
						}
						array_push($queriesdata, $data); 
				}
			}
			return response()->json(['Result'=>'1',
								'message'=>'success',
								'contact_list'=>$queriesdata
								]);	
		}				
		else
		{
			return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
		}	

	}
	/*The Function used for delete contact*/
	public function doApideletecontact()
	{	
		$id						=	Input::get('session_user_id');
		$contact_id				=	Input::get('contact_id');
		if($id == "" || $contact_id == "")
		{
			return response()->json(['Result'=>'0',
								'message'=>'Contact id is required'
									]);
		}
		if(Input::get('page_name')	==	'deletecontact')
		{
			$schemaname 			=  $this->getschemaname($id);
			if(!empty($schemaname))
			{
				$where 				=	array('contact_management_id'=>$contact_id);
				$updaterecord		=	array('contact_status'	=>	'inactive');
				$updateresult 		=	branchesmodel::UpdateTable(
															$schemaname,
															$this->contactManageTable,
															$updaterecord,
															$where
															);
				if(!empty($updateresult) && count($updateresult) >= 1)
				{
					$where 				=	array('contact_management_id'=>$contact_id);
					$updaterecord		=	array('dealer_document_status'	=>	'inactive');
					$updateresult 		=	branchesmodel::UpdateTable(
															$schemaname,
															$this->contactdocumentTable,
															$updaterecord,
															$where
															);
					return response()->json(['Result'=>'3',
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
		else
		{
			return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
		}	
	}
	
	/*THIS FUNCTION USED FOR VIEW BUSINESS PROFILE DETAILS*/
    public function doApiviewbusinessprofile()
    {          
        $id 				= 	Input::get('session_user_id');
        $cover_image 		= 	Input::get('cover_image');
        $profile_image 		= 	Input::get('profile_image');
        if($id == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'User id is required!!'
									]);
		}
		if(Input::get('page_name')=='viewbusinessprofile')
		{
			$schemaname 	=  $this->getschemaname($id);
			if(!empty($schemaname))
			{
				$userdata			=	array();
				$getprofiledetails 	=	dealermodel::all()->where('d_id', $id)->first();
				//upload cover image
				if(!empty($cover_image))
				{
					$coverimageupload 	=	$this->doApiuploadcompanycoverimage($cover_image,$schemaname);
					if(!empty($coverimageupload))
					{
						$coverimage				=	$coverimageupload;
					}
					else
					{
						 $coverimage 			= 	url(Config::get('common.no_contact_image'));
					}
					$oldcoverimage 				=	((count($getprofiledetails)>=1)?$getprofiledetails['coverphoto_logo']:'');
					//delete exist file name start
					$deletefilename	=	explode('/',$oldcoverimage,6);
					if(!empty($deletefilename[5]))
					{
						if(file_exists(public_path($deletefilename[5])))
						{
							unlink(public_path($deletefilename[5]));
						}
					}
					
					$wheremain 					=	array('d_id'=>$id);			
					$updatemain					=	array('coverphoto_logo'=>$coverimage);
					$updatemainresult 			=	branchesmodel::masterupdateDetail(
															'dms_dealers',
															$wheremain,
															$updatemain
															);
					if($updatemainresult>=1)
					{
						$where 					=	array('dealers_details_id'=>1);
						$updaterecord			=	array('company_cover_img'=>$coverimage);
						$updateresult 			=	branchesmodel::UpdateTable(
															$schemaname,
															'dms_dealerdetails',
															$updaterecord,
															$where
															);
					}
				}
				
				if(!empty($profile_image))
				{
					$profileimageupload 		=	$this->doApiuploadcompanycoverimage($profile_image,$schemaname);
					$resizeimageupload 			=	$this->doApiuploadresizeimage($profile_image,$schemaname);
					
					if(!empty($profileimageupload))
					{
						$profileimage			=	$profileimageupload;
					}
					else
					{
						 $profileimage 			= 	url(Config::get('common.no_contact_image'));
					}
					if(!empty($resizeimageupload))
					{
						$resizeimage			=	$resizeimageupload;
					}
					else
					{
						 $resizeimage 			= 	url(Config::get('common.no_contact_image'));
					}
					$oldcoverimage 				=	((count($getprofiledetails)>=1)?$getprofiledetails['company_logo']:'');
					//delete exist file name start
					$deletefilename	=	explode('/',$oldcoverimage,6);
					if(!empty($deletefilename[5]))
					{
						if(file_exists(public_path($deletefilename[5])))
						{
							unlink(public_path($deletefilename[5]));
						}
					}
					$oldresizeimage 			=	((count($getprofiledetails)>=1)?$getprofiledetails['watermark_logo']:'');
					//delete exist file name start
					$deletefilename	=	explode('/',$oldresizeimage,6);
					if(!empty($deletefilename[5]))
					{
						if(file_exists(public_path($deletefilename[5])))
						{
							unlink(public_path($deletefilename[5]));
						}
					}
					
					$wheremain 					=	array('d_id'=>$id);			
					$updatemain					=	array('company_logo'=>$profileimage,
															'watermark_logo'=>$resizeimage);
					$updatemainresult 			=	branchesmodel::masterupdateDetail(
															'dms_dealers',
															$wheremain,
															$updatemain
															);
					if($updatemainresult>=1)
					{
						$where 					=	array('dealers_details_id'=>1);
						$updaterecord			=	array('company_logo'=>$profileimage);
						$updateresult 			=	branchesmodel::UpdateTable(
																$schemaname,
																'dms_dealerdetails',
																$updaterecord,
																$where
																);
					}
				}
				//get user details
				$getuserdetails 	=	dealermodel::all()->where('d_id', $id)->first();
				if(!empty($getuserdetails) && count($getuserdetails) >= 1)
				{
					$userdata['d_id']				=	($getuserdetails['d_id'] 			== null ? '':$getuserdetails['d_id']);
					$userdata['parent_id']			=	($getuserdetails['parent_id'] 		== null ? '':$getuserdetails['parent_id']);
					$userdata['dealer_name']		=	($getuserdetails['dealer_name'] 	== null ? '':$getuserdetails['dealer_name']);
					$userdata['dealership_name']	=	($getuserdetails['dealership_name'] == null ? '':$getuserdetails['dealership_name']);
					$userdata['d_email']			=	($getuserdetails['d_email'] 		== null ? '':$getuserdetails['d_email']);
					$userdata['d_mobile']			=	($getuserdetails['d_mobile'] 		== null ? '':$getuserdetails['d_mobile']);
					$userdata['line_of_business']	=	($getuserdetails['line_of_business'] == null ? '':$getuserdetails['line_of_business']);
					$userdata['dealership_website']	=	($getuserdetails['dealership_website'] == null ? '':$getuserdetails['dealership_website']);
					$userdata['facebook_link']		=	($getuserdetails['facebook_link'] 	== null ? '':$getuserdetails['facebook_link']);
					$userdata['twitter_link']		=	($getuserdetails['twitter_link'] 	== null ? '':$getuserdetails['twitter_link']);
					$userdata['linkedin_link']		=	($getuserdetails['linkedin_link'] 	== null ? '':$getuserdetails['linkedin_link']);
					$userdata['company_logo']		=	($getuserdetails['company_logo'] 	== null ? '':$getuserdetails['company_logo']);
					$userdata['coverphoto_logo']	=	($getuserdetails['coverphoto_logo'] == null ? '':$getuserdetails['coverphoto_logo']);
					$userdata['company_doc']		=	($getuserdetails['company_doc'] 	== null ? '':$getuserdetails['company_doc']);
					$userdata['profile_name']		=	($getuserdetails['profile_name']	== null ? '':$getuserdetails['profile_name']);
					$userdata['business_domain']	=	($getuserdetails['business_domain'] == null ? '':$getuserdetails['business_domain']);
					$userdata['about_us']			=	($getuserdetails['about_us'] 		== null ? '':$getuserdetails['about_us']);
					$userdata['landline_no']		=	($getuserdetails['landline_no'] 	== null ? '':$getuserdetails['landline_no']);
					$userdata['fax_no']				=	($getuserdetails['fax_no'] 			== null ? '':$getuserdetails['fax_no']);
					$userdata['company_status']		=	($getuserdetails['company_status'] 	== null ? '':$getuserdetails['company_status']);
					$userdata['dealership_started']	= 	commonmodel::getdatemonthformat($getuserdetails['dealership_started']);
					$userdata['pan_no']				=	($getuserdetails['pan_no'] 			== null ? '':$getuserdetails['pan_no']);
					$userdata['verified']			= 	($getuserdetails['status'] == "Active" ?1:0);
				}
				//get car details page
				
				$wherecon 		=	array('car_master_status'=>2,'mongopush_status'=>'success');
				$getresult 		=	branchesmodel::branchlist($schemaname,
																$this->DmsCarListTable,
																$wherecon
																);
				$queriesdata 	= 	array();
				$data 			= 	array();
				if(!empty($getresult) && count($getresult) >= 1)
				{
					foreach($getresult as $uservalue)
					{		
						$imagefetch 				= 	branchesmodel::branchlist(
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
						$data['listing_id']       	= 	$uservalue->duplicate_id;
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
						$makewhere					=	array('make_id'=>$uservalue->make);
						$getmake 	 				=	branchesmodel::masterFetchTableDetails(
																					'master_makes',
																					$makewhere);
						$data['make'] 				=	((count($getmake)>=1)?$getmake[0]->makename:'');
						$modelwhere					=	array('model_id'=>$uservalue->model_id);
						$getmodel 	 				=	branchesmodel::masterFetchTableDetails(
																					'master_models',
																					$modelwhere);
                        $data['model'] 				=	((count($getmodel)>=1)?$getmodel[0]->model_name:'');
                        $varientwhere				=	array('variant_id'=>$uservalue->variant);
						$getvarient 	 			=	branchesmodel::masterFetchTableDetails(
																					'master_variants',
																					$varientwhere);
                        $data['varient'] 			=	((count($getvarient)>=1)?$getvarient[0]->variant_name:'');
                        $citywhere					=	array('city_id'=>$uservalue->car_city);
						$getcity 	 				=	branchesmodel::masterFetchTableDetails(
																				'master_city',
																				$citywhere);
						$data['car_locality'] 		=	((count($getcity)>=1)?$getcity[0]->city_name:'');
						$data['fuel_type']         	= 	$uservalue->fuel_type;
						$data['statuc_number']      = 	$uservalue->car_master_status;
						$data['imagecount'] 		= 	inventorymodel::dealerTableCount(
																				$schemaname,
																				$this->DmsCarListPhotosTable,
																				array('car_id'=>$uservalue->car_id)
																				);
						$data['days']				=	Carbon::parse($uservalue->created_at)->diffForHumans();
						array_push($queriesdata, $data); 
					}
				}			
				$whereactive 		=	array('status'=>'Active');
				$getbusinesstype	=	commonmodel::getAllRecordsWhere('master_company_type',$whereactive);
				$wherebusi 			=	array('status'=>'Active');
				$getcompanytype		=	commonmodel::getAllRecordsWhere('master_lineof_business',$wherebusi);
				return response()->json(['Result'=>'1',
									'message'=>'success',
									'business_index'=>[$userdata],
									'my_cardetails'	=>$queriesdata,
									'company_business'=>$getbusinesstype,
									'line_business'	=>$getcompanytype,
									]);																
			}
			return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
		}
		return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
		
	}
    
    /*THIS FUNCTION USED TO UPDATE BUSINESS PROFILE DETAILS*/
    public function doApiupdatebusinessprofile()
    {          
        $id 				= 	Input::get('session_user_id');
        $dealer_name 		= 	Input::get('dealer_name');
        $dealership_name 	= 	Input::get('dealership_name');
        $d_mobile 			= 	Input::get('d_mobile');
        if($id == "" || $dealer_name == "" || $dealership_name == "" || $d_mobile == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'All Fields are required!!'
									]);
		}
		
		if(Input::get('page_name')=='updatebusinessprofile')
		{
			$schemaname 	=  $this->getschemaname($id);
			if(!empty($schemaname))
			{
				$where 				=	array('d_mobile'=>$d_mobile);
				$checkdealermobile	=  	branchesmodel::masterFetchTableDetails($this->masterMainLoginTable,
																$where);
																
				/*if($id 	==	$checkdealermobile[0]->d_id && $d_mobile 	==	$checkdealermobile[0]->d_mobile)
				{*/
					$wheremain 					=	array('d_id'=>$id);			
					$updatemain					=	array('dealer_name'=>$dealer_name,
															'dealership_name'=>$dealership_name,
															'd_mobile'=>$d_mobile);
					$updatemainresult 			=	branchesmodel::masterupdateDetail(
															'dms_dealers',
															$wheremain,
															$updatemain
															);
					if($updatemainresult >= 1)
					{
					//update user account table
						$whereuser 					=	array('user_id'=>1);
						$updaterecord				=	array('user_name'=>$dealer_name,
																'user_moblie_no'=>$d_mobile);
						
						$updateresult 				=	branchesmodel::UpdateTable(
																$schemaname,
																'user_account',
																$updaterecord,
																$whereuser
																);
					//update dms dealer details table
					if($updateresult >= 1)
					{
						$wheredealer 				=	array('dealers_details_id'=>1);
						$updaterecord				=	array('dealer_name'=>$dealer_name,
																'phone'=>$d_mobile);										
						$updateresult 				=	branchesmodel::UpdateTable(
																$schemaname,
																'dms_dealerdetails',
																$updaterecord,
																$wheredealer
																);
						}
					}
				
				/*}
				else
				{
					return response()->json(['Result'=>'0',
									'message'=>'Your Mobile Number is already exist with us!!'
									]);
				}*/
				return response()->json(['Result'=>'1',
									'message'=>'success'
									]);																
			}
		}
		return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
    }
    
    /*THIS FUNCTION USED FOR VIEW BUSINESS PROFILE DETAILS*/
    public function doApiviewprofile()
    {          
        $id 				= 	Input::get('session_user_id');
        if($id == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'User id is required!!'
									]);
		}
		if(Input::get('page_name')=='viewprofile')
		{
			$schemaname 	=  $this->getschemaname($id);
			if(!empty($schemaname))
			{
				$cityName 			=	"";
				$stateName 			=	"";
				$userdata			=	array();
				//get user details
				$getuserdetails 	=	dealermodel::all()->where('d_id', $id)->first();
				if(!empty($getuserdetails) && count($getuserdetails) >= 1)
				{
					$resultcityandstate = 	apimodel::getCityAndState($getuserdetails['d_city']);
					if(count($resultcityandstate) > 0)
					{
						foreach($resultcityandstate as $key=>$cityvalue)
						{
							$cityName 	= 	$cityvalue->city_name;
							$stateName 	= 	$cityvalue->state_name;
						}
					}
					$address 		=	"";
					$city	 		=	"";
					$pincode 		=	"";
					$getschemaname 	=	apimodel::dealerFetchDetails($schemaname,'dms_dealerdetails');
					if(!empty($getschemaname) && count($getschemaname) >= 1)
					{
						$address 	=	$getschemaname[0]->Address;
						$city 		=	$cityName;
						$pincode 	=	$getschemaname[0]->pincode;
					}
					if($getuserdetails['logo'] == null || $getuserdetails['logo'] == "")
					{
						$logoprofile   = 	url(Config::get('common.profilenoimage'));
					}
					else
					{
						$logoprofile   =  	stripslashes(url($getuserdetails['logo']));
					}
				
				return response()->json(['Result'=>'1',
										'message'		=>"Successfully logged",
										'user_id'		=>($getuserdetails['d_id'] == null ? '' : $getuserdetails['d_id']),
										'dealer_name'	=>($getuserdetails['dealer_name'] == null ? '' : $getuserdetails['dealer_name']),
										'dealershipname'=>($getuserdetails['dealership_name'] == null ? '' : $getuserdetails['dealership_name']),
										'dealer_mobile'	=>($getuserdetails['d_mobile'] == null ? '' : $getuserdetails['d_mobile']),
										'dealer_email'	=>($getuserdetails['d_email'] == null ? '' : $getuserdetails['d_email']),
										'parent_id'		=>($getuserdetails['parent_id'] == null ? '' : $getuserdetails['parent_id']),
										'dealer_img'	=>$logoprofile,
										'dealer_address'=>($address == ""?'':$address),
										'city'			=>($city == ""?'':$city),
										'pincode'		=>($pincode == ""?'':$pincode)	
										]);
				}
			}
		}
		return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
		
    }
    //THIS FUNCTION USED FOR CREATE NEW EMPLOYEE
    public function doApiaddemployee()
	{					
		$id 					= 	Input::get('session_user_id');
		$employee_type 			= 	Input::get('employee_type');
		$employee_name 			= 	Input::get('employee_name');
		$employee_designation 	= 	Input::get('employee_designation');
		$employee_gender 		= 	Input::get('employee_gender');
		$employee_mobile 		= 	Input::get('employee_mobile');
        $employee_email 		= 	Input::get('employee_email');
        $contact_image 			= 	Input::get('employee_image');
        $cantactnoimage 		= 	Config::get('common.no_contact_image');
        $setuserimage 			= 	'data:image/png;base64,';
        $contactimage			=	"";  
        $contactnewimage		=	"";        
        $userimage 				=	'';
        if($id == "" || $employee_type == "" || $employee_name == "" || $employee_mobile== "" ||
         $employee_email== "" || $employee_designation ==	"" || $employee_gender == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'All Fields are required!!'
									]);
		}
		if(Input::get('page_name')=='addemployee')
		{
			$schemaname 		=  	$this->getschemaname($id);
			if(!empty($schemaname))
			{	
				//check mobile number and mail id is exist or not
			$wheremobile 	=	array('employee_moblie_no'=>$employee_mobile);
			$mobileresult 	=	branchesmodel::branchlist(
														$schemaname,
														$this->DealeremployeeTable,
														$wheremobile);
			$whereemail 	=	array('employee_email_1'=>$employee_email);
			$emailresult 	=	branchesmodel::branchlist(
														$schemaname,
														$this->DealeremployeeTable,
														$whereemail);
			if(!empty($mobileresult) && count($mobileresult) >= 1)
			{
				return response()->json(['Result'=>'0',
									'message'=>'Your mobile number is already registered with us!!'
									]);
			}
			if(!empty($emailresult) && count($emailresult) >= 1)
			{
				return response()->json(['Result'=>'0',
									'message'=>'Your Email id is already registered with us!!'
									]);
			}
							
				if(!empty($contact_image))
				{
					$userimage			=	$setuserimage.$contact_image;
					$base64_img_array 	= 	explode(':', $userimage);
					$img_info 			= 	explode(',', end($base64_img_array));
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
					$contactimage   = 	rand(23232,99999).'.'.$img_file_extension;
					if(file_exists(public_path('/uploadimages/'.$schemaname.'/employee/')))
					{

					}
					else
					{
						File::makeDirectory(public_path('/uploadimages/'.$schemaname.'/employee/'), 0777, true, true);
					}
					//check file is exist or not otherwise create file
					if(file_exists(public_path('/uploadimages/'.$schemaname.'/employee/'.$id.'/')))
					{
						$img_file_name 		= 	public_path().'/uploadimages/'.$schemaname.'/employee/'.$id.'/'.$contactimage;
						$img_file 			= 	file_put_contents($img_file_name, base64_decode($img_info[1]));
						$contactnewimage 	=	url('uploadimages/'.$schemaname.'/employee/'.$id.'/'.$contactimage);
					}
					else
					{
						File::makeDirectory(public_path('/uploadimages/'.$schemaname.'/employee/'.$id.'/'), 0777, true, true);
						$img_file_name 		= 	public_path().'/uploadimages/'.$schemaname.'/employee/'.$id.'/'.$contactimage;
						$img_file 			= 	file_put_contents($img_file_name, base64_decode($img_info[1]));
						$contactnewimage 	=	url('uploadimages/'.$schemaname.'/employee/'.$id.'/'.$contactimage);
					}
				}
				else
				{
					$contactnewimage  	=	url($cantactnoimage);
				}										
			$insertrecord		=	array('dealer_id'			=>	$id,
									 'employee_type'			=>	$employee_type,
									 'employee_first_name'		=>	$employee_name,
									 'employee_moblie_no'		=>	$employee_mobile,
									 'employee_email_1'			=>	$employee_email,									 
									 'employee_user_image'		=>	$contactnewimage,
									 'employee_designation' 	=>	$employee_designation,
									 'employee_gender'			=>	$employee_gender,
									 'employee_status'			=>	'active'
									  );
			
			$insertresult 		=	branchesmodel::InsertTable(
															$schemaname,
															$this->DealeremployeeTable,
															$insertrecord
															);
			if($insertresult >= 1)
			{
				$contactrecord	=	array('employee_management_id'  =>	$insertresult);
				$insertcontact 	=	branchesmodel::InsertTable(
															$schemaname,
															'dealer_employee_document_management',
															$contactrecord
															);
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
		}
		return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
		
	}
    
    /*The Function used for Edit Employee */

	public function doApiupdateEmployee()
	{					
		$id 					= 	Input::get('session_user_id');
		$employee_id 			= 	Input::get('employee_id');
		$employee_type 			= 	Input::get('employee_type');
		$employee_name 			= 	Input::get('employee_name');
		$employee_mobile 		= 	Input::get('employee_mobile');
        $employee_email 		= 	Input::get('employee_email');
        $contact_image 			= 	Input::get('employee_image');
		$employee_designation 	= 	Input::get('employee_designation');
		$employee_gender 		= 	Input::get('employee_gender');
        $cantactnoimage 		= 	Config::get('common.no_contact_image');
        $setuserimage 			= 	'data:image/png;base64,';
        $contactimage			=	"";  
        $contactnewimage		=	"";        
        $userimage 				=	'';
        if($id == "" || $employee_id == "" || $employee_type == "" || $employee_name == "" || $employee_mobile == "" ||
         $employee_email == "" || $employee_designation ==	"" || $employee_gender == "")
        {
			return response()->json(['Result'=>'0',
									'message'=>'All Fields are required!!'
									]);
		}
		if(Input::get('page_name')=='editemployee')
		{
			$schemaname 		=  	$this->getschemaname($id);
			if(!empty($schemaname))
				{//check email id is exist
				$whereemail 	=	array('employee_email_1'=>$employee_email);
				$emailresult 	=	commonmodel::doWherenotExists(
															$schemaname,
															$this->DealeremployeeTable,
															$whereemail,
															'employee_management_id',
															$employee_id);
				$emailidexist 	=	((count($emailresult)>=1)?$emailresult[0]->employee_email_1:'');
				
				if($emailidexist	==	$employee_email)
				{
					return response()->json(['Result'=>'0',
										'message'=>'This Email id is already registered with us!!'
										]);
				}
				//check mobile number id is exist
				$wheremobile 	=	array('employee_moblie_no'=>$employee_mobile);
				$mobileresult 	=	commonmodel::doWherenotExists(
															$schemaname,
															$this->DealeremployeeTable,
															$wheremobile,
															'employee_management_id',
															$employee_id);
				$mobilenumexist 	=	((count($mobileresult)>=1)?$mobileresult[0]->employee_moblie_no:'');
				
				if($mobilenumexist	==	$employee_mobile)
				{
					return response()->json(['Result'=>'0',
										'message'=>'This Mobile number is already registered with us!!'
										]);
				}
				
				if(!empty($contact_image))
				{
					$userimage			=	$setuserimage.$contact_image;
					$base64_img_array 	= 	explode(':', $userimage);
					$img_info 			= 	explode(',', end($base64_img_array));
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
					
					$where 			=	array('employee_management_id'=>$employee_id,'employee_status'=>'active');
					$getresult 		=	branchesmodel::branchlist(
															$schemaname,
															$this->DealeremployeeTable,
															$where
																);
					$imageexplode 	=	((count($getresult)>=1)?$getresult[0]->employee_user_image:'');
					$deletefilename	=	explode('/',$imageexplode,6);
					if(!empty($deletefilename[5]))
					{
						if(file_exists(public_path($deletefilename[5])))
						{
							unlink(public_path($deletefilename[5]));
						}
					}					
					$contactimage   	= 	rand(23232,99999).'.'.$img_file_extension;
					$img_file_name 		= 	public_path().'/uploadimages/'.$schemaname.'/employee/'.$id.'/'.$contactimage;
					$img_file 			= 	file_put_contents($img_file_name, base64_decode($img_info[1]));
					$contactnewimage 	=	url('uploadimages/'.$schemaname.'/employee/'.$id.'/'.$contactimage);
				}
				else
				{
					$contactnewimage  	=	url($cantactnoimage);
				}				
					$where 				=	array('employee_management_id'=>$employee_id);
					$updaterecord		=	array('dealer_id'			=>	$id,
											 'employee_type'			=>	$employee_type,
											 'employee_first_name'		=>	$employee_name,
											 'employee_moblie_no'		=>	$employee_mobile,
											 'employee_email_1'			=>	$employee_email,									 
											 'employee_user_image'		=>	$contactnewimage,
											 'employee_designation' 	=>	$employee_designation,
											 'employee_gender'			=>	$employee_gender
											  );
					
					$updateresult 		=	branchesmodel::UpdateTable(
																	$schemaname,
																	$this->DealeremployeeTable,
																	$updaterecord,
																	$where
																	);
				if($updateresult >= 1)
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
			}	
			return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);	
		}
		
    /*The Function used for view all contact*/
	public function doApiviewemployee()
	{	
		$id						=	Input::get('session_user_id');
		$employee_type			=	Input::get('employee_type');
		if($id == "" || $employee_type == "")
		{
			return response()->json(['Result'=>'0',
								'message'=>'Userid are required'
									]);
		}
		if(Input::get('page_name')	==	'viewemployeelist')
		{
			$schemaname 	=  $this->getschemaname($id);
			if(!empty($schemaname))
			{
				if($employee_type == 0)
				{
					$where 			=	array('employee_status'=>'active');
					$getresult 		=	branchesmodel::branchlist(
															$schemaname,
															$this->DealeremployeeTable,
															$where
																);
				}
				else
				{
					$where 			=	array('employee_type'=>$employee_type,'employee_status'=>'active');
					$getresult 		=	branchesmodel::branchlist(
															$schemaname,
															$this->DealeremployeeTable,
															$where
																);
				}
				$queriesdata 	= 	array();
				$data 			= 	array();
				if(!empty($getresult) && count($getresult) >= 1)
				{
					foreach($getresult as $uservalue)
					{	
						$data['employee_id']        = 	($uservalue->employee_management_id == null?"":$uservalue->employee_management_id);		
						$data['employee_type']      = 	($uservalue->employee_type == null?"":$uservalue->employee_type);				
						$data['employee_name']      = 	$uservalue->employee_first_name.' '.$uservalue->employee_last_name;
						$data['employee_designation']  	= 	($uservalue->employee_designation == null?"":$uservalue->employee_designation);
						$data['employee_gender']  	= 	($uservalue->employee_gender == null?"":$uservalue->employee_gender);
						$data['employee_mobile']  	= 	($uservalue->employee_moblie_no == null?"":$uservalue->employee_moblie_no);
						$data['employee_landline']  = 	($uservalue->employee_landline_no == null?"":$uservalue->employee_landline_no);
						$data['employee_email']  	= 	($uservalue->employee_email_1 == null?"":$uservalue->employee_email_1);
						$data['employee_address']  	= 	($uservalue->employee_mailing_address == null?"":$uservalue->employee_mailing_address);
						$data['employee_location']  = 	($uservalue->employee_mailing_locality == null?"":$uservalue->employee_mailing_locality);
						$data['employee_pincode']  	= 	($uservalue->employee_mailing_pincode == null?"":$uservalue->employee_mailing_pincode);
						if(!empty($uservalue->employee_user_image))
						{
							$data['contactimage']   = 	url(stripcslashes($uservalue->employee_user_image));
						}
						else
						{
							$data['contactimage']   = 	url(Config::get('common.profilenoimage'));
						}
						switch($uservalue->employee_type)
						{
							case 0;
							$data['status']         = 	"All";
							break;
							case 1;
							$data['status']         = 	"Sales Person";
							break;
							case 2;
							$data['status']         = 	"Mechanic";
							break;
							case 3;
							$data['status']         = 	"Store Manager";
							break;
							case 4;
							$data['status']         = 	"Customer Support";
							break;
							case 5;
							$data['status']         = 	"Others";
							break;
						}
						$wherecon 					=	array('employee_management_id'=>$uservalue->employee_management_id);
						$getnameofcontact 			= 	branchesmodel::branchlist($schemaname,
																				$this->DealeremployeedocTable,
																				$wherecon
																				);
			            if(count($getnameofcontact) >= 1)
			            {
							$data['employee_document']  = 	($getnameofcontact[0]->employee_doc_url==null?'':$getnameofcontact[0]->employee_doc_url);
						}
						array_push($queriesdata, $data); 
					}
				}
				return response()->json(['Result'=>'1',
									'message'=>'success',
									'employee_list'=>$queriesdata
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
	
	/*The Function used for view all contact*/
	public function doApisearchemployee()
	{	
		$id						=	Input::get('session_user_id');
		$employee_type			=	Input::get('employee_type');
		$searchemployee			=	Input::get('searchemployee');
		if($id == "" || $employee_type == "" || $searchemployee ==	"")
		{
			return response()->json(['Result'=>'0',
								'message'=>'Userid are required'
									]);
		}
		
		$schemaname 	=  $this->getschemaname($id);
		if(!empty($schemaname))
		{
			if($employee_type == 0)
			{
				$where 			=	array('employee_status'=>'active');
				$getresult 		=	branchesmodel::searchallcolumnemployee(
														$schemaname,
														$where,
														$searchemployee
															);
			}
			else
			{
				$where 			=	array('employee_type'=>$employee_type,'employee_status'=>'active');
				$getresult 		=	branchesmodel::searchallcolumnemployee(
														$schemaname,
														$where,
														$searchemployee
															);
			}
			$queriesdata 	= 	array();
			$data 			= 	array();
			if(!empty($getresult) && count($getresult) >= 1)
			{
				foreach($getresult as $uservalue)
				{	
					$data['employee_id']        = 	($uservalue->employee_management_id == null?"":$uservalue->employee_management_id);		
					$data['employee_type']      = 	($uservalue->employee_type == null?"":$uservalue->employee_type);				
					$data['employee_name']      = 	$uservalue->employee_first_name.' '.$uservalue->employee_last_name;
					$data['employee_designation']  	= 	($uservalue->employee_designation == null?"":$uservalue->employee_designation);
					$data['employee_gender']  	= 	($uservalue->employee_gender == null?"":$uservalue->employee_gender);
					$data['employee_mobile']  	= 	($uservalue->employee_moblie_no == null?"":$uservalue->employee_moblie_no);
					$data['employee_landline']  = 	($uservalue->employee_landline_no == null?"":$uservalue->employee_landline_no);
					$data['employee_email']  	= 	($uservalue->employee_email_1 == null?"":$uservalue->employee_email_1);
					$data['employee_address']  	= 	($uservalue->employee_mailing_address == null?"":$uservalue->employee_mailing_address);
					$data['employee_location']  = 	($uservalue->employee_mailing_locality == null?"":$uservalue->employee_mailing_locality);
					$data['employee_pincode']  	= 	($uservalue->employee_mailing_pincode == null?"":$uservalue->employee_mailing_pincode);
					if(!empty($uservalue->employee_user_image))
					{
						$data['contactimage']   = 	url(stripcslashes($uservalue->employee_user_image));
					}
					else
					{
						$data['contactimage']   = 	url(Config::get('common.profilenoimage'));
					}
					switch($uservalue->employee_type)
					{
						case 0;
						$data['status']         = 	"All";
						break;
						case 1;
						$data['status']         = 	"Sales Person";
						break;
						case 2;
						$data['status']         = 	"Mechanic";
						break;
						case 3;
						$data['status']         = 	"Store Manager";
						break;
						case 4;
						$data['status']         = 	"Customer Support";
						break;
						case 5;
						$data['status']         = 	"Others";
						break;
					}
					$wherecon 					=	array('employee_management_id'=>$uservalue->employee_management_id);
					$getnameofcontact 			= 	branchesmodel::branchlist($schemaname,
																			$this->DealeremployeedocTable,
																			$wherecon
																			);
					if(count($getnameofcontact) >= 1)
					{
						$data['employee_document']  = 	($getnameofcontact[0]->employee_doc_url==null?'':$getnameofcontact[0]->employee_doc_url);
					}
					array_push($queriesdata, $data); 
				}
			}
			return response()->json(['Result'=>'1',
								'message'=>'success',
								'employee_list'=>$queriesdata
								]);	
		}		
		else
		{
			return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
		}	

	}
	/*The Function used for delete contact*/
	public function doApideleteemployee()
	{	
		$id						=	Input::get('session_user_id');
		$employee_id			=	Input::get('employee_id');
		if($id == "" || $employee_id == "")
		{
			return response()->json(['Result'=>'0',
								'message'=>'Employee id is required'
									]);
		}
		if(Input::get('page_name')	==	'deleteemployee')
		{
			$schemaname 			=  $this->getschemaname($id);
			if(!empty($schemaname))
			{
				$where 				=	array('employee_management_id'=>$employee_id);
				$updaterecord		=	array('employee_status'	=>	'deactive');
				$updateresult 		=	branchesmodel::UpdateTable(
															$schemaname,
															$this->DealeremployeeTable,
															$updaterecord,
															$where
															);
				if(!empty($updateresult) && count($updateresult) >= 1)
				{
					$where 				=	array('employee_management_id'=>$employee_id);
					$updaterecord		=	array('employee_document_status'=>'Inactive');
					$updateresult 		=	branchesmodel::UpdateTable(
															$schemaname,
															'dealer_employee_document_management',
															$updaterecord,
															$where
															);
					return response()->json(['Result'=>'3',
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
		else
		{
			return response()->json(['Result'=>'0',
										'message'=>'Invalid Access'
										]);
		}	
	}
	
	 /*The Function used for view allbranch*/
	public function doApiViewTransaction()
	{	
		$id						=	Input::get('session_user_id');
		$offset					= 	Input::get('page_no');      
		if($id == "")
		{
			return response()->json(['Result'=>'0',
								'message'=>'Userid are required'
									]);
		}
		
		$schemaname 	=  $this->getschemaname($id);
		if(!empty($schemaname))
		{
			$curCredit      =   creditmodel::fetchCredit($id);
			$cur_bill_data 	= 	subscriptionmodel::fetch_dealer_billing($id,config::get('common.cur_sub_key'));
			$current_plan   = 	subscriptionmodel::fetch_plandata((!empty($cur_bill_data)?$cur_bill_data->subscription_plan_id:''));
			$cur_detail     = 	array(
									'cur_startdate'=>$cur_bill_data->subscription_start_date,
									'cur_enddate'=>$cur_bill_data->subscription_end_date,
									'cur_credit'=>(!empty($curCredit)?$curCredit[0]->credit_balance:'')
									);
			$pageno 				=	$offset*10;
			$fetch_dealerdata   	= 	branchesmodel::fetch_dealer_allbilling($id,$pageno);
			if(!empty($fetch_dealerdata))
			{
				foreach($fetch_dealerdata as $key)
				{
					$fetch_plan  	= 	subscriptionmodel::fetch_plandata($key->subscription_plan_id);
					$key->planname 	= 	$fetch_plan['plan_type_name'];
				}
			}
			
			return response()->json(['Result'=>'1',
								'message'=>'success',
								'dealer_billing'=>$fetch_dealerdata,
								'current_detail'=>$cur_detail,
								'current_plan'=>$current_plan
								]);	
		}	
		return response()->json(['Result'=>'0',
									'message'=>'Invalid Access'
									]);	

	}
	
	 //GET SCHEMA NAME FUNCTION
    public function getschemaname($id)
    {
		$getdealer_schemaname 	  		=	branchesmodel::masterFetchTableDetails(
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
	//THIS FUNCTION USED FOR UPLOAD IMAGE
	public function doApiuploadcompanycoverimage($imagename,$schemaname)
	{
		$setuserimage 		= 	'data:image/png;base64,';
		$userimage			=	$setuserimage.$imagename;
		$base64_img_array 	= 	explode(':', $userimage);
		$img_info 			= 	explode(',', end($base64_img_array));
		$img_file_extension = 	'';
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
		
		$contactimage   		= 	rand(23232,99999).'.'.$img_file_extension;
		if(file_exists(public_path('/uploadimages/'.$schemaname.'/companylogo/')))
		{
			$img_file_name 		= 	public_path().'/uploadimages/'.$schemaname.'/companylogo/'.$contactimage;
			$img_file 			= 	file_put_contents($img_file_name, base64_decode($img_info[1]));
			$contactnewimage 	=	url('uploadimages/'.$schemaname.'/companylogo/'.$contactimage);
			return $contactnewimage;
		}
		else
		{
			File::makeDirectory(public_path('/uploadimages/'.$schemaname.'/companylogo/'), 0777, true, true);
			$img_file_name 		= 	public_path().'/uploadimages/'.$schemaname.'/companylogo/'.$contactimage;
			$img_file 			= 	file_put_contents($img_file_name, base64_decode($img_info[1]));
			$contactnewimage 	=	url('uploadimages/'.$schemaname.'/companylogo/'.$contactimage);
			return $contactnewimage;
		}
	}
	
	//THIS FUNCTION USED FOR UPLOAD IMAGE
	public function doApiuploadresizeimage($imagename,$schemaname)
	{
		$setuserimage 		= 	'data:image/png;base64,';
		$userimage			=	$setuserimage.$imagename;
		$base64_img_array 	= 	explode(':', $userimage);
		$img_info 			= 	explode(',', end($base64_img_array));
		$img_file_extension = 	'';
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
		
		$contactimage   		= 	rand(23232,99999).'.'.$img_file_extension;
		$destinationPath 		= 	public_path().'/uploadimages/'.$schemaname.'/companylogo/watermark/';
		$img 					=	Image::make(base64_decode($imagename));		
		$contactnewimage 		=	url('uploadimages/'.$schemaname.'/companylogo/watermark/'.$contactimage);
		if(file_exists(public_path('/uploadimages/'.$schemaname.'/companylogo/watermark/')))
		{
			$img->opacity(40);
			$img->resize(100, 100, function ($constraint) {
				$constraint->aspectRatio();
			})->save($destinationPath.$contactimage);
			return $contactnewimage;
		}
		else
		{
			File::makeDirectory(public_path('/uploadimages/'.$schemaname.'/companylogo/watermark/'), 0777, true, true);
			$img->opacity(40);
			$img->resize(100, 100, function ($constraint) {
				$constraint->aspectRatio();
			})->save($destinationPath.$contactimage);
			return $contactnewimage;
		}
	}
}
