<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Support\PremiumCalculator;
use Illuminate\Http\Request;

class PolicyCalculatorController extends Controller
{
    public function policy_calculation(Request $request)
    {
        $sum_assured = $request->sum_assured;
        $payment_mode = $request->payment_mode;
        $term = $request->term;
        $gender = $request->gender;
        $policy_product_id = $request->policy_product_id;
        $age = $request->age_birth;

        $result = PremiumCalculator::calculate(
            $sum_assured,
            $payment_mode,
            $term,
            $policy_product_id,
            $age,
            $request->adb_rider,
            $request->tir_rider
        );

        if ($result === null) {
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unable to calculate premium for the selected age, term and product.',
                ], 422);
            }

            return back()->with('error', 'Unable to calculate premium for the selected age, term and product.');
        }

        return view(
            'frontend.policy_calculator',
            [
                'policy_data' => $result['policy_data'],
                'gender' => $gender,
                'age' => $age,
                'sum_assured' => $sum_assured,
                'payment_mode' => $payment_mode,
                'term' => $term,
                'premium_paid' => $result['premium_paid'],
                'adb_rider' => $result['adb_rider'],
                'tir_rider' => $result['tir_rider'],
            ]
        );
    }
}
