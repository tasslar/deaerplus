<?php
namespace App\model;

use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
use App\model\notificationsmodel;
use App\Jobs\mailqueue;
use App\Jobs\fundingmailqeue;
use DB;
use config;

class emailmodel extends Model
{
	
	public 		$timestamps  = false;
    protected 	$connection  = 'dmsmysql';

    /* The function get_email_templates get email template 
   	   From master_email_templates.
	*/
    public static function get_email_templates($email_template_id)
    {

        $maildata=DB::table('master_email_templates')
        			->where('email_type_id','=',$email_template_id)
        			->get();
        return $maildata;
    }

    /* The function emailContentConstruct create email template with parameter 
     * Content.
     */
    public static function emailContentConstruct($mail_subject,$mail_message,$mail_params,$data)
    {
       	
		$mail_params_explode = explode(",",$mail_params);
			
		if(!empty($data))
		{
			if(!empty($mail_params_explode))
			{
				foreach ($mail_params_explode as $key => $value) 
				{
					$mail_message = str_replace($mail_params_explode[$key],$data[$key], $mail_message); 
					
				}

			}
			else
			{
				foreach ($data as $key => $value) 
				{
					$mail_message = str_replace("##".$key."##",$data[$key], $mail_message); 		
					
				}

			}

			
		}
	
	    $data['mail_subject']  =  $mail_subject;
		$data['mail_message']  =  $mail_message;

		return $data;
	}

	/* The function emailContentConstruct create email template with parameter 
     * Content.
     */
    public static function emailContentConstructLoan($mail_subject,$mail_message,$mail_params,$data,$footermail)
    {
		$mail_params_explode 	= 	explode(",",$mail_params);
			
		if(!empty($data))
		{
			if(!empty($mail_params_explode))
			{
				foreach ($mail_params_explode as $key => $value) 
				{

					$mail_message 	= 	str_replace($mail_params_explode[$key],$data[$key], $mail_message); 
				}
				$mail_message		.=	$footermail;

			}
			else
			{
				foreach ($data as $key => $value) 
				{
					$mail_message = str_replace("##".$key."##",$data[$key], $mail_message); 
					
				}

			}

			
		}
	
	    $data['mail_subject']  =  $mail_subject;
		$data['mail_message']  =  $mail_message;
		return $data;
	}

	public static function emailContentsubject($mail_subject,$mail_message,$mail_params,$data,$subject_data)
    {
		$mail_params_explode = explode(",",$mail_params);
		$mail_subject_explode = explode(",",$mail_subject);
			
		if(!empty($data))
		{
			if(!empty($mail_params_explode))
			{
				foreach ($mail_params_explode as $key => $value) 
				{
					$mail_message = str_replace($mail_params_explode[$key],$data[$key], $mail_message);
				}
			}
			else
			{
				foreach ($data as $key => $value) 
				{
					$mail_message = str_replace("##".$key."##",$data[$key], $mail_message); 
				}
			}
		}
		if(!empty($subject_data))
		{
			if(!empty($mail_subject_explode))
			{
				foreach ($mail_subject_explode as $key => $value) 
				{
					$mail_subject = str_replace($mail_subject_explode[$key],$subject_data[$key], $mail_subject); 
				}
			}
			else
			{
				foreach ($subject_data as $key => $value) 
				{
					$mail_subject = str_replace("##".$key."##",$subject_data[$key], $mail_subject); 
				}
			}
		}
	    $data['mail_subject']  =  $mail_subject;
		$data['mail_message']  =  $mail_message;

		return $data;
	}

	 /* The function email_sending send email 
	 * to the registered dealer email.
     */
	public static function email_sending($email,$data,$replyto='support@dealerplus.in')
	{
		$data['email']=$email;
		$data['replyto']=$replyto;

		//Mail Is Pushed to Queue
		/*$var = Mail::send('email_template',['data'=>$data],
				  function($message) use ($data)
				  {
				  	$message->to($data['email'])
		            		->subject($data['mail_subject']);
				    //print_r($msg-> failures());
				  });*/

		$job = new \App\Jobs\mailqueue($data);
		dispatch($job);
		/*if(count(Mail::failures()) > 0)
		{
			return 'false';
		}
		else
		{*/
			return 'true';
		//}

	}
	public static function email_sending_cc($email,$data,$ccemail)
	{
		$data['email']	=	$email;
		$job = new \App\Jobs\fundingmailqeue($data,$ccemail);
		dispatch($job);
		return 'true';
	}

	public static function emailSendingAttach($email,$data,$pdfPath)
	{
		$data['email']=$email;
		$attach['data'] = $pdfPath;
		$var = Mail::send('email_template',['data'=>$data,'attach'=>$attach],
				  function($message) use ($data,$attach)
				  {
				  	$message->to($data['email'])
		            		->subject($data['mail_subject'])
		            		->attach($attach['data']);
				  });

		if(count(Mail::failures()) > 0)
		{
			return 'false';
		}
		else
		{
			return 'true';
		}
	}


	/*public static function emailToAdmin($mailmsg)
	{
		
		$var_check = Mail::raw($mailmsg,
						function ($message){
						$message->subject('DEALER-ENQUIRY');
			            $message->to('ahila@falconnect.in');
			 		});
		

		if(count(Mail::failures()) > 0)
		{
			return 'false';
		}
		else
		{
			return 'true';
		}

	}*/
}