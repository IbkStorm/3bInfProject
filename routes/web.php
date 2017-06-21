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

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('auth/{provider}', 'Auth\RegisterController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\RegisterController@handleProviderCallback');

Route::middleware('auth')->group(function () {
    Route::get('soundcloud/login', 'SoundCloudController@SoundcloudLogin');
    Route::get('soundcloud/callback', 'SoundCloudController@SoundcloudLogin');

    Route::get('spotify/login', 'SpotifyController@SpotifyLogin');
    Route::get('spotify/callback', 'SpotifyController@SpotifyCallback');
    Route::get('spotify/refresh', 'SpotifyController@SpotifyRefresh');

    Route::get('/youtube/login', 'YoutubeController@YoutubeLogin');
    Route::get('/youtube/callback', 'YoutubeController@YoutubeCallback');

    Route::get('playlists', 'PlaylistController@index');
    Route::get('playlists/{userid}/{playlistid}', 'PlaylistController@show');

    Route::get('playlists/convert/spotify/youtube/{userid}/{playlistid}', 'PlaylistConverterController@SpotifyToYotubeConvert');
});