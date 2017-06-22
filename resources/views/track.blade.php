@extends('layouts.app')

@section('content')
        <div class="container-fluid" id="tracks">
            <div class="row">
                <div class="col-lg-10 col-lg-offset-1">
                    <div class="panel panel">
                        <div class="panel-heading">
                            <h3>{{$track->name}}</h3>
                        </div>

                        <div class="panel-body">
                            <img src="{{$track->images[0]->url}}">
                            @foreach($track->tracks->items as $item)
                            <div class="group playlist-group">
                                <p class="track-name">{{ $item->track->name }}</p>
                                @foreach($item->track->artists as $artist)
                                <p class="artists">{{ $artist->name }}</p>
                                @endforeach
                                @if($item->track->preview_url)
                                <audio src="{{ $item->track->preview_url }}" controls>
                                    Your stupid browser doesn't support HTML 5 audio.
                                </audio>
                                <button class="play btn"><i class="fa fa-play" aria-hidden="true"></i></button>
                                <button class="pause btn"><i class="fa fa-pause" aria-hidden="true"></i></button>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
