<?php

namespace App\Models;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoldenEndowmentPlanTir extends Model
{
    use HasFactory;
    protected $table = 'golden_endowment_plan_tir';
    protected $guarded = ['id'];

}
