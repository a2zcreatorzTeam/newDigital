<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'consumer_number',
        'customer_name',
        'amount_within_due_date',
        'amount_after_due_date',
        'due_date',
        'billing_month',
        'email',
        'contact_number',
        'status',
        'tran_auth_id',
        'date_paid',
        'bank_mnemonic',
        'order_id',
        'policy_id',
        'user_ip_address',
        'payment_ip_address'
    ];


    public static function formatTwoKuickpayAmount($amount, $includeSign = true)
    {
        // Amount ko 100 se multiply karke paisa me convert kiya aur decimals khatam kiye
        $minorUnits = round($amount * 100);

        // Total 13 digits tak zeros pad karein (kyunki + sign mila kar 14 banenge) [cite: 91]
        $padded = str_pad($minorUnits, 13, '0', STR_PAD_LEFT);

        return $includeSign ? '+' . $padded : '0' . $padded;
    }
    public static function formatKuickpayAmount($amount, $includeSign = false)
    {
        // Convert to minor units (paisas)
        $minorUnits = round($amount * 100);
        // Ensure exactly 12 digits, left padded with zeros
        $padded = str_pad($minorUnits, 12, '0', STR_PAD_LEFT);

        return $includeSign ? '+' . $padded : $padded;
    }

    /**
     * Amount Kuickpay must collect: within due date, or after-due amount once the due date has passed.
     */
    public function expectedPaymentAmount(): float
    {
        $dueDate = $this->due_date
            ? \Carbon\Carbon::parse($this->due_date)->endOfDay()
            : null;

        if ($dueDate && now()->gt($dueDate)) {
            return (float) $this->amount_after_due_date;
        }

        return (float) $this->amount_within_due_date;
    }

    /**
     * Normalize Kuickpay transaction_amount (rupees, or 12-digit minor units) to rupees.
     */
    public static function normalizeTransactionAmount(mixed $amount): ?float
    {
        if ($amount === null || $amount === '') {
            return null;
        }

        $raw = trim((string) $amount);
        if (preg_match('/^\d{12,14}$/', $raw)) {
            return round(((int) $raw) / 100, 2);
        }

        if (!is_numeric($raw)) {
            return null;
        }

        return round((float) $raw, 2);
    }

    public function paymentAmountMatches(mixed $amountPaid): bool
    {
        $paid = self::normalizeTransactionAmount($amountPaid);
        if ($paid === null) {
            return false;
        }

        return abs($paid - $this->expectedPaymentAmount()) < 0.01;
    }

    public function policy()
    {
        return $this->belongsTo(UserPolicyData::class, 'order_id', 'id');
    }
}
