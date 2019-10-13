<?php

namespace App\Http\Controllers;

/*
  Module Name : Manage 
  Created By  : Sreenivasan  26-12-2016
  Use of this module is Branches
*/
use Config;
use Redirect;
use Session;
use Exception;
use Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\model\notificationsmodel;
use App\Exceptions\CustomException;
use App\model\commonmodel;
use App\model\businessmodel;
use App\model\usersmodel;
use App\model\branchesmodel;
use App\model\fileuploadmodel;
use App\model\dealermodel;
use App\model\buyymodel;
use App\Http\Controllers\buy;
/**
* 
*/
class  BusinessProfile extends Controller
{
	public $active_menu_name;
	public $header_data;
	public $side_bar_active;
  public $login_authecation;
  public $masterMainLoginTable;
  public $dmsbusinesstable;
  public $p_id;
  public $id;
	public function __construct()
  {    
    
  	$this->active_menu_name        ='manage_menu';		
  	$this->side_bar_active          ='businessprofile';
    $this->masterMainLoginTable   = "dms_dealers";
    $this->dmsbusinesstable        = "dealer_documents_table";
  	$this->middleware(function ($request, $next) 
  	{
      $this->id                     = session::get('ses_id');
      $this->p_id                   = dealermodel::parent_id($this->id);
        $this->login_authecation = session()->has( 'ses_dealername' ) ? session()->get( 'ses_dealername' ) :  Redirect::to('login')->send();
  	  $this->header_data         = commonmodel::commonheaderdata();
      $this->header_data['title']='Manage';
      $this->header_data['p_id']   =$this->p_id;
      return $next($request);
      }
      );       						
  }
  public function doBusinessProfile()
  {
    $id                     = Session::get('ses_id');
    $dealer_schemaname      = $this->getschemaname($id);
    $paginatenolisting      = Config::get('common.paginatenolisting');
    $selectdealer           = dealermodel::select('dealer_schema_name')
                                   ->where('d_id',"=",$id)
                                   ->first();
    $dealerdata             = dealermodel::dealerdetails_get($selectdealer->dealer_schema_name,$id); 
    $tablename              = 'dms_dealer_branches';
    $headquarter            = dealermodel::dealer_hqbranch($dealer_schemaname,$tablename); 
    $dealer_deatails        = dealermodel::dealerprofile($id);    
    $dealer_branches        = branchesmodel::branch()->where('headquarter',1)->first();    
    $company_type           = businessmodel::company_type();
    $lineof_business        = businessmodel::lineof_business();
    $car_listing            = businessmodel::car_listings()->where('car_master_status',config::get('common.car_status'))->paginate($paginatenolisting);  
    $file_id1               = array('file_id'=>config::get('common.file_id1'));
    $file_id2               = array('file_id'=>config::get('common.file_id2'));
    $file_id3               = array('file_id'=>config::get('common.file_id3'));
    $file_id4               = array('file_id'=>config::get('common.file_id4'));
    $file_id5               = array('file_id'=>config::get('common.file_id5'));
    $document_doc_1         = businessmodel::documents_get($dealer_schemaname,$this->dmsbusinesstable,$file_id1);
    $document_doc_2         = businessmodel::documents_get($dealer_schemaname,$this->dmsbusinesstable,$file_id2);
    $document_doc_3         = businessmodel::documents_get($dealer_schemaname,$this->dmsbusinesstable,$file_id3);
    $document_doc_4         = businessmodel::documents_get($dealer_schemaname,$this->dmsbusinesstable,$file_id4);
    $document_doc_5         = businessmodel::documents_get($dealer_schemaname,$this->dmsbusinesstable,$file_id5);    
    foreach($car_listing as $car_id)
    {
     $car_listings_images    = businessmodel::car_listings_images()->where('car_id',$car_id->car_id)->where('profile_pic_name','profile_pic')->get();
     $image_count    = businessmodel::car_listings_images()->where('car_id',$car_id->car_id)->count();
     $car_id->car_image_count  = $image_count;
      foreach($car_listings_images as $car_image)
      {

          $images  =  $car_image->s3_bucket_path;          
          $car_id->car_image        = $images;
      }
    }        
    $carlisting_count            = businessmodel::car_listings()->where('car_master_status',config::get('common.car_status'))->count();        
    foreach ($car_listing as $key) 
    {
      $startdate            =  $key->mongopushdate;      
      $listing_day          = commonmodel::daysBetweenCurrentDate($startdate);   
      $key->day             = $listing_day;                        
    }    
    $model                  = commonmodel::modeldropdown();
    $variant                = commonmodel::variantdropdown();
    $city                   = commonmodel::get_master_city();    
    $header_data            = $this->header_data;
    if(!empty($dealerdata))
    {
      $compact_array          = array
                              (
                                  'active_menu_name'      =>$this->active_menu_name,         

                                  'side_bar_active'       =>$this->side_bar_active,

                                  'dealer_deatails'       =>$dealer_deatails,

                                  'headquarter'           =>$headquarter,

                                  'dealer_branches'       =>$dealer_branches,

                                  'dealerdata'            =>$dealerdata,

                                  'company_type'          =>$company_type,

                                  'lineof_business'       =>$lineof_business,

                                  'car_listing'           =>$car_listing,

                                  'model'                 =>$model,

                                  'variant'               =>$variant,

                                  'city'                  =>$city,

                                  'count'                 =>$carlisting_count,

                                  'document_doc_1'          =>$document_doc_1,

                                  'document_doc_2'          =>$document_doc_2,

                                  'document_doc_3'          =>$document_doc_3,

                                  'document_doc_4'          =>$document_doc_4,

                                  'document_doc_5'          =>$document_doc_5       
                              );  
                              
                              
    }
    else
    {
      $compact_array          = array
                                (
                                    'active_menu_name'      =>$this->active_menu_name,         

                                    'side_bar_active'       =>$this->side_bar_active,

                                    'dealer_deatails'       =>$dealer_deatails,

                                    'dealer_branches'       =>$dealer_branches,

                                    'dealerdata'            =>'' 
                                );    
    }                              
    return view('mybusiness_profile',compact('compact_array','header_data'));    
  }
  public function doinsertBusinessProfile(Request $request)
  {        
    $id                       = Session::get('ses_id');    
    $dealername               = Input::get('dealer_name');
    $dealership_name          = Input::get('dealership_name');
    $landline                 = Input::get('landline');
    $fax                      = Input::get('fax');
    $mobile                   = Input::get('mobile');
    $dealership_started       = Input::get('dealership_started');
    $line_of_business         = Input::get('line_of_business');
    $company_status           = Input::get('company_status');
    $pan                      = Input::get('pan');    
    $facebook_link            = Input::get('facebook');
    $twitter_link             = Input::get('twitter');
    $linkedin_link            = Input::get('linkedin');
    $comment                  = Input::get('comment');
    $business_domain          = Input::get('business_domain');
    $dealership_website       = Input::get('dealership_website');
    $profile_name             = Input::get('profile_name');
    $userimage                = Input::file('company_logo');
    $dealer_schema_name       =session::get( 'dealer_schema_name' );

    if($profile_name == "")
        {         
          
            $profile_name       = "Please Enter The Profile Name";         
            Session::flash('profile_none', $profile_name);
              return Redirect::back();  
        }   

       $updatedealer             = array
                                  (
                                    'dealer_name'=>$dealername,                                    
                                    'landline_no'=>$landline,                                    
                                    'dealership_name'=>$dealership_name,                                    
                                    'fax_no'=>$fax,
                                    'd_mobile'=>$mobile,
                                    'line_of_business'=>$line_of_business,
                                    'company_status'=>$company_status,
                                    'dealership_started'=>$dealership_started,
                                    'pan_no'=>$pan,                                    
                                    'facebook_link'=>"www.facebook.com/".$facebook_link,
                                    'twitter_link'=>"twitter.com/".$twitter_link,
                                    'linkedin_link'=>"www.linkedin.com/".$linkedin_link,
                                    'about_us'=>$comment,
                                    'profile_name'=>$profile_name,
                                    'business_domain'=>$business_domain,
                                    'dealership_website'=>$dealership_website,
                                  );
    try{
    $businessprofile_update   = dealermodel::dealerupdate($id,$updatedealer);    
                                session(['ses_dealername'=>$dealername]); 
                                session(['dealership_name'=>$dealership_name]); 
    $selectdealer             =    dealermodel::select('dealer_schema_name')
                                   ->where('d_id',"=",$id)
                                   ->first();   
                                   /*dd($selectdealer);*/
                                                        
    $dealerdata               =    dealermodel::dealerdetails_get($selectdealer->dealer_schema_name,$id); 
    if(count($dealerdata))
    {

      $dealerdata             = array(

                                      'dealer_id'=>$id,
                                      'phone'=>$mobile,
                                      'dealer_name'=>$dealername,                                    
                                      'landline_no'=>$landline,                                    
                                      'fax_no'=>$fax,                            
                                      'line_of_business'=>$line_of_business,
                                      'company_status'=>$company_status,
                                      'dealership_started'=>$dealership_started,
                                      'pan_no'=>$pan,                                      
                                      'facebook_link'=>$facebook_link,
                                      'twitter_link'=>$twitter_link,
                                      'linkedin_link'=>$linkedin_link,
                                      'about_us'=>$comment,
                                      'business_domain'=>$business_domain,
                                      'dealership_website'=>$dealership_website
                                     );
                                     session(['ses_dealername'=>$dealername]);    
      $primaryuser_update      = array(
                                        'dealer_id'=>$id,
                                        'user_name'=>$dealername,
                                        'user_moblie_no'=>$mobile
                                      );
      $primaryuser_update      = usersmodel::user_table()->where('user_id',config::get('common.primary_user'))->update($primaryuser_update);
       $detail_id  =  dealermodel::dealerdetails_update($selectdealer->dealer_schema_name,$dealerdata,$id);       
      
    }
    else
    {
        $dealer_storedata =  array(

                                      'dealer_id'=>$id,
                                      'phone'=>$mobile,
                                      'dealer_name'=>$dealername,                                    
                                      'landline_no'=>$landline,                                    
                                      'fax_no'=>$fax,                            
                                      'line_of_business'=>$line_of_business,
                                      'company_status'=>$company_status,
                                      'dealership_started'=>$dealership_started,
                                      'pan_no'=>$pan,
                                      'preferences'=>$preferences,
                                      'facebook_link'=>$facebook_link,
                                      'twitter_link'=>$twitter_link,
                                      'linkedin_link'=>$linkedin_link,
                                      'about_us'=>$comment,
                                      'business_domain'=>$business_domain,
                                      'dealership_website'=>$dealership_website
                                   );
        $detail_id   =  dealermodel::dealerdetails_store($selectdealer->dealer_schema_name,$dealer_storedata,$id);         
    }
        session(['ses_dealername' => $dealername]);
        }catch(Exception $e){
                    throw new CustomException($e->getMessage());
                }
    
  if($detail_id)
  {      
    if(!empty($detail_id))
    {

        return redirect('business_profile')->with('message', 'Your Details Updated Successfully.');
    }
    else
    {
        return redirect('business_profile')->with('message-err', 'Invalid Filetype.And Maximum file size is 2MB.');
    }
  }  
    return redirect('business_profile')->with('message', 'Your Details Updated Successfully.');
  }


