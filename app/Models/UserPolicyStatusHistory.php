<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPolicyStatusHistory extends Model
{
    use HasFactory;
    protected $table = 'user_policy_status_history';
    protected $guarded = ['id'];
}
