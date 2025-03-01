<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Substation extends Model
{
    
    use HasFactory;
    protected $fillable = [
        'substation_name',
        'substation_location',
        'substation_date',
    ];
}
