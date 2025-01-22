<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\RFIDController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('index');
// });

// Route::get('/layout_page/dashboard_page.blade', [RFIDController::class, 'home'])->name('home');
Route::get('/login', fn () => redirect('admin'))->name('login');

Route::get('/borrow', [RFIDController::class, 'borrow']);

Route::get('/', fn () => redirect('home'))->name('home');

Route::get('/home', [BookController::class, 'home']);

Route::resource('book', BookController::class);
