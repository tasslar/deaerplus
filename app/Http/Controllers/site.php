<?php

/*
  Module Name : Site
  Created By  : Naveen Babu 02-01-2017 Version 1.0
  Use of this module is Site Details

 */

namespace App\Http\Controllers;
use Session;
use Request;
use Config;
use Redirect;
use App\model\emailmodel;
use App\Exceptions\CustomException;

class site extends Controller {

    public function aboutus() {
        $header_data = array('id' => '',
            'dealer_name' => '0',
            'logo' => '',
            'email_count' => '0',
            'recentcount' => '0',
            'savedcount' => '0',
            'title' => 'About Us',
            'dealer_notification' => '0'
        );
        $compact_array = array('active_menu_name' => '',
        );
        return view('about_main', compact('compact_array', 'header_data'));
    }
    public function contactushtml()
    {
    $fullname=Request::input('fullname');
    $dealername=Request::input('dealername');
    $phone=Request::input('phone');
    $email=Request::input('email');
    $dealer_message=Request::input('message');
    $req_type=Request::input('req_type');
    
    
    
    if($fullname== "" || $dealername== "" ||$phone==""||$email==""||$dealer_message=="" ||$req_type=="")
    {
         Session::flash('message', "All fields are required");
         return Redirect::back();
    }
    else
    {

     $adminEmail          =  config::get('common.admin_mail_id');
     $enquiry_template_id =  config::get('common.dealer_enquiry_template_id');
     try
     {

            $enquiry_template    =  emailmodel::get_email_templates($enquiry_template_id); 
     
                foreach ($enquiry_template as $rowone)
                 {
                        $mail_subject  =  $rowone->email_subject;
                        $mail_message  =  $rowone->email_message;
                        $mail_params   =  $rowone->email_parameters; 
                } 

                $data                  =    array(
                                            '0' =>"",      
                                            '1'=>$dealername,
                                            '2'=>$phone,
                                            '3'=>$email,
                                            '4'=>$req_type,
                                            '5'=>$dealer_message,
                                             );

     $dealer_enquiry_template    =     emailmodel::emailContentConstruct($mail_subject,$mail_message,$mail_params,$data);

     $sentToAdmin                =     emailmodel::email_sending($adminEmail,$dealer_enquiry_template);
     

     if($sentToAdmin == "true")
      {
         $admin_reply_template_id =    config::get('common.admin_reply_email_template_id');
         $admin_reply_data        =    emailmodel::get_email_templates($admin_reply_template_id);
         
                foreach ($admin_reply_data as $row) 
                {
                        $mail_subject  =  $row->email_subject;
                        $mail_message  =  $row->email_message;
                        $mail_params   =  $row->email_parameters; 
                }

        $data                  =    array(
                                            '0' =>"",      
                                            '1'=>$dealername,
                                            '2'=>$email,
                                            '3'=>$dealer_message,
                                            '4'=>"",
                                            '5'=>"",
                                        );


    $admin_reply_template    =     emailmodel::emailContentConstruct($mail_subject,$mail_message,$mail_params,$data);
    $admin_Reply_sent        =     emailmodel::email_sending($email,$admin_reply_template);

    Session::flash('message', "Thank you for contacting us. Our representative will contact You soon.");
    return redirect("http://www.dealerplus.in/contact.html");
  }
  else
  {
    Session::flash('message-err', "Error...Please try again!");
    return redirect("http://www.dealerplus.in/contact.html");

  }  

}
catch(Exception $e)
{
    throw new CustomException($e->getMessage());
}
        
}    
    }
    public function privacy() {
        $header_data = array('id' => '',
            'dealer_name' => '0',
            'logo' => '',
            'email_count' => '0',
            'title' => 'Privacy Policy',
            'dealer_notification' => '0',
            'recentcount' => '0',
            'savedcount' => '0',
        );
        $compact_array = array('active_menu_name' => '',
        );
        return view('privacy', compact('compact_array', 'header_data'));
    }

    public function terms() {
        $header_data = array('id' => '',
            'dealer_name' => '0',
            'logo' => '',
            'email_count' => '0',
            'title' => 'Terms and conditions',
            'dealer_notification' => '0',
            'recentcount' => '0',
            'savedcount' => '0',
        );
        $compact_array = array('active_menu_name' => '',
        );
        return view('terms', compact('compact_array', 'header_data'));
    }

 
   
