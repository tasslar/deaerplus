<?php
/*
	Module Name : Invoice 
	Created By  : HARIKRISHNAN R 09-03-2017 Version 1.0
	This module handle with Invoice 
*/

namespace App\model;
use DB;
use Config;
use Illuminate\Database\Eloquent\Model;
use App\model\schemaconnection;

class invoicemodel extends Model
{

	public static function invoicecode()
	{
		$query 	= schemaconnection::dmsmysqlconnection()
								->table('dealer_invoices')
								->select('invoice_number')
								->orderBy('invoice_id','DESC')
								->limit(1)
								->where('invoice_number','!=',"")
								->get();
		if(isset($query[0]))
		{
			$number 			= preg_split('/(,?\s+)|((?<=[a-z])(?=\d))|((?<=\d)(?=[a-z]))/i', $query[0]->invoice_number);
			$invoicecode 		= "I000".($number[1]+1);
			//dd($invoicecode);
		}
		else
		{
			$invoicecode = "I0001";
		}
		// $code = $query[0]->invoice_id;
		//dd($invoicecode);
		return $invoicecode;
	}

	public static function car_lisitng($dealer_schemaname,$tablename)
	{
		commonmodel::doschemachange($dealer_schemaname);
		$car_data	=	schemaconnection::dmsmysqlconnection()
								->table($tablename)
								->get();
		return $car_data;
	}

	public static function count($dealer_schemaname,$tablename)
	{
		commonmodel::doschemachange($dealer_schemaname);
		$car_data_count	=	schemaconnection::dmsmysqlconnection()
								->table($tablename)
								->where('invoice_status_id','=',config::get('common.status_draft'))
								->where('invoice_number','!=',"")
								->whereNotNull('quote_id')
								->count();
								//dd($car_data_count);
		return $car_data_count;
	}

	public static function car_price($dealer_schemaname,$tablename,$where)
	{
		commonmodel::doschemachange($dealer_schemaname);
		$car_data	= 	schemaconnection::dmsmysqlconnection()
								->table($tablename)
								->where($where)
								->first();
		return $car_data;
	}

	public static function getAllInvoiceCode($dealer_schemaname,$invoice_number,$tablename)
	{
		commonmodel::doschemachange($dealer_schemaname);
		return schemaconnection::dmsmysqlconnection()
								->table($tablename)
								->where('invoice_number',$invoice_number)
								->first();
	}

	public static function getcontacts($dealer_schemaname,$tablename){
        commonmodel::doschemachange($dealer_schemaname);
        $insertwithid = schemaconnection::dmsmysqlconnection()
										->table($tablename)
										//->where('contact_status',config::get('common.contact_status_active'))
										->select('contact_management_id','contact_first_name','contact_phone_1','contact_email_1')
										->orderBy('contact_first_name', 'asc')
										->get();
        return $insertwithid; 
    }

	public static function insert($dealer_schemaname,$tablename,$data)
	{
		commonmodel::doschemachange($dealer_schemaname);
		$invoice	= 	schemaconnection::dmsmysqlconnection()
								->table($tablename)
								->insertGetId($data);
		return $invoice;
	}

	public static function car_items_insert($dealer_schemaname,$tablename,$car_items)
	{
		commonmodel::doschemachange($dealer_schemaname);
		$invoice_items	= 	schemaconnection::dmsmysqlconnection()
								->table($tablename)
								->insertGetId($car_items);
		return $invoice_items;	
	}

	public static function insertPayment($dealer_schemaname,$tablename,$insertData)
	{
		commonmodel::doschemachange($dealer_schemaname);
		return schemaconnection::dmsmysqlconnection()
								->table($tablename)
								->insert($insertData);
	}

	public static function car_items_delete($dealer_schemaname,$id)
	{
		commonmodel::doschemachange($dealer_schemaname);
			$delete_items	= 	schemaconnection::dmsmysqlconnection()
									->table('dealer_invoice_items')
									->where('invoice_id',$id)
									->delete();	
	}
	public static function dealer_invoice($dealer_schemaname,$tablename)
	{
		commonmodel::doschemachange($dealer_schemaname);
		$car_items	= 	schemaconnection::dmsmysqlconnection()
								->table($tablename)
								->get();
		return $car_items;	
	}	

