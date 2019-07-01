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
    Route::get('/client/config','ConfigController@getConfig')->name('client.config');
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
    Route::get('/fsd/login', 'FSDController@login')->name('fsd.login');
    Route::post('/pilot/register', 'PilotController@register')->name('pilot.register');
    Route::get('/pilot/verify', 'PilotController@verifyCallsignPassword')->name('pilot.verify');
    Route::get('/pilot/new/verify', 'PilotController@verifyNewPilot')->name('pilot.new.verify');
    Route::post('/pilot/change/password', 'PilotController@changePassword')->name('pilot.change.password');
    Route::post('/pilot/exam/redeem', 'PilotController@redeemExam')->name('pilot.exam.redeem');
});

Route::group([
    'middleware' => ['auth:web,bbs'],
    'namespace' => 'Api', 'prefix' => '', 'as' => 'api.',
], function () {
    Route::post('/atc/atis', 'ATCController@createATIS')->name('atc.atis.create');
    Route::post('/atc/restrict/status', 'ATCController@updateRestrictStatus')->name('atc.restrict.status.change');
    Route::get('/atc/callsign/query', 'ATCController@queryCallsignStatus')->name('atc.callsign.query');
    Route::get('/atc/callsign/ban', 'ATCController@banCallsign')->name('atc.callsign.ban');
    Route::get('/atc/callsign/unban', 'ATCController@unbanCallsign')->name('atc.callsign.unban');
    Route::get('/atc/callsign/mod', 'ATCController@modCallsign')->name('atc.callsign.mod');
});