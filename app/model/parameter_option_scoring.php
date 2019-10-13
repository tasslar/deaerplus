<?php
/*
	Module Name : preferencemodel 
	Created By  : Naveen 31-03-2017 Version 1.0
	This module handle with Preference
*/

namespace App\model;
use DB;
use Config;
use Illuminate\Database\Eloquent\Model;
use App\model\schemaconnection;

class parameter_option_scoring extends Model
{
	
	protected $table 	=	"parameter_option_scoring";
	public static function parameter_option_scoring_fetch($dealer_schemaname,$wherecondition)
	{
		
		$insertGetId	= 	schemaconnection::masterconnection()
								->table('parameter_option_scoring')
								->where($wherecondition)
								->get(); 
		return $insertGetId;
	}

	
}