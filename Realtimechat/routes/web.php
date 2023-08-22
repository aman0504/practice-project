<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Livewire\Category\Category;
use App\Http\Livewire\Category\Subcategory;
use App\Http\Livewire\ChatApp;
use Illuminate\Support\Facades\Route;
use App\Models\User;

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

require __DIR__ . '/auth.php';



Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        // fetch image from media table
        $user = User::find(auth()->user()->id);

        $image = $user->getMedia('image')->last();

        return view('dashboard', compact('image', 'user'));
    })->name('dashboard');
    Route::post('/profileImage', [ProfileController::class, 'profileImage'])->name('profileImage');

    // ...chat
    Route::get('/chat', ChatApp::class)->name('chat');


    // ...availablity time slots*****
    // making 2 tables 1. cleaner_availabity_days  2. cleaner_availability_day_time , use realtion
    // in User model make a function for define days, status, and default start/end time

    Route::get('/availability', function () {
        return view('availability');
    })->name('availabilty');



    // category, subcategory , products

    Route::get('/category',Category::class)->name('category');
    Route::get('/sub-category',Subcategory::class)->name('subcategory');

    Route::prefix('products')->group(function(){
        Route::controller(ProductController::class)->group(function(){
            Route::get('/index','index')->name('index');
        });
    });

});
