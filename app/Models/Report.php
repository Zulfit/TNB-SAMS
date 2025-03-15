<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'report_substation',
        'report_panel',
        'report_compartment',
        'start_date',
        'end_date',
    ];

    public function substation(){
        return $this->belongsTo(Substation::class,'report_substation');
    }

    public function panel(){
        return $this->belongsTo(Panels::class,'report_panel');
    }

    public function compartment(){
        return $this->belongsTo(Compartments::class,'report_compartment');
    }
}
