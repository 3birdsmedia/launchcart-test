<?php

namespace App\Http\Controllers;

use App\Contact;
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
        // Need to abstract these to the construct
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
        Log::debug('Trying to edit');
        Log::debug($id);


        $contact = \App\Contact::find($id);
        Log::debug($contact->email);

        // show the edit form and pass the nerd
        return view('contacts/edit', ['contact' => $contact]);
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
        Log::debug('Trying to update');
        Log::debug($id);

        $request->validate([
            'first_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'user_id'=> 'required'
        ]);

        $contact = \App\Contact::find($id);
        $contact->first_name =  $request->get('first_name');
        $contact->email = $request->get('email');
        $contact->phone = $request->get('phone');
        //This will to transfer contacts to other users in the future
        $contact->user_id = $request->get('user_id');
        $contact->save();

        return redirect('/contacts')->with('success', 'Contact updated!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Need to abstract these to the construct
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

    /**
     * Upload csv files to the database.
     *
     * @param  request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request){
        Log::debug('--Upload ');

        if ($request->input('submit') != null ){

            $file = $request->file('file');

            // File Details
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $tempPath = $file->getRealPath();
            $fileSize = $file->getSize();
            $mimeType = $file->getMimeType();

            // Need to abstract these to the construct
            $private_key = env('KLAVIYO_PIVRATE_KEY');
            $list_id = auth()->user()->list_id;



            // Valid File Extensions
            $valid_extension = array("csv");

            // 2MB in Bytes
            $maxFileSize = 2097152;

            // Check file extension
            if(in_array(strtolower($extension),$valid_extension)){

              // Check file size
              if($fileSize <= $maxFileSize){

                // File upload location
                $location = 'uploads/'.auth()->user()->id;

                // Upload file
                $file->move($location,$filename);

                // Import CSV to Database
                $filepath = public_path($location."/".$filename);

                // Reading file
                $file = fopen($filepath,"r");

                $importData_arr = array();
                $i = 0;

                while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                   $num = count($filedata );

                   // Skip first row (Remove below comment if you want to skip the first row)
                   /*if($i == 0){
                      $i++;
                      continue;
                   }*/
                   for ($c=0; $c < $num; $c++) {
                      $importData_arr[$i][] = $filedata [$c];
                   }
                   $i++;
                }
                fclose($file);
                Log::debug($importData_arr);
                // Insert to MySQL database
                foreach($importData_arr as $importData){

                Log::debug($importData_arr);
                //clean that phone
                $phone = preg_replace("/[^0-9]/", "", $importData[2]);

                  $insertData = array(
                     "first_name"=>$importData[0],
                     "email"=>$importData[1],
                     "phone"=>$phone,
                     "user_id"=>auth()->user()->id
                    );

                    $response = Http::post('https://a.klaviyo.com/api/v2/list/'.$list_id.'/members', [
                        'api_key' => env('KLAVIYO_PIVRATE_KEY'),
                        'profiles' => [
                            'email' => $importData[1],
                            'phone' => $phone,
                            'first_name' => $importData[0],
                            'user_id' => auth()->user()->id
                        ]
                    ]);

                    Log::debug($response);

                  Contact::insertData($insertData);
                }

                $request->session()->flash('message','Contacts updloaded!');
              }else{
                $request->session()->flash('message','File too large. File must be less than 2MB.');
              }

            }else{
               $request->session()->flash('message','Invalid File Extension.');
            }

          }

          // Redirect to index
        return redirect('/contacts')->with('success', 'Contacts updloaded!');










    }


}
