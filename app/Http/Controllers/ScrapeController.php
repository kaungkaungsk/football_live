<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ScrapeService;

class ScrapeController extends Controller
{
    public function scrape(){
        $liveMatches = ScrapeService::getScrapedMatches();
        print json_encode($liveMatches);
    }

    public function links($id){
        $result = ScrapeService::getVideoLinks($id);
    }
}
