<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserManagement extends Model
{

    protected $fillable = [
        'user_id',
        'dashboard_access',
        'analytics_access',
        'dataset_access',
        'substation_access',
        'asset_access',
        'sensor_access',
        'report_access',
        'user_management_access',
    ];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
