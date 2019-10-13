<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\model\contactsmodel;
use App\model\shortnerurl;
use App\model\smsmodel;
use Log;
use Config;
use Illuminate\Support\Facades\Mail;

class fundingmailqeue implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $maildata;
    protected $ccmail;
    public function __construct($maildata,$ccemail)
    {
        //
        $this->maildata	= 	$maildata;
        $this->ccmail   = 	$ccemail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->maildata;    
        $var = Mail::send('email_template',['data'=>$data],
              function($message) use ($data)
              {
                $message->to($data['email'])
                        ->subject($data['mail_subject'])
                        ->cc("support@dealerplus.in");
                        //->cc(["support@dealerplus.in",$this->ccmail]);
              });
    }

