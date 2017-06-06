<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Plister</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
                font-weight: bold;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            h3{
              margin: 0;
            }
            .btn{
              margin: 30px;
              text-transform: uppercase;
              font-weight: bold;
              font-size: 18px;
              padding: 10px 20px;
            }
        </style>
    </head>
    <body>
        <div class="position-ref full-height" id="particles-js">
          <canvas class="particles-js-canvas-el"></canvas>
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ url('/login') }}">Login</a>
                        <a href="{{ url('/register') }}">Register</a>
                    @endif
                </div>
            @endif

            <div class="content">
                <div class="title">
                    Convert your music playlists
                </div>

                <div class="links">
                    <h3>Stop wasting your time transferring playlists and music data between</br>streaming platforms. Let Plister do the job.</h3>
                </div>
                <a class="btn btn-info" href="{{ url('/register') }}">Start now</a>
            </div>
        </div>
      <!-- Scripts -->
      <script src="{{ asset('js/app.js') }}"></script>
      <script>
          /* particlesJS.load(@dom-id, @path-json, @callback (optional)); */
          particlesJS.load('particles-js', 'particles.json', function() {
          console.log('callback - particles.js config loaded');
          });
      </script>
    </body>
</html>