     public function alert() {
        $header_data = array('id' => '',
            'dealer_name' => '0',
            'logo' => '',
            'email_count' => '0',
            'title' => 'Alert',
            'dealer_notification' => '0',
            'recentcount' => '0',
            'savedcount' => '0',
            'sys_notification_list' => "",
        );
        $compact_array = array('active_menu_name' => ''
        );
        return view('alert', compact('compact_array', 'header_data'));
    }
    public function email() {
        $header_data = array('id' => '',
            'dealer_name' => '0',
            'logo' => '',
            'email_count' => '0',
            'title' => 'Email Template',
            'dealer_notification' => '0',
            'recentcount' => '0',
            'savedcount' => '0',
            'alert_count'=>'0',
            'p_id'=>0,
            'sys_notification_list' => "",
        );
        $compact_array = array('active_menu_name' => 'network'
        );
        return view('email_temp', compact('compact_array', 'header_data'));
    }
    public function sms() {
        $header_data = array('id' => '',
            'dealer_name' => '0',
            'logo' => '',
            'email_count' => '0',
            'title' => 'SMS Template',
            'dealer_notification' => '0',
            'recentcount' => '0',
            'savedcount' => '0',
            'alert_count'=>'0',
            'p_id'=>0,
            'sys_notification_list' => "",
        );
        $compact_array = array('active_menu_name' => 'network'
        );
        return view('sms_temp', compact('compact_array', 'header_data'));
    }
    public function addsms() {
        $header_data = array('id' => '',
            'dealer_name' => '0',
            'logo' => '',
            'email_count' => '0',
            'title' => 'SMS Template',
            'dealer_notification' => '0',
            'recentcount' => '0',
            'savedcount' => '0',
            'alert_count'=>'0',
            'p_id'=>0,
            'sys_notification_list' => "",
        );
        $compact_array = array('active_menu_name' => 'network'
        );
        return view('addsms_temp', compact('compact_array', 'header_data'));
    }
    public function addemail() {
        $header_data = array('id' => '',
            'dealer_name' => '0',
            'logo' => '',
            'email_count' => '0',
            'title' => 'Email Template',
            'dealer_notification' => '0',
            'recentcount' => '0',
            'savedcount' => '0',
            'alert_count'=>'0',
            'p_id'=>0,
            'sys_notification_list' => "",
        );
        $compact_array = array('active_menu_name' => 'network'
        );
        return view('addemail_temp', compact('compact_array', 'header_data'));
    }

     public function contactus() {
        $header_data = array('id' => '',
            'dealer_name' => '0',
            'logo' => '',
            'email_count' => '0',
            'dealer_notification' => '0',
            'recentcount' => '0',
            'savedcount' => '0',
            'sys_notification_list' => "",
            
        );
        $compact_array = array('active_menu_name' => '',

        );
        $title = "Contactus";
        return view('contactus', compact('compact_array', 'header_data','title'));
    }


/*
  Module Name : dealerContactUs
  Created By  : Ahila.A 18-02-2017 Version 1.0
  Use of this module is dealer contact to Admin.

 */
  public function dealerContactUs()
  {
    
    $fullname=Request::input('fullname');
    $dealername=Request::input('dealername');
    $phone=Request::input('phone');
    $email=Request::input('email');
    $dealer_message=Request::input('message');
    $req_type=Request::input('req_type');
    
    
    
    if($fullname== "" || $dealername== "" ||$phone==""||$email==""||$dealer_message=="" ||$req_type=="")
    {
         Session::flash('message', "All fields are required");
         return Redirect::back();
    }
    else
    {

     $adminEmail          =  config::get('common.admin_mail_id');
     $enquiry_template_id =  config::get('common.dealer_enquiry_template_id');
     try
     {

            $enquiry_template    =  emailmodel::get_email_templates($enquiry_template_id); 
     
                foreach ($enquiry_template as $rowone)
                 {
                        $mail_subject  =  $rowone->email_subject;
                        $mail_message  =  $rowone->email_message;
                        $mail_params   =  $rowone->email_parameters; 
                } 

                $data                  =    array(
                                            '0' =>"",      
                                            '1'=>$dealername,
                                            '2'=>$phone,
                                            '3'=>$email,
                                            '4'=>$req_type,
                                            '5'=>$dealer_message,
                                             );

     $dealer_enquiry_template    =     emailmodel::emailContentConstruct($mail_subject,$mail_message,$mail_params,$data);

     $sentToAdmin                =     emailmodel::email_sending($adminEmail,$dealer_enquiry_template);
     

     if($sentToAdmin == "true")
      {
         $admin_reply_template_id =    config::get('common.admin_reply_email_template_id');
         $admin_reply_data        =    emailmodel::get_email_templates($admin_reply_template_id);
         
                foreach ($admin_reply_data as $row) 
                {
                        $mail_subject  =  $row->email_subject;
                        $mail_message  =  $row->email_message;
                        $mail_params   =  $row->email_parameters; 
                }

        $data                  =    array(
                                            '0' =>"",      
                                            '1'=>$dealername,
                                            '2'=>$email,
                                            '3'=> "",
                                            '4'=>"",
                                            '5'=>"",
                                        );


    $admin_reply_template    =     emailmodel::emailContentConstruct($mail_subject,$mail_message,$mail_params,$data);
    $admin_Reply_sent        =     emailmodel::email_sending($email,$admin_reply_template);

    Session::flash('message', "Thank you for contacting us. Our representative will contact You soon.");
    return Redirect::back();
  }
  else
  {
    Session::flash('message-err', "Error...Please try again!");
    return Redirect::back();

  }  

}
catch(Exception $e)
{
    throw new CustomException($e->getMessage());
}
        
}    
}
}
