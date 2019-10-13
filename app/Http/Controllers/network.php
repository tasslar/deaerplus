<?php
 /* 
    Module Name : Networks   
    Created By  : Naveen 23-02-2017
    Use of this module is Add Inventory, Add the car details,Saved Cars
*/
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\model\commonmodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\model\buyymodel;
use Redirect;
use Config;
use Session;
use Carbon\Carbon;
/**
* 
*/
class network extends Controller
{    
    public function __construct(Request $request)
    {
        $this->middleware(function ($request, $next)
        {
            $this->login_authecation  = session()->has( 'ses_dealername' ) ? session()->get( 'ses_dealername' ) :  Redirect::to('login')->send();  

            $this->header_data      = commonmodel::commonheaderdata();
            $this->dealer_schemaname=Session::get('dealer_schema_name');
            return $next($request);
        }); 
    }
    public function cometchat_group()
    {
        $id = Session::get('ses_id');
        $dms_dealers_tablename        = 'cometchat_chatrooms';
        $fetch_cometchat_group   = buyymodel::masterFetchTableDetails($id,$dms_dealers_tablename,array('createdby'=>$id));
        $data = array();
        $cometchat_group = array();
        foreach ($fetch_cometchat_group as $cometchatkey) {
             $data['groupid'] = $cometchatkey->id;
             $data['groupname'] = $cometchatkey->name;
             $data['groupusercount'] = buyymodel::masterFetchTablecount('cometchat_chatrooms_users',array('chatroomid'=>$data['groupid']));             
             array_push($cometchat_group, $data);
        }
        
        $compact_array            = array
                                        ('active_menu_name'=>'manage_menu',                   
                                         'side_bar_active'=>'network',
                                         'cometchat_group'=>$cometchat_group 
                                        );

        $header_data= $this->header_data;
           
        $header_data['title']='Group';
        
        return view('cometchat_group',compact('compact_array','header_data'));
    }
    public function deletegroup_chat()
    {
        $tablename        = 'cometchat_chatrooms';
        buyymodel::masterFetchTableDelete($tablename,array('id'=>Input::get('deletegroup_id')));
        Session::flash('warning','Successfully Deleted Group');
        return redirect('group');
    }
    public function add_cometchatgroup()
    {
        $id  = Session::get('ses_id');
        //dd($_POST);
        $tablename        = 'cometchat_chatrooms';
        $fetch_cometchat_group   = buyymodel::masterFetchTableDetails($id,$tablename,array('name'=>Input::get('groupname'),'createdby'=>$id));
        if(count($fetch_cometchat_group)<=0){

            
            $insertdata = array('name'=>Input::get('groupname'),
                                'createdby'=>$id,
                                'type'=>0);

            buyymodel::masterInsertTable($id,$tablename,$insertdata);
            Session::flash('success','The Network Group Is Created Successfully');

        }
        else{
            Session::flash('warning','The Network Group Is Already Exists');
        }
        return redirect('group');
    }
}