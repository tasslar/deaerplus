<?php

namespace App\model;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class mongomodel extends Eloquent {

    protected $connection = 'mongodb';
    protected $collection = 'dms_car_listings';

}