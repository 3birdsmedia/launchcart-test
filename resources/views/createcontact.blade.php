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
                <form method="POST" action="{{ config('app.url')}}/contacts">
                    <h1> Enter your contact's details</h1>
                    <div class="form-input">
                        <label>Name</label> <input type="text" name="first_name">
                    </div>

                    <div class="form-input">
                        <label>email</label> <input type="email" name="email">
                    </div>

                    <div class="form-input">
                        <label>Phone</label> <input type="number" name="phone">
                    </div>

                    <button type="submit">Submit</button>
                </form>
            </div>
        </div>
    </body>
    </html>