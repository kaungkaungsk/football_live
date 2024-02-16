<?php

namespace App\Console\Commands;

use App\FireNotification;
use App\Http\Controllers\FootballApiController;
use Illuminate\Console\Command;

class ThirdPartyLive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh:third-party-live';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the api index frequently';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        FootballApiController::getApiLive();
        FireNotification::sendNotification('work', 'work message');
    }
}
