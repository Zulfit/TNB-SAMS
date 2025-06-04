<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensorPartialDischarge extends Model
{
    protected $table = 'sensor_partial_discharge';

    protected $fillable = [
        'sensor_id',
        'LFB_Ratio',
        'LFB_Ratio_Linear',
        'MFB_Ratio',
        'MFB_Ratio_Linear',
        'HFB_Ratio',
        'HFB_Ratio_Linear',
        'Mean_Ratio',
        'LFB_EPPC',
        'MFB_EPPC',
        'HFB_EPPC',
        'Mean_EPPC',
        'Indicator',
        'alert_triggered',
        'created_at',
        'updated_at',
    ];

    public function sensor()
    {
        return $this->belongsTo(Sensor::class);
    }
}
