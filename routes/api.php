<?php

use App\Http\Controllers\AdsController;
use App\Http\Controllers\FootballApiController;
use App\Http\Controllers\ScrapeController;
use App\Http\Controllers\FootballApiController2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(FootballApiController::class)->group(function () {
    Route::get("/test", 'getTest');
    Route::get("/new_api_data", 'getNewApiData');
    Route::get("/sport_news", 'getSportNews');
    Route::get("/sport_highlights", 'getSportHighlights');
    Route::get("/tv_channels", 'getTvChannels');
    Route::get("/movies", 'getMovies');
    Route::get("/open_ad", 'getOpenAd');
});

Route::controller(FootballApiController2::class)->group(function () {
    Route::get("/sport_live", 'getSportLive');
});

Route::controller(AdsController::class)->group(function () {
    Route::get('/ads_data', 'getAdsData');
    Route::post('/click_count', 'postClickCount');
});

Route::get('/scrape', [ScrapeController::class, 'scrape']);
Route::get('/scrape/{id}', [ScrapeController::class, 'links']);
