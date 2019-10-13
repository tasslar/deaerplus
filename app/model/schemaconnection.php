<?php

namespace App\model;
use DB;
use config;

use Illuminate\Database\Eloquent\Model;

class schemaconnection extends Model
{
    public static function dmsmysqlconnection()
    {
        return DB::connection('dmsmysql');
    }

    public static function masterconnection()
    {
        return DB::connection('mastermysql');
    }
}
