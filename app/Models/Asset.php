<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_name',
        'asset_type',
        'asset_substation',
        'asset_date',
        'asset_status',
    ];

    public function substation(){
        return $this->belongsTo(Substation::class,'asset_substation');
    }
}
