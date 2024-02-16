<?php

namespace App\Models;

use App\Jobs\SendPushNotificationJob;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesJobs;

class Event extends Model
{
    // use HasFactory;
    use DispatchesJobs;

    public function save(array $options = [])
    {
        parent::save($options);

        // Dispatch notification job on event creation/update
        $this->dispatchNotificationJob();
    }

    public function dispatchNotificationJob()
    {
        $delay = now()->diffInSeconds($this->event_time);
        $this->dispatch(new SendPushNotificationJob($this))->delay($delay);
    }
}
