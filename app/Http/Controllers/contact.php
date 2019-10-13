<?php

/*
  Module Name : Manage 
  Created By  : Sreenivasan  26 -12-2016
  Use of this module is manage leads,customer,contact
*/
namespace App\Http\Controllers;

use Session;
use Redirect;
use Image;
use Config;
use App\Http\Requests\contact as contactVal;
use App\model\branchesmodel;
use App\model\commonmodel;
use App\model\map;
use App\model\fileuploadmodel;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\model\contactsmodel;
use App\model\notificationsmodel;
use App\model\dealermodel;
use App\model\employeemodel;
use App\model\leadpreferencesmodel;
use App\model\parameter_option_scoring;
use Illuminate\Support\Facades\Validator;
/**
* 
*/
class contact extends Controller
{
    public $active_menu_name;
    public $header_data;
    public $side_bar_active;
    public $login_authecation;
    public $side_bar_customer;
    public $side_bar_contacts;
    public $p_id;
    public $id;
    public function __construct()
    {           
        $this->active_menu_name         = 'manage_menu';
        $this->side_bar_contacts        = config::get('common.contact');
        $this->middleware(function ($request, $next) 
            {
            $this->id                     = session::get('ses_id');
            $this->p_id                   = dealermodel::parent_id($this->id);
            $this->login_authecation    = session()->has( 'ses_dealername' ) ? session()->get( 'ses_dealername' ) :  Redirect::to('login')->send();
            $this->header_data          = commonmodel::commonheaderdata();
            $this->header_data['title']='Manage';
            $this->header_data['p_id']   =$this->p_id;
            $this->dealer_schemaname    = (new branch)->getschemaname($this->id);
            return $next($request);
            }
        );                              
    }
    
    /*The Function used for Manage data in dealer database*/

    public function managecontact()
    {       
        $contact_value                 = encrypt(0);        
        $contact_type_id                = contactsmodel::contact_type()->get();         
        $total_count                    = contactsmodel::contact_table()->where('contact_status',config::get('common.contact_status_active'))->count();        
        $count = array();
        foreach ($contact_type_id as $key) 
            {
                $contact_type_count             = contactsmodel::contact_table()->where('contact_type_id',$key->contact_type_id)->where('contact_status',config::get('common.contact_status_active'))->count();                
                    $key->type_count     =$contact_type_count;              
            }               
                
        $compact_array                  = array
                                            (
                                    'active_menu_name'    =>$this->active_menu_name,
                                    'side_bar_active'     =>$this->side_bar_contacts,  
                                    'contact_type'        =>$contact_type_id,
                                    'total_count'         =>$total_count,
                                    'contact_type_count'  =>$contact_type_count,
                                    'contact_value'       =>$contact_value
                                            );
                                            /*echo "<pre>";
                                            print_r($compact_array['contact_value']);
                                            exit;*/
        $header_data                    = $this->header_data;                                   
        return view('mycontact_manage',compact('compact_array','header_data'));
    }

    /*The Function used for delete_contact*/

    public function deletecontact()
    {
        
        $delete_contact_id              = Input::get('delete_customer');
       /* $delete                         = array(
                                                    'contact_status' =>config::get('common.contact_status_inactive')
                                                );*/
        $delete_customer_data           = contactsmodel::contact_table()
                                            ->where('contact_management_id',$delete_contact_id)
                                            ->update(['contact_status' =>config::get('common.contact_status_inactive')]);     
                                            //dd($delete_customer_data);
        $delete                         = array(
                                                    'dealer_document_status' =>config::get('common.contact_status_inactive')
                                                );
        $delete_customer_document       = contactsmodel::document()
                                            ->where('contact_management_id',$delete_contact_id)
                                            ->update($delete); 
        Session::flash('deletecontact', "Successfully deleted");
        return redirect('managecontact');       
    }

    /*The Function used for editcontact blade file*/

