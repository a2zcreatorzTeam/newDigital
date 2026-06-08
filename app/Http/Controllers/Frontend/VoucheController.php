<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Carbon\Carbon;

class VoucheController extends Controller
{


    public function voucher($id)
    {
        $voucher=Voucher::where('order_id',$id)->first();
        return view('frontend.voucher',['voucher'=>$voucher]);
    }
}
