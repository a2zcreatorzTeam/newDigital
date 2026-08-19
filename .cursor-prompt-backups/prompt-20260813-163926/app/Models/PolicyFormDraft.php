<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PolicyFormDraft extends Model
{
    protected $table = 'policy_form_drafts';

    protected $fillable = [
        'user_id',
        'product_id',
        'product_name',
        'last_tab',
        'progress_label',
        'filled_sections',
        'form_payload',
    ];

    protected $casts = [
        'form_payload' => 'array',
        'filled_sections' => 'integer',
        'product_id' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(SubClass::class, 'product_id', 'id');
    }
}
