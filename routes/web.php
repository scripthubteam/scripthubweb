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

// PagesControllers
Route::view('/', 'pages.index')->name('root');

// DiscordUsersControllers
Route::resource('/discord', 'DiscordUsersController');

// Users System
Auth::routes(['verify' => true]);

// ScriptHubUsersController
Route::get('/home', 'ScriptHubUsersController@index')->name('home');
Route::resource('/users', 'ScriptHubUsersController')->only([
    'show'
]);

// BotsControllers
Route::resource('/user/bots', 'BotsController');
