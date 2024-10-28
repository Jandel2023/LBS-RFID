<?php

use App\Http\Controllers\RFIDController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/login', fn () => redirect('admin'))->name('login');

Route::get('/borrow/{id}', [RFIDController::class, 'borrow']);
