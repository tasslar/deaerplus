<?php

/*
	Module Name : Excel Export 
	Created By  : HARIKRISHNAN R  23-02-2017
	This Module is exporting values into excel
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Input;
use App\model\contactsmodel;
use DB;
use Session;
use App\model\branchesmodel;
use App\model\usersmodel;
use App\model\exportmodel;
use App\model\employeemodel;
use App\model\commonmodel;
use App\model\alertmodel;
use App\model\dealermodel;

class exportcontroller extends Controller
{

	public $dmsusertable;

	public function __construct()
	{
		$this->dmsusertable				='user_account';
		$this->masterMainLoginTable   	= 'dms_dealers';
	}

	public function contact_export($contacttypeid="")
	{
		try
		{
			if($contacttypeid == "0")
			{
				$fetch_data			= contactsmodel::contact_table()->where('contact_status','!=','inactive')->get();
				$contacttype		= contactsmodel::contact_type()->get();
				$excelname 			= "My Contact_".time();
				$sheetheading 		= "My Contact";
				$mergecells 		= "A1:M1";
				$sheetArray 		= array();
				$sheetArray[] 		= array('SL No','Business Name','Customer Name','Gender','Contact Owner','Email','Contact','Address','Pincode','Contact Type','Lead Source','Email Output','SMS Output');
				foreach($fetch_data  as $i => $row)
				{
					foreach ($contacttype as $type) 
					{
						if($row->contact_type_id == $type->contact_type_id)
						{
							$contact_type = $type->contact_type;
						}
					}
					$i++;
					if($row->contact_email_opt_out == "1")
					{
						$emailout = "Subscribed";
					}
					else
					{
						$emailout = "Unsubscribe";
					}

					if($row->contact_sms_opt_out == "1")
					{
						$smsout = "Subscribed";
					}
					else
					{
						$smsout = "Unsubscribe";
					}

					$leadsource = exportmodel::getleadsource($row->contact_lead_source);

					$sheetArray[] 	= array($i,$row->contact_business_name,$row->contact_first_name.' '.$row->contact_last_name,$row->contact_gender,$row->contact_owner,$row->contact_email_1,$row->contact_phone_1,$row->contact_mailing_address,$row->contact_mailing_pincode,$contact_type,$leadsource,$emailout,$smsout);
				}
				exportmodel::generatereport($sheetArray,$sheetheading,$excelname,$mergecells);
			}
			else
			{
				$fetch_data			= contactsmodel::contactexcel($contacttypeid)->where('contact_status','!=','inactive')->get();
				$contacttype		= contactsmodel::contact_type()->get();
				$excelname 			= "My Contact_".time();
				$sheetheading 		= "My Contact";
				$mergecells 		= "A1:M1";
				$sheetArray 		= array();
				$sheetArray[] 		= array('SL No','Business Name','Customer Name','Gender','Contact Owner','Email','Contact','Address','Pincode','Contact Type','Lead Source','Email Output','SMS Output');
				foreach($fetch_data  as $i => $row)
				{
					foreach ($contacttype as $type) 
					{
						if($row->contact_type_id == $type->contact_type_id)
						{
							$contact_type = $type->contact_type;
						}
					}
					$i++;
					if($row->contact_email_opt_out == "1")
					{
						$emailout = "Subscribed";
					}
					else
					{
						$emailout = "Unsubscribe";
					}

					if($row->contact_sms_opt_out == "1")
					{
						$smsout = "Subscribed";
					}
					else
					{
						$smsout = "Unsubscribe";
					}

					$leadsource = exportmodel::getleadsource($row->contact_lead_source);

					$sheetArray[] 	= array($i,$row->contact_business_name,$row->contact_first_name.' '.$row->contact_last_name,$row->contact_gender,$row->contact_owner,$row->contact_email_1,$row->contact_phone_1,$row->contact_mailing_address,$row->contact_mailing_pincode,$contact_type,$leadsource,$emailout,$smsout);
				}
				exportmodel::generatereport($sheetArray,$sheetheading,$excelname,$mergecells);
			}
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
	}

	public function export_users($userid="")
	{
		try
		{
			if($userid=="0")
			{
				$fetch_data		= usersmodel::select_all_user($this->getschemaname(session::get('ses_id')),$this->dmsusertable);
				$fetch_usertype		= usersmodel::user_type();
				$excelname 			= "My User_".time();
				$sheetheading 		= "My User";
				$mergecells 		= "A1:H1";
				$sheetArray 		= array();
				$sheetArray[] 		= array('SL No','Name','Email','Contact Number','Role','Primary User','Status');
				foreach($fetch_data  as $i => $row)
				{
					$i++;
					foreach ($fetch_usertype as $usrtype) 
					{
						if($usrtype->master_role_id == "1")
						{
							$usrrole = "Admin";
						}
						elseif($row->user_role == $usrtype->master_role_id)
						{
							$usrrole = $usrtype->master_role_name;
						}
					}

					if($row->user_role == "1")
					{
						$priusr = "YES";
					}
					else
					{
						$priusr = "NO";
					}

					$sheetArray[] 	= array($i,$row->user_name,$row->user_email,$row->user_moblie_no,$usrrole,$priusr,$row->status);
				}
				exportmodel::generatereport($sheetArray,$sheetheading,$excelname,$mergecells);
			}
			else
			{
				$fetch_data		= usersmodel::selectuser($this->getschemaname(session::get('ses_id')),$this->dmsusertable,$userid);
				$fetch_usertype		= usersmodel::user_type();
				$excelname 			= "My User_".time();
				$sheetheading 		= "My User";
				$mergecells 		= "A1:H1";
				$sheetArray 		= array();
				$sheetArray[] 		= array('SL No','Name','Email','Contact Number','Role','Primary User','Status');
				foreach($fetch_data  as $i => $row)
				{
					$i++;
					foreach ($fetch_usertype as $usrtype) 
					{
						if($usrtype->master_role_id == "1")
						{
							$usrrole = "Admin";
						}
						elseif($row->user_role == $usrtype->master_role_id)
						{
							$usrrole = $usrtype->master_role_name;
						}
					}

					if($row->user_role == "1")
					{
						$priusr = "YES";
					}
					else
					{
						$priusr = "NO";
					}

					$sheetArray[] 	= array($i,$row->user_name,$row->user_email,$row->user_moblie_no,$usrrole,$priusr,$row->status);
				}
				exportmodel::generatereport($sheetArray,$sheetheading,$excelname,$mergecells);
			}
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
	}

	public function getschemaname($id)
	{
		$getdealer_schemaname		=	branchesmodel::masterFetchTableDetails(
												$this->masterMainLoginTable,
												array('d_id'=>$id)
													);
		$dealer_schemaname			= 	"";
		if(!empty($getdealer_schemaname) && count($getdealer_schemaname) > 0)
		{
			foreach($getdealer_schemaname as $dealernameselect)
			{
				$dealer_schemaname	= 	$dealernameselect->dealer_schema_name;
			}
			return $dealer_schemaname;
		}
		else
		{
			return false;
		}
	}

	public function export_employee($emptypeid="")
	{
		if($emptypeid == "0")
		{
			$fetch_employee		= exportmodel::employeetable($emptypeid)->get();
			$excelname 			= "My Employee_".time();
			$sheetheading 		= "My Employee";
			$mergecells 		= "A1:J1";
			$sheetArray 		= array();
			$sheetArray[] 		= array('SL No','Bussiness Name','Employee Name','Gender','Mobile Number','Landline Number','Email ID','Address','Mailing Locality','Pincode');
			foreach($fetch_employee  as $i => $row)
			{
				$i++;

				$sheetArray[] 	= array($i,$row->employee_business_name,$row->employee_first_name.$row->employee_last_name,$row->employee_gender,$row->employee_moblie_no,$row->employee_landline_no,$row->employee_email_1,$row->employee_mailing_address,$row->employee_mailing_locality,$row->employee_mailing_pincode);
			}
			exportmodel::generatereport($sheetArray,$sheetheading,$excelname,$mergecells);
		}
		else
		{
			$fetch_employee		= exportmodel::employeetable($emptypeid)->get();
			$excelname 			= "My Employee_".time();
			$sheetheading 		= "My Employee";
			$mergecells 		= "A1:J1";
			$sheetArray 		= array();
			$sheetArray[] 		= array('SL No','Bussiness Name','Employee Name','Gender','Mobile Number','Landline Number','Email ID','Address','Mailing Locality','Pincode');
			foreach($fetch_employee  as $i => $row)
			{
				$i++;

				$sheetArray[] 	= array($i,$row->employee_business_name,$row->employee_first_name.$row->employee_last_name,$row->employee_gender,$row->employee_moblie_no,$row->employee_landline_no,$row->employee_email_1,$row->employee_mailing_address,$row->employee_mailing_locality,$row->employee_mailing_pincode);
			}
			exportmodel::generatereport($sheetArray,$sheetheading,$excelname,$mergecells);
		}
	}

	public function export_branch()
	{
		$manage_branch				= exportmodel::branch()->get();
		$state 						= commonmodel::get_master_state();
		$city 						= commonmodel::get_master_city();
		$excelname					= "My Branches_".time();
		$sheetheading 				= "My Branches";
		$mergecells 				= "A1:J1";
		$sheetArray 				= array();
		$sheetArray[] 				= array('Sl No','Dealer Name','Contact Number','Address','Pincode','Email','City','State','Service Centre','Headquarters');
		//dd($manage_branch);
		foreach ($manage_branch as $i => $row) 
		{
			$i++;
			foreach ($state as $st) 
			{
				if($st->id == $row->dealer_state)
				{
					$statename = $st->state_name;
				}
			}
			foreach ($city as $cit) 
			{
				if($cit->master_id == $row->dealer_city)
				{
					$cityname = $cit->city_name;
				}
			}
			if($row->headquarter == '1')
			{
				$headquarter = "Yes";
			}
			else
			{
				$headquarter = "No";
			}

			if($row->dealer_service == '1')
			{
				$dealser = "Available";
			}
			else
			{
				$dealser = "Not Available";
			}

			$sheetArray[] 		= array($i,$row->dealer_name,$row->dealer_contact_no,$row->branch_address,$row->dealer_pincode,$row->dealer_mail,$cityname,$statename,$dealser,$headquarter);
		}
		exportmodel::generatereport($sheetArray,$sheetheading,$excelname,$mergecells);
	}

	public function exportalert()
	{
		$alertData		= alertmodel::fetchAllAlert(Session::get('ses_id'));
		//dd($alertData);
		$excelname 			= "Alerts_".time();
		$sheetheading 		= "Alerts";
		$mergecells 		= "A1:N1";
		$sheetArray 		= array();
		$sheetArray[] 		= array('SL No','Alert Id','Alert Type','Dealer Name','Alert Date','Product','Year','Fuel Type','Location','Mobile Number','Email ID','Alert ON/OFF','Email ON/OFF','SMS ON/OFF');
			foreach($alertData  as $i => $row)
			{
				$i++;
				if($row->alert_status =="1")
				{
					$alert_stat = "ON";
				}
				else
				{
					$alert_stat = "OFF";
				}

				if($row->alert_email_status == "1")
				{
					$email_status = "ON";
				}
				else
				{
					$email_status ="OFF";
				}

				if($row->alert_sms_status =="1")
				{
					$sms_status = "ON";
				}
				else
				{
					$sms_status="OFF";
				}

				$dname=dealermodel::dealerfetch($row->alert_source_dealer_id);
				if(count($dname)>0)
				{
					$row->dealername=$dname[0]->dealer_name;
				}
				else
				{
					$row->dealername="ALL";
				}

				$dateString = strtotime($row->alert_date);
				$date = date("jS F, Y" ,$dateString);

				$sheetArray[] 	= array($i,$row->alertid,$row->alert_type,$row->dealername,$date,$row->alert_model." ".$row->alert_variant,$row->alert_year,$row->alert_fueltype,$row->alert_city,$row->alert_mobileno,$row->alert_usermailid,$alert_stat,$email_status,$sms_status);
			}
			exportmodel::generatereport($sheetArray,$sheetheading,$excelname,$mergecells);
	}

}