  public function check_name()
  {    
    $check_name                  = Input::get('check_name');       
    $carlisting_count            = businessmodel::business_domain($check_name);    
     if($carlisting_count)
      {
          return 0;
      }    
       return 1;
  }
  public function company_logo()
  {

    $id                             = session::get('ses_id');
    $dealer_schema_name             = session::get( 'dealer_schema_name');
    $image_remove                   = Input::get('image_remove');   
    $file                           = Input::file('logo');
    $watermark_path                 = public_path('uploadimages'.'/'.$dealer_schema_name.'/'.'companylogo'.'/'.'watermark');   
    $watermark                      = fileuploadmodel::file_resizer($file,$watermark_path); 
    $route    = url('uploadimages'.'/'.session::get( 'dealer_schema_name').'/'.'companylogo'.'/'.'watermark'.'/');    
    $watermarkReal_path             = $route.'/'.$watermark;   
    $updatedealer                   = array
                                          (                                    
                                            'watermark_logo'=>$watermarkReal_path
                                          );
    $businessprofile_update         = dealermodel::dealerupdate($id,$updatedealer);      
    if(!empty($file))
        {
            $path                           = public_path('uploadimages'.'/'.$dealer_schema_name.'/'.'companylogo'.'/'); 
            $image                          = fileuploadmodel::any_upload($file,$path);             
            $paths                          = url('uploadimages'.'/'.$dealer_schema_name.'/'.'companylogo'.'/');
            $updatedealer                   = array
                                              (                                    
                                                'company_logo'=>$paths.'/'.$image
                                              );
            $businessprofile_update   = dealermodel::dealerupdate($id,$updatedealer);      

        }       
    return redirect('business_profile');

  }
  public function cover_image()
  {    
    $remove_cover             = Input::get('remove_cover');
    $id                       = Session::get('ses_id');    
    $dealer_schema_name       =session::get( 'dealer_schema_name');
    $file                     = Input::file('cover_images');
    if(!empty($file))
        {
            $path                           = public_path('uploadimages'.'/'.$dealer_schema_name.'/'.'companylogo'.'/'.$id.'/');   
            $image                          = fileuploadmodel::any_upload($file,$path);        
            $paths                          = url('uploadimages'.'/'.$dealer_schema_name.'/'.'companylogo'.'/'.$id.'/');
            $updatedealer             = array
                                  (                                    
                                    'coverphoto_logo'=>$paths.'/'.$image
                                  );
            $businessprofile_update   = dealermodel::dealerupdate($id,$updatedealer);  
            return $businessprofile_update;
        }
        else
        {
            $paths = url(Config::get('common.profilenoimage'));            
            $updatedealer             = array
                                  (                                    
                                    'coverphoto_logo'=>$paths
                                  );
            $businessprofile_update   = dealermodel::dealerupdate($id,$updatedealer);  
            return $businessprofile_update;
        }
  }
  public function remove_logo()
  {
      $id                     = Session::get('ses_id');
      $dealer_deatails        = dealermodel::dealerprofile($id);
      $dealer_logo            = $dealer_deatails->company_logo;
      return $dealer_logo;
  }
  public function remove_cover()
  {
    $id                     = Session::get('ses_id');
      $dealer_deatails        = dealermodel::dealerprofile($id);
      $dealer_logo            = $dealer_deatails->coverphoto_logo;
      return $dealer_logo;
  }
  public function business_document()
  {        
    $id                   = session::get('ses_id');
    $dealer_schemaname    = $this->getschemaname($id);
    $document             = Input::get('documt_name');
    $userimage            = Input::file('contact_document');    
    $file_name            = $userimage->getClientOriginalName();
    $document_size        = $userimage->getsize();  
    $file_id              = Input::get('file_id');
    $business_doc         = businessmodel::documents_count($dealer_schemaname,$this->dmsbusinesstable,$file_id);    
        if(!empty($userimage) && !empty($document))
        {
          if(!empty($business_doc))
          {            
            if($document_size <= 5242880)
            {
              if(!empty($userimage))
                  {
                      $path                           = public_path('uploadimages'.'/'.$dealer_schemaname.'/'.'companydocument'.'/'.$id.'/');   
                      $image                          = fileuploadmodel::any_upload($userimage,$path);        
                      $paths                          = url('uploadimages'.'/'.$dealer_schemaname.'/'.'companydocument'.'/'.$id.'/');
                      $insertrecord             = array
                                            (           
                                              'file_type'=>$document,                   
                                              'file_name'=>$file_name,                   
                                              'file_url'=>$paths.'/'.$image
                                            );
                      $business_doc      = businessmodel::documents_update($dealer_schemaname,$this->dmsbusinesstable,$insertrecord,$file_id);
                      return $business_doc;
                  }
                  else
                  {
                      $businessprofile_update = "0";
                      return $business_doc;
                  }
            }
            return $business_doc = "File Size To large";       
          }
          else
          {      
            if($document_size <= 5242880)
            {
              if(!empty($userimage))
                  {
                      $path                           = public_path('uploadimages'.'/'.$dealer_schemaname.'/'.'companydocument'.'/'.$id.'/');   
                      $image                          = fileuploadmodel::any_upload($userimage,$path);        
                      $paths                          = url('uploadimages'.'/'.$dealer_schemaname.'/'.'companydocument'.'/'.$id.'/');
                      $insertrecord             = array
                                            (           
                                              'file_type'=>$document,                   
                                              'file_name'=>$file_name,                   
                                              'file_url'=>$paths.'/'.$image,
                                              'file_id'=>$file_id
                                            );
                    return  businessmodel::documents_table_insert($dealer_schemaname,$this->dmsbusinesstable,$insertrecord);                 
                  }
                  else
                  {
                      $businessprofile_update = "0";
                      return $business_doc;
                  }
            }
          return  $business_doc = "File Size To large";      
          }
        }
        else
        {
          return 0;
        }

  }
  public function dodealer_search()
  {    
        $filter                = Input::get('filter');
     /*if($filter == config::get('common.dealer_search'))
     {*/
         $search_value          = Input::get('search_listing');      
         $dealer_search_count   = dealermodel::dealer_search_count($search_value);
         $dealer_search         = dealermodel::dealer_search($search_value);               
         $dealer_city           = dealermodel::dealer_city_count();
         $dealer_citys          = commonmodel::get_master_city();            
         $verified_dealer       = dealermodel::status();
         foreach ($dealer_search as $value) {      
           $car_listing_count     = buyymodel::mongolistingtypecount(Session::get('ses_id'),array(
            'dealer_id'=>$value->d_id));      
            $value->carlisting_count = $car_listing_count;
         }     
         $paginate_link         =$dealer_search->links();     
         $header_data           = $this->header_data;

        $compact_array          = array
                                  (
                                      'active_menu_name'      =>$this->active_menu_name,         

                                      'side_bar_active'       =>$this->side_bar_active,

                                      'dealer_search'         =>$dealer_search,

                                      'dealer_search_count'   =>$dealer_search_count,

                                      'paginate_link'         =>$paginate_link,                                  

                                      'search_value'          =>$search_value,

                                      'dealer_city'           =>$dealer_city,

                                      'dealer_citys'          =>$dealer_citys,

                                      'verified_dealer'       =>$verified_dealer  
                                  );                                
        return view('dealer_search',compact('compact_array','header_data'));
      /*}*/
      /*elseif($filter == config::get('common.car_search'))
      {
          
      }
      else
      {
        return false;
      }*/

  }
  public function city_search()
  {    
    //dd($_POST);
    $city_id                  = Input::get('city_id');  
    $city_count               = Input::get('city_count'); 
    $status                   = Input::get('status');
    if(empty($city_id) && empty($status))
    {
      $search_value             = Input::get('search_value');
      $dealer_search_count   = dealermodel::dealer_search_count($search_value);
         $dealer_search         = dealermodel::dealer_search($search_value);               
         $dealer_city           = dealermodel::dealer_city_count();
         $dealer_citys          = commonmodel::get_master_city();            
         $verified_dealer       = dealermodel::status();
         foreach ($dealer_search as $value) {      
           $car_listing_count     = buyymodel::mongolistingtypecount(Session::get('ses_id'),array(
            'dealer_id'=>$value->d_id));      
            $value->carlisting_count = $car_listing_count;
         }     
         $paginate_link         =$dealer_search->links();     
         $header_data           = $this->header_data;

        $compact_array          = array
                                  (
                                      'active_menu_name'      =>$this->active_menu_name,         

                                      'side_bar_active'       =>$this->side_bar_active,

                                      'dealer_search'         =>$dealer_search,

                                      'dealer_search_count'   =>$dealer_search_count,

                                      'paginate_link'         =>$paginate_link,                                  

                                      'search_value'          =>$search_value,

                                      'dealer_city'           =>$dealer_city,

                                      'dealer_citys'          =>$dealer_citys,

                                      'verified_dealer'       =>$verified_dealer  
                                  );                                
        return view('ajaxdealer_search',compact('compact_array','header_data'));
    }
    if($status == '1')
    {
      $status  = config::get('common.dealer_status_1');      
    }
    elseif($status == '0')
    {
      $status  = config::get('common.dealer_status_2');      
    }
    else
    {
      $status = '';
    }        
    $dealer_search            = dealermodel::city_search_count($city_id,$status);    
    $dealer_citys             = commonmodel::get_master_city();                
    foreach ($dealer_search as $value) {      
       $car_listing_count     = buyymodel::mongolistingtypecount(Session::get('ses_id'),array(
        'dealer_id'=>$value->d_id));      
        $value->carlisting_count = $car_listing_count;
     }    
     $compact_array = array(
                                'dealer_search'=>$dealer_search,

                                'dealer_citys'=>$dealer_citys,

                                'city_count'=>$city_count
                            );   
    return view('city_search',compact('compact_array'));

  }
  public function dodealer_Profile()
  {
    $id                           = Session::get('ses_id');
    $dealer_id                    = Input::get('dealer_id');
    $dealer_schemaname            = $this->getschemaname($dealer_id);
    $table                        = "dms_car_listings";
    $wherecondition['dealer_id']  = array((int) $dealer_id);  
    $listing_orwherecondition     = array();
    $buy                          = new buy;
    $mongodb_cardetails           = buyymodel::mongoListingFetch($id,$wherecondition,$listing_orwherecondition);
    $mongodb_dealer_cars          = $buy->searchcarlistingarraybulider($mongodb_cardetails);      
    $dealer_deatails              = dealermodel::dealerprofile($dealer_id);   
    $master_city                  = commonmodel::get_master_city();  
    $tablename                    = 'dms_dealer_branches';
    $headquarter                  = dealermodel::dealer_hqbranch($dealer_schemaname,$tablename);    
    $car_listing_count            = buyymodel::mongolistingtypecount(Session::get('ses_id'),array(
        'dealer_id'=>(int) $dealer_id));                  
    $header_data                  = $this->header_data;    
    $compact_array                = array(

                                      'active_menu_name'      =>$this->active_menu_name,

                                      'side_bar_active'       =>$this->side_bar_active,

                                      'dealer_deatails'       =>$dealer_deatails,

                                      'car_listing'           =>$mongodb_dealer_cars,

                                      'car_listing_count'     =>$car_listing_count,

                                      'mongodb_cardetails'    =>$mongodb_cardetails,

                                      'master_city'           =>$master_city,

                                      'headquarter'           =>$headquarter

                                    );
    //dd($compact_array['car_listing']);
    return view('Dealer_BusinessProfile',compact('compact_array','header_data'));
  }
  public function dostatus_search()
  {
    $status                   = Input::get('status');    
    if($status == '1')
    {
      $status  = config::get('common.dealer_status_1');      
    }
    else
    {
      $status  = config::get('common.dealer_status_2');      
    }    
    $dealer_status            =  dealermodel::status_search($status);     
    $dealer_status_count      =  dealermodel::status_count($status);
    $dealer_citys             = commonmodel::get_master_city();                
    foreach ($dealer_status as $value) {      
       $car_listing_count     = buyymodel::mongolistingtypecount(Session::get('ses_id'),array(
        'dealer_id'=>$value->d_id));      
        $value->carlisting_count = $car_listing_count;
     }    
     $compact_array = array(
                                'dealer_search'=>$dealer_status,

                                'dealer_citys'=>$dealer_citys,

                                'dealer_status_count' =>$dealer_status_count
                                
                            );
     /*dd($compact_array['dealer_search']);*/
    return view('dealer_status',compact('compact_array'));
  }
  public function autocomplete()
  {
      $term = Input::get('term');

        $results = array();

        // this will query the users table matching the TagName

       /* $queries = DB::table('New_Themes')
            ->where('TagName', 'like', '%'.$term.'%')
            ->take(5)->get();*/
            $queries = dealermodel::autocomplete($term);

        foreach ($queries as $query)
        {
            $results[] = ['value' => $query->dealer_name];
        }
    return Response::json($results);
  }
  public function getschemaname($id)
    {
    $getdealer_schemaname         = branchesmodel::masterFetchTableDetails(
                                    $this->masterMainLoginTable,
                                    array('d_id'=>$id)
                                    );
      $dealer_schemaname      =   "";
      if(!empty($getdealer_schemaname) && count($getdealer_schemaname) > 0)
      {                             
        foreach($getdealer_schemaname as $dealernameselect)
        {
          $dealer_schemaname  =   $dealernameselect->dealer_schema_name;
        }
        return $dealer_schemaname;
      }
      else
      {
        return false;
      }
  }
}