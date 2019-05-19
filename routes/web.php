<?php


Route::get('/', function () {
    return view('welcome');
});

Route::get('/verify', 'VerifyController@show')->name('verify');
Route::post('/verify', 'VerifyController@verify')->name('verify');      

    Auth::routes();



Route::get('/home', 'HomeController@index')->name('home');
/*Route::get('invoice', function(){
    return 'test';
})->middleware('verified');*/
/*Route::get('customer', [
  'as' => 'customer',
  'uses' => 'Auth\LoginController@showLoginForm'
]);*/
/*Route::get('clinicdashboard', function (){
        return 'test';
});*/
/*Route::get('clinic', 'Auth\AdminController@showLoginForm');
Route::post('admin-login', ['as'=>'admin-login','uses'=>'Auth\AdminController@login']);*/
Route::get('/{path}',"HomeController@index")->where( 'path', '.*' );

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
