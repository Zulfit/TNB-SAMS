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
        'pic',
        'assigned_by',
        'desc',
        'status',
        'report',
        'admin_review',
        'reviewed_at',
    ];

    public function sensor()
    {
        return $this->belongsTo(Sensor::class, 'sensor_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'pic');
    }

    public function assignBy()
    {
        return $this->belongsTo(User::class,'assigned_by');
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
