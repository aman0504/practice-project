<?php

use App\Http\Controllers\ProfileController;
use App\Http\Livewire\ChatApp;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';



 Route::middleware(['auth','verified'])->group(function(){

        Route::get('/dashboard',function(){ return view('dashboard');})->name('dashboard');
   // ...chat
        Route::get('/chat', ChatApp::class)->name('chat');






   // ...availablity time slots*****
        // making 2 tables 1. cleaner_availabity_days  2. cleaner_availability_day_time , use realtion
        // in User model make a function for define days, status, and default start/end time

    Route::get('/availability',function(){ return view('availability');})->name('availabilty');

 });
