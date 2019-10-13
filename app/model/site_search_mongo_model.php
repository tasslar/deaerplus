<?php
/*
  Module Name : Manage 
  Created By  : Sreenivasan  3-2-2017
  Use of this module is Mongo
*/
namespace App\model;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class site_search_mongo_model extends Eloquent {

    protected $connection = 'mongodb_siteserach';
    protected $collection = 'site_serach';

}