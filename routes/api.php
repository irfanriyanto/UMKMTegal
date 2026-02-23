<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| All API routes are automatically rate limited using the 'api' rate limiter
| defined in AppServiceProvider:
| - Unauthenticated: 60 requests per minute (by IP)
| - Authenticated: 120 requests per minute (by user ID)
|
*/

Route::middleware(['throttle:api'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');
});
