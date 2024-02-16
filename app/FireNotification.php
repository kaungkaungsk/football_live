<?php

namespace App;

use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;

class FireNotification
{
    public static function sendNotification($title, $message)
    {
        $messaging = Firebase::messaging();

        $message = (CloudMessage::fromArray([
            'notification' => [
                'title' => $title,
                'body' => $message,
            ],
            'topic' => 'notification',
            'channel_id' => 'test',
            // 'android' => [
            //     'notification' => [
            //         'channel_id' => 'test',
            //     ],
            // ],
        ]));

        $messaging->send($message);
    }



    // public static function sendMessage(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'title' => 'required|string',
    //         'message' => 'required|string',
    //     ]);

    //     if ($validator->fails()) {
    //         return $this->sendError('Validation Fail', $validator->errors(), 400);
    //     }

    //     $this->sendNotification(
    //         $request->title,
    //         $request->message,
    //     );

    //     return $this->sendResponse(null, 'Save Successfully!');
    // }

}
