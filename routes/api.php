<?php

use App\Http\Controllers\FootballApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(FootballApiController::class)->group(function () {
    Route::get("/api_data", 'getOldApiData');
    Route::get("/new_api_data", 'getNewApiData');
    Route::post("/increase_highlight_view", 'postIncreaseHighlightView');
    Route::get("/sport_news", 'getSportNews');
    Route::get("/sport_highlights", 'getSportHighlights');
    Route::get("/tv_channels", 'getTvChannels');
    Route::get("/movies", 'getMovies');
    Route::get("/open_ad", 'getOpenAd');
});
