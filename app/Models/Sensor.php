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
            'sensor_substation',
            'sensor_panel',
            'sensor_compartment',
            'sensor_measurement',
            'sensor_date',
            'sensor_status',
        ];

    public function substation()
    {
        return $this->belongsTo(Substation::class, 'sensor_substation');
    }

    public function panel()
    {
        return $this->belongsTo(Panels::class, 'sensor_panel');
    }

    public function compartment()
    {
        return $this->belongsTo(Compartments::class, 'sensor_compartment');
    }

    public function temperatureReadings()
    {
        return $this->hasMany(SensorTemperature::class);
    }

    public function partialDischargeReadings()
    {
        return $this->hasMany(SensorPartialDischarge::class);
    }

    public function error()
    {
        return $this->hasOne(ErrorLog::class);
    }

    public function dataset()
    {
        return $this->hasMany(Dataset::class);
    }
}
