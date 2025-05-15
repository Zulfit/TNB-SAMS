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

    public function assets(){
        return $this->hasMany(Asset::class);
    }

    public function sensors(){
        return $this->hasMany(Sensor::class);
    }

    public function report(){
        return $this->hasOne(Report::class);
    }

    public function datasets(){
        return $this->hasMany(Dataset::class);
    }
}
