@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @foreach($spotifyplaylists->items as $playlist)
                <div class="panel panel">
                    <div class="panel-heading">{{$playlist->name}}</div>

                    <div class="panel-body">
                        You are logged in!
                    </div>
                </div>
                    @endforeach
            </div>
        </div>
    </div>
@endsection
