<?php

namespace App\Jobs;

use App\FireNotification;
use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPushNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function handle()
    {
        FireNotification::sendNotification('hello', 'world');
        // // Get users associated with the event
        // $users = $this->event->users;

        // // Send notifications to each user
        // foreach ($users as $user) {
        //     // Use your chosen push notification service here
        //     // Example for Pusher:
        //     // Pusher::trigger('notifications', 'event-'.$this->event->id, ['message' => 'An event is happening soon!']);
        // }
    }
}
