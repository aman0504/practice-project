<?php

use App\Http\Controllers\availabilityController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\GoogelMapController;
use App\Http\Controllers\PaymentController;
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

//country code with phone number


Route::get('/countrycode',[PracticeController::class,'countrycodeIndex'])->name('countrycode');

Route::get('/map', [GoogelMapController::class, 'index'])->name('map.googleMap');

// save image using spatie package
Route::get('/create',[ClientController::class, 'create'])->name('spatieimage.create');
Route::post('/save',[ClientController::class, 'store'])->name('spatieimage.store');

// multi select2   ...its working
Route::get('/selectIndex',[availabilityController::class,'selectIndex'])->name('selectMultipleIndex');
Route::post('/selectMultiple',[availabilityController::class,'selectMultiple'])->name('selectMultiple');

//stripe
Route::get('/billing',[PaymentController::class,'show'])->name('payment.show');
Route::post('/create-account', [PaymentController::class, 'getCardDetails'])->name('getCardDetails');

Route::post('/account', [PaymentController::class, 'createAccount'])->name('stripe.create-account');
Route::post('/payment', [PaymentController::class, 'processPayment'])->name('payment.process');

