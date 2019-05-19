<?php

use Illuminate\Http\Request;

/*php
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources(['user' => 'API\UserController']);
Route::get('profile', 'API\UserController@profile');
Route::get('findUser', 'API\UserController@search');
Route::put('profile', 'API\UserController@updateProfile');
Route::get('getPosts','PostController@getPosts');
Route::get('getAppointments','ReservationController@getAppointments');
Route::get('loadReserve','QrController@getQr');
Route::get('countCustomer','DashboardController@countCustomer');
Route::get('countPost','DashboardController@countPost');
Route::get('countAppointment','DashboardController@countAppointment');
Route::get('countQr','DashboardController@countQr');
Route::get('userQr','QrController@userQr');
Route::apiResources(['qr'=> 'QrController']);
Route::apiResources(['posts' => 'PostController'] );
Route::apiResources(['pets' => 'PetController']);
Route::apiResources(['reservations' => 'ReservationController']);
Route::get('getPets','ReservationController@getPet');
Route::post('rating','RateController@setrating')->name('setrating');
Route::get('getrate','RateController@getrate')->name('getrate');
Route::get('getpending','StatusController@pendingStatus')->name('getpending');
Route::get('getapprove','StatusController@approveStatus')->name('getapprove');
Route::post('approve/{id}','StatusController@approve')->name('approve');

