<?php

namespace App\Http\Controllers;

/*
  Module Name : Manage 
  Created By  : Sreenivasan  26-12-2016
  Use of this module is Branches
*/

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\branch as branchvalidation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use App\model\branchesmodel;
use App\model\commonmodel;
use App\model\notificationsmodel;
use App\model\dealermodel;
use App\model\dms_master_dealer_data;
use Illuminate\Support\Facades\Auth;
use App\model\site_searchmodel;
use App\User;
use Config;
use Redirect;
use Session;
use Illuminate\Contracts\Encryption\DecryptException;

/**
* 
*/
class branch extends Controller
{
	public $masterMainLoginTable;
	public $active_menu_name;
	public $header_data;
	public $side_bar_active;
	public $login_authecation;
	public $p_id;
	public $id;
	public $dmsbranchtable;
	public function __construct()
    {    
    	$this->active_menu_name       ='manage_menu';		
    	$this->side_bar_active        ='branch';
    	$this->masterMainLoginTable   = "dms_dealers";
    	$this->dmsbranchtable 		  = "dms_dealer_branches";
    	$this->middleware(function ($request, $next) 
    	{
	    	$this->id                     = session::get('ses_id');
	     	$this->p_id                   = dealermodel::parent_id($this->id);
        	$this->login_authecation      = session()
        								->has( 'ses_dealername' ) ? session()
        								->get( 'ses_dealername' ) :  Redirect::to('login')
        								->send();
		$this->header_data            = commonmodel::commonheaderdata();
		$this->header_data['title']   ='Manage';
		$this->header_data['p_id']   =$this->p_id;
        return $next($request);
        }
        );
    }

    /*The Function used for view addbranch blade*/

	public function addBranches()
	{		
		try
     	{
     		$id                   = session::get('ses_id');
     		$dealer_schemaname    = $this->getschemaname($id);     		
			$mapAddress			  =	config::get('common.map');		
			$state     			  = commonmodel::get_master_state();		
			$city     			  = commonmodel::get_master_city();	
			$headquarter_count    = branchesmodel::headquarter_count($dealer_schemaname,$this->dmsbranchtable);
			$compact_array      	  = array
											(
												'active_menu_name'=>$this->active_menu_name,
											 	'side_bar_active'=>$this->side_bar_active,
											 	'map'	=>	$mapAddress,
											 	'state' => $state,
											 	'city' =>$city,
											 	'headquarter_count' =>$headquarter_count
											);				
											/*echo "<pre>";			
											print_r($compact_array['headquarter_count']);
											exit;*/
			$header_data        	  = $this->header_data;	
		}
		catch(Exception $e){
          	throw new CustomException($e->getMessage());
     	} 			
		
		return view('add_branch',compact('compact_array','header_data'));		
	}

	/*The Function used for fetch city in table*/

	public function fetch_city()
	{
		$state = Input::get('state');
		$citys = commonmodel::master_citys($state);
		echo json_encode($citys);
	}

	/*The Function used for store info */

