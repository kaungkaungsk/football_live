<?php

namespace App\Http\Controllers;

use App\DataCrawler;
use App\Helper;
use App\Models\Advertisement;
use App\Models\AppData;
use App\Models\Event;
use App\Models\FootballHighlight;
use App\Models\FootballMatch;
use App\Models\Movie;
use App\Models\OpenAd;
use App\Models\SportHighlight;
use App\Models\SportNews;
use App\Models\Tag;
use App\Models\TvChannel;
use App\Notification;
use App\Traits\CipherTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FootballApiController extends Controller
{
    use CipherTrait;

    public function getTest()
    {
        $path2 = 'data/bingsportlive.json';
        $json2 = Storage::get($path2);
        $data2 = json_decode($json2, true);

        return $data2;
    }

    public static function getApiLive($refresh)
    {
        $path = 'data/live.json';
        $json = Storage::get($path);
        $data = json_decode($json, true);

        //todo: uncomment this code
        // $path2 = 'data/bingsportlive.json';
        // $json2 = Storage::get($path2);
        // $data2 = json_decode($json2, true);

        if ($refresh) {
            // return array_merge(FootballApiController::crawlAndSaveData(), $data2);
            return FootballApiController::crawlAndSaveData();
        } else {
            if (is_null($data)) {
                // return array_merge(FootballApiController::crawlAndSaveData(), $data2);
                return FootballApiController::crawlAndSaveData();
            } else {
                // return array_merge($data, $data2);
                return $data;
            }
        }
    }

    public static function crawlAndSaveData()
    {
        $path = 'data/live.json';
        $page = 2;
        $response =  DataCrawler::fetch3rdLive($page);
        $data =  $response['data'];

        if ($response['pagination']['last_page'] != 2) {
            $page = $response['pagination']['last_page'];

            $response =  DataCrawler::fetch3rdLive($page);
            $data =  $response['data'];
        }

        $collection = collect($data);

        $filteredCollection = $collection->filter(function ($item) {
            $today = Carbon::today('Asia/Yangon');
            $matchDate = Carbon::parse($item['date']);

            return $matchDate->gte($today);
        })->values();

        $reconstrut = [];
        $keywords = ['bawlone', 'sports geek'];

        foreach ($filteredCollection as $match) {

            $rematch = [];

            $rematch['fixture_id'] = $match['fixture_id'];
            $rematch['date'] = $match['date'];
            $rematch['goals'] = $match['goals'];
            $rematch['league'] = $match['league'];
            $rematch['home'] = $match['home'];
            $rematch['away'] = $match['away'];


            $videoLinks = $match['video_links'];
            foreach ($videoLinks as $key => $link) {
                $name = strtolower($link['name']);
                $link = strtolower($link['link']);

                foreach ($keywords as $k) {
                    if ((str_contains($name, $k) || str_contains($link, $k))) {
                        unset($videoLinks[$key]);
                        break;
                    }
                }
            }

            $rematch['video_links'] = collect($videoLinks)->values();

            array_push($reconstrut,  $rematch);
        }


        $json = json_encode($reconstrut, JSON_PRETTY_PRINT);
        Storage::put($path, $json);

        FootballApiController::modifyJobQueue();

        return $reconstrut;
    }

    public static function modifyJobQueue()
    {
        $path = 'data/live.json';
        $json = Storage::get($path);
        $data = json_decode($json, true);

        foreach ($data as $key => $value) {
            $matchId =  $value['fixture_id'];
            $event = Event::where(['match_id' => $matchId, 'own' => 0])->exists();
            if (!$event) {
                $event = new Event();
                $event->own = false;
                $event->match_id = $matchId;
                $event->event_time = Carbon::parse($value['date']);
                $event->title = Helper::titleFormat($value['league']['name']);
                $event->message = Helper::messageFormat($value['home']['name'], $value['away']['name']);

                $event->save();
            }
        }

        //todo: uncomment this code
        // $path2 = 'data/bingsportlive.json';
        // $json2 = Storage::get($path2);
        // $data2 = json_decode($json2, true);

        // foreach ($data2 as $key => $value) {
        //     $matchId =  $value['fixture_id'];
        //     $event = Event::where(['match_id' => $matchId, 'own' => 0])->exists();
        //     if (!$event) {
        //         $event = new Event();
        //         $event->own = false;
        //         $event->match_id = $matchId;
        //         $event->event_time = Carbon::parse($value['date']);
        //         $event->title = Helper::titleFormat($value['league']['name']);
        //         $event->message = Helper::messageFormat($value['home']['name'], $value['away']['name']);

        //         $event->save();
        //     }
        // }
    }


    public function getOldApiData()
    {
        $appData = AppData::get()[0];

        $advertisements = Advertisement::orderBy('created_at', 'DESC')->get();
        foreach ($advertisements as $item) {
            $item->image = $item->image ?? $item->image_link;
        }

        $footballHighlight = FootballHighlight::orderBy('created_at', 'DESC')->get();

        $tvChannels = TvChannel::orderBy('created_at', 'DESC')->get();
        foreach ($tvChannels as $item) {
            $item->image = $item->image ?? $item->image_link;
        }

        $tags = Tag::orderBy('created_at', 'DESC')->get();

        $footballMatch = FootballMatch::with(['team1', 'team2'])->orderBy('match_date', 'ASC')->get();

        $apiLive = $this->getApiLive(false);

        $collection = [
            'app_data' => $appData,
            'advertisement' => $advertisements,
            'football_highlight' => $footballHighlight,
            'tv_channel' => $tvChannels,
            'tag' => $tags,
            'football_match' => $footballMatch,
            'api_live' => $apiLive,
        ];

        return $this->oldEncryptData(json_encode($collection));
    }


    public function getNewApiData()
    {
        $appData = AppData::get()[0];

        $advertisements = Advertisement::orderBy('created_at', 'DESC')->get();
        foreach ($advertisements as $item) {
            $item->image = $item->image ?? $item->image_link;
        }

        $footballHighlight = FootballHighlight::orderBy('created_at', 'DESC')->get();

        $tvChannels = TvChannel::orderBy('created_at', 'DESC')->get();
        foreach ($tvChannels as $item) {
            $item->image = $item->image ?? $item->image_link;
        }

        $tags = Tag::orderBy('created_at', 'DESC')->get();

        $footballMatch = FootballMatch::with(['team1', 'team2'])->orderBy('match_date', 'ASC')->get();

        $apiLive = $this->getApiLive(false);

        $collection = [
            'app_data' => $appData,
            'advertisement' => $advertisements,
            'football_highlight' => $footballHighlight,
            'tv_channel' => $tvChannels,
            'tag' => $tags,
            'football_match' => $footballMatch,
            'api_live' => $apiLive,
        ];

        return $this->encryptData(json_encode($collection));
    }


    public function getOpenAd()
    {
        $data = OpenAd::get()[0];
        foreach ($data as $item) {
            $item->image = $item->image ?? $item->image_link;
        }

        return $this->encryptData(json_encode($data));
    }

    public function getTvChannels()
    {
        $data = TvChannel::orderBy('created_at', 'DESC')
            ->paginate(50);

        foreach ($data as $item) {
            $item->image = $item->image ?? $item->image_link;
        }

        return $this->encryptData(json_encode($data));
    }

    public function getMovies()
    {
        $data = Movie::orderBy('created_at', 'DESC')
            ->paginate(50);

        foreach ($data as $item) {
            $item->image = $item->image ?? $item->image_link;
        }

        return $this->encryptData(json_encode($data));
    }

    public function getSportHighlights()
    {
        $data = SportHighlight::orderBy('match_date', 'DESC')
            ->paginate(50);
        return $this->encryptData(json_encode($data));
    }

    public function getSportNews()
    {
        $data = SportNews::orderBy('created_at', 'DESC')
            ->paginate(50);;

        foreach ($data as $item) {
            $item->image = $item->image ?? $item->image_link;
        }

        return $this->encryptData(json_encode($data));
    }
}
