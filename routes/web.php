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

Route::get('/', function () {
    return view('welcome');
});



Route::get('/login', 'AuthController@loginForm')->middleware('guest');
Route::post('/login', 'AuthController@login')->name('auth.login');

Route::get('/register', 'AuthController@registerForm');
Route::post('/register', 'AuthController@register')->name('auth.register');

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::delete('/logout', 'AuthController@logout')->name('auth.logout');

});


