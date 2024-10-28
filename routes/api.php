<?php

use App\Http\Controllers\RFIDController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/rfidattendance/getdata', [RFIDController::class, 'receiveRFID']);

Route::post('/rfid_borrow', [RFIDController::class, 'borrow']);
