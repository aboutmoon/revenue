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

use App\Http\Controllers\Auth;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/login', 'Auth\LoginController@showLoginForm')->middleware('guest');
Route::post('/login', 'Auth\LoginController@login')->name('auth.login');

Route::get('/register', 'Auth\RegisterController@showRegistrationForm');
Route::post('/register', 'Auth\RegisterController@register')->name('auth.register');

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::delete('/logout', 'Auth\LoginController@logout')->name('auth.logout');
    Route::resource('users', 'UsersController');
    Route::resource('permissions', 'PermissionsController');
    Route::resource('roles', 'RolesController');
    Route::resource('accounts', 'AccountsController');
    Route::resource('locations', 'LocationsController');
    Route::resource('items', 'ItemsController');
    Route::resource('criterias', 'CriteriaController');
    Route::resource('projects', 'ProjectsController');
    Route::resource('forecast-items', 'ForecastItemsController');
});


