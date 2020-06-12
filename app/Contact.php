<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    // This is the structure for Klaviyo's contacts
    protected $fillable = [
        'first_name',
        'email',
        'phone',
        'user_id',
     ];

    //CSV Data importer
     public static function insertData($data){

        $value=DB::table('contacts')->where('email', $data['email'])->get();
        if($value->count() == 0){
           DB::table('contacts')->insert($data);
        }
     }


}
