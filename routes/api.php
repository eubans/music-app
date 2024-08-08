<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\PlaylistController;
use App\Http\Controllers\Api\PlayerController;

/**
 * Skipped using the middleware auth:sanctum; the reason is we used laravel breeze instead
 * (for login and registration) of using laravel sanctum and create a separate login mechanism on our SPA.
 */
Route::apiResource('/playlists', PlaylistController::class);

Route::controller(PlayerController::class)->group(function () {
    Route::post('/player/play/{id}', 'play');
});
