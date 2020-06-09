<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        //Log::debug("Contact Index");
        $contacts = \App\Contact::where('user_id', auth()->user()->id)->get();

        Log::debug($contacts);
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
    public function store()
    {

        Log::debug("User ID in store= ". auth()->user()->id);
        $this->validate(request(), [
            'first_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'user_id'=> 'required'
        ]);

        //Log::debug("Contact Store after validation");
        \App\Contact::create(request([
            'first_name',
            'email',
            'phone',
            'user_id'
        ]));

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
        //
    }
}
