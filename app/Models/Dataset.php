<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dataset extends Model
{
    protected $fillable = [
        'dataset_file',
        'dataset_measurement',
        'dataset_sensor'
    ];

    public function sensor(){
        return $this->belongsTo(Sensor::class,'dataset_sensor');
    }
}
