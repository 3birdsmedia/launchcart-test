<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SessionsController extends Controller
{
    //
    public function create()
    {
        Log::debug(bcrypt('Zeeb7777'));
        return view('login.create');
    }

    public function store()
    {
        if (auth()->attempt(request(['email', 'password'])) == false) {
            return back()->withErrors([
                'message' => 'The email or password is incorrect, please try again'
            ]);
        }

        return redirect()->to('/contacts');
    }

    public function destroy()
    {
        auth()->logout();

        return redirect()->to('/contacts');
    }
}
