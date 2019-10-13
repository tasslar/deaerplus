<?php
/*
  Module Name : Manage 
  Created By  : Sreenivasan  27 -12-2016
  Use of this module is manage users
*/
namespace App\Http\Controllers;

use Session;
use Redirect;
use Config;
use App\model\usersmodel;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\model\branchesmodel;
use App\model\smsmodel;
use App\model\dealermodel;
use App\model\emailmodel;
use App\model\employeemodel;
use App\model\notificationsmodel;
use App\model\commonmodel;
use App\model\subscriptionmodel;
use App\Exception\CustomException;
/*use App\Http\Controllers\CustomException;*/

/**
* 
*/
class user extends Controller
{
	public $active_menu_name;
	public $header_data;
	public $side_bar_active;
	public $side_bar_customer;
	public $login_authecation;
	public $p_id;
	public $id;
	public $dmsusertable;
	public function __construct()
    {    
    	
    	$this->active_menu_name  		='manage_menu';		
    	$this->side_bar_active    		='user';    
    	$this->masterMainLoginTable   = 'dms_dealers';
    	$this->dmsusertable	        ='user_account';
    	$this->middleware(function ($request, $next) 
	    	{
		    	$this->id                     = session::get('ses_id');
		    	$this->p_id                   = dealermodel::parent_id($this->id);
		        $this->login_authecation    = session()->has( 'ses_dealername' ) ? session()->get( 'ses_dealername' ) :  Redirect::to('login')->send();
				$this->header_data      = commonmodel::commonheaderdata();
				$this->header_data['title']='Manage';
				$this->header_data['p_id']   =$this->p_id;
		        return $next($request);
	        }
        );       						
    }


	/*The Function used for AddUser view*/

	public function adduser()
	{
		$user_role					   	= commonmodel::user_role()->get();
		$user_role                      = usersmodel::user_type();
		$exist_plan                     = subscriptionmodel::select_user_list(Session::get('ses_id'),1);	
		$max_user = $exist_plan->max_users;
		$branches = branchesmodel::branch()->get();
		/*echo "<pre>";
		print_r($branches);
		exit;*/
		$compact_array                 	= array
											(
												'active_menu_name'=>$this->active_menu_name,									

												'side_bar_active'=>$this->side_bar_active,

												'user_role'	=> $user_role,

												'max_user' =>$max_user,

												'branches' =>$branches
											);												

		$header_data        	 	   = $this->header_data;										
		return view('adduser',compact('compact_array','header_data'));
	}
	
