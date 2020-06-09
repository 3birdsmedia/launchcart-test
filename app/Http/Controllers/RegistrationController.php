<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\User;

class RegistrationController extends Controller
{
    //
    public function create()
    {
        return view('registration.create');
    }

    public function store(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        Log::debug(request());
        Log::debug('-------');
        Log::debug($request);

        //Create a list on Klaviyo to store the contacts
       //$request = request(['name']);
        $list_name = $request['name'];
        Log::debug($request);
        Log::debug($list_name);

        //withHeaders([            'X-CSRFToken' => 's0uzCqKBls0uUnHiFv5SHhL0ZH7wkWSf'        ])->
        $response = Http::post('https://a.klaviyo.com/api/v2/lists', [
            'api_key' => env('KLAVIYO_PIVRATE_KEY'),
            'list_name' => $list_name.'\'s List'
        ]);

        Log::debug(request());
        Log::debug($response);
        Log::debug($response['list_id']);
        $request['list_id'] = $response['list_id'];

        Log::debug($request);
        //need to add validation for duplicate emails
        $user = User::create(request(['name', 'email', 'password', 'list_id']));

        auth()->login($user);

        return redirect()->to('/contacts');
    }
}
