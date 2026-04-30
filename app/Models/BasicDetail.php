<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasicDetail extends Model
{
    use HasFactory;
    protected $table='user_basic_details';
    protected $guarded = ['id'];

    

}