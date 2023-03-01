<?php

use App\Http\Controllers\availabilityController;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\PracticeReceiverController;

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



Route::get('/availability',[availabilityController::class,'index'])->name('availability');

Route::get('/enableSelectedDates',[availabilityController::class,'enableSelectedDates'])->name('enableSelectedDates');

Route::post('/getDay',[availabilityController::class,'getDay'])->name('getdate');


Route::get('/gmap',[PracticeController::class,'index1'])->name('index1.goog');


// for encryption decryption
Route::post('/encyptData',[PracticeController::class,'create'])->name('create');

Route::get('/receiveEncyptDecypt',[PracticeReceiverController::class,'index'])->name('indexPage');

Route::get('/decryptData/{details}',[PracticeReceiverController::class,'getEncyptData'])->name('getEncyptData');

// Increment Decrement function

Route::get('/inc',[PracticeController::class,'incDecr'])->name('incrementDecrement');
