<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\PlanAgeMaturity;
use Carbon\Carbon;
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
        // dump($policy_product_id);
        $policy_data = PlanAgeMaturity::with('product')->where('plan_id', $policy_product_id)->where('age',$age)->where('term',$term)->first();
        // dump($policy_data);    



        // here calculations 

        // cal_amount
        $cal_amount = ($sum_assured * $policy_data->rate) / 1000 + 100;
        // $rebate=$sum_assured * (0.5/1000);
        $rebate = $sum_assured * (0.5 / 1000);
        $amount = $cal_amount - $rebate;

        $premium_paid = null;
        if ($payment_mode == 'Yearly') {
            $premium_paid = $amount * 1;
        } elseif ($payment_mode == 'Half Yearly') {
            $premium_paid = $amount * 0.52;
        } elseif ($payment_mode == 'Quarterly') {
            $premium_paid = $amount * 0.27;
        } else {
            $premium_paid = $amount * 0.09;
        }


        return view(
            'frontend.policy_calculator',
            [
                'policy_data' => $policy_data,
                'gender' => $gender,
                'age' => $age,
                'sum_assured' => $sum_assured,
                'payment_mode' => $payment_mode,
                'term' => $term,
                'premium_paid' => $premium_paid,
            ]
        );
    }
}
