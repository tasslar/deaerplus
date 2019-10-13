<?php

/*
  Module Name : Alert
  Created By  : A.Ahila
  Use of this module is to show alert details

 */

namespace App\Http\Controllers;

use Session;
use Redirect;
use Request;
use App\model\dealermodel;
use App\model\commonmodel;
use App\model\alertmodel;
use App\Exceptions\CustomException;

class alert extends Controller {

    public function __construct() {
        $this->active_menu_name = 'buy_menu';
        $this->side_bar_active = '';
        $this->middleware(function ($request, $next) {
            $this->id = Session::get('ses_id');
            $this->p_id = dealermodel::parent_id($this->id);
            $this->login_authecation = Session()
                            ->has('ses_dealername') ? session()
                            ->get('ses_dealername') : Redirect::to('login')
                            ->send();
            $this->header_data = commonmodel::commonheaderdata();
            $this->header_data['title'] = '';
            $this->header_data['p_id'] = $this->p_id;
            return $next($request);
        }
        );
    }

    public function alertshow() {
        $this->active_menu_name = 'buy_menu';
        $header_data = $this->header_data;
        $header_data['title'] = 'Alert';
        try {
            $alertData = alertmodel::fetchAllAlert(Session::get('ses_id'));
            foreach ($alertData as $key) {
                $dname = dealermodel::dealerfetch($key->alert_source_dealer_id);
                if (count($dname) > 0) {
                    $key->dealername = $dname[0]->dealer_name;
                } else {
                    $key->dealername = "ALL";
                }
            }
            $compact_array = array(
                'active_menu_name' => $this->active_menu_name,
                'left_menu' => 6,
            );
        } catch (Exception $e) {
            throw new CustomException($e->getMessage());
        }
        return view('alert', compact('header_data', 'compact_array', 'alertData'));
    }

    public function changeAlertStatus() {
        $al_id = Request::input('stat_id');
        $al_val = Request::input('stat_val');
        $al_type = Request::input('stat_type');
        try {
            $update_id = alertmodel::updateAlertStatus($al_id, $al_val, $al_type);

            $getAlertDetails = alertmodel::getAlertDetails($al_id);
            alertmodel::updateAlertSchemaStatus($getAlertDetails[0]->alert_type, $getAlertDetails[0]->alert_listingid, $getAlertDetails[0]->alert_user_id,$al_val,$al_type);
            $schemaAlert = alertmodel::getSchemaAlert($getAlertDetails[0]->alert_type,$getAlertDetails[0]->alert_listingid,$getAlertDetails[0]->alert_user_id);

            if(($getAlertDetails[0]->alert_status == "0") && ($getAlertDetails[0]->alert_email_status == "0" ) && ($getAlertDetails[0]->alert_sms_status == "0") && ($schemaAlert[0]->alert_status == "0") && ($schemaAlert[0]->alert_email_status == "0") && ($schemaAlert[0]->alert_sms_status == "0"))
            {
                alertmodel::deleteSchemaAlert($getAlertDetails[0]->alert_type, $getAlertDetails[0]->alert_listingid,$getAlertDetails[0]->alert_user_id);
                alertmodel::deleteAlert($al_id);
            }
        } catch (Exception $e) {
            throw new CustomException($e->getMessage());
        }
        //dd($al_val);

        if ($update_id == 1) {
            $message = "success";
        } else {
            $message = "fail";
        }
        $ret_data = array(
            'update_id' => $update_id,
            'message' => $message
        );
        return \Response::json($ret_data);
    }

    public function deleteAlert() {
        $ses_id = Session::get('ses_id');
        $alert_id = Request::input('id');
        try {
            $del_id = alertmodel::delAlert($alert_id);
            $aler_count = alertmodel::countAllAlert($ses_id);
        } catch (Exception $e) {
            throw new CustomException($e->getMessage());
        }

        if ($del_id == 1) {
            $message = "success";
        } else {
            $message = "fail";
        }
        $ret_data = array(
            'del_id' => $del_id,
            'message' => $message,
            'aler_count' => $aler_count
        );
        return \Response::json($ret_data);
    }

}
