@extends('layouts.app')

@section('content')
    <div class="container-fluid" id="home">
        <div class="row">
            <div class="col-md-3 col-lg-2">
                <div class="panel panel">
                    <div class="panel-heading">
                        <h3>Anbieter</h3>
                    </div>

                    <div class="panel-body">
                        <a href="{{ url('/spotify/login') }}" class="btn btn-spotify">Spotify</a>
                        <a href="{{ url('/youtube/login') }}" class="btn btn-youtube">Youtube</a>
                    </div>
                </div>
            </div>
            <div class="col-md-9 col-lg-10">
                <div class="panel panel">
                    <div class="panel-heading">
                        <h3>Playlists</h3>
                    </div>

                    <div class="panel-body">
                        @if($spotifyplaylists)
                        @foreach($spotifyplaylists->items as $playlist)

                        <div class="group playlist-group">
                            <div class="avatar avatar-spotify">
                                s
                            </div>
                            <div class="playlist-content">
                                <div class="playlist-titel">
                                    <p>{{$playlist->name}}</p>
                                </div>
                                <div class="playlist-info">
                                    <p>Playlist <a href="{{$playlist->external_urls->spotify}}" class="spotify">Spotify</a></p>
                                    <p><a href="{{ url('playlists/convert/spotify/youtube', [$playlist->owner->id, $playlist->id]) }}" class="spotify">TEST</a></p>
                                </div>
                            </div>
                            <div class="toolbar">
                                <div class="tool tool-convert">
                                    <button class="btn"><span class="glyphicon glyphicon-import"></span></button>
                                </div>
                                <div class="tool tool-context">
                                    <button class="btn"><a href="{{ url('playlists', [$playlist->owner->id, $playlist->id]) }}"><span class="glyphicon glyphicon-th"></span></a></button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                        @if($youtubeplaylists)
                        @foreach($youtubeplaylists as $playlist)
                        <div class="group playlist-group">
                            <div class="avatar avatar-youtube">
                                y
                            </div>
                            <div class="playlist-content">
                                <div class="playlist-titel">
                                    <p>{{ $playlist->snippet->title }}</p>
                                </div>
                                <div class="playlist-info">
                                    <p>Playlist <a href="#" class="youtube">Youtube</a></p>
                                </div>
                            </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
            <div class="playlist-overlay">

            </div>
        </div>
    </div>

@endsection
