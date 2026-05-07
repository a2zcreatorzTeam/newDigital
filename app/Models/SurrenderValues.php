<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurrenderValues extends Model
{
    use HasFactory;

    protected $table = 'surrender_values';
    protected $guarded = ['id'];
    public function PlanageMaturity()
    {
        return $this->belongsTo(SurrenderValues::class, 'plan_age_id', 'id');
    }
}
