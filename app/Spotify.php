<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SpotifyWebAPI\SpotifyWebAPI;

class Spotify extends Model
{
    static function make($session){
            try {
                $api = new SpotifyWebAPI();
                $api->setAccessToken($session);

                return $api;
            } catch (\Exception $e) {
                if ($e->getCode() == 401) {
                    return redirect('spotify/refresh');
                } else {
                    return dd($e);
                }
            }
    }
}
