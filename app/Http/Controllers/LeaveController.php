<?php

namespace App\Http\Controllers;

use App\Leave;
use App\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function leaveTypes() {
        return LeaveType::all();
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function getDays($param) {
        if (empty($param)) {
            return 0;
        }
        return $param;
    }

    public function store(Request $request)
    {
        $time = abs(strtotime($request->end_date) - strtotime($request->start_date));
        $diffdays = floor($time/(60*60*24)) + 1;

        $user = Auth::user();

        if ($request->leave_types_id === 1) {
            $pendingDays = self::getDays( $user->total_paid_leave) - self::getDays($user->paid_leave_taken);
            $leaveType = 'Paid';
        } else {
            $pendingDays = self::getDays($user->total_sick_leave) - self::getDays($user->sick_leave_taken);
            $leaveType = 'Sick';
        }

        if ($pendingDays === 0) {
            $request->validate([
                'no_of_days' => ["required", Rule::in($pendingDays)]
            ],
            [
                'no_of_days.required' => 'No of days required.',
                'no_of_days.*' => "No more $leaveType leave is remained, Select another Leave Type & Try."
            ]);
        }

        $request->validate([
           'no_of_days' => "numeric|between:1,$pendingDays"
        ],
        [
            'no_of_days.*' => "No of days must be less than or equal $pendingDays"
        ]);

        $request->validate([
            'leave_types_id' => 'required',
            'no_of_days' => Rule::in([$diffdays]),
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after_or_equal:start_date'
        ],
        [
            'leave_types_id.required' => 'You have to select Leave Types!',
            'no_of_days.*' => "No of days must be ".$diffdays.", based on Start & End Date"
        ]);



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function show(Leave $leave)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function edit(Leave $leave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Leave $leave)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function destroy(Leave $leave)
    {
        //
    }
}
