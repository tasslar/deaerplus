<?php
 /* 
    Module Name : Inventory   
    Created By  : Naveen 22-02-2017
    Use of this module is Add Inventory, Add the car details,Saved Cars
    
    //Before Functions
    Basic info,images,videos,documents,specification,online portal
*/
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Controllers\inventory;
use App\model\commonmodel;
use App\model\buymodel;
use App\model\mongomodel;
use App\model\inventorymodel;
use App\model\emailmodel;
use App\model\smsmodel;
use App\model\notificationsmodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Config;
use Session;
use Carbon\Carbon;
/**
* 
*/
class ajaxinventory extends Controller
{    
    public $login_authecation;
    public $dealer_schemaname;
	public $dealer_id;
    public function __construct(Request $request)
    {
        ini_set('max_execution_time',0);
        $this->middleware(function ($request, $next)
        {
            $this->login_authecation  = session()->has( 'ses_dealername' ) ? 1 :  0;  
            $this->dealer_schemaname=Session::get('dealer_schema_name');
            $this->dealer_id=Session::get('ses_id');
            return $next($request);
        }); 
    }
    //managelist tab functionality
    public function managelistingtab()
    {
        if($this->login_authecation==1){
            $id = Session::get('ses_id');
            $dealer_schemaname = $this->dealer_schemaname;
            $wherecondition = array();
            $dms_car_listings = 'dms_car_listings';
            $tabcategory = Input::get('tabcategory');
            $sortorder = Input::get('sortorder');
            switch ($sortorder) {
                case "0":
                    $sortingcolumn = 'price';
                    $sortingcond = 'desc';
                    break;
                case "1":
                    $sortingcolumn = 'price';
                    $sortingcond = 'asc';
                    break;
                case "2":
                    $sortingcolumn = 'mileage';
                    $sortingcond = 'desc';
                    break;
                case "3":
                    $sortingcolumn = 'mileage';
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
                default:
                    $sortingcolumn = 'updated_at';
                    $sortingcond = 'desc';
            }
            //$sortcondition = array($sortingcolumn=>$sortingcond);
            
            switch ($tabcategory) {
                case 'parkandsell':
                    $wherecondition['inventory_type']=$tabcategory;
                break;

                case 'own':
                    $wherecondition['inventory_type']=$tabcategory;
                break;

                case 'draft':
                    $wherecondition['car_master_status']=0;
                break;

                case 'sold':
                    $wherecondition['car_master_status']=3;
                break;

                case 'deleted':
                    $wherecondition['car_master_status']=4;
                break;

                case 'live':
                    $wherecondition['car_master_status']=2;
                break;
            }
            
            $param = array('car_id','duplicate_id','inventory_type','car_master_status','model_id','variant','mileage','registration_year','price','kms_done','fuel_type','car_master_status','funding_applied','funding_ticket_number');
            
            $inventorydata = inventorymodel::inventoryTableDetails($dealer_schemaname,$dms_car_listings,$wherecondition,$param,$sortingcolumn,$sortingcond);
            $paginatelink = $inventorydata->links();
            $data = array();
            $inventorylistingdata = array();
            foreach ($inventorydata as $inventorykey => $inventoryvalue) {
                
                $pricing_data = inventorymodel::dealerFetchTableDetails($dealer_schemaname,'dealer_cars_pricing',array('listing_id'=>$inventoryvalue->car_id));

                $data['duplicate_id']=$inventoryvalue->car_id;
                $data['inventory_type']=$inventoryvalue->inventory_type;
                $data['car_master_status']=$inventoryvalue->car_master_status;
                //$data['sold_status']=$inventoryvalue->sold_status;
                $data['model_id']=$inventoryvalue->model_id;
                $data['variant']=$inventoryvalue->variant;
                $data['kms_done']=$inventoryvalue->kms_done;
                $data['registration_year']=$inventoryvalue->registration_year;
                $data['mileage']=$inventoryvalue->mileage;
                $data['price']=$inventoryvalue->price;
                $data['fuel_type']=$inventoryvalue->fuel_type;
                $data['funding_applied']=$inventoryvalue->funding_applied;
                $data['funding_ticket_number']=$inventoryvalue->funding_ticket_number;
                if(count($pricing_data)>0)
                {
                    $data['test_drive']=$pricing_data[0]->test_drive;
                }
                else
                {
                    $data['test_drive']=0;
                }
                $data['listing_status']=$inventoryvalue->car_master_status;
                
                $fetchmodel = inventorymodel::master_table_makeid_model_varient('master_models','model_id',$inventoryvalue->model_id);     
                if(count($fetchmodel) >= 1){
                    $modelname = $fetchmodel[0]->model_name;
                }
                else{
                    $modelname = 'Empty Name';
                }
                $data['modelname']=$modelname;
                $fetchvariant = inventorymodel::master_table_makeid_model_varient('master_variants','variant_id',$inventoryvalue->variant);
                if(count($fetchvariant) >= 1){
                    $variant_name = $fetchvariant[0]->variant_name;
                }
                else{
                    $variant_name = 'Empty Name';
                }
                $data['variant_name']=$variant_name;
                $data['title']=$modelname.' '.$variant_name.' '.$data['registration_year'];

                $DmsCarListPhotosTable = 'dms_car_listings_photos';
                $DmsCarListVideosTable = 'dms_car_listings_videos';
                $DmsCarListDocumentTable = 'dms_car_listings_documents';
                
                $imagefetch = inventorymodel::inventoryImageDetails($dealer_schemaname,$DmsCarListPhotosTable,array('car_id'=>$inventoryvalue->car_id));
                if(count($imagefetch)>0)
                {
                    $data['image'] = $imagefetch[0]->s3_bucket_path;
                }
                else
                {
                    $data['image'] = config::get('common.carnoimage');   
                }
                $data['viewscount'] = inventorymodel::masterTableCount(
                                    'dealer_viewed_cars',
                                    array('car_id'=>
                                    $inventoryvalue->duplicate_id)
                                    );
                $data['imagecount'] = inventorymodel::dealerTableCount($dealer_schemaname,$DmsCarListPhotosTable,array('car_id'=>$inventoryvalue->car_id));
                $data['videocount'] = inventorymodel::dealerTableCount($dealer_schemaname,$DmsCarListVideosTable,array('car_id'=>$inventoryvalue->car_id));
                $data['documentcount'] = inventorymodel::dealerTableCount($dealer_schemaname,$DmsCarListDocumentTable,array('car_id'=>$inventoryvalue->car_id));

                $data['queriescount'] = inventorymodel::dealerSellQueriesCount($id,$dealer_schemaname,array($inventoryvalue->duplicate_id));

                array_push($inventorylistingdata, $data);
            }
            return view('sellsearchlistingajax',compact('inventorylistingdata','paginatelink'));
        }
        else
        {
            return 'sessionout';
        }
    }

