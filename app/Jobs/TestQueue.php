<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\model\buyymodel;
use Log;

class TestQueue implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $alert_make;
    protected $alert_model;
    protected $alert_variant;
    protected $alert_source_listing_id;
    protected $alert_source_dealer_id;

    public function __construct($make,$model,$variant,$listing_id,$dealer_id)
    {
        //
        $this->alert_make = $make;
        $this->alert_model = $model;
        $this->alert_variant = $variant;
        $this->alert_source_listing_id = $listing_id;
        $this->alert_source_dealer_id = $dealer_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $alert_source_listing_id    = $this->alert_source_listing_id;
        $alert_source_dealer_id     = $this->alert_source_dealer_id;
        $alert_history = buyymodel::masterFetchTableDetails($alert_source_dealer_id,'dealer_alert_history',array('alert_make'=>$this->alert_make,'alert_model'=>$this->alert_model,'alert_variant'=>$this->alert_variant,'alert_status'=>1));
        foreach ($alert_history as $key => $value) {
            $alert_id                   = $value->alertid;
            $alert_subscriber_dealer_id = $value->alert_user_id;
            $insert_array               = array('alert_id'=>$alert_id,
                                                'alert_subscriber_dealer_id'=>$alert_subscriber_dealer_id,
                                                'alert_source_listing_id'=>$alert_source_listing_id,
                                                'alert_source_dealer_id'=>$alert_source_dealer_id
                                                );
            //print_r($insert_array);
            buyymodel::masterInsertTable($alert_source_dealer_id,'dealer_alerts_received',$insert_array);
        }
    }
}
