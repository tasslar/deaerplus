<?php

/*
  Module Name : Manage 
  Created By  : Sreenivasan  26 -12-2016
  Use of this module is manage leads,customer,contact
*/
namespace App\Http\Controllers;

use Session;
use Redirect;
use Config;
use App\model\branchesmodel;
use App\model\employeemodel;
use App\model\fileuploadmodel;
use App\model\commonmodel;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\model\contactsmodel;
use App\model\notificationsmodel;
use App\model\dealermodel;
use Illuminate\Support\Facades\Validator;
/**
* 
*/
class employee extends Controller
{
	public $active_menu_name;
	public $header_data;
	public $side_bar_active;
	public $side_bar_customer;
	public $login_authecation;
	public $p_id;
  	public $id;
	public function __construct()
    {    
    	$this->active_menu_name  		= config::get('common.manage_menu');		
    	$this->side_bar_active    		= config::get('common.employee');
    	$this->middleware(function ($request, $next) 
	    	{
	    		$this->id                     = session::get('ses_id');
    			$this->p_id                   = dealermodel::parent_id($this->id);
		        $this->login_authecation= session()->has( 'ses_dealername' ) ? session()->get( 'ses_dealername' ) :  Redirect::to('login')->send();
				$this->header_data      = commonmodel::commonheaderdata();
				$this->header_data['title']='Manage';
				$this->header_data['p_id']   =$this->p_id;
				$this->dealer_schemaname    = (new branch)->getschemaname($this->id);
		        return $next($request);
	        }
        );       						
    }
    
    /*The Function used for ManageEmployee addpage view*/

    public function domyemployee()
    {
    	$employee 						= $this->side_bar_active;
    	$employee_type                  = employeemodel::employee_type();
    	$city 							= commonmodel::get_master_city();
    	$state     			            = commonmodel::get_master_state();
    	$compact_array                  = array
											(
												'active_menu_name'=>$this->active_menu_name,

												'side_bar_active'=>$employee,									

												'employee_type' => $employee_type,

												'city'=>$city,

												'state'=>$state,											
											);
		/*echo "<pre>";  
    	print_r($compact_array['state']);
    	exit;*/
		$header_data        	  		= $this->header_data;	
    	return view('myemployee',compact('compact_array','header_data'));
    }

   
    /*The Function used for ManageEmployee insert*/

    public function doinsertEmployee(Request $request)
    {
    	try
    	{
    		//This code is written for checking validation 
    		$validationcheck  = Validator::make($request->all(),[
                "contact_type_id" 			=> "required",
                "contact_first_name" 		=> "required",
                //"contact_last_name"  		=> "required",
                "contact_phone_1" 	 		=> "required",
                //"contact_phone_2" 	 	=> "required",
                "contact_email_1"  	 		=> "required",
                //"mailing_address" 	 		=> "required",
                //"contact_mailing_pincode" 	=> "required",
                //"contact_image" 			=> "required",
            ]);
	        if ($validationcheck->fails())
	        {
	            $result['error'] = $validationcheck->errors();
	            return response()->json($result,400);
	        }
	        //validation Finished
	        $id                  			= branchesmodel::branchId(); 
			$dealer_schema_name             = session()->get( 'dealer_schema_name' );		
	        $userimage                      = $request->file('contact_image');	
			if(!empty($userimage))
			{
		        $path                       = public_path('uploadimages'.'/'.$dealer_schema_name.'/'.'employee'.'/'.$id.'/');
				$image                      = fileuploadmodel::profile_upload($userimage,$path);
		        $paths                      = url('uploadimages'.'/'.$dealer_schema_name.'/'.'employee'.'/'.$id.'/');
		    }
		    else
		    {
		    	$image = "";
		    	$paths = "";
		    }
		    $employee_first_name            = Input::get('contact_first_name');
		    $employee_last_name             = Input::get('contact_last_name');
		    $employee_designation           = Input::get('contact_designation');
		    $employee_gender                = Input::get('contact_gender');
		    $employee_phone_1               = Input::get('contact_phone_1');
		    $employee_phone_2               = Input::get('contact_phone_2');
		    $employee_email_1               = Input::get('contact_email_1');
		    $employee_email_2               = Input::get('contact_email_2');
		    $mailing_address                = Input::get('mailing_address');
		    $employee_locality              = Input::get('mailing_locality');
		    $employee_state                 = Input::get('employee_mailing_state');
		    $employee_mailing_city           = Input::get('employee_mailing_city');
		    $employee_mailing_pincode       = Input::get('contact_mailing_pincode');
		    $employee_business_name         = Input::get('contact_business_name');
		    $employee_type_id               = Input::get('contact_type_id');	
		    $employee_insert = Input::get('employee_insert');
		    if(!empty($employee_insert))
		    {
				$insert_employee_id  =  $employee_insert;
		    }
		    else
		    {
	    		$insert_employee_id           = employeemodel::employeetable()
	    											->insertGetId(['dealer_id'=>$id]);
	    	}
			$employee_data 				    = array
											(
												'dealer_id'=>$id, 
												'branch_id'=>'',
												'employee_first_name'=>$employee_first_name, 
												'employee_last_name'=>$employee_last_name,
												'employee_designation'=>$employee_designation,
												'employee_gender'=>$employee_gender,
												'employee_moblie_no'=>$employee_phone_1,
												'employee_landline_no'=>$employee_phone_2,	
												'employee_email_1'=>$employee_email_1,
												'employee_email_2'=>$employee_email_2,
												'employee_mailing_address'=>$mailing_address,
												'employee_mailing_locality'=>$employee_locality,
												'employee_city'=>$employee_mailing_city,
												'employee_state'=>$employee_state,
												'employee_mailing_pincode'=>$employee_mailing_pincode,
												'employee_business_name'=>$employee_business_name,
												'employee_user_image'=>$paths.'/'.$image,
												'employee_type'=>$employee_type_id
											);  
			$insert_employee_data           = employeemodel::employeetable()
												->where('employee_management_id',$insert_employee_id)
												->update($employee_data);
			return $insert_employee_id;
    	}
    	catch(Exception $e){
            throw new CustomException($e->getMessage());
        }
    }

