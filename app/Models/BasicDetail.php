<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasicDetail extends Model
{
    use HasFactory;
    protected $table='user_basic_details';
    protected $guarded = ['id'];

    public function lifeProposedDetail()
    {
        return $this->hasOne(LifeProposedDetail::class, 'user_id', 'user_id')
            ->whereNull('policy_data_id');
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