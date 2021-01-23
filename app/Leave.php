<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    // constant
    const PAID_LEAVE_ID = 1;
    const SICK_LEAVE_ID = 2;
    const PENDING = 'pending';
    const APPROVED = 'approved';
    const REJECTED = 'rejected';
    
    public function leaveType() {
       return $this->belongsTo(LeaveType::class,'leave_types_id');
    }

    public function appliedUser() {
        return $this->belongsTo(User::class,'applied_by')->with('roles');
    }

    public function approvedUser() {
        return $this->belongsTo(User::class,'approved_by')->with('roles');
    }

    /*
    * instance methods
    */ 

    public function isPaid() {
        return $this->leave_types_id === $this::PAID_LEAVE_ID;
    }

    public function isSick() {
        return $this->leave_types_id === $this::SICK_LEAVE_ID;
    }

    public function reject($processedBy) {
        $user = $this->appliedUser()->first();
        $this->approved_by = $processedBy;
        $this->status = $this::REJECTED;

        if ($this->isSick()) {
            $user->sick_leave_taken = $user->sick_leave_taken - $this->no_of_days;
        } else {
            $user->paid_leave_taken = $user->paid_leave_taken - $this->no_of_days;
        }

        $this->save();
        $user->save();
    }
    
    public function approve($processedBy = null) {
        // logic for auto approved
        if (!empty($processedBy)) {
            $this->approved_by = $processedBy;
        }
        
        $this->status = $this::APPROVED;
        $this->save();
    }
}

    

    