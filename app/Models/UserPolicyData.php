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
    
       public function get_permanent_province()
    {
        return $this->hasOne(Provinces::class, 'id', 'permanent_province_id');
    }
       public function get_corres_province()
    {
        return $this->hasOne(Provinces::class, 'id', 'corres_province_id');
    }
       public function get_temp_province()
    {
        return $this->hasOne(Provinces::class, 'id', 'temp_province_id');
    }







   
    public function get_permanent_district()
    {
        return $this->hasOne(District::class, 'id', 'permanent_district_id');
    }
       public function get_corres_district()
    {
        return $this->hasOne(District::class, 'id', 'corres_district_id');
    }
       public function get_temp_district()
    {
        return $this->hasOne(District::class, 'id', 'temp_district_id');
    }












    public function get_permanent_city()
    {
        return $this->hasOne(City::class, 'id', 'permanent_city_id');
    }
       public function get_corres_city()
    {
        return $this->hasOne(City::class, 'id', 'corres_city_id');
    }
       public function get_temp_city()
    {
        return $this->hasOne(City::class, 'id', 'temp_city_id');
    }

     public function policyPlan()
     {
         return $this->belongsTo(SubClass::class, 'plan', 'id');
     }

     public function user()
     {
         return $this->belongsTo(User::class, 'user_id', 'id');
     }
}
