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
use App\model\dealermodel;
use App\model\buyymodel;
use App\model\shortnerurl;
use App\model\ibb;
use App\model\obv;
use App\model\commonmodel;
use App\model\fundingmodel;
use App\model\inventorymodel;
use App\model\notificationsmodel;
use App\model\emailmodel;
use App\model\smsmodel;
use App\model\leadpreferencesmodel;
use Illuminate\Support\Facades\Mail;
use App\Exceptions\CustomException;
use Exception;
use Session;
use Config;
use Redirect;
use Carbon\Carbon;

class buy extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*
     * The Constructor Consist of Assgned the model objects and master data 
     * Logout if session is out of time
     */
    public $buy_searchlisting_model;
    public $dms_master_dealer_data;
    public $header_data;
    public $session_names;
    public $login_authecation;
    public $active_menu_name;
    public $dealer_schemaname;

    public function __construct() {
        $this->active_menu_name = 'buy_menu';
        $this->middleware(function ($request, $next) {
            $this->login_authecation = session()->has('ses_dealername') ? session()->get('ses_dealername') : Redirect::to('login')->send();
            $this->header_data = commonmodel::commonheaderdata();
            $this->dealer_schemaname = Session::get('dealer_schema_name');
            return $next($request);
        });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('home');
    }

    /*
     * The Function searchlisting Consist of Assgned the model 
     * From Master getting the city, api sites and master makes
     * View of Buy Blade
     */

    public function searchlisting() {
        try {

            $make = commonmodel::makedropdown();

            $master_city = commonmodel::get_master_city();
            $api_sites = commonmodel::get_api_sites();
            $header_data = $this->header_data;
            $left_menu = '1';
            $compact_array = array('active_menu_name' => $this->active_menu_name,
                'left_menu' => 1,
                'master_city' => $master_city,
                'api_sites' => $api_sites,
                'make' => $make
            );
            $header_data['title'] = 'Buy';
        } catch (Exception $e) {
            throw new CustomException($e->getMessage());
        }
        return view('buy', compact('header_data', 'compact_array'));
    }

    /*
     * The Function name searchcarlisting 
     * From Master getting the city, api sites and master makes
     * From Mongo getting the listing datas of searched parameters
     * This Function Consists of 3types of searches are 
     * Search From Search Page
     * Search From Listing Page
     * Search From Similar More Page
     */

    public function searchcarlisting() {
        /* try
          { */
        $users = '';
        $id = Session::get('ses_id');
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
        $listing_orwherecondition = array();
        $listing_wherecondition = array();
        $car_sites = array();
        $city_name = '';
        $radioInline = '';
        $vehicle_make = '';
        $vehicle_model = '';
        $car_budget = '';
        $vehicle_type = '';
        $search_listing = '';
        $model_array = array();
        if (Input::get('page_name') == 'searchpage') {
            $car_sites = Input::get('car_sites');
            $city_name = Input::get('city_name');
            $radioInline = Input::get('radioInline');
            $vehicle_make = Input::get('vehicle_make');
            $vehicle_model = Input::get('vehicle_model');
            $car_budget = Input::get('car_budget');
            $vehicle_type = Input::get('vehicle_type');
            if (empty($car_sites)) {
                $car_sites = array();
            }
            if (!empty($car_budget)) {
                $car_budget_expolde = explode('-', $car_budget);
                $max_exp_price = $car_budget_expolde[1];
                $min_exp_price = $car_budget_expolde[0];
            }


            if ($radioInline == 2) {
                if ($vehicle_make != '') {
                    $listing_wherecondition['make_id'] = array($vehicle_make);
                    $model = buyymodel::masterFetchTableDetails($id, 'master_models', array('make_id' => $listing_wherecondition['make_id']));
                    $model_data = array();
                    $model_array = array();
                    foreach ($model as $key => $value) {
                        $model_data['description'] = $value->model_name;
                        $model_data['count'] = buyymodel::mongolistingtypecount($id, array('model' => $value->model_name));
                        array_push($model_array, $model_data);
                    }
                }
                if ($vehicle_model != '') {
                    $listing_wherecondition['model'] = array($vehicle_model);
                }
                if ($city_name != '') {
                    $listing_wherecondition['car_locality'] = array($city_name);
                }
            } elseif ($radioInline == 1) {
                if ($car_budget != '') {
                    if ($max_exp_price != 'Above') {
                        $listing_wherecondition['sell_price'] = array((int) $min_exp_price, (int) $max_exp_price);
                    } else {
                        $listing_wherecondition['sell_price'] = array((int) $min_exp_price, $max_exp_price);
                    }
                }
                if ($vehicle_type != '') {
                    $listing_wherecondition['body_type'] = array($vehicle_type);
                }
                if ($city_name != '') {
                    $listing_wherecondition['car_locality'] = array($city_name);
                }
            }
        } elseif (Input::get('page_name') == 'detail_searchpage') {
            $city_name = Input::get('city_name');
            if ($city_name != '') {
                $listing_wherecondition['car_locality'] = array($city_name);
            }
            $search_listing = Input::get('search_listing');
            if ($search_listing != '') {
                $listing_orwherecondition['make'] = $search_listing;
                $listing_orwherecondition['model'] = $search_listing;
                $listing_orwherecondition['variant'] = $search_listing;
            }
        } elseif (Input::get('page_name') == 'similar_searchpage') {
            $city_name = Input::get('city_name');
            $make_id = Input::get('make_id');
            $model = Input::get('model');

            if ($city_name != '') {
                $listing_wherecondition['car_locality'] = array($city_name);
            }
            if ($make_id != '') {
                $listing_wherecondition['make_id'] = array($make_id);
            }
            if ($model != '') {
                $listing_wherecondition['model'] = array($model);
            }
        }



        $mongo_carlisting_details = buyymodel::mongoListingFetch($id, $listing_wherecondition, $listing_orwherecondition);

        $mongo_carlisting_count = buyymodel::mongolistingtypecount($id, array('listing_status' => 'Active'), $listing_wherecondition, $listing_orwherecondition);



        $listing_details = $this->searchcarlistingarraybulider($mongo_carlisting_details);
        $paginate_link = $mongo_carlisting_details->links();

        $make = commonmodel::makedropdown();
        $make_data = array();
        $make_array = array();
        foreach ($make as $key => $value) {
            $make_data['description'] = $value->makename;
            $make_data['id'] = (string) $value->make_id;
            $make_data['count'] = buyymodel::mongolistingtypecount($id, array('make_id' => $make_data['id']), $listing_wherecondition, $listing_orwherecondition);
            array_push($make_array, $make_data);
        }
        $master_city = commonmodel::get_master_city();
        $api_sites = commonmodel::get_api_sites();
        $site_data = array();
        $site_array = array();
        foreach ($api_sites as $key => $value) {
            $site_data['description'] = $value->sitename;
            $site_data['count'] = buyymodel::mongolistingtypecount($id, array('sitename' => $site_data['description']), $listing_wherecondition, $listing_orwherecondition);

            array_push($site_array, $site_data);
        }
        $header_data = $this->header_data;
        $listing_category = commonmodel::get_listing_category();
        $listing_data = array();
        $listing_category_array = array();
        foreach ($listing_category as $key => $value) {
            $value->category_id;
            $listing_data['category_description'] = $value->category_description;
            $where_body_type = $value->category_description;

            $listing_data['categorycount'] = buyymodel::mongolistingtypecount($id, array('body_type' => $value->category_description), $listing_wherecondition, $listing_orwherecondition);

            array_push($listing_category_array, $listing_data);
        }
        $master_car_reg_year = commonmodel::master_car_reg_year();
        $reg_year_data = array();
        $reg_year_array = array();
        foreach ($master_car_reg_year as $key => $value) {
            $reg_year_data['description'] = (string) $value->master_reg_year;
            $reg_year_data['count'] = buyymodel::mongolistingtypecount($id, array('registration_year' => $reg_year_data['description']), $listing_wherecondition, $listing_orwherecondition);

            array_push($reg_year_array, $reg_year_data);
        }
        $header_data['title'] = 'Search Listing';
        $transmission = config::get('common.transmission_type');
        $transmission_array = array();
        $transmission_data = array();
        foreach ($transmission as $key => $value) {
            $transmission_data['id'] = (int) $key;
            $transmission_data['description'] = $value;
            $transmission_data['count'] = buyymodel::mongolistingtypecount($id, array('transmission' => $value), $listing_wherecondition, $listing_orwherecondition);

            array_push($transmission_array, $transmission_data);
        }
        $listingtype = config::get('common.listingtype');
        $listingtype_array = array();
        $listingtype_data = array();
        foreach ($listingtype as $key => $value) {
            $listingtype_data['id'] = (int) $key;
            $listingtype_data['description'] = $value;
            $listingtype_data['count'] = buyymodel::mongolistingtypecount($id, array('listing_selection' => $listingtype_data['id']), $listing_wherecondition, $listing_orwherecondition);

            array_push($listingtype_array, $listingtype_data);
        }
        $fuel_type = config::get('common.fuel_type');
        $fuel_array = array();
        $fuel_data = array();
        foreach ($fuel_type as $key => $value) {
            $fuel_data['id'] = (int) $key;
            $fuel_data['description'] = $value;
            $fuel_data['count'] = buyymodel::mongolistingtypecount($id, array('fuel_type' => $value), $listing_wherecondition, $listing_orwherecondition);

            array_push($fuel_array, $fuel_data);
        }
        $master_budget_varient = commonmodel::get_mater_budget();
        $budget_array = array();
        $budget_data = array();
        foreach ($master_budget_varient as $key => $value) {
            $budget_data['value'] = $value->budget_value;
            $explode_data = explode("-", $value->budget_value);
            $budget_data['minvalue'] = $explode_data[0];
            $budget_data['maxvalue'] = $explode_data[1];
            $budget_data['sell_price'] = array($explode_data[0], $explode_data[1]);
            $budget_data['description'] = $value->budget_varient_name;
            if ($explode_data[1] == '>') {
                $budget_data['count'] = buyymodel::mongolistingpricecount($id, array((int) $explode_data[0], 50000000000000000), $listing_wherecondition, $listing_orwherecondition);
            } else {
                $budget_data['count'] = buyymodel::mongolistingpricecount($id, array((int) $explode_data[0], (int) $explode_data[1]), $listing_wherecondition, $listing_orwherecondition);
            }
            array_push($budget_array, $budget_data);
        }

        $compact_array = array('active_menu_name' => $this->active_menu_name,
            'left_menu' => 1,
            'master_city' => $master_city,
            'city_name' => $city_name,
            'api_sites' => $site_array,
            'make' => $make_array,
            'paginate_link' => $paginate_link,
            'mongo_carlisting_count' => $mongo_carlisting_count,
            'listing_details' => $listing_details,
            'body_types' => $listing_category_array,
            'car_sites' => $car_sites,
            'vehicle_make' => $vehicle_make,
            'vehicle_model' => $vehicle_model,
            'car_budget' => $car_budget,
            'vehicle_type' => $vehicle_type,
            'transmission' => $transmission_array,
            'fuel_type' => $fuel_array,
            'listingtype' => $listingtype_array,
            'reg_year' => $reg_year_array,
            'model' => $model_array,
            'price_filter' => $budget_array,
            'search_listing' => $search_listing
        );
        /* print_r('<pre>');     
          print_r($compact_array);
          die; */
        /* }
          catch(Exception $e){
          throw new CustomException($e->getMessage());
          } */
        return view('search_listing', compact('header_data', 'compact_array'));
    }

    function narrowsearchcount() {
        $city_name = Input::get('city_name');
        $sites = Input::get('sites');
        $vehicle_make = Input::get('vehicle_make');
        $vehicle_model = Input::get('vehicle_model');
        $registration_year = Input::get('registration_year');
        $transmission = Input::get('transmission_type');
        $fueltype = Input::get('fuel_type');
        $price_range = Input::get('price_filter');
        $minvalue_filter = Input::get('minvalue_filter');
        $maxvalue_filter = Input::get('maxvalue_filter');
        $body_type = Input::get('body_type');
        $budgetsorting = Input::get('budgetsorting');
        $listypeselect = Input::get('listypeselect');
        $search_listing = Input::get('search_listing');
        $listing_details = array();
        $wherecondition = array();
        $makearray = array();
        $id = Session::get('ses_id');
        if (!empty($vehicle_make)) {
            $wherecondition['make_id'] = $vehicle_make;
        }
        if (!empty($sites)) {
            $wherecondition['sitename'] = $sites;
        }
        if (!empty($listypeselect)) {
            foreach ($listypeselect as $key => $value) {
                $wherecondition['listing_selection'][] = intval($value);
            }
        }

        if ($vehicle_model != '') {
            $wherecondition['model'] = array($vehicle_model);
        }
        if ($registration_year != '') {
            $wherecondition['registration_year'] = array($registration_year);
        }
        if ($transmission != '') {
            $wherecondition['transmission'] = array($transmission);
        }
        if ($fueltype != '') {
            $wherecondition['fuel_type'] = array($fueltype);
        }
        if (!empty($body_type)) {
            $wherecondition['body_type'] = $body_type;
        }
        if ($city_name != '') {
            $wherecondition['car_locality'] = array($city_name);
        }
        if ($price_range != '' && $price_range != 'undefined') {
            if ($maxvalue_filter != 'Above') {
                $wherecondition['sell_price'] = array((int) $minvalue_filter, (int) $maxvalue_filter);
            } else {
                $wherecondition['sell_price'] = array((int) $minvalue_filter, $maxvalue_filter);
            }
        }
        $listing_orwherecondition = array();
        if ($search_listing != '') {
            $listing_orwherecondition['make'] = $search_listing;
            $listing_orwherecondition['model'] = $search_listing;
            $listing_orwherecondition['variant'] = $search_listing;
        }

        $mongo_carlisting_count = buyymodel::mongolistingtypecount($id, array('listing_status' => 'Active'), $wherecondition, $listing_orwherecondition);

        $api_sites = commonmodel::get_api_sites();
        $site_data = array();
        $site_array = array();
        foreach ($api_sites as $key => $value) {
            $site_data['description'] = $value->sitename;
            $site_data['count'] = buyymodel::mongolistingtypecount($id, array('sitename' => $site_data['description']), $wherecondition, $listing_orwherecondition);
            if ((count($sites) > 0) && in_array($site_data['description'], $sites)) {
                $site_data['selected'] = 'selected';
            } else {
                $site_data['selected'] = '';
            }
            array_push($site_array, $site_data);
        }

        $make = commonmodel::makedropdown();
        $make_data = array();
        $make_array = array();
        foreach ($make as $key => $value) {
            $make_data['description'] = $value->makename;
            $make_data['id'] = (string) $value->make_id;
            if ((count($vehicle_make) > 0) && in_array($value->make_id, $vehicle_make)) {
                $make_data['selected'] = 'selected';
            } else {
                $make_data['selected'] = '';
            }
            $make_data['count'] = buyymodel::mongolistingtypecount($id, array('make_id' => $make_data['id']), $wherecondition, $listing_orwherecondition);
            array_push($make_array, $make_data);
        }
        $model_array = array();
        $model_data = array();
        if (!empty($vehicle_make)) {
            $getmodel = commonmodel::domodelwithwherein($vehicle_make);
            foreach ($getmodel as $key => $value) {
                $model_data['description'] = $value->model_name;
                $model_data['id'] = (string) $value->model_id;
                if ($value->model_name == $vehicle_model) {
                    $model_data['selected'] = 'selected';
                } else {
                    $model_data['selected'] = '';
                }
                $model_data['count'] = buyymodel::mongolistingtypecount($id, array('model_id' => $model_data['id']), $wherecondition, $listing_orwherecondition);
                array_push($model_array, $model_data);
            }
        }


        $listing_category = commonmodel::get_listing_category();
        $listing_data = array();
        $listing_category_array = array();
        foreach ($listing_category as $key => $value) {
            $value->category_id;
            $listing_data['category_description'] = $value->category_description;
            $where_body_type = $value->category_description;
            if ((count($body_type) > 0) && in_array($value->category_description, $body_type)) {
                $listing_data['selected'] = 'selected';
            } else {
                $listing_data['selected'] = '';
            }
            $listing_data['categorycount'] = buyymodel::mongolistingtypecount($id, array('body_type' => $value->category_description), $wherecondition, $listing_orwherecondition);

            array_push($listing_category_array, $listing_data);
        }
        $master_car_reg_year = commonmodel::master_car_reg_year();
        $reg_year_data = array();
        $reg_year_array = array();
        foreach ($master_car_reg_year as $key => $value) {
            $reg_year_data['description'] = (string) $value->master_reg_year;
            $reg_year_data['count'] = buyymodel::mongolistingtypecount($id, array('registration_year' => $reg_year_data['description']), $wherecondition, $listing_orwherecondition);
            if ($value->master_reg_year == $registration_year) {
                $reg_year_data['selected'] = 'selected';
            } else {
                $reg_year_data['selected'] = '';
            }
            array_push($reg_year_array, $reg_year_data);
        }

        $transmission_type = config::get('common.transmission_type');
        $transmission_array = array();
        $transmission_data = array();
        foreach ($transmission_type as $key => $value) {
            $transmission_data['id'] = (int) $key;
            $transmission_data['description'] = $value;
            if ($value == $transmission) {
            //if((count($transmission_type)>0)&&in_array($value, $transmission_type))   
                $transmission_data['selected'] = 'selected';
            } else {
                $transmission_data['selected'] = '';
            }
            $transmission_data['count'] = buyymodel::mongolistingtypecount($id, array('transmission' => $value), $wherecondition, $listing_orwherecondition);

            array_push($transmission_array, $transmission_data);
        }
        $listingtype = config::get('common.listingtype');
        $listingtype_array = array();
        $listingtype_data = array();
        foreach ($listingtype as $key => $value) {
            $listingtype_data['id'] = (int) $key;
            $listingtype_data['description'] = $value;
            if ((count($listypeselect) > 0) && in_array($listingtype_data['id'], $listypeselect)) {
                $listingtype_data['selected'] = 'selected';
            } else {
                $listingtype_data['selected'] = '';
            }
            $listingtype_data['count'] = buyymodel::mongolistingtypecount($id, array('listing_selection' => $listingtype_data['id']), $wherecondition, $listing_orwherecondition);

            array_push($listingtype_array, $listingtype_data);
        }
        $fuel_type = config::get('common.fuel_type');
        $fuel_array = array();
        $fuel_data = array();
        foreach ($fuel_type as $key => $value) {
            $fuel_data['id'] = (int) $key;
            $fuel_data['description'] = $value;
            if ($value == $fueltype) {
                $fuel_data['selected'] = 'selected';
            } else {
                $fuel_data['selected'] = '';
            }
            $fuel_data['count'] = buyymodel::mongolistingtypecount($id, array('fuel_type' => $value), $wherecondition, $listing_orwherecondition);

            array_push($fuel_array, $fuel_data);
        }

        $master_budget_varient = commonmodel::get_mater_budget();
        $budget_array = array();
        $budget_data = array();
        foreach ($master_budget_varient as $key => $value) {
            $budget_data['value'] = $value->budget_value;
            $explode_data = explode("-", $value->budget_value);
            $budget_data['minvalue'] = $explode_data[0];
            $budget_data['maxvalue'] = $explode_data[1];
            $budget_data['sell_price'] = array($explode_data[0], $explode_data[1]);
            $budget_data['description'] = $value->budget_varient_name;
            if ($explode_data[1] == '>') {
                $budget_data['count'] = buyymodel::mongolistingpricecount($id, array((int) $explode_data[0], 50000000000000000), $wherecondition, $listing_orwherecondition);
            } else {
                $budget_data['count'] = buyymodel::mongolistingpricecount($id, array((int) $explode_data[0], (int) $explode_data[1]), $wherecondition, $listing_orwherecondition);
            }
            array_push($budget_array, $budget_data);
        }
        return json_encode(array('sites' => $site_array,
            'make' => $make_array,
            'fuel_array' => $fuel_array,
            'listingtype_array' => $listingtype_array,
            'transmission_array' => $transmission_array,
            'reg_year_array' => $reg_year_array,
            'listing_category_array' => $listing_category_array,
            'price_filter' => $budget_array,
            'mongo_carlisting_count' => $mongo_carlisting_count,
            'model_array' => $model_array
        ));
    }

    /*
     * The Function name detail_car_listing 
     * Detailed View of coding
     * Car Fetures Fetched from master
     * Similar Cars Listed Below
     */

    public function detail_car_listing($car_id = '') {
        $id = session::get('ses_id');
        $dealer_schemaname = $this->dealer_schemaname;
        if (Input::has('car_view_id')) {
            $car_id = Input::get('car_view_id');
        } else {
            $car_id = $car_id;
        }
        $city_name = Input::get('city_name');
        $dms_dealers_tablename = 'dms_dealers';
        $mongofetchdetaillisting = $this->mongofetchdetaillisting($car_id, $dealer_schemaname, $id);
        $detail_list_data = $mongofetchdetaillisting[0];
        $listing_features = $mongofetchdetaillisting[1];
        $bidding_data = $mongofetchdetaillisting[2];
        $dealer_info = $mongofetchdetaillisting[3];

        $dealer_viewed_cars = 'dealer_viewed_cars';
        $viewed_insert_array = array('dealer_id' => $id, 'car_id' => $car_id);
        buyymodel::dealerInsertTable($id, $dealer_schemaname, $dealer_viewed_cars, $viewed_insert_array);
        buyymodel::masterInsertTable($id, $dealer_viewed_cars, $viewed_insert_array);

        //CHECK FUNDING TICKET ID IS EXIST OR NOT STRAT
        $fundingticketid    =   "";
        $fundingticket      =   "";
        $getfundingticketid = fundingmodel::doGetcardetailsfundingisexist($id, $car_id);
        if (!empty($getfundingticketid) && count($getfundingticketid)) {
            $getticketid = collect($getfundingticketid)->toArray();
            $fundingticketid    =   encrypt($getticketid[0]->dealer_funding_ticket_id);
            $fundingticket      =   $getticketid[0]->dealer_funding_ticket_id;
        }
        //CHECK FUNDING TICKET ID IS EXIST OR NOT END
        $variant_id = '';
        $make_id = '';
        $auction_end_time = array();

        $listing_wherecondition = array();
        $listing_orwherecondition = array();

        $listing_wherecondition['make_id'] = array($detail_list_data['make_id']);
        $listing_wherecondition['body_type'] = array($detail_list_data['body_type']);
        $fetchbetweenvalue = buyymodel::pricebetween($detail_list_data['price']);
        if (count($fetchbetweenvalue) > 0) {
            $listing_wherecondition['sell_price'] = array($fetchbetweenvalue[0]->min_value, $fetchbetweenvalue[0]->max_value);
        }
        $listing_wherecondition['notinlisting_id'] = array((string) $car_id);

        $mongo_carlisting_details = buyymodel::mongoListingFetch($id, $listing_wherecondition, $listing_orwherecondition
        );
        $listing_details = $this->searchcarlistingarraybulider($mongo_carlisting_details);
        $compact_array = array('active_menu_name' => $this->active_menu_name,
            'left_menu' => 1,
        );
        $header_data = $this->header_data;
        $header_data['title'] = 'Detailed Listing';        
        //dd($mongofetchdetaillisting);
        return view('detail_list', compact('detail_list_data', 'fundingticketid','fundingticket', 'header_data', 'bidding_data', 'listing_details', 'city_name', 'compact_array', 'listing_features', 'dealer_info')
        );
    }

    public static function mongofetchdetaillisting($car_id, $dealer_schemaname, $dealer_id) {
        $variant_id = '';
        $make_id = '';
        $dealer_schemaname = $dealer_schemaname;
        $dms_dealers_tablename = 'dms_dealers';
        $id = $dealer_id;
        $fetch_master_dealer_schema = buyymodel::masterFetchTableDetails($id, $dms_dealers_tablename, array('d_id' => $id));
        if (count($fetch_master_dealer_schema) > 0) {
            $dealer_schemaname = $fetch_master_dealer_schema[0]->dealer_schema_name;
            $dealer_name = $fetch_master_dealer_schema[0]->dealer_name;
            $d_email = $fetch_master_dealer_schema[0]->d_email;
            $dealership_name = $fetch_master_dealer_schema[0]->dealership_name;
            $d_mobile = $fetch_master_dealer_schema[0]->d_mobile;
            $d_city = $fetch_master_dealer_schema[0]->d_city;
        } else {
            $dealer_schemaname = '';
            $dealer_name = '';
            $d_email = '';
            $dealership_name = '';
            $d_mobile = '';
            $d_city = '';
        }
        $dealer_info = array(
            'dealer_name' => $dealer_name,
            'dealership_name' => $dealership_name,
            'd_email' => $d_email,
            'd_mobile' => $d_mobile,
            'd_city' => $d_city
        );

        $auction_end_time = array();
        $detail_list_data = array();
        $wherecondition = array();
        $wherecondition['listing_id'] = array((string) $car_id);
        $listing_orwherecondition = array();
        $update = buyymodel::mongoListingFetchwithqueries($id, $wherecondition, $listing_orwherecondition);
        $listing_features = '';

        foreach ($update as $key) {

            if ($dealer_schemaname != '' && $dealer_schemaname != '0') {
                $queries_contact_title = Config::get('common.queries_contact_title');
                $contact_array = array('user_id' => $id, 'car_id' => $car_id, 'title' => $queries_contact_title);

                $detail_list_data['contactmessagestatus'] = buyymodel::dealerTableCount($id, $dealer_schemaname, 'dealer_contact_message_transactions', $contact_array);

                $queries_testdrive_title = Config::get('common.queries_testdrive_title');
                $contact_array['title'] = $queries_testdrive_title;
                $detail_list_data['test_drive_status'] = buyymodel::dealerTableCount($id, $dealer_schemaname, 'dealer_contact_message_transactions', $contact_array);

                $dealer_saved_cars_tablename = 'dealer_saved_carlisting';

                $count_dealer_saved_cars = buyymodel::dealerTableCount($id, $dealer_schemaname, $dealer_saved_cars_tablename, array('car_id' => $key["listing_id"], 'dealer_id' => $id, 'saved_status' => '1'));

                $count_dealer_alert_cars = buyymodel::dealerTableCount($id, $dealer_schemaname, 'dealer_alert_history', array('alert_listingid' => $key["listing_id"], 'alert_user_id' => $id, 'alert_status' => '1'));
            } else {
                $detail_list_data['contactmessagestatus'] = 0;
                $detail_list_data['test_drive_status'] = 0;
                $count_dealer_saved_cars = 0;
                $count_dealer_alert_cars = 0;
            }

            $variant_id = $key['variant_id'];
            $make_id = $key['make_id'];
            $model = $key['model'];
            $city_name = $key['car_locality'];

            $auction_end_time = $key['auction_end_time'];
            $created_at = $key['created_at'];
            $detail_list_data['car_id'] = $key['listing_id'];
            $detail_list_data['dealer_id'] = $key['dealer_id'];
            $detail_list_data['make_id'] = $key['make_id'];
            $fetch_master_dealer_data = buyymodel::masterFetchTableDetails($id, $dms_dealers_tablename, array('d_id' => $key['dealer_id']));
            $lister_logo = '';
            if (count($fetch_master_dealer_data) > 0) {
                $lister_logo = $fetch_master_dealer_data[0]->logo;
            }
            $detail_list_data['lister_logo'] = $lister_logo;
            $detail_list_data['make'] = $key['make'];
            $detail_list_data['model'] = $key['model'];
            $detail_list_data['variant'] = $key['variant'];
            $detail_list_data['registration_year'] = $key['registration_year'];
            $detail_list_data['fuel_type'] = $key['fuel_type'];
            $detail_list_data['colors'] = $key['colors'];
            $detail_list_data['seating_capacity'] = $key['seating_capacity'];
            $detail_list_data['fuel_capacity'] = $key['fuel_capacity'];
            $detail_list_data['owner_type'] = $key['owner_type'];
            $detail_list_data['transmission'] = $key['transmission'];
            $detail_list_data['kilometer_run'] = $key['kilometer_run'];
            $detail_list_data['body_type'] = $key['body_type'];
            $detail_list_data['mileage'] = $key['mileage'];
            $detail_list_data['airbag'] = $key['driver_airbags'];
            $detail_list_data['air_conditioner'] = $key['air_conditioner'];
            $detail_list_data['central_locking'] = $key['central_locking'];

            $detail_list_data['car_owner_email'] = $key['car_owner_email'];
            $detail_list_data['car_address_1'] = $key['car_address_1'];
            $detail_list_data['car_owner_mobile'] = $key['car_owner_mobile'];
            $detail_list_data['car_owner_name'] = $key['car_owner_name'];
            $detail_list_data['branch_address'] = $key['branch_address'];
            $detail_list_data['car_locality'] = $key['car_city'];
            $dealer_info['d_city'] = $key['car_city'];
            if ($key['branch_address'] == '') {
                $detail_list_data['car_city'] = $key['car_city'];
            } else {
                $detail_list_data['car_city'] = $key['branch_address'];
            }

            $detail_list_data['listing_status'] = $key['listing_status'];
            $expiry_date = commonmodel::daysBetweenExpirydate($key["listing_expiry_date"]);
            $detail_list_data['listing_error_msg'] = commonmodel::listing_status_msg($detail_list_data['listing_status'], $expiry_date);
            $detail_list_data['auction'] = $key['listing_selection'];
            $detail_list_data['auction_starttime'] = $key['auction_starttime'];
            $detail_list_data['auction_end_time'] = $key['auction_end_time'];
            $detail_list_data['created_at'] = $key['created_at'];
            $detail_list_data['count_dealer_saved_cars'] = $count_dealer_saved_cars;
            $detail_list_data['count_dealer_alert_cars'] = $count_dealer_alert_cars;

            $detail_list_data['price'] = $key['sell_price'];
            $api_tablename = 'master_api_sites';
            $get_api_sites = buyymodel::masterFetchTableDetails($id, $api_tablename, array('sitename' => $key['sitename']));

            if (count($get_api_sites) > 0) {
                $get_logo_url = $get_api_sites[0]->logourl;
            } else {
                $get_logo_url = '';
            }

            $reporting_list_tablename = 'dealer_reported_listings';
            $reporting_list_details = buyymodel::masterFetchTableDetails($id, $reporting_list_tablename, array('dealer_id' => $id, 'dealer_listing_id' => $car_id));

            if (count($reporting_list_details) > 0) {
                $reporting_list_details = $reporting_list_details[0]->report_listing_type_type_id;
            } else {
                $reporting_list_details = '';
            }

            $detail_list_data['site_image'] = url($get_logo_url);
            $detail_list_data['reporting_list_details'] = $reporting_list_details;
            $photos_array = array();

            if (count($key["photos"]) > 0) {
                foreach ($key["photos"] as $photokey => $photovalue) {
                    $photos_array['imagelink'] = $photovalue['s3_bucket_path'];
                    $photos_array['imagename'] = $photovalue['profile_pic_name'];
                    $detail_list_data['image_url'][] = $photos_array;
                }
            } else {
                $carnoimage = Config::get('common.carnoimage');
                $photos_array['imagelink'] = $carnoimage;
                $photos_array['imagename'] = '';
                $detail_list_data['image_url'][] = $photos_array;
                //$detail_list_data['image_url']   =array($carnoimage);
            }
            $video_array = array();
            if (count($key["videos"]) > 0) {
                foreach ($key["videos"] as $vediokey => $videovalue) {
                    $video_array[] = $videovalue['video_url_fullpath'];
                }

                $detail_list_data['video_url'] = $video_array;
            } else {
                $detail_list_data['video_url'] = array();
            }
            $detail_list_data['time_left'] = $key['auction_end_date'];
            $detail_list_data['test_drive'] = $key['test_drive'];
            $detail_list_data['test_driveatdealerpoint'] = $key['testdrive_dealerpoint'];
            $detail_list_data['test_driveatdoorpoint'] = $key['testdrive_doorstep'];
            $novalue = 'N/A';
            $listing_features = array(
                'overviewdescription' => commonmodel::doreplacetoNA($key['overviewdescription']),
                'gear_box' => commonmodel::doreplacetoNA($key['gear_box']),
                'drive_type' => commonmodel::doreplacetoNA($key['drive_type']),
                'seating_capacity' => commonmodel::doreplacetoNA($key['seating_capacity']),
                'steering_type' => commonmodel::doreplacetoNA($key['steering_type']),
                'turning_radius' => commonmodel::doreplacetoNA($key['turning_radius']),
                'top_speed' => commonmodel::doreplacetoNA($key['top_speed']),
                'acceleration' => commonmodel::doreplacetoNA($key['acceleration']),
                'tyre_type' => commonmodel::doreplacetoNA($key['tyre_type']),
                'no_of_doors' => commonmodel::doreplacetoNA($key['no_of_doors']),
                'engine_type' => commonmodel::doreplacetoNA($key['engine_type']),
                'displacement' => commonmodel::doreplacetoNA($key['displacement']),
                'max_power' => commonmodel::doreplacetoNA($key['max_power']),
                'max_torque' => commonmodel::doreplacetoNA($key['max_torque']),
                'no_of_cylinder' => commonmodel::doreplacetoNA($key['no_of_cylinder']),
                'valves_per_cylinder' => commonmodel::doreplacetoNA($key['valves_per_cylinder']),
                'valve_configuration' => commonmodel::doreplacetoNA($key['valve_configuration']),
                'fuel_supply_system' => commonmodel::doreplacetoNA($key['fuel_supply_system']),
                'turbo_charger' => commonmodel::doreplacetoNA($key['turbo_charger']),
                'super_charger' => commonmodel::doreplacetoNA($key['super_charger']),
                'length' => commonmodel::doreplacetoNA($key['length']),
                'width' => commonmodel::doreplacetoNA($key['width']),
                'height' => commonmodel::doreplacetoNA($key['height']),
                'wheel_base' => commonmodel::doreplacetoNA($key['wheel_base']),
                'gross_weight' => commonmodel::doreplacetoNA($key['gross_weight']),
                'air_conditioner' => $key['air_conditioner'],
                'adjustable_steering' => $key['adjustable_steering'],
                'leather_steering_wheel' => $key['leather_steering_wheel'],
                'heater' => $key['heater'],
                'digital_clock' => $key['digital_clock'],
                'power_steering' => $key['power_steering'],
                'power_windows_front' => $key['power_windows_front'],
                'power_windows_rear' => $key['power_windows_rear'],
                'remote_trunk_opener' => $key['remote_trunk_opener'],
                'remote_fuel_lid_opener' => $key['remote_fuel_lid_opener'],
                'low_fuel_warning_light' => $key['low_fuel_warning_light'],
                'rear_reading_lamp' => $key['rear_reading_lamp'],
                'rear_seat_headrest' => $key['rear_seat_headrest'],
                'rear_seat_centre_arm_rest' => $key['rear_seat_centre_arm_rest'],
                'height_adjustable_front_seat_belts' => $key['height_adjustable_front_seat_belts'],
                'cup_holders_front' => $key['cup_holders_front'],
                'cup_holders_rear' => $key['cup_holders_rear'],
                'rear_ac_vents' => $key['rear_ac_vents'],
                'parking_sensors' => $key['parking_sensors'],
                'anti_lock_braking_system' => $key['anti_lock_braking_system'],
                'central_locking' => $key['central_locking'],
                'child_safety_lock' => $key['child_safety_lock'],
                'driver_airbags' => $key['driver_airbags'],
                'passenger_airbag' => $key['passenger_airbag'],
                'rear_seat_belts' => $key['rear_seat_belts'],
                'seat_belt_warning' => $key['seat_belt_warning'],
                'adjustable_seats' => $key['adjustable_seats'],
                'crash_sensor' => $key['crash_sensor'],
                'anti_theft_device' => $key['anti_theft_device'],
                'immobilizer' => $key['immobilizer'],
                'adjustable_head_lights' => $key['adjustable_head_lights'],
                'power_adjustable_exterior_rear_view_mirror' => $key['power_adjustable_exterior_rear_view_mirror'],
                'electric_folding_rear_view_mirror' => $key['electric_folding_rear_view_mirror'],
                'rain_sensing_wipers' => $key['rain_sensing_wipers'],
                'rear_window_wiper' => $key['rear_window_wiper'],
                'alloy_wheels' => $key['alloy_wheels'],
                'tinted_glass' => $key['tinted_glass'],
                'front_fog_lights' => $key['front_fog_lights'],
                'rear_window_defogger' => $key['rear_window_defogger'],
                'cdplayer' => $key['cdplayer'],
                'radio' => $key['radio'],
                'audio' => $key['audio'],
                'bluetooth' => $key['bluetooth'],
            );
//dd($listing_features);
        }

        $bidding_wherecondition = array('car_id' => $car_id);
        $bidding_list = buyymodel::masterBiddingDetail($bidding_wherecondition);

        $bidders_count = buyymodel::masterBiddingCount($bidding_wherecondition);

        $bids_count = buyymodel::masterBidCount($bidding_wherecondition);

        $detail_list_data['bidders_count'] = $bidders_count;
        $detail_list_data['bids_count'] = $bids_count;

        $detail_list_data['bidding_duration'] = $bids_count;
        $detail_list_data['dealer_name'] = $dealer_name;
        $detail_list_data['d_email'] = $d_email;

        $detail_list_data['listing_page'] = 1;
        $data = array();
        $bidding_data = array();

        if (!empty($bidding_list)) {
            foreach ($bidding_list as $biddedkey) {

                $data['bidded_amount'] = $biddedkey->bidded_amount;
                $data['delear_datetime'] = date('d-m-Y H:i:s', strtotime($biddedkey->delear_datetime));
                $data['dealer_id'] = $biddedkey->dealer_id;

                $get_dealer_name = buyymodel::masterFetchTableDetails($id, $dms_dealers_tablename, array('d_id' => $biddedkey->user_id));
                if (count($get_dealer_name) <= 0) {
                    $to_dealer_name = '';
                } else {
                    $dealer_name = $get_dealer_name[0]->dealer_name;
                    $to_dealer_name = commonmodel::maskingWithX($dealer_name);
                }

                $data['dealer_name'] = $to_dealer_name;
                $data['car_id'] = $biddedkey->car_id;
                array_push($bidding_data, $data);
            }
        }
        return array($detail_list_data, $listing_features, $bidding_data, $dealer_info);
    }

    public function searchcarlistingarraybulider($mongo_carlisting_details) {
        $data = array();
        $listing_details = array();
        foreach ($mongo_carlisting_details as $key => $value) {
            $data['make'] = $value["make"];
            $data['make_id'] = $value["make_id"];
            $data['model'] = $value["model"];
            $data['variant'] = $value["variant"];
            $data['car_address_1'] = $value["car_address_1"];
            $data['place'] = $value["place"];
            $data['car_locality'] = $value["car_locality"];
            $data['registration_year'] = $value["registration_year"];
            $data['listing_expiry_date'] = $value["listing_expiry_date"];

            $days = commonmodel::daysBetweenCurrentDate($value["created_at"]);

            if ($days <= 0) {
                $daysstmt = 'Listed Today';
            } else {
                $daysstmt = 'Listed ' . $days . ' day ago';
            }
            $data['kilometer_run'] = $value["kilometer_run"];

            $data['fuel_type'] = $value["fuel_type"];

            $data['owner_type'] = $value["owner_type"];
            $data['price'] = $value["sell_price"];
            $data['daysstmt'] = $daysstmt;

            $data['car_id'] = $value["listing_id"];


            $data['dealer_id'] = $value["dealer_id"];

            $data['listing_status'] = $value["listing_status"];
            $expiry_date = commonmodel::daysBetweenExpirydate($value["listing_expiry_date"]);
            $data['listing_error_msg'] = commonmodel::listing_status_msg($value["listing_status"], $expiry_date);

            $id = session::get('ses_id');



            $dealer_schemaname = session::get('dealer_schema_name');

            $dealer_viewed_cars_tablename = 'dealer_viewed_cars';

            $count_dealer_viewed_cars = buyymodel::dealerTableCount($id, $dealer_schemaname, $dealer_viewed_cars_tablename, array('car_id' => $value["listing_id"], 'dealer_id' => $id));

            $dealer_saved_cars_tablename = 'dealer_saved_carlisting';

            $count_dealer_saved_cars = buyymodel::dealerTableCount($id, $dealer_schemaname, $dealer_saved_cars_tablename, array('car_id' => $value["listing_id"], 'dealer_id' => $id, 'saved_status' => '1'));

            $count_dealer_alert_cars = buyymodel::dealerTableCount($id, $dealer_schemaname, 'dealer_alert_history', array('alert_listingid' => $value["listing_id"], 'alert_user_id' => $id, 'alert_status' => '1'));

            $data['noimages'] = count($value["photos"]);
            $photos_array = array();

            if (count($value["photos"]) > 0) {
                foreach ($value["photos"] as $photokey => $photovalue) {
                    $photos_array[] = $photovalue['s3_bucket_path'];
                }
                $data['imagelinks'] = $photos_array[0];
            } else {
                $carnoimage = Config::get('common.carnoimage');
                $data['imagelinks'] = $carnoimage;
            }
            $data['site'] = '1';
            $data['saved_car'] = $count_dealer_saved_cars;
            $data['compare_car'] = '1';
            $data['notify_car'] = $count_dealer_alert_cars;
            $data['view_car'] = $count_dealer_viewed_cars;
            $data['auction'] = $value["listing_selection"];
            $api_tablename = 'master_api_sites';
            $get_api_sites = buyymodel::masterFetchTableDetails($id, $api_tablename, array('sitename' => $value['sitename']));
            if (count($get_api_sites) > 0) {
                $get_logo_url = $get_api_sites[0]->logourl;
            } else {
                $get_logo_url = '';
            }
            $data['site_image'] = url($get_logo_url);
            array_push($listing_details, $data);
        }
        return $listing_details;
    }

    public function test_drive_update() {

        $id = session::get('ses_id');
        $queries_testdrive_title = Config::get('common.queries_testdrive_title');
        $currentdate = Carbon::now();
        $contact_transactioncode = $currentdate->format('Ymdhis');
        $test_drive = Input::get('test_drive');
        $dms_dealers_tablename = 'dms_dealers';
        $dealer_wherecondition = array('d_id' => $id);
        $fetchupdate = buyymodel::masterFetchTableDetails($id, $dms_dealers_tablename, $dealer_wherecondition);
        $dealer_schemaname = $fetchupdate[0]->dealer_schema_name;
        $fromdealer_name = $fetchupdate[0]->dealer_name;
        $from_email = $fetchupdate[0]->d_email;
        $from_mobileno = $fetchupdate[0]->d_mobile;
        $dealer_profile_image = $fetchupdate[0]->logo;

        $to_dealer_wherecondition = array('d_id' => Input::get('dealer_id'));
        $to_dealer_id_fetch = buyymodel::masterFetchTableDetails($id, $dms_dealers_tablename, $to_dealer_wherecondition);
        $to_dealer_name = $to_dealer_id_fetch[0]->dealer_name;
        $to_dealer_email = $to_dealer_id_fetch[0]->d_email;
        $to_dealer_mobile = $to_dealer_id_fetch[0]->d_mobile;
        $to_dealer_schema_name = $to_dealer_id_fetch[0]->dealer_schema_name;
        $to_dealer_profile_image = $to_dealer_id_fetch[0]->logo;

        $data = array('from_dealer_id' => $id,
            'contact_transactioncode' => $contact_transactioncode,
            'to_dealer_id' => Input::get('dealer_id'),
            'mobile' => $from_mobileno,
            'car_id' => Input::get('car_id'),
            'dealer_name' => $fromdealer_name,
            'dealer_email' => $from_email,
            'message' => Input::get('contact_dealer_message'),
            'title' => $queries_testdrive_title,
            'delear_datetime' => date('Y-m-d H:i:s'),
            'user_id' => $id,
        );

        $testdrive_data = array('listing_dealer_id' => Input::get('dealer_id'),
            'car_id' => Input::get('car_id'),
            'test_drive' => Input::get('test_drive'),
            'title' => Input::get('make_model_variant'),
            'user_id' => $id,
        );



        $table = 'dealer_contact_message_transactions';

        $testdrivetable = 'dealer_testdrive';

        $theard_id = buyymodel::dealerInsertTable($id, $dealer_schemaname, $table, $data);

        buyymodel::dealerInsertTable($id, $dealer_schemaname, $testdrivetable, $testdrive_data);

        $last_theard_id = buyymodel::dealerInsertToTable($id, $to_dealer_schema_name, $table, $data);

        buyymodel::dealerInsertToTable($id, $to_dealer_schema_name, $testdrivetable, $testdrive_data);

        $queries_notification_type_id = config::get('common.receive_queries_notification_type_id');
        $notification_type = notificationsmodel::get_notification_dealer_type($queries_notification_type_id);
        $notification_message = 'Test drive-' . ' ' . $fromdealer_name . ' ' . Input::get('make_model_variant') . ' ' . Input::get('contact_dealer_message');
        $dealer_notification = array('user_id' => $id,
            'd_id' => Input::get('dealer_id'),
            'notification_type_id' => $queries_notification_type_id,
            'title' => Input::get('make_model_variant'),
            'notification_type' => $notification_type[0]->notification_type_name,
            'message' => Input::get('contact_dealer_message'),
            'contact_transactioncode'=>$contact_transactioncode,
            'status' => 1);
        notificationsmodel::dealer_notification_insert($to_dealer_schema_name, $dealer_notification);

        $maildata = array('0' => $to_dealer_profile_image,
            '1' => $to_dealer_name,
            '2' => $fromdealer_name,
            '3' => $dealer_profile_image,
            '4' => Input::get('contact_dealer_message'),
        );
        $queries_email_template_id = config::get('common.queries_email_template_id');
        $email_template_data = emailmodel::get_email_templates($queries_email_template_id);

        foreach ($email_template_data as $row) {
            $mail_subject = $row->email_subject;
            $mail_message = $row->email_message;
            $mail_params = $row->email_parameters;
        }

        $send_email = $to_dealer_email;
        $email_template = emailmodel::emailContentConstruct($mail_subject, $mail_message, $mail_params, $maildata);
        $email_sent = emailmodel::email_sending($send_email, $email_template);
        //Mail End
        //Sms Queries Start
        $phone = $to_dealer_mobile;
        $queries_sms_id = Config::get('common.queries_sms_id');
        $sms_template_data = smsmodel::get_sms_templates($queries_sms_id);
        $sms_data = array('sms_template_data' => $sms_template_data,
            'phone' => $phone);
        $sms_sent = smsmodel::sendsms($sms_data);
        //End SMS
        echo json_encode(array('success' => true, 'data' => $last_theard_id));
    }

    /*
     * Function Name message_grid_view
     * 
     */

    public function message_grid_view() {

        //$car_id                           = Input::get('reply_carid');
        //$to_dealer_id                     = Input::get('to_dealer_id');
        $contact_transactioncode = Input::get('contact_transactioncode');
        $id = session::get('ses_id');
        $dealer_schemaname = $this->dealer_schemaname;

        $tablename = 'dealer_contact_message_transactions';
        $wherecondition = array('contact_transactioncode' => $contact_transactioncode);
        $contact_message_grid = buyymodel::dealerFetchTableDetails($id, $dealer_schemaname, $tablename, $wherecondition);

        $dealer_id = $contact_message_grid[0]->from_dealer_id;
        $to_dealer_id = $contact_message_grid[0]->to_dealer_id;
        $car_id = $contact_message_grid[0]->car_id;
        if ($contact_message_grid[0]->to_dealer_id == $id) {
            $to_dealer_id = $dealer_id;
        }

        $dealer_wherecondition = array('d_id' => $to_dealer_id);
        $dms_dealers_tablename = 'dms_dealers';
        $conversationname_details = buyymodel::masterFetchTableDetails($id, $dms_dealers_tablename, $dealer_wherecondition);

        $setcondition = array('status' => 0);
        buyymodel::dealerUpdateTableDetails($id, $dealer_schemaname, $tablename, $wherecondition, $setcondition);

        $data = array();
        $messagedetails = array();
        $infodetails = array();
        $data['contact_message_grid_html'] = '';
        $listing_id = (string) $car_id;
        $whereconditionon['listing_id'] = array($listing_id);
        $listing_orwherecondition = array();
        $update = buyymodel::mongoListingFetchwithqueries($id, $whereconditionon, $listing_orwherecondition);
        if (!empty($update)) {
            foreach ($update as $key) {
                $make = $key['make'];
                $sell_price = $key['sell_price'];
                $variant = $key['variant'];
                $model = $key['model'];
                $car_locality = $key['car_locality'];
                $created_date = $key['created_at'];

                $listing_status = $key['listing_status'];
                $listing_error_msg = $key['listing_error_msg'];
                $expiry_date = commonmodel::daysBetweenExpirydate($key["listing_expiry_date"]);
                $listing_error_msg = commonmodel::listing_status_msg($listing_status, $expiry_date);

                $data['noimages'] = count($key["photos"]);
                $photos_array = array();

                if (count($key["photos"]) > 0) {
                    foreach ($key["photos"] as $photokey => $photovalue) {
                        $photos_array[] = $photovalue['s3_bucket_path'];
                    }
                    $imagelinks = $photos_array[0];
                } else {
                    $carnoimage = Config::get('common.carnoimage');
                    $imagelinks = $carnoimage;
                }

                $days = commonmodel::daysBetweenCurrentDate($created_date);
                if ($days <= 0) {
                    $daysstmt = 'Listed Today';
                } else {
                    $daysstmt = 'Listed ' . $days . ' day ago';
                }
            }
        } else {
            $make = '';
            $sell_price = '';
            $variant = '';
            $model = '';
            $car_locality = '';
            $daysstmt = '';
            $imagelinks = '';
            $listing_error_msg = '';
            $listing_status = '';
        }
        $infodetails['make'] = $make;
        $infodetails['sell_price'] = $sell_price;
        $infodetails['variant'] = $variant;
        $infodetails['model'] = $model;
        $infodetails['car_locality'] = $car_locality;
        $infodetails['daysstmt'] = $daysstmt;
        $infodetails['imagelinks'] = $imagelinks;
        $infodetails['to_dealer_id'] = $to_dealer_id;
        $infodetails['car_id'] = $car_id;
        $infodetails['listing_error_msg'] = $listing_error_msg;
        $infodetails['listing_status'] = $listing_status;
        $infodetails['contact_transactioncode'] = $contact_transactioncode;
        if (count($conversationname_details) > 0) {
            $infodetails['headerdealername'] = $conversationname_details[0]->dealer_name;
        } else {
            $infodetails['headerdealername'] = 'The User is Not Available in System';
        }
        if (!empty($contact_message_grid)) {
            foreach ($contact_message_grid as $messagekey) {
                $style_align = 'left';
                if ($messagekey->user_id == $id) {
                    $style_align = 'right';
                }
                $data['style_align'] = $style_align;
                $data['contact_message_grid_html'] = $messagekey->message;
                $data['delear_datetime'] = $messagekey->delear_datetime;
                $data['downloadlink'] = '0';
                $dms_dealers_tablename = 'dms_dealers';
                $dealer_wherecondition = array('d_id' => $messagekey->user_id);
                $to_get_dealer_details = buyymodel::masterFetchTableDetails($id, $dms_dealers_tablename, $dealer_wherecondition);
                if (count($to_get_dealer_details) > 0) {
                    $dealer_profile_image = $to_get_dealer_details[0]->logo;
                } else {
                    $dealer_profile_image = url('img/noimage.jpeg');
                }
                $data['dealer_profile_image'] = $dealer_profile_image;
                $tablename_document = 'contact_documents_table';
                $wherecondition_document = array('id' => $messagekey->thread_id);
                $contact_document_grid = buyymodel::dealerFetchTableDetails($id, $dealer_schemaname, $tablename_document, $wherecondition_document);
                array_push($messagedetails, $data);
                if (!empty($contact_document_grid)) {
                    foreach ($contact_document_grid as $documentkey) {
                        $data['style_align'] = $style_align;
                        $data['downloadlink'] = 1;
                        $data['delear_datetime'] = $messagekey->delear_datetime;
                        $data['contact_message_grid_html'] = $documentkey->file_url;
                        array_push($messagedetails, $data);
                    }
                }
            }
        }
        $compact_array = array('active_menu_name' => $this->active_menu_name,
            'left_menu' => 3,
            'car_info' => $infodetails,
            'messagedetails' => $messagedetails,
        );
        $header_data = $this->header_data;
        $header_data['title'] = 'Sent Queries';
        $notification_type = config::get('common.receive_queries_notification_type_id');
        return view('sentqueries', compact('compact_array', 'header_data', 'notification_type'));
    }

    /*
     * The Function name Queried Cars 
     * Message Sent to dealer of car
     */

    public function queries_car() {
        try {
            $id = session::get('ses_id');
            $dms_dealers_tablename = 'dms_dealers';
            $fetch_master_dealer_schema = buyymodel::masterFetchTableDetails($id, $dms_dealers_tablename, array('d_id' => $id));
            $dealer_schemaname = $fetch_master_dealer_schema[0]->dealer_schema_name;
            $dealer_name = $fetch_master_dealer_schema[0]->dealer_name;

            $fetch_queried_details = buyymodel::dealerQueriesDetail($dealer_schemaname);
            //dd($fetch_queried_details);
            $paginatelink = $fetch_queried_details->links();
            $queriesdata = array();
            $listing_orwherecondition = array();
            $listing_wherecondition = array();
            foreach ($fetch_queried_details as $key) {
                $car_id = (string) $key->car_id;
                $dealer_id = $key->from_dealer_id;
                $listing_wherecondition['listing_id'] = array($car_id);
                $mongo_carlisting_details = buyymodel::mongoListingFetchwithqueries($id, $listing_wherecondition, $listing_orwherecondition);
                //dd($mongo_carlisting_details);
                foreach ($mongo_carlisting_details as $userkey => $uservalue) {
                    $data['noimages'] = count($uservalue["photos"]);
                    $photos_array = array();

                    $expiry_date = commonmodel::daysBetweenExpirydate($uservalue["listing_expiry_date"]);
                    $listing_error_msg = commonmodel::listing_status_msg($uservalue['listing_status'], $expiry_date);

                    if (count($uservalue["photos"]) > 0) {
                        foreach ($uservalue["photos"] as $photokey => $photovalue) {
                            $photos_array[] = $photovalue['s3_bucket_path'];
                        }
                        $data['imagelink'] = $photos_array[0];
                    } else {
                        $carnoimage = Config::get('common.carnoimage');
                        $data['imagelink'] = $carnoimage;
                    }

                    $data['listing_type'] = $uservalue['listing_type'];
                    $data['price'] = $uservalue["sell_price"];
                    $dms_dealers_tablename = 'dms_dealers';


                    $to_get_dealer_id = $key->to_dealer_id;
                    if ($key->to_dealer_id == $id) {
                        $to_get_dealer_id = $dealer_id;
                    }
                    $fetch_master_todealer_schema = buyymodel::masterFetchTableDetails($id, $dms_dealers_tablename, array('d_id' => $to_get_dealer_id));

                    if (count($fetch_master_todealer_schema) <= 0) {
                        $to_dealer_name = '';
                    } else {
                        $to_dealer_name = $fetch_master_todealer_schema[0]->dealer_name;
                    }
                    $codewherecondition = array('contact_transactioncode' => $key->contact_transactioncode);

                    $latest_message = buyymodel::dealerQueriesWithCode($dealer_schemaname, array('contact_transactioncode' => $key->contact_transactioncode));
                    //dd($latest_message);
                    $data['car_id'] = $key->car_id;
                    $data['status'] = $latest_message->status;
                    $data['from_dealer_id'] = $dealer_name;
                    $data['to_dealer_name'] = $to_dealer_name;
                    $data['to_dealer_id'] = $to_get_dealer_id;
                    $data['make'] = $uservalue['model'] . ' ' . $uservalue['variant'] . ' ' . $uservalue['registration_year'];
                    $data['title'] = $key->title;
                    $data['dealer_name'] = $key->dealer_name;
                    $data['dealer_email'] = $key->dealer_email;
                    $data['message'] = $latest_message->message;
                    $data['contact_transactioncode'] = $key->contact_transactioncode;
                    array_push($queriesdata, $data);
                }
            }

            $compact_array = array('active_menu_name' => $this->active_menu_name,
                'left_menu' => 3,
                'queriesdata' => $queriesdata,
            );
            $header_data = $this->header_data;
            $header_data['title'] = 'My Queries';
        } catch (Exception $e) {
            throw new CustomException($e->getMessage());
        }
        return view('queries_car_view', compact('compact_array', 'header_data', 'paginatelink'));
    }

    /*
     * The Function name ApplyFunding 
     * Apply the finding for car in my queries page
     */

    public function apply_fund() {
        $id = session::get('ses_id');
        $dealershipname = Input::get('dealershipname');
        $dealername = Input::get('dealername');
        $dealermobileno = Input::get('dealermobileno');
        $dealermailid = Input::get('dealermailid');
        $dealercity = Input::get('dealercity');
        $dealerarea = Input::get('dealerarea');
        $dealerdate = Input::get('dealerdate');
        $requested_amount = Input::get('requested_amount');

        $currentdate = Carbon::now();
        $fundPrefix = Config::get('common.fundPrefix');
        $ticket_id = $fundPrefix . $currentdate->format('Ymdhis');
        $dealer_schemaname = $this->dealer_schemaname;
        $insertrecord = array('ticket_id' => $ticket_id,
            'dealershipname' => $dealershipname,
            'dealername' => $dealername,
            'dealermailid' => $dealermailid,
            'dealermobileno' => $dealermobileno,
            'requested_amount' => $requested_amount,
            'dealercity' => $dealercity,
            'dealerarea' => $dealerarea,
            'created_date' => $dealerdate,
            'user_id' => $id
        );
        $dealer_funding_tablename = 'dealer_funding_details';
        buyymodel::dealerInsertTable($id, $dealer_schemaname, $dealer_funding_tablename, $insertrecord);
    }

    /*
     * The Function name applyInventoryFund 
     * Display the list of applied funding cars
     */

    public function apply_inventory_fund() {
        try {
            $id = session::get('ses_id');

            $dealer_schema_name = $this->dealer_schemaname;
            $fetch_queried_details = buyymodel::dealerFundingDetail($dealer_schema_name);
            //print_r($fetch_queried_details);
            //exit;
            $fundingdata = array();
            $data = array();
            foreach ($fetch_queried_details as $key) {
                $data['ticket_id'] = $key->ticket_id;
                $dms_dealers_tablename = 'dms_dealers';
                $fetch_master_todealer = buyymodel::masterFetchTableDetails($id, $dms_dealers_tablename, array('d_id' => $key->user_id));

                $fetch_dealer_name = $fetch_master_todealer[0]->dealer_name;
                $d_mobile = $fetch_master_todealer[0]->d_mobile;
                $data['dealer_name'] = $fetch_dealer_name;

                $data['mobileno'] = $key->dealermobileno;
                $data['dealercity'] = $key->dealercity;
                $data['requested_amount'] = $key->requested_amount;
                $data['created_date'] = $key->created_date;
                array_push($fundingdata, $data);
            }
            //$queriesdata=$fulldata;
            $header_data = $this->header_data;
            $compact_array = array('active_menu_name' => $this->active_menu_name,
                'left_menu' => 5,
                'fundingdata' => $fundingdata
            );
            $header_data['title'] = 'Applied Inventing';
        } catch (Exception $e) {
            throw new CustomException($e->getMessage());
        }
        return view('applied_fund_car_view', compact('compact_array', 'header_data'));
    }

    /*
     * The Function name biddingCar 
     * Bidding the auction cars from listing page, saved car page and detailed view page
     */

    public function bidding_car() {
        $id = session::get('ses_id');
        $dealer_id = Input::get('dealer_id');
        $car_id = Input::get('car_id');
        $bidded_amount = Input::get('bidded_amount');
        $dealer_schemaname = $this->dealer_schemaname;
        $dms_dealers_tablename = 'dms_dealers';
        $to_dealer_id_fetch = $fetch_master_todealer = buyymodel::masterFetchTableDetails($id, $dms_dealers_tablename, array('d_id' => $dealer_id));
        $to_dealer_email = $to_dealer_id_fetch[0]->d_email;
        $to_dealer_mobile = $to_dealer_id_fetch[0]->d_mobile;
        $to_dealer_schema_name = $to_dealer_id_fetch[0]->dealer_schema_name;

        $currentdate = Carbon::now();
        $bidPrefix = Config::get('common.bidPrefix');
        $ticket_id = $bidPrefix . $currentdate->format('Ymdhis');

        $insertrecord = array('dealer_id' => $dealer_id,
            'car_id' => $car_id,
            'bidded_amount' => $bidded_amount,
            'ticket_id' => $ticket_id,
            'user_id' => $id,
            'created_date' => date('Y-m-d h:i:s'));
        $tablename = 'dealer_bidding_details';
        buyymodel::dealerInsertTable($id, $dealer_schemaname, $tablename, $insertrecord);

        buyymodel::masterInsertTable($id, $tablename, $insertrecord);

        $notificationtablename = 'dealer_system_notifications';
        $bidding_notification_type_id = config::get('common.bidding_notification_type_id');
        $notification_type = notificationsmodel::get_notification_dealer_type($bidding_notification_type_id);
        $notificationinsert = array('user_id' => $id,
            'd_id' => Input::get('dealer_id'),
            'notification_type_id' => $bidding_notification_type_id,
            'title' => '',
            'notification_type' => $notification_type[0]->notification_type_name,
            'message' => '',
            'status' => 1
        );



        notificationsmodel::dealer_notification_insert($to_dealer_schema_name, $notificationinsert);
    }

    /*
     * The Function name biddingList 
     * Bidded car view and status of auctions
     */

    public function bidding_list() {
        try {
            $id = session::get('ses_id');
            $dealer_schemaname = $this->dealer_schemaname;
            $queryfetch = buyymodel::dealerBiddingDetail($dealer_schemaname);
            $car_id_array = array();
            $car_id = '';
            $data = array();
            $biddingdata = array();
            $listing_wherecondition = array();
            $listing_orwherecondition = array();
            foreach ($queryfetch as $key) {
                $car_id = (string) $key->car_id;
                $listing_wherecondition['listing_id'] = array($car_id);
                $mongo_carlisting_details = buyymodel::mongoListingFetchwithqueries($id, $listing_wherecondition, $listing_orwherecondition);

                foreach ($mongo_carlisting_details as $userkey => $uservalue) {
                    $data['dealer_id'] = $key->dealer_id;
                    $data['car_id'] = $uservalue['listing_id'];

                    $data['noimages'] = count($uservalue["photos"]);
                    $photos_array = array();

                    if (count($uservalue["photos"]) > 0) {
                        foreach ($uservalue["photos"] as $photokey => $photovalue) {
                            $photos_array[] = $photovalue['s3_bucket_path'];
                        }
                        $data['imagelink'] = $photos_array[0];
                    } else {
                        $carnoimage = Config::get('common.carnoimage');
                        $data['imagelink'] = $carnoimage;
                    }
                    //$data['imagelink'] = $uservalue['car_id'];
                    $data['make'] = $uservalue['make'];
                    $data['model'] = $uservalue['model'];
                    $data['variant'] = $uservalue['variant'];
                    $data['bidded_amount'] = $key->bidded_amount;
                    array_push($biddingdata, $data);
                }
            }

            $header_data = $this->header_data;
            $compact_array = array('active_menu_name' => $this->active_menu_name,
                'left_menu' => 4,
                'biddingdata' => $biddingdata
            );
            $header_data['title'] = 'Bidding List';
        } catch (Exception $e) {
            throw new CustomException($e->getMessage());
        }
        return view('bidding_list', compact('compact_array', 'header_data'));
    }

    /*
     * The Function name biddingGridView 
     * List of bids of car
     */

    public function biddingGridView() {
        $id = session::get('ses_id');
        $car_id = Input::get('car_id');
        $bidding_wherecondition = array('car_id' => $car_id);
        $bidding_list = buyymodel::masterBiddingDetail($bidding_wherecondition);
        $data = array();
        $bidding_data = array();
        $dms_dealers_tablename = 'dms_dealers';
        if (!empty($bidding_list)) {
            foreach ($bidding_list as $biddedkey) {
                $get_dealer_name = buyymodel::masterFetchTableDetails($id, $dms_dealers_tablename, array('d_id' => $biddedkey->user_id));
                $dealer_name = $get_dealer_name[0]->dealer_name;

                $result = commonmodel::maskingWithX($dealer_name);
                $data['dealer_name'] = $result;
                $data['bidded_amount'] = $biddedkey->bidded_amount;
                $data['bidded_datetime'] = $biddedkey->delear_datetime;
                array_push($bidding_data, $data);
            }
        }
        return view('biddingload', compact('bidding_data'));
    }

    /*
     * The Function name saveCar 
     * Save the car from listing and detail views
     */

    public function save_car() {
        $id = session::get('ses_id');
        $car_id = Input::get('carid');

        $dealer_schemaname = $this->dealer_schemaname;

        $dealer_saved_cars_tablename = 'dealer_saved_carlisting';
        $saveddata = array('car_id' => $car_id);
        $saved_dealer_car = buyymodel::dealerTableCount($id, $dealer_schemaname, $dealer_saved_cars_tablename, $saveddata);

        if ($saved_dealer_car <= 0) {
            $insertrecord = array('dealer_id' => $id,
                'car_id' => $car_id,
                'created_date' => date('Y-m-d h:i:s'),
                'saved_status' => '1');
            buyymodel::dealerInsertTable($id, $dealer_schemaname, $dealer_saved_cars_tablename, $insertrecord);

            return '1';
        } else {
            $saved_status = array('saved_status' => '1',
                'car_id' => $car_id
            );
            $saved_dealer_car_status = buyymodel::dealerTableCount($id, $dealer_schemaname, $dealer_saved_cars_tablename, $saved_status);
            if ($saved_dealer_car_status <= 0) {
                $saved_status_update = array('saved_status' => '1');
                $saved_dealer_car_status = buyymodel::dealerUpdateTableDetails($id, $dealer_schemaname, $dealer_saved_cars_tablename, $saveddata, $saved_status_update);

                return '1';
            } else {
                $saved_status_update = array('saved_status' => '0');
                $saved_dealer_car_status = buyymodel::dealerUpdateTableDetails($id, $dealer_schemaname, $dealer_saved_cars_tablename, $saveddata, $saved_status_update);
                return '0';
            }
        }
    }

    /*
     * The Function name viewSavedCars 
     * List of saved cars
     */

    public function view_savedcars() {
        try {
            $id = session::get('ses_id');
            $dealer_schemaname = $this->dealer_schemaname;
            $saved_tablename = 'dealer_saved_carlisting';
            $wherecondition = array('saved_status' => 1);
            $queryfetch = buyymodel::dealerFetchTableDetailswithpaginate($id, $dealer_schemaname, $saved_tablename, $wherecondition);
            $car_id_array = array();
            $data = array();
            $saveddata = array();
            $listing_wherecondition = array();
            $listing_orwherecondition = array();
            $paginatelink = $queryfetch->links();
            foreach ($queryfetch as $key) {
                $car_id_array[] = $key->car_id;
            }

            if (!empty($car_id_array)) {
                $listing_wherecondition['listing_id'] = $car_id_array;

                $mongo_carlisting_details = buyymodel::mongoListingFetchwithqueries($id, $listing_wherecondition, $listing_orwherecondition);
            } else {
                $mongo_carlisting_details = array();
            }
            $saveddata = $this->searchcarlistingarraybulider($mongo_carlisting_details);


            $header_data = $this->header_data;
            $compact_array = array('active_menu_name' => $this->active_menu_name,
                'left_menu' => 2,
                'listing_details' => $saveddata
            );

            $header_data['title'] = 'Saved Car';
        } catch (Exception $e) {
            throw new CustomException($e->getMessage());
        }
        return view('saved_car_listing', compact('compact_array', 'header_data', 'paginatelink'));
    }

    /*
     * The Function name Alert Car 
     * Save the car from listing and detail views
     */

    public function doalertlisting() {
        $id = session::get('ses_id');
        $listingid = Input::get('listingid');
        $make = Input::get('make');
        $model_name = Input::get('model_name');
        $variant = Input::get('variant');
        $regyear = Input::get('regyear');
        $fuel = Input::get('fuel');
        $city_name = Input::get('city_name');
        if (Input::has('alert_type')) {
            $alert_type = Input::get('alert_type');
        } else {
            $alert_type = 'Search';
        }
        $dealer_schemaname = $this->dealer_schemaname;
        $dealer_alert_tablename = 'dealer_alert_history';
        $saveddata = array('alert_type' => $alert_type, 'alert_listingid' => $listingid, 'alert_user_id' => $id);
        $dms_dealers_tablename = 'dms_dealers';
        $to_get_dealer_details = buyymodel::masterFetchTableDetails($id, $dms_dealers_tablename, array('d_id' => $id));
        $dealeremail = $to_get_dealer_details[0]->d_email;
        $dealermobile = $to_get_dealer_details[0]->d_mobile;
        $saved_dealer_car = buyymodel::dealerTableCount($id, $dealer_schemaname, $dealer_alert_tablename, $saveddata);

        if ($saved_dealer_car <= 0) {
            $insertrecord = array('alert_listingid' => $listingid,
                'alert_user_id' => $id,
                'alert_make' => $make,
                'alert_model' => $model_name,
                'alert_variant' => $variant,
                'alert_year' => $regyear,
                'alert_fueltype' => $fuel,
                'alert_city' => $city_name,
                'alert_type' => $alert_type,
                'alert_status' => 1,
                'alert_usermailid' => $dealeremail,
                'alert_mobileno' => $dealermobile
            );

            $Insertalert = buyymodel::dealerInsertTable($id, $dealer_schemaname, $dealer_alert_tablename, $insertrecord
            );
            $Insertalert = buyymodel::masterInsertTable($id, $dealer_alert_tablename, $insertrecord
            );

            return '1';
        } else {
            $saved_status = array('alert_listingid' => $listingid, 'alert_user_id' => $id, 'alert_status' => 1);
            $saved_dealer_car_status = buyymodel::dealerTableCount($id, $dealer_schemaname, $dealer_alert_tablename, $saved_status);
            if ($saved_dealer_car_status <= 0) {
                $saved_status_update = array('alert_status' => '1');
                buyymodel::dealerUpdateTableDetails($id, $dealer_schemaname, $dealer_alert_tablename, $saveddata, $saved_status_update);

                buyymodel::masterupdateDetail($dealer_alert_tablename, $saveddata, $saved_status_update);
                return '1';
            } else {
                $saved_status_update = array('alert_status' => '0');
                $saved_dealer_car_status = buyymodel::dealerUpdateTableDetails($id, $dealer_schemaname, $dealer_alert_tablename, $saveddata, $saved_status_update);
                buyymodel::masterupdateDetail($dealer_alert_tablename, $saveddata, $saved_status_update);
                return '0';
            }
        }
    }

    public function doview_recentcars() {
        try {
            $id = session::get('ses_id');
            $dealer_schemaname = $this->dealer_schemaname;
            $saved_tablename = 'dealer_viewed_cars';
            $wherecondition = array('dealer_id' => $id);
            $queryfetch = buyymodel::dealerRecentDetails($id, $dealer_schemaname);
            $car_id_array = array();
            $data = array();
            $saveddata = array();
            $listing_wherecondition = array();
            $listing_orwherecondition = array();
            foreach ($queryfetch as $key) {
                $car_id_array[] = $key->car_id;
            }

            if (!empty($car_id_array)) {
                $listing_wherecondition['listing_id'] = $car_id_array;

                $mongo_carlisting_details = buyymodel::mongoListingFetchwithqueries($id, $listing_wherecondition, $listing_orwherecondition);
            } else {
                $mongo_carlisting_details = array();
            }
            $saveddata = $this->searchcarlistingarraybulider($mongo_carlisting_details);


            $header_data = $this->header_data;
            $compact_array = array('active_menu_name' => $this->active_menu_name,
                'left_menu' => 0,
                'saveddata' => $saveddata
            );

            $header_data['title'] = 'Recent Viewed Listings';
        } catch (Exception $e) {
            throw new CustomException($e->getMessage());
        }
        return view('recent_car_listing', compact('compact_array', 'header_data'));
    }

    /*
     * The Function name Compare Listing 
     * Save the car from listing and detail views
     */

    public function docomparelisting() {
        $id = session::get('ses_id');
        $listingid = Input::get('listingid');

        $dealer_schemaname = $this->dealer_schemaname;

        $dealer_compare_tablename = 'dealer_compare_listing';
        $saveddata = array('listing_id' => $listingid);
        $saved_dealer_car = buyymodel::dealerTableCount($id, $dealer_schemaname, $dealer_compare_tablename, $saveddata);

        if ($saved_dealer_car <= 0) {
            $insertrecord = array('dealer_id' => $id,
                'listing_id' => $listingid,
                'created_date' => date('Y-m-d h:i:s'),
                'status' => 1
            );
            buyymodel::dealerInsertTable($id, $dealer_schemaname, $dealer_compare_tablename, $insertrecord);

            return '1';
        } else {
            $saved_status = array('status' => 1,
                'listing_id' => $listingid
            );
            $saved_dealer_car_status = buyymodel::dealerTableCount($id, $dealer_schemaname, $dealer_compare_tablename, $saved_status);
            if ($saved_dealer_car_status <= 0) {
                $saved_status_update = array('status' => 1);
                $saved_dealer_car_status = buyymodel::dealerUpdateTableDetails($id, $dealer_schemaname, $dealer_compare_tablename, $saveddata, $saved_status_update);

                return '1';
            } else {
                $saved_status_update = array('status' => 0);
                $saved_dealer_car_status = buyymodel::dealerUpdateTableDetails($id, $dealer_schemaname, $dealer_compare_tablename, $saveddata, $saved_status_update);
                return '0';
            }
        }
    }

    public function docompare() {
        try {
            $id = Session::get('ses_id');
            //print_r($_POST);
            $compare_data_post = Input::get('compare_data_text');

            $compare_data_post_exp = explode(",", $compare_data_post);

            $dealer_schemaname = $this->dealer_schemaname;
            $saved_tablename = 'dealer_compare_listing';
            $wherecondition = array('status' => 1);

            //$queryfetch             = buyymodel::dealerFetchTableDetails($id,$dealer_schemaname,$saved_tablename,$wherecondition);
            $listing_wherecondition = array();
            $listing_orwherecondition = array();
            $compare_data = array();

            $countlisting = 0;
            foreach ($compare_data_post_exp as $key => $value) {
                $car_id_array = (string) $value;
                if ($car_id_array != '') {
                    $countlisting++;
                    $listing_wherecondition['listing_id'] = array($car_id_array);
                    $mongo_carlisting_details = buyymodel::mongoListingFetchwithqueries($id, $listing_wherecondition, $listing_orwherecondition);
                    $variant_table = 'master_variants';
                    $variantcondition = array('variant_id' => $mongo_carlisting_details[0]->variant_id);
                    $variantfetch = buyymodel::masterFetchTableDetails($id, $variant_table, $variantcondition);

                    $feature_table = 'master_car_features';

                    $featurefetch = buyymodel::masterFetchTableDetails($id, $feature_table, $variantcondition);

                    //Top Data
                    $compare_data['listingname'][] = $mongo_carlisting_details[0]->make . ' ' . $mongo_carlisting_details[0]->model . ' ' . $mongo_carlisting_details[0]->variant . ' ' . $mongo_carlisting_details[0]->registration_year . ' ';
                    $compare_data['listingprice'][] = number_format($mongo_carlisting_details[0]->sell_price);
                    $compare_data['listingid'][] = $mongo_carlisting_details[0]->listing_id;

                    $photos_array = array();
                    $imagename = array();
                    if (count($mongo_carlisting_details[0]->photos) > 0) {
                        foreach ($mongo_carlisting_details[0]->photos as $photokey => $photovalue) {
                            $photos_array[] = $photovalue['s3_bucket_path'];
                            $imagename[] = $photovalue['profile_pic_name'];
                            //$compare_data['viewimagelinks'][] = $photos_array;
                        }
                        $dataimagelinks = $photos_array[0];
                    } else {
                        $carnoimage = Config::get('common.carnoimage');
                        $dataimagelinks = $carnoimage;
                    }
                    //Overview
                    $compare_data['countphoto'][] = count($mongo_carlisting_details[0]->photos);
                    $compare_data['viewimagelinks'][] = $photos_array;
                    $compare_data['viewimagenames'][] = $imagename;
                    $compare_data['mainimagelinks'][] = $dataimagelinks;
                    $compare_data['ex-showroomprice'][] = '-';
                    $compare_data['registration_city'][] = $mongo_carlisting_details[0]->car_locality;
                    $compare_data['model_year'][] = $mongo_carlisting_details[0]->registration_year;
                    $compare_data['noofowners'][] = $mongo_carlisting_details[0]->owner_type;
                    $compare_data['kms_driven'][] = $mongo_carlisting_details[0]->kilometer_run;
                    $compare_data['fuel_type'][] = $mongo_carlisting_details[0]->fuel_type;
                    $compare_data['mileagecity'][] = $mongo_carlisting_details[0]->mileage;
                    $compare_data['mileagehighway'][] = $mongo_carlisting_details[0]->mileage;
                    $compare_data['transmission'][] = $mongo_carlisting_details[0]->transmission;
                    if (count($mongo_carlisting_details[0]->documents) > 0) {
                        $compare_data['insurance'][] = 'Yes';
                    } else {
                        $compare_data['insurance'][] = 'No';
                    }
                    $compare_data['finance'][] = '-';

                    //Specification
                    $compare_data['colors'][] = $mongo_carlisting_details[0]->colors;
                    $compare_data['Gear_box'][] = commonmodel::doreplacetoNA($mongo_carlisting_details[0]->gear_box);
                    $compare_data['Drive_Type'][] = commonmodel::doreplacetoNA($mongo_carlisting_details[0]->drive_type);
                    $compare_data['seatingcapacity'][] = $mongo_carlisting_details[0]->seating_capacity;
                    $compare_data['Steering_type'][] = commonmodel::doreplacetoNA($mongo_carlisting_details[0]->steering_type);
                    $compare_data['Turning_Radius'][] = commonmodel::doreplacetoNA($mongo_carlisting_details[0]->turning_radius);
                    $compare_data['Top_Speed'][] = commonmodel::doreplacetoNA($mongo_carlisting_details[0]->top_speed);
                    $compare_data['Acceleration'][] = commonmodel::doreplacetoNA($mongo_carlisting_details[0]->acceleration);
                    $compare_data['Tyre_Type'][] = commonmodel::doreplacetoNA($mongo_carlisting_details[0]->tyre_type);
                    $compare_data['No_of_Doors'][] = commonmodel::doreplacetoNA($mongo_carlisting_details[0]->no_of_doors);

                    //Engine
                    $compare_data['Engine_Type'][] = commonmodel::doreplacetoNA($mongo_carlisting_details[0]->engine_type);
                    $compare_data['engine_displacement'][] = commonmodel::doreplacetoNA($mongo_carlisting_details[0]->displacement);
                    $compare_data['max_power'][] = commonmodel::doreplacetoNA($mongo_carlisting_details[0]->max_power);
                    $compare_data['max_torque'][] = commonmodel::doreplacetoNA($mongo_carlisting_details[0]->max_torque);
                    $compare_data['No_of_Cylinders'][] = commonmodel::doreplacetoNA($mongo_carlisting_details[0]->no_of_cylinder);
                    $compare_data['Valves_Per_Cylinder'][] = commonmodel::doreplacetoNA($mongo_carlisting_details[0]->valves_per_cylinder);
                    $compare_data['Valves_configure'][] = commonmodel::doreplacetoNA($mongo_carlisting_details[0]->valve_configuration);
                    $compare_data['Fuel_Supply_System'][] = commonmodel::doreplacetoNA($mongo_carlisting_details[0]->fuel_supply_system);
                    $compare_data['Turbo_Charger'][] = commonmodel::doreplacetoNA($mongo_carlisting_details[0]->turbo_charger);
                    $compare_data['Super_Charger'][] = commonmodel::doreplacetoNA($mongo_carlisting_details[0]->super_charger);

                    //Dimensions
                    $compare_data['Length'][] = commonmodel::doreplacetoNA($mongo_carlisting_details[0]->length);
                    $compare_data['Width'][] = commonmodel::doreplacetoNA($mongo_carlisting_details[0]->width);
                    $compare_data['Height'][] = commonmodel::doreplacetoNA($mongo_carlisting_details[0]->height);
                    $compare_data['Wheel_Base'][] = commonmodel::doreplacetoNA($mongo_carlisting_details[0]->wheel_base);
                    $compare_data['Gross_Weight'][] = commonmodel::doreplacetoNA($mongo_carlisting_details[0]->gross_weight);

                    //Interior Features
                    $compare_data['air_conditioner'][] = $mongo_carlisting_details[0]->air_conditioner;
                    $compare_data['steering_adjustment'][] = $mongo_carlisting_details[0]->adjustable_steering;
                    $compare_data['Leather_Steering_Wheel'][] = $mongo_carlisting_details[0]->leather_steering_wheel;
                    $compare_data['Heater'][] = $mongo_carlisting_details[0]->heater;
                    $compare_data['Digital_Clock'][] = $mongo_carlisting_details[0]->digital_clock;

                    //Comfort
                    $compare_data['Power_Steering'][] = $mongo_carlisting_details[0]->power_steering;
                    $compare_data['Power_windows_front'][] = $mongo_carlisting_details[0]->power_windows_front;
                    $compare_data['Power_windows_rear'][] = $mongo_carlisting_details[0]->power_windows_rear;
                    $compare_data['Remote_Trunk_Opener'][] = $mongo_carlisting_details[0]->remote_trunk_opener;
                    $compare_data['Remote_Fuel_Lid_Opener'][] = $mongo_carlisting_details[0]->remote_fuel_lid_opener;
                    $compare_data['Low_Fuel_Warning_Light'][] = $mongo_carlisting_details[0]->low_fuel_warning_light;
                    $compare_data['Rear_Reading_Lamp'][] = $mongo_carlisting_details[0]->rear_reading_lamp;
                    $compare_data['Rear_Seat_Headrest'][] = $mongo_carlisting_details[0]->rear_seat_headrest;
                    $compare_data['Rear_Seat_Center_Arm_Rest'][] = $mongo_carlisting_details[0]->rear_seat_centre_arm_rest;
                    $compare_data['Height_Adjustable_Front_Seat_Belts'][] = $mongo_carlisting_details[0]->height_adjustable_front_seat_belts;
                    $compare_data['Cup_Holders_Front'][] = $mongo_carlisting_details[0]->cup_holders_front;
                    $compare_data['Cup_Holders_Rear'][] = $mongo_carlisting_details[0]->cup_holders_rear;
                    $compare_data['Rear_A_C_Vents'][] = $mongo_carlisting_details[0]->rear_ac_vents;
                    $compare_data['Parking_Sensors'][] = $mongo_carlisting_details[0]->parking_sensors;

                    //Safety
                    $compare_data['Anti_Lock_Braking_System'][] = $mongo_carlisting_details[0]->anti_lock_braking_system;
                    $compare_data['Central_Locking'][] = $mongo_carlisting_details[0]->central_locking;
                    $compare_data['Child_Safety_Locks'][] = $mongo_carlisting_details[0]->child_safety_lock;
                    $compare_data['Driver_Airbag'][] = $mongo_carlisting_details[0]->driver_airbags;
                    $compare_data['Passenger_Airbag'][] = $mongo_carlisting_details[0]->passenger_airbag;
                    $compare_data['Rear_Seat_Belts'][] = $mongo_carlisting_details[0]->rear_seat_belts;
                    $compare_data['Seat_Belt_Warning'][] = $mongo_carlisting_details[0]->seat_belt_warning;
                    $compare_data['Adjustable_Seats'][] = $mongo_carlisting_details[0]->adjustable_seats;
                    $compare_data['Crash_Sensor'][] = $mongo_carlisting_details[0]->crash_sensor;
                    $compare_data['Anti_Theft_Alarm'][] = $mongo_carlisting_details[0]->anti_theft_device;
                    $compare_data['Engine_Immobilizer'][] = $mongo_carlisting_details[0]->immobilizer;
                    //Exterior
                    $compare_data['Adjustable_Head_lights'][] = $mongo_carlisting_details[0]->adjustable_head_lights;
                    $compare_data['Power_adjustable_exterior_rear_view_mirror'][] = $mongo_carlisting_details[0]->power_adjustable_exterior_rear_view_mirror;
                    $compare_data['Electric_folding_rear_view_mirror'][] = $mongo_carlisting_details[0]->electric_folding_rear_view_mirror;
                    $compare_data['Rain_sensing_wipers'][] = $mongo_carlisting_details[0]->rain_sensing_wipers;
                    $compare_data['Rear_window_wiper'][] = $mongo_carlisting_details[0]->rear_window_wiper;
                    $compare_data['Alloy_wheels'][] = $mongo_carlisting_details[0]->alloy_wheels;
                    $compare_data['Tinted_glass'][] = $mongo_carlisting_details[0]->tinted_glass;
                    $compare_data['Front_fog_lights'][] = $mongo_carlisting_details[0]->front_fog_lights;
                    //$compare_data['Rear_window_wiper'][]=$mongo_carlisting_details[0]->rear_window_wiper;
                    $compare_data['Rear_window_defogger'][] = $mongo_carlisting_details[0]->rear_window_defogger;
                    //Entertainment
                    $compare_data['CD_Player'][] = $mongo_carlisting_details[0]->cdplayer;
                    $compare_data['FM_AM_Radio'][] = $mongo_carlisting_details[0]->radio;
                    $compare_data['Audio_System_Remote_Control'][] = $mongo_carlisting_details[0]->audio;
                    $compare_data['Bluetooth_Connectivity'][] = $mongo_carlisting_details[0]->bluetooth;
                }
            }
            if ($countlisting >= 4) {
                $divclass = 'rightcomparefour';
            } elseif ($countlisting == 3) {
                $divclass = 'rightcomparethree';
            } else {
                $divclass = 'rightcomparetwo';
            }

            $header_data = $this->header_data;
            $left_menu = '1';
            $compact_array = array('active_menu_name' => $this->active_menu_name,
                'left_menu' => 0,
                'compare_data' => $compare_data,
                'compare_class' => $divclass
            );
            $header_data['title'] = 'Compare Listing';
        } catch (Exception $e) {
            throw new CustomException($e->getMessage());
        }
        return view('compare', compact('compact_array', 'header_data'));
    }

    /*
     * The Function name saveCar 
     * Save the car from listing and detail views
     */

    public function report_listing() {
        $id = session::get('ses_id');
        $car_id = Input::get('carid');
        $report_listing_type_type_id = Input::get('report_listing_type_type_id');
        $reported_dealer_id = Input::get('dealer_id');
        $dealer_schemaname = $this->dealer_schemaname;
        $returncar = mongomodel::where('listing_id',$car_id)->get();

        $dealer_saved_cars_tablename = 'dealer_reported_listings';
        $saveddata = array('dealer_listing_id' => $car_id, 'dealer_id' => $id, 'reported_dealer_id' => $reported_dealer_id);
        $saved_dealer_car = buyymodel::masterFetchTableDetails($id, $dealer_saved_cars_tablename, $saveddata);
        $insertrecord = array('dealer_id' => $id,
            'dealer_listing_id' => $car_id,
            'report_listing_type_type_id' => $report_listing_type_type_id,
            'reported_dealer_id' => $reported_dealer_id);

        if($report_listing_type_type_id == 1)
        {
            $reportListingType = "Car Not Available";
        }
        elseif($report_listing_type_type_id == 2)
        {
            $reportListingType = "Inaccurate Price";   
        }
        elseif($report_listing_type_type_id == 3)
        {
            $reportListingType = "Scam";   
        }
        elseif($report_listing_type_type_id == 4)
        {
            $reportListingType = "Others";   
        }
        else
        {
            $reportListingType = "";   
        }



        $dealerDetails = dealermodel::dealerfetch($reported_dealer_id);
        if(count($dealerDetails)>0){
        $reportedDealerName = $dealerDetails[0]->dealer_name;
        $reportedEmail = $dealerDetails[0]->d_email;
        }
        else
        {
            $reportedDealerName = 'Murthy';
            $reportedEmail = 'naveen@falconnect.in';
        }
        

        //Mail Send Start
                        
                        $maildata = array(  '0' => $reportedDealerName,
                                            '1' => $car_id,
                                            '2' => $reportListingType,
                                            '3' => $returncar[0]->model,
                                            '4' => $returncar[0]->variant,
                                            '5' => $returncar[0]->registration_year
                                            );

                        $listingreport_email_id = config::get('common.listingreport_email_id');
                        $email_template_data = emailmodel::get_email_templates($listingreport_email_id);

                        foreach ($email_template_data as $row) {
                            $mail_subject = $row->email_subject;
                            $mail_message = $row->email_message;
                            $mail_params = $row->email_parameters;
                        }
                        $email_template = emailmodel::emailContentConstruct($mail_subject, $mail_message, $mail_params, $maildata);
                        
                        $email_sent = emailmodel::email_sending($reportedEmail, $email_template);

        if (count($saved_dealer_car) <= 0) {

            buyymodel::masterInsertTable($id, $dealer_saved_cars_tablename, $insertrecord);

            return '1';
        } else {


            $saved_dealer_car_status = buyymodel::masterupdateDetail($dealer_saved_cars_tablename, $saveddata, $insertrecord);

            return '0';
        }
    }

    public function doregisterApplyfundingBuy(Request $request) {
        try {
            // $messsages    =   array(
            //       'dealershipname' => 'DealerShip Name',
            //       'ownerid' => 'Owner Id',
            //       'dealername' => 'Dealername',
            //       'emailid' => 'EmailId',
            //       'date' => 'Date',
            //       'place' => 'Place',
            //       'listingid' => 'Listingid',
            //       'make' => 'Make Name',
            //       'model_name' => 'Model Name',
            //       'variant' => 'Variant Name',
            //       'fundingamount' => 'Funding Amount',
            //       'mobilenumber' => 'Mobile Number'
            //     );
            //   $validationcheck  = Validator::make($request->all(),[
            //       'dealershipname' => 'required',
            //       'ownerid' => 'required',
            //       'dealername' => 'required',
            //       'emailid' => 'required|email',
            //       'date' => 'required',
            //       'place' => 'required',
            //       'listingid' => 'required',
            //       'make' => 'required',
            //       'model_name' => 'required',
            //       'variant' => 'required',
            //       'fundingamount' => 'required',
            //       'mobilenumber' => 'required|max:12'
            //   ],$messsages);
            //   if ($validationcheck->fails())
            //   {
            //     $result['message'] = "Funding Applied Failed Please Try Again";
            //     return response()->json($result);
            //   }            
            $id = Session::get('ses_id');
            $dealershipname = input::get('dealershipname');
            $ownerid = input::get('ownerid');
            $dealername = input::get('dealername');
            $emailid = input::get('emailid');
            $mobilenumber = input::get('mobilenumber');
            $date = input::get('date');
            $place = input::get('place');
            $fundingamount = input::get('fundingamount');
            $carid = input::get('carid');
            $listingid = input::get('listingid');
            $makename = input::get('make');
            $modelname = input::get('model_name');
            $variantname = input::get('variant');
            $ownermail = input::get('ownermail');
            $ownername = input::get('ownername');
            $originalfundingamount = input::get('originalfundingamount');
            
            if($originalfundingamount >= $fundingamount)
            {
              
            }
            else
            {
              $result['message'] = "Funding Amount is Exceeded";
              $result['success'] = "Funding Amount is Exceeded it should be less than or equal to ".$originalfundingamount."";
              
              return response()->json($result);
            }
            
            //getcity id
            //CHECK FUNDING TICKET ID IS EXIST OR NOT STRAT
            $fundingticketid    = "";
            $getfundingticketid = fundingmodel::doGetcardetailsfundingisexist($id, $listingid);

            if (!empty($getfundingticketid) && count($getfundingticketid)) {
                $fundingticketid = (count($getfundingticketid) >= 1 ? $getfundingticketid[0]->dealer_funding_ticket_id : '');
                $result['message']      =   "Funding Applied Successfully";
                $result['ticketid']     =   encrypt($fundingticketid);
                $result['fundticketid']     =   $fundingticketid;
                return response()->json($result);
            }
            
            $getcityname = fundingmodel::dogetcityidmaster($place);

            $cityid = ((count($getcityname) >= 1) ? $getcityname[0]->city_id : '');
            $ticketinsert = array('dealer_ticket_type_id' => 1,
                'dealer_id' => $id,
                'dealer_ticket_status_id' => 1
            );

            //GET DEALER DETAILS
            $dealer_wherecondition = array('d_id' => $id);
            $fetchupdate = fundingmodel::doGetmasterdetails('dms_dealers', $dealer_wherecondition
            );
            $dealer_profile_image = ((count($fetchupdate) >= 1) ? $fetchupdate[0]->logo : url(config::get('common.profilenoimage')));
            $from_email = ((count($fetchupdate) >= 1) ? $fetchupdate[0]->d_email : '');

            $dealer_wherecondition = array('dealer_id' => $id);
            $getdealeraddress = fundingmodel::dealerFetchTableDetails($this->dealer_schemaname, 'dms_dealerdetails', $dealer_wherecondition
            );
            $dealeraddress = ((count($getdealeraddress) >= 1) ? $getdealeraddress[0]->Address : '');

            $insertticketrequesttable = fundingmodel::doInsertTicketrequest($ticketinsert);
            if ($insertticketrequesttable >= 1) {
                //get last record for unique ticket creation
                $getlastid = fundingmodel::latest('dealer_funding_detail_id')
                                ->pluck('dealer_funding_detail_id')->first();
                $maketicketid = ($getlastid >= 1) ? ($getlastid + 1) : $insertticketrequesttable;
                $findingticketid = commonmodel::dodealercode() . '-F' . $maketicketid;
                $insertfundingdata = array('dealer_ticket_id' => $insertticketrequesttable,
                    'dealershipname' => $dealershipname,
                    'dealername' => $dealername,
                    'dealermobileno' => $mobilenumber,
                    'dealer_funding_ticket_id' => $findingticketid,
                    'dealermailid' => $emailid,
                    'city_id' => $cityid,
                    'dealercity' => $place,
                    'branch_id' => "",
                    'branchname' => "",
                    'requested_amount' => $fundingamount,
                    'created_date' => $date,
                    'user_id' => $id
                );
                $insertdealerfundingtable = fundingmodel::doInsertfundingapplyrequest($insertfundingdata);
                if ($insertdealerfundingtable >= 1) {
                    $insertfundingitems = array(
                        'dealer_funding_detail_id' => $insertdealerfundingtable,
                        'dealer_car_id' => $carid,
                        'dealer_listing_id' => $listingid,
                        'dealer_car_make_name' => $makename,
                        'dealer_car_model_name' => $modelname,
                        'dealer_car_variant_name' => $variantname,
                        'dealer_car_price' => $fundingamount
                    );
                    $insertdealerfundingitems = fundingmodel::doInsertFundingItems($insertfundingitems);
                    if ($insertdealerfundingitems >= 1) {
                        //get make,model,variant
                        $footeremailtemp = "";
                        $branchid = "";
                        $branchname = "";
                        if (!empty($listingid)) {
                            $carid = collect($listingid);
                            $getownerdetail = fundingmodel::doGetmasterdetails('dms_dealers', array('d_id' => $ownerid)
                            );
                            $dealerschemacon = ((count($getownerdetail) >= 1)?$getownerdetail[0]->dealer_schema_name:'');
                            $getmakemodel = fundingmodel::dealergetTodealerTable($dealerschemacon, $carid
                            );
                            if (!empty($getmakemodel) && count($getmakemodel) >= 1) {
                                $i = 1;
                                foreach ($getmakemodel as $value) {
                                    $imagefetch = fundingmodel::dealergetTodealerphotosTable($dealerschemacon,array('car_id' => $value->car_id)
                                    );
                                    $carimage = ((count($imagefetch) >= 1) ? $imagefetch[0]->s3_bucket_path : url(config::get('common.carnoimage')));
                                    $branchid = $value->branch_id;
                                    switch ($value->owner_type) {
                                        case 'FIRST':
                                            $owner_type = "1";
                                            break;
                                        case 'SECOND':
                                            $owner_type = "2";
                                            break;
                                        case 'THIRD':
                                            $owner_type = "3";
                                            break;
                                        case 'Fourth':
                                            $owner_type = "4";
                                            break;
                                        case 'Four +':
                                            $owner_type = "Above 4";
                                            break;
                                        default:
                                            $owner_type = "1";
                                            break;
                                    }
                                    $footeremailtemp .= '<tr><td>' . $i . '</td><td><img src="' . $carimage . '" alt="" class="img-responsive table-img"></td><td><p><b>' . $modelname . ' ' . $variantname . ' ' . $value->registration_year . '</b></p><p>Rs.' . $fundingamount . '</p><p class="list-detail"><span class="text-muted">' . $value->kms_done . ' km</span> | <span class="text-muted">' . $value->fuel_type . '</span> | <span class="text-muted">' . $value->registration_year . '</span> | <span class="text-muted">' . $owner_type . ' Owner</span></p></td></tr>';
                                    $i++;
                                }
                                //getbranchname
                                $getbranchname = fundingmodel::dealerFetchbranchname($this->dealer_schemaname, $branchid);
                                $branchname = ((count($getbranchname) >= 1) ? $getbranchname[0]->dealer_name : '');
                            }
                        }
                        $footeremailtemp .= '</tbody></table></div></div>';
                        //Mail Send Start
                        $maildata = array('0' => $findingticketid,
                            '1' => 'In Progress',
                            '2' => $dealer_profile_image,
                            '3' => $dealername,
                            '4' => $dealername,
                            '5' => $branchname,
                            '6' => $mobilenumber,
                            '7' => $dealeraddress
                        );

                        $queries_email_template_id = config::get('common.funding_email_template_id');
                        $email_template_data = emailmodel::get_email_templates($queries_email_template_id);

                        foreach ($email_template_data as $row) {
                            $mail_subject = $row->email_subject;
                            $mail_message = $row->email_message;
                            $mail_params = $row->email_parameters;
                        }
                        $email_template = emailmodel::emailContentConstructLoan($mail_subject, $mail_message, $mail_params, $maildata, $footeremailtemp);
                        $email_sent = emailmodel::email_sending($from_email, $email_template);
                        //$email_sent     = 	emailmodel::email_sending_cc($from_email,$email_template,$ownermail);
                        $result['message']      =   "Funding Applied Successfully";
                        $result['ticketid']     =   encrypt($findingticketid);
                        $result['fundticketid']     =   $findingticketid;
                        $dealer_info = dealermodel::dealerprofile(session::get('ses_id'));
                        $maildata = array($ownername,$listingid,session::get('ses_email'),$dealer_info->d_mobile);
                        $queries_email_template_id = config::get('common.funding_request');
                        $email_template_data = emailmodel::get_email_templates($queries_email_template_id);
                        foreach ($email_template_data as $row) {
                            $mail_subject = $row->email_subject;
                            $mail_message = $row->email_message;
                            $mail_params = $row->email_parameters;
                        }                        
                        $email_template = emailmodel::emailContentConstruct($mail_subject, $mail_message, $mail_params, $maildata);
                        $email_sent = emailmodel::email_sending($ownermail,$email_template);
                        return response()->json($result);
                    } else {
                        $result['message'] = "Funding Applied Failed Try Again";
                        return response()->json($result);
                    }
                }
            }
        } catch (Exception $e) {
            throw new CustomException($e->getMessage());
        }
    }

    public function autocompletecity(Request $request) {
        $term = $request->term;
        $id = '';
        $tablename = 'master_city';
        $wherecondition = array('city_name' => '%' . $term . '%');
        $data = buyymodel::masterfetchautocomplete($term);
        $result = array();
        foreach ($data as $key => $v) {
            $result[] = ['value' => $v->city_name];
        }
        return response()->json($result);
        //print_r($result);
        //$result=array();
    }

    public function shorturl() {
        $returndata = obv::obvprice();
        
        $returnjsondata = json_decode($returndata);
        dd($returnjsondata);
        //Good,Very Good,Excellent,Fair
        dd($returnjsondata->data->all_conditions->Excellent->range_from.'-'.$returnjsondata->data->all_conditions->Excellent->range_to);
        
    }

    public function sharelisting() {
        //dd($_POST);
        $id = Session::get('ses_id');
        $car_id = Input::get('car_id');
        $mailto = Input::get('mailto');
        $mailfrom = Input::get('mailfrom');
        $comments = Input::get('comments');
        $listing_wherecondition = array();
        $listing_orwherecondition = array();
        $listing_wherecondition['listing_id'] = array($car_id);
        $mongo_carlisting_details = buyymodel::mongoListingFetchwithqueries($id, $listing_wherecondition, $listing_orwherecondition);

        if (!empty($mongo_carlisting_details)) {
            $listing_link = url('guestlistingpage/' . $car_id);
            $shorturl = shortnerurl::shorturl($listing_link);
            foreach ($mongo_carlisting_details as $key) {
                $make = $key['make'];
                $sell_price = $key['sell_price'];
                $variant = $key['variant'];
                $model = $key['model'];
                $registration_year = $key['registration_year'];
                $car_locality = $key['car_locality'];
                $created_date = $key['created_at'];
                $listing_status = $key['listing_status'];
                $kilometer_run = $key['kilometer_run'];

                $owner_type = $key['owner_type'];
                $body_type = $key['body_type'];
                $sell_price = $key['sell_price'];

                $data['noimages'] = count($key["photos"]);
                $photos_array = array();

                if (count($key["photos"]) > 0) {
                    foreach ($key["photos"] as $photokey => $photovalue) {
                        $photos_array[] = $photovalue['s3_bucket_path'];
                    }
                    $imagelinks = $photos_array[0];
                } else {
                    $carnoimage = Config::get('common.carnoimage');
                    $imagelinks = $carnoimage;
                }

                $days = commonmodel::daysBetweenCurrentDate($created_date);
                if ($days <= 0) {
                    $daysstmt = 'Listed Today';
                } else {
                    $daysstmt = 'Listed ' . $days . ' day ago';
                }

                $productinfo = $model . ' ' . $variant . ' ' . $registration_year;
                $productcity = $car_locality;
                $noofdays = $daysstmt;
                $kmdone = $kilometer_run;
                $vehicletype = $body_type;
                $registrationyear = $registration_year;
                $noowner = $owner_type;
                $productprice = $sell_price;

                //print_r('<pre>');

                $maildata = array('', $imagelinks, $productinfo, $productcity, $noofdays, $kmdone, $vehicletype, $registrationyear, $noowner, $productprice, $shorturl, $comments);

                $queries_email_template_id = 14;
                $email_template_data = emailmodel::get_email_templates($queries_email_template_id);

                $send_email = $mailto;
                //$maildata[0]= $fetchdetails->contact_first_name;
                foreach ($email_template_data as $row) {
                    $mail_subject = $row->email_subject;
                    $mail_message = $row->email_message;
                    $mail_params = $row->email_parameters;
                }

                $email_template = emailmodel::emailContentConstruct($mail_subject, $mail_message, $mail_params, $maildata);
                $email_sent = emailmodel::email_sending($send_email, $email_template);

                //dd($maildata);
            }
        }
    }

}
