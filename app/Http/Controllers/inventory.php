<?php
 /* 
    Module Name : Inventory   
    Created By  : hemanand 01-12-2016  
    Use of this module is Add Inventory, Add the car details,Saved Cars
    
    //Before Functions
    Basic info,images,videos,documents,specification,online portal
*/
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Validator;
use App\model\dms_car_listings;
use App\model\dms_car_listings_photos;
use App\model\dms_car_listings_videos;
use App\model\fileuploadmodel;
use App\model\dms_car_list;
use App\model\commonmodel;
use App\model\buymodel;
use App\model\buyymodel;
use App\model\dealermodel;
use App\model\mongomodel;
use App\model\fundingmodel;
use App\model\schemamodel;
use App\model\inventorymodel;
use App\model\contactsmodel;
use App\model\shortnerurl;
use App\model\emailmodel;
use App\model\smsmodel;
use App\model\ibb;
use App\model\obv;
use App\model\fastlane;
use App\model\fastlanemongo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Hash;
use App\Http\Controller\sms_gateway\smsgateway_integrate;
use App\model\notificationsmodel;
use DB;
use Response; 
use Config;
use Session;
use Redirect;
use Youtube;
use Carbon\Carbon;
use PDF;
use App;

/**
* 
*/
class inventory extends Controller
{
    //protected $language;
    public $SchemaTable;
    public $DmsCarListTable;
    public $SchemaObject;
    public $DmsCarStatus;
    public $DuplicateMainId;
    public $DuplicateValueId;
    public $SchemaObjectResult;
    public $InventoryPrimayId;
    public $DmsCarListPhotosTable;
    public $DmsCarListDocumentTable;
    public $DmsCarListVideosTable;
    public $DealerViewedTable;  
    public $MasterCityTable;
    public $MasterVariantTable;
    public $MasterColorTable;
    public $DmsCarListingStatusTable;
    public $DmsOnlinePortalTable;
    public $DmsCarPurchaseTable;
    public $DealerCarExpensesTable;
    public $DealerCarPricingTable;    
    public $DmsDealerTable;
    public $mongophotos;
    public $mongovideos;
    public $mongodocuments;
    public $mongopurchase;
    public $mongopricing;
    public $mongoexpense;
    public $mongoonline;
    public $priceField;
    public $registrationyearField;
    public $mileageField;
    public $ascendingField;
    public $descendingField;
    public $statusResponse;
    public $active_menu_name;
    public $pricingstatus;
    public $ColumnPhoto;
    public $ColumnCarId;
    public $ColumnPhotoinventry;
    public $InventoryType;
    public $InventoryValue;
    public $mongopush_status;
    public $mongo_listing_id;
    public $dealercontactTable;  
    public $dealerfundingTable;  
	public function __construct(Request $request)
    {
        ini_set('max_execution_time',0);
        $this->active_menu_name         = "sell_menu";
        $this->DmsCarListTable          = "dms_car_listings";
        $this->DmsCarStatus             = "car_master_status";
        $this->DuplicateMainId          = "duplicate_id";
        $this->mongo_listing_id         = "listing_id";
        $this->InventoryPrimayId        = "inventory_primary_id";
        $this->DmsCarListPhotosTable    = "dms_car_listings_photos";
        $this->DmsCarListDocumentTable  = "dms_car_listings_documents";
        $this->DmsCarListVideosTable    = "dms_car_listings_videos";
        $this->DealerViewedTable        = "dealer_viewed_cars";
        $this->side_bar_active          = "branch";     
        $this->MasterCityTable          = "master_city";     
        $this->MasterVariantTable       = "master_variants";     
        $this->MasterColorTable         = "master_colors";
        $this->DmsCarListingStatusTable = "dms_car_listing_addinventor_status";
        $this->DmsOnlinePortalTable     = "dealer_online_portal";
        $this->DmsCarPurchaseTable      = "dealer_cars_purchase";
        $this->DealerCarExpensesTable   = "dealer_car_expenses";
        $this->DealerCarPricingTable    = "dealer_cars_pricing";     
        $this->DmsDealerTable           = "dms_dealers";
        $this->mongophotos              = "photos";
        $this->mongovideos              = "videos";
        $this->mongodocuments           = "documents";
        $this->mongopurchase            = "purchase";
        $this->mongopricing             = "pricing";
        $this->mongoexpense             = "expense";
        $this->mongoonline              = "online";        
        $this->priceField               = "price";
        $this->registrationyearField    = "registration_year";
        $this->mileageField             = "mileage";
        $this->ascendingField           = "asc";
        $this->descendingField          = "desc";
        $this->pricingstatus            = "pricing_status";
        $this->ColumnPhoto              = "photo_id";
        $this->ColumnCarId              = "car_id";
        $this->dealercontactTable       = "dealer_contact_management";
        $this->dealerfundingTable       =  "dealer_funding_details";
        $this->ColumnPhotoinventry      = "inventry_primary_id";
        $this->InventoryType            = "inventory_type";
        $this->InventoryValue           = "PARKANDSELL";
        $this->mongopush_status         = "mongopush_status";
        $this->statusResponse           = array('0'=>'0',
                                                '1'=>'1',
                                                '2'=>'2',
                                                '3'=>'3',
                                                '4'=>'4',
                                                '5'=>'5',
                                                '6'=>'6'
                                                );

        $this->middleware(function ($request, $next)
        {
            $this->login_authecation  = session()->has( 'ses_dealername' ) ? session()->get( 'ses_dealername' ) :  Redirect::to('login')->send();  

            $this->header_data      = commonmodel::commonheaderdata();
            $this->dealer_schemaname=Session::get('dealer_schema_name');
            $this->SchemaObject = new schemamodel;
            return $next($request);
        }); 
    }    

	public function managelisting()
    {
        if(empty(session::get('ses_id')))
        {
            return redirect('login');
        }
        else
        { 
            $compact_array            = array
                                            ('active_menu_name'=>$this->active_menu_name,                   
                                             'side_bar_active'=>1  
                                            );

            $header_data= $this->header_data;
            if(isset($_REQUEST['type'])){
                $type = $_REQUEST['type'];
            }
            else
            {
                $type = 'alllisting';
            }
            //$type = 'sold';
            

            $id = session::get('ses_id');
            $schemaname = session::get('dealer_schema_name');
            $email_count=notificationsmodel::email_notification_count($id,$schemaname);            
            $header_data['title']='My Inventory';
            //return view('sellsearchlistingajax',compact('compact_array','header_data','InventoryAllDetails','master_make','master_model','master_variant'));
            return view('managelisting',compact('compact_array','header_data','InventoryAllDetails','type'));
        }
    }

    


	public function fetch_make()
	{
		$businesstype_id=Input::get('businesstype_id');
		$make = DB::connection('mastermysql')->table('master_makes')->where('master_business_id',$businesstype_id)->get();
		echo json_encode($make);
	}
	public function fetch_model()
	{
		$make_id=Input::get('make');
		$make = DB::connection('mastermysql')->table('master_models')->wherein('make_id',$make_id)->get();		
		echo json_encode($make);
	}
    public function fetch_model_car()
    {
        $make_id=Input::get('make');
        $make = DB::connection('mastermysql')->table('master_models')->where('make_id',$make_id)->get();
        echo json_encode($make);
    }
     public function fetch_category()
    {
        $category_id=Input::get('category'); 
        $id = Session::get('ses_id');
        $variant_cat = commonmodel::master_variants()->where('variant_id',$category_id)->first();           
        $category_tbl = commonmodel::master_category()->where('category_id',$variant_cat->category_id)->first();
        $features = buymodel::masterFetchTableDetails($id,'master_car_features',array('variant_id'=>$category_id));
        //$category_tbl = commonmodel::master_category()->where('category_id',$variant_cat->category_id)->first();
        echo json_encode(array($category_tbl,$variant_cat,$features[0]));
    }

    public function fetch_citybranch()
    {
        $city_id=Input::get('city_id'); 
        $id = Session::get('ses_id');
        $dealer_schemaname = $this->dealer_schemaname;
        $branches = buymodel::dealerFetchTableDetails($id,$dealer_schemaname,'dms_dealer_branches',array('dealer_city'=>$city_id));
        echo json_encode($branches);
    }

	public function fetch_variant()
	{
		$variant_id=Input::get('variant');
		$variant = DB::connection('mastermysql')->table('master_variants')->where('model_id',$variant_id)->get();
		echo json_encode($variant);
	}
	
	
    public function listing_basic_info($listing_id)
    {
        $id                 = session::get('ses_id');
        $dealer_schemaname  = $this->dealer_schemaname;
        $listing_table      = $this->DmsCarListTable;
        $detail_list_data   = array();
        $fetch_listing      = buymodel::dealerFetchTableDetails($id,$dealer_schemaname,$listing_table,array('car_id'=>$listing_id));
        if(count($fetch_listing)>0){
            $car_id                                 = $fetch_listing[0]->duplicate_id;
            $variant_id                             = $fetch_listing[0]->variant;
            $make_id                                = $fetch_listing[0]->make;
            $model                                  = $fetch_listing[0]->model_id;
            $city_name                              = $fetch_listing[0]->car_city;
            $makename       = "";
            $modelname      = "";
            $variant_name   =   "";
            $fetchmake                      = schemamodel::master_table_makeid_model_varient('master_makes','make_id',$fetch_listing[0]->make);
            if(count($fetchmake) >= 1){
                $makename = $fetchmake[0]->makename;
            }else{
                $makename ='';
            }
                               
            $fetchmodel = schemamodel::master_table_makeid_model_varient('master_models','model_id',$fetch_listing[0]->model_id);     
            if(count($fetchmodel) >= 1){
                $modelname = $fetchmodel[0]->model_name;
            }else{
                $modelname ='';
            }
            
            $fetchvariant = schemamodel::master_table_makeid_model_varient('master_variants','variant_id',$fetch_listing[0]->variant);
            if(count($fetchvariant) >= 1){
                $variant_name = $fetchvariant[0]->variant_name;
            }
            else
            {
                $variant_name = '';
            }

            $body_type_name = buymodel::masterFetchTableDetails($id,'master_category',array('category_id'=>$fetch_listing[0]->category_id)); 
            if(count($body_type_name) >= 1){
                $body_type_category_name = $body_type_name[0]->category_description;
            }
            else{
                $body_type_category_name = '';   
            }        
            
            $created_at                             = $fetch_listing[0]->created_at;
            $detail_list_data['car_id']             = $fetch_listing[0]->duplicate_id;
            $detail_list_data['inventory_id']       = $fetch_listing[0]->car_id;
            $detail_list_data['created_at']         = $fetch_listing[0]->created_at;
            $detail_list_data['dealer_id']          = $fetch_listing[0]->dealer_id;
            $detail_list_data['make']               = $makename;
            $detail_list_data['make_id']            = $fetch_listing[0]->make;
            $detail_list_data['model']              = $modelname;
            $detail_list_data['model_id']           = $fetch_listing[0]->model_id;
            $detail_list_data['city_id']            = $fetch_listing[0]->car_city;
            $detail_list_data['variant']            = $variant_name;
            $detail_list_data['variant_id']         = $variant_id;
            $detail_list_data['registration_year']  = $fetch_listing[0]->registration_year;
            $detail_list_data['fuel_type']          = $fetch_listing[0]->fuel_type;
            $getresultcolor = schemamodel::master_table_color($this->MasterColorTable,
                                                                'colour_id',
                                                                $fetch_listing[0]->colors
                                                            );
            if(count($getresultcolor) > 0)
            {
                $detail_list_data['colors'] = $getresultcolor[0]->colour_name;
            }
            else
            {
                $detail_list_data['colors'] = '';
            }            
            if($fetch_listing[0]->car_city == "")
            {
                $detail_list_data['car_locality']       = "";
            }    
            else{
                $getcityname     =  schemamodel::master_table_where($this->MasterCityTable,
                                                                    "master_id",
                                                                    $fetch_listing[0]->car_city
                                                                );
                if(count($getcityname)>0){            
                $detail_list_data['car_locality']   = $getcityname[0]->city_name; }
                else
                    {$detail_list_data['car_locality']   = '';}
            }    
            

            
            $detail_list_data['owner_type']         = $fetch_listing[0]->owner_type;
            $detail_list_data['transmission']       = $fetch_listing[0]->transmission;
            $detail_list_data['kilometer_run']      = $fetch_listing[0]->kms_done;
            $detail_list_data['body_type']          = $body_type_category_name;
            $detail_list_data['mileage']            = $fetch_listing[0]->mileage;
            $detail_list_data['price']              = $fetch_listing[0]->price;
        }
        else
        {
            $detail_list_data['car_id']             = '';
            $detail_list_data['inventory_id']       = '';
            $detail_list_data['created_at']         = '';
            $detail_list_data['dealer_id']          = '';
            $detail_list_data['make']               = '';
            $detail_list_data['model']              = '';
            $detail_list_data['variant']            = '';
            $detail_list_data['variant_id']         = '';
            $detail_list_data['registration_year']  = '';
            $detail_list_data['fuel_type']          = '';
            $detail_list_data['colors']             = '';
            $detail_list_data['car_locality']       = "";
            $detail_list_data['owner_type']         = '';
            $detail_list_data['transmission']       = '';
            $detail_list_data['kilometer_run']      = '';
            $detail_list_data['body_type']          = '';
            $detail_list_data['mileage']            = '';
            $detail_list_data['price']              = '0';
        }

        return $detail_list_data;
    }
	
    public function listing_images($listing_id)
    {
        $id                 = session::get('ses_id');
        $dealer_schemaname  = session::get('dealer_schema_name');
        $photos_table       = $this->DmsCarListPhotosTable;
        return $fetch_photos       = buymodel::dealerFetchTableDetails($id,$dealer_schemaname,$photos_table,array('car_id'=>$listing_id));
    }
    public function listing_features($listing_id,$variant_id)
    {
        $id                 = session::get('ses_id');
        $dealer_schemaname  = $this->dealer_schemaname;
        $fetch_features     = buymodel::dealerFetchTableDetails($id,$dealer_schemaname,'dealer_listing_features',array('listing_id'=>$listing_id));
        if(count($fetch_features)>0)
        {
            $listing_features  = array(
                        'overviewdescription'=>commonmodel::doreplacetoNA($fetch_features[0]->overviewdescription),
                        'gear_box'=>commonmodel::doreplacetoNA($fetch_features[0]->gear_box),
                        'drive_type'=>commonmodel::doreplacetoNA($fetch_features[0]->drive_type),
                        'seating_capacity'=>$fetch_features[0]->seating_capacity,
                        'steering_type'=>commonmodel::doreplacetoNA($fetch_features[0]->steering_type),
                        'turning_radius'=>commonmodel::doreplacetoNA($fetch_features[0]->turning_radius),
                        'top_speed'=>commonmodel::doreplacetoNA($fetch_features[0]->top_speed),
                        'acceleration'=>commonmodel::doreplacetoNA($fetch_features[0]->acceleration),
                        'tyre_type'=>commonmodel::doreplacetoNA($fetch_features[0]->tyre_type),
                        'no_of_doors'=>commonmodel::doreplacetoNA($fetch_features[0]->no_of_doors),
                        'engine_type'=>commonmodel::doreplacetoNA($fetch_features[0]->engine_type),
                        'displacement'=>commonmodel::doreplacetoNA($fetch_features[0]->displacement),
                        'max_power'=>commonmodel::doreplacetoNA($fetch_features[0]->max_power),
                        'max_torque'=>commonmodel::doreplacetoNA($fetch_features[0]->max_torque),
                        'no_of_cylinder'=>commonmodel::doreplacetoNA($fetch_features[0]->no_of_cylinder),
                        'valves_per_cylinder'=>commonmodel::doreplacetoNA($fetch_features[0]->valves_per_cylinder),
                        'valve_configuration'=>commonmodel::doreplacetoNA($fetch_features[0]->valve_configuration),
                        'fuel_supply_system'=>commonmodel::doreplacetoNA($fetch_features[0]->fuel_supply_system),
                        'turbo_charger'=>commonmodel::doreplacetoNA($fetch_features[0]->turbo_charger),
                        'super_charger'=>commonmodel::doreplacetoNA($fetch_features[0]->super_charger),
                        'length'=>commonmodel::doreplacetoNA($fetch_features[0]->length),
                        'width'=>commonmodel::doreplacetoNA($fetch_features[0]->width),
                        'height'=>commonmodel::doreplacetoNA($fetch_features[0]->height),
                        'wheel_base'=>commonmodel::doreplacetoNA($fetch_features[0]->wheel_base),
                        'gross_weight'=>commonmodel::doreplacetoNA($fetch_features[0]->gross_weight),

                        'air_conditioner'=>$fetch_features[0]->air_conditioner,
                        'adjustable_steering'=>$fetch_features[0]->adjustable_steering,
                        'leather_steering_wheel'=>$fetch_features[0]->leather_steering_wheel,
                        'heater'=>$fetch_features[0]->heater,
                        'digital_clock'=>$fetch_features[0]->digital_clock,
                        'power_steering'=>$fetch_features[0]->power_steering,
                        'power_windows_front'=>$fetch_features[0]->power_windows_front,
                        'power_windows_rear'=>$fetch_features[0]->power_windows_rear,
                        'remote_trunk_opener'=>$fetch_features[0]->remote_trunk_opener,
                        'remote_fuel_lid_opener'=>$fetch_features[0]->remote_fuel_lid_opener,
                        'low_fuel_warning_light'=>$fetch_features[0]->low_fuel_warning_light,
                        'rear_reading_lamp'=>$fetch_features[0]->rear_reading_lamp,
                        'rear_seat_headrest'=>$fetch_features[0]->rear_seat_headrest,
                        'rear_seat_centre_arm_rest'=>$fetch_features[0]->rear_seat_centre_arm_rest,
                        'height_adjustable_front_seat_belts'=>$fetch_features[0]->height_adjustable_front_seat_belts,
                        'cup_holders_front'=>$fetch_features[0]->cup_holders_front,
                        'cup_holders_rear'=>$fetch_features[0]->cup_holders_rear,
                        'rear_ac_vents'=>$fetch_features[0]->rear_ac_vents,
                        'parking_sensors'=>$fetch_features[0]->parking_sensors,
                        'anti_lock_braking_system'=>$fetch_features[0]->anti_lock_braking_system,
                        'central_locking'=>$fetch_features[0]->central_locking,
                        'child_safety_lock'=>$fetch_features[0]->child_safety_lock,
                        'driver_airbags'=>$fetch_features[0]->driver_airbags,
                        'passenger_airbag'=>$fetch_features[0]->passenger_airbag,
                        'rear_seat_belts'=>$fetch_features[0]->rear_seat_belts,
                        'seat_belt_warning'=>$fetch_features[0]->seat_belt_warning,
                        'adjustable_seats'=>$fetch_features[0]->adjustable_seats,
                        'crash_sensor'=>$fetch_features[0]->crash_sensor,
                        'anti_theft_device'=>$fetch_features[0]->anti_theft_device,
                        'immobilizer'=>$fetch_features[0]->immobilizer,
                        'adjustable_head_lights'=>$fetch_features[0]->adjustable_head_lights,
                        'power_adjustable_exterior_rear_view_mirror'=>$fetch_features[0]->power_adjustable_exterior_rear_view_mirror,
                        'electric_folding_rear_view_mirror'=>$fetch_features[0]->electric_folding_rear_view_mirror,
                        'rain_sensing_wipers'=>$fetch_features[0]->rain_sensing_wipers,
                        'rear_window_wiper'=>$fetch_features[0]->rear_window_wiper,
                        'alloy_wheels'=>$fetch_features[0]->alloy_wheels,
                        'tinted_glass'=>$fetch_features[0]->tinted_glass,
                        'front_fog_lights'=>$fetch_features[0]->front_fog_lights,
                        'rear_window_defogger'=>$fetch_features[0]->rear_window_defogger,
                        'cdplayer'=>$fetch_features[0]->cdplayer,
                        'radio'=>$fetch_features[0]->radio,
                        'audio'=>$fetch_features[0]->audio,
                        'bluetooth'=>$fetch_features[0]->bluetooth,
                        );
        }
        else
        {
            $variant_id     = $variant_id;
            $fetchvariant   = buymodel::masterVariantDetail(array('variant_id'=>$variant_id));
            $listing_features = array(
            'overviewdescription'=>commonmodel::doreplacetoNA($fetchvariant->variant_desc),
            'gear_box'=>commonmodel::doreplacetoNA($fetchvariant->Gear_box),
            'drive_type'=>commonmodel::doreplacetoNA($fetchvariant->Drive_Type),
            'seating_capacity'=>commonmodel::doreplacetoNA($fetchvariant->Seating_Capacity),
            'steering_type'=>commonmodel::doreplacetoNA($fetchvariant->Steering_Gear_Type),
            'turning_radius'=>commonmodel::doreplacetoNA($fetchvariant->Turning_Radius),
            'top_speed'=>commonmodel::doreplacetoNA($fetchvariant->Top_Speed),
            'acceleration'=>commonmodel::doreplacetoNA($fetchvariant->Acceleration),
            'tyre_type'=>commonmodel::doreplacetoNA($fetchvariant->Tyre_Type),
            'no_of_doors'=>commonmodel::doreplacetoNA($fetchvariant->No_of_Doors),
            'engine_type'=>commonmodel::doreplacetoNA($fetchvariant->Engine_Description),
            'displacement'=>commonmodel::doreplacetoNA($fetchvariant->Engine_Displacementcc),
            'max_power'=>commonmodel::doreplacetoNA($fetchvariant->Maximum_Power),
            'max_torque'=>commonmodel::doreplacetoNA($fetchvariant->Maximum_Torque),
            'no_of_cylinder'=>commonmodel::doreplacetoNA($fetchvariant->No_of_Cylinders),
            'valves_per_cylinder'=>commonmodel::doreplacetoNA($fetchvariant->Valves_Per_Cylinder),

            'valve_configuration'=>commonmodel::doreplacetoNA($fetchvariant->valve_configuration),

            'fuel_supply_system'=>commonmodel::doreplacetoNA($fetchvariant->Fuel_Supply_System),
            'turbo_charger'=>commonmodel::doreplacetoNA($fetchvariant->Turbo_Charger),
            'super_charger'=>commonmodel::doreplacetoNA($fetchvariant->Super_Charger),
            'length'=>commonmodel::doreplacetoNA($fetchvariant->Length),
            'width'=>commonmodel::doreplacetoNA($fetchvariant->Width),
            'height'=>commonmodel::doreplacetoNA($fetchvariant->Height),
            'wheel_base'=>commonmodel::doreplacetoNA($fetchvariant->Wheel_Base),
            'gross_weight'=>commonmodel::doreplacetoNA($fetchvariant->Gross_Weight),
            'air_conditioner'=>$fetchvariant->Air_Conditioner,
            'adjustable_steering'=>$fetchvariant->Power_Steering,

            'leather_steering_wheel'=>$fetchvariant->leather_steering_wheel,
            'heater'=>$fetchvariant->heater,
            'digital_clock'=>$fetchvariant->digital_clock,

            'power_steering'=>$fetchvariant->Power_Steering,

            'power_windows_front'=>$fetchvariant->power_windows_front,
            'power_windows_rear'=>$fetchvariant->power_windows_rear,

            'remote_trunk_opener'=>$fetchvariant->Remote_Trunk_Opener,
            'remote_fuel_lid_opener'=>$fetchvariant->Remote_Fuel_Lid_Opener,
            'low_fuel_warning_light'=>$fetchvariant->Low_Fuel_Warning_Light,
            'rear_reading_lamp'=>$fetchvariant->Rear_Reading_Lamp,
            'rear_seat_headrest'=>$fetchvariant->Rear_Seat_Headrest,
            'rear_seat_centre_arm_rest'=>$fetchvariant->Rear_Seat_Center_Arm_Rest,
            'height_adjustable_front_seat_belts'=>$fetchvariant->Height_Adjustable_Front_Seat_Belts,
            'cup_holders_front'=>$fetchvariant->Cup_Holders_Front,
            'cup_holders_rear'=>$fetchvariant->Cup_Holders_Rear,
            'rear_ac_vents'=>$fetchvariant->Rear_A_C_Vents,
            'parking_sensors'=>$fetchvariant->Parking_Sensors,
            'anti_lock_braking_system'=>$fetchvariant->Anti_Lock_Braking_System,
            'central_locking'=>$fetchvariant->Central_Locking,
            'child_safety_lock'=>$fetchvariant->Child_Safety_Locks,
            'driver_airbags'=>$fetchvariant->Driver_Airbag,
            'passenger_airbag'=>$fetchvariant->Passenger_Airbag,
            'rear_seat_belts'=>$fetchvariant->Rear_Seat_Belts,
            'seat_belt_warning'=>$fetchvariant->Seat_Belt_Warning,
            'adjustable_seats'=>$fetchvariant->Adjustable_Seats,
            'crash_sensor'=>$fetchvariant->Crash_Sensor,
            'anti_theft_device'=>$fetchvariant->Anti_Theft_Alarm,
            'immobilizer'=>$fetchvariant->Engine_Immobilizer,
            
            'adjustable_head_lights'=>$fetchvariant->adjustable_head_lights,
            'power_adjustable_exterior_rear_view_mirror'=>$fetchvariant->power_adjustable_exterior_rear_view_mirror,
            'electric_folding_rear_view_mirror'=>$fetchvariant->electric_folding_rear_view_mirror,
            'rain_sensing_wipers'=>$fetchvariant->rain_sensing_wipers,
            'rear_window_wiper'=>$fetchvariant->rear_window_wiper,
            'alloy_wheels'=>$fetchvariant->alloy_wheels,
            'tinted_glass'=>$fetchvariant->tinted_glass,
            'front_fog_lights'=>$fetchvariant->front_fog_lights,
            'rear_window_defogger'=>$fetchvariant->rear_window_defogger,

            'cdplayer'=>$fetchvariant->CD_Player,
            'radio'=>$fetchvariant->FM_AM_Radio,
            'audio'=>$fetchvariant->Audio_System_Remote_Control,
            'bluetooth'=>$fetchvariant->Bluetooth_Connectivity,
        );
        }
        return $listing_features;
    }
	public function view_car_listing()
	{
        $id                 = session::get('ses_id');
        $listing_id         = Input::get('car_view_id');

        //dd($basic_info);
        $dealer_schemaname  = $this->dealer_schemaname;
        $detail_list_data   = array();   
        $listing_table      = $this->DmsCarListTable;
        $pricing_table      = $this->DealerCarPricingTable;
        $photos_table       = $this->DmsCarListPhotosTable;
        $videos_table       = $this->DmsCarListVideosTable;
        $online_table       = $this->DmsOnlinePortalTable;
        if (is_numeric($listing_id)) {
            $basic_info         = $this->listing_basic_info($listing_id);
        } else {
            $fetch_basic_info   = buyymodel::dealerFetchTableDetails($id,$dealer_schemaname,$listing_table,array('duplicate_id'=>$listing_id));
            $listing_id = $fetch_basic_info[0]->car_id;
            if(count($fetch_basic_info)>0)
            {
            $basic_info         = $this->listing_basic_info($fetch_basic_info[0]->car_id);
            }
            else
            {
            $basic_info         = '';  
            }
        }
        
        $fetch_listing      = $basic_info;
        $fetch_pricing      = buyymodel::dealerFetchTableDetails($id,$dealer_schemaname,$pricing_table,array('listing_id'=>$listing_id));
        $fetch_photos       = buyymodel::dealerFetchTableDetails($id,$dealer_schemaname,$photos_table,array('car_id'=>$listing_id));
        $fetch_videos       = buyymodel::dealerFetchTableDetails($id,$dealer_schemaname,$videos_table,array('car_id'=>$listing_id));
        $fetch_online       = buyymodel::dealerFetchTableDetails($id,$dealer_schemaname,$online_table,array('car_id'=>$listing_id));
        //CHECK FUNDING TICKET ID IS EXIST OR NOT STRAT
        $fundingticketid            =   "";
        $getfundingticketid         =   fundingmodel::doGetcardetailsfundingisexist($id,$listing_id);
        if(!empty($getfundingticketid) && count($getfundingticketid))
        {
            $getticketid            =   collect($getfundingticketid)->toArray();
            $fundingticketid        =   $getticketid[0]->dealer_funding_ticket_id;
        }
        //CHECK FUNDING TICKET ID IS EXIST OR NOT END
        $dms_dealers_tablename        = 'dms_dealers';
        $fetch_master_dealer_schema   = buyymodel::masterFetchTableDetails($id,$dms_dealers_tablename,array('d_id'=>$id));
        if(count($fetch_master_dealer_schema)>0)
        {
          $dealer_schemaname            = $fetch_master_dealer_schema[0]->dealer_schema_name;
          $dealer_name                  = $fetch_master_dealer_schema[0]->dealer_name;
          $d_email                      = $fetch_master_dealer_schema[0]->d_email;  
          $dealership_name              = $fetch_master_dealer_schema[0]->dealership_name;
          $d_mobile                     = $fetch_master_dealer_schema[0]->d_mobile;
          $d_city                       = $fetch_master_dealer_schema[0]->d_city;
          

        }

        $dealer_info = array(
                              'dealer_name'=>$dealer_name,
                              'dealership_name'=>$dealership_name,
                              'd_email'=>$d_email,
                              'd_mobile'=>$d_mobile,
                              'd_city'=>$d_city
                              );

        if(count($fetch_listing)>0&&count($fetch_pricing)>0)
        {
        $dms_dealers_tablename                  = 'dms_dealers';        
        $created_at                             = $fetch_listing['created_at'];
        $detail_list_data['car_id']             = $fetch_listing['car_id'];
        $detail_list_data['dealer_id']          = $fetch_listing['dealer_id'];
        $detail_list_data['make']               = $fetch_listing['make'];
        $detail_list_data['model']              = $fetch_listing['model'];
        $detail_list_data['variant']            = $fetch_listing['variant'];
        $detail_list_data['variant_id']         = $fetch_listing['variant_id'];
        $detail_list_data['registration_year']  = $fetch_listing['registration_year'];
        $detail_list_data['fuel_type']          = $fetch_listing['fuel_type'];
        $detail_list_data['owner_type']         = $fetch_listing['owner_type'];
        $detail_list_data['transmission']       = $fetch_listing['transmission'];
        $detail_list_data['kilometer_run']      = $fetch_listing['kilometer_run'];
        $detail_list_data['body_type']          = $fetch_listing['body_type'];
        $detail_list_data['mileage']            = $fetch_listing['mileage'];
        $detail_list_data['colors']             = $fetch_listing['colors'];        
        $detail_list_data['car_owner_mobile']   = ''; 
        $detail_list_data['car_owner_email']    = ''; 
        $detail_list_data['car_owner_name']     = '';
        $detail_list_data['car_address_1']      = '';
         
        $detail_list_data['car_city']           = $fetch_listing['car_locality'];
        $detail_list_data['car_locality']       = $fetch_listing['car_locality'];

        //Online Portal Table
        if(count($fetch_online)>0){
        $detail_list_data['auction']            = $fetch_online[0]->dealer_selection;
        $detail_list_data['auction_starttime']  = $fetch_online[0]->auction_startdate;
        $detail_list_data['auction_end_time']   = $fetch_online[0]->auction_end_date;
        $detail_list_data['created_at']         = $fetch_online[0]->created_at; 
        }else
        {
            $detail_list_data['auction']            = '';
            $detail_list_data['auction_starttime']  = '';
            $detail_list_data['auction_end_time']   = '';
            $detail_list_data['created_at']         = ''; 
        }
        //Pricing Info
        $listing_features = $this->listing_features($listing_id,$detail_list_data['variant_id']);
        if(count($listing_features)>0)
        {
            $detail_list_data['seating_capacity']    = $listing_features['seating_capacity'];
            
            $detail_list_data['airbag']             = $listing_features['driver_airbags'];
            $detail_list_data['air_conditioner']    = $listing_features['air_conditioner'];
            $detail_list_data['central_locking']    = $listing_features['central_locking'];
        }   
        else
        {
            $detail_list_data['seatingcapacity']    = 0;
            $detail_list_data['fuel_capacity']      = 0;
            $detail_list_data['airbag']             = 0;
            $detail_list_data['air_conditioner']    = 0;
            $detail_list_data['central_locking']    = 0;
        }

        $detail_list_data['price']              = $fetch_pricing[0]->saleprice;
        $detail_list_data['fuel_capacity']      = $fetch_pricing[0]->fuel_capacity;   
        $detail_list_data['site_url']           = '';  

        $detail_list_data['listing_page']       = '0'; 
        //Photos Info
        $photos_array                           = array();

        if(count($fetch_photos)>0)
        {
              foreach ($fetch_photos as $photokey => $photovalue) {
                  $photos_array['imagelink']=$photovalue->s3_bucket_path;
                  $photos_array['imagename']=$photovalue->profile_pic_name;
                  $detail_list_data['image_url'][] = $photos_array;
              }
              //dd($detail_list_data['image_url']);
              //$detail_list_data['image_url'] = $photos_array;
        }
        else
        {
            $carnoimage                      = Config::get('common.carnoimage');
            $photos_array['imagelink']=$carnoimage;
            $photos_array['imagename']='';
            $detail_list_data['image_url'][] = $photos_array;
            //$detail_list_data['image_url']   =array($carnoimage);
        }
        //Video Info
        $video_array                            =array();
        if(count($fetch_videos)>0)
        {
          foreach ($fetch_videos as $vediokey => $videovalue) {
              $video_array[]=$videovalue->video_url_fullpath;
          }
          
          $detail_list_data['video_url'] = $video_array;
        }
        else
        {
          $detail_list_data['video_url'] =array();
        } 
        


        $bidding_wherecondition                     =array('car_id'=>$detail_list_data['car_id']);
        $bidding_list                               = buymodel::masterBiddingDetail($bidding_wherecondition);

        $bidders_count                              = buymodel::masterBiddingCount($bidding_wherecondition);

        $bids_count                                 = buymodel::masterBidCount($bidding_wherecondition);

        $detail_list_data['bidders_count']          = $bidders_count;   
        $detail_list_data['bids_count']             = $bids_count;   
        $detail_list_data['time_left']              = $detail_list_data['auction_end_time'];   
        $detail_list_data['bidding_duration']       = $bids_count; 
        $detail_list_data['site_image']             = '';
        $detail_list_data['contactmessagestatus']   = '';
        $detail_list_data['lister_logo']            = '';
        $detail_list_data['test_drive']             = '';
        $detail_list_data['test_drive_status']      = '';
        $detail_list_data['test_driveatdoorpoint']  = '';
        $detail_list_data['test_driveatdealerpoint']= '';
        $detail_list_data['reporting_list_details']= '';
        
        
        $data                                       =array();
        $bidding_data                               =array();

        if(!empty($bidding_list))
        {
          foreach ($bidding_list as $biddedkey) {
          
              $data['bidded_amount']        = $biddedkey->bidded_amount;
              $data['delear_datetime']      = date('d-m-Y H:i:s',strtotime($biddedkey->delear_datetime));
              $data['dealer_id']            = $biddedkey->dealer_id;
              
              $get_dealer_name              =buymodel::masterFetchTableDetails($id,$dms_dealers_tablename,array('d_id'=>$biddedkey->user_id));
              
              
              if(count($get_dealer_name)<0)
              {
                  $to_dealer_name = '';                
              }
              else
              {
                  $dealer_name    = $get_dealer_name[0]->dealer_name;
                  $to_dealer_name = commonmodel::maskingWithX($dealer_name);   
              }
                  
              
              
              $data['dealer_name']          = $to_dealer_name;

              $data['car_id']               = $biddedkey->car_id;
              array_push($bidding_data, $data);
              
          }
        }
        }
       $compact_array              = array('active_menu_name'=>$this->active_menu_name,
                                            'side_bar_active'=>1
                                          );  
      $header_data                  = $this->header_data;
      $header_data['title']='Inventory View';
      $fundingticketid              = '';
      $fundingticket                = '';
      $city_name                    = '';

      return view('detail_list',compact('detail_list_data','fundingticketid','fundingticket','listing_features','header_data','bidding_data','fulldata','city_name','compact_array','dealer_info'));
	}
	
	

