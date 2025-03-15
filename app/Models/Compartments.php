<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compartments extends Model
{
    public function sensors(){
        return $this->hasMany(Sensor::class);
    }
}
