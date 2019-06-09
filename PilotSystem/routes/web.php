<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
    'namespace' => 'Frontend', 'prefix' => '', 'as' => 'frontend.',
], function () {
    Route::get('/', 'HomeController@index')->name('home');
});

Route::group([
   'namespace' => 'ClientUI', 'prefix' => 'clientui', 'as' => 'clientui.'
], function () {
    Route::get('/login', 'LoginController@index')->middleware(['guest:web,bbs'])->name('login.show');
    Route::post('/login', 'LoginController@login')->middleware(['guest:web,bbs','throttle:60,1'])->name('login.action');
    Route::group([
       'middleware' => ['auth:web,bbs']
    ], function() {
        Route::get('/logout','LoginController@logout')->name('logout');
        Route::get('/index','HomeController@index')->name('index');
        Route::get('/news/{type}','HomeController@news')->name('news');
        Route::get('/flightcenter','HomeController@flightcenter')->name('flightcenter');
        Route::get('/vaflight','HomeController@vaflight')->name('vaflight');
        Route::get('/voice','HomeController@voice')->name('voice');
        Route::get('/atc','HomeController@atc')->name('atc');
        Route::get('/vip','HomeController@vip')->name('vip');
        Route::get('/faq','HomeController@faq')->name('faq');
        Route::get('/dispatching','HomeController@dispatching')->name('dispatching');
        Route::get('/radar','HomeController@radar')->name('radar');
    });
});

/*
 * These are only visible to a logged in user
 */
Route::group([
    'namespace'  => 'Frontend', 'prefix' => 'dashboard', 'as' => 'frontend.',
    'middleware' => ['auth', 'verified', 'role:admin'],
], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard.index');
    Route::get('/bind', 'DashboardController@bindPlatformShow')->name('dashboard.bind');
    Route::post('/bind', 'DashboardController@bindPlatform')->middleware('throttle:15,10')->name('dashboard.bindPlatform');
    Route::get('/unbind', 'DashboardController@unbindPlatform')->name('dashboard.unbindPlatform');
    Route::get('/va', 'DashboardController@va')->name('dashboard.va');
    Route::post('/va', 'DashboardController@bindva')->name('dashboard.bindva');
    Route::get('/profile', 'DashboardController@profile')->name('dashboard.profile');
    Route::put('/profile', 'DashboardController@updateProfile')->name('dashboard.updateProfile');
    Route::get('/redeem', 'DashboardController@redeem')->name('dashboard.redeem');
    Route::post('/redeemFlightHours', 'DashboardController@redeemFlightHours')->name('dashboard.redeemFlightHours');
    Route::post('/redeem', 'DashboardController@useRedeemCode')->name('dashboard.useRedeemCode');
    Route::get('/transfer', 'DashboardController@transfer')->name('dashboard.transfer');

    Route::group([
        'prefix' => '/link'
    ], function () {
        Route::get('/flightrule', function () {
            return view('dashboard.link.flightrule');
        })->name('dashboard.link.flightrule');
        Route::get('/joinus', function () {
            return view('dashboard.link.joinus');
        })->name('dashboard.link.joinus');
    });

    Route::group([
        'prefix' => '/rank'
    ], function () {
        Route::get('/pilot', function () {
            return view('dashboard.rank.wip');
        })->name('dashboard.rank.pilot');
        Route::get('/atc', function () {
            return view('dashboard.rank.wip');
        })->name('dashboard.rank.atc');
        Route::get('/platform', function () {
            return view('dashboard.rank.wip');
        })->name('dashboard.rank.platform');
    });

    Route::group([
        'middleware' => ['pilotlevel:4'], 'prefix' => '/admin'
    ], function () {
        Route::get('', 'AdminDashboardController@index')->name('dashboard.admin.index');
        Route::put('/updateProfile', 'AdminDashboardController@updateProfile')->name('dashboard.admin.updateProfile');
        Route::get('/manage', 'AdminDashboardController@manage')->name('dashboard.admin.query');
    });

    Route::group([
        'middleware' => ['pilotlevel:11'], 'prefix' => '/admin'
    ], function () {
        Route::get('/redeem', 'AdminDashboardController@redeem')->name('dashboard.admin.redeem');
        Route::post('/redeem', 'AdminDashboardController@createRedeem')->name('dashboard.admin.createRedeem');
    });

    Route::group([
        'middleware' => ['pilotlevel:12'], 'prefix' => '/admin'
    ], function () {
        Route::get('/log', 'AdminDashboardController@log')->name('dashboard.admin.log');
    });

});

//Auth::routes(['verify' => true]);
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');