<?php

namespace App;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class DataCrawler
{
    static public function fetch3rdLive($page)
    {
        $httpClient = new Client();
        $response = $httpClient->request(
            'POST',
            "https://bawlonelive.com/api/fixture?page=$page",
            [
                'headers' => [
                    'user-agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.6 Mobile/15E148 Safari/604.1',
                    'accept' => 'application/json'
                ]
            ],
        );
        $jsonData = json_decode((string) $response->getBody(), true);

        return $jsonData;
    }


    // static public function fetchModernInternetData()
    // {
    //     $url = 'https://mylucky2d3d.com';

    //     $httpClient = new Client();
    //     $response = $httpClient->get($url);
    //     $htmlContent = (string) $response->getBody();

    //     $crawler = new Crawler($htmlContent);

    //     // Extract values based on class names
    //     $modIntVValues = $crawler->filter('.modIntV')->each(function (Crawler $node) {
    //         return (int) $node->text();
    //     });


    //     return $modIntVValues;
    // }

    static public function fetchHighlight()
    {
        $url = 'https://bingsportlive.com/high-light';

        $httpClient = new Client();
        $response = $httpClient->get($url);
        $htmlContent = (string) $response->getBody();

        $crawler = new Crawler($htmlContent);

        $itemMatches = $crawler->filter('a.item-match');

        $data = [];

        foreach ($itemMatches as $itemMatch) {
            // $itemContent = $itemMatch->nodeValue; // or $itemContent = $itemMatch->html();

            // return $itemContent;
            // // Create a new crawler from the content (optional)
            // if (strpos($itemContent, '<') !== false) { // Check if content contains HTML tags
            //     $itemCrawler = new Crawler($itemContent);
            //     $leagueName = $itemCrawler->filter('.league-name')->text();
            // } else {
            //     // Content is plain text, handle accordingly
            //     $leagueName = null; // or process plain text
            // }

            $data[] = ($itemMatch);
        }

        return $data;
    }


    // static public function fetchTaiwanData()
    // {
    //     $url = 'https://mis.twse.com.tw/stock/data/mis_ohlc_WWW.txt';

    //     $client = new Client();
    //     $api_resource = $client->request('GET', $url);
    //     $data = json_decode($api_resource->getBody()->getContents(), true);

    //     $set = floatval($data["infoArray"][0]["v"]) / 100;
    //     $value = $data["infoArray"][0]["z"];
    //     $tw = substr($data["infoArray"][0]["z"], -1) . substr($data["infoArray"][0]["v"], 3, 1);

    //     return [$set, $value, $tw];
    // }
}
