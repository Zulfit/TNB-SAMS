<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensorTemperature extends Model
{
    protected $table = 'sensor_temperature';

    protected $fillable = [
        'sensor_id',
        'red_phase_temp',
        'yellow_phase_temp',
        'blue_phase_temp',
        'max_temp',
        'min_temp',
        'variance_percent',
        'alert_triggered',
        'created_at',
        'updated_at',
    ];

    public function sensor()
    {
        return $this->belongsTo(Sensor::class);
    }
}
