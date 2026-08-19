<?php

namespace App\Support;

use App\Models\GoldenEndowmentPlanTir;
use App\Models\PlatinumPlusTIR;
use App\Models\PlanAgeMaturity;

class PremiumCalculator
{
    /**
     * Server-side premium calculation (same formula as PolicyCalculatorController).
     *
     * @return array{premium_paid:float,adb_rider:float,tir_rider:float,policy_data:PlanAgeMaturity}|null
     */
    public static function calculate(
        mixed $sumAssured,
        mixed $paymentMode,
        mixed $term,
        mixed $policyProductId,
        mixed $age,
        mixed $adbRider = 'No',
        mixed $tirRider = 'No'
    ): ?array {
        $policyData = PlanAgeMaturity::with('product')
            ->where('plan_id', $policyProductId)
            ->where('age', $age)
            ->where('term', $term)
            ->first();

        if (!$policyData || $policyData->rate === null || $sumAssured === null || $sumAssured === '') {
            return null;
        }

        $adbRiderAmount = 0;
        $tirRiderAmount = 0;
        if ((int) $policyProductId === 2) {
            if ($tirRider === 'Yes') {
                $goldenEndowment = GoldenEndowmentPlanTir::where('age', $age)->first();
                if ($goldenEndowment) {
                    $tirRiderAmount = ($sumAssured / 1000) * (float) $goldenEndowment->tir_value;
                }
            }
            if ($adbRider === 'Yes') {
                $adbRiderAmount = ($sumAssured / 1000) * 2.78;
            }
        } else {
            if ($tirRider === 'Yes') {
                $goldenEndowment = PlatinumPlusTIR::where('age', $age)->first();
                if ($goldenEndowment) {
                    $tirRiderAmount = ($sumAssured / 1000) * (float) $goldenEndowment->tir_value;
                }
            }
            if ($adbRider === 'Yes') {
                $adbRiderAmount = ($sumAssured / 1000) * 2.5;
            }
        }

        $calAmount = ($sumAssured * $policyData->rate) / 1000 + 100;
        $rebate = $sumAssured * (0.5 / 1000);
        $amount = $calAmount - $rebate;

        $premiumPaid = match ($paymentMode) {
            'Yearly' => $amount * 1,
            'Half Yearly' => $amount * 0.52,
            'Quarterly' => $amount * 0.27,
            default => $amount * 0.09,
        };

        return [
            'premium_paid' => $premiumPaid,
            'adb_rider' => $adbRiderAmount,
            'tir_rider' => $tirRiderAmount,
            'policy_data' => $policyData,
        ];
    }
}
