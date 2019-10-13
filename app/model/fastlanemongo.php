<?php

namespace App\model;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class fastlanemongo extends Eloquent {

    protected $connection = 'mongodb';
    protected $collection = 'fastlane';

}