<?php

namespace App;

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


}
