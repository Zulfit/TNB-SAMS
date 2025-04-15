<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ErrorLog extends Model
{
    protected $fillable = [
        'sensor_id',
        'state',
        'threshold',
        'severity',
        'pic'
    ];

    public function sensor()
    {
        return $this->belongsTo(Sensor::class, 'sensor_id');
    }

    public function getStateBadgeClass(): string
    {
        return match ($this->state) {
            'NORMAL' => 'bg-success',
            'AWAIT' => 'bg-warning',
            'ALARM' => 'bg-danger',
            default => 'bg-dark',
        };
    }

    public function getSeverityBadgeClass(): string
    {
        return match ($this->severity) {
            'CRITICAL' => 'bg-danger',
            'WARN' => 'bg-warning',
            'SAFE' => 'bg-success',
            default => 'bg-secondary',
        };
    }

}