    public function doinsert_document(Request $request)
    {
    	$id                             = Session::get('ses_id');
        $last_id                        = Input::get('last_id');  
        if($last_id == '')
        {
            return Redirect::back()->with('message', 'Wrong Method');;
        }            
        $userimage                      = Input::file('employee_document');
        $dealer_schema_name             = session()->get( 'dealer_schema_name' );
    	if(count($last_id)!= null)
		{				
			$emp_document_insert        = employeemodel::employeedocumenttable()
											->insertGetId([
															'employee_management_id'=>$last_id, 
															'employee_document_id_type'=>Input::get('document_id_type'),
															'employee_document_id_number'=>Input::get('document_id_number'),
															'employee_document_dob'=>Input::get('document_dob'),
														]); 	
			if(!empty($userimage))
			{
				$fileOrginalName                = $request->file('employee_document')->getClientOriginalName();
		        $path                       = public_path('uploadimages'.'/'.$dealer_schema_name.'/'.'employee'.'/'.$id.'/'.'document'.'/');	
				$image                      = fileuploadmodel::profile_upload($userimage,$path);
		        $paths                      = url('uploadimages'.'/'.$dealer_schema_name.'/'.'employee'.'/'.$id.'/'.'document'.'/');
		        $emp_document_insert        = employeemodel::employeedocumenttable()
		        								->where('dealer_employee_doc_mgmt_id',$emp_document_insert)
													->update([
															'employee_doc_url'       =>$paths.'/'.$image,
															'employee_document_name' =>$fileOrginalName
														]); 
		    }				
		}
		return redirect('manageEmployee')->with('message', 'Successfully added');
    }

    /*The Function used for ManageEmployee delete*/

    public function dodeleteEmployee()
    {    	
    	$delete_id						= Input::get('delete_employee_id');
    	$delete_employee_mgmt			=  employeemodel::employeetable()->where('employee_management_id',$delete_id)->update(['employee_status'=>'deactive']);
    	$delete_employee_mgmt			=  employeemodel::employeedocumenttable()->where('employee_management_id',$delete_id)->update(['employee_document_status'=>'Inactive']);
    	//$delete_employee_doc  			=  employeemodel::employeedocumenttable()->where('employee_management_id',$delete_id)->update(['employee_status'=>'deactive']);
    	return redirect('manageEmployee');
    }

    /*The Function used for ManageEmployee edit*/

    public function doeditEmployee()
    {    	
    	//dd($_POST);
    	$update_employee  				= Input::get('update_employee');
    	$employee 						= $this->side_bar_active;
    	$state     			            = commonmodel::get_master_state();
    	$city 							= commonmodel::get_master_city();
    	$edit_employee_mgmt 			= employeemodel::employeetable()->where('employee_management_id',$update_employee)->first();
    	//dd($edit_employee_mgmt);
    	$edit_employee_doc 				= employeemodel::employeedocumenttable()->where('employee_management_id',$update_employee)->first();
    	//dd($edit_employee_doc);
    	$document_count                 = employeemodel::employeedocumenttable()->where('employee_management_id',$update_employee)->count();   
    	//dd($document_count); 	
    	$employee_type                  = employeemodel::employee_type();
    	$compact_array                  = array
											(
												'city'                 =>$city,
												'state'                =>$state,
												'side_bar_active'      =>$employee,
												'employee_type'        => $employee_type,
												'document_count'       => $document_count,
												'fetch_employee_doc'   => $edit_employee_doc,
												'fetch_employee_mgmt'  => $edit_employee_mgmt,
												'active_menu_name'     =>$this->active_menu_name
											);

		$header_data        	  		= $this->header_data;    	

    	return view('edit_employee',compact('compact_array','header_data'));

    }