    public function editcontact()
    {
        
        try
        {
        $edit_contact_id                = Input::get('edit_contact'); 
        $fetch_contact_data             = contactsmodel::contact_table()
                                            ->where('contact_management_id',$edit_contact_id)
                                            ->first();    
        $contact_type_lead              = contactsmodel::contact_table()
                                            ->where('contact_management_id',$edit_contact_id)
                                            ->where('contact_type_id',config::get('common.contact_type_lead'))
                                            ->count();    
        $contact_type_customer          = contactsmodel::contact_table()
                                            ->where('contact_management_id',$edit_contact_id)
                                            ->where('contact_type_id',config::get('common.contact_type_customer'))
                                            ->count();    
                                            //dd($contact_type_customer);
        $fetch_contact_document_data    = contactsmodel::document()
                                            ->where('contact_management_id',$edit_contact_id)
                                            ->first();   
        $document                       = contactsmodel::document()
                                            ->where('contact_management_id',$edit_contact_id)
                                            ->count();
                                            /*echo "<Pre>";                                     
                                            print_r($fetch_contact_document_data);
                                            exit;*/
        $contact_type_id                = branchesmodel::contact_type()->get();   
        $city                           = commonmodel::get_master_city();
        $document_id                    = commonmodel::document_id_proof()->get(); 
        $state                          = commonmodel::get_master_state();    
        $compact_array                  = array
                                            (
                                                'active_menu_name'=>$this->active_menu_name,

                                                'side_bar_active'=>$this->side_bar_contacts,

                                                'fetch_contact_data'=>$fetch_contact_data,

                                                'fetch_contact_document_data'=> $fetch_contact_document_data,

                                                'contact_type_id' => $contact_type_id,

                                                'contact_type_lead' => $contact_type_lead,

                                                'contact_type_customer' =>$contact_type_customer,

                                                'city' => $city,

                                                'state'=>$state,

                                                'active_contact' => $this->side_bar_contacts,

                                                'document_id' =>$document_id,

                                                'document'   =>$document
                                            );      
                                            //dd($compact_array['document']);
        $header_data                    = $this->header_data;
        //dd($compact_array['fetch_contact_data']);
        }
        catch(Exception $e){
            throw new CustomException($e->getMessage());
        }   
        return view('edit_contact',compact('compact_array','header_data')); 
    }

    /*The Function used for Updatecontact*/

