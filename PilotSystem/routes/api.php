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

Route::group([
    'middleware' => ['throttle:60,1'],
    'namespace' => 'Api', 'prefix' => 'public', 'as' => 'api.public.',
], function () {
    Route::get('/pilot/status', 'PilotController@queryPublicPilotStatus')->name('pilot.status');
});

Route::group([
    'middleware' => ['auth:api'],
    'namespace' => 'Api', 'prefix' => '', 'as' => 'api.',
], function () {
    Route::get('/pilot/verify', 'PilotController@verifyCallsignPassword')->name('pilot.verify');
});