<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google;

class YoutubeController extends Controller
{
    public function youtube()
    {
        $youtube = Google::make('youtube');
        $youtube->playlists->list(array('mine' => true, 'maxResults' => 25, 'onBehalfOfContentOwner' => '', 'onBehalfOfContentOwnerChannel' => ''));
        dd($youtube);

    }
}
