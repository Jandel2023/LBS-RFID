<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\RFIDController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/rfidattendance/getdata', [RFIDController::class, 'receiveRFID']);

Route::get('/listOfBook/{id}', [RFIDController::class, 'listOfBooks']);

Route::post('/borrow', [RFIDController::class, 'borrow']);

Route::get('/searchBook/{id}', [BookController::class, 'show']);

Route::post('/return', [BookController::class, 'update']);
