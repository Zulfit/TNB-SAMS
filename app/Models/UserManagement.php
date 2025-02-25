<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserManagement extends Model
{
    public function accesscontrol()
    {
        return $this->belongsTo(User::class);
    }
}
