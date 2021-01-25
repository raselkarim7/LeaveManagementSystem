<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLeaveRequest extends FormRequest
{
    public static function getDays($param) {
        if (empty($param)) {
            return 0;
        }
        return $param;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $request = $this;
        $time = abs(strtotime($request->end_date) - strtotime($request->start_date));
        $diffdays = floor($time/(60*60*24)) + 1;

        $user = $this->user();


        if ($request->leave_types_id === 1) {
            $pendingDays = self::getDays( $user->total_paid_leave) - self::getDays($user->paid_leave_taken);
            $leaveType = 'Paid';
        } else {
            $pendingDays = self::getDays($user->total_sick_leave) - self::getDays($user->sick_leave_taken);
            $leaveType = 'Sick';
        }

        if ($pendingDays === 0) {
            $this->validate([
                'no_of_days' => ["required", Rule::in($pendingDays)]
            ],
            [
                'no_of_days.required' => 'No of days required.',
                'no_of_days.*' => "No more $leaveType leave is remained, Select another Leave Type & Try."
            ]);
        }

        $this->validate([
           'no_of_days' => "numeric|between:1,$pendingDays"
        ],
        [
            'no_of_days.*' => "No of days must be bewtween 1 and $pendingDays"
        ]);

        $this->validate([
            'leave_types_id' => 'required',
            'no_of_days' => Rule::in([$diffdays]),
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after_or_equal:start_date'
        ],
        [
            'leave_types_id.required' => 'You have to select Leave Types!',
            'no_of_days.*' => "No of days must be ".$diffdays.", based on Start & End Date"
        ]);
        
        return [];
    }
}
