<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'sensor_name',
        'sensor_panel',
        'sensor_compartment',
        'sensor_substation',
        'sensor_date',
        'sensor_status',
    ];

    public function substation(){
        return $this->belongsTo(Substation::class,'sensor_substation');
    }
}
