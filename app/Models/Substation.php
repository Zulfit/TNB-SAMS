<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Substation extends Model
{
    protected $fillable = [
        'substation_name',
        'substation_location',
        'substation_date',
    ];

    
}
