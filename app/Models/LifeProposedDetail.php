<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LifeProposedDetail extends Model
{
    protected $table = 'life_proposed_details';

    protected $guarded = ['id'];

    protected $casts = [
        'payload' => 'array',
    ];
}
