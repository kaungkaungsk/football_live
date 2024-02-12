<?php

namespace App\Http\Controllers;

use App\Models\FcmToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;

class FcmTokenController extends BaseController
{
    // public static function sendNotification(
    //     String $title,
    //     String $body
    // ) {
    //     $allTokens = FCMToken::all();

    //     foreach ($allTokens as $token) {

    //         $messaging = (new Factory())->createMessaging();

    //         $message = (CloudMessage::new())
    //             ->withNotification([
    //                 'title' => $title,
    //                 'body' => $body,
    //             ])
    //             ->withTarget('token', 'device-token-here');


    //         $messaging->send($message);
    //     }
    // }

    // public function sendMessage(Request $request)
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


    // public function saveToken(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'device_token' => 'required|string',
    //         'old_token' => 'string',
    //     ]);

    //     if ($validator->fails()) {
    //         return $this->sendError('Validation Fail', $validator->errors(), 400);
    //     }


    //     $token = FCMToken::where('device_token', $request->device_token)->count();

    //     if ($token == 0) {
    //         $token = new FCMToken();
    //         $token->device_token = $request->device_token;
    //         $token->save();
    //     }

    //     if ($request->old_token) {
    //         $token = FcmToken::where('device_token', $request->old_token);
    //         if ($token) {
    //             $token->delete();
    //         }
    //     }

    //     return $this->sendResponse(null, 'Save Successfully!');
    // }
}
