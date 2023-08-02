<?php

use App\Http\Controllers\availabilityController;
use App\Http\Controllers\BankInfoController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\GoogelMapController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\PracticeReceiverController;
use App\Http\Controllers\UserAlpineController;
use App\Http\Livewire\ChatApp;
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

//stripe  customer charge api's (charge using card)........
Route::get('/billing',[PaymentController::class,'show'])->name('payment.show');
Route::post('/create-account', [PaymentController::class, 'getCardDetails'])->name('getCardDetails');
Route::get('/update-card-details/{id}', [PaymentController::class, 'cardEdit'])->name('cardEdit');
Route::post('/updateCard-details/{id}', [PaymentController::class, 'updateCard'])->name('updateCard');
Route::delete('/delete-card/{id}', [PaymentController::class, 'delete'])->name('deleteCard');
Route::get('/refundCharges-details/{id}', [PaymentController::class, 'refundCharges'])->name('refundCharges');


//stripe connect account api (connect bank account for payment).......
Route::get('/index',[BankInfoController::class, 'index'])->name('bankinfo.index');
Route::get('/account-create',[BankInfoController::class, 'connectedAccountCreate'])->name('bankinfo.accountcreate');
Route::get('/account/bankInfoError',[BankInfoController::class, 'bankInfoError'])->name('bankinfo.bankInfoError');
Route::get('/account/bankInfoSuccess',[BankInfoController::class, 'bankInfoSuccess'])->name('bankinfo.bankInfoSuccess');
Route::post('/account/saveBankDetails',[BankInfoController::class, 'saveBankDetails'])->name('bankinfo.saveBankDetails');
Route::get('/account/connectedAccountDelete',[BankInfoController::class, 'connectedAccountDelete'])->name('bankinfo.connectedAccountDelete');
Route::post('/account/connectedAccountUpdate',[BankInfoController::class, 'connectedAccountUpdate'])->name('bankinfo.connectedAccountUpdate');

// stripe admin transfer(payout) to worker(in connect account)
Route::get('/account/payByAdminToWorker',[PaymentController::class, 'payByAdminToWorker'])->name('payByAdminToWorker');

//alpine js with laravel......

Route::get('/alpine/index', [UserAlpineController::class, 'index'])->name('alpine.index');


//pdf
Route::get('/pdf',[ClientController::class, 'pdfIndex'])->name('pdf');

//real time chat application

Route::get('/chatapp', ChatApp::class)->name('chatapp');