    /*The Function used for ManageEmployee update*/


    public function doupdateEmployee(Request $request)
    {    	    	
    	$validationcheck  = Validator::make($request->all(),[
    			"contact_type_id" 			=> "required",
                "contact_first_name" 		=> "required",
                //"contact_last_name"  		=> "required",
                "contact_phone_1" 	 		=> "required",
                //"contact_phone_2" 	 	=> "required",
                "contact_email_1"  	 		=> "required",
                //"mailing_address" 	 		=> "required",
                //"contact_mailing_pincode" 	=> "required",
                //"contact_image" 			=> "required",
            ]);
		if ($validationcheck->fails())
		{
		    $result['error'] = $validationcheck->errors();
		    return response()->json($result,400);
		}
    	$id                  			= session::get('ses_id');    	
		$dealer_schema_name             = session::get('dealer_schema_name');
		$employee_management_id         = Input::get('employee_management_id');		
        $userimage                      = Input::file('contact_image');	
		if(!empty($userimage))
		{
	        $path                       = public_path('uploadimages'.'/'.$dealer_schema_name.'/'.'employee'.'/'.$id.'/');	
			$image                      = fileuploadmodel::any_upload($userimage,$path);		
	        $paths                      = url('uploadimages'.'/'.$dealer_schema_name.'/'.'employee'.'/'.$id.'/');
	        $employee_data 				= array
											 (
											 	'employee_user_image'=>$paths.'/'.$image,
											 );
			$insert_employee_data           = employeemodel::employeetable()
											->where('employee_management_id',$employee_management_id)
											->update($employee_data);	
	    }							
		$employee_data 				    = array
											(
						'dealer_id'						=>$id, 
						'branch_id'						=>'',	
						'employee_first_name'			=>Input::get('contact_first_name'), 
						'employee_last_name'			=>Input::get('contact_last_name'),
						'employee_designation'			=>Input::get('contact_designation'),
						'employee_gender'				=>Input::get('contact_gender'),
						'employee_moblie_no'			=>Input::get('contact_phone_1'),
						'employee_landline_no'			=>Input::get('contact_phone_2'),	
						'employee_email_1'				=>Input::get('contact_email_1'),
						'employee_email_2'				=>Input::get('contact_email_2'),
						'employee_mailing_address'		=>Input::get('mailing_address'),
						'employee_mailing_locality'		=>Input::get('mailing_locality'),
						'employee_city'					=>Input::get('contact_mailing_city'),
						'employee_mailing_pincode'		=>Input::get('contact_mailing_pincode'),	
						'employee_business_name'		=>Input::get('contact_business_name'),
						'employee_type'					=>Input::get('contact_type_id')
											);  
		$insert_employee_data           = employeemodel::employeetable()
											->where('employee_management_id',$employee_management_id)
											->update($employee_data);		
		return $insert_employee_data;
		if(count($insert_employee_data)!= null)
		{				
			$emp_document_insert        = employeemodel::employeedocumenttable()
											->where('dealer_employee_doc_mgmt_id',$dealer_employee_doc_mgmt_id)
											->update([
									'employee_management_id'=>$insert_employee_data, 
									'employee_document_id_type'=>Input::get('document_id_type'),
									'employee_document_id_number'=>Input::get('document_id_number'),
									'employee_document_dob'=>Input::get('document_dob')
													]); 	
		}		
		return redirect('manageEmployee');
    }

