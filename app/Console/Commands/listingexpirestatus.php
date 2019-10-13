<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\model\mongomodel;
use Carbon\Carbon;
use Log;
class listingexpirestatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:expirestatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updating the Expired listing to expired';

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
        //
        //Log::info('Cron Running');
        $currentdate= Carbon::now();
        mongomodel::where('listing_expiry_date',$currentdate->format('Y-m-d'))->update(array('listing_status'=>'Expired'));
    }
}
