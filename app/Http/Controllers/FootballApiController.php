<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\AppData;
use App\Models\FootballHighlight;
use App\Models\FootballMatch;
use App\Models\Tag;
use App\Models\TvChannel;
use App\Traits\CipherTrait;
use Illuminate\Http\Request;

class FootballApiController extends Controller
{
    use CipherTrait;

    public function getApiData()
    {
        $appData = AppData::get()[0];
        $advertisements = Advertisement::orderBy('created_at', 'DESC')->get();
        $footballHighlight = FootballHighlight::orderBy('created_at', 'DESC')->get();
        $tvChannels = TvChannel::orderBy('created_at', 'DESC')->get();
        $tags = Tag::orderBy('created_at', 'DESC')->get();
        $footballMatch = FootballMatch::with(['team1', 'team2'])->orderBy('match_date', 'ASC')->get();


        return $this->encryptData([
            'app_data' => $appData,
            'advertisement' => $advertisements,
            'football_highlight' => $footballHighlight,
            'tv_channel' => $tvChannels,
            'tag' => $tags,
            'football_match' => $footballMatch,
        ]);
    }

    public function postIncreaseHighlightView(Request $request)
    {

        $footballHighlight = FootballHighlight::find($request->highlight_id);

        $footballHighlight->increment('views');

        return response('Success', 200);
    }
}
