<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanAgeMaturity extends Model
{
    use HasFactory;

    protected $table = 'plan_age_maturity';
    protected $guarded = ['id'];

    // public function product()
    // {
    //     return $this->belongsTo(SubClass::class, 'id', 'plan_id');
    // }
      public function surrendervalues()
    {
        return $this->hasMany(SurrenderValues::class, 'plan_age_id', 'id');
    }
}