    public function updatecontact(Request $request)
    {              
        try
        {
            $validationcheck  = Validator::make($request->all(),[
                "contact_type_id" => "required|not_in:0",
                "contact_first_name" => "required",
                //"contact_last_name" => "required",
                // "contact_designation" => "required",
                // "contact_designation" => "required",
                // "contact_gender"    => "required",
                // "contact_lead_source" => "required",
                // "contact_email_opt_out" => "required",
                // "contact_sms_opt_out" => "required",
                 "contact_phone_1" => "required",
                //"contact_phone_3" => "required",
                "contact_email_1" => "required",
                'contact_gender' => 'required|not_in:0'
                //"contact_email_2" => "required",
                // "contact_mailing_address" => "required",
                // "contact_mailing_locality" => "required",
                // "contact_mailing_city" => "required",
                // "contact_mailing_pincode" => "required",
                // "pan_number" => "required",
            ]);
            if ($validationcheck->fails())
            {
                $result['error'] = $validationcheck->errors();
                return response()->json($result,400);
            }
            $contact_mgmt_id                = Input::get('contact_mgmt_id');
            $id                             = session::get('ses_id');
            $document                       = contactsmodel::select_doc_count($this->dealer_schemaname,$id);
            $dealer_schema_name             = session::get( 'dealer_schema_name' );
            $userimage                      = Input::file('contact_image');
            $documentcount                  = Input::get('documetcount');

            if(!empty($userimage))
            {
                $path                       = public_path(config::get('common.uploadimages').'/'.$this->dealer_schemaname.'/'.'contacts'.'/'.$id.'/'); 
                $image                      = fileuploadmodel::any_upload($userimage,$path);        
                $paths                      = url('uploadimages'.'/'.$this->dealer_schemaname.'/'.'contacts'.'/'.$id.'/');   
                $temp_name = $paths.'/'.$image;
                $update_data               = array
                                                (
                                                    //'user_image'=>$paths.'/'.$image 
                                                    'user_image'=> $temp_name
                                                );  
                $contact_update             = contactsmodel::contact_table()
                                                ->where('contact_management_id',$contact_mgmt_id)
                                                ->update($update_data);  
               
            }             
            $contact_sms_opt_out            = Input::get('contact_sms_opt_out');
            $contact_email_opt_out          = Input::get('contact_email_opt_out');                
            if($contact_sms_opt_out == "1")
            {
                $sms    = "1";
                $update_data        = array(
                                              'contact_sms_opt_out'=>$sms,
                                           );    
               $contact_update      = contactsmodel::contact_table()
                                        ->where('contact_management_id',$contact_mgmt_id)
                                        ->update($update_data); 

            }
            else
            {
                $sms    = "0";
                $update_data        = array(
                                              'contact_sms_opt_out'=>$sms,
                                           );    
               $contact_update      = contactsmodel::contact_table()
                                        ->where('contact_management_id',$contact_mgmt_id)
                                        ->update($update_data); 
            }
            if($contact_email_opt_out == '1')
            {
                $email = "1";
                $update_data        = array(
                                              'contact_email_opt_out'=>$email,
                                           );    
                $contact_update     = contactsmodel::contact_table()
                                        ->where('contact_management_id',$contact_mgmt_id)
                                        ->update($update_data); 
            }
            else
            {
                $email = "0";
                $update_data        = array(
                                              'contact_email_opt_out'=>$email,
                                           );    
                $contact_update     = contactsmodel::contact_table()
                                        ->where('contact_management_id',$contact_mgmt_id)
                                        ->update($update_data); 
            }                          
            $update_data              = array(
                                'dealer_id'                 =>$id, 
                                'branch_id'                 =>'',
                                'contact_type_id'           =>Input::get('contact_type_id'),
                                'contact_owner'             =>Input::get('contact_owner'), 
                                'contact_first_name'        =>Input::get('contact_first_name'), 
                                'contact_last_name'         =>Input::get('contact_last_name'),
                                'contact_designation'       =>Input::get('contact_designation'),
                                'contact_gender'            =>Input::get('contact_gender'),
                                'contact_lead_source'       =>Input::get('contact_lead_source'),
                                'contact_phone_1'           =>Input::get('contact_phone_1'),
                                'contact_phone_2'           =>Input::get('contact_phone_2'),
                                'contact_phone_3'           =>Input::get('contact_phone_3'),
                                'contact_email_1'           =>Input::get('contact_email_1'),
                                'contact_email_2'           =>Input::get('contact_email_2'),
                                'contact_mailing_address'   =>Input::get('contact_mailing_address'),
                                'contact_mailing_locality'  =>Input::get('contact_mailing_locality'),
                                'contact_mailing_city'      =>Input::get('contact_mailing_city'),
                                'contact_mailing_pincode'   =>Input::get('contact_mailing_pincode'),
                                'contact_other_address'     =>Input::get('contact_other_address'),
                                'contact_other_locality'    =>Input::get('contact_other_locality'),
                                'contact_other_city'        =>Input::get('contact_other_city'),
                                'contact_other_pincode'     =>Input::get('contact_other_pincode'),
                                'pan_number'                => Input::get('pan_number'),
                                    );              
            $contact_update             = contactsmodel::contact_table()
                                            ->where('contact_management_id',$contact_mgmt_id)
                                            ->update($update_data);
            $employee_information_type = Input::get('employee_information_type');        
            if($employee_information_type == 1)
            {
                $contact_data                     = array(
                                    'salary_per_month'          =>'',
                                    'employeetype'              =>'',
                                    'business_type'             =>Input::get('business_type'),
                                    'contact_business_name'     =>Input::get('contact_business_name'),
                                    'employee_information_type' =>config::get('common.Business'),
                                                     );
                $insert_contact_data              = contactsmodel::contact_table()->where('contact_management_id',$contact_mgmt_id)->update($contact_data); 
            }
            else if($employee_information_type == 2)
            {
                $contact_data                     = array(
                                    'business_type'                =>'',
                                    'contact_business_name'        =>'',
                                    'salary_per_month'             =>Input::get('salary'),
                                    'employeetype'                 =>Input::get('employeetype'),
                                    'employee_information_type'    =>config::get('common.Employee'),
                                                     );
                $insert_contact_data              = contactsmodel::contact_table()->where('contact_management_id',$contact_mgmt_id)->update($contact_data); 
            }
            return $contact_update;  
            }
        catch(Exception $e){
            throw new CustomException($e->getMessage());
        }   
    }
    public function updatecontact_doc(Request $request)
    {
        /*print_r($_FILES);
        dd($_POST);*/
         $documentcount              = Input::get('documetcount');
         $contact_document           = Input::file('contact_document'); 
         $contact_mgmt_id            = Input::get('contact_mgmt_id');
         
         if(!empty($contact_document))
         {
            $fileOrginalName            = $request->file('contact_document')->getClientOriginalName();
            
         }
            if($documentcount == 1)        
            {       
                if(!empty($contact_document))   
                {
                   $path        = public_path('uploadimages'.'/'.$this->dealer_schemaname.'/'.'contacts'.'/'.$this->id.'/'.'document'.'/');   
                    $image      = fileuploadmodel::any_upload($contact_document,$path);        
                    $paths      = url('uploadimages'.'/'.$this->dealer_schemaname.'/'.'contacts'.'/'.$this->id.'/'.'document'.'/'); 
                    $contact_add = contactsmodel::document()
                                    ->where('contact_management_id',$contact_mgmt_id)
                                    ->update([
                                               'doc_link_fullpath' => $paths.'/'.$image,
                                    'document_name'     => $fileOrginalName,
                                            ]);
                }

                 $contact_add      = contactsmodel::document()
                                            ->where('contact_management_id',$contact_mgmt_id)
                                            ->update([
                                                'contact_management_id'=>$contact_mgmt_id, 
                                                'document_id_type'=>Input::get('document_id_type'),
                                                'document_id_number'=>Input::get('document_id_number'),
                                                'document_dob'=>Input::get('document_dob')
                                                    ]);
                    //return "Successfully updated";
                    $message = "Successfully updated";
                }
                else if($documentcount == 0)
                {
                    $document_name='';
                    $doc_link_fullpath='';
                    if(!empty($contact_document)){
                        $path                           = public_path('uploadimages'.'/'.$this->dealer_schemaname.'/'.'contacts'.'/'.$this->id.'/'.'document'.'/');   
                        $image                          = fileuploadmodel::any_upload($contact_document,$path);        
                        $paths                          = url('uploadimages'.'/'.$this->dealer_schemaname.'/'.'contacts'.'/'.$this->id.'/'.'document'.'/'); 
                        $doc_link_fullpath = $paths.'/'.$image;
                        $document_name     = $fileOrginalName;
                        }
                        $contact_add            = contactsmodel::document()
                                                ->insertGetId([
                                            'contact_management_id'=>$contact_mgmt_id, 
                                            'document_id_type'=>Input::get('document_id_type'),
                                            'document_id_number'=>Input::get('document_id_number'),
                                            'document_dob'=>Input::get('document_dob'),
                                            'doc_link_fullpath'=>$doc_link_fullpath,
                                            'document_name'=>$document_name,
                                                            ]);
                         /*if(!empty($contact_document))   
                            {
                                $path                           = public_path('uploadimages'.'/'.$this->dealer_schemaname.'/'.'contacts'.'/'.$this->id.'/'.'document'.'/');   
                                $image                          = fileuploadmodel::any_upload($contact_document,$path);        
                                $paths                          = url('uploadimages'.'/'.$this->dealer_schemaname.'/'.'contacts'.'/'.$this->id.'/'.'document'.'/'); 
                                $contact_add = contactsmodel::document()
                                                ->where('contact_management_id',$contact_add)
                                                ->update([
                                   'doc_link_fullpath' => $paths.'/'.$image
                                                        ]);                                          
                            } 
                            $message = "Successfully updated";*/
                }
                return redirect('managecontact')->with('message', 'Successfully Updated');
    }

