<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    // constant
    const PAID_LEAVE_ID = 1;
    const SICK_LEAVE_ID = 2;
    
    public function leaveType() {
       return $this->belongsTo(LeaveType::class,'leave_types_id');
    }

    public function appliedUser() {
        return $this->belongsTo(User::class,'applied_by')->with('roles');
    }

    public function approvedUser() {
        return $this->belongsTo(User::class,'approved_by')->with('roles');
    }
}
