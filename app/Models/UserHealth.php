<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHealth extends Model
{
    use HasFactory;

    protected $table = 'user_health';
    protected $guarded = ['id'];

 
}