	public function insertuser()
	{		
		try
        {

		$dealer_id                  	= branchesmodel::branchId(); 
		$email 							= Input::get('user_email');
		$user_name						= Input::get('user_name');	
		$moblie_no						= Input::get('user_moblie_no');	
		$schema_name					= session()->get( 'dealer_schema_name' );	
		$user_role                      = Input::get('user_role');
		if($user_name== "" || $email== "" || $moblie_no==""|| $user_role == "")
            {
                 Session::flash('message', "All fields are required");
                 return Redirect::back()->withInput();
            }
            if($user_role == 1)
            {
            	 Session::flash('message', "Wrong Method");
                 return Redirect::back()->withInput();
            }
		/*echo $user_name;
		exit;*/
		$dealer_logo            =  url(Config::get('common.profilenoimage'));
		$dealerdata 		    =    array
												(
													'parent_id'=>$dealer_id,
													'dealer_name'=>Input::get('user_name'),					
													'logo'=>$dealer_logo,	
													'd_mobile'=>$moblie_no,
													'd_email'=>$email, 
													'dealer_schema_name'=>$schema_name,
													'activation_status' => 'Inactive'							
												);												
		$checkusermail =  dealermodel::selectRaw("Count(*) as Total")
                                     ->where('d_email',"=",$email)
                                     ->first();

        $checkusermoblie_no =  dealermodel::selectRaw("Count(*) as Total")
                                     ->where('d_mobile',"=",$moblie_no)
                                     ->first();

        $user_table = usersmodel::user_table()->where('user_email',$email)->count();

        $user_moblie_no_valid = usersmodel::user_table()->where('user_moblie_no',Input::get('user_moblie_no'))->count();


        if(($user_moblie_no_valid > 0)||intval($checkusermoblie_no->Total)>0)
        {
        	 Session::flash('message-err', "The Entered Moblie No is already registered.");
            return Redirect::back()->withInput();
        }
        else if((intval($checkusermail->Total)>0) || ($user_table > 0))
        {
        	 Session::flash('message-err', "The Entered Email-id is already registered.");
            return Redirect::back()->withInput();
        }
        else
        {
        	$master_dealer			= dealermodel::dealer_register($dealerdata);
			$id 					        = $master_dealer;
			if($master_dealer)
				{

					$user_data 				= array
												(													
													'dealer_id'=>$master_dealer, 
													'dealer_id'=>$id,
													'branch_id'=>'', 
													'user_name'=>Input::get('user_name'),
													'user_moblie_no'=>Input::get('user_moblie_no'),
													'user_email'=>Input::get('user_email'), 
													'user_role'=>Input::get('user_role')		
												);
					$adduser 				= usersmodel::user_table()->insertGetId($user_data);											
				}		
			$sms_template_data				= config::get('common.welcome_sms_id');
			$sms_data 						= array
											(
												'phone' => Input::get('user_moblie_no'),

												'sms_template_data' => smsmodel::get_sms_templates($sms_template_data)
											);
			$sms_send						= smsmodel::sendsms($sms_data);	
			$dealer_name					= $this->login_authecation;
			$welcome_email_template_id      = config::get('common.user_email_id');
	    	$email_template_data            = emailmodel::get_email_templates($welcome_email_template_id);


	    	foreach ($email_template_data as $row) 
	        {
	            $mail_subject  			=  $row->email_subject;
	            $mail_message  			=  $row->email_message;
	            $mail_params  			=  $row->email_parameters; 	          
	        }
	        	

				

	    	$url                    =    url("usermail/".encrypt($id));	    
	   		$data                   =    array
	   											(
			                                        '0'=>$user_name,
			                                        '1'=>$dealer_name,
			                                        '2'=>$email,
			                                        '3'=>$url,
			                                    );

	   		$email_template         =    emailmodel::emailContentConstruct($mail_subject,$mail_message,$mail_params,$data);

	    	$email_sent             =    emailmodel::email_sending($email,$email_template);
	    		/*exit;*/				
	   }
	}
      catch(Exception $e){
          throw new CustomException($e->getMessage());
      }
      //Session::flash('sucess_msg', "Successfully updated.");
		Session::flash('sucess_msg', "Successfully Added Your User.");				
		return redirect('manageuser');
	}

	/*The Function used for edituser view*/

	public function edituser()
	{
		try
        { 
			$edit_user_id 				    = Input::get('edit_id');
			$fetch_user					    = usersmodel::user_table()->where('user_id',$edit_user_id)->delete();
			Session::flash('sucess_msg', "Deleted Successfully.");				
			return redirect('manageuser');		
		}
      	catch(Exception $e)
      	{
          throw new CustomException($e->getMessage());
      	}
		
	}	

	/*The Function used for UpdateUser view*/

	public function updateuser()
	{
		//dd($_POST);
		$user_id                        = Input::get('user_id');
		$user_email                     = Input::get('user_email');		
		$user_mob                       = Input::get('user_mob');		
		$user_name                      = Input::get('user_name');
		//dd($user_email);		
		$get_user                       = usersmodel::useremail_id($user_email);
		//dd($get_user);
      	$dealer_id                      = $get_user->d_id;
		$user_data 						= array
											(
												'dealer_id'=>session::get('d_id'), 
												'branch_id'=>'', 
												'user_name'=>$user_name,
												'user_moblie_no'=>$user_mob,
											);
		$dealer_value                   = array(
													'dealer_name' => $user_name,
													'd_mobile'=>$user_mob
												);
		$update_user                    = usersmodel::user_table()->where('user_id',$user_id)->update($user_data);
		$dealertableupdate              = dealermodel::dealerupdate($dealer_id,$dealer_value);
		Session::flash('sucess_msg', "Successfully updated.");
		return redirect('manageuser');
	}

	/*The Function used for Delete view*/

