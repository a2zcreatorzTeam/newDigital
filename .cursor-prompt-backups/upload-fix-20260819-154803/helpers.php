<?php

use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;



if (!function_exists('format_price')) {
    /**
     * Format a number into a standard currency format.
     *
     * @param float $amount
     * @return string
     */
    function format_price(float $amount): string
    {
        return '$' . number_format($amount, 2);
    }
}

if (!function_exists('user_initials')) {
    /**
     * Get user initials from a name.
     */
    function user_initials(string $name): string
    {
        $words = explode(' ', $name);
        $initials = '';
        foreach ($words as $w) {
            $initials .= $w[0] ?? '';
        }
        return strtoupper($initials);
    }
}


if (!function_exists('generateCustomerVoucher')) {
    /**
     * Get user initials from a name.
     */
    function generateCustomerVoucher($order)
    {


        $prefix = "01520";
        $currentDate = Carbon::now();
        $billingMonth = $currentDate->format('ym');

        $sequence = str_pad($order->id, 7, '0', STR_PAD_LEFT);

        $consumerNumber = $prefix . $billingMonth . $sequence;
        // DB me insert karna
        return Voucher::create([
            'consumer_number' => $consumerNumber,
            'customer_name' => $order->customer_name,
            'amount_within_due_date' => $order->total_amount,
            'amount_after_due_date' => $order->total_amount + 150, // Late fee agar applicable ho
            'due_date' => Carbon::now()->addDays(10)->format('Y-m-d'),
            'billing_month' => $billingMonth,
            'email' => $order->customer_email,
            'contact_number' => $order->customer_phone,
            'status' => 'U' // Unpaid [cite: 85]
        ]);
    }
}

if (!function_exists('uploadFile')) {


    function uploadFile(Request $request, string $field, string $folder = 'uploads/policy_documents')
    {
        if (!$request->hasFile($field)) {
            return null;
        }
        $file = $request->file($field);
        $fileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
        if (!is_dir(public_path($folder))) {
            mkdir(public_path($folder), 0755, true);
        }
        $file->move(public_path($folder), $fileName);
        return $fileName;
    }
}
