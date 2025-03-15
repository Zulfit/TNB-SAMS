<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Panels extends Model
{
    public function sensors(){
        return $this->hasMany(Sensor::class);
    }

    public function report(){
        return $this->hasOne(Report::class);
    }
}