    //status update in dahsboard iventry
    public function managelisting_status()
    {       
        if($this->login_authecation==1){

            $status_val         = Input::get('status');
            $duplicateid        = Input::get('duplicateid');
            
            $id                 = session::get('ses_id');
            $whereSchema        = array('car_id' => $id);
            $dealer_schemaname  = $this->dealer_schemaname;
            
            $dms_car_listings = 'dms_car_listings';
            
            $wherecheck         = array('car_id'=>$duplicateid);
            //Not Updated
            $status             = 0;
            
            if(Input::get('status') == 'delete'){
                $UpdateArray        = array("car_master_status" => 4);
                $WhereDmsListing    = array('car_id'=>$duplicateid);
            
                $update_data        = inventorymodel::dealerUpdateTableDetails(                                            $id,
                                                            $dealer_schemaname,
                                                            $dms_car_listings,
                                                            $WhereDmsListing,
                                                            $UpdateArray
                                                            );
                $setdata = array('listing_status'=>'Inactive');
                $listing_details = inventorymodel::dealerFetchTableDetails($dealer_schemaname,$dms_car_listings,array('car_id'=>$duplicateid));
                $listing_id = $listing_details[0]->duplicate_id;
                mongomodel::where('listing_id',$listing_id)->update($setdata);
                if($update_data>0)
                {   
                    //Updated Successfully
                    $status = 1;
                }
            }
            elseif(Input::get('status') == 'readyforsale'){
                
                
                $DealerCarPricingTable = 'dealer_cars_pricing';
                $DmsCarListPhotosTable = 'dms_car_listings_photos';
                
                $fetch_listing      = buymodel::dealerFetchTableDetails($id,$dealer_schemaname,$dms_car_listings,array('car_id'=>$duplicateid));


                $photoscount           = inventorymodel::dealerTableCount($dealer_schemaname,$DmsCarListPhotosTable,array('car_id'=>$duplicateid));

                $pricingcount          = inventorymodel::dealerTableCount($dealer_schemaname,$DealerCarPricingTable,array('listing_id'=>$duplicateid));
                if($photoscount>0&&$fetch_listing[0]->price>0)
                {
                    $UpdateArray        = array("car_master_status" => 1);
                    $WhereDmsListing    = array('car_id'=>$duplicateid);
            
                    $update_data        = inventorymodel::dealerUpdateTableDetails(                                            $id,
                                                            $dealer_schemaname,
                                                            $dms_car_listings,
                                                            $WhereDmsListing,
                                                            $UpdateArray
                                                            );
                    if($update_data>0)
                    {
                        //Updated Successfully
                        $status = 1;
                    }
                }
                elseif($photoscount<0&&$fetch_listing[0]->price>0)
                {
                    //Image Tab is not filled
                    $status = 2;
                }
               
                elseif($photoscount>0&&$fetch_listing[0]->price<0)
                {
                    //Pricing Tab and Image Tab is not filled
                    $status = 3;
                }
                else
                {
                    $status = 4;
                }
            }
            elseif(Input::get('status') == 'sold'){
                $UpdateArray        = array("car_master_status" => 3);
                $WhereDmsListing    = array('car_id'=>$duplicateid);
            
                $update_data        = inventorymodel::dealerUpdateTableDetails(                                            $id,
                                                            $dealer_schemaname,
                                                            $dms_car_listings,
                                                            $WhereDmsListing,
                                                            $UpdateArray
                                                            );
                if($update_data>0)
                {
                    //Updated Successfully
                    $status = 1;
                }

            }

            return json_encode($status);
        }
        else
        {
            return 'sessionout';
        }        
    }

