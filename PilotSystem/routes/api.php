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
    Route::get('/pilot/recommend/callsign', 'PilotController@getRecommendCallsign')->name('pilot.recommend.callsign');
    Route::get('/pilot/status', 'PilotController@queryPublicPilotStatus')->name('pilot.status');
    Route::get('/va/pilot/{pilotid}/pireps', 'VirtualAirlineController@getPireps')->name('va.pilot.pireps');
    Route::get('/atc/atis', 'ATCController@getATIS')->name('atc.atis.get');
    Route::get('/pilot/export', 'PilotController@exportPilot')->name('pilot.export');
    Route::get('/pilot/mobile/verify/send', 'PilotController@sendMobileVerifyCode')
        ->middleware('throttle:15,1')
        ->name('pilot.mobile.verify.send');
});

Route::group([
    'middleware' => ['auth:api'],
    'namespace' => 'Api', 'prefix' => '', 'as' => 'api.',
], function () {
    Route::post('/pilot/register', 'PilotController@register')->name('pilot.register');
    Route::get('/pilot/verify', 'PilotController@verifyCallsignPassword')->name('pilot.verify');
    Route::get('/pilot/new/verify', 'PilotController@verifyNewPilot')->name('pilot.new.verify');
    Route::post('/pilot/change/password', 'PilotController@changePassword')->name('pilot.change.password');
    Route::post('/pilot/exam/redeem', 'PilotController@redeemExam')->name('pilot.exam.redeem');
});

Route::group([
    'middleware' => ['auth'],
    'namespace' => 'Api', 'prefix' => '', 'as' => 'api.',
], function () {
    Route::post('/atc/atis', 'ATCController@createATIS')->middleware('pilotlevel:4')->name('atc.atis.create');
    Route::post('/atc/restrict/status', 'ATCController@updateRestrictStatus')->middleware('pilotlevel:4')->name('atc.restrict.status.change');
});