@extends('layouts.app')

@section('content')

    <div class="container-fluid" id="tracks">
        <div class="row">
            <div class="col-md-9 col-lg-10 col-md-offset-3 col-lg-offset-2">
                <div class="panel panel">
                    <div class="panel-heading">
                        <h3>{{$track->name}}</h3>
                    </div>

                    <div class="panel-body">
                        <!-- {{ dd($track) }} -->
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
