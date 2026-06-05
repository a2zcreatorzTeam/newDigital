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





// for testing 
// https://newdigital.test/api/v1/BillInquiry
// {
//     "consumer_number":"0152026060000023",
// “bank_mnemonic”:“KPY”,
// “reserved”: “something, special, string, can, be, send, into, it.” 
// }



// https://newdigital.test/api/v1/BillPayment



// {
//   "consumer_number": "0152026060000021",
//   "tran_auth_id": "99887766",
//   "transaction_amount": "0000000115000",
//   "tran_date": "20260605",
//   "tran_time": "173000",
//   "bank mnemonic": "KPY",
//   "reserved": "any_optional_string"
// }



