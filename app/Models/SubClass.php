<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubClass extends Model
{
    use HasFactory;

    protected $table = 'sub_classes';

    protected $fillable = [
        'name',
        'logo',
        'class_id',
        'status',
        'table_no'
    ];

    public function mainClass()
    {
        return $this->belongsTo(MainClass::class, 'class_id', 'id');
    }
      public function product()
    {
        return $this->hasMany(PlanAgeMaturity::class, 'plan_id', 'id');
    }
}
