<?php
use App\Models\Voucher;
use Carbon\Carbon;


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