    public function image_upload()
    {
        if(isset($_FILES)){
        $dublicate_id       = Input::get('dplistid');
        $invetryimages          = Input::file("inventry_image");
        if(!empty($invetryimages))
        {
            $allowed            = array('png', 'jpg','jpeg', 'gif','zip');
            $file_name          = $_FILES["inventry_image"]["name"];
            //$newfile_name       = time().$_FILES["inventry_image"]["name"];
            $file_tmp           = $_FILES["inventry_image"]["tmp_name"];
            //$ext                = pathinfo($file_name,PATHINFO_EXTENSION);
            $id                 = session::get('ses_id');
            $whereSchema        = array('d_id' => $id);
            $SchemaName       = $this->SchemaObject->schema_table_whereschemaname(
                                                            $this->DmsDealerTable,
                                                            $whereSchema);
            if(count($SchemaName) == 1){
                $dealername = $SchemaName[0]->dealer_schema_name;
            }
            else
            {
                $dealername = $this->dealer_schemaname;
            }
            $uploadPath         = "uploadimages/".$dealername."/photos/";

                        $file = Input::file("inventry_image");
                        $destinationPath = public_path()."/uploadimages/".$dealername."/photos/";
                        $dms_image_fileupload = new fileuploadmodel;
                        ini_set('max_execution_time',0);
                        foreach($file as $file_key => $file_value){
                          if(is_object($file_value)){
                            $exists = $this->SchemaObject->schema_where_two('dms_car_listings_photos','profile_pic_name','car_id',$file_key,$dublicate_id); 
                            if(count($exists) >=1)
                            {       
                                $result = Storage::delete("/uploadimages/".$dealername."/photos/".$exists[0]->photo_link);
                                sleep(2);
                                $image_upload_result = $dms_image_fileupload->image_upload($file_value,$destinationPath);
                                if(!empty($image_upload_result)){
                                    $updateData = array (
                                                    'profile_pic_name'=>$file_key,
                                                    'photo_link'=>$image_upload_result,
                                                    'photo_link_fullpath'=>url("/uploadimages/".$dealername."/photos/".$image_upload_result), 
                                                    'folder_path'=>'',                  
                                                    's3_bucket_path'=>Config::get('common.s3bucketpath').$dealername."/photos/".$image_upload_result
                                                );

                                    $Profile_id_where =  array('car_id'=>Input::get('dplistid'));
                                    $Profile_pic_where = array('profile_pic_name'=>$file_key);
                                    $select     = $this->SchemaObject->schema_update_twowhere(
                                                                                $this->DmsCarListPhotosTable,
                                                                                $Profile_id_where,
                                                                                $Profile_pic_where,
                                                                                $updateData
                                                                                );
                                    $fileContents = public_path("/uploadimages/".$dealername."/photos/").$image_upload_result;
                                    $result = Storage::put("/uploadimages/".$dealername."/photos/".$image_upload_result, file_get_contents($fileContents),'public');
                                    unlink($fileContents);
                                    sleep(10);
                                }
                            }
                            else{
                                $image_upload_result = $dms_image_fileupload->image_upload($file_value,$destinationPath);
                                if(!empty($image_upload_result)){
                                    $InsertData = array (
                                            'car_id'=>'',
                                            'car_id'=>Input::get('dplistid'),
                                            'profile_pic_name'=>$file_key,
                                            'photo_link'=>$image_upload_result,
                                            'photo_link_fullpath'=>url("/uploadimages/".$dealername."/photos/".$image_upload_result), 
                                            'folder_path'=>'',                  
                                            's3_bucket_path'=>Config::get('common.s3bucketpath').$dealername."/photos/".$image_upload_result
                                        );        
                                    $select     = $this->SchemaObject->schema_insert(
                                                                        $this->DmsCarListPhotosTable,
                                                                        $InsertData
                                                                        );
                                    $fileContents = public_path("/uploadimages/".$dealername."/photos/").$image_upload_result;
                                    $result = Storage::put("/uploadimages/".$dealername."/photos/".$image_upload_result, file_get_contents($fileContents),'public');
                                    unlink($fileContents);
                                    sleep(10);
                                }
                            }
                          }
                        } 
            return json_encode(array('success'=>Config::get('common.jsontrue')));                            
        }            
    }
}

    public function video_upload(Request $request)
    {
        $id                 = session::get('ses_id');
        $whereSchema        = array('d_id' => $id);
        $SchemaName         = $this->SchemaObject->schema_table_whereschemaname(
                                                            $this->DmsDealerTable,
                                                            $whereSchema);
            if(count($SchemaName) == 1){
                $dealername = $SchemaName[0]->dealer_schema_name;
            }
            //get last id 
        $select             = $this->SchemaObject->schema_table(
                                                        $this->DmsCarListingStatusTable
                                                        );
        if(count($select) == 1){
            $invetry_primaryid = $select[0]->duplicate_id;
        }
        $uploadPath   = "uploadimages/".$dealername."/videos";
        $list_data    = array('car_id'=>Input::get('dplistid'));
        $select       = $this->SchemaObject->schema_insert_get(
                                                            $this->DmsCarListTable,
                                                                $list_data
                                                            );
        $whereid                    = array($this->InventoryPrimayId => Input::get('dplistid'));
        $listing_videos             = $this->SchemaObject->schema_whereid(
                                                            $this->DmsCarListVideosTable,
                                                            $whereid
                                                            );
        if(count($listing_videos) == 1){
           unlink($listing_videos[0]->video_url);
            $file = Input::file("car_video_upload");
            $destinationPath = public_path()."/uploadimages/".$dealername."/videos/";
            $dms_image_fileupload = new fileuploadmodel;
            $image_upload_result = $dms_image_fileupload->videos_upload($file,$destinationPath);
            /*$video                = Youtube::upload(url("/uploadimages/".$dealername."/videos/".$image_upload_result), [
                                        'title'       => 'My Awesome Video',
                                        'description' => 'You can also specify your video description here.',
                                        'tags'        => ['foo', 'bar', 'baz'],
                                        'category_id' => 10
                                        ]);
            echo $video->getVideoId();*/
            if($image_upload_result){
                if(Config::get('common.jsonfalse') == $image_upload_result){
                        $result['status'] = Config::get('common.jsonfalse');
                        echo json_encode($result);
                        exit;
                }else{
                    $Updatevideo    = array(
                                        'video_url'=>$image_upload_result,
                                        'video_url_fullpath'=>url("/uploadimages/".$dealername."/videos/".$image_upload_result),     
                                        'folder_path'=>'',
                                        's3_bucket_path'=>Config::get('common.s3bucketpath').$dealername.'/videos/'.$image_upload_result
                                        );
                    $purchase_data             = $this->SchemaObject->schema_update_singlewhere(
                                                                $this->DmsCarListVideosTable,
                                                                $whereid,
                                                                $Updatevideo
                                                                );
                    $result['status'] = "success";
                     echo json_encode($result);
                }
            }
        }
        else{
            $file = Input::file("car_video_upload");
            $destinationPath = public_path()."/uploadimages/".$dealername."/videos/";
            $dms_image_fileupload = new fileuploadmodel;
            $image_upload_result = $dms_image_fileupload->videos_upload($file,$destinationPath);
            /*$video                = Youtube::upload(url("/uploadimages/".$dealername."/videos/".$image_upload_result), [
                                        'title'       => 'My Awesome Video',
                                        'description' => 'You can also specify your video description here.',
                                        'tags'        => ['foo', 'bar', 'baz'],
                                        'category_id' => 10
                                        ]);

            echo $video->getVideoId();
            exit;*/
            if($image_upload_result){
                if(Config::get('common.jsonfalse') == $image_upload_result){
                    $result['status'] = Config::get('common.jsonfalse');
                    echo json_encode($result);
                    exit;
                }else{
                        $InsertVideos  = array(
                                'inventory_primary_id'=>Input::get('dplistid'), 
                                'car_id'=>'', 
                                'video_url'=>url("/uploadimages/".$dealername."/videos/".$image_upload_result), 
                                'video_url_fullpath'=>url("/uploadimages/".$dealername."/videos/".$image_upload_result),    
                                'folder_path'=>'',
                                's3_bucket_path'=>Config::get('common.s3bucketpath').$dealername.'/videos/'.$image_upload_result,      
                                );
                        $select         = $this->SchemaObject->schema_insert(
                                                        $this->DmsCarListVideosTable,
                                                        $InsertVideos
                                                        );
                        $result['status'] = "success";
                        echo json_encode($result);
                }   
            }
        }
    }

