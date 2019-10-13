<?php
/*
  Module Name : Manage 
  Created By  : Sreenivasan  3-2-2017
  Use of this module is Mongo
*/
namespace App\model;

use Illuminate\Database\Eloquent\Model;
use Config;
use DB;
use Session;
use App\model\schemaconnection;
use App\model\site_search_mongo_model;

class site_searchmodel extends Model
{
	public static function site_serach($tags,$pushtype,$url,$cat_id,$sub_id,$d_id,$auto_id)
	{
		switch ($pushtype) {
			case 'insert':		
					$mongodb_carlisting            = new site_search_mongo_model;
					$mongodb_carlisting['tags']    =$tags;
					$mongodb_carlisting['url']     =$url;
					$mongodb_carlisting['cat_id']  =$cat_id;
					$mongodb_carlisting['sub_id']  =$sub_id;
					$mongodb_carlisting['d_id']    =(int) $d_id;
					$mongodb_carlisting['auto_id'] =(int) $auto_id;
					$mongodb_carlisting->save();	
					return "success";				
				break;
			case 'update':
			//delete
					$delete_ids = array(
											'cat_id' =>$cat_id,
											'sub_id' =>$sub_id,
											'd_id'   =>(int) $d_id,
											'auto_id'=>(int) $auto_id
										);
					$mongodb_carlisting            =  site_search_mongo_model::where($delete_ids)->delete();        					
			//insert
					if($mongodb_carlisting)
					{
						$mongodb_carlisting            = new site_search_mongo_model;            
						$mongodb_carlisting['tags']    =$tags;
						$mongodb_carlisting['url']     =$url;
						$mongodb_carlisting['cat_id']  =$cat_id;
						$mongodb_carlisting['sub_id']  =$sub_id;
						$mongodb_carlisting['d_id']    =(int) $d_id;
						$mongodb_carlisting['auto_id'] = (int) $auto_id;
						$mongodb_carlisting->save();
					}
					return "success";					
				break;
			case 'delete':
			//delete
					$delete_ids 					= array(
																'cat_id' =>$cat_id,
																'sub_id' =>$sub_id,
																'd_id'   =>(int) $d_id,
																'auto_id'=>(int) $auto_id
															);					
					$mongodb_carlisting            = site_search_mongo_model::where($delete_ids)->delete(); 
					return "success";					
			default:
					return "error";
				break;
		}		
	}
}