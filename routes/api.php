<?php

use App\Http\Controllers\FootballApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(FootballApiController::class)->group(function () {
    Route::get("/api_data", 'getApiData');
    Route::post("/increase_highlight_view", 'postIncreaseHighlightView');
});
