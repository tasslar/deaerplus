<?php

/*
  Module Name : Dealer
  Created By  : Ahila 01-12-2016 Version1.0
  Use of this module is My edit account , Dealer change password ,
  Dealer profile image upload.
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use Redirect;
use DB;
use Session;
use File;
use Exception;
use Cookie;
use DateTime;
use Validator;
use App\model\map;
use App\model\dealermodel;
use App\model\notificationsmodel;
use App\model\smsmodel;
use App\model\emailmodel;
use App\model\usersmodel;
use App\model\fileuploadmodel;
use App\model\commonmodel;
use App\model\schemaconnection;
use App\model\master_temp_register;
use App\Http\Requests\registervalidation;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\Handler;
use App\Http\Controllers\Api\api;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\CustomException;
use App\Http\Requests\changepassword;

class dealer extends Controller {

    public $side_bar_active;
    public $active_menu_name;
    public $change_password;
    public $login_authecation;
    public $p_id;
    public $id;

    public function __construct(Request $req) {
        $this->side_bar_active = 'profile';
        $this->active_menu_name = 'manage_menu';
        $this->change_password = 'change_password';
        $this->middleware(function ($request, $next) {
            $this->id = session::get('ses_id');
            $this->p_id = dealermodel::parent_id($this->id);
            $this->login_authecation = session()->has('ses_dealername') ? session()->get('ses_dealername') : Redirect::to('login')->send();
            $this->header_data = commonmodel::commonheaderdata();
            $this->header_data['title'] = 'Manage';
            $this->header_data['p_id'] = $this->p_id;
            ini_set("upload_max_filesize", "3000M");
            return $next($request);
        });
    }

    public function getmap() {
        $map = new map;
        $address = "45,4th cross street, sastri nagar,chennai";
        $resultmap = $map->get_lat_lon($address);
    }

    /* The function dealer_change_password show the dealer
     * Change password view
     */

    public function dealer_change_password() {
        $id = Session::get('ses_id');
        $ses_dealer_name = Session::get('ses_dealername');
        $ses_dealer_logo = Session::get('logo');
        $ses_dealer_schema = Session::get('dealer_schema_name');
        $header_data = commonmodel::commonheaderdata();
        $header_data['title'] = "Manage";
        $compact_array = array(
            'active_menu_name' => $this->active_menu_name,
            'side_bar_active' => 'change_password',
        );

        //Config::set('database.connections.dmsmysql.database', $ses_dealer_schema);

        $email_count = notificationsmodel::
                email_notification_count($ses_dealer_schema, $id);
        $header_data['email_count'] = $email_count;
        $header_data['p_id'] = $this->p_id;

        if (!empty(Session::get('ses_id'))) {

            return view('dealer_changepassword', compact('header_data', 'compact_array'));
        } else {
            return redirect('login');
        }
        $active_menu_name = 'dashboard_menu';
        return view('dealer_changepassword', compact('header_data', 'compact_array'));
    }

