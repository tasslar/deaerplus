<?php

namespace App\model;
use DB;
use config;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\model\schemaconnection;

class billingmodel extends Model
{
    

    public $timestamps = false;
    protected $connection = 'dmsmysql';
    
    public static function future_startdate($id)
    {
      
        $current_date = DB::connection('mastermysql')
                        ->table('dealer_billing_details') 
                        ->select('subscription_start_date','subscription_end_date') 
                        ->where(['current_subscription'=>'1','dealer_id'=>$id])
                        ->get();
         $future_startdate = $current_date[0]->subscription_end_date;
        
       return $future_startdate;
    }

    
    public static function billing_enddate($startdate,$freq_id){


        
        $freq_data=DB::connection('mastermysql')
                    ->table('master_plan_frequency')
                    ->where('frequency_id',$freq_id)
                    ->get();

        $bill_dates=array(
                        'startdate'=>$startdate,
                        'current'=>"",
                        'exp'=>""
                        );
        
        $current= \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $startdate);
        $cur=Carbon::now();
        
        $temp=$freq_data[0]->frequency_interval.' '.$freq_data[0]->frequency_unit;
      
        if($freq_data[0]->frequency_unit == 'D')
        {
            $exp=$current->addDays($freq_data[0]->frequency_interval);
        }
        elseif($freq_data[0]->frequency_unit == 'M')
        {
            $exp=$current->addMonths($freq_data[0]->frequency_interval);
        }
        elseif($freq_data[0]->frequency_unit == 'Y')
        {
         $exp=$current->addYears($freq_data[0]->frequency_interval);   
        }
        $bill_dates ['current']=$cur;
        $bill_dates ['exp']=$exp;
     
        return $bill_dates;
    }

    public static function dealer_billing_store($dealer_schemaname,$insert_billing){
            $table = 'dms_dealer_billing_details';
            commonmodel::doschemachange($dealer_schemaname);
            $billing_id = schemaconnection::dmsmysqlconnection()
                                            ->table($table)
                                            ->insertGetId($insert_billing);     
            return $billing_id; 
    }

    

    
}
