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


    public static function formatKuickpayAmount($amount, $includeSign = true)
    {
        // Amount ko 100 se multiply karke paisa me convert kiya aur decimals khatam kiye
        $minorUnits = round($amount * 100);

        // Total 13 digits tak zeros pad karein (kyunki + sign mila kar 14 banenge) [cite: 91]
        $padded = str_pad($minorUnits, 13, '0', STR_PAD_LEFT);

        return $includeSign ? '+' . $padded : '0' . $padded;
    }

    public function policy()
    {
        return $this->belongsTo(UserPolicyData::class, 'order_id', 'id');
    }
}
