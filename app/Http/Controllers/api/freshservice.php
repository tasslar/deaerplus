<?php
namespace App\Http\Controllers\api;
use App\Http\Requests;
use App\Http\registervalidation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\buyymodel;
use App\model\common;
use App\model\commonmodel;
use Illuminate\Support\Facades\Input;
use App\model\mongomodel;
use DB;
use Config;
use Carbon\Carbon;

class freshservice extends Controller
{
	public $materCityTable;
	public $masterApiSitesTable;
	public $masterCityfiled;
	public $masterSitefiled;
	public $masterMakeIdfiled;
	public $masterModelsTable;
	public $masterMakeTable;
	public $dealerViewedCarsTable;
	public $dealerSavedCarListingTable;
	public $masterMainLoginTable;
	public $dealerfunddingTable;
	public $dealermessageTable;
	public $dealerbiddingTable;	
	public $carId;
	public $DuplicateMainId;
    public $DmsCarStatus;
    public $DmsCarListPhotosTable;
    public $MasterVariantTable;
    public $DmsCarListVideosTable;
    public $DmsCarListDocumentTable;
	public function __construct(Request $request)
    {		
		$this->materCityTable				=	"master_city";
        $this->masterApiSitesTable  		= 	"master_api_sites";
        $this->masterCityfiled				=	"city_name";
        $this->masterSitefiled				=	"sitename";
        $this->masterMakeIdfiled        	=	"make_id";
        $this->masterModelsTable			=	"master_models";
        $this->masterMakeTable				=	"master_makes";
        $this->dealerViewedCarsTable		=	"dealer_viewed_cars";
        $this->dealerSavedCarListingTable 	= 	"dealer_saved_carlisting";
        $this->masterMainLoginTable 		= 	"dms_dealers";
        $this->dealerfunddingTable 			= 	"dealer_funding_details";
        $this->dealermessageTable 			= 	"dealer_contact_message_transactions";
		$this->dealerbiddingTable			=	"dealer_bidding_details";
		$this->DuplicateMainId          	= 	"duplicate_id";
		$this->carId          				= 	"car_id";
        $this->DmsCarStatus             	= 	"car_master_status";
        $this->DmsCarListPhotosTable    	= 	"dms_car_listings_photos";
        $this->DmsCarListVideosTable    	= 	"dms_car_listings_videos";
        $this->DmsCarListDocumentTable  	= 	"dms_car_listings_documents";
        $this->MasterVariantTable       	= 	"master_variants";
	}
	
	 /*CREATE FRESH TICKET SERVICE FOR FUNDING,LOAN,CONTACT ETC*/
	public static function doApiCreateTicketfreshservice($requesterid,$typeofticket,$dealershipname,$dealername,$requesteremail,$mobilenum,
				$amount,$dealerdate,$dealercity,$dealerarea)
    {     
		$email			=	"admin@dealerplus.in";
		$password		=	"FreshDealer";
		$yourdomain 	= 	"dealerplus";
		//send data json format to api freshservice 
		$ticket_data 	= 	json_encode(array("helpdesk_ticket"=>array(
			"description" => 	"Test tikcet on  the issue ...",
			"subject" 	=> 	"Model make varient",
			"email" 		=> 	$requesteremail,
			"priority" 	=> 	1,
			"status" 		=> 	2,
			"source"		=>	2,
			"ticket_type"	=>	"Service Request",
			"to_email"	=>	"support@dealerplus.in",
			"custom_field"=>	array("mobilenumber_107113"=>$mobilenum,
										"area_107113"=>$dealerarea,
										"city_107113"=>$dealercity,
										"dealername_107113"=>$dealername,
										"dealershipname_107113"=>$dealershipname,
										"funddate_107113"=>$dealerdate,
										"make_107113"=>"honda",
										"model_107113"=>"honda venrda",
										"year_107113"=>"2017",
										"price_107113"=>"2342.3",
										"fueltype_107113"=>"Petrol",
										"ownertype_107113"=>"first",
										"image1_107113"=>"image url",
										"kilometer_107113"=>"12",
										"requesttype_107113"=>"Funding",
										"variant_107113"=>"variant")),
			"cc_emails" 	=> "support@dealerplus.in"
			));
		
		$url 	= 	"https://$yourdomain.freshservice.com/helpdesk/tickets.json";
		$ch 	=	curl_init();
		$header[] = "Content-type: application/json";
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_USERPWD, "$email:$password");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $ticket_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$server_output = curl_exec($ch);
		$info = curl_getinfo($ch);
		
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$headers = substr($server_output, 0, $header_size);
		$response = substr($server_output, $header_size);
		if($info['http_code'] == 200) {
		  echo "Ticket created successfully, the response is given below \n";
		  echo $headers."\n";
		  echo "$response \n";
		 // return true;
		} else {
		  if($info['http_code'] == 404) {
			//return false;
		  } else {
			echo "Error, HTTP Status Code : " . $info['http_code'] . "\n";
			echo "Headers are ".$headers;
			echo "Response are ".$response;
		  }
		}
		curl_close($ch);
    }
	
    /*Get All fetch Model Name table*/
    public function doFetchModel()
    {
        $make_id		=	Input::get('make');
        $wherecondition	=	array($this->masterMakeIdfiled=>$make_id);
        $make 			= 	commonmodel::getAllRecordsWhere($this->masterModelsTable,$wherecondition);
        if(count($make) != 0){
			return response()->json(['Result'	=>'7',
										'message'	=>'success',
										'model_makeid'=>$make
										]);
        }
        else{
            return response()->json(['Result'=>'0',
									'message'=>'failure'
										]);
        }
    }
}
