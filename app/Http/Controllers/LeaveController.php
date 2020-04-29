<?php

namespace App\Http\Controllers;

use App\Leave;
use App\LeaveType;
use Illuminate\Http\Request;
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
    public function store(Request $request)
    {
        $time = abs(strtotime($request->end_date) - strtotime($request->start_date));
        $diffdays = floor($time/(60*60*24)) + 1;


        $request->validate([
            'leave_types_id' => 'required',
            'no_of_days' => ['required',  Rule::in([$diffdays])],
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after_or_equal:start_date'
        ],
        [
            'leave_types_id.required' => 'You have to select Leave Types!',
            'no_of_days.required' => 'No of days required.',
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
