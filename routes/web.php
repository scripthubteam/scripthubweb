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
Route::get('login', 'PagesController@login')->name('login');

// DiscordUsersControllers
Route::get('discord/users', 'DiscordUsersController@index');
Route::get('discord/users/{id}', 'DiscordUsersController@show');

// ScriptHubUsersControllers