	public function storeBranches(branchvalidation $request)
	{
		try
     	{
     		$id                   = session::get('ses_id');
     		$dealer_schemaname    = $this->getschemaname($id);
     		$dealer_name       = Input::get('dealer_name');
     		$dealer_contact_no = Input::get('dealer_contact_no');
     		$branch_address    = Input::get('branch_address');
     		$dealer_state      = Input::get('dealer_state');
     		$dealer_city       = Input::get('dealer_city');
     		$dealer_pincode    = Input::get('dealer_pincode');
     		$dealer_mail        = Input::get('dealer_mail');

     		/*if($dealer_name== "" || $dealer_contact_no== "" || $branch_address== ""|| $dealer_state== ""|| $dealer_city== "" ||$dealer_pincode== "")
		    {		    	
		    	if($dealer_name =="")
		    	{
		    		$dealer_name       = "Enter The Dealer Name";		    	
		    		Session::flash('message', $dealer_name);
		         	return Redirect::back();	
		    	}
		    	elseif($dealer_contact_no =="")
		    	{
		    		$dealer_contact_no    = "Enter The Contact NO";		    	
		    		Session::flash('message', $dealer_contact_no);
		         	return Redirect::back();	
		    	}		    	
		    	elseif($branch_address =="")
		    	{
		    		$branch_address    = "Enter The Address";		    	
		    		Session::flash('message', $branch_address);
		         	return Redirect::back();	
		    	}		  
		    	elseif($dealer_state =="")
		    	{
		    		$dealer_state         = "Enter The State";		    	
		    		Session::flash('message', $dealer_state);
		         	return Redirect::back();	
		    	}	  
		    	elseif($dealer_city =="")
		    	{
		    		$dealer_city          = "Enter The City";		    	
		    		Session::flash('message', $dealer_city);
		         	return Redirect::back();	
		    	}	
		    	elseif($dealer_pincode== "")
		    	{
		    		$dealer_pincode          = "Enter The Pincode";		    	
		    		Session::flash('message', $dealer_pincode);
		         	return Redirect::back();	
		    	}	
		    	else
		    	{			    	
		        	Session::flash('message', "All fields are required");
		         	return Redirect::back();
		     	}
		    }	*/
		    $headquarter = Input::has('headquarter');		
     		if(!empty($headquarter))
			{
				$headquarter       =1;
			}
			else
			{
				$headquarter       = 0;
			}	
			/*echo $headquarter;
			exit;*/		
			$model_branches		  = branchesmodel::branch();
			$head_count      = branchesmodel::headquarter_count($dealer_schemaname,$this->dmsbranchtable);
			$id 				  = branchesmodel::branchId();
			if(Input::has('dealer_service'))
			{
				$dealer_service = 1;
			}	
			else
			{
				$dealer_service = 0;
			}
			
			$insertrecord		  = array(
											'dealer_id'=>$id,
											'dealer_name'=>$dealer_name,
											'dealer_contact_no'=>$dealer_contact_no,
											'branch_address'=>$branch_address,
											'dealer_state'=>$dealer_state,
											'dealer_city'=>$dealer_city,
											'dealer_pincode'=>$dealer_pincode,
											'dealer_mail'=>$dealer_mail,			
											'headquarter'=>$headquarter,			
											'dealer_service'=>$dealer_service
										);
			$insert_branches      = branchesmodel::InsertTable($dealer_schemaname,$this->dmsbranchtable,$insertrecord); 			
			$tags		          = array
										(
											'dealer_id'=>$id,
											'dealer_name'=>$dealer_name,
											'dealer_contact_no'=>$dealer_contact_no,
											'branch_address'=>$branch_address,
											'dealer_state'=>(int) $dealer_state,
											'dealer_city'=>(int) $dealer_city,
											'dealer_pincode'=>(int) $dealer_pincode,
											'dealer_mail'=>$dealer_mail,			
											'headquarter'=>(int) $headquarter,			
											'dealer_service'=>(int) $dealer_service
										);	
			$pushtype  = 'insert';
			$url       = 'http://52.221.57.201/addbranches';
			$cat_id    = 'manage';
			$sub_id	   = 'branch'; 
			$d_id      = $id;  
			$auto_id   = $insert_branches;
			$push      = site_searchmodel::site_serach($tags,$pushtype,$url,$cat_id,$sub_id,$d_id,$auto_id) ;
			}	
			catch(Exception $e){
          	throw new CustomException($e->getMessage());
     	} 				
			Session::flash('successdata', "Successfully Added Your Branch.");			
			return redirect('managebranches');		
	}

	/*The Function used for Manage Branch*/

	public function manageBranches()
	{	
		try
	     	{
			$manage_branch 		      = branchesmodel::branch()->paginate(10);		
			$manage_branch_count 	  = branchesmodel::branch()->count();
			$state     			      = commonmodel::get_master_state();
			$city     			      = commonmodel::get_master_city();	
			$p_id                     = $this->p_id;
			/*echo $id = $this->id;
			echo "<pre>";
			print_r($p_id);
			exit;*/
			if(!empty($manage_branch_count))
			{
				$branch_null = "1";
			}
			else
			{
				$branch_null ="0";
			}
			$compact_array            = array
											(
												'active_menu_name'=>$this->active_menu_name,
												'side_bar_active'=>$this->side_bar_active,	
												'manage_branch' => $manage_branch,
												'branch_null'	=> $branch_null,
												'state'         => $state,
												'city'          => $city,
												'p_id' 			=>$p_id
											);
			$header_data        	  = $this->header_data;		
		}
			catch(Exception $e){
          	throw new CustomException($e->getMessage());
     	} 		
		return view('manage_branch',compact('compact_array','header_data'));

	}

	/*The Function used for edit Branches*/

