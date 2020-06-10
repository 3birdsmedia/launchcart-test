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
            <h1>Create a new contact</h1>
                <form method="POST" action="{{ config('app.url')}}/contacts">
                    {{ csrf_field() }}
                    <h2> Enter your contact's details</h2>
                    <div class="form-input">
                        <label>Name</label> <input type="text" name="first_name">
                    </div>

                    <div class="form-input">
                        <label>email</label> <input type="email" name="email">
                    </div>

                    <div class="form-input">
                        <label>Phone</label> <input type="number" name="phone" maxlength="10">
                    </div>

                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                    <button type="submit">Submit</button>
                </form>
            </div>
        </div>
    </body>
    </html>
