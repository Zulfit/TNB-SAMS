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
        'generated_by', 
        'file_report'
    ];

    public function substation(){
        return $this->belongsTo(Substation::class,'report_substation');
    }

    public function user(){
        return $this->belongsTo(User::class,'generated_by');
    }
}
