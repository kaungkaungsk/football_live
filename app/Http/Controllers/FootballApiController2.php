<?php

namespace App\Http\Controllers;

use App\Helper;
use Carbon\Carbon;
use App\Models\Tag;
use App\DataCrawler;
use App\Models\Event;
use App\Models\Movie;
use App\Models\OpenAd;
use App\Models\AppData;
use App\Models\SportNews;
use App\Models\TvChannel;
use App\Traits\CipherTrait;
use App\Models\Advertisement;
use App\Models\FootballMatch;
use App\Models\SportHighlight;
use App\Models\FootballHighlight;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ScrapeController;

class FootballApiController2 extends Controller
{
    use CipherTrait;


    public static function getApiLive()
    {
        $path = 'data/bingsportlive.json';
        $json = Storage::get($path);
        $data = json_decode($json, true);

        return is_null($data) ? [] : $data;
    }


    public static function registerBingsportNewNotificationJob()
    {
        $path = 'data/bingsportlive.json';
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
    }


    public function getSportLive()
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

        // $apiLive = self::getApiLive();
        $controller = new ScrapeController();
        $apiLive = $controller->getMatches();

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
        // return json_encode($collection);
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
