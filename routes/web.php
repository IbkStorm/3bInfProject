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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('auth/{provider}', 'Auth\RegisterController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\RegisterController@handleProviderCallback');

Route::get('soundcloud/login', 'SoundCloudController@SoundcloudLogin');
Route::get('soundcloud/callback', 'SoundCloudController@SoundcloudLogin');

Route::get('spotify/login', 'SpotifyController@SpotifyLogin');
Route::get('spotify/callback', 'SpotifyController@SpotifyCallback');

Route::get('playlist', 'PlaylistController@index');