<?php

namespace App\Models;

use App\Support\LifeProposedDocument;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPolicyData extends Model
{
    use HasFactory;

    protected $table = 'user_personal_policy_data';
    protected $guarded = ['id', 'user_id'];

    public const PROTECTED_ATTRIBUTES = [
        'id',
        'user_id',
        'policy_id',
        'status',
        'comment',
        'premium_paid',
    ];

    public static function withoutProtected(array $data): array
    {
        return collect($data)->except(self::PROTECTED_ATTRIBUTES)->all();
    }

    public function scopeOwnedBy($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function lifeProposedDetail()
    {
        return $this->hasOne(LifeProposedDetail::class, 'policy_data_id');
    }

    public function getLifeProposedDocumentAttribute(): ?string
    {
        return LifeProposedDocument::filename($this->attributes['other_documents'] ?? null);
    }

       public function product()
    {
        return $this->hasOne(SubClass::class, 'id', 'plan');
    }

       public function voucher()
    {
        return $this->hasOne(Voucher::class, 'policy_id', 'policy_id');
    }
       public function family_history()
    {
        return $this->hasMany(FamilyHistory::class, 'policy_id', 'policy_id');
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

     public function dualNationalityCountry()
     {
         return $this->belongsTo(Country::class, 'dual_nationality_country_id');
     }

     public function primaryNationalityCountry()
     {
         return $this->belongsTo(Country::class, 'primary_nationality_country_id');
     }

     public function countryOfResidence()
     {
         return $this->belongsTo(Country::class, 'country_of_residence_id');
     }
}