	public static function editvalue($dealer_schemaname,$editquotes)
	{
		commonmodel::doschemachange($dealer_schemaname);
		$invoice	= 	schemaconnection::dmsmysqlconnection()
								->table('dealer_invoices')
								->where('invoice_id',$editquotes)
								->first();
		return $invoice;	
	}

	public static function deletevalue($dealer_schemaname,$id,$value)
	{
		commonmodel::doschemachange($dealer_schemaname);
		return schemaconnection::dmsmysqlconnection()
								->table('dealer_invoices')
								->where('invoice_id',$id)
								->update($value);	
	}

	public static function dealer_invoice_select($dealer_schemaname,$tablename)
	{
		commonmodel::doschemachange($dealer_schemaname);
		return	schemaconnection::dmsmysqlconnection()
								->table($tablename)
								->where('invoice_number','!=',"")
								->where('invoice_status_id','!=','8')
								->whereNull('quote_id')
								->leftjoin('dealer_payments','dealer_payments.invoice_id','=',$tablename.'.invoice_id')
								->select($tablename.'.invoice_id','invoice_number',$tablename.'.contact_id',$tablename.'.amount as invoiceAmount',$tablename.'.due_date as invoiceDuedate','invoice_status_id',DB::raw('SUM(dealer_payments.amount) as totalPaidAmount'))
								->groupBy($tablename.'.invoice_id')
								->get();
	}

	public static function dealer_quotes_select($dealer_schemaname)
	{
		commonmodel::doschemachange($dealer_schemaname);
		$car_items	= 	schemaconnection::dmsmysqlconnection()
								->table('dealer_invoices')
								->where('invoice_status_id','!=',config::get('common.status_delete'))
								->where('invoice_number','!=',"")
								->whereNotNull('quote_id')
								->get();
		return $car_items;
	}

	public static function getdate($dealer_schemaname,$tablename,$invoiceid)
	{
		commonmodel::doschemachange($dealer_schemaname);
		$car_items	= 	schemaconnection::dmsmysqlconnection()
								->table($tablename)
								->select('due_date','invoice_id')
								->where('invoice_id',$invoiceid)
								->get();
		return $car_items;	
	}

	public static function do_getInvoicePayments($dealer_schemaname,$tablename,$invoiceid)
	{
		commonmodel::doschemachange($dealer_schemaname);
		return schemaconnection::dmsmysqlconnection()
								->table($tablename)
								->select('invoice_id','amount','payment_date','payment_type_id')
								->where('invoice_id',$invoiceid)
								->get();
	}

	public static function do_getInvoicePaymentsWithAmount($dealer_schemaname,$tablename,$invoiceid)
	{
		commonmodel::doschemachange($dealer_schemaname);
		return schemaconnection::dmsmysqlconnection()
								->table($tablename)
								->select('dealer_invoices.amount as fullAmount',DB::raw('SUM(dealer_payments.amount) as totalPaidAmount'))
								->where($tablename.'.invoice_id',$invoiceid)
								->join('dealer_invoices','dealer_invoices.invoice_id','=','dealer_payments.invoice_id')
								->groupBy($tablename.'.invoice_id')
								->get();
	}

	public static function dogetInvoiceStatus($dealer_schemaname,$tablename,$invoiceid)
	{
		commonmodel::doschemachange($dealer_schemaname);
		return schemaconnection::dmsmysqlconnection()
								->table($tablename)
								//->select('invoice_id','amount','payment_date','payment_type_id')
								->where('invoice_id',$invoiceid)
								->get();
	}

	public static function convert_number_to_words($number)
	{
		$hyphen      = '-';
		$conjunction = ' and ';
		$separator   = ', ';
		$negative    = 'negative ';
		$decimal     = ' point ';
		$dictionary  = array(
							    0                   => 'Zero',
							    1                   => 'One',
							    2                   => 'Two',
							    3                   => 'Three',
							    4                   => 'Four',
							    5                   => 'Five',
							    6                   => 'Six',
							    7                   => 'Seven',
							    8                   => 'Eight',
							    9                   => 'Nine',
							    10                  => 'Ten',
							    11                  => 'Eleven',
							    12                  => 'Twelve',
							    13                  => 'Thirteen',
							    14                  => 'Fourteen',
							    15                  => 'Fifteen',
							    16                  => 'Sixteen',
							    17                  => 'Seventeen',
							    18                  => 'Eighteen',
							    19                  => 'Nineteen',
							    20                  => 'Twenty',
							    30                  => 'Thirty',
							    40                  => 'Fourty',
							    50                  => 'Fifty',
							    60                  => 'Sixty',
							    70                  => 'Seventy',
							    80                  => 'Eighty',
							    90                  => 'Ninety',
							    100                 => 'Hundred',
							    1000                => 'Thousand',
							    1000000             => 'Lakhs',
							    1000000000          => 'Crores',
							    1000000000000       => 'Trillion',
							    1000000000000000    => 'Quadrillion',
							    1000000000000000000 => 'Quintillion'
							);

		if (!is_numeric($number)) {
		    return false;
		}

		if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
		    // overflow
		    trigger_error(
		        'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
		        E_USER_WARNING
		    );
		    return false;
		}

