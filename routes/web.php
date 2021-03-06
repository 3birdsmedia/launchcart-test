<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');



// Need to look into the two different ways of usign these routes (noticed a difference with @ and without @ also :get, :post and :resource)

//Adding Registration/login functionality
Route::get('/register', 'RegistrationController@create')->name('register');
Route::post('register', 'RegistrationController@store');

Route::get('/login', 'SessionsController@create')->name('login');
Route::post('/login', 'SessionsController@store');
Route::get('/logout', 'SessionsController@destroy');

Route::group(['middleware' => 'auth'], function () {
    //Adding default CRUD controller
    Route::resource('/contacts', 'ContactController');

    // //Adding import Functionality
    Route::post('/upload', 'ContactController@upload');
});
