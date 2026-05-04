<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddressInfo extends Model
{
    use HasFactory;
    protected $table='user_address_info';
    protected $guarded = ['id'];

    

}