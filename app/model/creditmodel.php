<?php
/*
  Module Name : Creditmodel
  Created By  : Ahila 07-03-2017 version 1.0
  Use of this module is to maintain credit details.

  by scindia changes

*/
namespace App\model;
use DB;
use config;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\model\schemaconnection;
use App\Exceptions\CustomException;

class creditmodel extends Model
{
    

   
    protected $connection = 'dmsmysql';
    
    public static function fetchCredit($id)
    {
      try
      {
        $creditData =   schemaconnection::masterconnection()
                        ->table('dealer_accounts') 
                        ->where('dealer_id',$id)
                        ->get();
         
       if(count($creditData) > 0)
        {
      return $creditData;
      }
    else 
    {
       $tempCreditData  = array(
                                    'dealer_id'=>$id,
                                    'credit_balance'=>0,
                                    'created_at'=>Carbon::now()
                                    );
            $creditId  =  creditmodel::addCredit($tempCreditData);
      return creditmodel::fetchCreditbyID($id);
    }
    }
      catch(\Exception $e)
      {
           throw new CustomException($e->getMessage());
      }
    }
public static function fetchCreditbyID($id)
{
  $creditData =   schemaconnection::masterconnection()
                        ->table('dealer_accounts') 
                        ->where('dealer_id',$id)
                        ->get();
  return $creditData;
}
    
    public static function strCredits($tempcredit,$id)
    {
        $creditData   = creditmodel::fetchCreditbyID($id);
        if(count($creditData) > 0)
        {
            $tempUpdateData  = array(
                                    'credit_balance'=>$tempcredit,
                                    'updated_at'=>Carbon::now()
                                    );
            $creditId  =  creditmodel::updateCredit($tempUpdateData,$id);
            
        }
        else
        {
            $tempCreditData  = array(
                                    'dealer_id'=>$id,
                                    'credit_balance'=>$tempcredit,
                                    'created_at'=>Carbon::now()
                                    );
            $creditId  =  creditmodel::addCredit($tempCreditData);
        }
        return $creditId;
    }

    public static function addCredit($tempCreditData)
    {
        try
        {

        $creditid = schemaconnection::masterconnection()
                    ->table('dealer_accounts')
                    ->insertGetId($tempCreditData); 
        return $creditid; 
        }
        catch(\Exception $e)
        {
           throw new CustomException($e->getMessage());
        }
    }

    public static function updateCredit($tempUpdateData,$id)
    {
        try{

         $updatedata      =      schemaconnection::masterconnection()
                                ->table('dealer_accounts')
                                ->where('dealer_id',"=",$id)
                                ->update($tempUpdateData);
        return $updatedata;
        }
        catch(\Exception $e)
        {
           throw new CustomException($e->getMessage());
        }

    }
    
   
    
}
