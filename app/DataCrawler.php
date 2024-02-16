<?php

namespace App;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class DataCrawler
{
    static public function fetch3rdLive()
    {
        $httpClient = new Client();
        $response = $httpClient->request(
            'POST',
            'https://bawlonelive.com/api/fixture?page=2',
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

    // static public function fetchLatest3d()
    // {
    //     $url = 'https://mylucky2d3d.com/3d';

    //     $httpClient = new Client();
    //     $response = $httpClient->get($url);
    //     $htmlContent = (string) $response->getBody();

    //     $crawler = new Crawler($htmlContent);

    //     $latestData = $crawler->filter('.feature-card')->first();

    //     $dateString = $latestData->filter('.blockTime')->first()->text();
    //     $carbonDate = Carbon::createFromFormat('d/M/Y', $dateString);
    //     $latest3D = $latestData->filter('.blockLucky')->first()->text();

    //     return [$carbonDate, $latest3D];
    // }


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