    /*The Function used for addcontact  blade file */

    public function addcontact($id)
    {
        try
        {
            $id                             = decrypt($id);
            $contact                        = $this->side_bar_contacts;
            $contact_type_id                = branchesmodel::contact_type()->get();   
            $city                           = commonmodel::get_master_city();
            $state                          = commonmodel::get_master_state();
            $document_id                    = commonmodel::document_id_proof()->get();  
            $contact_count                  = contactsmodel::contact_count($this->dealer_schemaname,$id);
            $fetch_contact_data             = contactsmodel::selectcontact($this->dealer_schemaname,$id);
            $contact_type_lead              = contactsmodel::selectLeadcontact($this->dealer_schemaname,$id);
            $contact_type_customer          = contactsmodel::selectCustomercontact($this->dealer_schemaname,$id);
            $fetch_contact_document_data    = contactsmodel::select_doc($this->dealer_schemaname,$id);
            $document                       = contactsmodel::select_doc_count($this->dealer_schemaname,$id);
            $make                           = commonmodel::makedropdown();

            $getprefercences                = leadpreferencesmodel::lead_preferences_fetch($this->dealer_schemaname,array('lead_id'=>$id));

            $getprice_filter               = parameter_option_scoring::parameter_option_scoring_fetch($this->dealer_schemaname,array('parameter_id'=>4));
            //dd($getprice_filter);
            $gettimeline                   = parameter_option_scoring::parameter_option_scoring_fetch($this->dealer_schemaname,array('parameter_id'=>5));
            //dd($gettimeline);
            //dd($getprefercences);
            $regionfetch = array();
            $model     = array();
            $makefetch = array();
            $modelfetch = array();
            $pricefilterfetch = array();
            $budgetfetch = array();
            $timelinefetch = array();
            foreach ($getprefercences as $key => $value) {
                $paramid  = $value->lead_option_id;
                switch ($paramid) {
                    case 1:
                        $regionfetch = explode(',', $value->lead_option_value);
                        break;

                    case 2:
                        $makefetchformodel = explode(',', str_replace('m','',$value->lead_option_value));
                        $makefetch = explode(',',$value->lead_option_value);
                        $model = commonmodel::domodelwithwherein($makefetchformodel);
                        break;

                    case 3:
                        $modelfetch = explode(',', $value->lead_option_value);
                        break;
                    case 4:
                        $pricefilterfetch = explode(',', $value->lead_option_value);
                        break;

                    case 5:
                        $timelinefetch = explode(',', $value->lead_option_value);
                        break;

                    default:
                        # code...
                        break;
                }
            }
            
            $contact_value                  = 0;
            $compact_array                  = array
                                                (
                                        'city'                       =>$city,
                                        'state'                      =>$state,
                                        'document'                   =>$document,
                                        'fetch_add_leads_active'     =>$contact,
                                        'contact_value'              =>$contact_value,
                                        'document_id'                =>$document_id,
                                        'contact_count'              =>$contact_count,
                                        'contact_type_id'            =>$contact_type_id,
                                        'contact_type_lead'          =>$contact_type_lead,
                                        'fetch_contact_data'         =>$fetch_contact_data,
                                        'fetch_contact_data'         =>$fetch_contact_data,
                                        'contact_type_customer'      =>$contact_type_customer,
                                        'active_menu_name'           =>$this->active_menu_name,
                                        'side_bar_active'            =>$this->side_bar_contacts,
                                        'fetch_contact_document_data'=>$fetch_contact_document_data,
                                        'model'                      =>$model,
                                        'make'                       =>$make,
                                        'regionfetch'                =>$regionfetch,
                                        'makefetch'                  =>$makefetch,
                                        'modelfetch'                 =>$modelfetch,
                                        'pricefilterfetch'           =>$pricefilterfetch,
                                        'timelinefetch'              =>$timelinefetch,
                                        'getprice_filter'            =>$getprice_filter,
                                        'gettimeline'                =>$gettimeline
                                                );
            $header_data                    = $this->header_data;   

        }
        catch(Exception $e){
            throw new CustomException($e->getMessage());
        }   
        return view('mycontact',compact('compact_array','header_data'));
    }

