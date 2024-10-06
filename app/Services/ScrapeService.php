<?php

namespace App\Services;

use DateTime;
use Illuminate\Support\Facades\Storage;

class ScrapeService {
    public static function scrapeMatches(){
        include_once app_path('Helpers/SimpleHtmlDom.php');
        $targetUrl = 'https://live.thapcam72.net/football';
        $html =  file_get_html($targetUrl);
        if($html){

            //for today
            $today_div = $html->find('.tag_content', 1);
            $today_matches = [];
            $tournaments = $today_div->find('.tourz');
            foreach($tournaments as $tour) {
                $league_title = $tour->find('.league_title', 0)->plaintext;
                $matches = $tour->find('.match');
                foreach ($matches as $match) {
                    $date = $match->find('.grid-match__date', 0)->plaintext;
                    $href = $match->href;
                    $parts = explode('-', $href);
                    $id = end($parts);
                    $home = $match->find('.team--home', 0);
                    $home_logo = $home->find('.team__logo', 0)->getAttribute('data-src');
                    $home_name = $home->find('.team__name', 0)->plaintext;
                    $away = $match->find('.team--away', 0);
                    $away_logo = $away->find('.team__logo', 0)->getAttribute('data-src');
                    $away_name = $away->find('.team__name', 0)->plaintext;
                    $video_links = self::getVideoLinks($id);
                    $today_matches[] = [
                        'video_links' => $video_links,
                        'date' => self::formatDate($date),
                        'league' => trim($league_title),
                        'home' => [
                            'name' => $home_name,
                            'logo' => $home_logo
                        ],
                        'away' => [
                            'name' => $away_name,
                            'logo' => $away_logo
                        ]
                    ];
                }
            }

            //for tomorrow
            $tomorrow_div = $html->find('.tag_content', 2);
            $tournaments = $tomorrow_div->find('.tourz');
            $tomorrow_matches = [];
            foreach($tournaments as $tour) {
                $league_title = $tour->find('.league_title', 0)->plaintext;
                $tmatches = $tour->find('.match');
                foreach ($tmatches as $match) {
                    $date = $match->find('.grid-match__date', 0)->plaintext;
                    $href = $match->href;
                    $parts = explode('-', $href);
                    $id = end($parts);
                    $home = $match->find('.team--home', 0);
                    $home_logo = $home->find('.team__logo', 0)->getAttribute('data-src');
                    $home_name = $home->find('.team__name', 0)->plaintext;
                    $away = $match->find('.team--away', 0);
                    $away_logo = $away->find('.team__logo', 0)->getAttribute('data-src');
                    $away_name = $away->find('.team__name', 0)->plaintext;
                    $video_links = self::getVideoLinks($id);
                    $tomorrow_matches[] = [
                        'video_links' => $video_links,
                        'date' => self::formatDate($date),
                        'league' => trim($league_title),
                        'home' => [
                            'name' => $home_name,
                            'logo' => $home_logo
                        ],
                        'away' => [
                            'name' => $away_name,
                            'logo' => $home_logo
                        ]
                    ];
                }
                }
            $merged_array = array_merge($today_matches, $tomorrow_matches);
            $json = json_encode($merged_array, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
            $path = 'data/scrape.json';
            Storage::put($path, $json);
        }
    }

    public static function getScrapedMatches(){
        $path = 'data/scrape.json';
        $json = Storage::get($path);
        $data = json_decode($json, true);
        if($data != null){
            return $data;
        }
        return [];
    }

    public static function getVideoLinks($id){
        $match_data = file_get_contents('https://api.thapcam.xyz/api/match/tc/'. $id . '/no/meta');
        $data_array = json_decode($match_data, true);
        if($data_array['status'] == 1){
            $video_links = $data_array['data']['play_urls'];
            if($video_links == null) return [];
            $referer = 'https://i.fdcdn.xyz/';
            foreach($video_links as &$link) {
                $link['referer'] = $referer;
            }
            return $video_links;

        }
        return $data_array;
    }

    public static function formatDate($input){
        $currentYear = date("Y");
        $formattedInput = $input . " " . $currentYear;
        $dateTime = DateTime::createFromFormat('H:i d/m Y', $formattedInput);
        if ($dateTime) {
            return $dateTime->format('Y-m-d H:i:s');
        }
        return '';
    }

}
