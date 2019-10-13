<?php
/*
Module Name : pdfcontroller 
Created By  : Ahila
Use of this module is manage invoice data
*/
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\model\dealermodel;
use App\model\subscriptionmodel;
use App\Exceptions\CustomException;
use PDF;
use Session;
use NumberFormatter;


class pdfcontroller extends Controller
{
	public function pdfContent($historyid)
	{
		$pdfContent = $this->pdfGenerate($historyid);
		return $pdfContent->stream('pdf');
	}

	public function invoicepdfDownload($historyid)
	{
		$pdfContent = $this->pdfGenerate($historyid);
		return $pdfContent->download('invoice.pdf');
		
	}


public function pdfGenerate($historyid)
{
	$id             =      Session::get('ses_id');
		$schema         =      Session::get('dealer_schema_name');
		try
		{
		$dealerper      =      dealermodel::dealerdetails_get($schema,$id);
		$dealerpertwo   =      dealermodel::dealerfetch($id);
		$dealership     =      $dealerpertwo[0]->dealership_name;
		$address        =      $dealerper[0]->Address;
		$pincode        =      $dealerper[0]->pincode;
		if ($pincode == "" )
		{
			$pincode="";
		}
	
		$historydata    =      subscriptionmodel::fetch_history_record(decrypt($historyid));

		$f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
				
		$plandata       =      subscriptionmodel::fetch_plandata($historydata->subscription_plan_id);
		
		$pdf            =    PDF::loadview('pdf',['address'=>$address,
								  				  'dealership'=>$dealership,
								  				  'pincode'=>$pincode,
								  				  'maxuser'=>$historydata->max_users,
								  				  'plan'=>$plandata['plan_type_name'],
								  				  'unitcost'=>$plandata['plan_detail'][0]->unit_cost,
								  				  'startdate'=>$historydata->subscription_start_date,
								  				  'enddate'=>$historydata->subscription_end_date,
								  				  'carry_amount'=>$historydata->carry_forward_amount,
								  				  'payable_amount'=>$historydata->payable_amount,
								  				  'coupon_amount'=>$historydata->coupon_amount,
								  				  'history_id'=>$historydata->history_id,
								  				  'payment_date'=>$historydata->payment_date,
								  				  'payable_amount_words'=>$f->format($historydata->payable_amount),

								  ]);

		
		return $pdf;
	   }
	   catch(Exception $e)
	   {
	   		 throw new CustomException($e->getMessage());
	   }
}
}	