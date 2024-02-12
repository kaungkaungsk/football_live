<?php

namespace App\Http\Controllers;

// use App\Config;
// use App\DataCrawler;
// use App\Models\Holiday;
// use App\Models\Result;
// use App\Models\Result3D;
// use App\Traits\CipherTrait;
// use Carbon\Carbon;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Validator;

// class ResultController extends BaseController
// {
//     use CipherTrait;

//     public function getTest()
//     {
//         // $data = DataCrawler::fetchLatest3d();

//         return $this->encryptData("Lee Lar");
//     }

//     public function getLiveServerData()
//     {
//         $data =  [
//             'set_url' => Config::$setUrl,
//             'headers' => Config::$options['headers'],
//         ];

//         return $this->encryptData($data);
//     }

//     public function getServerTime()
//     {
//         $data = [
//             'server_time' => Carbon::now('Asia/Yangon')->toDateTimeString()
//         ];

//         return $this->encryptData($data);
//     }


//     public function getHoliday()
//     {
//         $data = Holiday::holiday_list();

//         return $this->encryptData($data);
//     }


//     public function getLatestResult(Request $request)
//     {
//         $result = Result::orderBy('created_at', 'DESC')->first();

//         if ($result) {
//             $result->is_holiday = Holiday::isTodayHoliday();
//         } else {
//             $result = [
//                 'is_holiday' => Holiday::isTodayHoliday()
//             ];
//         }

//         return $this->encryptData($result);
//     }

//     public function get3DResult(Request $request)
//     {
//         $result = Result3D::orderBy('result_date', 'DESC')->get();
//         return $this->encryptData($result);
//     }

//     public function get2DResult(Request $request)
//     {
//         $result = Result::orderBy('created_at', 'DESC')->get();
//         return $this->encryptData($result);
//     }

//     public function get2DResultByDate(Request $request)
//     {
//         //prefer yyyy-mm-dd format
//         if ($request->date) {
//             $date = $request->date;

//         }
//         $result = Result::whereDate('created_at', date($date))->get();
//         return $this->encryptData($result);
//     }
// }
