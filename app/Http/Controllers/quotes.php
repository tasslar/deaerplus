<?php
/*
  Module Name : Manage 
  Created By  : Sreenivasan  08-03-2017
  Use of this module is Quotes
*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use Session;
use App\model\dealermodel;
use App\model\commonmodel;
use App\model\branchesmodel;
use App\model\contactsmodel;
use App\model\invoicemodel;
use App\model\usersmodel;
use App\model\emailmodel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\branch;
use Redirect;
use DateTime;
use Carbon;
use PDF;
use App\model\exportmodel;
use NumberFormatter;

class quotes extends Controller
{
    public $active_menu_name;
    public $header_data;
    public $side_bar_active;
    public $login_authecation;
    public $side_bar_customer;
    public $side_bar_contacts;
    public $p_id;
    public $id;
    public $contact_table;
    public $car_listing_tbl;
    public $invoice_table;
    public $user_table;
    public $invoice_table_items;
    public function __construct()
    {           
        $this->active_menu_name         = config::get('common.accounts');
        $this->masterMainLoginTable     = "dms_dealers";
        $this->contact_table            = "dealer_contact_management";
        $this->car_listing_tbl          = 'dealer_listing_pricing';
        $this->side_bar_active          = config::get('common.quotessidebar');
        $this->invoice_table            = "dealer_invoices";
        $this->invoice_table_items      = "dealer_invoice_items";
        $this->user_table               = "user_account";
        $this->middleware(function ($request, $next) 
            {
            $this->id                   = session::get('ses_id');
            $this->p_id                 = dealermodel::parent_id($this->id);
            $this->login_authecation    = session()->has( 'ses_dealername' ) ? session()->get( 'ses_dealername' ) :  Redirect::to('login')->send();
            $this->header_data          = commonmodel::commonheaderdata();
            $this->header_data['title'] ='Accounts';
            $this->header_data['p_id']  =$this->p_id;
            $this->dealer_schemaname    = (new branch)->getschemaname($this->id);
            return $next($request);
            }
        );                              
    }
    public function doaddquotes()
    {
        $date                           = Carbon\Carbon::now()->format("Y-m-d");            	
        $car_listing                    = invoicemodel::car_lisitng($this->dealer_schemaname,$this->car_listing_tbl);
    	$client                         = contactsmodel::getcontacts($this->dealer_schemaname,$this->contact_table);    	   
        $last_day_this_month            = date('Y-m-t');
    	$header_data					= $this->header_data;
    	$compact_array					= array(
    												'active_menu_name'     =>$this->active_menu_name,

    												'side_bar_active'      =>$this->side_bar_active,

    												'client'               =>$client,

                                                    'date'                 =>$date,

                                                    'car_listing'          =>$car_listing,

                                                    'last_day_this_month'  => $last_day_this_month
    											);    	
    	return view('myaddquotes',compact('compact_array','header_data'));
    }
    public function docar_price()
    {        
        $car_id       = Input::get('car_id');
        if($car_id)
        {
            $where        = array('car_id'=>$car_id);
            $car_price    = invoicemodel::car_price($this->dealer_schemaname,$this->car_listing_tbl,$where);
            return $car_price->saleprice;    
        }
        else
        {
            return "";
        }
        

    }  
    public function doinsertquotes()
    {

        //dd($_POST);
        /*$user_id                        = dealermodel::parent_id($this->id);
        if($user_id == 0)
        {
            $user_id = session::get('d_id');
        }
        else
        {
            $user_id = dealermodel::primaryuser_id(session::get('d_id'));
        }*/
        $user_id                      = dealermodel::parent_id($this->id);
        $client                       =  Input::get('client'); 
        $product                    = Input::get('product');
        if($user_id == 0)
        {
            $user_id = 1;
        }
        else
        {
            $user_id = usersmodel::user_id($this->dealer_schemaname,$this->user_table,$this->id);
            $user_id = $user_id->user_id;
        }
        if($client == '' || $product == '')
        {
            Session::flash('message', "client name missing !");
            return Redirect::back();
        }
        $reference                      =  Input::get('reference');
        $invoiceDiscount                =  Input::get('invoiceDiscount');
        $invoiceDiscountType            =  Input::get('invoiceDiscountType');
        $grand_total                    =  Input::get('grand_total');                
        $start_date                     =  Input::get('estimate_date');
        $end_date                       =  Input::get('expiry_date');                
        $term_cond                      =  Input::get('term_cond');
        $description                    =  Input::get('description'); 
        $finaldiscounts                    =  Input::get('finaldiscounts'); 
        $invoice_number                 =  invoicemodel::quotes_id();
        //dd($invoice_number);
        $data                           =  array(
                                                    'contact_id'            =>$client,
                                                    'dealer_id'             =>$this->id,
                                                    'user_id'               =>$this->id,
                                                    'invoice_number'        =>$invoice_number,
                                                    'discount'              =>$invoiceDiscount,
                                                    'terms'                 =>$term_cond,
                                                    'start_date'            =>$start_date,
                                                    'end_date'              =>$end_date,              
                                                    'reference'             =>$reference,
                                                    'invoice_discount_type' => $invoiceDiscountType,
                                                    'amount'                =>$grand_total,
                                                    'public_notes'          =>$description,
                                                    'po_number'             =>$finaldiscounts,

                                                );
        $invoice                        = invoicemodel::insert($this->dealer_schemaname,$this->invoice_table,$data);
        $quotes_id                      = array(
                                                    'quote_id'=>$invoice,
                                                    'invoice_status_id'=>config::get('common.status_draft')
                                                );
        $quotes_id_update               = invoicemodel::update_quotes($this->dealer_schemaname,$invoice,$quotes_id);  
        //dd($quotes_id_update);
        if($invoice)
        {
            $product                    = Input::get('product');
            $cardescription             = Input::get('cardescription');
            $quantity                   = Input::get('quantity');
            $price                      = Input::get('price');
            $taxrate                    = Input::get('taxrate');
            $discount                   = Input::get('discount');
            $type                       = Input::get('type');
            $subtotal                   = Input::get('subtotal');            
            foreach ($product as $fetch =>$key) 
            {
                $car_items = [                            
                    'product_id'    => $product[$fetch], 
                    'notes'         => $cardescription[$fetch],                           
                    'qty'           => $quantity[$fetch],
                    'cost'          => $price[$fetch],
                    'tax_rate1'     => $taxrate[$fetch],
                    'discount'      => $discount[$fetch],
                    'discount_type' => $type[$fetch],
                    'sub_total'     => $subtotal[$fetch],
                    'dealer_id'     => $this->id,
                    'user_id'       => $user_id,
                    'invoice_id'    => $invoice
                        ];                  
                $invoice_itemsadded = invoicemodel::car_items_insert($this->dealer_schemaname,$this->invoice_table_items,$car_items);    
            }
            
                return redirect('managequotes')->with('message', 'Successfully added');
        }

    }
    public function domanagequotes()
    {
        $header_data                    = $this->header_data;  
        $header_data['title']           = "Quotes List";
        $dealer_invoice                 = invoicemodel::dealer_quotes_select($this->dealer_schemaname);  
        $dealer_invoice_count           = invoicemodel::count($this->dealer_schemaname,$this->invoice_table); 
        $status                         = invoicemodel::statustable(); 
        $i = config::get('common.quotescount');
        foreach($dealer_invoice as $value)
        {
            $value->sno = $i;
            $client                         = contactsmodel::getcontactselect($this->dealer_schemaname,$this->contact_table,$value->contact_id);
            $qoutesvalue = encrypt($value->invoice_id);
            $value->pdfvalue =  $qoutesvalue;
            if(count($client)>0){
                $value->contact_id = $client[0]->contact_first_name;
            }
            else
            {
                $value->contact_id = 0;   
            }
            $i++;
        }        
        $compact_array                  = array(
                                                    'active_menu_name' =>$this->active_menu_name,

                                                    'side_bar_active'  =>$this->side_bar_active,

                                                    'dealer_invoice'   =>$dealer_invoice,

                                                    'status'           =>$status,

                                                    'dealer_invoice_count' => $dealer_invoice_count
                                                );      
        return view('manage_quotes',compact('compact_array','header_data'));  
    }
    public function doemailmsg()
    {
        $quotesid                       = Input::get('quotes_id');
        $quotes_value                   = invoicemodel::quotesvalue($this->dealer_schemaname,$this->invoice_table,$quotesid);
        $get_client                     = contactsmodel::get_client($this->dealer_schemaname,$quotes_value[0]->contact_id);
        $dealer_info                    = dealermodel::dealerdetails_get($this->dealer_schemaname,$this->id);
        $dealer_profile                 = dealermodel::dealerprofile($this->id);
        $customer_name                  = $get_client->contact_first_name;
        $customer_email                 = $get_client->contact_email_1;
        $emailTemplate                  = emailmodel::get_email_templates(config::get('common.quotestemplate'));
        foreach ($emailTemplate as $emailData) 
        {
            $mail_subject   = $emailData->email_subject;
            $mail_message   = $emailData->email_message;
            $mail_params    = $emailData->email_parameters; 
        }
        $maildata          = array(
                                    '0' => $quotes_value[0]->invoice_number,
                                    '1' => session::get('ses_dealername'),
                                    '2' => $customer_name,
                                    '3' => $quotes_value[0]->amount,
                                    '4' => $dealer_info[0]->Address,
                                    '5' => $dealer_info[0]->phone,
                                    '6' => $quotes_value[0]->end_date
                                    );
        $email_template   = emailmodel::emailContentConstruct($mail_subject,$mail_message,$mail_params,$maildata);
        return $email_template['mail_message'];
        
    }
    public function doeditquotes()
    {
        $id                             = session::get('ses_id');                
        $date                           = Carbon\Carbon::now()->format("Y-m-d");                
        $editquotes                     = Input::get('editquotes');
        $editquotesvalue                = invoicemodel::editvalue($this->dealer_schemaname,$editquotes);        
        $editquotes_items               = invoicemodel::invoice_items($this->dealer_schemaname,$editquotes);    
        $car_listing                    = invoicemodel::car_lisitng($this->dealer_schemaname,$this->car_listing_tbl);
        $client                         = contactsmodel::getcontacts($this->dealer_schemaname,$this->contact_table); 
         $i = config::get('common.quotescount');
        foreach($editquotes_items as $value)
        {
            $value->sno = $i;
            $i++;
        }            
        $header_data                    = $this->header_data;
        $compact_array                  = array(
                                                    'active_menu_name' =>$this->active_menu_name,

                                                    'side_bar_active'  =>$this->side_bar_active,

                                                    'client'           =>$client,

                                                    'date'             =>$date,

                                                    'car_listing'      =>$car_listing,

                                                    'editquotesvalue'  =>$editquotesvalue,

                                                    'editquotes_items' =>$editquotes_items,

                                                    'editquotes'       =>$editquotes

                                                ); 
        return view('edit_quotes',compact('compact_array','header_data'));
    }
    public function doupdatequotes()
    {        
        $user_id                = dealermodel::parent_id($this->id);
        if($user_id == 0)
        {
            $user_id = 1;
        }
        else
        {
            $user_id = usersmodel::user_id($this->dealer_schemaname,$this->user_table,$this->id);
            $user_id = $user_id->user_id;
        }
        $client                         =  Input::get('client');        
        $reference                      =  Input::get('reference');
        $editid                         =  Input::get('editid'); 
        $invoiceDiscount                =  Input::get('invoiceDiscount');
        $invoiceDiscountType            =  Input::get('invoiceDiscountType');
        $grand_total                    =  Input::get('grand_total');                
        $start_date                     =  Input::get('estimate_date');
        $end_date                       =  Input::get('expiry_date');                
        $term_cond                      =  Input::get('term_cond');
        $description                    =  Input::get('description'); 
        $finaldiscounts                 =  Input::get('finaldiscounts'); 
       // $invoice_number                 =  invoicemodel::quotes_id();
        $data                           =  array(
                                                    //'contact_id'            =>$client,
                                                    'dealer_id'             =>$this->id,
                                                    'user_id'               =>$this->id,
                                                    //'invoice_number'        =>$invoice_number,
                                                    'discount'              =>$invoiceDiscount,
                                                    'terms'                 =>$term_cond,
                                                    'start_date'            =>$start_date,
                                                    'end_date'              =>$end_date,              
                                                    'reference'             =>$reference,
                                                    'invoice_discount_type' => $invoiceDiscountType,
                                                    'amount'                =>$grand_total,
                                                    'public_notes'          =>$description,
                                                    'po_number'             =>$finaldiscounts,
                                                );
        $invoice                        = invoicemodel::update_invoice_value($this->dealer_schemaname,$editid,$data);
        //dd($invoice);
        $quotesvalue                 = array(
                                                    'quote_id'=>$invoice,
                                                    'invoice_status_id'=>config::get('common.status_draft')
                                                );
        $quotes_id_update               = invoicemodel::update_quotes($this->dealer_schemaname,$editid,$quotesvalue);  
         /*$invoice_itemsadded = invoicemodel::car_items_delete($this->dealer_schemaname,$editid);*/
        //dd($quotes_id_update);
        if($invoice)
        {
            $product                    = Input::get('product');
            $cardescription             = Input::get('cardescription');
            $quantity                   = Input::get('quantity');
            $price                      = Input::get('price');
            $taxrate                    = Input::get('taxrate');
            $quotes_id                  = Input::get('quotes_id');  
            $discount                   = Input::get('discount');
            $type                       = Input::get('type');
            $subtotal                   = Input::get('subtotal');            
            foreach ($product as $fetch =>$key) 
            {
                $car_items = [                            
                    'product_id'    => $product[$fetch], 
                    'notes'         => $cardescription[$fetch],                           
                    'qty'           => $quantity[$fetch],
                    'cost'          => $price[$fetch],
                    'tax_rate1'     => $taxrate[$fetch],
                    'discount'      => $discount[$fetch],
                    'discount_type' => $type[$fetch],
                    'sub_total'     => $subtotal[$fetch],
                    'dealer_id'     => $this->id,
                    'user_id'       => $user_id,
                   'invoice_id'    => $editid

                        ];                  
             /*$invoice_itemsadded = invoicemodel::car_items_insert($this->dealer_schemaname,$this->invoice_table_items,$car_items);    */
             $invoice_itemsadded    = invoicemodel::update_invoice_items(
                                                    $this->dealer_schemaname,
                                                    $this->invoice_table_items,
                                                    $quotes_id[$fetch],
                                                    $car_items);  
            }
            //dd($invoice_itemsadded);
        }
            return redirect('managequotes')->with('message', 'Successfully updated');
    }
    public function deletequotes()
    {
        $delete_id              = Input::get('deletequotes');
        $value                  = array(
                                            'invoice_status_id'         => config::get('common.status_delete'),
                                        );
        $invoice                =  invoicemodel::deletevalue($this->dealer_schemaname,$delete_id,$value);
        return redirect()->back()->with('message-err', 'Successfully deleted');
    }
    public function doquote_price()
    {        
        $car_id           =  Input::get('car_id');
        $invoice_item_id  =  Input::get('invoice_item_id');
        $invoice_id       =  Input::get('invoice_id');
        $carprice_check   =  invoicemodel::carprice_check($this->dealer_schemaname,$invoice_id,$car_id,$invoice_item_id);
        return $carprice_check;
    }
    public function doexport_quotes(Request $request,$quotesid)
    {       
        $quotesid = decrypt($quotesid);                        
        $dealer_profile     = dealermodel::dealerprofile($this->id);
        if(empty($dealer_profile->company_logo))
        {
            $dealer_profile->company_logo = $defaultlogo = url('img/logo.png'); 
        }
        elseif($dealer_profile->company_logo == 'http://52.221.57.201/dev/public/img/noimage.jpg') 
        {
            $dealer_profile->company_logo = $defaultlogo = url('img/logo.png'); 
        }        
        $car_lisitng        = invoicemodel::car_lisitng($this->dealer_schemaname,$this->car_listing_tbl);
        $quotes_value       = invoicemodel::quotesvalue($this->dealer_schemaname,$this->invoice_table,$quotesid);
        $get_client         = contactsmodel::get_client($this->dealer_schemaname,$quotes_value[0]->contact_id);
        $quotes_car_value   = invoicemodel::quotesvalue($this->dealer_schemaname,$this->invoice_table_items,$quotesid);
        $totaldiscountvalue = 0;
        $overalltotal = 0;
        foreach($quotes_car_value as $car_value)
        {
            $discount_amount =  commonmodel::discountcalc($car_value->cost,$car_value->tax_rate1,$car_value->discount,$car_value->discount_type,$car_value->sub_total);
            $car_value->sumofdiscount = $discount_amount;
            $car_value->discountamt = $discount_amount;
            $totaldiscountvalue = $totaldiscountvalue + $car_value->sumofdiscount;
            $overalltotal = $overalltotal + $car_value->sub_total;

        }             
        $overalldis =  commonmodel::overalldiscount($overalltotal,$quotes_value[0]->invoice_discount_type,$quotes_value[0]->discount);
        $quotes_value[0]->discount = $overalldis;
        $overalldiscount = $totaldiscountvalue + $quotes_value[0]->discount;
        $number             = $quotes_value[0]->amount;
        $numberconvert      = new NumberFormatter("en", NumberFormatter::SPELLOUT);    
        $getNumberWords     = $numberconvert->format($number);        
        $getNumberWords     = commonmodel::convert_number_to_words($getNumberWords);
        $dealer_info        = dealermodel::dealerdetails_get($this->dealer_schemaname,$this->id);
        $city               = commonmodel::get_master_city();    
        $state              = commonmodel::get_master_state(); 
        $date               = Carbon\Carbon::now()->format("Y-m-d");         
        //dd($getNumberWords);
        $compact_array      = array(
                                         'car_lisitng'     => $car_lisitng,

                                         'getNumberWords'  => $getNumberWords,

                                         'quotes_value'    => $quotes_value,

                                         'quotes_car_value'=> $quotes_car_value,

                                         'get_client'      => $get_client,

                                         'dealer_info'     => $dealer_info,

                                         'dealer_profile'  => $dealer_profile,

                                         'city'            => $city,

                                         'state'           => $state,

                                         'date'            => $date,

                                         'overalldiscount' => $overalldiscount     

                                    );     
        //dd($compact_array['quotes_value']);
        //dd($compact_array['client']);
        //return view('invoice_pdf',compact('compact_array','invoice_main'));
        $pdf               = PDF::loadView('quotespdf', compact('compact_array'))
                                        ->setPaper('a3', 'portrait');
         return $pdf->stream('quotes.pdf');
    }

    public function export_quotes_excel()
    {
        try
        {
            $fetch_data         = invoicemodel::dealer_quotes_select($this->dealer_schemaname);

            $client             = contactsmodel::getcontacts($this->dealer_schemaname,
                                                            $this->contact_table);

            $status             = invoicemodel::statustable();

            $paymentMethod      = invoicemodel::paymentMethod();

            $excelname          = "My Quotes".time();
            $sheetheading       = "Quotes";
            $mergecells         = "A1:K1";
            $sheetArray         = array();
            $sheetArray[]       = array('SL No','Client Name','Reference','Estimated Date','Expiry Date','Discount Type','Discount','Total','Description','Terms and Conditions','Quotes status');
            foreach($fetch_data  as $i => $row)
            {
                $contactName    = "NIL";
                $statusName     = "NIL";
                foreach ($status as $quotesStatus) 
                {
                    if($quotesStatus->id == $row->invoice_status_id)
                    {
                        $statusName = $quotesStatus->name;
                    }
                }

                foreach ($client as $fetchClientName) 
                {
                    if($fetchClientName->contact_management_id == $row->contact_id)
                    {
                        $contactName = $fetchClientName->contact_first_name;
                    }
                }

                $sheetArray[]   = array(++$i,$contactName,$row->reference,$row->start_date,$row->end_date,$row->invoice_discount_type,$row->discount,$row->amount,$row->public_notes,$row->terms,$statusName);
            }
            exportmodel::generatereport($sheetArray,$sheetheading,$excelname,$mergecells);
        }
        catch(\Exception $e)
        {
            return $e->getMessage();
        }

    }
    public function doquotesemail()
    {
        $quotesid          = Input::get('quotes_id');  
        //dd($quotesid); 
        //$pdf_download       =  $this->doexport_quotes($quotes_id);
        //dd($pdf_download);                   
        $quotes_value       = invoicemodel::quotesvalue($this->dealer_schemaname,$this->invoice_table,$quotesid);
        $emailTemplate      = emailmodel::get_email_templates(config::get('common.quotestemplate'));
        foreach ($emailTemplate as $emailData) 
        {
            $mail_subject   = $emailData->email_subject;
            $mail_message   = $emailData->email_message;
            $mail_params    = $emailData->email_parameters; 
        }
        //dd($mail_subject);
        $car_lisitng        = invoicemodel::car_lisitng($this->dealer_schemaname,$this->car_listing_tbl);
        $quotes_value       = invoicemodel::quotesvalue($this->dealer_schemaname,$this->invoice_table,$quotesid);
        $get_client         = contactsmodel::get_client($this->dealer_schemaname,$quotes_value[0]->contact_id);
        $quotes_car_value   = invoicemodel::quotesvalue($this->dealer_schemaname,$this->invoice_table_items,$quotesid);
        $totaldiscountvalue = 0;
        $overalltotal = 0;
        foreach($quotes_car_value as $car_value)
        {
            $discount_amount =  commonmodel::discountcalc($car_value->cost,$car_value->tax_rate1,$car_value->discount,$car_value->discount_type,$car_value->sub_total);
            $car_value->sumofdiscount = $discount_amount;
            $car_value->discountamt = $discount_amount;
            $totaldiscountvalue = $totaldiscountvalue + $car_value->sumofdiscount;
            $overalltotal = $overalltotal + $car_value->sub_total;
        }  
        $overalldis =  commonmodel::overalldiscount($overalltotal,$quotes_value[0]->invoice_discount_type,$quotes_value[0]->discount);
        $quotes_value[0]->discount = $overalldis;
        $overalldiscount = $totaldiscountvalue + $quotes_value[0]->discount;
        $numberconvert      = new NumberFormatter("en", NumberFormatter::SPELLOUT);    
        $getNumberWords     = $numberconvert->format($quotes_value[0]->amount); 
        $getNumberWords     = commonmodel::convert_number_to_words($getNumberWords);
        $dealer_info        = dealermodel::dealerdetails_get($this->dealer_schemaname,$this->id);
        $dealer_profile     = dealermodel::dealerprofile($this->id);        
        if(empty($dealer_profile->company_logo))
        {
            $dealer_profile->company_logo = $defaultlogo = url('img/logo.png'); 
        }
        elseif($dealer_profile->company_logo == 'http://52.221.57.201/dev/public/img/noimage.jpg') 
        {
            $dealer_profile->company_logo = $defaultlogo = url('img/logo.png'); 
        }        
        $city               = commonmodel::get_master_city();    
        $state              = commonmodel::get_master_state();    
        $date               = Carbon\Carbon::now()->format("Y-m-d");   
        //dd($getNumberWords);
        $compact_array      = array(
                                         'car_lisitng'     => $car_lisitng,

                                         'getNumberWords'  => $getNumberWords,

                                         'quotes_value'    => $quotes_value,

                                         'quotes_car_value'=> $quotes_car_value,

                                         'get_client'      => $get_client,

                                         'dealer_info'     => $dealer_info,

                                         'dealer_profile'  => $dealer_profile,

                                         'city'            => $city,

                                         'state'           => $state,

                                         'date'            => $date,

                                         'overalldiscount' => $overalldiscount     

                                    );     
        //dd($compact_array['client']);
        //return view('invoice_pdf',compact('compact_array','invoice_main'));
        //$pdfpath           = public_path('uploadimages'.'/'.$this->dealer_schemaname.'/'.'quotespdf'.'/'); 
        $pdf               = PDF::loadView('quotespdf', compact('compact_array'))
                                        ->setPaper('a3', 'portrait')
                                        //->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif'])
                                        ->save(public_path().'/'.'uploadimages'.'/'.$this->dealer_schemaname.'/'.$quotes_value[0]->invoice_number.'.pdf');
        $pdf_path          = public_path().'/'.'uploadimages'.'/'.$this->dealer_schemaname.'/'.$quotes_value[0]->invoice_number.'.pdf';
        $customer_name     = $get_client->contact_first_name;
        $customer_email    = $get_client->contact_email_1;
        $maildata          = array(
                                    '0' => $quotes_value[0]->invoice_number,
                                    '1' => session::get('ses_dealername'),
                                    '2' => $customer_name,
                                    '3' => $quotes_value[0]->amount,
                                    '4' => $dealer_info[0]->Address,
                                    '5' => $dealer_info[0]->phone,
                                    '6' => $quotes_value[0]->end_date
                                    );
        $mail_subject_data = array(
                                    '0' => '[Quotes] Quotes',
                                    '1' => $quotes_value[0]->invoice_number,
                                    '2' => session::get('ses_dealername'),
                                  );

        $make_email        = emailmodel::emailContentsubject($mail_subject,$mail_message,$mail_params,$maildata,$mail_subject_data);        

        $email_sent        = emailmodel::emailSendingAttach($customer_email,$make_email,$pdf_path);
        $quotesvalue       = array(
                                        'invoice_status_id'=>config::get('common.status_send')
                                   );
        $quotes_id_update  = invoicemodel::update_quotes($this->dealer_schemaname,$quotesid,$quotesvalue);
        unlink(public_path().'/'.'uploadimages'.'/'.$this->dealer_schemaname.'/'.$quotes_value[0]->invoice_number.'.pdf');
        return redirect()->back()->with('message', 'successfully sent');            

    }
}
