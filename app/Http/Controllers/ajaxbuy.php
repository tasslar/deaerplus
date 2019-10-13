<?php
/*
  Module Name : Buy 
  Created By  : Naveen Babu 01-12-2016 Version 1.0
  Use of this module is Buy Search, Listing the car details,Saved Cars ,Apply Inventory Fundings, Bids Posted List, My Queries

*/
namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\model\mongomodel;
use App\model\fileuploadmodel;
use App\model\buymodel;
use App\model\buyymodel;
use App\Http\Controllers\buy;
use App\model\commonmodel;
use App\model\inventorymodel;
use App\model\notificationsmodel;
use App\model\emailmodel;
use App\model\smsmodel;
use App\model\contactsmodel;
use App\model\usersmodel;
use App\model\employeemodel;
use App\model\branchesmodel;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Mail;
use App\Exceptions\CustomException;
use Exception;
use Session;
use Config;
use Redirect;
use Carbon\Carbon;

class ajaxbuy extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /*
    *The Constructor Consist of Assgned the model objects and master data 
    *Logout if session is out of time
    */
    public $buy_searchlisting_model;
    public $dms_master_dealer_data;
    public $header_data;
    public $session_names;
    public $login_authecation;
    public $active_menu_name;
    public $dealer_schemaname;
    public function __construct()
    {
      $this->active_menu_name         = 'buy_menu';
      $this->masterMainLoginTable     = 'dms_dealers';
      $this->dmsusertable             ='user_account';
      $this->middleware(function ($request, $next) {
              $this->login_authecation= session()->has( 'ses_dealername' ) ? 1 :  0;
              
              $this->dealer_schemaname=Session::get('dealer_schema_name');
            return $next($request);
        });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
    /*
    *The Function name view_searchcarlisting 
    *Detailed View of coding
    *Car Fetures Fetched from master
    *Similar Cars Listed Below
    */
    public function view_searchcarlisting()
    {
      //print_r($_POST);

      if($this->login_authecation==1){
        $id               = session::get('ses_id'); 
        $dms_dealers_tablename = 'dms_dealers';
        $dealer_wherecondition    = array('d_id'=>$id);
        $fetchupdate              = buyymodel::masterFetchTableDetails($id,$dms_dealers_tablename,$dealer_wherecondition);
        if(count($fetchupdate)>0)
        {
          $parent_id        = $fetchupdate[0]->parent_id; 
          if($parent_id!=0)
          {       
            $id               = $parent_id; 
          }
          
        }
        $city_name        =Input::get('city_name');
        $sites            =Input::get('sites');
        $vehicle_make     =Input::get('vehicle_make');
        $vehicle_model    =Input::get('vehicle_model');
        $registration_year=Input::get('registration_year');
        $transmission     =Input::get('transmission_type');
        $fueltype         =Input::get('fuel_type');
        $price_range      =Input::get('price_filter');
        $minvalue_filter  =Input::get('minvalue_filter');
        $maxvalue_filter  =Input::get('maxvalue_filter');
        $body_type        =Input::get('body_type');
        $budgetsorting    =Input::get('budgetsorting');
        $listypeselect    =Input::get('listypeselect');
        $search_listing   =Input::get('search_listing');
        $listing_details  = array();
        $wherecondition   = array();
        $makearray        = array();
        if(!empty($vehicle_make))
        {
            $wherecondition['make_id']          =$vehicle_make;
        }
        if(!empty($sites))
        {
            $wherecondition['sitename']         =$sites;
        }
        if(!empty($listypeselect))
        {
            foreach ($listypeselect as $key => $value) {
              $wherecondition['listing_selection'][]=intval($value);
            }            
        }
        if($vehicle_model!='')
        {
            $wherecondition['model']            =array($vehicle_model);
        }
        if($registration_year!='')
        {
            $wherecondition['registration_year']=array($registration_year);
        }
        if($transmission!='')
        {
            $wherecondition['transmission']     =array($transmission);
        }
        if($fueltype!='')
        {
            $wherecondition['fuel_type']        =array($fueltype);
        }
        if(!empty($body_type))
        {
            $wherecondition['body_type']        =$body_type;
        }
        if($city_name!='')
        {
            $wherecondition['car_locality']     =array($city_name);
        }
        if($price_range!='' && $price_range!='undefined')
        {
            if($maxvalue_filter!='Above')
            {
              $wherecondition['sell_price']       =array((int) $minvalue_filter, (int) $maxvalue_filter);
            }
            else
            {
              $wherecondition['sell_price']       =array((int) $minvalue_filter,$maxvalue_filter);
            }
        }
        //print_r($wherecondition);
        switch ($budgetsorting) {
            case "0":
                $sortingcolumn = 'sell_price';
                $sortingcond = 'desc';
                break;
            case "1":
                $sortingcolumn = 'sell_price';
                $sortingcond = 'asc';
                break;
            case "2":
                $sortingcolumn = 'kilometer_run';
                $sortingcond = 'desc';
                break;
            case "3":
                $sortingcolumn = 'kilometer_run';
                $sortingcond = 'asc';
                break;
            case "4":
                $sortingcolumn = 'registration_year';
                $sortingcond = 'asc';
                break;
            case "5":
                $sortingcolumn = 'registration_year';
                $sortingcond = 'desc';
                break;
            case "6":
                $sortingcolumn = 'created_at';
                $sortingcond = 'desc';
                break;
            case "7":
                $sortingcolumn = 'created_at';
                $sortingcond = 'asc';
                break;
            default:
                $sortingcolumn = 'sell_price';
                $sortingcond = 'asc';
        }
        

        $listing_orwherecondition = array();
        if($search_listing!='')
        {
            $listing_orwherecondition['make']     =$search_listing;
            $listing_orwherecondition['model']    =$search_listing;
            $listing_orwherecondition['variant']  =$search_listing;
        }
        $paginatenolisting       = Config::get('common.paginatenolisting');
        $mongo_carlisting_details = mongomodel::where(function($q) use (                                                    $wherecondition){
                                    foreach($wherecondition as $key => $value){
                                        if($key!='sell_price')
                                        {
                                          if(!empty($value))
                                          {
                                              $q->wherein($key, $value);
                                          }
                                        }
                                        else if($key=='sell_price')
                                        {
                                          if(!empty($value))
                                          {
                                              if($value[1]!='Above')
                                              {
                                                $q->wherebetween($key, $value);
                                              }
                                              else
                                              {
                                                $q->where($key,'>', $value[0]);
                                              }
                                          }
                                        }
                                    }
                                    })->where(function($q) use ($listing_orwherecondition){
                                        foreach($listing_orwherecondition as $key => $value){                                          
                                              $q->orwhere($key,'like','%'.$value.'%');
                                           
                                        }
                                    })->where('dealer_id','<>',$id)
                                      ->orderby($sortingcolumn,$sortingcond)
                                      ->paginate($paginatenolisting); 
        $buycontroller = new buy;
        $listing_details = $buycontroller->searchcarlistingarraybulider($mongo_carlisting_details);
        $paginate_link      =$mongo_carlisting_details->links();
        $compact_array      = array('paginate_link'=>$paginate_link,
                                    'listing_details'=>$listing_details,
                                    );        

        return view('buysearchlistingajax',compact('compact_array'));
      }
      else
      {
        return 'sessionout';
      }
    }    

    /*
    *The Function name sentQueries 
    *Message and file communication of dealers
    */
    public function sentQueries()
    {    
        if($this->login_authecation==1){
        $id                       = session::get('ses_id');
        $contact_transactioncode  = Input::get('contact_transactioncode');
        $notification_type_id     = Input::get('notification_type_id');
        $queries_contact_title    = Config::get('common.queries_contact_title');
        $dublicate_id = Input::get('car_id');
        $data                     = array();
        $messagedetails           = array();
        $dms_dealers_tablename    = 'dms_dealers';
        $dealer_wherecondition    = array('d_id'=>$id);
        $fetchupdate              = buyymodel::masterFetchTableDetails($id,$dms_dealers_tablename,$dealer_wherecondition);

        $dealer_schemaname        = $fetchupdate[0]->dealer_schema_name; 
        $fromdealer_name          = $fetchupdate[0]->dealer_name;
        $from_email               = $fetchupdate[0]->d_email;
        $frommobileno             = $fetchupdate[0]->d_mobile;
        $dealer_profile_image     = $fetchupdate[0]->logo;
        
        $to_dealer_wherecondition = array('d_id'=>Input::get('to_dealer_id'));
        $to_dealer_id_fetch       = buyymodel::masterFetchTableDetails($id,$dms_dealers_tablename,$to_dealer_wherecondition);
        $to_dealer_name           = $to_dealer_id_fetch[0]->dealer_name;
        $to_dealer_email          = $to_dealer_id_fetch[0]->d_email;
        $to_dealer_mobile         = $to_dealer_id_fetch[0]->d_mobile;
        $to_dealer_schema_name    = $to_dealer_id_fetch[0]->dealer_schema_name;
        $to_dealer_profile_image  = $to_dealer_id_fetch[0]->logo;             

        $table                    = 'dealer_contact_message_transactions';
        $total                    = count(Input::file('dealer_upload'));
        
        $insertrecord             = array('from_dealer_id'=>$id,
                                          'to_dealer_id'=>Input::get('to_dealer_id'),
                                          'contact_transactioncode'=>$contact_transactioncode,
                                          'car_id'=>Input::get('car_id'),
                                          'title'=>$queries_contact_title,
                                          'dealer_name'=>$fromdealer_name,
                                          'dealer_email'=>$from_email,
                                          'mobile'=>$frommobileno,
                                          'message'=>Input::get('text_area'),
                                          'delear_datetime'=>date('Y-m-d H:i:s'),
                                          'document_link'=>$total,
                                          'user_id'=>$id
                                          );

        $theard_id                = 	buyymodel::dealerInsertTable($id,$dealer_schemaname,$table,$insertrecord);
        $insertrecord['status']   = 	1;
        $last_theard_id           = 	buyymodel::dealerInsertToTable($id,$to_dealer_schema_name,$table,$insertrecord);
        $file_extentions = Config::get('fileuploadrestrictions.myqueries_file_formats');
        
        $data['contact_message_grid_html'] = Input::get('text_area');
        $data['downloadlink']              = '0';   
        $data['delear_datetime']           = 'Now';   
        $data['dealer_profile_image']      = $dealer_profile_image;   
        array_push($messagedetails, $data); 
        if(!empty(Input::file('dealer_upload'))){
        foreach (Input::file('dealer_upload') as $file) {
            $extension = $file->getClientOriginalExtension();   

            $filename = $file->getClientOriginalName();
            if (in_array($extension, $file_extentions))
            {
              $destinationPath      = public_path().'/queriesdocuments/';
              $image_upload_result  = fileuploadmodel::any_upload($file,$destinationPath,$extension);
              $realpath             = url('queriesdocuments/'.$image_upload_result);            
              $fileContents         = public_path("/queriesdocuments/").$image_upload_result;
              $result               = Storage::put("/uploadimages/".$dealer_schemaname."/inventory/".$dublicate_id.'/queriesdocuments/'.$contact_transactioncode.'/'.$image_upload_result, file_get_contents($realpath),'public');
              $s3_bucket_path =Config::get('common.s3bucketpath').$dealer_schemaname.'/inventory/'.$dublicate_id.'/queriesdocuments/'.$contact_transactioncode.'/'.$image_upload_result;
              unlink($fileContents);

              $document_table       = 'contact_documents_table';
              $documents_insert     = array('id'=>$theard_id,
                                         'file_name'=>$filename,
                                         'file_url'=>$s3_bucket_path);

              $to_documents_insert  = array('id'=>$last_theard_id,
                                         'file_name'=>$filename,
                                         'file_url'=>$s3_bucket_path);

              buyymodel::dealerInsertTable($id,$dealer_schemaname,$document_table,$documents_insert);

              buyymodel::dealerInsertToTable($id,$to_dealer_schema_name,$document_table,$to_documents_insert);
              
              $data['contact_message_grid_html'] = $s3_bucket_path;
              $data['downloadlink']              = '1';   
              $data['delear_datetime']           = 'Now';   
              $data['dealer_profile_image']      = $dealer_profile_image;   
              array_push($messagedetails, $data);     
            }
         }
        }
        //$queries_notification_type_id = config::get('common.queries_notification_type_id');
        $notification_type         = notificationsmodel::get_notification_dealer_type($notification_type_id);
        $notification_message = 'Lead enquiry-'.' '.$fromdealer_name.' '.Input::get('title').' '.Input::get('text_area');

        $dealer_notification       = array( 'user_id'=>$id,
                                            'd_id'=>Input::get('to_dealer_id'),
                                            'notification_type_id'=>$notification_type_id,
                                            'title'=>Input::get('title'),
                                            'notification_type'=>$notification_type[0]->notification_type_name,
                                            'message'=>$notification_message,
                                            'contact_transactioncode'=>$contact_transactioncode,        
                                            'status'=>1);
        notificationsmodel::dealer_notification_insert($to_dealer_schema_name,$dealer_notification);
        $compact_array              = array('messagedetails'=>$messagedetails);
        //Mail Send Start
        $maildata                   = array('0'=>$to_dealer_profile_image,
                                            '1'=>$to_dealer_name,
                                            '2'=>$fromdealer_name,
                                            '3'=>$dealer_profile_image,
                                            '4'=>Input::get('text_area'),
                                            );
        $queries_email_template_id =    config::get('common.queries_email_template_id');
        $email_template_data       =    emailmodel::get_email_templates($queries_email_template_id);

        foreach ($email_template_data as $row) 
        {
          $mail_subject  =  $row->email_subject;
          $mail_message  =  $row->email_message;
          $mail_params   =  $row->email_parameters; 
        }

        $send_email        = $to_dealer_email;
        $email_template    = emailmodel::emailContentConstruct($mail_subject,$mail_message,$mail_params,$maildata);
        $email_sent        = emailmodel::email_sending($send_email,$email_template);
        //Mail End
        //Sms Queries Start
        $phone              = $to_dealer_mobile;
        $smsdata            = array($to_dealer_name,$fromdealer_name);
        $queries_sms_id     = Config::get('common.queries_sms_id');
        $sms_template_data  = smsmodel::get_sms_templates($queries_sms_id);

        $sms_template       = smsmodel::smsContentConstruct($sms_template_data[0]->sms_subject,$sms_template_data[0]->sms_message,$sms_template_data[0]->sms_parameters,$smsdata);

        $sms_data           = array('sms_template_data'=>$sms_template,
                                  'phone'=>$phone);
        $sms_sent           = smsmodel::sendsmsarray($sms_data);
        //SMS Queries End
        return view('queriesload',compact('compact_array'));
        }
        else{
            return 'sessionout';
        }
        
    }
    public function employee_type()
    {
      /*print_r($_POST);
      exit;*/
      
      $employee                       = Input::get('employee_type');      
      $all_employee                   = employeemodel::employeetable()->get();
      $employees_list                 = employeemodel::employeetable();
      $employee_type                  = employeemodel::employee_type(); 
      $employee_count         = employeemodel::employeetable()->count();
      if($employee == 0)
      {
        $employee_empty         = employeemodel::employeetable()->where('employee_status','active')->count();  
      }  
      else
      {
        $employee_empty         = employeemodel::employeetable()->where('employee_type',$employee)->where('employee_status','active')->count(); 
      }   
      $compact_array          = array
                        (
                          'all_employee'   => $all_employee,

                          'employee_type'  => $employee_type,             

                          'employee_empty' => $employee_empty

                        );                  
    if($employee == 0)
          {
            $employee_list = $employees_list->where('employee_status','active')->get();            
          }                         
      foreach($employee_type as $employee_value)
      {
          $employee_type_id = $employee_value->employee_type_id;
        $employee_type    = $employee_value->employee_type;       
        if($employee_type_id == $employee)
        {

          $employee_list = $employees_list->where('employee_type',$employee)->where('employee_status','active')->get(); 

        }       
      }     
      return view('manage_emp_tbl',compact('compact_array','employee_list'));                       

    }
    public function contact_type()
    {       


        $contact                        = Input::get('contact_type');        
        $fetch_contact                  = contactsmodel::contact_table()
                                           ->where('contact_status',config::get('common.contact_status_active'))->paginate(10);
        $contact_list                   = contactsmodel::contact_table();
        $contact_type                   = contactsmodel::contact_type()->get();        
        $contact_count                  = contactsmodel::contact_table()->count();
       if($contact == 0)
       {

            $contact_empty                    = contactsmodel::contact_table()->where('contact_status',config::get('common.contact_status_active'))->count();
       }    
       else{

            $contact_empty                  = contactsmodel::contact_table()->where('contact_status',config::get('common.contact_status_active'))->where('contact_type_id',$contact)->count(); 
       }     
       
            
        $compact_array                  = array
                                            (
                                                'all_employee'   => $fetch_contact,

                                                'contact_type'  => $contact_type,                     

                                                'contact_empty' => $contact_empty,                                                

                                            ); 
        if($contact == 0)
        {

            $contact_list = $contact_list->where('contact_status',config::get('common.contact_status_active'))->get();
            foreach ($contact_list as $key) 
            {
                $id = encrypt($key->contact_management_id);
                $key->encryptid  = $id;
            }           
        }
        foreach($contact_type as $contact_value)
        {
            $contact_type_id = $contact_value->contact_type_id;
            $contact_type    = $contact_value->contact_type;
            if($contact_type_id == $contact)
            {                

                $contact_list = $contact_list->where('contact_status',config::get('common.contact_status_active'))->where('contact_type_id',$contact)->get();  
                foreach($contact_list as $key)
                {
                  $id = encrypt($key->contact_management_id);
                  $key->encryptid  = $id;
                }       
            }           
        }   
        return view('manage_contact_tbl',compact('compact_array','contact_list'));
    } 
    public function user_type()
    {     
      $id                             = session::get('ses_id');
      $dealer_schemaname              = $this->dealer_schemaname;
      $user                           =  Input::get('user_type');
      $all_user                       =  usersmodel::select_all_user($dealer_schemaname,$this->dmsusertable);
      $user_type                      = usersmodel::user_type(); 
      /*dd($user_type);*/
      if($user == 0)
      {
        $user_empty       = usersmodel::user_all_count($dealer_schemaname,$this->dmsusertable);   
      }
      else
      {
        $user_empty             =usersmodel::user_type_count($dealer_schemaname,$this->dmsusertable,$user);       
      }
      $compact_array          = array
                        (
                          'all_user'   => $all_user,

                          'user_type'  => $user_type,             

                          'user_empty' => $user_empty

                        );    
    if($user == 0)
    {
      $user_list = usersmodel::select_all_user($dealer_schemaname,$this->dmsusertable); 
      return view('user_details',compact('compact_array','user_list'));                  
    }
    foreach($user_type as $user_value)
      {
          $user_type_id = $user_value->master_role_id;
          $user_type    = $user_value->master_role_name;        
          if($user_type_id == $user)
          {

            $user_list = usersmodel::user_type_select($dealer_schemaname,$this->dmsusertable,$user); 

          }       
      }    
      return view('user_details',compact('compact_array','user_list'));       

    }
}