<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    public function leaveTypes() {
        $this->belongsTo(LeaveType::class);
    }
}
