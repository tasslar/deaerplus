<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\model\dealerTransactionHistoryManagement;
use Carbon\Carbon;
use Log;
use Mail;
class planexpirenotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:planexpire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Plan Expired';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        dealerTransactionHistoryManagement::schedulerPlanExp();
        Log::info("Plan expired notification sent successfully");
        
    }
}
