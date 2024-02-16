<?php

namespace App\Http\Controllers;

use App\DataCrawler;
use App\Models\Advertisement;
use App\Models\AppData;
use App\Models\Event;
use App\Models\FootballHighlight;
use App\Models\FootballMatch;
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
        $event = new Event();
        $event->event_time = Carbon::now()->addSecond(15);
        $event->save();

        return  now()->diffInSeconds($event->event_time);
    }


    public static function getApiLive()
    {
        $path = 'data/live.json';
        $json = Storage::get($path);
        $data = json_decode($json, true);

        if (is_null($data)) {
            $response =  DataCrawler::fetch3rdLive();
            $data =  $response['data'];

            $collection = collect($data);

            $filteredCollection = $collection->filter(function ($item) {
                $today = Carbon::today('Asia/Yangon');
                $matchDate = Carbon::parse($item['date']);

                return $matchDate->gte($today);
            })->values();


            $json = json_encode($filteredCollection, JSON_PRETTY_PRINT);
            Storage::put($path, $json);

            $filteredCollection;
        } else {
            return $data;
        }
    }

    public function getApiData()
    {
        $appData = AppData::get()[0];
        $advertisements = Advertisement::orderBy('created_at', 'DESC')->get();
        $footballHighlight = FootballHighlight::orderBy('created_at', 'DESC')->get();
        $tvChannels = TvChannel::orderBy('created_at', 'DESC')->get();
        $tags = Tag::orderBy('created_at', 'DESC')->get();
        $footballMatch = FootballMatch::with(['team1', 'team2'])->orderBy('match_date', 'ASC')->get();
        $apiLive = $this->getApiLive();


        return $this->encryptData([
            'app_data' => $appData,
            'advertisement' => $advertisements,
            'football_highlight' => $footballHighlight,
            'tv_channel' => $tvChannels,
            'tag' => $tags,
            'football_match' => $footballMatch,
            'api_live' => $apiLive,
        ]);
    }

    public function postIncreaseHighlightView(Request $request)
    {

        $footballHighlight = FootballHighlight::find($request->highlight_id);

        $footballHighlight->increment('views');

        return response('Success', 200);
    }
}