    public function ajaxcontactdealermessage()
    {
        if($this->login_authecation==1){
        $id = session::get('ses_id'); 
        $queries_contact_title    = Config::get('common.queries_contact_title');
        $currentdate              = Carbon::now();
        $contact_transactioncode  = $currentdate->format('Ymdhis');
        
        $dms_dealers_tablename    = 'dms_dealers';
        $dealer_wherecondition    = array('d_id'=>$id);
        $fetchupdate = buymodel::masterFetchTableDetails($id,$dms_dealers_tablename,$dealer_wherecondition);
        $dealer_schemaname        = $fetchupdate[0]->dealer_schema_name; 
        $fromdealer_name          = $fetchupdate[0]->dealer_name;
        $from_email               = $fetchupdate[0]->d_email;
        $from_mobileno            = $fetchupdate[0]->d_mobile;
        $dealer_profile_image     = $fetchupdate[0]->logo;

        $to_dealer_wherecondition = array('d_id'=>Input::get('dealer_id'));
        $to_dealer_id_fetch       = buymodel::masterFetchTableDetails($id,$dms_dealers_tablename,$to_dealer_wherecondition);
        $to_dealer_name           = $to_dealer_id_fetch[0]->dealer_name;
        $to_dealer_email          = $to_dealer_id_fetch[0]->d_email;
        $to_dealer_mobile         = $to_dealer_id_fetch[0]->d_mobile;
        $to_dealer_schema_name    = $to_dealer_id_fetch[0]->dealer_schema_name;
        $to_dealer_profile_image  = $to_dealer_id_fetch[0]->logo;             
        
        $data = array('from_dealer_id'=>$id,
                      'contact_transactioncode'=>$contact_transactioncode,
                      'to_dealer_id'=>Input::get('dealer_id'),
                      'mobile'=>$from_mobileno,
                      'car_id'=>Input::get('car_id'),
                      'dealer_name'=>Input::get('contact_dealer_name'),
                      'dealer_email'=>Input::get('contact_dealer_mailid'),
                      'message'=>Input::get('contact_dealer_message'),
                      'title'=>$queries_contact_title,
                      'delear_datetime'=>date('Y-m-d H:i:s'),
                      'user_id'=>$id,
                      );

        $table                    = 'dealer_contact_message_transactions';                  

        $theard_id                = buymodel::dealerInsertTable($id,$dealer_schemaname,$table,$data);
        $data['status']           = 1;
        $last_theard_id           = buymodel::dealerInsertToTable($id,$to_dealer_schema_name,$table,$data);

        $queries_notification_type_id= config::get('common.receive_queries_notification_type_id');
        $notification_type           = notificationsmodel::get_notification_dealer_type($queries_notification_type_id);
        
        $notification_message = 'Lead enquiry-'.' '.$fromdealer_name.' '.Input::get('make_model_variant').' '.Input::get('contact_dealer_message');
        $dealer_notification         = array( 'user_id'=>$id,
                                            'd_id'=>Input::get('dealer_id'),
                                            'notification_type_id'=>$queries_notification_type_id,
                                            'title'=>Input::get('make_model_variant'),
                                            'notification_type'=>$notification_type[0]->notification_type_name,
                                            'message'=>$notification_message,        
                                            'status'=>1,
                                            'contact_transactioncode'=>$contact_transactioncode);
        notificationsmodel::dealer_notification_insert($to_dealer_schema_name,$dealer_notification);

        //Mail Send Start
        $maildata                   = array('0'=>$to_dealer_profile_image,
                                            '1'=>$to_dealer_name,
                                            '2'=>$fromdealer_name,
                                            '3'=>$dealer_profile_image,
                                            '4'=>Input::get('contact_dealer_message'),
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
        //End SMS
        echo json_encode(array('success'=>true,'data'=>$last_theard_id));
        }
        else
        {
            return 'sessionout';
        }
    }	
}