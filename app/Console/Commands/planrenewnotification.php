<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\model\dealerTransactionHistoryManagement;
use Carbon\Carbon;
use Log;
use Mail;
class planrenewnotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:planrenew';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Renew plan before expired';

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
        dealerTransactionHistoryManagement::schedulerPlanRenew();
        Log::info("Plan Renewed notification sent successfully");
        
    }
}
