<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}" >
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif



                <div class="flex-center position-ref full-height">
                    <div class="content">
                        <div class="title m-b-md">
                            Launchpad Test
                        </div>
                        <div class="links">
                        <a href="{{ config('app.url')}}/contacts/create">Add Contact</a>
                        <a href="{{ config('app.url')}}/contacts">View Contacts</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
