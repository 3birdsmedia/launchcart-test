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
            <div class="content">
            <h2>Register</h2>
              <form method="POST" action="{{ config('app.url')}}/register">
                  {{ csrf_field() }}
                  <div class="form-group">
                      <label for="name">Name:</label>
                      <input type="text" class="form-control" id="name" name="name">
                  </div>

                  <div class="form-group">
                      <label for="email">Email:</label>
                      <input type="email" class="form-control" id="email" name="email">
                  </div>

                  <div class="form-group">
                      <label for="password">Password:</label>
                      <input type="password" class="form-control" id="password" name="password">
                  </div>

                  <div class="form-group">
                      <button style="cursor:pointer" type="submit" class="btn btn-primary">Submit</button>
                  </div>
                  {{-- @include('partials.formerrors') --}}
              </form>

            </div>
        </div>
    </body>
    </html>
