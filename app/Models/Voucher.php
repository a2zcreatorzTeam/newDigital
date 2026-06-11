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

    public static function formatKuickpayAmount($amount)
    {
        // Convert to minor units (paisas)
        $minorUnits = round($amount * 100);
        // Ensure exactly 12 digits, left padded with zeros
        return str_pad($minorUnits, 12, '0', STR_PAD_LEFT);
    }

    public function policy()
    {
        return $this->belongsTo(UserPolicyData::class, 'order_id', 'id');
    }
}