	public function deleteuser()
	{		
		$id                             = session::get('ses_id');		
		$delete_user_id  				= Input::get('delete_user');	
		$dealer_id  					= Input::get('delete_dealer');			
		$exist_plan                     =  subscriptionmodel::select_user_list(Session::get('ses_id'),1);
		$limited_users 				    = usersmodel::user_table()->count(); 		
		$max_user = $exist_plan->max_users;		
		$check_user_status 					= usersmodel::user_table()->where('status','Active')->count();
		$check_user_active 					= usersmodel::user_table()->where('status','Active')->where('user_id',$delete_user_id)->count();
		$check_dealer_status 					= usersmodel::dms_dealers()->where('parent_id',$id)->where('status','Active')->count();	
		if($check_user_active == 1)
		{
			$update_staus = array
									(
										'status' => 'Inactive'
									);
			$value        = 0; 	
			$update_user_status 					= usersmodel::user_table()->where('user_id',$delete_user_id)->update($update_staus);
			$update_dealer_status 					= usersmodel::dms_dealers()->where('d_id',$dealer_id)->update($update_staus);						
		}
		elseif ($check_user_status < $max_user) 
		{
			$update_staus = array
									(
										'status' => 'Active'
									);
			$value        = 1;

			$update_user_status 					= usersmodel::user_table()->where('user_id',$delete_user_id)->update($update_staus);
			$update_dealer_status 					= usersmodel::dms_dealers()->where('d_id',$dealer_id)->update($update_staus);
			
		}
		else
		{
			$value  =2;
		}	
		return $value;	
	}

	public function manage_list()
	{
		$id                             = session::get('ses_id');
		$dealer_schemaname              = $this->getschemaname($id);
		$customer                       = $this->side_bar_active;				
    	$fetch_user                     = usersmodel::select_all_user($dealer_schemaname,$this->dmsusertable);     	
    	$fetch_user_count               = usersmodel::user_count($dealer_schemaname,$this->dmsusertable);    
    	$total_count                    = $fetch_user_count;   
    	$user_type                      = usersmodel::user_type();
    	$exist_plan                     =  subscriptionmodel::select_user_list(Session::get('ses_id'),1);
    	$limited_users 	                = usersmodel::user_table()->where('status','Active')->count();
		$max_user                       = $exist_plan->max_users;

    	foreach ($user_type as $key) 
            {
                               
                $user_type_count    = usersmodel::user_type_count($dealer_schemaname,$this->dmsusertable,$key->master_role_id);
                if($key->master_role_name=='All')
                {
                    $key->type_count     = $total_count;     
                }
                else
                {
                    $key->type_count     =$user_type_count;  
                }  
            }              
    	$compact_array                  = array
											(
												'active_menu_name'=>$this->active_menu_name,

												'side_bar_active'=>$customer,
																
												'fetch_add_leads_active' =>$customer,

												'user_type'=>$user_type,

												'limited_users' =>$limited_users,

												'max_user'    =>$max_user,

												'exist_plan'=>$exist_plan,

												'total_count' =>$total_count

											);	
											/*echo "<pre>";
											print_r($compact_array['employee_type']);
											exit;*/
		$header_data        	  		= $this->header_data;
		return view('user_list',compact('compact_array','header_data'));
	}

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

	public function user_curl()
	{		

			$ch = curl_init();			
			curl_setopt($ch, CURLOPT_URL,"http://52.221.57.201/dev/public/ninja/public/users");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,
            	"first_name=sreenivasan&last_name=vasan&email=sreenivasan057@gmail.com");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$server_output = curl_exec ($ch);
			if ($server_output == "OK")
			 { 
			 	return $server_output;
			 } 
			 else
			 {
			 	 return "fail";
			 }
			
			
			curl_close ($ch);
			

	}
	public function douserresetpassword()
      {
      	  $user_email_id            = Input::get('user_email');
      	  $get_user                 = usersmodel::useremail_id($user_email_id);
      	  $user_id                  = $get_user->d_id;
          $passwordclear            = usersmodel::passwordclear($user_id);          
          $email_template_data      = emailmodel::get_email_templates("2");
          //dd($email_template_data);
          foreach ($email_template_data as $row) 
          {
              $mail_subject  =  $row->email_subject;
              $mail_message  =  $row->email_message;
              $mail_params   =  $row->email_parameters; 
          }
          $url               =   url("changepassword/".encrypt($get_user->d_id));
          $data              =   array(
                                          '0'=>$url,
                                          '1'=>$get_user->dealer_name,
                                          '2'=>$get_user->d_email,
                                          '3'=>"",
                                          '4'=>"",
                                          'id'=>$get_user->d_id
                                      );
          $email_template    =   emailmodel::emailContentConstruct($mail_subject,$mail_message,$mail_params,$data);
          $email_sent        =   emailmodel::email_sending($get_user->d_email,$email_template);
          $email_update      =   dealermodel::where('d_email', '=', $get_user->d_email)
                                      ->update(['activation_status'=>'Inactive']);
          Session::flash('sucess_msg', "Password link has been sent to your mail id. Reset your password and login again.");
          return redirect('manageuser');
      }

}