    /*The Function used for ManageEmployee view*/
    public function documentupdate(Request $request)
    {
    	/*echo "<pre>";
    	print_r($_FILES);
    	dd($_POST);*/
    	 $document               = Input::get('document');
    	 $document_id            = Input::get('document_id');
    	 $employee_management_id = Input::get('employee_management_id');    	
    	if($document == 1)
    	{
    		$employee_document = Input::file('employee_document');
    		if(!empty($employee_document))
    		{
    			$fileOrginalName                = $request->file('employee_document')->getClientOriginalName();
    			$path                       = public_path('uploadimages'.'/'.session::get('dealer_schema_name').'/'.'employee'.'/'.session::get('ses_id').'/');	
				$image                      = fileuploadmodel::any_upload($employee_document,$path);
		        $paths                      = url('uploadimages'.'/'.$this->dealer_schemaname.'/'.'employee'.'/'.session::get('ses_id').'/');
		        $employee_data 				= array
												 (
												 	'employee_doc_url'=>$paths.'/'.$image,
												 	'employee_document_name' => $fileOrginalName,
												 );
				$insert_employee_data           = employeemodel::employeedocumenttable()
												->where('dealer_employee_doc_mgmt_id',$document_id)
											->update($employee_data);	
    		}
    		$emp_document_insert        = employeemodel::employeedocumenttable()
											->where('dealer_employee_doc_mgmt_id',$document_id)
											->update([
														'employee_management_id'=>$employee_management_id, 
														'employee_document_id_type'=>Input::get('document_id_type'),
														'employee_document_id_number'=>Input::get('document_id_number'),
														'employee_document_dob'=>Input::get('document_dob')
													]); 	

    	}
    	else
    	{
    		/*echo "<pre>";
    		print_r($_FILES);
    		dd($_POST);*/
    		$employee_document = Input::file('employee_document');
    		$emp_document_insert        = employeemodel::employeedocumenttable()
											->where('dealer_employee_doc_mgmt_id',$document_id)
											->insertGetId([
									'employee_management_id'=>$employee_management_id, 
									'employee_document_id_type'=>Input::get('document_id_type'),
									'employee_document_id_number'=>Input::get('document_id_number'),
									'employee_document_dob'=>Input::get('document_dob')
													]); 	

			if(!empty($employee_document))
    		{
    			$fileOrginalName                = $request->file('employee_document')->getClientOriginalName();
    			$path                       = public_path('uploadimages'.'/'.$this->dealer_schemaname.'/'.'employee'.'/'.session::get('ses_id').'/');	
				$image                      = fileuploadmodel::any_upload($employee_document,$path);		
		        $paths                      = url('uploadimages'.'/'.$this->dealer_schemaname.'/'.'employee'.'/'.session::get('ses_id').'/');
				$insert_employee_data       = employeemodel::employeedocumenttable()
												->where('dealer_employee_doc_mgmt_id',$emp_document_insert)
											->update(['employee_doc_url'=>$paths.'/'.$image,'employee_document_name' => $fileOrginalName,]);	
    		}
    	}
    	return redirect('manageEmployee')->with('message', 'Successfully Updated');
    }
    
    public  function doviewEmployee()
    {
    	$update_employee  				= Input::get('view_employee');
    	$employee 						= $this->side_bar_active;
    	$state     			            = commonmodel::get_master_state();
    	$city 							= commonmodel::get_master_city();
    	$edit_employee_mgmt 			= employeemodel::employeetable()->where('employee_management_id',$update_employee)->first();
    	//dd($edit_employee_mgmt);
    	$edit_employee_doc 				= employeemodel::employeedocumenttable()->where('employee_management_id',$update_employee)->first();
    	//dd($edit_employee_doc);
    	$document_count                 = employeemodel::employeedocumenttable()->where('employee_management_id',$update_employee)->count();   
    	//dd($document_count); 	
    	$employee_type                  = employeemodel::employee_type();
    	$compact_array                  = array
											(
												'city'                 =>$city,
												'state'                =>$state,
												'side_bar_active'      =>$employee,
												'employee_type'        => $employee_type,
												'document_count'       => $document_count,
												'fetch_employee_doc'   => $edit_employee_doc,
												'fetch_employee_mgmt'  => $edit_employee_mgmt,
												'active_menu_name'     =>$this->active_menu_name
											);

		$header_data        	  		= $this->header_data;       	

    	return view('view_employee',compact('compact_array','header_data'));
    }
     /*The Function used for ManageEmployee managelisting view*/

    public function domanageEmployee()
    {
    	$customer                       = $this->side_bar_active;
    	$fetch_employee                 = employeemodel::employeetable()
    														->where('employee_status','active')
    														->get();
    	$total_count                 = employeemodel::employeetable()
    														->where('employee_status','active')
    														->count();  
    	$employee_type                  = employeemodel::employee_type();

    	foreach ($employee_type as $key) 
        {
            $contact_type_count             = employeemodel::employeetable()
            									->where('employee_type',$key->employee_type_id)
            									->where('employee_status','active')
            									->count();
                $key->type_count     =$contact_type_count;
        }
    	$compact_array                  = array
											(
												'active_menu_name'=>$this->active_menu_name,
												'side_bar_active'=>$customer,
												'fetch_employee'=> $fetch_employee,
												'total_count'=>	$total_count,
												'fetch_add_leads_active' =>$customer,
												'employee_type'=>$employee_type
											);	
											/*echo "<pre>";
											print_r($compact_array['employee_type']);
											exit;*/
		$header_data        	  		= $this->header_data;			
    	return view('manage_employee',compact('compact_array','header_data'));
    }

}