    /*The Function used for insertcontact data */

    public function insertcontact(Request $request)
    {               
        try{
            $validationcheck  = Validator::make($request->all(),[
                "contact_type_id" => "required|not_in:0",
                "contact_first_name" => "required",
                //"contact_last_name" => "required",
                // "contact_designation" => "required",
                // "contact_designation" => "required",
                // "contact_gender"    => "required",
                // "contact_lead_source" => "required",
                // "contact_email_opt_out" => "required",
                // "contact_sms_opt_out" => "required",
                 "contact_phone_1" => "required",
                //"contact_phone_3" => "required",
                "contact_email_1" => "required",
                'contact_gender' => 'required|not_in:0'
                //"contact_email_2" => "required",
                // "contact_mailing_address" => "required",
                // "contact_mailing_locality" => "required",
                // "contact_mailing_city" => "required",
                // "contact_mailing_pincode" => "required",
                // "pan_number" => "required",
            ]);
            if ($validationcheck->fails())
            {
                $result['error'] = $validationcheck->errors();
                return response()->json($result,400);
            }   
            $id                      = Session::get('ses_id');          
            $leads_add               = contactsmodel::contact_table()->get();          
            $dealer_schema_name      = Session::get( 'dealer_schema_name' );
            $userimage               = Input::file('contact_image');  
            $contact_sms_opt_out     = Input::get('contact_sms_opt_out');
            $contact_email_opt_out   = Input::get('contact_email_opt_out');
            $contact_type_id         = Input::get('contact_type_id');
            $contact_owner           = Input::get('contact_owner');
            $contact_first_name      = Input::get('contact_first_name');
            $contact_last_name       = Input::get('contact_last_name');
            $contact_designation     = Input::get('contact_designation');
            $contact_gender          = Input::get('contact_gender');
            $contact_lead_source     = Input::get('contact_lead_source');
            $contact_phone_1         = Input::get('contact_phone_1');
            $contact_phone_2         = Input::get('contact_phone_2');
            $contact_phone_3         = Input::get('contact_phone_3');
            $contact_email_1         = Input::get('contact_email_1');
            $contact_email_2         = Input::get('contact_email_2');
            $contact_mailing_address = Input::get('contact_mailing_address');
            $contact_mailing_locality= Input::get('contact_mailing_locality');
            $contact_mailing_city    = Input::get('contact_mailing_city');
            $contact_mailing_pincode = Input::get('contact_mailing_pincode');
            $contact_other_address   = Input::get('contact_other_address');
            $contact_other_locality  = Input::get('contact_other_locality');
            $contact_other_city      = Input::get('contact_other_city');
            $contact_other_pincode   = Input::get('contact_other_pincode');        
            $contact_document        = Input::get('contact_document');  
            $pan_number              = Input::get('pan_number');

            if($contact_type_id== "" && $contact_first_name== "" && $contact_phone_1 == "" && $contact_mailing_address == "")
                {
                     return "fields are required";
                }
                 $id                             = Session::get('ses_id');
                 $add_contact = Input::get('last_id');
                 if(empty($add_contact))
                 {
                    $insert_contact              = contactsmodel::contact_table()
                                                        ->insertGetId(['dealer_id'=>$id]); 
                 }
                 else
                 {
                    $insert_contact =  $add_contact;
                 }
                 if(!empty($userimage))
                    {
                        $path                           = public_path('uploadimages'.'/'.$dealer_schema_name.'/'.'contacts'.'/'.$id.'/'.'images'.'/');   
                        $image                          = fileuploadmodel::any_upload($userimage,$path);        
                        $paths                          = url('uploadimages'.'/'.$dealer_schema_name.'/'.'contacts'.'/'.$id.'/'.'images'.'/');   
                        $contact_data      = array(
                                                      'user_image'=>$paths.'/'.$image
                                                  );
                        $insert_contact_data              = contactsmodel::contact_table()
                                                                ->where('contact_management_id',$insert_contact)
                                                                ->update($contact_data);  

                    }           
                    if(!empty($contact_sms_opt_out))
                    {
                        $sms    = "1";
                        $contact_data      = array(
                                                      'contact_sms_opt_out'=>$sms,
                                                  );    
                        $insert_contact_data              = contactsmodel::contact_table()
                                                                ->where('contact_management_id',$insert_contact)
                                                                ->update($contact_data);  
                    }
                    if(!empty($contact_email_opt_out))
                    {
                        $email = "1";
                        $contact_data      = array(
                                                      'contact_email_opt_out'=>$email,
                                                  );    
                        $insert_contact_data              = contactsmodel::contact_table()
                                                    ->where('contact_management_id',$insert_contact)
                                                    ->update($contact_data);
                    }
                    $contact_data                = array
                                                    (
                                                'dealer_id'=>$id, 
                                                'branch_id'=>'',
                                                'contact_type_id'=>$contact_type_id,
                                                'contact_owner'=>$contact_owner, 
                                                'contact_first_name'=>$contact_first_name, 
                                                'contact_last_name'=>$contact_last_name,
                                                'contact_designation'=>$contact_designation,
                                                'contact_gender'=>$contact_gender,
                                                'contact_lead_source'=>$contact_lead_source,
                                                'contact_phone_1'=>$contact_phone_1,
                                                'contact_phone_2'=>$contact_phone_2,
                                                'contact_phone_3'=>$contact_phone_3,
                                                'contact_email_1'=>$contact_email_1,
                                                'contact_email_2'=>$contact_email_2,
                                                'contact_mailing_address'=>$contact_mailing_address,
                                                'contact_mailing_locality'=>$contact_mailing_locality,
                                                'contact_mailing_city'=>$contact_mailing_city,
                                                'contact_mailing_pincode'=>$contact_mailing_pincode,
                                                'contact_other_address'=>$contact_other_address,
                                                'contact_other_locality'=>$contact_other_locality,
                                                'contact_other_city'=>$contact_other_city,
                                                'contact_other_pincode'=>$contact_other_pincode,
                                                'pan_number'=>$pan_number
                                                    );  
            $insert_contact_data              = contactsmodel::contact_table()
                                                    ->where('contact_management_id',$insert_contact)
                                                    ->update($contact_data); 
            $employee_information_type = Input::get('employee_information_type');        
            if($employee_information_type == 1)
            {
                $contact_data                     = array(
                                    'salary_per_month'          =>'',
                                    'employeetype'              =>'',
                                    'business_type'             =>Input::get('business_type'),
                                    'contact_business_name'     =>Input::get('contact_business_name'),
                                    'employee_information_type' =>config::get('common.Business'),
                                                     );
                $insert_contact_data              = contactsmodel::contact_table()->where('contact_management_id',$insert_contact)->update($contact_data); 
            }
            else if($employee_information_type == 2)
            {

                $contact_data                     = array(
                                    'business_type'                =>'',
                                    'contact_business_name'        =>'',
                                    'salary_per_month'             =>Input::get('salary'),
                                    'employeetype'                 =>Input::get('employeetype'),
                                    'employee_information_type'    =>config::get('common.Employee'),
                                                     );
                $insert_contact_data              = contactsmodel::contact_table()
                                                ->where('contact_management_id',$insert_contact)
                                                ->update($contact_data); 
            }
        }
        catch(Exception $e){
            throw new CustomException($e->getMessage());
        }   
        return $insert_contact;        
    }
     /*The Function used for View-Contact*/
     public function document_save(Request $request)
     {
     try
     {
        $id                             = Session::get('ses_id');
        $last_id                        = Input::get('last_id');

        // if(Input::get('document_id_number') == "")
        // {
        //      Session::flash('message', "fields are required");
        //      return Redirect::back();
        // }
        $contact_document               = Input::file('contact_document');
        if(!empty($contact_document)) 
        {
        $getOrgFileName                 = $request->file('contact_document')->getClientOriginalName();
        }
        $dealer_schema_name             = session::get( 'dealer_schema_name' );
        if(count($last_id)!= null)
        {  
            $last_doc_id  = Input::get('last_doc_id');
            if(empty($last_doc_id))
            {
            $contact_insert                = contactsmodel::document()
                                                    ->insertGetId([
                                                        'contact_management_id'=>$last_id,
                                                        ]);
            }
            else
            {
                $contact_insert = $last_doc_id;
            }
             if(!empty($contact_document))   
            {
               $path                           = public_path('uploadimages'.'/'.$dealer_schema_name.'/'.'contacts'.'/'.$id.'/'.'document'.'/');   
                $image                          = fileuploadmodel::any_upload($contact_document,$path);
                $paths                          = url('uploadimages'.'/'.$dealer_schema_name.'/'.'contacts'.'/'.$id.'/'.'document'.'/'); 
                $contact_doc                = contactsmodel::document()->where('dealer_document_management_id',$contact_insert)->update([
                                                'doc_link_fullpath'=>$paths.'/'.$image,
                                                'document_name' => $getOrgFileName,
                                            ]);
            }
            $contact_doc                = contactsmodel::document()->where('dealer_document_management_id',$contact_insert)->update([
                                            'contact_management_id'=>$last_id, 
                                            'document_id_type'=>Input::get('document_id_type'),
                                            'document_id_number'=>Input::get('document_id_number'),
                                            'document_dob'=>Input::get('document_dob'),
                                                                            ]);
        }     
        else
        {
            return "0";
        }
        if(!empty($contact_doc))
        {
            $contact_doc = contactsmodel::document()->where('dealer_document_management_id',$contact_insert)->first();
            $document_link = $contact_doc->doc_link_fullpath; 
            $redirect      = redirect('managecontact');
            $document_lastid = array( 'last_doc_id' => $contact_insert,'link'=>$document_link,'redirect' => $redirect);             
            return redirect('managecontact')->with('message', 'Successfully added');
        }  
        else
        {
            $contact_doc = contactsmodel::document()->where('dealer_document_management_id',$contact_insert)->first();
            $document_lastid = array( 'last_doc_id' => $contact_insert,'link'=>$document_link);
            return redirect('managecontact')->with('message', 'Successfully added');
        }  
        }
        catch(Exception $e){
            throw new CustomException($e->getMessage());
        }
     }
   public function view_contact()
    {       
        try
        {
        $contact                        = "contact";
        $id                             = Input::get('view_customer');
        $city                           = commonmodel::get_master_city();
        $state                          = commonmodel::get_master_state();
        $document_id                    = commonmodel::document_id_proof()->get();  
        $contact_type_id                = contactsmodel::contact_type()->get();   
        $contact_count                  = contactsmodel::contact_count($this->dealer_schemaname,$id);
        $fetch_contact_data             = contactsmodel::selectcontact($this->dealer_schemaname,$id);
        $contact_type_lead              = contactsmodel::selectLeadcontact($this->dealer_schemaname,$id);
        $contact_type_customer          = contactsmodel::selectCustomercontact($this->dealer_schemaname,$id);
        $fetch_contact_document_data    = contactsmodel::select_doc($this->dealer_schemaname,$id);
        $document                       = contactsmodel::select_doc_count($this->dealer_schemaname,$id);
        $make                           = commonmodel::makedropdown();

        $getprefercences                = leadpreferencesmodel::lead_preferences_fetch($this->dealer_schemaname,array('lead_id'=>$id));

        $getprice_filter               = parameter_option_scoring::parameter_option_scoring_fetch($this->dealer_schemaname,array('parameter_id'=>4));
        //dd($getprice_filter);
        $gettimeline                   = parameter_option_scoring::parameter_option_scoring_fetch($this->dealer_schemaname,array('parameter_id'=>5));
        //dd($gettimeline);
        //dd($getprefercences);
        $regionfetch = array();
        $model     = array();
        $makefetch = array();
        $modelfetch = array();
        $pricefilterfetch = array();
        $budgetfetch = array();
        $timelinefetch = array();
        foreach ($getprefercences as $key => $value) {
            $paramid  = $value->lead_option_id;
            switch ($paramid) {
                case 1:
                    $regionfetch = explode(',', $value->lead_option_value);
                    break;

                case 2:
                    $makefetchformodel = explode(',', str_replace('m','',$value->lead_option_value));
                    $makefetch = explode(',',$value->lead_option_value);
                    $model = commonmodel::domodelwithwherein($makefetchformodel);
                    break;

                case 3:
                    $modelfetch = explode(',', $value->lead_option_value);
                    break;
                
                case 4:
                    $pricefilterfetch = explode(',', $value->lead_option_value);
                    break;

                case 5:
                    $timelinefetch = explode(',', $value->lead_option_value);
                    break;

                default:
                    # code...
                    break;
            }
        }
                                                   
        $compact_array                  = array
                                            (
                                         'city'                       =>$city,
                                        'state'                      =>$state,
                                        'document'                   =>$document,
                                        'fetch_add_leads_active'     =>$contact,
                                        'document_id'                =>$document_id,
                                        'contact_count'              =>$contact_count,
                                        'contact_type_id'            =>$contact_type_id,
                                        'contact_type_lead'          =>$contact_type_lead,
                                        'fetch_contact_data'         =>$fetch_contact_data,
                                        'fetch_contact_data'         =>$fetch_contact_data,
                                        'contact_type_customer'      =>$contact_type_customer,
                                        'active_menu_name'           =>$this->active_menu_name,
                                        'side_bar_active'            =>$this->side_bar_contacts,
                                        'fetch_contact_document_data'=>$fetch_contact_document_data,
                                        'model'                      =>$model,
                                        'make'                       =>$make,
                                        'regionfetch'                =>$regionfetch,
                                        'makefetch'                  =>$makefetch,
                                        'modelfetch'                 =>$modelfetch,
                                        'pricefilterfetch'           =>$pricefilterfetch,
                                        'timelinefetch'              =>$timelinefetch,
                                        'getprice_filter'            =>$getprice_filter,
                                        'gettimeline'                =>$gettimeline
                                            );      

        $header_data                    = $this->header_data;
        }
        catch(Exception $e){
            throw new CustomException($e->getMessage());
        }   
        return view('view_contact',compact('compact_array','header_data'));
    }    

