<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    public function leaveType() {
       return $this->belongsTo(LeaveType::class,'leave_types_id');
    }
}
