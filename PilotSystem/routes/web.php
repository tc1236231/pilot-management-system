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

/*
 * These are only visible to a logged in user
 */
Route::group([
    'namespace'  => 'Frontend', 'prefix' => '', 'as' => 'frontend.',
    'middleware' => ['auth', 'verified', 'role:admin|user'],
], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');
    Route::get('/dashboard/bind', 'DashboardController@bindPlatformShow')->name('dashboard.bind');
    Route::post('/dashboard/bind', 'DashboardController@bindPlatform')->middleware('throttle:15,10')->name('dashboard.bindPlatform');
    Route::delete('/dashboard/bind', 'DashboardController@unbindPlatform')->name('dashboard.unbindPlatform');
    Route::get('/dashboard/va', 'DashboardController@va')->name('dashboard.va');
    Route::post('/dashboard/va', 'DashboardController@bindva')->name('dashboard.bindva');
    Route::get('/dashboard/profile', 'DashboardController@profile')->name('dashboard.profile');
    Route::put('/dashboard/profile', 'DashboardController@updateProfile')->name('dashboard.updateProfile');
    Route::get('/dashboard/redeem', 'DashboardController@redeem')->name('dashboard.redeem');
    Route::post('/dashboard/redeemFlightHours', 'DashboardController@redeemFlightHours')->name('dashboard.redeemFlightHours');
    Route::post('/dashboard/redeem', 'DashboardController@useRedeemCode')->name('dashboard.useRedeemCode');
    Route::get('/dashboard/transfer', 'DashboardController@transfer')->name('dashboard.transfer');
    Route::group([
        'middleware' => ['pilotlevel:4'], 'prefix' => '/dashboard'
    ], function () {
        Route::get('/admin', 'AdminDashboardController@index')->name('dashboard.admin.index');
        Route::put('/admin/updateProfile', 'AdminDashboardController@updateProfile')->name('dashboard.admin.updateProfile');
        Route::get('/admin/manage', 'AdminDashboardController@manage')->name('dashboard.admin.query');
    });

    Route::group([
        'middleware' => ['role:admin'], 'prefix' => '/dashboard'
    ], function () {
        Route::get('/admin/log', 'AdminDashboardController@log')->name('dashboard.admin.log');
        Route::get('/admin/redeem', 'AdminDashboardController@redeem')->name('dashboard.admin.redeem');
        Route::post('/admin/redeem', 'AdminDashboardController@createRedeem')->name('dashboard.admin.createRedeem');
    });
});

Auth::routes(['verify' => true]);
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');