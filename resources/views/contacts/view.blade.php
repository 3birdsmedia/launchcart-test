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
                <h1>Here are your contacts!</h1>
                <a class="btn" href="{{ config('app.url')}}/contacts/create">Add More</a>
                <table>
                    <thead>
                        <td>First Name</td>
                        <td>Email</td>
                        <td>Phone</td>
                    </thead>
                    <tbody>
                        @foreach ($allContacts as $contact)
                            <tr>
                                <td>{{ $contact->first_name }}</td>
                                <td class="inner-table">{{ $contact->email }}</td>
                                <td class="inner-table">{{ $contact->phone }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </body>
    </html>
