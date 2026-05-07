<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPolicyData extends Model
{
    use HasFactory;

    protected $table = 'user_personal_policy_data';
    protected $guarded = ['id'];

       public function product()
    {
        return $this->hasOne(SubClass::class, 'id', 'plan');
    }
}
