<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOccupation extends Model
{
    use HasFactory;

    protected $table = 'user_occupation';
     protected $guarded = ['id'];

 
}
