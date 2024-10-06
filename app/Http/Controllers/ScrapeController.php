<?php

namespace App\Http\Controllers;

use Log;
use App\scripts;
use Illuminate\Http\Request;

class ScrapeController extends Controller
{
    public function scrape()
    {
        $scriptPath = app_path('scripts/scrape_matches.py');

        $output = shell_exec("python3 $scriptPath 2>&1");
        // Log::info("Scraping output: $output");

        $jsonPath = storage_path('app/data/scrape.json');

        if (file_exists($jsonPath)) {
            $matches = json_decode(file_get_contents($jsonPath), true);
            return response()->json($matches);
        }

        return response()->json([], 404);
    }

    public function getMatches(){
        $jsonPath = storage_path('app/data/scrape.json');
        if (file_exists($jsonPath)) {
            $matches = json_decode(file_get_contents($jsonPath), true);
            return $matches;
        }
        return [];
    }

    public function links($id){
        $result = ScrapeService::getVideoLinks($id);
    }


}
