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
                <a class="btn logout" href="{{ config('app.url')}}/logout">Logout</a>
                <div class="csv-import">
                <p>-OR-</p>
                <!-- Form -->
                <!-- Message -->
                @if(session()->has('message'))
                    <p >{{ session()->get('message') }}</p>
                @else
                    <p class="info"> Please be gentle, right now I can only handle <strong>2mb</strong> files, with 3 columns (First Name, Email and Phone) and no headers</p>
                @endif
                <form method='post' action='{{ config('app.url')}}/upload' enctype='multipart/form-data' >
                    {{ csrf_field() }}
                    {{ method_field('POST') }}
                    <input type='file' name='file' class="btn outline" >
                    <input type='submit' name='submit' class="btn import" value='🤯 MASS IMPORT!'>
                </form>
                </div>
                <table cellpadding="10" align="center">
                    <thead>
                        <td>First Name</td>
                        <td>Email</td>
                        <td>Phone</td>
                        <td>Edit</td>
                        <td>Delete</td>
                    </thead>
                    <tbody>
                        @foreach ($allContacts as $contact)
                            <tr>
                                <td>{{ $contact->first_name }}</td>
                                <td class="inner-table">{{ $contact->email }}</td>
                                <td class="inner-table">{{ $contact->phone }}</td>
                                <td class="inner-table">
                                    <a class="btn" href="{{ URL::to('contacts/' . $contact->id . '/edit') }}">&#9998;</a></td>
                                <td class="inner-table">
                                    <form id="delete_entry" name="delete_entry" method="POST" action="{{ URL::route('contacts.destroy', $contact->id) }}" >
                                        {{ method_field('DELETE') }}
                                        {{ csrf_field() }}
                                    <button type="submit" name="delete" class="btn logout">&#10006;</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </body>
    </html>
