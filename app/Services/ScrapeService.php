<?php

namespace App\Services;

class ScrapeService {
    public static function getLiveMatches(){
        include_once app_path('Helpers/SimpleHtmlDom.php');
        $targetUrl = 'https://live.thapcam72.net/football';
        $html =  file_get_html($targetUrl);
        if($html){

            #for today
            $today_div = $html->find('.tag_content', 1);
            $matches = $today_div->find('.match');
            $todayMatches = [];
            foreach ($matches as $match) {
                $href = $match->href;
                $parts = explode('-', $href);
                $id = end($parts);
                $home = $match->find('.team--home', 0);
                $homeLogo = $home->find('.team__logo', 0)->getAttribute('data-src');
                $homeName = $home->find('.team__name', 0)->plaintext;
                $away = $match->find('.team--away', 0);
                $awayLogo = $away->find('.team__logo', 0)->getAttribute('data-src');
                $awayName = $away->find('.team__name', 0)->plaintext;
                $todayMatches[] = [
                    'scrapale_link' => url('/') . '/api/scrape/' . $id,
                    'date' => '',
                    'league' => '',
                    'home' => [
                        'name' => $homeName,
                        'logo' => $homeLogo
                    ],
                    'away' => [
                        'name' => $awayName,
                        'logo' => $awayLogo
                    ]
                ];
            }

            #for tomorrow
            $tomorrow_div = $html->find('.tag_content', 2);
            $tmatches = $tomorrow_div->find('.match');
            $tomorrowMatches = [];
            foreach ($tmatches as $match) {
                $href = $match->href;
                $parts = explode('-', $href);
                $id = end($parts);
                $home = $match->find('.team--home', 0);
                $homeLogo = $home->find('.team__logo', 0)->getAttribute('data-src');
                $homeName = $home->find('.team__name', 0)->plaintext;
                $away = $match->find('.team--away', 0);
                $awayLogo = $away->find('.team__logo', 0)->getAttribute('data-src');
                $awayName = $away->find('.team__name', 0)->plaintext;
                $tomorrowMatches[] = [
                    'scrapale_link' => url('/') . '/api/scrape/' . $id,
                    'date' => '',
                    'league' => '',
                    'home' => [
                        'name' => $homeName,
                        'logo' => $homeLogo
                    ],
                    'away' => [
                        'name' => $awayName,
                        'logo' => $awayLogo
                    ]
                ];
            }
            $mergedArray = array_merge($todayMatches, $tomorrowMatches);
            return $mergedArray;
        }
    }

    public static function getVideoLinks($id){
        $matchData = file_get_contents('https://api.thapcam.xyz/api/match/tc/'. $id . '/no/meta');
        $dataArray = json_decode($matchData, true);
        if($dataArray['status'] == 1){
            return $dataArray['data']['play_urls'];
        }
        return $dataArray;
    }
}
