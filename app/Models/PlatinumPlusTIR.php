<?php

namespace App\Models;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatinumPlusTIR extends Model
{
    use HasFactory;
    protected $table = 'platinumplustir';
    protected $guarded = ['id'];

}
