<?php

namespace App\Console\Commands;

use App\Services\ScrapeService;
use Illuminate\Console\Command;

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
        ScrapeService::scrapeMatches();
    }
}
