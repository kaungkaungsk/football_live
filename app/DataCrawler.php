<?php

namespace App;

use GuzzleHttp\Client;

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
}
