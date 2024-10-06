<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\ScrapeController;

class ScrapeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kkdev:scrape-now';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update football matches';

    /**
     * Execute the console command.
     */
    public function handle()
    {
       $controller = new ScrapeController();
       $controller->scrape();
       Log::info("Scraped at " . now());
    }
}
