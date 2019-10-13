<?php
/*
  Module Name : Subscriptionmodel
  Created By  : Ahila , version 1.0
  Use of this module is maintain related to billing.

*/
namespace App\model;

use Illuminate\Database\Eloquent\Model;
use Config;
use DB;
use App\model\schemaconnection;
use App\Exceptions\CustomException;

class dealerPaymentmodel extends Model
{
  public $timestamps = false;
  public static function masterPaymentRespInsert($paymentData)
  {
  		$paymentId      =      schemaconnection::masterconnection()
                                  ->table('payment_transaction')
                                  ->insertGetId($paymentData); 
      return $paymentId;  
  }
}
