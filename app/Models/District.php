<?php

namespace App\Models;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $table = 'districts';
     protected $guarded = ['id'];

     public function city(){
        return $this->hasOne(City::class, 'id', 'city_id');
     }
}
