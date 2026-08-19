<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CnicMobileLink extends Model
{
    protected $table = 'cnic_mobile_links';

    protected $fillable = [
        'cnic',
        'cnic_digits',
        'mobile_number',
        'mobile_digits',
        'source',
        'user_id',
        'status',
        'created_by',
        'updated_by',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