    public function leadstatus()
    { 
      $last_id = Input::get('last_id');
      $dealer_schemaname = Session::get('dealer_schema_name');

      leadpreferencesmodel::lead_preferences_delete($dealer_schemaname,array('lead_id'=>$last_id));

      $buycity = Input::get('buycity');
      $buymake = Input::get('buymake');
      $buymodel = Input::get('buymodel');
      $pricefliter = Input::get('pricefliter');
      $timeline = Input::get('timeline');

      $insertregion['lead_option_id']=1;
      $insertmake['lead_option_id']=2;
      $insertmodel['lead_option_id']=3;
      $insertpricefilter['lead_option_id']=4;
      $inserttimeline['lead_option_id']=5;
      
      
      $insertregion['lead_id']=$last_id;
      $insertmake['lead_id']=$last_id;
      $insertmodel['lead_id']=$last_id;
      $insertpricefilter['lead_id']=$last_id;
      $inserttimeline['lead_id']=$last_id;
      $insertregionvalue = array();
      $insertmakevalue = array();
      $insertmodelvalue = array();
      $insertpricefiltervalue = array();
      $inserttimelinevalue = array();
      
      if(!empty($buycity)){
        foreach ($buycity as $key){
          $insertregionvalue[] = 'r'.$key.'r';          
        }
        $insertregion['lead_option_value'] = implode(',', $insertregionvalue);
        leadpreferencesmodel::lead_preferences_insert($dealer_schemaname,$insertregion);
      }
      
      if(!empty($buymake)){
        foreach ($buymake as $key){
          $insertmakevalue[] = 'm'.$key.'m';
        }
        $insertmake['lead_option_value'] = implode(',', $insertmakevalue);
        leadpreferencesmodel::lead_preferences_insert($dealer_schemaname,$insertmake);
      }
      if(!empty($buymodel)){
        foreach ($buymodel as $key){
          $insertmodelvalue[] = 'mo'.$key.'mo';
        }
        $insertmodel['lead_option_value'] = implode(',', $insertmodelvalue);
        leadpreferencesmodel::lead_preferences_insert($dealer_schemaname,$insertmodel);
      }

      if(!empty($pricefliter)){
        foreach ($pricefliter as $key){
          $insertpricefiltervalue[] = 'f'.$key.'f';
        }
        $insertpricefilter['lead_option_value'] = implode(',', $insertpricefiltervalue);
        leadpreferencesmodel::lead_preferences_insert($dealer_schemaname,$insertpricefilter);
      }

      if(!empty($timeline)){
        foreach ($timeline as $key){
          $inserttimelinevalue[] = 't'.$key.'t';
        } 
        $inserttimeline['lead_option_value'] = implode(',', $inserttimelinevalue);
        leadpreferencesmodel::lead_preferences_insert($dealer_schemaname,$inserttimeline);
      }
    }
    public function dofetch_city()
    {

        $state = Input::get('state');
        $citys = commonmodel::master_citys($state);
        echo json_encode($citys);
    }
}