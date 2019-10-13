<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use Config;
use DB;
use Session;
use App\model\schemaconnection;

class contactsmodel extends Model
{
    public static function contact_table()
    {
        $id = session::get('ses_id');
        $fetchupdate = DB::connection('mastermysql')->table('dms_dealers')->where('d_id',$id)->get();
        $connection = $fetchupdate[0]->dealer_schema_name;      
        Config::set('database.connections.dmsmysql.database', $connection);
        $table = 'dealer_contact_management';
        $contact_table = DB::connection('dmsmysql')->table($table);
        return $contact_table;  
    }
    public static function document()
    {
        $id = session::get('ses_id');
        $fetchupdate = DB::connection('mastermysql')->table('dms_dealers')->where('d_id',$id)->get();
        $connection = $fetchupdate[0]->dealer_schema_name;      
        Config::set('database.connections.dmsmysql.database', $connection);
        $document = 'dealer_contact_document_management';
        $document_table = DB::connection('dmsmysql')->table($document);
        return $document_table; 
    }
    public static function contact_type()
    {       
        $contact_type = DB::connection('mastermysql')->table('dealer_contact_type');
        return $contact_type;
    }

        //Below function is for getting data into excel
    public static function contactexcel($contacttypeid)
    {
        $fetchupdate = DB::connection('mastermysql')
                            ->table('dms_dealers')
                            ->where('d_id',session::get('ses_id'))
                            ->get();
        $connection = $fetchupdate[0]->dealer_schema_name;
        Config::set('database.connections.dmsmysql.database', $connection);
        $contact_type =  DB::connection('dmsmysql')
                            ->table('dealer_contact_management')
                            ->where('contact_type_id',$contacttypeid);
                            // ->join('dealer_contact_type','dealer_contact_type.contact_type_id','=','dealer_contact_management.contact_type_id')
        return $contact_type;
    }
    public static function getcontacts($dealer_schemaname,$tablename){

        commonmodel::doschemachange($dealer_schemaname);
        $insertwithid = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)
                                            ->where('contact_status',config::get('common.contact_status_active'))
                                            ->select('contact_management_id','contact_first_name','contact_phone_1','contact_email_1')
                                            ->orderBy('contact_first_name', 'asc')
                                            ->get();      
        return $insertwithid; 
    }

    public static function getcontactselect($dealer_schemaname,$tablename,$wherecondition){

        commonmodel::doschemachange($dealer_schemaname);
        $insertwithid = schemaconnection::dmsmysqlconnection()
                                            ->table($tablename)
                                            ->where('contact_status',config::get('common.contact_status_active'))
                                            ->select('contact_management_id','contact_first_name','contact_phone_1','contact_email_1')
                                            ->where('contact_management_id',$wherecondition)
                                            ->orderBy('contact_first_name', 'asc')
                                            ->get();      
        return $insertwithid; 
    }

    public static function contact_count($dealer_schemaname,$id){

        commonmodel::doschemachange($dealer_schemaname);
        $contact_count = schemaconnection::dmsmysqlconnection()
                                            ->table('dealer_contact_management')
                                            ->where('contact_management_id',$id)                                    
                                            ->count();      
        return $contact_count; 
    }
    public static function contactdoc($dealer_schemaname,$value){

        commonmodel::doschemachange($dealer_schemaname);
        $insertwithid = schemaconnection::dmsmysqlconnection()
                                            ->table('dealer_contact_document_management')                           
                                            ->insertGetId($value);      
        return $insertwithid; 
    }
    public static function selectcontact($dealer_schemaname,$id){

        commonmodel::doschemachange($dealer_schemaname);
        $selectcontact = schemaconnection::dmsmysqlconnection()
                                            ->table('dealer_contact_management')                            
                                            ->where('contact_management_id',$id)
                                            ->first();      
        return $selectcontact; 
    }
    public static function selectLeadcontact($dealer_schemaname,$id){

        commonmodel::doschemachange($dealer_schemaname);
        $leadcontact = schemaconnection::dmsmysqlconnection()
                                            ->table('dealer_contact_management')                            
                                            ->where('contact_management_id',$id)
                                            ->where('contact_type_id',config::get('common.contact_type_lead'))
                                            ->count();      
        return $leadcontact; 
    }
    public static function selectCustomercontact($dealer_schemaname,$id)
    {
        commonmodel::doschemachange($dealer_schemaname);
        $leadcontact = schemaconnection::dmsmysqlconnection()
                                            ->table('dealer_contact_management')                            
                                           ->where('contact_management_id',$id)
                                            ->where('contact_type_id',config::get('common.contact_type_customer'))
                                            ->count();        
        return $leadcontact; 
    }
    public static function select_doc($dealer_schemaname,$id){

        commonmodel::doschemachange($dealer_schemaname);
        $select_doc = schemaconnection::dmsmysqlconnection()
                                            ->table('dealer_contact_document_management')                           
                                            ->where('contact_management_id',$id)
                                            ->first();
        return $select_doc; 
    }
    public static function select_doc_count($dealer_schemaname,$id){

        commonmodel::doschemachange($dealer_schemaname);
        $select_doc = schemaconnection::dmsmysqlconnection()
                                            ->table('dealer_contact_document_management')                           
                                            ->where('contact_management_id',$id)
                                            ->count();
        return $select_doc; 
    }

    public static function contactsreport($dealer_schemaname,$queryparams){

        commonmodel::doschemachange($dealer_schemaname);
        $select_doc = schemaconnection::dmsmysqlconnection()
                                            ->table('dealer_contact_management')
                                            ->select($queryparams)
                                            ->where('contact_status','active')
                                            ->get();
        return $select_doc; 
    }
    public static function get_client($dealer_schemaname,$id)
    {
        commonmodel::doschemachange($dealer_schemaname);
        return schemaconnection::dmsmysqlconnection()
                            ->table('dealer_contact_management')
                            ->where('contact_management_id',$id)
                            ->first();
    }


    public static function marketingemailstatuscount($dealer_schemaname,$regionno,$makeno,$modelno,$filterno,$contact_type_id)
    {
        commonmodel::doschemachange($dealer_schemaname);
        return $fre = schemaconnection::dmsmysqlconnection()
        ->table('dealer_contact_management')
        ->whereIn('contact_management_id',function($query)use($regionno){
            $query -> select('lead_id')
               -> from('lead_preferences')
               ->where('lead_preferences.lead_option_id', 1)
               ->where('lead_preferences.lead_option_value','like','%r'.$regionno.'r%');
            })
        ->whereIn('contact_management_id',function($query)use($makeno){
            $query -> select('lead_id')
               -> from('lead_preferences')
               ->where('lead_preferences.lead_option_id', 2)
               ->where('lead_preferences.lead_option_value','like','%m'.$makeno.'m%');
            })
        ->whereIn('contact_management_id',function($query)use($modelno){
            $query -> select('lead_id')
               -> from('lead_preferences')
               ->where('lead_preferences.lead_option_id', 3)
               ->where('lead_preferences.lead_option_value','like','%mo'.$modelno.'mo%');
            })
        ->whereIn('contact_management_id',function($query)use($filterno){
            $query -> select('lead_id')
               -> from('lead_preferences')
               ->where('lead_preferences.lead_option_id', 4)
               ->where('lead_preferences.lead_option_value','like','%f'.$filterno.'f%');
            })
        ->where('contact_email_opt_out',1)
        ->where('contact_type_id',$contact_type_id)
        ->count(); 
    }

    public static function marketingsmsstatuscount($dealer_schemaname,$regionno,$makeno,$modelno,$filterno,$contact_type_id)
    {
        commonmodel::doschemachange($dealer_schemaname);
        return $fre = schemaconnection::dmsmysqlconnection()
        ->table('dealer_contact_management')
        ->whereIn('contact_management_id',function($query)use($regionno){
            $query -> select('lead_id')
               -> from('lead_preferences')
               ->where('lead_preferences.lead_option_id', 1)
               ->where('lead_preferences.lead_option_value','like','%r'.$regionno.'r%');
            })
        ->whereIn('contact_management_id',function($query)use($makeno){
            $query -> select('lead_id')
               -> from('lead_preferences')
               ->where('lead_preferences.lead_option_id', 2)
               ->where('lead_preferences.lead_option_value','like','%m'.$makeno.'m%');
            })
        ->whereIn('contact_management_id',function($query)use($modelno){
            $query -> select('lead_id')
               -> from('lead_preferences')
               ->where('lead_preferences.lead_option_id', 3)
               ->where('lead_preferences.lead_option_value','like','%mo'.$modelno.'mo%');
            })
        ->whereIn('contact_management_id',function($query)use($filterno){
            $query -> select('lead_id')
               -> from('lead_preferences')
               ->where('lead_preferences.lead_option_id', 4)
               ->where('lead_preferences.lead_option_value','like','%f'.$filterno.'f%');
            })
        ->where('contact_sms_opt_out',1)
        ->where('contact_type_id',$contact_type_id)
        ->count(); 
    }

    public static function marketingemailstatusfetchdetail($dealer_schemaname,$regionno,$makeno,$modelno,$filterno,$contact_type_id)
    {
        commonmodel::doschemachange($dealer_schemaname);
        return $fre = schemaconnection::dmsmysqlconnection()
        ->table('dealer_contact_management')
        ->whereIn('contact_management_id',function($query)use($regionno){
            $query -> select('lead_id')
               -> from('lead_preferences')
               ->where('lead_preferences.lead_option_id', 1)
               ->where('lead_preferences.lead_option_value','like','%r'.$regionno.'r%');
            })
        ->whereIn('contact_management_id',function($query)use($makeno){
            $query -> select('lead_id')
               -> from('lead_preferences')
               ->where('lead_preferences.lead_option_id', 2)
               ->where('lead_preferences.lead_option_value','like','%m'.$makeno.'m%');
            })
        ->whereIn('contact_management_id',function($query)use($modelno){
            $query -> select('lead_id')
               -> from('lead_preferences')
               ->where('lead_preferences.lead_option_id', 3)
               ->where('lead_preferences.lead_option_value','like','%mo'.$modelno.'mo%');
            })
        ->whereIn('contact_management_id',function($query)use($filterno){
            $query -> select('lead_id')
               -> from('lead_preferences')
               ->where('lead_preferences.lead_option_id', 4)
               ->where('lead_preferences.lead_option_value','like','%f'.$filterno.'f%');
            })
        ->where('contact_email_opt_out',1)
        ->whereIn('contact_type_id',$contact_type_id)
        ->get(); 
    }

    public static function marketingsmsstatusfetchdetail($dealer_schemaname,$regionno,$makeno,$modelno,$filterno,$contact_type_id)
    {
        commonmodel::doschemachange($dealer_schemaname);
        return $fre = schemaconnection::dmsmysqlconnection()
        ->table('dealer_contact_management')
        ->whereIn('contact_management_id',function($query)use($regionno){
            $query -> select('lead_id')
               -> from('lead_preferences')
               ->where('lead_preferences.lead_option_id', 1)
               ->where('lead_preferences.lead_option_value','like','%r'.$regionno.'r%');
            })
        ->whereIn('contact_management_id',function($query)use($makeno){
            $query -> select('lead_id')
               -> from('lead_preferences')
               ->where('lead_preferences.lead_option_id', 2)
               ->where('lead_preferences.lead_option_value','like','%m'.$makeno.'m%');
            })
        ->whereIn('contact_management_id',function($query)use($modelno){
            $query -> select('lead_id')
               -> from('lead_preferences')
               ->where('lead_preferences.lead_option_id', 3)
               ->where('lead_preferences.lead_option_value','like','%mo'.$modelno.'mo%');
            })
        ->whereIn('contact_management_id',function($query)use($filterno){
            $query -> select('lead_id')
               -> from('lead_preferences')
               ->where('lead_preferences.lead_option_id', 4)
               ->where('lead_preferences.lead_option_value','like','%f'.$filterno.'f%');
            })
        ->where('contact_sms_opt_out',1)
        ->whereIn('contact_type_id',$contact_type_id)
        ->get(); 
    }
}
