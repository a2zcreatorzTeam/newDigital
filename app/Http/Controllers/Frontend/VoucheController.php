<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Support\Facades\Auth;

class VoucheController extends Controller
{
    public function voucher($id)
    {
        session()->forget('policy_id');

        try {
            $orderId = decrypt($id);
        } catch (\Throwable) {
            abort(404);
        }

        $voucher = Voucher::with('policy')->where('order_id', $orderId)->firstOrFail();

        $user = Auth::user();
        $isAdmin = $user && (int) $user->user_type === 2;
        $isOwner = $user && $voucher->policy && (int) $voucher->policy->user_id === (int) $user->id;

        if (!$isAdmin && !$isOwner) {
            abort(404);
        }

        return view('frontend.voucher', ['voucher' => $voucher]);
    }
}