    public function dealer_documents()
    {
        $id                 = session::get('ses_id');
        $dealer_schemaname  = $this->dealer_schemaname;
        $dplistid           = Input::get('dplistid');
        $condition          = array('listing_id'=>$dplistid);
        $hypothcheck        = inventorymodel::dealerTableCount($dealer_schemaname,'dealer_hypothacation_details',$condition);
        $insurancecheck     = inventorymodel::dealerTableCount($dealer_schemaname,'dealer_insurance_details',$condition);        

        $hypothacation_type = Input::get('hypothacation_type');
        $finacier_name      = Input::get('finacier_name');
        $fla_finacier_name  = Input::get('fla_finacier_name');
        $from_date          = Input::get('from_date');
        
        $hyporecord         = array('listing_id'=>$dplistid,
                                    'hypothacation_type'=>$hypothacation_type,
                                    'finacier_name'=>$finacier_name,
                                    'fla_finacier_name'=>$fla_finacier_name,
                                    'from_date'=>$from_date);
        if($hypothcheck<=0)
        {
            inventorymodel::dealerInsertTable($dealer_schemaname,'dealer_hypothacation_details',$hyporecord);
        }
        else
        {
            inventorymodel::dealerUpdateTableDetails($id,$dealer_schemaname,'dealer_hypothacation_details',$condition,$hyporecord);
        }
        
        
        $comp_cd_desc       = Input::get('comp_cd_desc');
        $fla_insurance_name = Input::get('fla_insurance_name');
        $insurance_type_desc= Input::get('insurance_type_desc');
        $insurance_from     = Input::get('insurance_from');
        $insurance_upto     = Input::get('insurance_upto');
        $insurancerecord    = array('listing_id'=>$dplistid,
                                    'comp_cd_desc'=>$comp_cd_desc,
                                    'fla_insurance_name'=>$fla_insurance_name,
                                    'insurance_type_desc'=>$insurance_type_desc,
                                    'insurance_from'=>$insurance_from,
                                    'insurance_upto'=>$insurance_upto,
                                    );
        if($insurancecheck<=0)
        {
            inventorymodel::dealerInsertTable($dealer_schemaname,'dealer_insurance_details',$insurancerecord);
        }
        else
        {
            inventorymodel::dealerUpdateTableDetails($id,$dealer_schemaname,'dealer_insurance_details',$condition,$insurancerecord);
        }
        if(!empty(Input::file('dd_documents')))
        {
        $whereSchema        = array('car_id' => $id);

        $SchemaName         = $this->SchemaObject->schema_table_whereschemaname(
                                                            $this->DmsDealerTable,
                                                            $whereSchema);
        if(count($SchemaName) == 1){
            $dealername = session::get('dealer_schema_name');
        }
        $dealername = session::get('dealer_schema_name');
        $data=array();
        $file_size_check = '';
        foreach(Input::file('dd_documents') as $post_key=>$post_value){
            if(Input::file('dd_documents')[$post_key]->getSize() > 10485760 || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "x-ms-asf" || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "mp4" || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "mp3" || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "webm" || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "mkv" || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "flv" || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "vob" || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "ogv" || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "ogg" || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "drc" || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "gifv"  || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "mng" || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "avi" || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "mov" || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "wmv"  || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "yuv" || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "rm"  || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "rmvb" || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "asf"  || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "amv" || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "m4p"  || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "m4v" || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "mpg"  || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "mp2" || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "mpeg"  || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "mpe" || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "mpv"  || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "m2v" || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "m4v"  || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "svi" || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "3gp"  || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "3g2" || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "mxf"  || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "roq" || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "nsv"  || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "flv" || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "f4v"  || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "f4p"  || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "f4a"  || Input::file('dd_documents')[$post_key]->getClientOriginalExtension() == "f4b"){
                $file_size_check = true;
                break;
            }
        }
         if($file_size_check == true){
            $data = array('filetyperesponse'=>"problem");
        }
        else{
            $car_id = Input::get('dplistid');
            foreach(Input::file('dd_documents') as $post_key=>$post_value){
            $WhereDcoument        = array('car_id' => Input::get('dplistid'),'document_number'=>$post_key);

            $listing_documents    = buymodel::dealerFetchTableDetails($id,$dealername,
                                                        $this->DmsCarListDocumentTable,
                                                        $WhereDcoument
                                                       );

            $extension            = $post_value->getClientOriginalExtension();
            $destinationPath      = "uploadimages/".$dealername."/documents";
            //echo $listing_documents[0]->document_link;
            //exit;
            if(count($listing_documents)<=0)
            {
                $image_upload_result  = fileuploadmodel::any_upload($post_value,$destinationPath,$extension);
                $fileContents = public_path("/uploadimages/".$dealername."/documents/").$image_upload_result;
                $result = Storage::put("/uploadimages/".$dealername.'/inventory/'.$car_id."/documents/".$image_upload_result, file_get_contents($fileContents),'public');
                $s3_bucket_path =Config::get('common.s3bucketpath').$dealername.'/inventory/'.$car_id.'/documents/'.$image_upload_result;
                unlink($fileContents);
                $InsertDocuments      = array('car_id'=>Input::get('dplistid'), 
                                              'inventory_primary_id'=>'',
                                              'document_number'=>$post_key, 
                                              'document_link'=>$image_upload_result,
                                              'full_folder_path'=>url("/uploadimages/".$dealername."/documents/".$image_upload_result),     
                                              'folder_path'=>url("/uploadimages/".$dealername."/documents/".$image_upload_result),
                                              's3_bucket_path'=>$s3_bucket_path,      
                                              );
                $data[$post_key]=stripcslashes($s3_bucket_path);
                buymodel::dealerInsertTable($id,$dealername,
                                                    $this->DmsCarListDocumentTable,
                                                    $InsertDocuments
                                                    );
            }
            else
            {
                
                Storage::delete("/uploadimages/".$dealername.'/inventory/'.$car_id."/documents/".$listing_documents[0]->document_link);
                $image_upload_result  = fileuploadmodel::any_upload($post_value,$destinationPath,$extension);

                $fileContents = public_path("/uploadimages/".$dealername."/documents/").$image_upload_result;

                $result = Storage::put("/uploadimages/".$dealername.'/inventory/'.$car_id."/documents/".$image_upload_result, file_get_contents($fileContents),'public');
                $s3_bucket_path =Config::get('common.s3bucketpath').$dealername.'/inventory/'.$car_id.'/documents/'.$image_upload_result;
                unlink($fileContents);
                $InsertDocuments      = array('car_id'=>Input::get('dplistid'), 
                                              'inventory_primary_id'=>'',
                                              'document_number'=>$post_key, 
                                              'document_link'=>$image_upload_result,
                                              'full_folder_path'=>url("/uploadimages/".$dealername."/documents/".$image_upload_result),     
                                              'folder_path'=>url("/uploadimages/".$dealername."/documents/".$image_upload_result),
                                              's3_bucket_path'=>$s3_bucket_path,      
                                              );
                $data[$post_key]=stripcslashes($s3_bucket_path);
                $WhereDcoument= array('car_id' => Input::get('dplistid'),'document_id' => $listing_documents[0]->document_id);
                
                buymodel::dealerUpdateTableDetails(
                                    $id,
                                    $dealername,
                                    $this->DmsCarListDocumentTable,
                                    $WhereDcoument,
                                    $InsertDocuments
                                    );
            }
            sleep(10);
            }
        }
        return response()->json($data);
        }
    }

    
    public function certificationwarrantysave()
    {
        $id                 = Session::get('ses_id');
        $list_data          = array('listing_id'=>Input::get('dplistid'));
        $dealer_schemaname  = $this->dealer_schemaname;
        $inspectionagency   = Input::get('inspectionagency');
        $inspectiondate     = Input::get('inspectiondate');
        $certificateid      = Input::get('certificateid');
        $certificateurl     = Input::get('certificateurl');
        $serviceagency      = Input::get('serviceagency');
        $servicedate        = Input::get('servicedate');
        $serviceid          = Input::get('serviceid');
        $serviceurl         = Input::get('serviceurl');
        $certificatereport  = Input::File('certificatereport');
        $servicereport      = Input::File('servicereport');
        $car_id             = Input::get('dplistid');
        $add_list           = array(
                                    'listing_id'=>Input::get('dplistid'),
                                    'inspectionagency'=>$inspectionagency,
                                    'inspectiondate'=>$inspectiondate,
                                    'certificateid'=>$certificateid,
                                    'certificateurl'=>$certificateurl,
                                    'serviceagency'=>$serviceagency,
                                    'serviceagency'=>$serviceagency,
                                    'servicedate'=>$servicedate,
                                    'serviceid'=>$serviceid,
                                    'serviceurl'=>$serviceurl,
                                    'user_id'=>$id
                                    );
        $filecertificatereportvalid = 0;
        $fileservicereportvalid = 0;
        $certificatereporturl =''; 
        if(!empty($certificatereport))
        {
            $extension          = $certificatereport->getClientOriginalExtension();
            $filesize           = $certificatereport->getSize();
            if($filesize<=5242880)
            {
                $destinationPath    = "uploadimages/".$dealer_schemaname."/documents";
                $image_upload_result= fileuploadmodel::any_upload($certificatereport,$destinationPath,$extension);
                $fileContents       = public_path("/uploadimages/".$dealer_schemaname."/documents/").$image_upload_result;
                $result             = Storage::put("/uploadimages/".$dealer_schemaname.'/inventory/'.$car_id."/certificatedocuments/".$image_upload_result, file_get_contents($fileContents),'public');
                $s3_bucket_path =Config::get('common.s3bucketpath').$dealer_schemaname.'/inventory/'.$car_id.'/certificatedocuments/'.$image_upload_result;
                $add_list['certificatereport']=$s3_bucket_path;
                $certificatereporturl =$s3_bucket_path;
            }
            else
            {
                $filecertificatereportvalid = 1;  
                $certificatereporturl =''; 
            }
        }
        $servicereporturl = '';
        if(!empty($servicereport))
        {
            $extension          = $servicereport->getClientOriginalExtension();
            $filesize           = $servicereport->getSize();
            if($filesize<=5242880)
            {
                $destinationPath    = "uploadimages/".$dealer_schemaname."/documents";
                $image_upload_result= fileuploadmodel::any_upload($servicereport,$destinationPath,$extension);
                $fileContents       = public_path("/uploadimages/".$dealer_schemaname."/documents/").$image_upload_result;
                $result             = Storage::put("/uploadimages/".$dealer_schemaname.'/inventory/'.$car_id."/certificatedocuments/".$image_upload_result, file_get_contents($fileContents),'public');

                $s3_bucket_path =Config::get('common.s3bucketpath').$dealer_schemaname.'/inventory/'.$car_id.'/certificatedocuments/'.$image_upload_result;

                $add_list['servicereport']=$s3_bucket_path;
                $servicereporturl =$s3_bucket_path;
            }
            else
            {
                $servicereporturl ='';
                $fileservicereportvalid = 1;   
            }
        }
               
        $insertupdatecheck  =  inventorymodel::dealerTableCount($dealer_schemaname,'dms_listing_certification_warranty_inspection',$list_data);

        if($insertupdatecheck<=0)
        {
            $addinventor_status       = inventorymodel::InsertTable($id,$dealer_schemaname,
                                                            'dms_listing_certification_warranty_inspection',
                                                            $add_list
                                                            );
        }
        else
        {
            $addinventor_status       = inventorymodel::dealerUpdateTableDetails($id,$dealer_schemaname,
                                                            'dms_listing_certification_warranty_inspection',
                                                            $list_data,
                                                            $add_list
                                                            );
        }
        return json_encode(array('status'=>$addinventor_status,'fileservicereportvalid'=>$fileservicereportvalid,'filecertificatereportvalid'=>$filecertificatereportvalid,'fileservicereporturl'=>$servicereporturl,'filecertificatereporturl'=>$certificatereporturl));
    }
    public function update_car_list()
    {
        $id = Session::get('ses_id');
        $list_data                = array('listing_id'=>Input::get('dplistid'));
        $dealer_schemaname = $this->dealer_schemaname;
        $where                    = $list_data;
        $insertupdatecheck  =  inventorymodel::dealerTableCount($dealer_schemaname,'dealer_listing_features',$where);
        $add_list                 = array(
                                    'dealer_id'=>$id,
                                    'listing_id'=>Input::get('dplistid'),
                                    'overviewdescription'=>Input::get('overviewdesc'),
                                    'gear_box'=>Input::get('gear_box'),
                                    'drive_type'=>Input::get('drive_type'),
                                    'seating_capacity'=>Input::get('seating_capacity'),
                                    'steering_type'=>Input::get('steering_type'),
                                    'turning_radius'=>Input::get('turning_radius'),
                                    'acceleration'=>Input::get('acceleration'),
                                    'tyre_type'=>Input::get('tyre_type'),
                                    'no_of_doors'=>Input::get('no_of_doors'),
                                    'engine_type'=>Input::get('engine_type'),
                                    'displacement'=>Input::get('displacement'),
                                    'top_speed'=>Input::get('top_speed'),
                                    'max_power'=>Input::get('max_power'),
                                    'max_torque'=>Input::get('max_torque'),
                                    'no_of_cylinder'=>Input::get('no_of_cylinder'),
                                    'valves_per_cylinder'=>Input::get('valves_per_cylinder'),
                                    'valve_configuration'=>Input::get('valve_configuration'),
                                    'fuel_supply_system'=>Input::get('fuel_supply_system'),
                                    'turbo_charger'=>Input::get('turbo_charger'),
                                    'super_charger'=>Input::get('super_charger'),
                                    'length'=>Input::get('length'),
                                    'width'=>Input::get('width'),
                                    'height'=>Input::get('height'),
                                    'wheel_base'=>Input::get('wheel_base'),
                                    'gross_weight'=>Input::get('gross_weight'),
                                    'air_conditioner'=>Input::has('air_conditioner')?1:0,
                                    'adjustable_steering'=>Input::has('adjustable_steering')?1:0,
                                    'leather_steering_wheel'=>Input::has('leather_steering_wheel')?1:0,
                                    'heater'=>Input::has('heater')?1:0,
                                    'digital_clock'=>Input::has('digital_clock')?1:0,
                                    'power_steering'=>Input::has('power_steering')?1:0,
                                    'power_windows_front'=>Input::has('power_windows_front')?1:0,
                                    'power_windows_rear'=>Input::has('power_windows_rear')?1:0,
                                    'remote_trunk_opener'=>Input::has('remote_trunk_opener')?1:0,
                                    'remote_fuel_lid_opener'=>Input::has('remote_fuel_lid_opener')?1:0,
                                    'low_fuel_warning_light'=>Input::has('low_fuel_warning_light')?1:0,
                                    'rear_reading_lamp'=>Input::has('rear_reading_lamp')?1:0,
                                    'rear_seat_headrest'=>Input::has('rear_seat_headrest')?1:0,
                                    'rear_seat_centre_arm_rest'=>Input::has('rear_seat_centre_arm_rest')?1:0,
                                    'height_adjustable_front_seat_belts'=>Input::has('height_adjustable_front_seat_belts')?1:0,
                                    'cup_holders_front'=>Input::has('cup_holders_front')?1:0,
                                    'cup_holders_rear'=>Input::has('cup_holders_rear')?1:0,
                                    'rear_ac_vents'=>Input::has('rear_ac_vents')?1:0,
                                    'parking_sensors'=>Input::has('parking_sensors')?1:0,
                                    'anti_lock_braking_system'=>Input::has('anti_lock_braking_system')?1:0,
                                    'central_locking'=>Input::has('central_locking')?1:0,
                                    'child_safety_lock'=>Input::has('child_safety_lock')?1:0,
                                    'driver_airbags'=>Input::has('driver_airbags')?1:0,
                                    'passenger_airbag'=>Input::has('passenger_airbag')?1:0,
                                    'rear_seat_belts'=>Input::has('rear_seat_belts')?1:0,
                                    'seat_belt_warning'=>Input::has('seat_belt_warning')?1:0,
                                    'adjustable_seats'=>Input::has('adjustable_seats')?1:0,
                                    'crash_sensor'=>Input::has('crash_sensor')?1:0,
                                    'anti_theft_device'=>Input::has('anti_theft_device')?1:0,
                                    'immobilizer'=>Input::has('immobilizer')?1:0,
                                    'adjustable_head_lights'=>Input::has('adjustable_head_lights')?1:0,
                                    'power_adjustable_exterior_rear_view_mirror'=>Input::has('power_adjustable_exterior_rear_view_mirror')?1:0,
                                    'electric_folding_rear_view_mirror'=>Input::has('electric_folding_rear_view_mirror')?1:0,
                                    'rain_sensing_wipers'=>Input::has('rain_sensing_wipers')?1:0,
                                    'rear_window_wiper'=>Input::has('rear_window_wiper')?1:0,
                                    'alloy_wheels'=>Input::has('alloy_wheels')?1:0,
                                    'tinted_glass'=>Input::has('tinted_glass')?1:0,
                                    'front_fog_lights'=>Input::has('front_fog_lights')?1:0,
                                    'rear_window_defogger'=>Input::has('rear_window_defogger')?1:0,
                                    'cdplayer'=>Input::has('cdplayer')?1:0,
                                    'radio'=>Input::has('radio')?1:0,
                                    'audio'=>Input::has('audio')?1:0,
                                    'bluetooth'=>Input::has('bluetooth')?1:0,

            );
//dd($add_list);
        if($insertupdatecheck<=0)
        {
            $addinventor_status       = inventorymodel::InsertTable($id,$dealer_schemaname,
                                                            'dealer_listing_features',
                                                            $add_list
                                                            );
        }
        else
        {
            $addinventor_status       = inventorymodel::dealerUpdateTableDetails($id,$dealer_schemaname,
                                                            'dealer_listing_features',
                                                            $where,
                                                            $add_list
                                                            );
        }
    }

    public function online_portal()
    {
        $list_data                = array('car_id'=>Input::get('dplistid'));
        $select       = $this->SchemaObject->schema_insert_get(
                                                            $this->DmsCarListTable,
                                                                $list_data
                                                            );
        $invetry_primaryid = $select[0]->car_id;
        $id                 = session::get('ses_id');
        $ResultDuplicateId  = $select[0]->car_id;
        //mongopush record check 
        $WhereDcoument      = array('car_id' => $ResultDuplicateId); 
        $Whereportal             = array('portal_primary_id'=>Input::get('dplistid')); 
        $portal_details          = $this->SchemaObject->schema_whereid(
                                                            $this->DmsOnlinePortalTable,
                                                            $Whereportal
                                                            );
        if(count($portal_details) >= 1){
                $listing_dealer = '';
                if($portal_details[0]->listing_dealer != '' && $portal_details[0]->listing_dealer != NULL){
                    $listing_dealer = $portal_details[0]->listing_dealer;
                }
                else{
                    $listing_dealer = Input::get('listing_dealerplus');   
                }
                $listing_olx = '';
                if($portal_details[0]->listing_olx != '' && $portal_details[0]->listing_olx != NULL){
                    $listing_olx = $portal_details[0]->listing_olx;
                }
                else{
                    $listing_olx = Input::get('listing_olx');   
                }

                $listing_carwale = '';
                if($portal_details[0]->listing_carwale != '' && $portal_details[0]->listing_carwale != NULL){
                    $listing_carwale = $portal_details[0]->listing_carwale;
                }
                else{
                    $listing_carwale = Input::get('listing_carwale');   
                }

                $listing_cardekho = '';
                if($portal_details[0]->listing_cardekho != '' && $portal_details[0]->listing_cardekho != NULL){
                    $listing_cardekho = $portal_details[0]->listing_cardekho;
                }
                else{
                    $listing_cardekho = Input::get('listing_cardekho');   
                }

                $listing_quickr = '';
                if($portal_details[0]->listing_quickr != '' && $portal_details[0]->listing_quickr != NULL){
                    $listing_quickr = $portal_details[0]->listing_quickr;
                }
                else{
                    $listing_quickr = Input::get('listing_quickr');   
                }

            $UpdatePortal = array(
                            'car_id'=>$id,//$value_car 
                            'dealer_selection'=>Input::get('dealer_selection'),
                            'auction_price'=>Input::get('auction_price'),
                            'auction_startdate'=>Input::get('auction_startdate'),
                            'auction_end_date'=>Input::get('auction_end_date'),
                            'listing_dealer'=>$listing_dealer,
                            'listing_olx'=>$listing_olx,
                            'listing_carwale'=>$listing_carwale,
                            'listing_cardekho'=>$listing_cardekho,
                            'listing_quickr'=>$listing_quickr,
                            'other_auction_type'=>Input::get('other_auction_type'),
                            'other_min_price'=>0,
                            'other_start_date'=>Input::get('other_start_date'),
                            'other_end_date'=>Input::get('other_end_date'),
                            'inviation'=>Input::get('inviation'),
                            'auctioninviation'=>Input::get('auctioninviation')
                            ); 
              $addinventor_status       = $this->SchemaObject->schema_update_singlewhere(
                                                            $this->DmsOnlinePortalTable,
                                                            $Whereportal,
                                                            $UpdatePortal
                                                            );
            $result['status'] = "success";
            $result['message'] = "Updated Successfully";
            echo json_encode($result);
        }
        else
        {
        $wheredata  =   array('car_id'=>$ResultDuplicateId,
                            $this->mongopush_status=>"failure",
                            );
        $orwheredata    =   array($this->DmsCarStatus=>1,$this->DmsCarStatus=>2);
        $checkcompletedataexist = $this->SchemaObject->mongopush_mypostings(
                                                $this->DmsCarListTable,
                                                $wheredata,
                                                $orwheredata
                                                );
        $whereimage             =   array("car_id"=>$ResultDuplicateId);
        $checkimagedataexist    =   $this->SchemaObject->schema_table_where(
                                                $this->DmsCarListPhotosTable,
                                                $whereimage
                                                );

        if(count($checkcompletedataexist) >= 1 && count($checkimagedataexist) >= 1)
        {
        $InsertPoratlDatainsert = array(
                                        'car_id'=>$ResultDuplicateId,//$value_car 
                                        'portal_primary_id'=>'',
                                        'dealer_selection'=>Input::get('dealer_selection'),
                                        'auction_price'=>Input::get('auction_price'),
                                        'auction_startdate'=>Input::get('auction_startdate'),
                                        'auction_end_date'=>Input::get('auction_end_date'),
                                        'listing_dealer'=>Input::get('listing_dealerplus'),
                                        'listing_olx'=>Input::get('listing_olx'),
                                        'listing_carwale'=>Input::get('listing_carwale'),
                                        'listing_cardekho'=>Input::get('listing_cardekho'),
                                        'listing_quickr'=>Input::get('listing_quickr'),
                                        'other_auction_type'=>Input::get('other_auction_type'),
                                        'other_min_price'=>0,
                                        'other_start_date'=>0,
                                        'other_end_date'=>0,
                                        'inviation'=>Input::get('inviation'),
                                        'auctioninviation'=>Input::get('auctioninviation')
                                    );

                $insertportal   = $this->SchemaObject->schema_insert(
                                                            $this->DmsOnlinePortalTable,
                                                            $InsertPoratlDatainsert
                                                            );
            $result['status'] = "success";
            $result['message'] = "Inserted Successfully";
            echo json_encode($result);
            }
            else
            {
                $result['status'] = "failure";
                echo json_encode($result);
            }
        }
    }