//The function dealer_change_password_process 
//used to change new password.
    public function dealer_change_password_process(Request $request) {

        $messsages = array(
            'oldpassword.required.min:8.max:16' => 'Oldpassword',
            'newpassword.required' => 'Password',
            'confirmnewpassword.required' => 'Confirm password',
        );
        $validator = Validator::make($request->all(), [
                    'oldpassword' => 'required|min:8|max:16',
                    'newpassword' => 'required|min:8|max:16',
                    'confirmnewpassword' => 'required|same:newpassword|min:8|max:16',], $messsages);

        if ($validator->fails()) {
            return redirect('dealerchangepassword')
                            ->withErrors($validator)
                            ->withInput();
        }
        $id = Session::get('ses_id');
        $ses_dealer_name = Session::get('ses_dealername');
        $ses_dealer_logo = Session::get('logo');
        $dealer_schema_name = Session::get('dealer_schema_name');


        if (!empty(Session::get('ses_id'))) {
            $oldpassword = Input::get('oldpassword');
            $newpassword = Input::get('newpassword');
            $confirm_password = Input::get('confirmnewpassword');
            if ($oldpassword == "" || $newpassword == "" || $confirm_password == "") {
                Session::flash('messageerr', "All fields are required.");
                return Redirect::back();
            } else {

                $selectdealer = dealermodel::select('d_password', 'dealer_schema_name')
                        ->where('d_id', "=", $id)
                        ->first();
                if ($selectdealer->d_password == $newpassword || $selectdealer->d_password == $confirm_password) {
                    Session::flash('messageerr', "Old and new password same!!");
                    return Redirect::back();
                } else {

                    if ($oldpassword == $selectdealer->d_password) {
                        if ($newpassword == $confirm_password) {

                            $affectedRows = dealermodel::where('d_id', '=', $id)->update(['d_password' => $confirm_password]);

                            Session::flash('message', "Successfully Password Updated.");
                            return Redirect::back();
                        } else {
                            Session::flash('messageerr', "Passwords Must Be Same!!");
                            return Redirect::back();
                        }
                    } else {
                        Session::flash('messageerr', "Incorrect Old Password!!");
                        return Redirect::back();
                    }
                }
            }
        } else {
            return redirect('login');
        }
    }

    /* The function cancel form clear all form data. */

    public function cancelform() {
        return Redirect::back();
    }

    /* The function myeditaccount to show  My edit account view 
     * With the existing data.
     */

    public function myeditaccount() {

        $id = Session::get('ses_id');
        $ses_dealer_name = Session::get('ses_dealername');
        $ses_dealer_logo = Session::get('logo');
        $dealer_schema_name = Session::get('dealer_schema_name');

        if (!empty(Session::get('ses_id'))) {
            try {

                $selectdealer = dealermodel::select('dealer_name', 'd_email', 'd_password', 'd_city', 'd_state', 'd_mobile', 'dealer_schema_name', 'logo')
                        ->where('d_id', "=", $id)
                        ->first();



                $dealerdata = dealermodel::dealerdetails_get($selectdealer->dealer_schema_name, $id);
            } catch (Exception $e) {
                throw new CustomException($e->getMessage());
            }
            if (count($dealerdata)) {

                foreach ($dealerdata as $dealer) {
                    $phone = $dealer->phone;
                    $pincode = $dealer->pincode;
                    $address = $dealer->Address;
                    $otherinformation = $dealer->otherinformation;
                    $dealer_logo = $dealer->logo;
                }
                $data = array(
                    'dealer_name' => $selectdealer->dealer_name,
                    'd_email' => $selectdealer->d_email,
                    'd_city' => $selectdealer->d_city,
                    'd_state' => $selectdealer->d_state,
                    'd_mobile' => $phone,
                    'pincode' => $pincode,
                    'address' => $address,
                    'otherinformation' => $otherinformation,
                    'logo' => $dealer_logo
                );
            } else {
                $data = array(
                    'dealer_name' => $selectdealer->dealer_name,
                    'd_email' => $selectdealer->d_email,
                    'd_mobile' => $selectdealer->d_mobile,
                    'pincode' => "",
                    'address' => "",
                    'd_state' => $selectdealer->d_state,
                    'd_city' => $selectdealer->d_city,
                    'otherinformation' => "",
                    'logo' => url(Config::get('common.profilenoimage'))
                );
                /* echo "<pre>";
                  print_r($data);
                  exit; */
            }

            $header_data = $this->header_data;
            $header_data['title'] = "Manage";
            $email_count = notificationsmodel::
                    email_notification_count($selectdealer->dealer_schema_name, $id);
            $header_data['email_count'] = $email_count;
            $city = commonmodel::get_master_city();
            $state = commonmodel::get_master_state();

            $compact_array = array
                (
                'active_menu_name' => $this->active_menu_name,
                'side_bar_active' => $this->side_bar_active,
                'city' => $city,
                'state' => $state,
                'selectdealer' => $selectdealer
            );

            return view('myeditaccount', compact('data', 'header_data', 'compact_array'));
        } else {
            return redirect('login');
        }
    }

    public function editaccount_state() {
        /* echo "<pre>";
          print_r($_POST);
          exit; */
        $state_id = Input::get('state');
        $city = commonmodel::get_master_states()->where('state_id', $state_id)->get();
        echo json_encode($city);
        /* echo "<pre>";
          print_r($city);
          exit; */
    }

    /* The function accounteditprocess to edit  the dealer details
     */

    public function accounteditprocess(Request $request) {


        $messsages = array(
            'mobile.required'               => 'Mobile No Required',
            'address.required'              => 'Address Required',
            'state.required'                => 'State Required',
            'city.required'                 => 'City Required',
            'pincode.required'              => 'Pincode Required',
        );
        $validator = Validator::make($request->all(), [
                    'mobile'  => 'required',
                    'address' => 'required',
                    'state'   => 'required',
                    'city'    => 'required',
                    'pincode' => 'required'], $messsages);

        if ($validator->fails()) {
            return redirect('myeditaccount')
                            ->withErrors($validator)
                            ->withInput();
        }


        $id = Session::get('ses_id');
        if (!empty(Session::get('ses_id'))) {
            $dealername = Input::get('fname');
            if ($dealername == '') {

                $dealername = "Please Enter The Dealer Name";
                Session::flash('message-err', $dealername);
                return Redirect::back();
            }
            $email = Input::get('email');
            $mobile = Input::get('mobile');
            $moblieno =  dealermodel::selectRaw("Count(*) as Total")
                                 ->where('d_mobile',$mobile)
                                 ->where('d_id','<>',session::get('ses_id'))
                                 ->first();                                 
            if(intval($moblieno->Total)>0)
            {
                Session::flash('message-err', "The Moble number already used");
                return Redirect::back();
            }

            $address = Input::get('address');
            $pincode = Input::get('pincode');
            $otherinformation = Input::get('otherinformation');
            $lat = Input::get('lat');
            $lon = Input::get('lon');
            $userimage = Input::file('userimage');
            $state = Input::get('state');
            $city = Input::get('city');
            $image_replace = Input::get('image_replace');
            $selectdealer = dealermodel::select('dealer_schema_name')
                    ->where('d_id', "=", $id)
                    ->first();
            $dealer = dealermodel::where('d_id', '=', $id)
                    ->update([
                'd_email' => $email,
                'dealer_name' => $dealername,
                'd_mobile' => $mobile,
                'd_city' => $city,
                'd_state' => $state
            ]);

            $user_data = array(
                'user_name' => $dealername,
                'user_moblie_no' => $mobile
            );

            $edit_user = usersmodel::user_table()->where('user_id', 1)->update($user_data);

            $dealerdata = dealermodel::dealerdetails_get($selectdealer->dealer_schema_name, $id);

            if (count($dealerdata)) {

                $dealerdata = array(
                    'dealer_id' => $id,
                    'phone' => $mobile,
                    'Address' => $address,
                    'pincode' => $pincode,
                    'otherinformation' => $otherinformation,
                    'latitude' => $lat,
                    'd_state' => $state,
                    'd_city' => $city,
                    'longitude' => $lon,
                );
                if ($image_replace) {
                    $master_img = schemaconnection::masterconnection()
                            ->table('dms_dealers')
                            ->where('d_id', '=', $id)
                            ->update(['logo' => $image_replace]);
                    session(['logo' => $image_replace]);
                }
                $detail_id = dealermodel::dealerdetails_update($selectdealer->dealer_schema_name, $dealerdata, $id);
            } else {
                $dealer_storedata = array('phone' => $mobile,
                    'Address' => $address,
                    'pincode' => $pincode,
                    'otherinformation' => $otherinformation,
                    'latitude' => $lat,
                    'longitude' => $lon,
                    'd_state' => $state,
                    'd_city' => $city,
                );

                if ($image_replace) {
                    $master_img = schemaconnection::masterconnection()
                            ->table('dms_dealers')
                            ->where('d_id', '=', $id)
                            ->update(['logo' => $image_replace]);
                    session(['logo' => $image_replace]);
                }
                $dealer_update = dealermodel::dealerdetails_store($selectdealer->dealer_schema_name, $dealer_storedata, $id);
            }
            session(['ses_dealername' => $dealername]);

            if ($userimage) {
                $file_extentions = Config::get('fileuploadrestrictions.userprofile_fileformat');
                $extension = $userimage->getClientOriginalExtension();
                $filesize = $userimage->getsize();
                /* dd($filesize); */
                if ($filesize <= 2097152) {
                    if (in_array($extension, $file_extentions)) {
                        $path = url('/profileimages/');
                        $path = public_path('profileimages/');
                        $dms_logo = fileuploadmodel::any_upload($userimage, $path);
                        /* print_r($dms_logo);
                          exit; */
                        if ($dms_logo == Config::get('common.fileresult')) {
                            /* echo "hi";
                              exit; */
                            return redirect('myeditaccount')->with('message-err', 'Invalid Filetype....');
                        } else {
                            $dealer_image = schemaconnection::dmsmysqlconnection()
                                    ->table('dms_dealerdetails')
                                    ->where('dealer_id', "=", $id)
                                    ->update(['logo' => url('profileimages/' . $dms_logo)]);
                            $master_img = schemaconnection::masterconnection()
                                    ->table('dms_dealers')
                                    ->where('d_id', '=', $id)
                                    ->update(['logo' => url('profileimages/' . $dms_logo)]);
                            session(['logo' => url('profileimages/' . $dms_logo)]);
                            return redirect('myeditaccount')->with('message', 'Your Details Updated Successfully.');
                        }
                    } else {
                        return redirect('myeditaccount')->with('message-err', 'Invalid Filetype.And Maximum file size is 2MB.');
                    }
                } else {
                    return redirect('myeditaccount')->with('message-err', 'Maximum file size is 2MB.');
                }
            }


            return redirect('myeditaccount')->with('message', 'Your Details Updated Successfully.');
        } else {
            return redirect('login');
        }
    }

}
