<?php

namespace App\Filament\Resources\FootballMatchResource\Pages;

use App\Filament\Resources\FootballMatchResource;
use App\FireNotification;
use App\Helper;
use App\Models\Event;
use App\Models\Tag;
use App\Models\Team;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateFootballMatch extends CreateRecord
{
    protected static string $resource = FootballMatchResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $tag = Tag::find($data['tag_id'])->title;
        $home = Team::find($data['team1_id'])->team_name;
        $away = Team::find($data['team2_id'])->team_name;

        $res = static::getModel()::create($data);

        $event = new Event();
        $event->own = true;
        $event->match_id = $res['id'];
        $event->event_time = Carbon::parse($res['match_date']);
        $event->title = Helper::titleFormat($tag);
        $event->message = Helper::messageFormat($home, $away);

        $event->save();

        return $res;
    }
}
