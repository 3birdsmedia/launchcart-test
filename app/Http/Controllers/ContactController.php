<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::debug("User ID = ". auth()->user()->id);
        Log::debug("User List ID = ". auth()->user()->list_id);
        //Log::debug("Contact Index");
        $contacts = \App\Contact::where('user_id', auth()->user()->id)->get();

        //--------------------------------------------------------------------------------------
        //
        //This is only to delete/clean up lists, since postman is not working for that purpose

        // $delete_response = Http::delete('https://a.klaviyo.com/api/v2/list/SJgtH5', [
        //     'api_key' => env('KLAVIYO_PIVRATE_KEY'),
        // ]);
        // Log::debug($delete_response);
        //
        //--------------------------------------------------------------------------------------



        //Log::debug($contacts);
        return view('contacts/view', ['allContacts' => $contacts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        //Log::debug("Contact Create");
        // Create a contact
        return view('contacts/create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $private_key = env('KLAVIYO_PIVRATE_KEY');
        $list_id = auth()->user()->list_id;

        Log::debug("User ID in store= ". auth()->user()->id);
        Log::debug("User List ID in store = ". auth()->user()->list_id);

        $this->validate(request(), [
            'first_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'user_id'=> 'required'
        ]);

        Log::debug("Contact Store after validation");
        \App\Contact::create(request([
            'first_name',
            'email',
            'phone',
            'user_id'
        ]));


        // Log::debug('first_name '.$request->first_name);
        // Log::debug('EMAIL '.$request->email);
        // Log::debug('phone '.$request->phone);
        // Log::debug('user_id '.$request->user_id);

        Log::debug('URL https://a.klaviyo.com/api/v2/list/'.$list_id.'/members');

        $response = Http::post('https://a.klaviyo.com/api/v2/list/'.$list_id.'/members', [
            'api_key' => env('KLAVIYO_PIVRATE_KEY'),
            'profiles' => [
                'email' => $request->email,
                'phone' => $request->phone,
                'first_name' => $request->first_name,
                'user_id' => $request->user_id
            ]
            ]);
        // $responseGET = Http::get('https://a.klaviyo.com/api/v2/group/'.$list_id.'/members/all', [
        //     'api_key' => env('KLAVIYO_PIVRATE_KEY'),
        //     ]);
        //Log::debug($responseGET);

        Log::debug($private_key);
        Log::debug($response);
        return redirect('/contacts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $private_key = env('KLAVIYO_PIVRATE_KEY');
        $list_id = auth()->user()->list_id;
        $contacts = \App\Contact::where('user_id', auth()->user()->id)->get();
        //
        Log::debug('Trying to destroy');
        Log::debug($id);


        $contact = \App\Contact::find($id);
        Log::debug($contact->email);
        $contact->delete();


        $response = Http::delete('https://a.klaviyo.com/api/v2/list/'.$list_id.'/members', [
            'api_key' => env('KLAVIYO_PIVRATE_KEY'),
            'emails' => $contact->email
        ]);
        Log::debug($response);

        return redirect('/contacts');
    }
}