	public function editBranches($branchid="")
	{		
		try
	    {
	    	$branchId 				= decrypt($branchid);
	    	$id                   = session::get('ses_id');
     		$dealer_schemaname    = $this->getschemaname($id);
			$edit_id 			      = 	$branchId;	
			$where                = array('branch_id'=>$edit_id);		
			$branch_detail            = branchesmodel::select_branch($dealer_schemaname,$this->dmsbranchtable,$edit_id);
			$headquarter_counts        = branchesmodel::branch()->where('headquarter',1)->count();
			$headquarter_count        = $branch_detail->headquarter;
			if($headquarter_count == 1)
			{
				$headquarter = 1;
			}
			else
			{
				$headquarter = 'NULL';	
			}
			$mapAddress			 	  =	$branch_detail->dealer_city.','.$branch_detail->branch_address.','.$branch_detail->dealer_state.'.'.$branch_detail->dealer_pincode;	
			$branch_detail->map     = $mapAddress;
			$state     			      = commonmodel::get_master_state();
			$city     			      = commonmodel::get_master_city();
			$compact_array            = array
											(
												'active_menu_name'=>$this->active_menu_name,
												'side_bar_active'=>$this->side_bar_active,
												'branch_detail'=> $branch_detail,
												'state' => $state,
											 	'city' =>$city,
											 	'headquarter_count'=>$headquarter,
											 	'total_headquarter'=>$headquarter_counts	
											);			
											
			$header_data        	  = $this->header_data;
			return view('edit_branch',compact('compact_array','header_data'));
		}
		catch(Exception $e){
          	throw new CustomException($e->getMessage());
     	}
	}
	/*The Function used for update branches*/
	
	public function updateBranches(branchvalidation $request)
	{			
		try
	    {
	    	// if(!empty(Input::get('dealer_pincode')))
	    	// {
	    	// 	return redirect()->back();
	    	// }
			$edit_id                  = Input::get('update_branch_id');
			$id 		     		  = branchesmodel::branchId();
			if(Input::has('headquarter'))
			{
				$headquarter       =1;
			}
			else
			{
				$headquarter       = 0;
			}
			$model_branches		  = branchesmodel::branch();
			$head_count      = $model_branches->where('headquarter',1)->count();
			/*if($head_count == $headquarter)
			{
				Session::flash('headquarter', "Already headquarter used");			
				return Redirect::back();
			}*/
			$id 				  = branchesmodel::branchId();
			if(Input::has('dealer_service'))
			{
				$dealer_service = 1;
			}	
			else
			{
				$dealer_service = 0;
			}				
			$update_branch            = array(
										'dealer_name'=>Input::get('dealer_name'),
										'dealer_contact_no'=>Input::get('dealer_contact_no'),
										'branch_address'=>Input::get('branch_address'),
										'dealer_state'=>Input::get('dealer_state'),
										'dealer_city'=>Input::get('dealer_city'),
										'dealer_pincode'=>Input::get('dealer_pincode'),
										'dealer_mail'=>Input::get('dealer_mail'),
										'dealer_service'=>$dealer_service,
										'headquarter'=>$headquarter,
											);		
			$update_branch 		      = branchesmodel::branch()
										  ->where('branch_id',$edit_id)
										  ->update($update_branch);
			$tags		          = array
										(
											'dealer_name'=>Input::get('dealer_name'),
											'dealer_contact_no'=>Input::get('dealer_contact_no'),
											'branch_address'=>Input::get('branch_address'),
											'dealer_state'=>Input::get('dealer_state'),
											'dealer_city'=>Input::get('dealer_city'),
											'dealer_pincode'=>Input::get('dealer_pincode'),
											'dealer_mail'=>Input::get('dealer_mail'),
											'dealer_service'=>$dealer_service,
											'headquarter'=>$headquarter,
										);	
			$pushtype  = 'update';
			$url       = 'http://52.221.57.201/editbranches';
			$cat_id    = 'manage';
			$sub_id	   = 'branch'; 
			$d_id      = $id;  
			$auto_id   = $edit_id;
			$push      = site_searchmodel::site_serach($tags,$pushtype,$url,$cat_id,$sub_id,$d_id,$auto_id) ;			
			
		}
		catch(Exception $e){
          	throw new CustomException($e->getMessage());
     	} 	
		Session::flash('editdata', "Successfully Edited");
		return redirect('managebranches');	
	}

	/*The Function used for Delete branches*/

	public function delete_branch()
	{		
		try
	    {
			$id 				  = branchesmodel::branchId();
			$delete_id			  = Input::get('delete_id');
			$branch_detail        = branchesmodel::branch()->where('branch_id',$delete_id)->delete();
			$tags		          = array
									(
									);	
				$pushtype  = 'delete';
				$url       = '';
				$cat_id    = 'manage';
				$sub_id	   = 'branch'; 
				$d_id      = $id;  
				$auto_id   = $delete_id;
				$push      = site_searchmodel::site_serach($tags,$pushtype,$url,$cat_id,$sub_id,$d_id,$auto_id) ;
		}
		catch(Exception $e){
          	throw new CustomException($e->getMessage());
     	}
		Session::flash('faildata', "Successfully Deleted");			
		return redirect('managebranches');
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
}