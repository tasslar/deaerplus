<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class master_temp_register extends Model
{
	

	public $timestamps = false;
    protected $connection = 'mastermysql';
    protected $table = 'master_temp_register';
    //protected $fillable = ['history_id','dealer_id','supscription_plan_id','payment_date','transcation_status','payment'];
}