    public function mongo_push()
    {   
        $duplicate_id = Input::get('duplicate_id');
        $maintable = new schemamodel;
        $WhereDmsListing = array('car_id'=>$duplicate_id);
        $car_listing       = $maintable->schema_table_where(
                                                            $this->DmsCarListTable,
                                                            $WhereDmsListing
                                                            );
        $WhereDmsListing = array('car_id'=>$duplicate_id);
        $car_photos       = $maintable->schema_table_where(
                                                            $this->DmsCarListPhotosTable,
                                                            $WhereDmsListing
                                                            );

        $WhereDmsListing = array('listing_id'=>$duplicate_id);
        $car_pricing       = $maintable->schema_table_where(
                                                            $this->DealerCarPricingTable,
                                                            $WhereDmsListing
                                                            );
        $car_listing_main_view = array();
        if(count($car_listing) >=1 && count($car_photos) >= 1 && $car_pricing[0]->saleprice > 0){
                $car_view_count = count($car_listing);
            
            $mongo_data = array();
            if($car_view_count >= 1){
                foreach($car_listing as $key=>$car_value){
                    if($car_value->car_id){
                        $main_id = $car_value->car_id;
                                    $car_listing_main_view['car_list']     = $maintable->schema_table_listing_duplicateid(
                                                                                        $this->DmsCarListTable,
                                                                                        'car_id',
                                                                                        $car_value->car_id
                                                                                        );
                                    $car_listing_main_view['photos']        = $maintable->schema_table_listing_photos_duplicateid(
                                                                                        'dms_car_listings_photos',
                                                                                        'car_id',
                                                                                        $car_value->car_id
                                                                                        );

                                    $car_listing_main_view['videos']        = $maintable->schema_table_listing_videos_duplicateid(
                                                                                        'dms_car_listings_videos',
                                                                                        'car_id',
                                                                                        $car_value->car_id
                                                                                        );

                                    $car_listing_main_view['documents']     = $maintable->schema_table_listing_documents_duplicateid(
                                                                                        'dms_car_listings_documents',
                                                                                        'car_id',
                                                                                        $car_value->car_id
                                                                                        );
                                
                                    $car_listing_main_view['pricing']     = $maintable->schema_table_listing_pricing_duplicateid(
                                                                                        'dealer_cars_pricing',
                                                                                        'listing_id',
                                                                                        $car_value->car_id
                                                                                        );

                                    $car_listing_main_view['expense']     = $maintable->schema_table_listing_expense_duplicateid(
                                                                                        'dealer_car_expenses',
                                                                                        'car_id',
                                                                                        $car_value->car_id
                                                                                        );
                                    $car_listing_main_view['online']     = $maintable->schema_table_listing_online_duplicateid(
                                                                                        'dealer_online_portal',
                                                                                        'car_id',
                                                                                        $car_value->car_id
                                                                                );

                                    $car_listing_main_view['features']     = $this->SchemaObject->schema_where(
                                                                                                                'dealer_listing_features',
                                                                                                                'listing_id',
                                                                                                                $car_value->car_id
                                                                                                                );


                    }
                }
            }

            if($car_listing_main_view >= 1){
                foreach($car_listing_main_view as $mongokey => $value){
                    if($mongokey == 'car_list'){
                        $mongo_data['car_id']           = $value[0]->car_id;
                        $mongo_data['duplicate_id']     = $value[0]->duplicate_id;
                        $mongo_data['inventory_type']   = $value[0]->inventory_type;
                        $mongo_data['dealer_id']        = $value[0]->dealer_id;
                        $mongo_data['addinventor_id']   = $value[0]->addinventor_id;
                        $mongo_data['branch_id']        = $value[0]->branch_id;
                        $fetchmake                      = $maintable->master_table_makeid_model_varient('master_makes','make_id',$value[0]->make);
                        if(count($fetchmake) >= 1){
                            $makename = $fetchmake[0]->makename;
                        }
                        else{
                            $makename = 'Empty Name';
                        }                   
                        $fetchmodel = $maintable->master_table_makeid_model_varient('master_models','model_id',$value[0]->model_id);     
                        if(count($fetchmodel) >= 1){
                            $modelname = $fetchmodel[0]->model_name;
                        }
                        else{
                            $modelname = 'Empty Name';
                        }
                        $fetchvariant = $maintable->master_table_makeid_model_varient('master_variants','variant_id',$value[0]->variant);
                        if(count($fetchvariant) >= 1){
                            $variant_name = $fetchvariant[0]->variant_name;
                        }
                        else{
                            $variant_name = 'Empty Name';
                        }
                        $mongo_data['make_name']            = $makename;
                        $mongo_data['make_id']              = $value[0]->make;
                        $mongo_data['model_name']           = $modelname;
                        $mongo_data['model_id']             = $value[0]->model_id;                    
                        $mongo_data['variant_name']         = $variant_name;
                        $mongo_data['variant_id']           = $value[0]->variant;
                        //$mongo_data['model_id'] = $value[0]->model_id;
                        $mongo_data['category_id']          = $value[0]->category_id;
                        //$mongo_data['add_list_status'] = $value[0]->add_list_status;
                        $mongo_data['mileage']              = $value[0]->mileage;
                        $mongo_data['price']                = $value[0]->price;
                        $mongo_data['body_type']            = $value[0]->body_type;                        
                        $mongo_data['colors']               = $value[0]->colors;                        
                        $mongo_data['status']               = $value[0]->status;
                        //$mongo_data['registration_number'] = $value[0]->registration_number;
                        $mongo_data['registration_year']    = $value[0]->registration_year;                        
                        $mongo_data['owner_type']           = $value[0]->owner_type;
                        $mongo_data['place']                = $value[0]->place;
                        $mongo_data['kms_done']             = $value[0]->kms_done;                        
                        $mongo_data['car_city']             = $value[0]->car_city;                        
                        $mongo_data['fuel_type']            = $value[0]->fuel_type;
                        $mongo_data['transmission']         = $value[0]->transmission;
                        $mongo_data['created_at']           = $value[0]->created_at;
                        $mongo_data['updated_at']           = $value[0]->updated_at;
                    }
                    if($mongokey == $this->mongophotos){
                        $mongo_data['photos'] = array();
                        foreach($value as $photo_value){
                            $mongo_data['photos'][] = $photo_value;
                        } 
                    }
                    if($mongokey == $this->mongovideos){
                        $mongo_data['videos']  = array();
                        foreach($value as $video_value){
                            $mongo_data['videos'][] = $video_value;
                        } 
                    }

                    if($mongokey == $this->mongodocuments){
                        $mongo_data['documents'] = array();
                        foreach($value as $document_value){
                            $mongo_data['documents'][] = $document_value;
                        } 
                    }
                    if($mongokey == $this->mongopricing){
                        $mongo_data['pricing'] = array();
                        foreach($value as $pricing_value){
                            $mongo_data['pricing'][] = $pricing_value;
                        } 
                    }
                    

                    if($mongokey == $this->mongoexpense){
                        $mongo_data['expense'] = array();
                        foreach($value as $expense_value){
                            $mongo_data['expense'][] = $expense_value;
                        } 
                    }

                    if($mongokey == $this->mongoonline){
                        $mongo_data['online'] = array();
                        foreach($value as $online_value){
                            $mongo_data['online'][] = $online_value;
                        } 
                    }

                    if($mongokey == 'features'){
                        $mongo_data['features'] = array();
                        foreach($value as $features_value){
                            $mongo_data['features'][] = $features_value;
                        } 
                    }
                    
                }
            }
            
            
            
            if($mongo_data['duplicate_id']=='')
            {
                $mongo_id = 'DPLD'.Carbon::now()->format('Ymdhis');
                $mongodb_carlisting = new mongomodel;
            }
            else
            {
                $mongo_id =   $mongo_data['duplicate_id'];
                $mongodb_carlisting = array();
                //return json_encode(array('success'=>'Mongo Already Pushed'));
                //exit;
            }
            $cur=Carbon::now();
            $listing_expiry_date = $cur->addDays(config::get('common.listing_expiry_days'))->format('Y-m-d');            
            
            //$mongodb_carlisting['listing_id']     = $mongo_data['car_id'].$mongo_data['dealer_id'];
            $mongodb_carlisting['listing_id']     = $mongo_id;
            $mongodb_carlisting['addinventor_id'] = $mongo_data['addinventor_id'];
            $mongodb_carlisting['duplicate_id']   = $mongo_id;
            $mongodb_carlisting['inventory_type'] = $mongo_data['inventory_type'];
            
            $mongodb_carlisting['dealer_id']      = $mongo_data['dealer_id'];
            $mongodb_carlisting['listing_expiry_date'] = $listing_expiry_date;
            $mongodb_carlisting['branch_id']      = $mongo_data['branch_id'];
            $mongodb_carlisting['model_id']       = $mongo_data['model_id'];
            $mongodb_carlisting['category_id']    = $mongo_data['category_id'];
            $mongodb_carlisting['mileage']        = $mongo_data['mileage'];
            $mongodb_carlisting['transmission']   = $mongo_data['transmission'];
            $dealer_schemaname = $this->dealer_schemaname;
            $branchaddress = inventorymodel::dealerFetchTableDetails($dealer_schemaname,'dms_dealer_branches',array('branch_id'=>1));
            
            if(count($branchaddress)>0){
                $mongodb_carlisting['branch_address'] = $branchaddress[0]->branch_address;
            }
            else
            {
                $mongodb_carlisting['branch_address'] = '';   
            }
            
            $id = Session::get('ses_id');
            $body_type_name = buymodel::masterFetchTableDetails($id,'master_category',array('category_id'=>$mongo_data['category_id'])); 
            if(count($body_type_name) >= 1){
                $body_type_category_name = $body_type_name[0]->category_description;
            }
            else{
                $body_type_category_name = '';   
            }
            $mongodb_carlisting['body_type']       = $body_type_category_name;
            
            $fetchcolor = inventorymodel::master_table_color('master_colors','colour_id',$mongo_data['colors']);
            if(count($fetchcolor) >= 1){
                $colour_name = $fetchcolor[0]->colour_name;
            }
            else{
                $colour_name = 'No Name';   
            }
            $mongodb_carlisting['colors']                    = $colour_name;
            
            $mongodb_carlisting['status']                    = $mongo_data['status'];
            $mongodb_carlisting['registration_year']         = $mongo_data['registration_year'];
            
            $mongodb_carlisting['owner_type']                = $mongo_data['owner_type'];
            $mongodb_carlisting['make_id']                   = $mongo_data['make_id'];
            $mongodb_carlisting['make']                      = $mongo_data['make_name'];
            $mongodb_carlisting['model_id']                  = $mongo_data['model_id'];
            $mongodb_carlisting['model']                     = $mongo_data['model_name'];
            $mongodb_carlisting['variant_id']                = $mongo_data['variant_id'];
            $mongodb_carlisting['variant']                   = $mongo_data['variant_name'];
            $mongodb_carlisting['kilometer_run']             = $mongo_data['kms_done'];
            
            $fetchdealer_details = inventorymodel::master_table_where('dms_dealers','d_id',$mongo_data['dealer_id']);
            $mongodb_carlisting['car_owner_name']            = $fetchdealer_details[0]->dealer_name;
            $mongodb_carlisting['car_owner_email']           = $fetchdealer_details[0]->d_email;
            $mongodb_carlisting['car_owner_mobile']          = $fetchdealer_details[0]->d_mobile;
            $fetchcity = inventorymodel::master_table_where('master_city','city_id',$mongo_data['car_city']);
            $mongodb_carlisting['car_locality']              = $fetchcity[0]->city_name;
            $mongodb_carlisting['car_city']                  = $fetchcity[0]->city_name;
            
            $mongodb_carlisting['fuel_type']                 = $mongo_data['fuel_type'];
            if(count($mongo_data['photos']) >=1){
                $mongodb_carlisting['photos'] = $mongo_data['photos'];
            }
            else{
                $mongodb_carlisting['photos'] = array();
            }

            if(count($mongo_data['videos']) >=1){
                $mongodb_carlisting['videos'] = $mongo_data['videos'];
            }
            else{
                $mongodb_carlisting['videos'] = array();
            }

            if(count($mongo_data['documents']) >=1){
                $mongodb_carlisting['documents'] = $mongo_data['documents'];
            }
            else{
                $mongodb_carlisting['documents'] = array();
            }

            
            
            if(count($mongo_data['pricing']) >=1){
                $mongodb_carlisting['sell_price']            = floatval($mongo_data['pricing'][0]->saleprice);
                $mongodb_carlisting['ownpurchase_date']      = $mongo_data['pricing'][0]->ownpurchase_date;
                $mongodb_carlisting['ownpurchased_from']     = $mongo_data['pricing'][0]->ownpurchased_from;
                $mongodb_carlisting['ownreceived_from_name'] = $mongo_data['pricing'][0]->ownreceived_from_name;
                $mongodb_carlisting['ownpurchased_price']        = $mongo_data['pricing'][0]->ownpurchased_price;
                $mongodb_carlisting['ownkey_received'] = $mongo_data['pricing'][0]->ownkey_received;
                $mongodb_carlisting['owndocuments_received']   = $mongo_data['pricing'][0]->owndocuments_received;
                $mongodb_carlisting['test_drive']          = $mongo_data['pricing'][0]->test_drive;
                $mongodb_carlisting['testdrive_dealerpoint']            = $mongo_data['pricing'][0]->testdrive_dealerpoint;
                $mongodb_carlisting['testdrive_doorstep']          = $mongo_data['pricing'][0]->testdrive_doorstep;
                $mongodb_carlisting['markup_percentage']        = $mongo_data['pricing'][0]->markup_percentage;

                $mongodb_carlisting['markup_condition']        = $mongo_data['pricing'][0]->markup_condition;
                $mongodb_carlisting['markup_percentage']        = $mongo_data['pricing'][0]->markup_percentage;
                $mongodb_carlisting['markup_value']        = $mongo_data['pricing'][0]->markup_value;
                $mongodb_carlisting['purchase_date']        = $mongo_data['pricing'][0]->purchase_date;
                $mongodb_carlisting['starting_kms']        = $mongo_data['pricing'][0]->starting_kms;
                $mongodb_carlisting['received_from_own']        = $mongo_data['pricing'][0]->received_from_own;
                $mongodb_carlisting['received_from_name']        = $mongo_data['pricing'][0]->received_from_name;
                $mongodb_carlisting['fuel_indication']        = $mongo_data['pricing'][0]->fuel_indication;
                $mongodb_carlisting['fuel_capacity']        = $mongo_data['pricing'][0]->fuel_capacity;

                $mongodb_carlisting['customer_asking_price']        = $mongo_data['pricing'][0]->customer_asking_price;
                $mongodb_carlisting['dealer_markup_price']        = $mongo_data['pricing'][0]->dealer_markup_price;
                $mongodb_carlisting['keys_available']        = $mongo_data['pricing'][0]->keys_available;
                $mongodb_carlisting['documents_received']        = $mongo_data['pricing'][0]->documents_received;
            }
            else{
                $mongo_data['pricing'] = array();
            }


            if(count($mongo_data['expense']) >=1){
                $mongodb_carlisting['expense_desc']           = $mongo_data['expense'][0]->expense_desc;
                $mongodb_carlisting['expense_amount']         = $mongo_data['expense'][0]->expense_amount;
                //$mongodb_carlisting['extra']                  = $mongo_data['expense'][0]->extra;
            }else{
                $mongo_data['expense'] = array();
            }

            if(count($mongo_data['features']) >=1){
                $mongodb_carlisting['overviewdescription']    = $mongo_data['features'][0]->overviewdescription;
                $mongodb_carlisting['gear_box']               = $mongo_data['features'][0]->gear_box;
                $mongodb_carlisting['drive_type']             = $mongo_data['features'][0]->drive_type;
                $mongodb_carlisting['seating_capacity']       = $mongo_data['features'][0]->seating_capacity;
                $mongodb_carlisting['steering_type']          = $mongo_data['features'][0]->steering_type;
                $mongodb_carlisting['turning_radius']         = $mongo_data['features'][0]->turning_radius;
                $mongodb_carlisting['top_speed']              = $mongo_data['features'][0]->top_speed;
                $mongodb_carlisting['acceleration']           = $mongo_data['features'][0]->acceleration;
                $mongodb_carlisting['tyre_type']              = $mongo_data['features'][0]->tyre_type;
                $mongodb_carlisting['no_of_doors']            = $mongo_data['features'][0]->no_of_doors;
                $mongodb_carlisting['engine_type']            = $mongo_data['features'][0]->engine_type;
                $mongodb_carlisting['displacement']           = $mongo_data['features'][0]->displacement;
                $mongodb_carlisting['max_power']              = $mongo_data['features'][0]->max_power;
                $mongodb_carlisting['max_torque']             = $mongo_data['features'][0]->max_torque;
                $mongodb_carlisting['no_of_cylinder']         = $mongo_data['features'][0]->no_of_cylinder;
                $mongodb_carlisting['valves_per_cylinder']    = $mongo_data['features'][0]->valves_per_cylinder;
                $mongodb_carlisting['valve_configuration']    = $mongo_data['features'][0]->valve_configuration;
                $mongodb_carlisting['fuel_supply_system']     = $mongo_data['features'][0]->fuel_supply_system;
                $mongodb_carlisting['turbo_charger']          = $mongo_data['features'][0]->turbo_charger;
                $mongodb_carlisting['super_charger']          = $mongo_data['features'][0]->super_charger;
                $mongodb_carlisting['length']                 = $mongo_data['features'][0]->length;
                $mongodb_carlisting['width']                  = $mongo_data['features'][0]->width;
                $mongodb_carlisting['height']                 = $mongo_data['features'][0]->height;
                $mongodb_carlisting['wheel_base']             = $mongo_data['features'][0]->wheel_base;
                $mongodb_carlisting['gross_weight']           = $mongo_data['features'][0]->gross_weight;
                $mongodb_carlisting['air_conditioner']        = $mongo_data['features'][0]->air_conditioner;
                $mongodb_carlisting['adjustable_steering']    = $mongo_data['features'][0]->adjustable_steering;
                $mongodb_carlisting['leather_steering_wheel'] = $mongo_data['features'][0]->leather_steering_wheel;
                $mongodb_carlisting['heater']                 = $mongo_data['features'][0]->heater;
                $mongodb_carlisting['digital_clock']          = $mongo_data['features'][0]->digital_clock;
                $mongodb_carlisting['power_steering']         = $mongo_data['features'][0]->power_steering;
                $mongodb_carlisting['power_windows_front']    = $mongo_data['features'][0]->power_windows_front;
                $mongodb_carlisting['power_windows_rear']     = $mongo_data['features'][0]->power_windows_rear;
                $mongodb_carlisting['remote_trunk_opener']    = $mongo_data['features'][0]->remote_trunk_opener;
                $mongodb_carlisting['remote_fuel_lid_opener'] = $mongo_data['features'][0]->remote_fuel_lid_opener;
                $mongodb_carlisting['low_fuel_warning_light'] = $mongo_data['features'][0]->low_fuel_warning_light;
                $mongodb_carlisting['rear_reading_lamp']      = $mongo_data['features'][0]->rear_reading_lamp;
                $mongodb_carlisting['rear_seat_headrest']     = $mongo_data['features'][0]->rear_seat_headrest;
                $mongodb_carlisting['rear_seat_centre_arm_rest'] = $mongo_data['features'][0]->rear_seat_centre_arm_rest;
                $mongodb_carlisting['height_adjustable_front_seat_belts'] = $mongo_data['features'][0]->height_adjustable_front_seat_belts;
                $mongodb_carlisting['cup_holders_front']      = $mongo_data['features'][0]->cup_holders_front;
                $mongodb_carlisting['cup_holders_rear']       = $mongo_data['features'][0]->cup_holders_rear;
                $mongodb_carlisting['rear_ac_vents']          = $mongo_data['features'][0]->rear_ac_vents;
                $mongodb_carlisting['parking_sensors']        = $mongo_data['features'][0]->parking_sensors;
                $mongodb_carlisting['anti_lock_braking_system'] = $mongo_data['features'][0]->anti_lock_braking_system;
                $mongodb_carlisting['central_locking']        = $mongo_data['features'][0]->central_locking;
                $mongodb_carlisting['child_safety_lock']      = $mongo_data['features'][0]->child_safety_lock;
                $mongodb_carlisting['driver_airbags']         = $mongo_data['features'][0]->driver_airbags;
                $mongodb_carlisting['passenger_airbag']       = $mongo_data['features'][0]->passenger_airbag;
                $mongodb_carlisting['rear_seat_belts']        = $mongo_data['features'][0]->rear_seat_belts;
                $mongodb_carlisting['seat_belt_warning']      = $mongo_data['features'][0]->seat_belt_warning;
                $mongodb_carlisting['adjustable_seats']       = $mongo_data['features'][0]->adjustable_seats;
                $mongodb_carlisting['crash_sensor']           = $mongo_data['features'][0]->crash_sensor;
                $mongodb_carlisting['anti_theft_device']      = $mongo_data['features'][0]->anti_theft_device;
                $mongodb_carlisting['immobilizer']            = $mongo_data['features'][0]->immobilizer;
                $mongodb_carlisting['adjustable_head_lights'] = $mongo_data['features'][0]->adjustable_head_lights;
                $mongodb_carlisting['power_adjustable_exterior_rear_view_mirror'] = $mongo_data['features'][0]->power_adjustable_exterior_rear_view_mirror;
                $mongodb_carlisting['electric_folding_rear_view_mirror'] = $mongo_data['features'][0]->electric_folding_rear_view_mirror;
                $mongodb_carlisting['rain_sensing_wipers']    = $mongo_data['features'][0]->rain_sensing_wipers;
                $mongodb_carlisting['rear_window_wiper']      = $mongo_data['features'][0]->rear_window_wiper;
                $mongodb_carlisting['alloy_wheels']           = $mongo_data['features'][0]->alloy_wheels;
                $mongodb_carlisting['tinted_glass']           = $mongo_data['features'][0]->tinted_glass;
                $mongodb_carlisting['front_fog_lights']       = $mongo_data['features'][0]->front_fog_lights;
                $mongodb_carlisting['rear_window_defogger']   = $mongo_data['features'][0]->rear_window_defogger;
                $mongodb_carlisting['cdplayer']               = $mongo_data['features'][0]->cdplayer;
                $mongodb_carlisting['radio']                  = $mongo_data['features'][0]->radio;
                $mongodb_carlisting['audio']                  = $mongo_data['features'][0]->audio;
                $mongodb_carlisting['bluetooth']              = $mongo_data['features'][0]->bluetooth;

            }else{
                $mongo_data['features'] = array();
            }
            
            

            if(count($mongo_data['online']) >=1){
                $mongodb_carlisting['online_portal_id']         = $mongo_data['online'][0]->online_portal_id;
                $mongodb_carlisting['portal_primary_id']        = $mongo_data['online'][0]->portal_primary_id;

                $delearselecttiontype = "";
                if($mongo_data['online'][0]->dealer_selection == "listing")
                {
                    $delearselecttiontype = 0;
                }
                else
                {
                    $delearselecttiontype = 1;
                }
                //$mongodb_carlisting['listing_selection'] = $mongo_data['online'][0]->dealer_selection;
                $mongodb_carlisting['listing_selection']        = $delearselecttiontype;
                $mongodb_carlisting['auction_price']            = $mongo_data['online'][0]->auction_price;
                $mongodb_carlisting['auction_startdate']        = $mongo_data['online'][0]->auction_startdate;
                $mongodb_carlisting['auction_end_date']         = $mongo_data['online'][0]->auction_end_date;
                $mongodb_carlisting['inviation']                = $mongo_data['online'][0]->inviation;
                $mongodb_carlisting['listing_olx']              = $mongo_data['online'][0]->listing_olx;
                $mongodb_carlisting['listing_carwale']          = $mongo_data['online'][0]->listing_carwale;
                $mongodb_carlisting['listing_cardekho']         = $mongo_data['online'][0]->listing_cardekho;
                $mongodb_carlisting['listing_quickr']           = $mongo_data['online'][0]->listing_quickr;
                $mongodb_carlisting['listing_olx']              = $mongo_data['online'][0]->auction_price;
                $mongodb_carlisting['listing_carwale']          = $mongo_data['online'][0]->listing_carwale;
                $mongodb_carlisting['listing_cardekho']         = $mongo_data['online'][0]->listing_cardekho;
                $mongodb_carlisting['other_auction_type']       = $mongo_data['online'][0]->other_auction_type;
                $mongodb_carlisting['other_min_price']          = $mongo_data['online'][0]->other_min_price;
                $mongodb_carlisting['other_start_date']         = $mongo_data['online'][0]->other_start_date;
                $mongodb_carlisting['other_end_date']           = $mongo_data['online'][0]->other_end_date;
                $mongodb_carlisting['auctioninviation']         = $mongo_data['online'][0]->other_min_price;
            }else{
                $mongo_data['online'] = array();
            }
            $mongodb_carlisting['listing_status'] = 'Active';
            $mongodb_carlisting['sitename'] = 'Dealerplus';
            if($mongo_data['duplicate_id']=='')
            {
                $mongodb_carlisting->save();
                if($mongodb_carlisting){
                    $arryupdate     =   array("duplicate_id"=>$mongo_id,"mongopushdate"=>Carbon::now(),
                                                "mongopush_status"=>"success","car_master_status"=>2); 
                    $whereupdate    =   array("car_id"=>$duplicate_id); 
                    $update_data = inventorymodel::schema_mongopush_update($this->DmsCarListTable,$whereupdate,$arryupdate);
                    $dealer_schemaname = $this->dealer_schemaname;
                    $listing_details = array( 'inventory_id'=>$duplicate_id,
                                              'listing_id'=>$mongo_id,
                                              'listing_site'=>'Dealerplus',
                                              'listing_status'=>'Active',
                                              'user_id'=>$id,
                                              'createddate'=>Carbon::now()->format('Y-m-d'),
                                            );
                    inventorymodel::InsertTable($id,$dealer_schemaname,'dealer_listing_details',$listing_details);

                    $id = Session::get('ses_id');
                    //return json_encode(array('success'=>'successfully insertred mongo'));
                    /*echo shell_exec("php alertlisting.php ".base64_encode($mongo_data['make_name'])." ".base64_encode($mongo_data['model_name'])." ".base64_encode($mongo_data['variant_name'])." ".$mongo_id." ".$id." 2>&1");*/

                    $job = new \App\Jobs\TestQueue($mongo_data['make_name'],$mongo_data['model_name'],$mongo_data['variant_name'],$mongo_id,$id);

                    //$job = new \App\Jobs\TestQueue('Fiat','Fiat Linea','Active 1.3L MULTIJET','dplasdsdwerwesd123',$id);
                    dispatch($job);
                    return json_encode(array('success'=>'successfully insertred mongo'));
                }
                else{
                    $arryupdate     =   array("mongopushdate"=>Carbon::now(),
                                                "mongopush_status"=>"failure"); 
                    $whereupdate    =   array("car_id"=>$duplicate_id); 
                    $update_data = inventorymodel::schema_mongopush_update($this->DmsCarListTable,$whereupdate,$arryupdate);
                    return json_encode(array('failure'=>'Mongo Push Failed..'));
                }
            }
            else
            {
                $mongo_id =   $mongo_data['duplicate_id'];
                mongomodel::where('listing_id',$mongo_id)->update($mongodb_carlisting);
            }
        }
        else{
                $arryupdate     =   array("mongopushdate"=>Carbon::now(),
                                            "mongopush_status"=>"failure"); 
                $whereupdate    =   array("car_id"=>$duplicate_id); 
                $update_data = inventorymodel::schema_mongopush_update($this->DmsCarListTable,$whereupdate,$arryupdate);
                return json_encode(array('failure'=>'Mongo Push Failed..'));
        }
    }

