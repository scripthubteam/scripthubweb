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
Route::get('/', 'PagesController@index')->name('home');

// DiscordUsersControllers
Route::resource('discord', 'DiscordUsersController');

// ScriptHubUsersControllers
Route::get('login', 'ScriptHubUsersController@index')->name('login');
Route::get('register', 'ScriptHubUsersController@create')->name('users.register');
Route::post('register', 'ScriptHubUsersController@store');
Route::get('user/{user}', 'ScriptHubUsersController@show')->where('id', '[0-9]+')->name('users.user');
Route::patch('user/{user}/edit', 'ScriptHubUsersController@update')->where('id', '[0-9]+')->name('users.edit');
