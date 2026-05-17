<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Otp extends Model
{
    protected $fillable = [
        'user_id',
        'otp',
        'type',
        'expires_at',
        'is_used'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_used' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    public function isExpired()
    {
        return now()->gt($this->expires_at);
    }
}
