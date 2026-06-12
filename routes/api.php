<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\KuickpayController;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('v1')->group(function () {
    
    Route::post('/BillInquiry', [KuickpayController::class, 'billInquiry']);
    Route::post('/BillPayment', [KuickpayController::class, 'billPayment']);
    
});









