<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ScrapeService;

class ScrapeController extends Controller
{
    public function scrape(){
        $liveMatches = ScrapeService::getLiveMatches();
        dd($liveMatches);
    }

    public function links($id){
        $result = ScrapeService::getVideoLinks($id);
        dd($result);
    }
}
