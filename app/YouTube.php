<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class YouTube extends Model
{
    static function make($session){
        try {
            $googleClient = Google::getClient();
            $googleClient->setAccessToken($session);
            $youtube = Google::make('Youtube');

            return $youtube;
        }catch (\Exception $e) {
            if ($e->getCode() == 401) {
                return redirect('spotify/refresh');
            } else {
                return dd($e);
            }
        }
    }
}