		if ($number < 0) {
		    return $negative . invoicemodel::convert_number_to_words(abs($number));
		}

		$string = $fraction = null;

		if (strpos($number, '.') !== false) {
		    list($number, $fraction) = explode('.', $number);
		}

		switch (true) {
		    case $number < 21:
		        $string = $dictionary[$number];
		        break;
		    case $number < 100:
		        $tens   = ((int) ($number / 10)) * 10;
		        $units  = $number % 10;
		        $string = $dictionary[$tens];
		        if ($units) {
		            $string .= $hyphen . $dictionary[$units];
		        }
		        break;
		    case $number < 1000:
		        $hundreds  = $number / 100;
		        $remainder = $number % 100;
		        $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
		        if ($remainder) {
		            $string .= $conjunction . invoicemodel::convert_number_to_words($remainder);
		        }
		        break;
		    default:
		        $baseUnit = pow(1000, floor(log($number, 1000)));
		        $numBaseUnits = (int) ($number / $baseUnit);
		        $remainder = $number % $baseUnit;
		        $string = invoicemodel::convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
		        if ($remainder) {
		            $string .= $remainder < 100 ? $conjunction : $separator;
		            $string .= invoicemodel::convert_number_to_words($remainder);
		        }
		        break;
		}

		if (null !== $fraction && is_numeric($fraction)) {
		    $string .= $decimal;
		    $words = array();
		    foreach (str_split((string) $fraction) as $number) {
		        $words[] = $dictionary[$number];
		    }
		    $string .= implode(' ', $words);
		}

