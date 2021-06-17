<?php

use App\Http\Livewire\SendMessage;
use App\Http\Livewire\VerifyPhoneNumber;
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
});
Route::get('/verify', VerifyPhoneNumber::class)->name('verify');

Route::group(['middleware' => 'auth:sanctum'], static function () {
    Route::get('/dashboard', SendMessage::class)->name('dashboard');
});

Route::get('/callback', SendMessage::class)->middleware('twilio.validate')->name('callback');
