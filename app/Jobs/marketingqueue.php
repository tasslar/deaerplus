<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Http\Controllers\inventory;
use DB;
use Log;
use Config;

class marketingqueue implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $listing_basic_info;
    protected $sms_data;
    protected $email_data;
    protected $dealer_info;
    protected $shorturl;
    protected $maildata;
    public function __construct($listing_basic_info,$sms_data,$email_data,$dealer_info,$shorturl,$maildata)
    {
        //
        $this->listing_basic_info   = $listing_basic_info;
        $this->sms_data             = $sms_data;
        $this->email_data           = $email_data;
        $this->dealer_info          = $dealer_info;
        $this->shorturl             = $shorturl;
        $this->maildata             = $maildata;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {        
        $listing_basic_info = $this->listing_basic_info;
        $sms_data = $this->sms_data;
        $email_data = $this->email_data;
        $dealer_info = $this->dealer_info;
        $shorturl = $this->shorturl;
        $maildata = $this->maildata;
        inventory::queuesmsemailmarket($listing_basic_info,$sms_data,$email_data,$dealer_info,$shorturl,$maildata);
    }
}