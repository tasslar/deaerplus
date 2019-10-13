<?php

/*
	Module Name : Invoice 
	Created By  : HARIKRISHNAN R 09-03-2017 Version 1.0
	This module handle with Invoice
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Config;
use PDF;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\branch;
use App\model\invoicemodel;
use App\model\commonmodel;
use App\model\contactsmodel;
use App\model\usersmodel;
use App\model\dealermodel;
use App\model\exportmodel;
use App\model\emailmodel;
use App\model\report;
use Mail;
use Carbon;
use NumberFormatter;

class invoicecontroller extends Controller
{
	public $dealer_id;
	public $side_bar_active;
	public $contact_table;
	public $dealer_schemaname;
	public $car_listing_tbl;
	public $invoice_table;
	public $invoice_table_items;
	public $dealer_payments;

	public function __construct()
	{
		$this->active_menu_name 	= "accounts";
		$this->side_bar_active 		= "";
		$this->side_bar_active  	= config::get('common.contact');
		$this->contact_table 		= "dealer_contact_management";
		$this->car_listing_tbl		= 'dealer_listing_pricing';
		$this->invoice_table 		= "dealer_invoices";
		$this->invoice_table_items	= "dealer_invoice_items";
		$this->dealer_payments 		= "dealer_payments";
		$this->user_table               = "user_account";
		$this->middleware(function($request,$next){
			$this->id 					= Session::get('ses_id');
			$this->header_data 			= commonmodel::commonheaderdata();
			$this->dealer_schemaname 	= Session::get('dealer_schema_name');
			$this->login_authecation    = session()->has( 'ses_dealername' ) ? session()->get( 'ses_dealername' ) :  Redirect::to('login')->send();
			//$this->dealer_schemaname 	= quotes::getschemaname(Session::get('ses_id'));
			$this->dealer_id 			= Session::get('ses_id');
			$this->header_data['title'] = "";
			return $next($request);
		});
	}

	public function doinvoice_list()
	{
		//$myplan 				= invoicemodel::getPlan($this->id);
		$header_data 			= $this->header_data;
		$header_data['title'] 	= "Invoice List";
		$this->side_bar_active 	= "1";
		$dealer_invoice 		= invoicemodel::dealer_invoice_select(
												$this->dealer_schemaname,
												$this->invoice_table
															);
		//dd($dealer_invoice);

		$select 				= array(
									'contact_management_id'=> 'contact_management_id',
									'contact_first_name'   =>'contact_first_name'
									);

		$where		 			= array(
									'contact_type_id'=>config::get('common.customer')
									);

		$client 				= contactsmodel::getcontacts(
											$this->dealer_schemaname,
											$this->contact_table
										);

		$invoice_status 		= invoicemodel::statustable();

		$paymentMethod 			= invoicemodel::paymentMethod();
		//dd($invoice_status); 
		$compact_array 			= array(
									'active_menu_name'	=> $this->active_menu_name,
									'left_menu' 		=> 1,
									'dealer_invoice'	=> $dealer_invoice,
									'client' 			=> $client,
									'side_bar_active'	=> $this->side_bar_active,
									'invoice_status'	=> $invoice_status,
									'paymentMethod'		=> $paymentMethod,
									);
		return view('invoice_list_home',compact('header_data','compact_array'));
	}

	public function do_add_invoice_list(Request $request)
	{
		try
		{
			$dealerid 				= Session::get('ses_id');
			$first_day_this_month 	= date('Y-m-01');
			$last_day_this_month  	= date('Y-m-t');
			$current_day_this_month =date("Y-m-d");
			$this->side_bar_active 	= "1";

			$user_id				= dealermodel::parent_id($this->id);
			if($user_id == 0)
			{
			    $user_id = 1;
			}
			else
			{
			    $user_id = usersmodel::user_id($this->dealer_schemaname,$this->user_table,$this->id);
			    $user_id = $user_id->user_id;
			}

			$header_data 			= $this->header_data;

			$dealer_schemaname 		= $this->dealer_schemaname;
			$table 				 	= 'dms_car_listings';
			$wherecondtion 			= array('dealer_id'=>$this->dealer_id);

			$dealer_schemanames 	= (new branch)->getschemaname($dealerid);

			$header_data['title'] 	= "Invoice List";

			$car_lisitng 			= invoicemodel::car_lisitng(
												$this->dealer_schemaname,
												$this->car_listing_tbl);

			$invoicecode 			= invoicemodel::invoicecode();

			$select 				= array(
										'contact_management_id' => 'contact_management_id',
										'contact_first_name' 	=> 'contact_first_name'
										);
			$where 					= array(
										'contact_type_id' 		=> config::get('common.customer')
										);
			$client		 			= contactsmodel::getcontacts(
											$dealer_schemanames,
											$this->contact_table,
											$where,
											$select
											);

			$paymentMethod 			= invoicemodel::paymentMethod();

			$compact_array 			= array(
										'active_menu_name' 		=> $this->active_menu_name,
										'left_menu' 			=> 1,
										'side_bar_active'  		=> $this->side_bar_active,
										'car_lisitng'			=> $car_lisitng,
										'invoicecode'			=> $invoicecode,
										'client'				=> $client,
										'first_day_this_month'	=> $first_day_this_month,
										'last_day_this_month'	=> $last_day_this_month,
										'current_day_this_month'=> $current_day_this_month,
										'paymentMethod'			=> $paymentMethod,
										'side_bar_active'	=> $this->side_bar_active,
										);

			// $invoice_id 			= array(
			// 								'invoice_status_id'=>config::get('common.status_draft')
			// 							);
			//dd($car_lisitng);

			if (Input::has('btn_save')) 
			{
				$invoice_number 		= $request->get('txt_invoice_code');
				$getAllInvoiceCode 		= invoicemodel::getAllInvoiceCode(
													$dealer_schemaname,
													$invoice_number,
													$this->invoice_table);

				$clientid 				= $request->get('ddl_client');
				$first_date 			= $request->get('txt_date1');
				$second_date 			= $request->get('txt_date2');
				$invoice_discount 		= $request->get('txt_invoiceDiscount');
				$invoice_discount_type 	= $request->get('ddl_invoiceDiscountType');
				$grand_total 			= $request->get('txt_grand_total');
				$finalDiscount 			= $request->get('txt_finalDiscount');

				$extra_inform 			= $request->get('txtar_extra_inform');

				if($getAllInvoiceCode)
				{
					return redirect()->back()->with('message-err', 'Already Taken Invoice Number');
				}
				elseif($request->get('txt_payment_paid') > $grand_total)
				{
					return redirect()->back()->with('message-err', 'Amount Paid is Greater than Total Amount');
				}
				elseif(empty($request->get('ddl_product')))
				{
					return redirect()->back()->with('message-err', 'Please Select a Product to create Invoice');
				}
				elseif($clientid == "0")
				{
					return redirect()->back()->with('message-err', 'Please Select a Client to create Invoice');
				}
				else
				{
					$table1 				= "dealer_invoices";
					$data1 					= array(
										'contact_id' 			=> $clientid,
										'dealer_id' 			=> $dealerid,
										'user_id'				=> Session::get('ses_id'),
										'invoice_status_id'		=> config::get('common.status_draft'),
										//'invoice_status_id'	=> '1',
										'invoice_number'		=> $invoice_number,
										'discount' 				=> $invoice_discount,
										'invoice_discount_type' => $invoice_discount_type,
										'invoice_date'			=> $first_date,
										'due_date'				=> $second_date,
										'terms'					=> $extra_inform,
										'amount'				=> $grand_total,
										'po_number' 			=> $finalDiscount,
													);

					$invoice 				 =  invoicemodel::insert(
														$this->dealer_schemaname,
														$this->invoice_table,
														$data1);
					if($invoice)
					{
						$product 					= $request->get('ddl_product');
						$cardescription 			= $request->get('txtar_description');
						$quantity 					= $request->get('txt_quantity');
						$price                      = $request->get('txt_price');
						$taxrate 					= $request->get('ddl_taxrate');
						$discount 					= $request->get('txt_discount_sub');
						$type 						= $request->get('ddl_discount_type');
						$subtotal 					= $request->get('txt_subtototal');

						foreach ($product as $fetch =>$key) 
						{
						    $car_items = [
											'product_id'		=> $product[$fetch], 
											'notes'				=> $cardescription[$fetch],
											//'user_id'			=> Session::get('ses_id'),
											'qty' 				=> $quantity[$fetch],
											'cost'				=> $price[$fetch],
											'tax_rate1'			=> $taxrate[$fetch],
											'discount'			=> $discount[$fetch],
											'discount_type'		=> $type[$fetch],
											'sub_total'			=> $subtotal[$fetch],
											'dealer_id'			=> $this->id,
											'user_id'			=> $user_id,
											'invoice_id'		=> $invoice
										];
						    $invoice_itemsadded 		= invoicemodel::car_items_insert(
								    							$this->dealer_schemaname,
								    							$this->invoice_table_items,
								    							$car_items);
						}
					}
					//dd($request->get('txt_payment_paid'));
					if($request->get('txt_payment_paid') != "")
					{
						$data2 					= array(
											'invoice_id' 		=> $invoice,
											'contact_id' 		=> $clientid,
											'user_id'			=> Session::get('ses_id'),
												//'invoice_status_id'	=> '1',
											'dealer_id'			=> $dealerid,
											'amount' 			=> $request->get('txt_payment_paid'),
											'payment_date' 		=> $request->get('txt_payment_date'),
											'payment_type_id'	=> $request->get('ddl_payment_method'),
											'payment_status_id'	=> config::get('common.status_draft'),
											//'payment_status_id'	=> '1',
											);

						$invoice 				 =  invoicemodel::insert(
														$this->dealer_schemaname,
														$this->dealer_payments,
														$data2);
					}
					return redirect()->action('invoicecontroller@doinvoice_list')->with('message','Invoice Added Successfully');
				}
			}
			else
			{
				return view('accounts_add_invoicelist',compact('header_data','compact_array','client'));
			}
		}
		catch (\Exception $e) 
		{
			return $e->getMessage();
		}
	}

	public function edit_invoice(Request $request)
	{
		try
		{
			$header_data 			= $this->header_data;
			$dealerid 				= Session::get('ses_id');
			$first_day_this_month 	= date('Y-m-01');
			$today 					= date("Y/m/d");
			$user_id				= dealermodel::parent_id($this->id);
			$header_data['title'] 	= "Edit Invoice List";
			$this->side_bar_active 	= "1";
			if($user_id == 0)
			{
			    $user_id = 1;
			}
			else
			{
			    $user_id = usersmodel::user_id($this->dealer_schemaname,$this->user_table,$this->id);
			    $user_id = $user_id->user_id;
			}

			$dealer_schemanames 	= (new branch)->getschemaname($dealerid);

			$where 					= array(
										'contact_type_id' 		=> config::get('common.customer')
										);

			$select 				= array(
										'contact_management_id' => 'contact_management_id',
										'contact_first_name' 	=> 'contact_first_name'
										);

			$car_lisitng 			= invoicemodel::car_lisitng(
												$this->dealer_schemaname,
												$this->car_listing_tbl);

			$invoicecode 			= invoicemodel::invoicecode();

			$client		 			= invoicemodel::getcontacts(
											$dealer_schemanames,
											$this->contact_table,
											$where,
											$select
											);

			$invoiceid 				= $request->get('viewinvoice');

			$invoice_main 			= invoicemodel::invoicemain(
													$dealer_schemanames,
													$this->invoice_table,
													$invoiceid);
			//dd($invoice_main);

			$invoice_sub 			= invoicemodel::invoicemain(
													$dealer_schemanames,
													$this->invoice_table_items,
													$invoiceid);
			//dd($invoice_sub);

			$invoicePayments 		= invoicemodel::getInvoicePayments(
													$dealer_schemanames,
													$this->dealer_payments,
													$invoiceid
													);
			//dd($invoicePayments);
			foreach($invoice_sub as $i=> $value)
			{
			    $value->sno = $i;
			    $i++;
			}

			$paymentMethod 			= invoicemodel::paymentMethod();

	        $compact_array 			= array(
										'active_menu_name' 		=> $this->active_menu_name,
										'left_menu' 			=> 1,
										'side_bar_active'  		=> $this->side_bar_active,
										'client'				=> $client,
										'invoicecode'			=> $invoicecode,
										'car_lisitng'			=> $car_lisitng,
										'invoiceid'				=> $invoiceid,
										'invoice_sub' 			=> $invoice_sub,
										'first_day_this_month' 	=> $first_day_this_month,
										'paymentMethod'			=> $paymentMethod,
										'side_bar_active'		=> $this->side_bar_active,
										'today'					=> $today,
										//'invoicePayments'		=> $invoicePayments,
										);

			if(Input::has('btn_update'))
			{
				$invoice_number 		= $request->get('txt_invoice_code');
				//$clientid 				= $request->get('ddl_client');
				$first_date 			= $request->get('txt_date1');
				$second_date 			= $request->get('txt_date2');
				$invoice_discount 		= $request->get('txt_invoiceDiscount');
				$invoice_discount_type 	= $request->get('ddl_invoiceDiscountType');
				$grand_total 			= $request->get('txt_grand_total');
				$extra_inform 			= $request->get('txtar_extra_inform');
				$finalDiscount 			= $request->get('txt_finalDiscount');
				//dd($invoice_discount_type);
				if($request->get('txt_payment_paid') > $grand_total)
				{
					return redirect()->back()->with('message-err', 'Amount Paid is Greater than Total Amount');
				}
				elseif(empty($request->get('ddl_product')))
				{
					return redirect()->back()->with('message-err', 'Please Select a Product to create Invoice');
				}
				// elseif($clientid == "0")
				// {
				// 	return redirect()->back()->with('message-err', 'Please Select a Client to create Invoice');
				// }
				else
				{
					$data1 					= array(
													//'contact_id' 			=> $request->get('ddl_client'),
													'dealer_id' 			=> $dealerid,
													//'user_id'			=> $user_id,
													//'invoice_status_id'	=>'1',
													//'invoice_number'	=> $invoice_number,
													'discount' 				=> $invoice_discount,
													'invoice_discount_type' => $invoice_discount_type,
													'invoice_date'			=> $first_date,
													'due_date'				=> $second_date,
													'terms'					=> $extra_inform,
													'amount'				=> $grand_total,
													'po_number' 			=> $finalDiscount,
													);
					$whereCondtion 			= "invoice_id";
					$whereData 				= $request->get('txt_invoice_id');

					$invoice 				=  invoicemodel::update_invoice(
															$this->dealer_schemaname,
															$this->invoice_table,
															$whereCondtion,
															$whereData,
															$data1);

					$invoice_sub_id 		= $request->get('txt_invoice_sub_id');
					$product 				= $request->get('ddl_product');
					$cardescription 		= $request->get('txtar_description');
					$quantity 				= $request->get('txt_quantity');
					$price 					= $request->get('txt_price');
					$taxrate 				= $request->get('ddl_taxrate');
					$discount 				= $request->get('txt_discount_sub');
					$type 					= $request->get('ddl_discount_type');
					$subtotal 				= $request->get('txt_subtototal');
					$whereCondtion2 		= "invoice_item_id";
					foreach ($product as $fetch => $key) 
					{
						$car_items 			= [
												//'invoice_item_id'	=> $invoice_sub_id[$fetch],
												'product_id'		=> $product[$fetch], 
												'notes'				=> $cardescription[$fetch],
												'qty' 				=> $quantity[$fetch],
												'cost'				=> $price[$fetch],
												'tax_rate1'			=> $taxrate[$fetch],
												'discount'			=> $discount[$fetch],
												'discount_type'		=> $type[$fetch],
												'sub_total'			=> $subtotal[$fetch],
												'dealer_id'			=> $this->id,
												//'user_id'			=> Session::get('ses_id'),
												];
						//dd($car_items);
						$invoice_itemsadded 	= invoicemodel::update_invoice_items(
							    							$this->dealer_schemaname,
							    							$this->invoice_table_items,
							    							$invoice_sub_id[$fetch],
							    							$car_items);
					}

					return redirect()->action('invoicecontroller@doinvoice_list')->with('message','Updated 
					Successfully');
				}
			}
			else
			{
				return view('invoice_edit',compact('header_data','compact_array','invoice_main','invoice_sub','invoicePayments'));
			}
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
	}

	public function doget_date_invoice(Request $request)
	{
		//dd($request->get('id'));
		$result 	= invoicemodel::getdate(
									$this->dealer_schemaname,
									$this->invoice_table,
									$request->get('id')
									);
		//dd($result);
		return $result;
	}

	public function update_invoice_date(Request $request)
	{
		if(Input::has('btn_save_date'))
		{
			$invoiceDate 	= $request->get('txt_due_date');
			$data 			= array(
									'due_date' 		=> $invoiceDate
									);
			$whereCondtion 	= "invoice_id";
			$whereData 		= $request->get('txt_invoice_id');
			//dd($whereData);
			$invoice 		=  invoicemodel::update_invoice(
											$this->dealer_schemaname,
											$this->invoice_table,
											$whereCondtion,
											$whereData,
											$data);

			return redirect()->back()->with('message','Due Date Successfully Edited');
		}
	}

	public function do_getInvoicePayments(Request $request)
	{
		if(Input::has('btn_add_payment'))
		{
			//dd($request->get('txt_payments_amount'));
			$invoice 		=  invoicemodel::do_getInvoicePaymentsWithAmount(
												$this->dealer_schemaname,
												$this->dealer_payments,
												$request->get('txt_invoice_id1'));
			if(isset($invoice[0]))
			{
				$balanceAmount  =  $invoice[0]->fullAmount-$invoice[0]->totalPaidAmount;
			}
			else
			{
				$result = invoicemodel::invoicemain(
									$this->dealer_schemaname,
									$this->invoice_table,
									$request->get('txt_invoice_id1'));
				$balanceAmount = $result[0]->amount;
			}
			

			if($request->get('txt_payments_date') == "")
			{
				return redirect()->back()->with('message-err','Payment Date is required');
			}
			elseif($request->get('txt_payments_amount') == "")
			{
				return redirect()->back()->with('message-err','Payment Amount is Required');
			}
			elseif($request->get('txt_payments_amount') > $balanceAmount)
			{
				return redirect()->back()->with('message-err','Amount Should be lesser than Balance Amount');
			}
			else
			{
				$data = array(
								'amount' 			=> $request->get('txt_payments_amount'),
								'payment_date' 		=> $request->get('txt_payments_date') ,
								'payment_type_id' 	=> $request->get('ddl_payment_method'),
								'invoice_id' 		=> $request->get('txt_invoice_id1'),
							);

				//dd($whereData);
				$invoice 		=  invoicemodel::insertPayment(
												$this->dealer_schemaname,
												$this->dealer_payments,
												$data);
				return redirect()->back()->with('message','Payment Added Successfully');
			}
		}
		else
		{
			$result = invoicemodel::do_getInvoicePayments(
									$this->dealer_schemaname,
									$this->dealer_payments,
									$request->get('id'));
			return $result;
		}
	}

	public function dogetInvoiceStatus(Request $request)
	{
		if(Input::has('btn_invoice_status_change'))
		{
			$data = array(
							'invoice_status_id' => $request->get('ddl_invoice_status'),
						);

			$whereCondtion 	= "invoice_id";
			$whereData 		= $request->get('txt_invoice_status_id');
			//dd($whereData);
			$invoice 		=  invoicemodel::update_invoice(
											$this->dealer_schemaname,
											$this->invoice_table,
											$whereCondtion,
											$whereData,
											$data);
			return redirect()->back();
		}
		else
		{
			return invoicemodel::dogetInvoiceStatus(
									$this->dealer_schemaname,
									$this->invoice_table,
									$request->get('id'));
		}
	}

	public function doexport_invoice(Request $request)
	{
		$header_data 		= $this->header_data;
		$invoiceid 			= $request->get('exportinvoice');
		$dealerid 			= Session::get('ses_id');

		$car_lisitng        = invoicemodel::car_lisitng(
										$this->dealer_schemaname,
										$this->car_listing_tbl);

		$invoiceValue       = invoicemodel::quotesvalue(
										$this->dealer_schemaname,
										$this->invoice_table,
										$invoiceid);
		// $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
		// dd($f->format(123456));
		$number = $invoiceValue[0]->amount;
		//dd($number);
		$numberconvert      = new NumberFormatter("en", NumberFormatter::SPELLOUT);    
        $getNumberWords     = $numberconvert->format($number);        
		$getNumberWords     = commonmodel::convert_number_to_words($getNumberWords);		

		$invoiceCarValue   	= invoicemodel::quotesvalue(
										$this->dealer_schemaname,
										$this->invoice_table_items,
										$invoiceid);

		$getClient         	= contactsmodel::get_client(
										$this->dealer_schemaname,
										$invoiceValue[0]->contact_id);

		$dealerInfo        	= dealermodel::dealerdetails_get(
										$this->dealer_schemaname,
										$this->id);

		$dealerProfile    	= dealermodel::dealerprofile($this->id);

		$city               = commonmodel::get_master_city();    
		$state              = commonmodel::get_master_state();

		$amountPaid			= invoicemodel::do_getInvoicePayments(
									$this->dealer_schemaname,
									$this->dealer_payments,
									$invoiceid);

		$date               = Carbon\Carbon::now()->format("Y-m-d");

		$compact_array 		= array(
									'car_lisitng'		=> $car_lisitng,
									'getNumberWords'	=> $getNumberWords,
									'quotes_value'		=> $invoiceValue,
									'quotes_car_value'	=> $invoiceCarValue,
									'get_client'		=> $getClient,
									'dealer_info'		=> $dealerInfo,
									'dealer_profile'	=> $dealerProfile,
									'city'				=> $city,
									'state'				=> $state,
									'amountPaid'		=> $amountPaid,
									'date' 				=> $date
									);		
		$pdf 				= PDF::loadView('invoicePdf',compact('compact_array'))
													->setPaper('a3', 'portrait');
		return $pdf->stream('invoicePdf.pdf');

		//return view('invoice_pdf',compact('compact_array','invoice_main'));
		//$pdf 				= PDF::loadView('invoice_pdf', compact('compact_array','invoice_main'))
		 								//->setPaper('a3', 'portrait');
		//return $pdf->download('invoice.pdf');
	}

	public function doinvoiceEmailSend(Request $request)
	{
		$invoiceid 			= $request->get('txt_invoice_id_email');
		$dealerid 			= Session::get('ses_id');

		$fetchDealerName 	= invoicemodel::getDealerName($dealerid);

		$emailTemplate 		= emailmodel::get_email_templates('12');

		foreach ($emailTemplate as $emailData) 
		{
			$mail_subject 	= $emailData->email_subject;
			$mail_message  	= $emailData->email_message;
        	$mail_params   	= $emailData->email_parameters; 
		}

		$car_lisitng        = invoicemodel::car_lisitng(
										$this->dealer_schemaname,
										$this->car_listing_tbl);

		$invoiceValue       = invoicemodel::quotesvalue(
										$this->dealer_schemaname,
										$this->invoice_table,
										$invoiceid);
		//dd($invoiceValue);
		$numberconvert      = new NumberFormatter("en", NumberFormatter::SPELLOUT);    
        $getNumberWords     = $numberconvert->format($invoiceValue[0]->amount); 
		$getNumberWords     = commonmodel::convert_number_to_words($getNumberWords);		
		$invoiceCarValue   	= invoicemodel::quotesvalue(
										$this->dealer_schemaname,
										$this->invoice_table_items,
										$invoiceid);

		$getClient         	= contactsmodel::get_client(
										$this->dealer_schemaname,
										$invoiceValue[0]->contact_id);

		$dealerInfo        	= dealermodel::dealerdetails_get(
										$this->dealer_schemaname,
										$this->id);

		$dealerProfile    	= dealermodel::dealerprofile($this->id);

		$city               = commonmodel::get_master_city();    
		$state              = commonmodel::get_master_state();

		$amountPaid			= invoicemodel::do_getInvoicePayments(
									$this->dealer_schemaname,
									$this->dealer_payments,
									$invoiceid);

		$date               = Carbon\Carbon::now()->format("Y-m-d");

		$compact_array 		= array(
									'car_lisitng'		=> $car_lisitng,
									'getNumberWords'	=> $getNumberWords." Rupees",
									'quotes_value'		=> $invoiceValue,
									'quotes_car_value'	=> $invoiceCarValue,
									'get_client'		=> $getClient,
									'dealer_info'		=> $dealerInfo,
									'dealer_profile'	=> $dealerProfile,
									'city'				=> $city,
									'state'				=> $state,
									'amountPaid'		=> $amountPaid,
									'date'				=> $date
									);

		$pdf  				= PDF::loadView('invoicePdf', compact('compact_array'))
									->setPaper('a3', 'portrait')
									->save(public_path().'/'.$invoiceValue[0]->invoice_number.'.pdf');

		$pdf_path 			= public_path().'/'.$invoiceValue[0]->invoice_number.'.pdf';

		$customerName 		= $getClient->contact_first_name;

		$toEmail    		= $getClient->contact_email_1;
		//$toEmail 			= "hari@falconnect.in";

		$maildata 			= array(
								'0' => $invoiceValue[0]->invoice_number,
								'1' => session::get('ses_dealername'),
								'2' => $customerName,
								'3' => $invoiceValue[0]->amount,
								'4' => $dealerInfo[0]->Address,
								'5' => $dealerInfo[0]->phone,
								'6' => $invoiceValue[0]->due_date
								);

		// $mail_subject_data 	= array(
		// 						'0' => '[Invoice] Invoice',
		// 						'1' => $invoiceValue[0]->invoice_number,
		// 						'2' => session::get('ses_dealername'),
		// 						);

		$mail_subject_data 	= array(
								'0' => $invoiceValue[0]->invoice_number." ".session::get('ses_dealername'),
								);

		$make_email        	= emailmodel::emailContentsubject(
											$mail_subject,
											$mail_message,
											$mail_params,
											$maildata,
											$mail_subject_data);
		//dd($mail_subject_data);

		$email_sent        = emailmodel::emailSendingAttach(
									$toEmail,
									$make_email,
									$pdf_path);

		$invoiceStatus      = array(
									    'invoice_status_id'=>"2"
									);

		$quotes_id_update  	= invoicemodel::update_quotes(
									$this->dealer_schemaname,
									$invoiceid,
									$invoiceStatus);

		unlink(public_path().'/'.$invoiceValue[0]->invoice_number.'.pdf');

        return redirect()->back()->with('message', 'successfully sent');
	}

	public function doemailMsgInvoice()
	{
		$quotesid           = Input::get('quotes_id');
		$quotes_value       = invoicemodel::quotesvalue(
												$this->dealer_schemaname,
												$this->invoice_table,
												$quotesid);

		$get_client 		= contactsmodel::get_client(
												$this->dealer_schemaname,
												$quotes_value[0]->contact_id);

		$dealer_info 		= dealermodel::dealerdetails_get(
												$this->dealer_schemaname,
												$this->id);

		$dealer_profile 	= dealermodel::dealerprofile($this->id);

		$customer_name 		= $get_client->contact_first_name;

		$customer_email 	= $get_client->contact_email_1;

		$emailTemplate 		= emailmodel::get_email_templates('12');
		//dd($emailTemplate);
		foreach ($emailTemplate as $emailData) 
		{
		    $mail_subject   = $emailData->email_subject;
		    $mail_message   = $emailData->email_message;
		    $mail_params    = $emailData->email_parameters; 
		}

		$maildata          	= array(
								'0' => $quotes_value[0]->invoice_number,
								'1' => session::get('ses_dealername'),
								'2' => $customer_name,
								'3' => $quotes_value[0]->amount,
								'4' => $dealer_info[0]->Address,
								'5' => $dealer_info[0]->phone,
								'6' => $quotes_value[0]->due_date
								);

		$email_template   	= emailmodel::emailContentConstruct(
													$mail_subject,
													$mail_message,
													$mail_params,
													$maildata);
		return $email_template['mail_message'];
	}

	public function doexcel_export(Request $request)
	{
		$invoiceid 			= $request->get('exportinvoice');
		$dealerid 			= Session::get('ses_id');

		$dealer_schemanames = (new branch)->getschemaname($dealerid);

		try
		{
			$fetch_data			= invoicemodel::dealerInvoiceExcel(
												$this->dealer_schemaname,
												$this->invoice_table);
			//dd($fetch_data);

			$whereClient 		= array(
									'contact_type_id' 		=> config::get('common.customer')
									);

			$selectClient		= array(
										'contact_management_id' => 'contact_management_id',
										'contact_first_name' 	=> 'contact_first_name'
										);

			$client		 		= contactsmodel::getcontacts(
										$dealer_schemanames,
										$this->contact_table,
										$whereClient,
										$selectClient
										);

			$invoice_status 	= invoicemodel::statustable();

			$paymentMethod 		= invoicemodel::paymentMethod();

			$excelname 			= "Invoice".time();
			$sheetheading 		= "Invoice";
			$mergecells 		= "A1:O1";
			$sheetArray 		= array();
			$sheetArray[] 		= array('SL No','Invoice Number','Client Name','Amount','Due Date','Invoice Date','Paid','Balance','Status','Terms','Payment Amount','Payment Date','Payment Method');
			foreach($fetch_data  as $i => $row)
			{
				$contactName = "NIL";
				$statusName  = "NIL";
				foreach ($client as $fetchClientName) 
				{
					if($fetchClientName->contact_management_id == $row->contact_id)
					{
						$contactName = $fetchClientName->contact_first_name;
					}
				}

				foreach ($invoice_status as $invoiceStatus) 
				{
					if($invoiceStatus->id == $row->invoice_status_id)
					{
						$statusName = $invoiceStatus->name;
					}
				}

				if($row->invoiceDiscount=="1")
				{
					$invoiceDiscount = "Amount";
				}
				elseif($row->invoiceDiscount=="2")
				{
					$invoiceDiscount = "Percentage";
				}

				if($row->paymentStatus == "1")
				{
					$payName = "CHECK";
				}
				elseif($row->paymentStatus == "2")
				{
					$payName = "CASH";
				}
				elseif($row->paymentStatus == "3")
				{
					$payName = "BANK TRANSFER";
				}
				else
				{
					$payName = "";
				}
				$amount 		= report::moneyFormat($row->amount);
				$paymentAmount 	= report::moneyFormat($row->paymentAmount);
				//$paidAmount 	= 
				$balanceAmount  = report::moneyFormat($row->amount-($row->paymentAmount));

				$sheetArray[] 	= array(++$i,$row->invoice_number,$contactName,$amount,$row->invoiceDueDate,$row->invoice_date,$paymentAmount,$balanceAmount,$statusName,$row->terms,$paymentAmount,$row->paymentDate,$payName);
			}
			exportmodel::generatereport($sheetArray,$sheetheading,$excelname,$mergecells);
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
	}

	// public function delete_invoice_item(Request $request)
	// {
	// 	$whereCondtion 			= "invoice_item_id";
	// 	$whereData 				= $request->get('deleteinvoice');
	// 	$data 					= array(
	// 										'invoice_status_id' 		=> '7',
	// 									);
	// 	$invoice 				=  invoicemodel::update_invoice(
	// 												$this->dealer_schemaname,
	// 												$this->invoice_table_items,
	// 												$whereCondtion,
	// 												$whereData,
	// 												$data);
	// 	return redirect()->back();
	// }

	public function delete_invoice(Request $request)
	{
		$whereCondtion 			= "invoice_id";
		$whereData 				= $request->get('deleteinvoice');
		$data1 					= array(
											'invoice_status_id' 		=> '8',
										);
		$invoice 				=  invoicemodel::update_invoice(
													$this->dealer_schemaname,
													$this->invoice_table,
													$whereCondtion,
													$whereData,
													$data1);
		return redirect()->back();
		//dd($request->get('deleteinvoice'));
	}
}