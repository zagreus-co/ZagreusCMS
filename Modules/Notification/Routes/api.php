<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->post('/notifications', function (Request $request) {
    return \Modules\Notification\Entities\Notification::query()
        ->whereUserId(auth()->user()->id)
        ->whereVisible(1)
        ->latest()
        ->limit(10)
        ->get();
});