    public function myposting()
    {
           
    if(empty(session::get('ses_id')))
    {
        return redirect('login');
    }
    else
    {   
        $id = session::get('ses_id');
        $param = array('car_id','duplicate_id','inventory_type','car_master_status','model_id','variant','mileage','registration_year','price','kms_done','fuel_type','car_master_status');
        $dealer_schemaname = $this->dealer_schemaname;
        $wherecondition = array('dealer_id'=>$id);
        $dms_car_listings = $this->DmsCarListTable;
        
        $sortingcolumn = 'price';
        $sortingcond = 'desc';
        
        //$sortcondition = array($sortingcolumn=>$sortingcond);
        $wherecondition['mongopush_status']='success';
        $wherecondition['mongopush_status']='success';
        
        $inventorydata = inventorymodel::inventoryTableDetails($dealer_schemaname,$dms_car_listings,$wherecondition,$param,$sortingcolumn,$sortingcond);
        $paginatelink = $inventorydata->links();
        $data = array();
        $inventorylistingdata = array();
        foreach ($inventorydata as $inventorykey => $inventoryvalue) {
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

            $DmsCarListPhotosTable = $this->DmsCarListPhotosTable;
            $DmsCarListVideosTable = $this->DmsCarListVideosTable;
            $DmsCarListDocumentTable = $this->DmsCarListDocumentTable;
            
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
                                $this->DealerViewedTable,
                                array('car_id'=>
                                $inventoryvalue->duplicate_id)
                                );
            
            $data['imagecount'] = inventorymodel::dealerTableCount($dealer_schemaname,$DmsCarListPhotosTable,array('car_id'=>$inventoryvalue->car_id));
            $data['videocount'] = inventorymodel::dealerTableCount($dealer_schemaname,$DmsCarListVideosTable,array('car_id'=>$inventoryvalue->car_id));
            $data['documentcount'] = inventorymodel::dealerTableCount($dealer_schemaname,$DmsCarListDocumentTable,array('car_id'=>$inventoryvalue->car_id));

            array_push($inventorylistingdata, $data);
        }
        $compact_array            = array
                                            ('active_menu_name'=>$this->active_menu_name,                   
                                             'side_bar_active'=>2  
                                            );

        $header_data= $this->header_data;
        $header_data['title']='My Posting';
        //print_r($inventorylistingdata);
        return view('myposting',compact('compact_array','header_data','inventorylistingdata','paginatelink'));
    }
    }
    //MY POSTING DETAILS IN SELL
    public function mypostingdetails()
    {
        $id                 =   session::get('ses_id');
        $listing_id         =   Input::get('car_view_id');        
        $dealer_schemaname  =   $this->dealer_schemaname;  
        $fetch_listing      =   buymodel::dealerFetchTableDetails($id,$dealer_schemaname,
                                        $this->DmsCarListTable,
                                        array('car_id'=>$listing_id)
                                        );

        $fetch_pricing      =   buymodel::dealerFetchTableDetails($id,$dealer_schemaname,
                                                                $this->DealerCarPricingTable,
                                                                array('listing_id'=>$listing_id)
                                                                );
        $fetch_photos       =   buymodel::dealerFetchTableDetails($id,$dealer_schemaname,
                                                                $this->DmsCarListPhotosTable,
                                                                array('car_id'=>$listing_id)
                                                                );
        $fetch_videos       =   buymodel::dealerFetchTableDetails($id,$dealer_schemaname,
                                                                $this->DmsCarListVideosTable,
                                                                array('car_id'=>$listing_id)
                                                                );

        $fetch_features     =   buymodel::dealerFetchTableDetails($id,$dealer_schemaname,'dealer_listing_features',array('listing_id'=>$listing_id));

        $fetch_online       =   buymodel::dealerFetchTableDetails($id,$dealer_schemaname,
                                                                $this->DmsOnlinePortalTable,
                                                                array('car_id'=>$listing_id)
                                                                );

        if(!empty($fetch_listing) && count($fetch_listing) >= 1)
        {
        $car_id                 = $fetch_listing[0]->duplicate_id;
        $variant_id             = $fetch_listing[0]->variant;
        $make_id                = $fetch_listing[0]->make;
        $model                  = $fetch_listing[0]->model_id;
        $city_name              = $fetch_listing[0]->car_city;
        $makename               = "";
        $modelname              = "";
        $variant_name           = "";
        $fetchmake              = schemamodel::master_table_makeid_model_varient('master_makes',
                                                                'make_id',$fetch_listing[0]->make
                                                                );
        if(count($fetchmake) >= 1){
            $makename = $fetchmake[0]->makename;
        }
                           
        $fetchmodel = schemamodel::master_table_makeid_model_varient('master_models','model_id',$fetch_listing[0]->model_id);     
        if(count($fetchmodel) >= 1){
            $modelname = $fetchmodel[0]->model_name;
        }
        
        $fetchvariant = schemamodel::master_table_makeid_model_varient('master_variants','variant_id',$fetch_listing[0]->variant);
        if(count($fetchvariant) >= 1){
            $variant_name = $fetchvariant[0]->variant_name;
        }        
        
        $created_at                             = $fetch_listing[0]->created_at;
        $detail_list_data['car_id']             = $fetch_listing[0]->car_id;
        $detail_list_data['dealer_id']          = $fetch_listing[0]->dealer_id;
        $detail_list_data['make']               = $makename;
        $detail_list_data['model']              = $modelname;
        $detail_list_data['variant']            = $variant_name;
        $detail_list_data['registration_year']  = $fetch_listing[0]->registration_year;
        $detail_list_data['fuel_type']          = $fetch_listing[0]->fuel_type;
        $getresultcolor = schemamodel::master_table_color($this->MasterColorTable,
                                                            'colour_id',
                                                            $fetch_listing[0]->colors
                                                        );

        if(!empty($getresultcolor) && count($getresultcolor) > 0)
        {
            $detail_list_data['colors']             = $getresultcolor[0]->colour_name;
        }           
        if($fetch_listing[0]->car_city == "")
        {
            $detail_list_data['car_locality']       = "";
        }    
        else{
            $getcityname     =  schemamodel::master_table_where($this->MasterCityTable,
                                                                "master_id",
                                                                $fetch_listing[0]->car_city
                                                            );            
            $detail_list_data['car_locality']   = $getcityname[0]->city_name; 
        }             

        if(count($fetch_features)>0)
        {
            $detail_list_data['seatingcapacity']    = $fetch_features[0]->seating_capacity;
        }
        else
        {
            $detail_list_data['seatingcapacity']    = 0;
        }
        $detail_list_data['fuel_capacity']      = $fetch_pricing[0]->fuel_capacity;
        $detail_list_data['owner_type']         = $fetch_listing[0]->owner_type;
        $detail_list_data['transmission']       = $fetch_listing[0]->transmission;
        $detail_list_data['kilometer_run']      = $fetch_listing[0]->kms_done;
        $detail_list_data['body_type']          = $fetch_listing[0]->body_type;
        $detail_list_data['mileage']            = $fetch_listing[0]->mileage; 

        if($fetch_listing[0]->mongopushdate == "")
        {
            $detail_list_data['mongopushdate']  =   "";
        }else
        {
            $detail_list_data['mongopushdate']  = commonmodel::getdatemonthformat($fetch_listing[0]->mongopushdate);
        } 
        //Pricing Info
        $detail_list_data['price']              = $fetch_pricing[0]->saleprice;           
        //Photos Info
        $photos_array                           = array();

        if(count($fetch_photos)>0)
        {
              foreach ($fetch_photos as $photokey => $photovalue) {
                  $photos_array[]=$photovalue->s3_bucket_path;
              }
              
              $detail_list_data['image_url'] = $photos_array;
        }
        else
        {
            $carnoimage                      =  Config::get('common.carnoimage');

            $detail_list_data['image_url']   =  array($carnoimage);
        }
        $onlinearray        =   array();
        $whereonline        =   array("portal_primary_id"=>$listing_id);
        $getonlineportal    =   schemamodel::schema_table_where($this->DmsOnlinePortalTable,$whereonline);
        
        $whereonline        =   array("inventory_id"=>$listing_id);
        $listing_details    =   schemamodel::schema_table_where('dealer_listing_details',$whereonline);
        $listing_data       = array();
        $listing_array     = array();
        foreach ($listing_details as $key) {
            $listing_data['listing_site']   = $key->listing_site;
            $listing_data['listing_status'] = $key->listing_status;
            $listing_data['listing_id'] = $key->listing_id;
            $listing_data['listing_category'] = 'Free';
            $listing_data['createddate'] = $key->createddate;
            array_push($listing_array, $listing_data);
        }
        

        }
         $compact_array            = array
                                        ('active_menu_name'=>$this->active_menu_name,                 
                                         'side_bar_active'=>2  
                                        );
      $header_data                  = $this->header_data;
      $header_data['title']='My Posting Details';
      $city_name                    = '';
      return view('mypostingdetails',compact('detail_list_data','listing_array','variant_det','header_data','bidding_data','fulldata','city_name','compact_array'));
    }

    public function myposting_delete()
    {
        $id = Session::get('ses_id');
        $dealer_schemaname = $this->dealer_schemaname;
        $inventory_id = Input::get('inventory_id');
        $listing_id   = Input::get('listing_id');
        $basic_info = $this->listing_basic_info($inventory_id);
        //dd($basic_info);
        $wheredata = array('inventory_id'=>$inventory_id,'listing_id'=>$listing_id);
        $setdata = array('listing_status'=>'Inactive');
        $car_status_id = 4;
        $api_sites_id = 4;
        $insert_posting_detail = array(
                                        'car_id'=>$inventory_id,
                                        'api_sites_id'=>$api_sites_id,
                                        'car_status_id'=>$car_status_id,
                                        'dealer_id'=>$id,
                                        'user_id'=>$id,
                                        'listing_info'=>$listing_id,
                                        'sale_price'=>$basic_info['price']
                                        );
        inventorymodel::InsertTable($id,$dealer_schemaname,'dealer_posting_history',$insert_posting_detail);
        inventorymodel::dealerUpdateTableDetails($id,$dealer_schemaname,'dealer_listing_details',$wheredata,$setdata);
        mongomodel::where('listing_id',$listing_id)->update($setdata);
    }

    public function myposting_repost()
    {
        $id = Session::get('ses_id');
        $dealer_schemaname = $this->dealer_schemaname;
        $inventory_id = Input::get('inventory_id');
        $listing_id   = Input::get('listing_id');
        $basic_info = $this->listing_basic_info($inventory_id);
        $wheredata = array('inventory_id'=>$inventory_id,'listing_id'=>$listing_id);
        $setdata = array('listing_status'=>'Active');
        $car_status_id = 5;
        $api_sites_id = 4;
        $insert_posting_detail = array(
                                        'car_id'=>$inventory_id,
                                        'api_sites_id'=>$api_sites_id,
                                        'car_status_id'=>$car_status_id,
                                        'dealer_id'=>$id,
                                        'user_id'=>$id,
                                        'listing_info'=>$listing_id,
                                        'sale_price'=>$basic_info['price']
                                        );
        inventorymodel::InsertTable($id,$dealer_schemaname,'dealer_posting_history',$insert_posting_detail);
        inventorymodel::dealerUpdateTableDetails($id,$dealer_schemaname,'dealer_listing_details',$wheredata,$setdata);
        mongomodel::where('listing_id',$listing_id)->update($setdata);
    }

    public function loanforcustomer()
    {
      $id                       = session::get('ses_id');        
      $tablename                = 'dealer_customerloan_details';
      $fetch_queried_details    = inventorymodel::schema_table($tablename);      
      $loandata                 = array();
      $data                     = array();
      foreach ($fetch_queried_details as $key){
          $data['ticket_id']          = $key->ticket_id;
          $data['customername']       = $key->customername;
          $data['mobileno']           = $key->customermobileno;
          $data['mailid']             = $key->customermailid;
          $data['city']               = $key->customercity;
          $data['requested_amount']   = $key->requested_amount;
          $data['status']             = $key->status;
          $data['created_date']       = $key->created_date;
          array_push($loandata, $data);  
      }
      //$queriesdata=$fulldata;
      $header_data              = $this->header_data;
      $compact_array            = array('active_menu_name'=>$this->active_menu_name,
                                        'left_menu'=>5,
                                        'loandata'=>$loandata
                                        );
      return view('applied_loan_view',compact('compact_array','header_data'));
    }

    /*
    *The Function name ApplyFunding 
    *Apply the finding for car in my queries page
    */
    public function apply_loan()
    {
        $id                   = session::get('ses_id'); 
        $customername         = Input::get('customername');
        $customercontactno    = Input::get('customercontactno');
        $customermailid       = Input::get('customermailid');
        $customermobileno     = Input::get('customermobileno');
        $customerdate         = Input::get('customerdate');
        $customercity         = Input::get('customercity');
        $customerarea         = Input::get('customerarea');
        $requested_amount     = Input::get('requested_amount');

        $currentdate          = Carbon::now();
        $fundPrefix           = Config::get('common.fundPrefix');
        $ticket_id            = $fundPrefix.$currentdate->format('Ymdhis');
        
        $insertrecord         = array('ticket_id'=>$ticket_id,
                                     'customername'=>$customername,
                                     'customercontactno'=>$customercontactno,
                                     'customermailid'=>$customermailid,
                                     'customermobileno'=>$customermobileno,
                                     'requested_amount'=>$requested_amount,
                                     'customercity'=>$customercity,
                                     'customerarea'=>$customerarea,
                                     'created_date'=>$customerdate,
                                     'user_id'=>$id
                                      );
        $dealer_funding_tablename='dealer_customerloan_details';
        inventorymodel::schema_insertId($dealer_funding_tablename,$insertrecord);
    }
    //
    public function variant_selection()
    {
        $variant_id     = Input::get('variant_id');
        $fetchvariant   = buymodel::masterVariantDetail(array('variant_id'=>$variant_id));
        $data = array();
        $data = array(
            'overviewdesc'=>$fetchvariant->variant_desc,
            'gear_box'=>$fetchvariant->Gear_box,
            'drive_type'=>$fetchvariant->Drive_Type,
            'seating_capacity'=>$fetchvariant->Seating_Capacity,
            'steering_type'=>$fetchvariant->Steering_Gear_Type,
            'turning_radius'=>$fetchvariant->Turning_Radius,
            'top_speed'=>$fetchvariant->Top_Speed,
            'acceleration'=>$fetchvariant->Acceleration,
            'tyre_type'=>$fetchvariant->Tyre_Type,
            'no_of_doors'=>$fetchvariant->No_of_Doors,
            'engine_type'=>$fetchvariant->Engine_Description,
            'displacement'=>$fetchvariant->Engine_Displacementcc,
            'max_power'=>$fetchvariant->Maximum_Power,
            'max_torque'=>$fetchvariant->Maximum_Torque,
            'no_of_cylinder'=>$fetchvariant->No_of_Cylinders,
            'valves_per_cylinder'=>$fetchvariant->Valves_Per_Cylinder,

            'valve_configuration'=>$fetchvariant->valve_configuration,

            'fuel_supply_system'=>$fetchvariant->Fuel_Supply_System,
            'turbo_charger'=>$fetchvariant->Turbo_Charger,
            'super_charger'=>$fetchvariant->Super_Charger,
            'length'=>$fetchvariant->Length,
            'width'=>$fetchvariant->Width,
            'height'=>$fetchvariant->Height,
            'wheel_base'=>$fetchvariant->Wheel_Base,
            'gross_weight'=>$fetchvariant->Gross_Weight);
        $checkboxdata = array(
            'air_conditioner'=>$fetchvariant->Air_Conditioner,
            'adjustable_steering'=>$fetchvariant->Power_Steering,

            'leather_steering_wheel'=>$fetchvariant->leather_steering_wheel,
            'heater'=>$fetchvariant->heater,
            'digital_clock'=>$fetchvariant->digital_clock,

            'power_steering'=>$fetchvariant->Power_Steering,

            'power_windows_front'=>$fetchvariant->power_windows_front,
            'power_windows_rear'=>$fetchvariant->power_windows_rear,

            'remote_trunk_opener'=>$fetchvariant->Remote_Trunk_Opener,
            'remote_fuel_lid_opener'=>$fetchvariant->Remote_Fuel_Lid_Opener,
            'low_fuel_warning_light'=>$fetchvariant->Low_Fuel_Warning_Light,
            'rear_reading_lamp'=>$fetchvariant->Rear_Reading_Lamp,
            'rear_seat_headrest'=>$fetchvariant->Rear_Seat_Headrest,
            'rear_seat_centre_arm_rest'=>$fetchvariant->Rear_Seat_Center_Arm_Rest,
            'height_adjustable_front_seat_belts'=>$fetchvariant->Height_Adjustable_Front_Seat_Belts,
            'cup_holders_front'=>$fetchvariant->Cup_Holders_Front,
            'cup_holders_rear'=>$fetchvariant->Cup_Holders_Rear,
            'rear_ac_vents'=>$fetchvariant->Rear_A_C_Vents,
            'parking_sensors'=>$fetchvariant->Parking_Sensors,
            'anti_lock_braking_system'=>$fetchvariant->Anti_Lock_Braking_System,
            'central_locking'=>$fetchvariant->Central_Locking,
            'child_safety_lock'=>$fetchvariant->Child_Safety_Locks,
            'driver_airbags'=>$fetchvariant->Driver_Airbag,
            'passenger_airbag'=>$fetchvariant->Passenger_Airbag,
            'rear_seat_belts'=>$fetchvariant->Rear_Seat_Belts,
            'seat_belt_warning'=>$fetchvariant->Seat_Belt_Warning,
            'adjustable_seats'=>$fetchvariant->Adjustable_Seats,
            'crash_sensor'=>$fetchvariant->Crash_Sensor,
            'anti_theft_device'=>$fetchvariant->Anti_Theft_Alarm,
            'immobilizer'=>$fetchvariant->Engine_Immobilizer,
            
            'adjustable_head_lights'=>$fetchvariant->adjustable_head_lights,
            'power_adjustable_exterior_rear_view_mirror'=>$fetchvariant->power_adjustable_exterior_rear_view_mirror,
            'electric_folding_rear_view_mirror'=>$fetchvariant->electric_folding_rear_view_mirror,
            'rain_sensing_wipers'=>$fetchvariant->rain_sensing_wipers,
            'rear_window_wiper'=>$fetchvariant->rear_window_wiper,
            'alloy_wheels'=>$fetchvariant->alloy_wheels,
            'tinted_glass'=>$fetchvariant->tinted_glass,
            'front_fog_lights'=>$fetchvariant->front_fog_lights,
            'rear_window_defogger'=>$fetchvariant->rear_window_defogger,

            'cdplayer'=>$fetchvariant->CD_Player,
            'radio'=>$fetchvariant->FM_AM_Radio,
            'audio'=>$fetchvariant->Audio_System_Remote_Control,
            'bluetooth'=>$fetchvariant->Bluetooth_Connectivity,
        );
        
        return json_encode(array('textboxvalues'=>$data,'checkboxvalues'=>$checkboxdata));
    }
    //Inventory Tab Functionality Main
    public function add_inventory($inventoryid='')
    {
        $year                       = commonmodel::master_car_reg_year();  
        $city                       = commonmodel::get_master_city();
        $header_data                = $this->header_data;
        $compact_array              = array
                                        (
                                            'active_menu_name'  =>$this->active_menu_name,                   

                                            'side_bar_active'   =>'1',

                                            'year'              => $year,

                                            'city'              =>$city
                                        );
        $make               = commonmodel::makedropdown();
        $model              = array();
        $Variant            = array();
        $color              = $this->SchemaObject->master_table(
                                                            $this->MasterColorTable
                                                            );
        $selectcategory     = $this->SchemaObject->master_table('master_category');
        $Ownership          = array(""=>"Select Ownership",
                                    "FIRST"=>"1",
                                    "SECOND"=>"2",
                                    "THIRD"=>"3",
                                    "Fourth"=>"4",
                                    "Four +"=>"4 +"
                                    );
        $CarStatus          = array(""=>"Select Car Status",
                                    "3"=>"Excellent",
                                    "2"=>"Medium",
                                    "1"=>"Good",
                                    );
        $selectfuel         = array(""=>"Select Fuel Type",
                                    "Petrol"=>"Petrol",
                                    "Diesel"=>"Diesel",
                                    "Gas"=>"Gas"
                                    );
        $selectdeleare      = array(""=>"Select",
                                    "customer"=>"Customer",
                                    "dealer"=>"Dealer",
                                    "broker"=>"Broker",
                                    "car_wale"=>"Car Wale",
                                    "olx"=>"OLX",
                                    "quickr"=>"Quickr",
                                    "others"=>"Others"
                                    );
        $car_id = $inventoryid;
        $branch = array();
        $id = Session::get('ses_id');
        $dealer_schemaname = $this->dealer_schemaname;
        if($car_id!='')
        {
            $wherecondition = array('car_id'=>$inventoryid);            
            $basic_info = inventorymodel::dealerFetchTableDetails($dealer_schemaname,'dms_car_listings',$wherecondition);
            $prince_info = inventorymodel::dealerFetchTableDetails($dealer_schemaname,'dealer_cars_pricing',array('listing_id'=>$inventoryid));
            $expense_info = inventorymodel::dealerFetchTableDetails($dealer_schemaname,'dealer_car_expenses',$wherecondition);
            $branch = buymodel::dealerFetchTableDetails($id,$dealer_schemaname,'dms_dealer_branches',array('dealer_city'=>$basic_info[0]->car_city));
            $basic_info_array = array(
                                'model_id'          =>$basic_info[0]->model_id,     
                                'category_id'       =>$basic_info[0]->category_id,
                                'registration_year' =>$basic_info[0]->registration_year,       
                                'make'              =>$basic_info[0]->make, 
                                'model'             =>$basic_info[0]->model_id,        
                                'variant'           =>$basic_info[0]->variant, 
                                'kms_done'          =>$basic_info[0]->kms_done, 
                                'mileage'           =>$basic_info[0]->mileage, 
                                'owner_type'        =>$basic_info[0]->owner_type, 
                                'status'            =>$basic_info[0]->status, 
                                'branch_id'         =>$basic_info[0]->branch_id, 
                                'transmission'      =>$basic_info[0]->transmission, 
                                'colors'            =>$basic_info[0]->colors, 
                                'car_city'          =>$basic_info[0]->car_city, 
                                'fuel_type'         =>$basic_info[0]->fuel_type,
                                'branch_id'         =>$basic_info[0]->branch_id,
                                'transmission'      =>$basic_info[0]->transmission,
                                'engine_number'     =>$basic_info[0]->engine_number,
                                'chassis_number'    =>$basic_info[0]->chassis_number,
                                'registration_number'=>$basic_info[0]->registration_number,
                                );
            $Variant = inventorymodel::master_table_color($this->MasterVariantTable,'model_id',$basic_info[0]->model_id);
            $model = inventorymodel::master_table_color('master_models','make_id',$basic_info[0]->make);
            $prince_info_array = array(
                                        'ownpurchase_date'=>commonmodel::checkdatecontent($prince_info[0]->ownpurchase_date),
                                        'ownpurchased_from'=>$prince_info[0]->ownpurchased_from,
                                        'ownreceived_from_name'=>$prince_info[0]->ownreceived_from_name,
                                        'ownpurchased_price'=>$prince_info[0]->ownpurchased_price,
                                        'ownkey_received'=>$prince_info[0]->ownkey_received,
                                        'owndocuments_received'=>$prince_info[0]->owndocuments_received,
                                        'documents_received'=>$prince_info[0]->documents_received,
                                        'inventory_type'=>$prince_info[0]->inventory_type,
                                        'test_drive'=>$prince_info[0]->test_drive,
                                        'testdrive_dealerpoint'=>$prince_info[0]->testdrive_dealerpoint,
                                        'testdrive_doorstep'=>$prince_info[0]->testdrive_doorstep,
                                        'markup_condition'=>$prince_info[0]->markup_condition,
                                        'markup_percentage'=>$prince_info[0]->markup_percentage,
                                        'markup_value'=>$prince_info[0]->markup_value,
                                        'saleprice'=>$prince_info[0]->saleprice,
                                        'purchase_date'=>commonmodel::checkdatecontent($prince_info[0]->purchase_date),
                                        'starting_kms'=>$prince_info[0]->starting_kms,
                                        'received_from_own'=>$prince_info[0]->received_from_own,
                                        'received_from_name'=>$prince_info[0]->received_from_name,
                                        'fuel_indication'=>$prince_info[0]->fuel_indication,
                                        'fuel_capacity'=>$prince_info[0]->fuel_capacity,
                                        'customer_asking_price'=>$prince_info[0]->customer_asking_price,
                                        'dealer_markup_price'=>$prince_info[0]->dealer_markup_price,
                                        'keys_available'=>$prince_info[0]->keys_available,
                                        'documents_received'=>$prince_info[0]->documents_received,
                                        );
            $oldexpense = array();
        }
        else
        {
            if(old('model')!=''){
            $Variant = inventorymodel::master_table_color($this->MasterVariantTable,'model_id',old('model'));
            }
            if(old('make')!=''){
            $model = inventorymodel::master_table_color('master_models','make_id',old('make'));
            }

            if(old('place')!=''){
             $branch = buymodel::dealerFetchTableDetails($id,$dealer_schemaname,'dms_dealer_branches',array('dealer_city'=>old('place')));
            }
           
            $basic_info_array = array(
                                'model_id'          =>old('model'),     
                                'category_id'       =>old('category_id'),
                                'registration_year' =>old('registration_year'),       
                                'make'              =>old('make'), 
                                'model'             =>old('model'),        
                                'variant'           =>old('variant'), 
                                'kms_done'          =>old('kms_done'), 
                                'mileage'           =>old('mileage'), 
                                'owner_type'        =>old('owner_type'), 
                                'status'            =>old('status'), 
                                'add_list_status'   =>'1', 
                                'colors'            =>old('colors'), 
                                'car_city'          =>old('place'), 
                                'fuel_type'         =>old('fuel_type'),
                                'branch_id'         =>old('branch'),
                                'transmission'      =>old('transmission'),
                                'engine_number'     =>old('engine_number'),
                                'chassis_number'    =>old('chassis_number'),
                                'registration_number'=>old('registration_number'),
                                );

            if(old('inventory_type')=='')
            {
                $oldinventory_type = 'OWN';
            }
            else
            {
                $oldinventory_type = old('inventory_type');
            }

            if(old('test_drive')=='')
            {
                $oldtest_drive = '1';
            }
            else
            {
                $oldtest_drive = old('test_drive');
            }

            if(old('testdrive_dealerpoint')=='')
            {
                $oldtestdrive_dealerpoint = '1';
            }
            else
            {
                $oldtestdrive_dealerpoint = old('testdrive_dealerpoint');
            }

            if(old('testdrive_doorstep')=='')
            {
                $oldtestdrive_doorstep = '1';
            }
            else
            {
                $oldtestdrive_doorstep = old('testdrive_doorstep');
            }

            if(old('markup_condition')=='')
            {
                $oldmarkup_condition = 'option1';
            }
            else
            {
                $oldmarkup_condition = old('markup_condition');
            }

            if(old('customer_asking_price')=='')
            {
                $oldcustomer_asking_price = '0.00';
            }
            else
            {
                $oldcustomer_asking_price = old('customer_asking_price');
            }

            if(old('dealer_markup_price')=='')
            {
                $olddealer_markup_price = '0.00';
            }
            else
            {
                $olddealer_markup_price = old('dealer_markup_price');
            }

            if(old('expense_desc')=='')
            {
                $expense_desc = '0.00';
            }
            else
            {
                $expense_desc = old('expense_desc');
            }
            if(old('expense_amount')=='')
            {
                $expense_amount = '0.00';
            }
            else
            {
                $expense_amount = old('expense_amount');
            }
            $oldexpense = array();

            if(count(old('extrarupee'))>0){
                foreach(old('extrarupee') as $key => $value)
                {
                    if(!empty(old('extra')[$key])&&!empty(old('extrarupee')[$key]))
                    {
                        $oldexpense[old('extra')[$key]]=old('extrarupee')[$key];
                    }
                }
            }
            
            $prince_info_array = array(
                                        'ownpurchase_date'=>old('ownpurchase_date'),
                                        'ownpurchased_from'=>old('ownpurchased_from'),
                                        'ownreceived_from_name'=>old('ownreceived_from_name'),
                                        'ownpurchased_price'=>old('ownpurchased_price'),
                                        'ownkey_received'=>old('ownkey_received'),
                                        'owndocuments_received'=>old('owndocuments_received'),
                                        'documents_received'=>old('documents_received'),
                                        'inventory_type'=>$oldinventory_type,
                                        'test_drive'=>$oldtest_drive,
                                        'testdrive_dealerpoint'=>$oldtestdrive_dealerpoint,
                                        'testdrive_doorstep'=>$oldtestdrive_doorstep,
                                        'markup_condition'=>$oldmarkup_condition,
                                        'markup_percentage'=>old('percentage'),
                                        'markup_value'=>old('markup_value'),
                                        'saleprice'=>old('price'),
                                        'purchase_date'=>old('purchase_date'),
                                        'starting_kms'=>old('starting_kms'),
                                        'received_from_own'=>old('received_from_own'),
                                        'received_from_name'=>old('received_from_name'),
                                        'fuel_indication'=>old('fuel_indication'),
                                        'fuel_capacity'=>old('fuel_capacity'),
                                        'customer_asking_price'=>$oldcustomer_asking_price,
                                        'dealer_markup_price'=>$olddealer_markup_price,
                                        'keys_available'=>old('keys_available'),
                                        'documents_received'=>old('documents_received'),
                                        'expense_desc'=>$expense_desc,
                                        'expense_amount'=>$expense_amount,
                                        );
            $expense_info  = array();
            
        }
        $fetchedvalues = array(
                                'basic_info'=>$basic_info_array,
                                'prince_info'=>$prince_info_array,
                                'expense_info'=>$expense_info,
                                'listing_id' => $car_id,
                              );
        $header_data['title']='Add Inventory';
        
        return view('add_list_inventory_tab',compact('branch','selectdeleare','Ownership','CarStatus','selectfuel','make','model','Variant','color','selectcategory','header_data','compact_array','fetchedvalues','oldexpense'));
    }
    public function fastlaneapicall()
    {
        $id = Session::get('ses_id');
        $registration_number = Input::get('registration_number');
        $registration_number =   strtoupper($registration_number);
        $checkregnum         =   fastlanemongo::where('regn_no',$registration_number)->get();
        //dd($checkregnum);
        if(!empty($checkregnum) && count($checkregnum) >= 1)
        {
            
            $vehicledetails = $checkregnum;
            //dd($vehicledetails[0]->vehicle['fla_maker_desc']);
           /* exit;
            foreach($checkregnum as $vehicledetails)
            {*/
                //$vehicledetails   =   $returnjsondata->results;  
         
                $fetch_make_details = buyymodel::masterFetchTableDetails($id,'master_makes',array('ibb_make'=>$vehicledetails[0]->vehicle['fla_maker_desc']));
                if(count($fetch_make_details)>0)
                {
                    $fast_make_id = $fetch_make_details[0]->make_id;
                }
                else
                {
                    $fast_make_id = 0;
                }
                
                $fetch_model_details = buyymodel::masterFetchTableDetails($id,'master_models',array('ibb_model'=>$vehicledetails[0]->vehicle['fla_model_desc']));
                if(count($fetch_model_details)>0)
                {
                    $fast_model_id = $fetch_model_details[0]->model_id;
                }
                else
                {
                    $fast_model_id = 0;
                }
                $fetch_variant_details = buyymodel::masterFetchTableDetails($id,'master_variants',array('ibb_variants'=>$vehicledetails[0]->vehicle['fla_variant']));
                if(count($fetch_variant_details)>0)
                {
                    $fast_variant_id = $fetch_variant_details[0]->variant_id;
                }
                else
                {
                    $fast_variant_id = 0;
                }

                $fetch_city_details = buyymodel::masterFetchTableDetails($id,'master_city',array('city_name'=>$vehicledetails[0]->vehicle['c_city']));
                if(count($fetch_city_details)>0)
                {
                    $fast_city_id = $fetch_city_details[0]->city_id;
                }
                else
                {
                    $fast_city_id = 0;
                }
                $fetch_color_details = buyymodel::masterFetchTableDetails($id,'master_colors',array('colour_name'=>$vehicledetails[0]->vehicle['color']));
                if(count($fetch_color_details)>0)
                {
                    $fast_color_id = $fetch_color_details[0]->colour_id;
                }
                else
                {
                    $fast_color_id = 0;
                }
                $fast_seat_cap  = $vehicledetails[0]->vehicle['seat_cap'];
                $fast_manu_yr  = $vehicledetails[0]->vehicle['manu_yr'];
                $fast_owner_type = 'FIRST';
                switch($vehicledetails[0]->vehicle['owner_sr'])
                {
                     case 1:
                     $fast_owner_type  = 'FIRST';
                     break;
                     case 2:
                     $fast_owner_type  = 'SECOND';
                     break;
                     case 3:
                     $fast_owner_type  = 'THIRD';
                     break;
                     case 4:
                     $fast_owner_type  = 'Fourth';
                     break;
                     case 5:
                     $fast_owner_type  = 'Four +';
                     break;
                }

                $datawithids = array(
                                     'fast_make_id'=>$fast_make_id,
                                     'fast_model_id'=>$fast_model_id,
                                     'fast_variant_id'=>$fast_variant_id,
                                     'fast_city_id'=>$fast_city_id,
                                     'fast_seat_cap'=>$fast_seat_cap,
                                     'fast_manu_yr'=>$fast_manu_yr,
                                     'fast_owner_type'=>$fast_owner_type,

                                     'fast_hypothacation_type'=>$vehicledetails[0]->hypth['hp_type'],
                                     'fast_finacier_name'=>$vehicledetails[0]->hypth['fncr_name'],
                                     'fast_fla_finacier_name'=>$vehicledetails[0]->hypth['fla_fncr_name'],
                                     'fast_from_date'=>$vehicledetails[0]->hypth['from_dt'],

                                     'fast_comp_cd_desc'=>$vehicledetails[0]->insurance['comp_cd_desc'],
                                     'fast_fla_insurance_name'=>$vehicledetails[0]->insurance['fla_ins_name'],
                                     'fast_insurance_type_desc'=>$vehicledetails[0]->insurance['ins_type_desc'],
                                     'fast_insurance_from'=>$vehicledetails[0]->insurance['ins_from'],
                                     'fast_insurance_upto'=>$vehicledetails[0]->insurance['ins_upto'],
                                    );
                
                $data = array('registration_number'=>$vehicledetails[0]->vehicle['regn_no'],
                              'engine_number'=>$vehicledetails[0]->vehicle['eng_no'],
                              'chassis_number'=>$vehicledetails[0]->vehicle['chasi_no'],
                                );
                $modaldata = array(
                                  'regn_no'=>$vehicledetails[0]->vehicle['regn_no'],
                                  'state_cd'=>$vehicledetails[0]->vehicle['state_cd'],
                                  'rto_cd'=>$vehicledetails[0]->vehicle['rto_cd'],
                                  'rto_name'=>$vehicledetails[0]->vehicle['rto_name'],
                                  'chasi_no'=>$vehicledetails[0]->vehicle['chasi_no'],
                                  'eng_no'=>$vehicledetails[0]->vehicle['eng_no'],
                                  'regn_dt'=>$vehicledetails[0]->vehicle['regn_dt'],
                                  'purchase_dt'=>$vehicledetails[0]->vehicle['purchase_dt'],
                                  'vh_class_desc'=>$vehicledetails[0]->vehicle['vh_class_desc'],
                                  'fla_vh_class_desc'=>$vehicledetails[0]->vehicle['fla_vh_class_desc'],
                                  'owner_sr'=>$vehicledetails[0]->vehicle['owner_sr'],
                                  'owner_cd_desc'=>$vehicledetails[0]->vehicle['owner_cd_desc'],
                                  'regn_type'=>$vehicledetails[0]->vehicle['regn_type'],
                                  'regn_type_desc'=>$vehicledetails[0]->vehicle['regn_type_desc'],
                                  'c_city'=>$vehicledetails[0]->vehicle['c_city'],
                                  'c_pincode'=>$vehicledetails[0]->vehicle['c_pincode'],
                                  'p_city'=>$vehicledetails[0]->vehicle['p_city'],
                                  'p_pincode'=>$vehicledetails[0]->vehicle['p_pincode'],
                                  'vehicle_cd'=>$vehicledetails[0]->vehicle['vehicle_cd'],
                                  'maker_desc'=>$vehicledetails[0]->vehicle['maker_desc'],
                                  'fla_maker_desc'=>$vehicledetails[0]->vehicle['fla_maker_desc'],
                                  'series'=>$vehicledetails[0]->vehicle['series'],
                                  'maker_model'=>$vehicledetails[0]->vehicle['maker_model'],
                                  'fla_model_desc'=>$vehicledetails[0]->vehicle['fla_model_desc'],
                                  'fla_variant'=>$vehicledetails[0]->vehicle['fla_variant'],
                                  'fla_sub_variant'=>$vehicledetails[0]->vehicle['fla_sub_variant'],
                                  'color'=>$vehicledetails[0]->vehicle['color'],
                                  'fuel_type_desc'=>$vehicledetails[0]->vehicle['fuel_type_desc'],
                                  'fla_fuel_type_desc'=>$vehicledetails[0]->vehicle['fla_fuel_type_desc'],
                                  'cubic_cap'=>$vehicledetails[0]->vehicle['cubic_cap'],
                                  'fla_cubic_cap'=>$vehicledetails[0]->vehicle['fla_cubic_cap'],
                                  'manu_yr'=>$vehicledetails[0]->vehicle['manu_yr'],
                                  'seat_cap'=>$vehicledetails[0]->vehicle['seat_cap'],
                                  'fla_seat_cap'=>$vehicledetails[0]->vehicle['fla_seat_cap'],
                                  'hp_type'=>$vehicledetails[0]->hypth['hp_type'],
                                  'fncr_name'=>$vehicledetails[0]->hypth['fncr_name'],
                                  'fla_fncr_name'=>$vehicledetails[0]->hypth['fla_fncr_name'],
                                  'from_dt'=>$vehicledetails[0]->hypth['from_dt'],
                                  'comp_cd_desc'=>$vehicledetails[0]->insurance['comp_cd_desc'],
                                  'fla_ins_name'=>$vehicledetails[0]->insurance['fla_ins_name'],
                                  'ins_type_desc'=>$vehicledetails[0]->insurance['ins_type_desc'],
                                  'ins_from'=>$vehicledetails[0]->insurance['ins_from'],
                                  'ins_upto'=>$vehicledetails[0]->insurance['ins_upto'],
                                );
                return json_encode(array('message'=>'success','data'=>$data,'modaldata'=>$modaldata,'datawithids'=>$datawithids));
            
        }
        else
        {
            $returndata   =   fastlane::fetch_vehicle_detail($registration_number);

            $returnjsondata   =   json_decode($returndata);
            if($returnjsondata->status == 100)
            {
                //fastlanemongo::insert($returnjsondata);
                $datainsert             =   new fastlanemongo;
                $datainsert['regn_no']  =   $returnjsondata->results[0]->vehicle->regn_no;
                $datainsert['success']  =   "100";
                foreach($returnjsondata->results[0] as $key=>$vehicle)
                {
                    if($key     ==  "vehicle")
                    {
                        $datainsert['vehicle']  =   $vehicle;
                    }
                    if($key     ==  "hypth")
                    {
                        $datainsert['hypth']    =   $vehicle;
                    }
                    if($key     ==  "insurance")
                    {
                        $datainsert['insurance']    =   $vehicle;
                    }
                }

                $datainsert['fastlane_status']= "Active";
                $datainsert->save();
                $vehicledetails   =   $returnjsondata->results;  
                $fetch_make_details = buyymodel::masterFetchTableDetails($id,'master_makes',array('ibb_make'=>$vehicledetails[0]->vehicle->fla_maker_desc));
                if(count($fetch_make_details)>0)
                {
                    $fast_make_id = $fetch_make_details[0]->make_id;
                }
                else
                {
                    $fast_make_id = 0;
                }
                $fetch_model_details = buyymodel::masterFetchTableDetails($id,'master_models',array('ibb_model'=>$vehicledetails[0]->vehicle->fla_model_desc));
                if(count($fetch_model_details)>0)
                {
                    $fast_model_id = $fetch_model_details[0]->model_id;
                }
                else
                {
                    $fast_model_id = 0;
                }
                $fetch_variant_details = buyymodel::masterFetchTableDetails($id,'master_variants',array('ibb_variants'=>$vehicledetails[0]->vehicle->fla_variant));
                if(count($fetch_variant_details)>0)
                {
                    $fast_variant_id = $fetch_variant_details[0]->variant_id;
                }
                else
                {
                    $fast_variant_id = 0;
                }

                $fetch_city_details = buyymodel::masterFetchTableDetails($id,'master_city',array('city_name'=>$vehicledetails[0]->vehicle->c_city));
                if(count($fetch_city_details)>0)
                {
                    $fast_city_id = $fetch_city_details[0]->city_id;
                }
                else
                {
                    $fast_city_id = 0;
                }
                $fetch_color_details = buyymodel::masterFetchTableDetails($id,'master_colors',array('colour_name'=>$vehicledetails[0]->vehicle->color));
                if(count($fetch_color_details)>0)
                {
                    $fast_color_id = $fetch_color_details[0]->colour_id;
                }
                else
                {
                    $fast_color_id = 0;
                }
                $fast_seat_cap  = $vehicledetails[0]->vehicle->seat_cap;
                $fast_manu_yr  = $vehicledetails[0]->vehicle->manu_yr;

                switch($vehicledetails[0]->vehicle->owner_sr)
                {
                     case 1:
                     $fast_owner_type  = 'FIRST';
                     break;
                     case 2:
                     $fast_owner_type  = 'SECOND';
                     break;
                     case 3:
                     $fast_owner_type  = 'THIRD';
                     break;
                     case 4:
                     $fast_owner_type  = 'Fourth';
                     break;
                     case 5:
                     $fast_owner_type  = 'Four +';
                     break;
                }

                $datawithids = array(
                                     'fast_make_id'=>$fast_make_id,
                                     'fast_model_id'=>$fast_model_id,
                                     'fast_variant_id'=>$fast_variant_id,
                                     'fast_city_id'=>$fast_city_id,
                                     'fast_seat_cap'=>$fast_seat_cap,
                                     'fast_manu_yr'=>$fast_manu_yr,
                                     'fast_owner_type'=>$fast_owner_type,

                                     'fast_hypothacation_type'=>$vehicledetails[0]->hypth->hp_type,
                                     'fast_finacier_name'=>$vehicledetails[0]->hypth->fncr_name,
                                     'fast_fla_finacier_name'=>$vehicledetails[0]->hypth->fla_fncr_name,
                                     'fast_from_date'=>$vehicledetails[0]->hypth->from_dt,
                                     'fast_comp_cd_desc'=>$vehicledetails[0]->insurance->comp_cd_desc,

                                     'fast_fla_insurance_name'=>$vehicledetails[0]->insurance->fla_ins_name,
                                     'fast_insurance_type_desc'=>$vehicledetails[0]->insurance->ins_type_desc,
                                     'fast_insurance_from'=>$vehicledetails[0]->insurance->ins_from,
                                     'fast_insurance_upto'=>$vehicledetails[0]->insurance->ins_upto,
                                    );
                
                $data = array('registration_number'=>$vehicledetails[0]->vehicle->regn_no,
                              'engine_number'=>$vehicledetails[0]->vehicle->eng_no,
                              'chassis_number'=>$vehicledetails[0]->vehicle->chasi_no,
                                );
                $modaldata = array(
                                  'regn_no'=>$vehicledetails[0]->vehicle->regn_no,
                                  'state_cd'=>$vehicledetails[0]->vehicle->state_cd,
                                  'rto_cd'=>$vehicledetails[0]->vehicle->rto_cd,
                                  'rto_name'=>$vehicledetails[0]->vehicle->rto_name,
                                  'chasi_no'=>$vehicledetails[0]->vehicle->chasi_no,
                                  'eng_no'=>$vehicledetails[0]->vehicle->eng_no,
                                  'regn_dt'=>$vehicledetails[0]->vehicle->regn_dt,
                                  'purchase_dt'=>$vehicledetails[0]->vehicle->purchase_dt,
                                  'vh_class_desc'=>$vehicledetails[0]->vehicle->vh_class_desc,
                                  'fla_vh_class_desc'=>$vehicledetails[0]->vehicle->fla_vh_class_desc,
                                  'owner_sr'=>$vehicledetails[0]->vehicle->owner_sr,
                                  'owner_cd_desc'=>$vehicledetails[0]->vehicle->owner_cd_desc,
                                  'regn_type'=>$vehicledetails[0]->vehicle->regn_type,
                                  'regn_type_desc'=>$vehicledetails[0]->vehicle->regn_type_desc,
                                  'c_city'=>$vehicledetails[0]->vehicle->c_city,
                                  'c_pincode'=>$vehicledetails[0]->vehicle->c_pincode,
                                  'p_city'=>$vehicledetails[0]->vehicle->p_city,
                                  'p_pincode'=>$vehicledetails[0]->vehicle->p_pincode,
                                  'vehicle_cd'=>$vehicledetails[0]->vehicle->vehicle_cd,
                                  'maker_desc'=>$vehicledetails[0]->vehicle->maker_desc,
                                  'fla_maker_desc'=>$vehicledetails[0]->vehicle->fla_maker_desc,
                                  'series'=>$vehicledetails[0]->vehicle->series,
                                  'maker_model'=>$vehicledetails[0]->vehicle->maker_model,
                                  'fla_model_desc'=>$vehicledetails[0]->vehicle->fla_model_desc,
                                  'fla_variant'=>$vehicledetails[0]->vehicle->fla_variant,
                                  'fla_sub_variant'=>$vehicledetails[0]->vehicle->fla_sub_variant,
                                  'color'=>$vehicledetails[0]->vehicle->color,
                                  'fuel_type_desc'=>$vehicledetails[0]->vehicle->fuel_type_desc,
                                  'fla_fuel_type_desc'=>$vehicledetails[0]->vehicle->fla_fuel_type_desc,
                                  'cubic_cap'=>$vehicledetails[0]->vehicle->cubic_cap,
                                  'fla_cubic_cap'=>$vehicledetails[0]->vehicle->fla_cubic_cap,
                                  'manu_yr'=>$vehicledetails[0]->vehicle->manu_yr,
                                  'seat_cap'=>$vehicledetails[0]->vehicle->seat_cap,
                                  'fla_seat_cap'=>$vehicledetails[0]->vehicle->fla_seat_cap,
                                  'hp_type'=>$vehicledetails[0]->hypth->hp_type,
                                  'fncr_name'=>$vehicledetails[0]->hypth->fncr_name,
                                  'fla_fncr_name'=>$vehicledetails[0]->hypth->fla_fncr_name,
                                  'from_dt'=>$vehicledetails[0]->hypth->from_dt,
                                  'comp_cd_desc'=>$vehicledetails[0]->insurance->comp_cd_desc,
                                  'fla_ins_name'=>$vehicledetails[0]->insurance->fla_ins_name,
                                  'ins_type_desc'=>$vehicledetails[0]->insurance->ins_type_desc,
                                  'ins_from'=>$vehicledetails[0]->insurance->ins_from,
                                  'ins_upto'=>$vehicledetails[0]->insurance->ins_upto,
                                );
                return json_encode(array('message'=>'success','data'=>$data,'modaldata'=>$modaldata,'datawithids'=>$datawithids));
            }
            else
            {
                return json_encode(array('message'=>'failure','data'=>''));
            }
        }
    }
    public function IBBpricing()
    {
        $registration_year  = Input::get('registration_year');
        $make               = Input::get('make');
        $model              = Input::get('model');
        $variant            = Input::get('variant');
        $kms_done           = Input::get('kms_done');
        $colors             = Input::get('colors');
        $owner_type         = Input::get('owner_type');
        $place              = Input::get('place');
        switch ($owner_type) {
            case 'FIRST':
                $owner_type=1;
                break;

            case 'SECOND':
                $owner_type=2;
                break;

            case 'THIRD':
                $owner_type=3;
                break;

            case 'Fourth':
                $owner_type=4;
                break;

            case 'Four +':
                $owner_type=5;
                break;
        }
        $getcityname     =  schemamodel::master_table_where('master_city',
                                                                    "master_id",
                                                                    $place
                                                                );

        if(count($getcityname)>0){            
        $city_name   = $getcityname[0]->city_name; }
        else
        {$city_name   = '';}
        $fetch_ibb_make     = ibb::fetch_ibb_make($make);
        $fetch_ibb_model    = ibb::fetch_ibb_model($model);
        $fetch_ibb_variant  = ibb::fetch_ibb_variant($variant);
        $getresultcolor     = schemamodel::master_table_color('master_colors',
                                                              'colour_id',
                                                              $colors
                                                            );

        if(count($getresultcolor)>0){            
        $colors_name   = $getresultcolor[0]->colour_name; }
        else
        {$colors_name   = '';}
     
        $ibbreturndata         = ibb::DoApiibbprice($registration_year,$fetch_ibb_make,$fetch_ibb_model,$fetch_ibb_variant,$city_name,$kms_done,$owner_type,$colors_name);
        $ibbjsondata           = json_decode($ibbreturndata);
        if($ibbjsondata->status==1)
        {
            $data[]             = array('Low'=>$ibbjsondata->ForPrivatePrice[0],'Medium'=>$ibbjsondata->ForPrivatePrice[1],'Good'=>$ibbjsondata->ForPrivatePrice[2]);
            $data[]             = array('Low'=>$ibbjsondata->ForRetailPrice[0],'Medium'=>$ibbjsondata->ForRetailPrice[1],'Good'=>$ibbjsondata->ForRetailPrice[2]);
            $data[]             = array('Low'=>$ibbjsondata->ForTradeinPrice[0],'Medium'=>$ibbjsondata->ForTradeinPrice[1],'Good'=>$ibbjsondata->ForTradeinPrice[2]);
            $data[]             = array('Low'=>$ibbjsondata->ForCPOPrice[0],'Medium'=>$ibbjsondata->ForCPOPrice[1],'Good'=>$ibbjsondata->ForCPOPrice[2]);
        }
        else
        {
            $navar   = 'NA';
            $data[]             = array('Low'=>$navar,'Medium'=>$navar,'Good'=>$navar);
            $data[]             = array('Low'=>$navar,'Medium'=>$navar,'Good'=>$navar);
            $data[]             = array('Low'=>$navar,'Medium'=>$navar,'Good'=>$navar);
            $data[]             = array('Low'=>$navar,'Medium'=>$navar,'Good'=>$navar);
        }
        $obvreturndata         = obv::DoApiobvprice($registration_year,$fetch_ibb_make,$fetch_ibb_model,$fetch_ibb_variant,$city_name,$kms_done,$owner_type,$colors_name);        
        $obbjsondata           = json_decode($obvreturndata);
        if($obbjsondata->code=='success')
        {
            $data[]             = array('range_from'=>$obbjsondata->data->all_conditions->Excellent->range_from,'range_to'=>$obbjsondata->data->all_conditions->Excellent->range_to);
            $data[]             = array('range_from'=>$obbjsondata->data->all_conditions->Good->range_from,'range_to'=>$obbjsondata->data->all_conditions->Good->range_to);
            $data[]             = array('range_from'=>$obbjsondata->data->all_conditions->Fair->range_from,'range_to'=>$obbjsondata->data->all_conditions->Fair->range_to);
        }
        else
        {
            $navar   = 'NA';
            $data[]             = array('range_from'=>$navar,'range_to'=>$navar);
            $data[]             = array('range_from'=>$navar,'range_to'=>$navar);
            $data[]             = array('range_from'=>$navar,'range_to'=>$navar);
        }

        return json_encode($data);
    }

    public function add_inventory_save(Request $request)
    {
        $inventory_type = Input::get('inventory_type');
        $rate = Input::get('rate');
        if($rate=='option1')
        {
            $markuptextbox = 'percentage';
            $markupmsg = 'Percentage';
        }
        else
        {
            $markuptextbox = 'markup_amount';
            $markupmsg = 'Amount';
        }
        if($inventory_type=='PARKANDSELL'){
            $messsages = array(
                'make.required'=>'Make',
                'model.required'=>'Model',
                'variant.required' => 'Variant',
                'category_id.required' => 'Body Type',
                'kms_done.required' => 'Kms Done',
                'mileage.required' => 'Mileage',
                'owner_type.required' => 'Owner Type',
                'colors.required' => 'Color',
                'place.required' => 'City',
                'fuel_type.required' => 'Fuel Type',
                'transmission.required' => 'Transmission',
                'received_from_own.required' => 'Received From',
                'received_from_name.required' => 'From Name',
                'purchase_date.required' => 'Purchased Date',
                'starting_kms.required' => 'Starting Kms',
                $markuptextbox.'.required' => $markupmsg,
                'price.required'=>'Price Exceeded',
            );
            
            $validator = Validator::make($request->all(), [
                'make' => 'required',
                'model' => 'required',
                'variant' => 'required',
                'category_id' => 'required',
                'kms_done' => 'required',
                'mileage' => 'required',
                'owner_type' => 'required',
                'colors' => 'required',
                'place' => 'required',
                'fuel_type' => 'required',
                'transmission' => 'required',
                'received_from_own'=>'required',
                'received_from_name'=>'required',
                'purchase_date'=>'required',
                'starting_kms'=>'required',
                $markuptextbox=>'required',
                'price'=>'required|max:15'
            ],$messsages);
        }
        else
        {
            $messsages = array(
                'make.required'=>'Make',
                'model.required'=>'Model',
                'variant.required' => 'Variant',
                'category_id.required' => 'Body Type',
                'kms_done.required' => 'Kms Done',
                'mileage.required' => 'Mileage',
                'owner_type.required' => 'Owner Type',
                'colors.required' => 'Color',
                'place.required' => 'City',
                'fuel_type.required' => 'Fuel Type',
                'transmission.required' => 'Transmission',
                'ownpurchased_from.required' => 'Purchased From',
                'ownreceived_from_name.required' => 'From Name',
                'ownpurchased_price.required' => 'Purchased Price',
                'ownpurchase_date.required' => 'Ownpurchase Date',
                'price.required'=>'Price Exceeded',
                $markuptextbox.'.required' => $markupmsg,
            );
            $validator = Validator::make($request->all(), [
                'make' => 'required',
                'model' => 'required',
                'variant' => 'required',
                'category_id' => 'required',
                'kms_done' => 'required',
                'mileage' => 'required',
                'owner_type' => 'required',
                'colors' => 'required',
                'place' => 'required',
                'fuel_type' => 'required',
                'transmission' => 'required',
                'ownpurchased_from'=>'required',
                'ownreceived_from_name'=>'required',
                'ownpurchased_price'=>'required',
                'ownpurchase_date'=>'required',
                $markuptextbox=>'required',
                'price'=>'required|max:11'
            ],$messsages);
        }
        
        $listing_id = Input::get('listing_id');

        if($listing_id=='')
        {
             if ($validator->fails()) {
                return redirect('add_listing_tab')
                            ->withErrors($validator)
                            ->withInput();
            }
        }
        else{
            if ($validator->fails()) {
                return redirect('add_listing_tab/'.$listing_id)
                            ->withErrors($validator)
                            ->withInput();
            }
        } 

        $id = Session::get('ses_id');
        $dealer_schemaname = Session::get('dealer_schema_name');
        
        $registration_year = Input::get('registration_year');
        
        $make = Input::get('make');
        $model = Input::get('model');
        $variant = Input::get('variant');
        $category_id = Input::get('category_id');
        $kms_done = Input::get('kms_done');
        $mileage = Input::get('mileage');
        $owner_type = Input::get('owner_type');
        $status = Input::get('status');
        $colors = Input::get('colors');
        $place = Input::get('place');
        $fuel_type = Input::get('fuel_type');
        $transmission = Input::get('transmission');
        $branch = Input::get('branch');

        $inventory_type = Input::get('inventory_type');
        $onoffswitch = Input::get('onoffswitch');
        if(Input::has('onoffswitch'))
        {
            $test_drive=1;
        }
        else
        {
            $test_drive=0;
        }

        if(Input::has('test_drive_dealer'))
        {
            $test_drive_dealer=1;
        }
        else
        {
            $test_drive_dealer=0;
        }
        //$test_drive_door = Input::get('test_drive_door');
        if(Input::has('test_drive_door'))
        {
            $test_drive_door=1;
        }
        else
        {
            $test_drive_door=0;
        }
        $ownpurchased_from = Input::get('ownpurchased_from');
        $ownreceived_from_name = Input::get('ownreceived_from_name');
        $ownpurchased_price = Input::get('ownpurchased_price');
        $ownpurchase_date = Input::get('ownpurchase_date');
        $ownkey_received = Input::get('ownkey_received');
        
        $owndocuments_received = Input::get('owndocuments_received');
        

        $received_from_own = Input::get('received_from_own');
        $received_from_name = Input::get('received_from_name');
        $purchase_date = Input::get('purchase_date');
        $starting_kms = Input::get('starting_kms');
        $fuel_indicator = Input::get('fuel_indicator');
        $fuel_capacity = Input::get('fuel_capacity');
        $customer_asking_price = Input::get('customer_asking_price');
        $dealer_markup_price = Input::get('dealer_markup_price');
        $keys_available = Input::get('keys_available');
        
        $documents_received = Input::get('documents_received');
        
        
        $percentage = Input::get('percentage');
        $markup_amount = Input::get('markup_amount');
        $price = Input::get('price');

        $basic_info = array(
                            'dealer_id'         =>$id,   
                            'branch_id'         =>'', 
                            'model_id'          =>Input::get('model'),     
                            'category_id'       =>Input::get('category_id'),
                            'registration_year' =>Input::get('registration_year'),       
                            'make'              =>Input::get('make'), 
                            'registration_number'=>Input::get('registration_number'),
                            'chassis_number'=>Input::get('chassis_number'),
                            'engine_number'=>Input::get('engine_number'),
                            'variant'           =>Input::get('variant'), 
                            'kms_done'          =>Input::get('kms_done'), 
                            'mileage'           =>Input::get('mileage'), 
                            'owner_type'        =>Input::get('owner_type'), 
                            'branch_id'         =>Input::get('branch'),
                            'transmission'      =>Input::get('transmission'),
                            'colors'            =>Input::get('colors'), 
                            'car_city'          =>Input::get('place'), 
                            'fuel_type'         =>Input::get('fuel_type'),
                            'status'            =>Input::get('status'),
                            'inventory_type'    =>Input::get('inventory_type'),
                            'price'             =>Input::get('price'),
                            'updated_at'        =>Carbon::now()->format('Y-m-d H:i:s'),
                            );
        if($listing_id=='')
        {
            $listing_id = inventorymodel::dealerInsertTable($dealer_schemaname,'dms_car_listings',$basic_info);        

            $dealer_cars_pricing = array(
                                        'listing_id'=>$listing_id,
                                        'ownpurchase_date'=>$ownpurchase_date,
                                        'ownpurchased_from'=>$ownpurchased_from,
                                        'ownreceived_from_name'=>$ownreceived_from_name,
                                        'ownpurchased_price'=>$ownpurchased_price,
                                        'ownkey_received'=>$ownkey_received,
                                        'owndocuments_received'=>$owndocuments_received,
                                        'inventory_type'=>$inventory_type,
                                        'test_drive'=>$test_drive,
                                        'testdrive_dealerpoint'=>$test_drive_dealer,
                                        'testdrive_doorstep'=>$test_drive_door,
                                        'markup_condition'=>$rate,
                                        'markup_percentage'=>$percentage,
                                        'markup_value'=>$markup_amount,
                                        'saleprice'=>$price,
                                        'user_id'=>$id,
                                        'purchase_date'=>$purchase_date,
                                        'received_from_own'=>$received_from_own,
                                        'received_from_name'=>$received_from_name,
                                        'starting_kms'=>$starting_kms,
                                        'fuel_indication'=>$fuel_indicator,
                                        'customer_asking_price'=>$customer_asking_price,
                                        'dealer_markup_price'=>$dealer_markup_price,
                                        'createddatetime'=>Carbon::today()->toDateString()
                                        );

            inventorymodel::dealerInsertTable($dealer_schemaname,'dealer_cars_pricing',$dealer_cars_pricing);

        }
        else
        {
            $wheredata = array('car_id'=>$listing_id);
            inventorymodel::dealerUpdateTableDetails($id,$dealer_schemaname,'dms_car_listings',$wheredata,$basic_info);        

            $dealer_cars_pricing = array(
                                        'listing_id'=>$listing_id,
                                        'ownpurchase_date'=>$ownpurchase_date,
                                        'ownpurchased_from'=>$ownpurchased_from,
                                        'ownreceived_from_name'=>$ownreceived_from_name,
                                        'ownpurchased_price'=>$ownpurchased_price,
                                        'ownkey_received'=>$ownkey_received,
                                        'owndocuments_received'=>$owndocuments_received,
                                        'inventory_type'=>$inventory_type,
                                        'test_drive'=>$test_drive,
                                        'testdrive_dealerpoint'=>$test_drive_dealer,
                                        'testdrive_doorstep'=>$test_drive_door,
                                        'markup_condition'=>$rate,
                                        'markup_percentage'=>$percentage,
                                        'markup_value'=>$markup_amount,
                                        'saleprice'=>$price,
                                        'user_id'=>$id,
                                        'purchase_date'=>$purchase_date,
                                        'received_from_own'=>$received_from_own,
                                        'received_from_name'=>$received_from_name,
                                        'starting_kms'=>$starting_kms,
                                        'fuel_indication'=>$fuel_indicator,
                                        'customer_asking_price'=>$customer_asking_price,
                                        'dealer_markup_price'=>$dealer_markup_price,
                                        'keys_available'=>$keys_available,
                                        'documents_received'=>$documents_received
                                        );

            inventorymodel::dealerUpdateTableDetails($id,$dealer_schemaname,'dealer_cars_pricing',array('listing_id'=>$listing_id),$dealer_cars_pricing);  
            
            inventorymodel::dealerDeleteTableDetails($dealer_schemaname,'dealer_car_expenses',$wheredata);
        }

        $condition          = array('listing_id'=>$listing_id);
        $hypothcheck        = inventorymodel::dealerTableCount($dealer_schemaname,'dealer_hypothacation_details',$condition);
        $insurancecheck     = inventorymodel::dealerTableCount($dealer_schemaname,'dealer_insurance_details',$condition);        

        $hypothacation_type = Input::get('hypothacation_type');
        $finacier_name      = Input::get('finacier_name');
        $fla_finacier_name  = Input::get('fla_finacier_name');
        $from_date          = Input::get('from_date');
        if($from_date!='')
        {
            $from_date = date("Y-m-d", strtotime($from_date));
        }
        $hyporecord         = array('listing_id'=>$listing_id,
                                    'hypothacation_type'=>$hypothacation_type,
                                    'finacier_name'=>$finacier_name,
                                    'fla_finacier_name'=>$fla_finacier_name,
                                    'from_date'=>$from_date);
        if($hypothcheck<=0)
        {
            inventorymodel::dealerInsertTable($dealer_schemaname,'dealer_hypothacation_details',$hyporecord);
        }
        else
        {
            inventorymodel::dealerUpdateTableDetails($id,$dealer_schemaname,'dealer_hypothacation_details',$condition,$hyporecord);
        }
        
        
        $comp_cd_desc       = Input::get('comp_cd_desc');
        $fla_insurance_name = Input::get('fla_insurance_name');
        $insurance_type_desc= Input::get('insurance_type_desc');
        $insurance_from     = Input::get('insurance_from');
        $insurance_upto     = Input::get('insurance_upto');
        if($insurance_from!='')
        {
            $insurance_from = date("Y-m-d", strtotime($insurance_from));
        }

        if($insurance_upto!='')
        {
            $insurance_upto = date("Y-m-d", strtotime($insurance_upto));
        }
        $insurancerecord    = array('listing_id'=>$listing_id,
                                    'comp_cd_desc'=>$comp_cd_desc,
                                    'fla_insurance_name'=>$fla_insurance_name,
                                    'insurance_type_desc'=>$insurance_type_desc,
                                    'insurance_from'=>$insurance_from,
                                    'insurance_upto'=>$insurance_upto,
                                    );
        if($insurancecheck<=0)
        {
            inventorymodel::dealerInsertTable($dealer_schemaname,'dealer_insurance_details',$insurancerecord);
        }
        else
        {
            inventorymodel::dealerUpdateTableDetails($id,$dealer_schemaname,'dealer_insurance_details',$condition,$insurancerecord);
        }

        $InsertExpenseData = array(
                                    'car_id'        =>$listing_id, 
                                    'car_primary_id'=>'',
                                    'expense_desc'  =>'Transport Cost',
                                    'expense_amount'=>Input::get('expense_amount')
                                    );
        $InsertExpense      = inventorymodel::dealerInsertTable(
                                        $dealer_schemaname,'dealer_car_expenses',$InsertExpenseData
                                        );
        $InsertExpenseData = array(
                        'car_id'        =>$listing_id, 
                        'car_primary_id'=>'',
                        'expense_desc'  =>'Refurbishment Cost',
                        'expense_amount'=>Input::get('expense_desc')
                        );
        $InsertExpense      = inventorymodel::dealerInsertTable(
                                        $dealer_schemaname,'dealer_car_expenses',$InsertExpenseData
                                        );
        if(Input::has('extra')){
            foreach(Input::get('extra') as $key=>$value){
                if(trim($value)!='')
                {
                    $InsertExpenseData = array(
                                        'car_id'        =>$listing_id, 
                                        'car_primary_id'=>'',
                                        'expense_desc'  =>$value,
                                        'expense_amount'=>Input::get('extrarupee')[$key]
                                        );
                    $InsertExpense      = inventorymodel::dealerInsertTable(
                                                $dealer_schemaname,'dealer_car_expenses',$InsertExpenseData
                                                );
                }
            }
        }
        
        return redirect('add_inventory_tabs/'.$listing_id);
    }

    public function add_inventory_tabs($inventoryid)
    {
        $header_data = $this->header_data;
        $compact_array              = array
                                        (
                                            'active_menu_name'  =>$this->active_menu_name,                   

                                            'side_bar_active'   =>$this->side_bar_active,

                                            
                                        );
        $list_images = array();
        $dealer_phoneno         = dealermodel::dealerprofile(session::get('ses_id'));             
        $dealer_schemaname = $this->dealer_schemaname;
        $dealerplan      = inventorymodel::dealerplan();
        $dealerplans     = $dealerplan->plan_type_id;
        $portal = Input::get('portal');
        $wherecondition = array('car_id'=>$inventoryid);

        $basic_info = inventorymodel::dealerFetchTableDetails($dealer_schemaname,'dms_car_listings',$wherecondition);

        $model_id   = $basic_info[0]->model_id;
        $variant    = $basic_info[0]->variant;
        $price      = $basic_info[0]->price;
        $colors      = $basic_info[0]->colors;
        $registration_year = $basic_info[0]->registration_year;
        $car_city    = $basic_info[0]->car_city;
        $mongopush_status    = $basic_info[0]->mongopush_status;
        $car_master_status  = $basic_info[0]->car_master_status;
        if($portal=='mongo')
            $listing_status=1;
        else
            $listing_status=0;


        $fetchcolor = inventorymodel::master_table_color('master_colors','colour_id',$colors);
        if(count($fetchcolor) >= 1){
            $colour_name = $fetchcolor[0]->colour_name;
        }
        else{
            $colour_name = 'No Name';   
        }

        $fetchmodel = inventorymodel::master_table_makeid_model_varient('master_models','model_id',$model_id);     
        if(count($fetchmodel) >= 1){
            $modelname = $fetchmodel[0]->model_name;
        }
        else{
            $modelname = 'Empty Name';
        }
        $fetchvariant = inventorymodel::master_table_makeid_model_varient('master_variants','variant_id',$variant);
        if(count($fetchvariant) >= 1){
            $variant_name = $fetchvariant[0]->variant_name;
        }
        else{
            $variant_name = 'Empty Name';
        }

        $fetchcity = inventorymodel::master_table_where('master_city','city_id',$car_city);
        $dealer_deatails        = dealermodel::dealerprofile(session::get('ses_id'));
        if($dealerplans != 1)
        {
            $water_mark             = $dealer_deatails->company_logo;
            
        }
        else
        {
            $water_mark = url(Config::get('common.watermark'));   
        }

        if(empty($water_mark))
        {
            $water_mark = url(Config::get('common.watermark'));
        }

        $listing_headerdata = array(
                                    'modelname'=>$modelname,
                                    'variant_name'=>$variant_name,
                                    'colour_name'=>$colour_name,
                                    'registration_year'=>$registration_year,
                                    'price'=>$price,
                                    'car_city'=>$fetchcity[0]->city_name,
                                    'mongopush_status'=>$mongopush_status,
                                    'variant_id'=>$variant,
                                    'listing_status'=>$listing_status
                                    );
    
        $list_images        = $this->SchemaObject->schema_where(
                                                            $this->DmsCarListPhotosTable,
                                                            'car_id',
                                                            $inventoryid
                                                            );
        $document_images        = $this->SchemaObject->schema_where(
                                                            $this->DmsCarListDocumentTable,
                                                            'car_id',
                                                            $inventoryid
                                                            );
        
        $dealer_listing_features = $this->SchemaObject->schema_where(
                                                        'dealer_listing_features',
                                                        'listing_id',
                                                        $inventoryid
                                                        );

        $dealer_certification = $this->SchemaObject->schema_where(
                                                        'dms_listing_certification_warranty_inspection',
                                                        'listing_id',
                                                        $inventoryid
                                                        );
        
        $dealer_hypothacation = $this->SchemaObject->schema_where(
                                                        'dealer_hypothacation_details',
                                                        'listing_id',
                                                        $inventoryid
                                                        );

        $dealer_insurance = $this->SchemaObject->schema_where(
                                                        'dealer_insurance_details',
                                                        'listing_id',
                                                        $inventoryid
                                                        );
        if(count($dealer_hypothacation)>0)
        {
            $dealer_hypothacation[0]->from_date=commonmodel::checkdatecontent($dealer_hypothacation[0]->from_date);
        }

        if(count($dealer_insurance)>0)
        {
            $dealer_insurance[0]->insurance_from=commonmodel::checkdatecontent($dealer_insurance[0]->insurance_from);
        }
        
        $dp_listid  = $inventoryid;
        $date          = Carbon::now()->format("Y-m-d");                
        $header_data['title']='Add Inventory';   
        return view('add_inventory',compact('header_data','compact_array','list_images','dp_listid','dealer_certification','dealer_listing_features','document_images','listing_headerdata','water_mark','dealer_phoneno','dealer_hypothacation','dealer_insurance','dealerplans','date'));   
    }
        

    /*
    *The Function name Queried Cars 
    *Message Sent to dealer of car
    */
    public function doQueriesReceived()
    {
        $id                         = session::get('ses_id');  
        $dms_dealers_tablename      = 'dms_dealers';
        $fetch_master_dealer_schema = buyymodel::masterFetchTableDetails($id,$dms_dealers_tablename,array('d_id'=>$id));
        $dealer_schemaname          = $fetch_master_dealer_schema[0]->dealer_schema_name;
        $dealer_name                = $fetch_master_dealer_schema[0]->dealer_name;        
        $fetch_queried_details      = inventorymodel::dealerSellQueriesDetail($id,$dealer_schemaname);
        $paginatelink               = $fetch_queried_details->links();              
        //print_r($fetch_queried_details);
        $queriesdata                = array();
        $listing_orwherecondition   = array();
        $listing_wherecondition     = array();
        foreach ($fetch_queried_details as $key){
          $car_id                               = (string) $key->car_id;
          $dealer_id                            = $key->from_dealer_id;
          $listing_wherecondition['listing_id'] = array($car_id);
          $mongo_carlisting_details             = buyymodel::mongoListingFetchwithqueries($id,$listing_wherecondition,$listing_orwherecondition);
        
          foreach ($mongo_carlisting_details as $userkey => $uservalue) {
            $data['noimages']               = count($uservalue["photos"]);
            $photos_array                   = array();

            if(count($uservalue["photos"])>0)
            {
                foreach ($uservalue["photos"] as $photokey => $photovalue) {
                   $photos_array[]     =$photovalue['s3_bucket_path'];
                }
                $data['imagelink']  = $photos_array[0];
            }
            else
            {
                $carnoimage         = Config::get('common.carnoimage');
                $data['imagelink']  =$carnoimage;
            }
            
            $data['listing_type']           = $uservalue['listing_type'];
            $data['price']                  = $uservalue["sell_price"];
            $dms_dealers_tablename          = 'dms_dealers';       
            $to_get_dealer_id               = $key->to_dealer_id;
            if($key->to_dealer_id==$id)
            {
                $to_get_dealer_id=$dealer_id;
            }
            $fetch_master_todealer_schema   = buyymodel::masterFetchTableDetails($id,$dms_dealers_tablename,array('d_id'=>$to_get_dealer_id));
            
            if(count($fetch_master_todealer_schema)<=0)
            {
              $to_dealer_name = '';
            }
            else
            {
              $to_dealer_name = $fetch_master_todealer_schema[0]->dealer_name;
            }
            $codewherecondition             = array('contact_transactioncode'=>$key->contact_transactioncode);
            $latest_message                 = inventorymodel::dealerQueriesWithCode($dealer_schemaname,$codewherecondition);
            $data['car_id']                 = $key->car_id;
            $data['status']                 = $latest_message->status;
            $data['from_dealer_id']         = $dealer_name;
            $data['to_dealer_name']         = $to_dealer_name;
            $data['to_dealer_id']           = $to_get_dealer_id;
            $data['make']                   = $uservalue['make'].' '.$uservalue['model'].' '.$uservalue['variant'].' '.$uservalue['registration_year'];
            $data['title']                  = $key->title;
            $data['dealer_name']            = $key->dealer_name;
            $data['dealer_email']           = $key->dealer_email;
            $data['message']                = $latest_message->message;
            $data['contact_transactioncode']= $key->contact_transactioncode;            
            array_push($queriesdata, $data);    
          }
        }

        $compact_array              = array('active_menu_name'=>$this->active_menu_name,
                                            'side_bar_active'=>4,
                                            'queriesdata'=>$queriesdata,
                                            );  
        $header_data                = $this->header_data;
        $header_data['title']       = 'Queries Received';
        return view('queries_received',compact('compact_array','header_data','paginatelink'));
    }

    /*
    * Function Name message_grid_view
    * 
    */
    public function doReceiveQueries()
    {

        //$car_id                           = Input::get('reply_carid');
        //$to_dealer_id                     = Input::get('to_dealer_id');
        if(Input::has('i')){
            $contact_transactioncode          = Input::get('i');    
        }        
        else{
            $contact_transactioncode          = Input::get('contact_transactioncode');    
        }
        $id                               = session::get('ses_id');
        $dealer_schemaname                = $this->dealer_schemaname;        
        
        $tablename                        = 'dealer_contact_message_transactions';
        $wherecondition                   = array('contact_transactioncode'=>$contact_transactioncode);
        $contact_message_grid             = buyymodel::dealerFetchTableDetails($id,$dealer_schemaname,$tablename,$wherecondition);

        $dealer_id                      = $contact_message_grid[0]->from_dealer_id;
        $to_dealer_id                   = $contact_message_grid[0]->to_dealer_id;
        $car_id                         = $contact_message_grid[0]->car_id;
        if($contact_message_grid[0]->to_dealer_id==$id)
        {
            $to_dealer_id=$dealer_id;
        }
        
        $dealer_wherecondition            = array('d_id'=>$to_dealer_id);
        $dms_dealers_tablename            = 'dms_dealers';
        $conversationname_details         = buyymodel::masterFetchTableDetails($id,$dms_dealers_tablename,$dealer_wherecondition);

        $setcondition                     = array('status'=>0);
        buymodel::dealerUpdateTableDetails($id,$dealer_schemaname,$tablename,$wherecondition,$setcondition);

        $data                             = array();
        $messagedetails                   = array();
        $infodetails                      = array();
        $data['contact_message_grid_html']= '';
        $listing_id                       = (string) $car_id;
        $whereconditionon['listing_id']   = array($listing_id);
        $listing_orwherecondition         = array();
        $update                           = buymodel::mongoListingFetchwithqueries($id,$whereconditionon,$listing_orwherecondition);
        if(!empty($update))
        {
          foreach ($update as $key) {
            $make             = $key['make'];
            $sell_price       = $key['sell_price'];
            $variant          = $key['variant'];
            $model            = $key['model'];
            $car_locality     = $key['car_locality'];
            $created_date     = $key['created_at'];
            $data['noimages'] = count($key["photos"]);
            $photos_array     = array();
            $listing_status  = $key['listing_status'];            
            $expiry_date               = commonmodel::daysBetweenExpirydate($key["listing_expiry_date"]);
            $listing_error_msg = commonmodel::listing_status_msg($listing_status,$expiry_date);
            if(count($key["photos"])>0)
            {
              foreach ($key["photos"] as $photokey => $photovalue) {
                  $photos_array[] = $photovalue['s3_bucket_path'];
              }
              $imagelinks = $photos_array[0];
            }
            else
            {
              $carnoimage         = Config::get('common.carnoimage');
              $imagelinks         = $carnoimage;
            }
            
            $days         = commonmodel::daysBetweenCurrentDate($created_date);
            if($days<=0)
            {
                $daysstmt = 'Listed Today';
            }
            else{
                $daysstmt = 'Listed '.$days.' day ago';
            }
          }
        }
        else
        {
          $make         ='';
          $sell_price   ='';
          $variant      ='';
          $model        ='';
          $car_locality ='';
          $daysstmt     ='';
          $imagelinks   ='';
          $listing_error_msg='';
          $listing_status='';
        }
        $infodetails['make']            = $make;
        $infodetails['sell_price']      = $sell_price;
        $infodetails['variant']         = $variant;
        $infodetails['model']           = $model;
        $infodetails['car_locality']    = $car_locality;
        $infodetails['daysstmt']        = $daysstmt;
        $infodetails['imagelinks']      = $imagelinks;
        $infodetails['to_dealer_id']    = $to_dealer_id;
        $infodetails['car_id']          = $car_id;
        $infodetails['listing_error_msg'] = $listing_error_msg;
        $infodetails['listing_status'] = $listing_status;
        $infodetails['contact_transactioncode']= $contact_transactioncode;
        
        if(count($conversationname_details)>0)
        {
          $infodetails['headerdealername']       = $conversationname_details[0]->dealer_name;
        }
        else
        {
          $infodetails['headerdealername']       = 'The User is Not Available in System'; 
        }
        if(!empty($contact_message_grid))
        {
            foreach ($contact_message_grid as $messagekey) {
                $style_align                        = 'left'; 
                if($messagekey->user_id==$id)
                {
                    $style_align  ='right'; 
                }
                 $data['style_align']               = $style_align;
                 $data['contact_message_grid_html'] = $messagekey->message;
                 $data['delear_datetime']           = $messagekey->delear_datetime;
                 $data['downloadlink']              = '0';   
                 $dms_dealers_tablename             = 'dms_dealers';
                 $dealer_wherecondition             = array('d_id'=>$messagekey->user_id);
                 $to_get_dealer_details             = buymodel::masterFetchTableDetails($id,$dms_dealers_tablename,$dealer_wherecondition);

                 if(count($to_get_dealer_details)>0)
                 {
                    $dealer_profile_image           = $to_get_dealer_details[0]->logo;
                 }
                 else
                 {
                    $dealer_profile_image           = url('img/noimage.jpeg');
                 }
                 $data['dealer_profile_image']      = $dealer_profile_image;
                 $tablename_document                = 'contact_documents_table';
                 $wherecondition_document           = array('id'=>$messagekey->thread_id);
                 $contact_document_grid             = buymodel::dealerFetchTableDetails($id,$dealer_schemaname,$tablename_document,$wherecondition_document);
                 array_push($messagedetails, $data);
                 if(!empty($contact_document_grid))
                {
                    foreach ($contact_document_grid as $documentkey) { 
                       $data['style_align']               = $style_align;
                       $data['downloadlink']              = 1;   
                       $data['delear_datetime']           = $messagekey->delear_datetime;
                        $data['contact_message_grid_html']= $documentkey->file_url;
                      array_push($messagedetails, $data);
                    }
                }
            }
        }
        $compact_array              = array('active_menu_name'=>$this->active_menu_name,
                                            'side_bar_active'=>4,
                                            'car_info'=>$infodetails,
                                            'messagedetails'=>$messagedetails,
                                           );  
        $header_data                = $this->header_data;
        $header_data['title']       = 'Sent Queries';
        $notification_type = config::get('common.sent_queries_notification_type_id');
        $updateNotifyHeader = notificationsmodel::updateDealerNotification($id,$dealer_schemaname,$contact_transactioncode);
        return view('sentqueries',compact('compact_array','header_data','notification_type'));
    }
    public function dosoldview()
    {
        $id = Session::get('ses_id');
        $dealer_schemaname = $this->dealer_schemaname;
        $currentdate              = Carbon::now()->format('Y-m-d');
        $header_data                = $this->header_data;

        $inventory_id=Input::get('sold_id');
        
        $param = array('car_id','duplicate_id','inventory_type','car_master_status','model_id','variant','mileage','registration_year','price','kms_done','fuel_type','car_master_status','chassis_number','registration_number');
        
        $inventorydata = inventorymodel::inventoryTableDetails($dealer_schemaname,'dms_car_listings',array('car_id'=>$inventory_id),$param,'price','asc');

        $inventory_type = $inventorydata[0]->inventory_type;
        $vinno = $inventorydata[0]->chassis_number;
        $registration_number=$inventorydata[0]->registration_number;
        $fetchmodel = inventorymodel::master_table_makeid_model_varient('master_models','model_id',$inventorydata[0]->model_id);   

        $registration_year = $inventorydata[0]->registration_year;  
        if(count($fetchmodel) >= 1){
            $modelname = $fetchmodel[0]->model_name;
        }
        else{
            $modelname = 'Empty Name';
        }
        
        $fetchvariant = inventorymodel::master_table_makeid_model_varient('master_variants','variant_id',$inventorydata[0]->variant);
        if(count($fetchvariant) >= 1){
            $variant_name = $fetchvariant[0]->variant_name;
        }
        else{
            $variant_name = 'Empty Name';
        }
        $expense_info = inventorymodel::dealerFetchTableDetails($dealer_schemaname,'dealer_car_expenses',array('car_id'=>$inventory_id));

        $pricing_info = inventorymodel::dealerFetchTableDetails($dealer_schemaname,'dealer_cars_pricing',array('listing_id'=>$inventory_id));

        if($inventory_type=='PARKANDSELL')
        {
            $purchased_price=$pricing_info[0]->customer_asking_price;
        }
        else
        {
            $purchased_price=$pricing_info[0]->ownpurchased_price;
        }
        
        
        $salesdetails = inventorymodel::dealerFetchTableDetails($dealer_schemaname,'dealer_sales',array('inventory_id'=>$inventory_id));
        $salesdocuments = array();
        if(count($salesdetails)>0)
        {
            $salesdocumentsdetails = inventorymodel::dealerFetchTableDetails($dealer_schemaname,'dealer_sales_documents',array('inventory_id'=>$inventory_id));
            $salesdetails = array(
                                'vinno'=>$salesdetails[0]->vinno,
                                'inventory_id'=>$salesdetails[0]->inventory_id,
                                'registrationno'=>$salesdetails[0]->registrationno,
                                'purchaseprice'=>$salesdetails[0]->purchaseprice,
                                'saleprice'=>$salesdetails[0]->saleprice,
                                'saledate'=>$salesdetails[0]->saledate,
                                'salesperson'=>$salesdetails[0]->salesperson,
                                'purchaser'=>$salesdetails[0]->purchaser,
                                );
            
            foreach ($salesdocumentsdetails as $key => $value) {
                $salesdocuments[$value->document_no] = array('document_no'=>$value->document_no,
                                        'document_name'=>$value->document_name,
                                        'filepath'=>$value->file_path
                                        );
            }
        }
        else
        {
            $salesdetails = array(
                                'vinno'=>$vinno,
                                'inventory_id'=>$inventory_id,
                                'registrationno'=>$registration_number,
                                'purchaseprice'=>$purchased_price,
                                'saleprice'=>$inventorydata[0]->price,
                                'saledate'=>$currentdate,
                                'salesperson'=>'',
                                'purchaser'=>'',

                                );
        }
        $salesdetails['dealer_markup_price']=$pricing_info[0]->dealer_markup_price;
        $compact_array              = array('active_menu_name'=>$this->active_menu_name,
                                            'side_bar_active'=>1,
                                            'salesdetails'=>$salesdetails,
                                            'salesdocuments'=>$salesdocuments,
                                            'expense_info'=>$expense_info,
                                            'modelname'=>$modelname,
                                            'variant_name'=>$variant_name,
                                            'registration_year'=>$registration_year,
                                            'inventory_id'=>$inventory_id
                                           ); 

       
        $header_data['title']       = 'Sold View';
        return view('sold',compact('compact_array','header_data'));
    }

    public function dosaleinventory()
    {
        $id = Session::get('ses_id');
        $dealer_schemaname = $this->dealer_schemaname;
        $currentdate              = Carbon::now()->format('Y-m-d');
        $inventory_id =Input::get('inventory_id');
        $soldcheck = inventorymodel::dealerTableCount($dealer_schemaname,'dealer_sales',array('inventory_id'=>$inventory_id));


        $vinno = Input::get('vinno');
        $registrationno = Input::get('registrationno');
        $purchaseprice = Input::get('purchaseprice');
        $saleprice = Input::get('saleprice');
        $saledate = Input::get('saledate');
        $salesperson = Input::get('salesperson');
        $purchaser = Input::get('purchaser');
        $document = Input::get('document');

        //dd();
        if(!empty(Input::file('documentupload')[0]))
        {
            if(empty(Input::get('document')[0]))
            {
                return redirect('managelisting')->with('message-err','Document 1 Name is Needed');
            }
        }
        if(!empty(Input::file('documentupload')[1]))
        {
            if(empty(Input::get('document')[1]))
            {
                return redirect('managelisting')->with('message-err','Document 2 Name  is Needed');
            }
        }
        if(!empty(Input::file('documentupload')[2]))
        {
            if(empty(Input::get('document')[2]))
            {
                return redirect('managelisting')->with('message-err','Document 3 Name  is Needed');
            }
        }
        if(!empty(Input::file('documentupload')[3]))
        {
            if(empty(Input::get('document')[3]))
            {
                return redirect('managelisting')->with('message-err','Document 4 Name  is Needed');
            }
        }
        if(!empty(Input::file('documentupload')[4]))
        {
            if(empty(Input::get('document')[4]))
            {
                return redirect('managelisting')->with('message-err','Document 5 Name  is Needed');
            }
        }

        $insertdata = array('inventory_id'=>$inventory_id,
                            'vinno'=>$vinno,
                            'registrationno'=>$registrationno,
                            'purchaseprice'=>$purchaseprice,
                            'saleprice'=>$saleprice,
                            'saledate'=>$saledate,
                            'salesperson'=>$salesperson,
                            'purchaser'=>$purchaser,
                            'user_id'=>$id,
                            'status'=>1,
                            );
        if($soldcheck<=0)
        {
            $insertdata['createddate']=$currentdate;
            $listing_id = inventorymodel::dealerInsertTable($dealer_schemaname,'dealer_sales',$insertdata);
        }
        else
        {
            $listing_id = inventorymodel::dealerUpdateTableDetails($id,$dealer_schemaname,'dealer_sales',array('inventory_id'=>$inventory_id),$insertdata);   
        }
        foreach ($document as $key => $value) {
            if(!empty($value)&&!empty(Input::file('documentupload')[$key])){
                $post_value = Input::file('documentupload')[$key];

                $WhereDcoument        = array('inventory_id' => $inventory_id,'document_no'=>$key);

                $listing_documents    = buymodel::dealerFetchTableDetails($id,$dealer_schemaname,
                                                            'dealer_sales_documents',
                                                            $WhereDcoument
                                                           );
                
                if(count($listing_documents)<=0){
                $extension            = $post_value->getClientOriginalExtension();
                $destinationPath      = "uploadimages/".$dealer_schemaname."/documents";

                $image_upload_result  = fileuploadmodel::any_upload($post_value,$destinationPath,$extension);
                $fileContents = url("uploadimages/".$dealer_schemaname."/documents").'/'.$image_upload_result;
                Storage::put("/uploadimages/".$dealer_schemaname."/saledocument/".$image_upload_result, file_get_contents($fileContents),'public');
                $s3_bucket_path =Config::get('common.s3bucketpath').$dealer_schemaname."/saledocument/".$image_upload_result;
                unlink(public_path()."/uploadimages/".$dealer_schemaname."/documents/".$image_upload_result);
                $insertdata = array('inventory_id'=>$inventory_id,
                            'sales_id'=>$listing_id,
                            'document_no'=>$key,
                            'document_name'=>$value,
                            'filename'=>$image_upload_result,
                            'file_path'=>$s3_bucket_path,
                            'user_id'=>$id,
                            'status'=>1,
                            );

                $insertdata['createddate']=$currentdate;
                inventorymodel::dealerInsertTable($dealer_schemaname,'dealer_sales_documents',$insertdata);
                }
                else{
                    Storage::delete("/uploadimages/".$dealer_schemaname."/saledocument/".$listing_documents[0]->filename);
                    sleep(2);
                    $extension            = $post_value->getClientOriginalExtension();
                    $destinationPath      = "uploadimages/".$dealer_schemaname."/documents";
                    $image_upload_result  = fileuploadmodel::any_upload($post_value,$destinationPath,$extension);
                    $fileContents = url("uploadimages/".$dealer_schemaname."/documents/").'/'.$image_upload_result;
                    Storage::put("/uploadimages/".$dealer_schemaname."/saledocument/".$image_upload_result, file_get_contents($fileContents),'public');
                    $s3_bucket_path =Config::get('common.s3bucketpath').$dealer_schemaname."/saledocument/".$image_upload_result;
                    unlink(public_path()."/uploadimages/".$dealer_schemaname."/documents/".$image_upload_result);
                    $insertdata = array('inventory_id'=>$inventory_id,
                                'sales_id'=>$listing_id,
                                'document_no'=>$key,
                                'document_name'=>$value,
                                'filename'=>$image_upload_result,
                                'file_path'=>$s3_bucket_path,
                                'user_id'=>$id,
                                'status'=>1,
                                );

                    $listing_id = inventorymodel::dealerUpdateTableDetails($id,$dealer_schemaname,'dealer_sales_documents',$WhereDcoument,$insertdata);   
                }   

            }

        }
        $UpdateArray        = array("car_master_status" => 3);
        $WhereDmsListing    = array('car_id'=>$inventory_id);
        
        $listing_details = inventorymodel::dealerFetchTableDetails($dealer_schemaname,$this->DmsCarListTable,array('car_id'=>$inventory_id));
        $listing_id = $listing_details[0]->duplicate_id;
        $setdata = array('listing_status'=>'Sold');
        mongomodel::where('listing_id',$listing_id)->update($setdata);

        $update_data        = inventorymodel::dealerUpdateTableDetails(                                            $id,
                                                    $dealer_schemaname,
                                                    $this->DmsCarListTable,
                                                    $WhereDmsListing,
                                                    $UpdateArray
                                                    );
        return redirect('managelisting');
    }
    
  /*
  Module Name : listStickerShow
  Created By  : A.Ahila
  Use of this module is to show inventory window sticker

 */
    public function listStickerShow($listid)
    {
        
        $basic_info         = $this->listing_basic_info($listid);
       
        $dealer_info        = dealermodel::dealerfetch($basic_info['dealer_id']);

        $basic_info['dealername']  = $dealer_info[0]->dealer_name;
        $basic_info['mobile']  = $dealer_info[0]->d_mobile;
        $basic_info['email']  = $dealer_info[0]->d_email;
        $basic_info['logo']  = $dealer_info[0]->watermark_logo;
        $basic_info['listid'] = $listid;
        $feature_info       = $this->listing_features($listid,$basic_info['variant_id']);
        return view('sell_listing_sticker',compact('basic_info','feature_info'));
    }

     /*
          Module Name : listStickerShowPdf
          Created By  : A.Ahila
          Use of this module is to show inventory window sticker pdf
     */
    public function listStickerShowPdf()
    {
        //dd($_POST);
        $listid=Input::get('listid');
        $basic_info         =   $this->listing_basic_info($listid);
        $dealer_info        =   dealermodel::dealerfetch($basic_info['dealer_id']);
        $basic_info['dealername']  = $dealer_info[0]->dealer_name;
        $basic_info['mobile']      = $dealer_info[0]->d_mobile;
        $basic_info['email']       = $dealer_info[0]->d_email;
        $basic_info['logo']        = $dealer_info[0]->watermark_logo;
        $fuel_type                 =   Input::get('fuel_type'); 
        $basic_info['fuel_type']   =   Input::get('fuel_type');
        $basic_info['body_type']   =   Input::get('body_type');
        $basic_info['owners']      =   Input::get('owners');
        $basic_info['transmission']=   Input::get('transmission');
        $basic_info['displacement']=   Input::get('displacement');
        $basic_info['cylinders']   =   Input::get('cylinders');
        $basic_info['mileage']     =   Input::get('mileage');
        $basic_info['air_conditioner']  =  Input::get('air_conditioner');
        $basic_info['central_locking']  =  Input::get('central_locking');
        $basic_info['max_power']        =  Input::get('max_power');
        $basic_info['max_torque']       =  Input::get('max_torque');
        $basic_info['power_steering']   =  Input::get('power_steering');
        $basic_info['anti_lock']        =  Input::get('anti_lock');
        $basic_info['tyre_type']        =  Input::get('tyre_type');
        $basic_info['power_windows_front']  =  Input::get('power_windows_front');
        $basic_info['alloy_wheels']         =  Input::get('alloy_wheels');
        $basic_info['driver_airbags']       =  Input::get('driver_airbags');
        $basic_info['cruise_control']       =  Input::get('cruise_control');
        $basic_info['gear_box']         =  Input::get('gear_box');
        $basic_info['comments']         =  Input::get('comments');
        $basic_info['drivetrain']         =  Input::get('drivetrain');
        $basic_info['certified']         =  Input::get('certified');
        $basic_info['ice_system']         =  Input::get('ice_system');
        $basic_info['clutch_type']         =  Input::get('clutch_type');
        $basic_info['cruise_control']         =  Input::get('cruise_control');
        $basic_info['fuel_tank']         =  Input::get('fuel_tank');
        $basic_info['comments']         =  Input::get('comments');

        $listpdf  = PDF::loadView('sell_listing_sticker_pdf',compact('basic_info'));
        return $listpdf->stream('sell_listing_sticker_pdf');
        //return view('sell_listing_sticker_pdf',compact('basic_info'));

        /*$pathmy=url('inventorylist_sticker/'.$listid);
        $content = \View::make('sell_listing_sticker',[''])->render();
        echo $content;
        return PDF::loadView('sell_listing_sticker',compact('basic_info','feature_info'));
        die;*/
                    
    }

    public function inventory_image()
    {        
        $id                     = Session::get('ses_id');    
        $imageTypeData          = Input::get('imageTypeData');        
        $dplistid               = Input::get('dplistid');             
        $userimage              = Input::get('image');
        $dublicate_id           = Input::get('dplistid');
        $position               = Input::get('position');
        $number                 = Input::get('number'); 
        $exists = $this->SchemaObject->schema_where_two('dms_car_listings_photos','profile_pic_name','car_id',$imageTypeData,$dublicate_id); 
        //dd(count($exists));
        if(!empty($userimage))
        {
            $base64_img_array   =   explode(':', $userimage);
            $img_info           =   explode(',', end($base64_img_array));
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
            
            $nameofimage   = rand(23232,99999).'.'.$img_file_extension;
            $id            = session::get('ses_id');
            $whereSchema   = array('d_id' => $id);
            $SchemaName    = $this->SchemaObject->schema_table_whereschemaname(
                                                            $this->DmsDealerTable,
                                                            $whereSchema);
            if(count($SchemaName) == 1){
                $dealername = $SchemaName[0]->dealer_schema_name;
            }
            else
            {
                $dealername = $this->dealer_schemaname;
            }
            $uploadPath      = "uploadimages/".$dealername."/photos/";
            $img_file_name   = public_path().'/'.$uploadPath.$nameofimage;
            $img_file        = file_put_contents($img_file_name, base64_decode($img_info[1]));
            $img_file_name   = fileuploadmodel::imageresize($img_file_name);
            $dealer_deatails = dealermodel::dealerprofile($id);
            $dealerplan      = inventorymodel::dealerplan();
            $dealerplans     = $dealerplan->plan_type_id;
            if($dealerplans != 1)
            {
                $watermark_image = $dealer_deatails->watermark_logo;   

            }
            else
            {
                $watermark_image = url(Config::get('common.watermark'));   
            }
            if(empty($watermark_image))
            {
                $watermark_image = url(Config::get('common.watermark'));     
            }
            $water_mark      = fileuploadmodel::watermark($img_file_name,$position,$watermark_image,$number);             
            $realpath        = url('uploadimages'.'/'.session::get( 'dealer_schema_name').'/photos/'.$nameofimage);            
            if(!empty($dplistid) && !empty($imageTypeData))
            {
                if(count($exists)==0)
                {

                    //$fileContents = $img_file_name.$nameofimage;
                    $result = Storage::put("/uploadimages/".$dealername."/inventory/".$dublicate_id.'/listing_images/'.$nameofimage, file_get_contents($realpath),'public');
                    unlink($img_file_name);
                    $InsertData = array (
                                            'car_id'=>'',
                                            'car_id'=>Input::get('dplistid'),
                                            'profile_pic_name'=>$imageTypeData,
                                            'photo_link'=>$nameofimage,
                                            'photo_link_fullpath'=>$realpath, 
                                            'folder_path'=>'',                  
                                            's3_bucket_path'=>Config::get('common.s3bucketpath').$dealername."/inventory/".$dublicate_id.'/listing_images/'.$nameofimage,
                                        );        
                    $select     = $this->SchemaObject->schema_insert(
                                                            $this->DmsCarListPhotosTable,
                                                            $InsertData
                                                            );                        
                }   
                else
                {
                    $result = Storage::delete("/uploadimages/".$dealername."/inventory/".$dublicate_id.'/listing_images/'.$exists[0]->photo_link);
                    sleep(2);
                    $result = Storage::put("/uploadimages/".$dealername."/inventory/".$dublicate_id.'/listing_images/'.$nameofimage, file_get_contents($realpath),'public');
                    unlink($img_file_name);             
                    $updateData = array (
                                    'profile_pic_name'=>$imageTypeData,
                                    'photo_link'=>$nameofimage,
                                    'photo_link_fullpath'=>$realpath, 
                                    'folder_path'=>'',                  
                                    's3_bucket_path'=>Config::get('common.s3bucketpath').$dealername."/inventory/".$dublicate_id.'/listing_images/'.$nameofimage
                                );

                    $Profile_id_where =  array('car_id'=>Input::get('dplistid'));
                    $Profile_pic_where = array('profile_pic_name'=>$imageTypeData);
                    $select     = $this->SchemaObject->schema_update_twowhere(
                                                                $this->DmsCarListPhotosTable,
                                                                $Profile_id_where,
                                                                $Profile_pic_where,
                                                                $updateData
                                                                );                                    
                }    
            }                        
            return $realpath;            
        }
        else
        {

            return "OOPs";       
        }
    }
    public function domarketing()
    {
        $header_data  = $this->header_data;
        $left_menu    = '1';
        $compact_array= array('active_menu_name'=>$this->active_menu_name,
                        'side_bar_active'=>1,
                        );        
        $header_data['title']='Marketing';
        $car_id = Input::get('inventory_id');

        $dealer_contact_type = commonmodel::dealer_contact_type()->get();
        $basic_info = $this->listing_basic_info($car_id);
        $listing_features = $this->listing_features($car_id,$basic_info['variant_id']);
        $pricefilter = buyymodel::pricebetweenformarketing($basic_info['price']);
        $pricefilter_id = 0;
        if(count($pricefilter)){
        $pricefilter_id = $pricefilter[0]->option_id;}
        $dealer_schemaname = $this->dealer_schemaname;
        $DmsCarListPhotosTable = $this->DmsCarListPhotosTable;
        $imagefetch = inventorymodel::inventoryImageDetails($dealer_schemaname,$DmsCarListPhotosTable,array('car_id'=>$car_id));
        if(count($imagefetch)>0)
        {
            $imagelinks = $imagefetch[0]->s3_bucket_path;
        }
        else
        {
            $imagelinks = config::get('common.carnoimage');   
        }
        $basic_info['imagelinks'] = $imagelinks;
        $smsdata = array();
        $emaildata = array();
        $data = array();
        foreach($dealer_contact_type as $fetch)
        {
            $data['contact_type'] = $fetch->contact_type;
            $data['contact_type_id'] = $fetch->contact_type_id;
            $data['count'] = contactsmodel::marketingsmsstatuscount($dealer_schemaname,$basic_info['city_id'],$basic_info['make_id'],$basic_info['model_id'],$pricefilter_id,$data['contact_type_id']);
            array_push($smsdata, $data);
            $data['count'] = contactsmodel::marketingemailstatuscount($dealer_schemaname,$basic_info['city_id'],$basic_info['make_id'],$basic_info['model_id'],$pricefilter_id,$data['contact_type_id']);
            array_push($emaildata, $data);
        }
        //dd($smsdata);
        $compact_array['smsdata']=$smsdata;
        $compact_array['emaildata']=$emaildata;
        $compact_array['basic_info']=$basic_info;
        $compact_array['listing_features']=$listing_features;
        return view('marketing',compact('header_data','compact_array'));  
    }

    public function marketingsmsandmail()
    {
        //dd($_POST);
        $id = Session::get('ses_id');
        $phoneno=array();
        $emailids=array();
        $dms_dealers_tablename = 'dms_dealers';
        $fetch_master_dealer_schema   = buyymodel::masterFetchTableDetails($id,$dms_dealers_tablename,array('d_id'=>$id));
        $dealer_info = array();
        if(count($fetch_master_dealer_schema)>0)
        {
          $dealer_schemaname            = $fetch_master_dealer_schema[0]->dealer_schema_name;
          $dealer_name                  = $fetch_master_dealer_schema[0]->dealer_name;
          $d_email                      = $fetch_master_dealer_schema[0]->d_email;  
          $dealership_name              = $fetch_master_dealer_schema[0]->dealership_name;
          $d_mobile                     = $fetch_master_dealer_schema[0]->d_mobile;
          $d_city                       = $fetch_master_dealer_schema[0]->d_city;
          $dealer_info['dealer_schemaname'] = $dealer_schemaname;
          $dealer_info['dealer_name']       = $dealer_name;
          $dealer_info['d_email']           = $d_email;
          $dealer_info['dealership_name']   = $dealership_name;
          $dealer_info['d_mobile']          = $d_mobile;
          $dealer_info['d_city']            = $d_city;
        }

        $inventory_id       = Input::get('inventory_id');
        $listing_basic_info = $this->listing_basic_info($inventory_id);
        $listing_images     = $this->listing_images($inventory_id);
        $listing_image      = $listing_images[0]->s3_bucket_path;
        $listing_id         = $listing_basic_info['car_id'];
        $listing_link       = url('guestlistingpage/'.$listing_id);
        $shorturl           = shortnerurl::shorturl($listing_link);
        //$shorturl = $listing_link;
        //print_r('<pre>');
        $sms_data = array();
        $email_data = array();
        $productinfo = $listing_basic_info['model'].' '.$listing_basic_info['variant'].' '.$listing_basic_info['registration_year'];
        $productcity = $listing_basic_info['car_locality'];
        $noofdays = $listing_basic_info['created_at'];
        $kmdone = $listing_basic_info['kilometer_run'];
        $vehicletype = $listing_basic_info['body_type'];
        $registrationyear = $listing_basic_info['registration_year'];
        $noowner = $listing_basic_info['owner_type'];
        $productprice = $listing_basic_info['price'];

        //print_r('<pre>');

        $maildata = array('',$listing_image,$productinfo,$productcity,$noofdays,$kmdone,$vehicletype,$registrationyear,$noowner,$productprice,$shorturl);
        
        
        if(Input::has('smscheck'))
        {
            foreach(Input::get('sms') as $value)
            {
                $sms_data[] = $value;
            }
        }
        //print_r($sms_data);
        if(Input::has('emailcheck'))
        {
            foreach(Input::get('email') as $fetch)
            {
                $email_data[] = $fetch;                
            }   
        } 
        
        $job = new \App\Jobs\marketingqueue($listing_basic_info,$sms_data,$email_data,$dealer_info,$shorturl,$maildata);
        dispatch($job);
        //$this->queuesmsemailmarket($listing_basic_info,$sms_data,$email_data,$dealer_info,$shorturl,$maildata);
        return redirect('managelisting');

    }

    public static function queuesmsemailmarket($listing_basic_info,$sms_data,$email_data,$dealer_info,$shorturl,$maildata)
    {
        $product_info       = $listing_basic_info['model'].' '.$listing_basic_info['variant'].' '.$listing_basic_info['registration_year'].' '.$listing_basic_info['kilometer_run'];
        $product_price      = $listing_basic_info['price'];
        $pricefilter = buyymodel::pricebetweenformarketing($listing_basic_info['price']);
        $pricefilter_id = 0;
        if(count($pricefilter)>0){
        $pricefilter_id = $pricefilter[0]->option_id;}
        $shorturl           = $shorturl;
        if(count($dealer_info)>0)
        {
            $dealer_schemaname            = $dealer_info['dealer_schemaname'];
            $dealer_name                  = $dealer_info['dealer_name'];
            $d_email                      = $dealer_info['d_email'];  
            $dealership_name              = $dealer_info['dealership_name'];
            $d_mobile                     = $dealer_info['d_mobile'];
            $d_city                       = $dealer_info['d_city'];
        }
        $smsdata                   = array('',
                                            $product_info,
                                            $product_price,
                                            $shorturl,
                                            $dealership_name,
                                            $d_mobile
                                            );
        //dd($sms_data);
        $sms_fetch_details         = contactsmodel::marketingsmsstatusfetchdetail($dealer_schemaname,$listing_basic_info['city_id'],$listing_basic_info['make_id'],$listing_basic_info['model_id'],$pricefilter_id,$sms_data);

        $email_fetch_details         = contactsmodel::marketingemailstatusfetchdetail($dealer_schemaname,$listing_basic_info['city_id'],$listing_basic_info['make_id'],$listing_basic_info['model_id'],$pricefilter_id,$email_data);
        
        if(count($sms_fetch_details)>0)
        {
            foreach($sms_fetch_details as $fetchdetails)
            {
                if($fetchdetails->contact_phone_1!=''){
                    $queries_sms_id     = Config::get('common.queries_sms_id');
                    $smsdata[0]         = $fetchdetails->contact_first_name;
                    $sms_template_data  = smsmodel::get_sms_templates(7);
                    $sms_template       = smsmodel::smsContentConstruct($sms_template_data[0]->sms_subject,$sms_template_data[0]->sms_message,$sms_template_data[0]->sms_parameters,$smsdata);
                    $sms_data           = array('sms_template_data'=>$sms_template,
                                              'phone'=>$fetchdetails->contact_phone_1);
                    $sms_sent           = smsmodel::sendsmsarray($sms_data);
                }
            }
        }

        $queries_email_template_id = 22;
        $email_template_data       = emailmodel::get_email_templates($queries_email_template_id);

        if(count($email_fetch_details)>0)
        {
            foreach($email_fetch_details as $emaildetails)
            {
                if($emaildetails->contact_email_1!=''){
                    $send_email = $fetchdetails->contact_email_1;
                    $maildata[0]= $fetchdetails->contact_first_name;
                    foreach ($email_template_data as $row) 
                    {
                      $mail_subject  =  $row->email_subject;
                      $mail_message  =  $row->email_message;
                      $mail_params   =  $row->email_parameters; 
                    }
                    $email_template    = emailmodel::emailContentConstruct($mail_subject,$mail_message,$mail_params,$maildata);
                    $email_sent        = emailmodel::email_sending($send_email,$email_template);
                }
            }
        }

    }
}