		return $string;
	}

	public static function invoicemain($dealer_schemanames,$table,$invoiceid)
	{
		return DB::connection('dmsmysql')
					->table($table)
					->where('invoice_id',$invoiceid)
					->get();
		// commonmodel::doschemachange($dealer_schemanames);
		// return DB::connection('dmsmysql')
		// 			->table($table)
		// 			->where('invoice_id','18')
		// 			->get();
	}

	public static function invoicesub($dealer_schemanames,$table,$invoiceid)
	{
		return DB::connection('dmsmysql')
					->table($table)
					->where('invoice_id',$invoiceid)
					->get();
		// commonmodel::doschemachange($dealer_schemanames);
		// return DB::connection('dmsmysql')
		// 			->table($table)
		// 			->where('invoice_id','9')
		// 			->get();
	}

	public static function getInvoicePayments($dealer_schemanames,$table,$invoiceid)
	{
		return DB::connection('dmsmysql')
					->table($table)
					->where('invoice_id',$invoiceid)
					->get();
	}

	public static function update_invoice($dealer_schemaname,$tablename,$whereCondtion,$whereData,$data)
	{
		commonmodel::doschemachange($dealer_schemaname);
		return schemaconnection::dmsmysqlconnection()
								->table($tablename)
								->where($whereCondtion,$whereData)
								->update($data);
	}

	public static function update_invoice_value($dealer_schemaname,$id,$data)
	{						
		commonmodel::doschemachange($dealer_schemaname);
		return schemaconnection::dmsmysqlconnection()
								->table('dealer_invoices')
								->where('invoice_id','=',$id)
								->update($data);
	}

	public static function getInvoiceItems($dealer_schemaname,$tablename,$whereData2)
	{
		commonmodel::doschemachange($dealer_schemaname);
		return schemaconnection::dmsmysqlconnection()
								->table($tablename)
								->where('invoice_item_id',$whereData2)
								->get();
	}

	public static function invoice_items($dealer_schemaname,$id)
	{
		commonmodel::doschemachange($dealer_schemaname);
		return schemaconnection::dmsmysqlconnection()
								->table('dealer_invoice_items')
								->where('invoice_id',$id)
								->get();
	}

	public static function update_invoice_items($dealer_schemaname,$tablename,$whereData2,$data)
	{
		commonmodel::doschemachange($dealer_schemaname);
		return schemaconnection::dmsmysqlconnection()
								->table($tablename)
								->where('invoice_item_id',$whereData2)
								->update($data);
	}

	public static function update_quotes($dealer_schemaname,$id,$data)
	{
		commonmodel::doschemachange($dealer_schemaname);
		$update =  schemaconnection::dmsmysqlconnection()
								->table('dealer_invoices')
								->where('invoice_id',$id)
								->update($data);
		return $update;
	}

	public static function quotes_id()
	{
		$query 	= schemaconnection::dmsmysqlconnection()
								->table('dealer_invoices')
								->select('invoice_number')
								->orderBy('invoice_id','DESC')
								->limit(1)
								->where('invoice_number','!=',"")
								->get();
		if(isset($query[0]))
		{
			$number 			= preg_split('/(,?\s+)|((?<=[a-z])(?=\d))|((?<=\d)(?=[a-z]))/i', $query[0]->invoice_number);
			$quotescode 		= "Q000".($number[1]+1);
		}
		else
		{
			$quotescode = "Q0001";
		}
		return $quotescode;
	}

	public static function statustable()
	{
		return schemaconnection::masterconnection()
							->table('invoice_statuses')
							->get();
	}

	public static function paymentMethod()
	{
		return schemaconnection::masterconnection()
							->table('payment_types')
							->get();
	}

	public static function dealerInvoiceExcel($dealer_schemaname,$tablename)
	{
		commonmodel::doschemachange($dealer_schemaname);
		return schemaconnection::dmsmysqlconnection()
								->table($tablename)
								->where('invoice_number','!=',"")
								->where('invoice_status_id','!=','7')
								->where('invoice_status_id','!=','8')
								->whereNull('quote_id')
								->orderBy($tablename.'.invoice_id',"ASC")
								->leftjoin('dealer_payments','dealer_payments.invoice_id','=',$tablename.'.invoice_id')
								->select($tablename.'.invoice_id',
										$tablename.'.contact_id',
										$tablename.'.invoice_status_id',
										$tablename.'.invoice_number',
										$tablename.'.invoice_date',
										$tablename.'.due_date AS invoiceDueDate',
										$tablename.'.terms',
										$tablename.'.invoice_type_id as invoiceDiscount',
										$tablename.'.discount',
										$tablename.'.amount',
										'dealer_payments.payment_date as paymentDate',
										'dealer_payments.payment_type_id as paymentStatus',
										'dealer_payments.amount as paymentAmount')
								->get();
	}

	public static function getDealerName($dealerid)
	{
		return schemaconnection::dmsmysqlconnection()
							->table('dms_dealerdetails')
							->leftjoin('dms_dev.dms_dealers','dms_dealerdetails.dealer_id','=','dms_dealers.d_id')
							->where('d_id',$dealerid)
							->get();
	}

	public static function carprice_check($dealer_schemaname,$invoice_id,$car_id)
	{
		commonmodel::doschemachange($dealer_schemaname);
			$car_value  = schemaconnection::dmsmysqlconnection()
							->table('dealer_invoice_items')
							->where('invoice_id',$invoice_id)
							->where('product_id',$car_id)
							->count();
							//dd($car_id);
		if(!empty($car_value))
		{
			commonmodel::doschemachange($dealer_schemaname);
			$product_id = schemaconnection::dmsmysqlconnection()
							->table('dealer_invoice_items')
							->where('invoice_id',$invoice_id)
							->where('product_id',$car_id)
							->select('cost')
							->get();
			return $product_id[0]->cost;
		}		
		else
		{
			//dd($car_id);
			commonmodel::doschemachange($dealer_schemaname);
			$product_id	= 	schemaconnection::dmsmysqlconnection()
								->table('dealer_listing_pricing')
								->where('car_id',$car_id)
								->first();
		    return $product_id->saleprice;
		}
	}
	public static function quotesvalue($dealer_schemaname,$tablename,$id)
	{
		commonmodel::doschemachange($dealer_schemaname);
	  	return   schemaconnection::dmsmysqlconnection()
						->table($tablename)
						->where('invoice_id',$id)
						->get();
	}
	
	public static function getTemplateData()
	{
		return schemaconnection::masterconnection()
							->table('master_email_templates')
							->select('email_message')
							->where('id','12')
							->get();
	}
}