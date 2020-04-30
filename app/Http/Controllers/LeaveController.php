<?php

namespace App\Http\Controllers;

use App\Leave;
use App\LeaveType;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use function PHPSTORM_META\type;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private const PENDING = 'pending';
    private const APPROVED = 'approved';
    private const REJECTED = 'rejected';

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

        $user = User::where('id', Auth::id())->with('managers')->first();


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
            'no_of_days.*' => "No of days must be bewtween 1 and $pendingDays"
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




        $leave = new Leave();
        $leave->no_of_days = $request->no_of_days;
        $leave->start_date = $request->start_date;
        $leave->end_date = $request->end_date;
        $leave->leave_types_id = $request->leave_types_id;
        $leave->applied_by = Auth::id();
        $leave->status = self::PENDING;
        $leave->save();

        $user = User::find(Auth::id());
        if ($request->leave_types_id === 1) {
            $alreadyTaken = self::getDays( $user->paid_leave_taken );
            $user->paid_leave_taken = $alreadyTaken + $leave->no_of_days;
        } else {
            $alreadyTaken = self::getDays( $user->sick_leave_taken );
            $user->sick_leave_taken = $alreadyTaken + $leave->no_of_days;
        }
        $user->save();


        $managers = $user->managers;
        if($managers->isEmpty()) {
           self::autoLeaveApproval($leave->id, Auth::id());
        }

        return response()->json([
            'message' => 'Leave Applied Successfully!'
        ], 201);
    }

    public static function autoLeaveApproval($leave_id, $user_id) {

        $leave = Leave::find($leave_id);
        $user = User::where('id', $user_id)->first();

        $leave->status = self::APPROVED;
        $leave->save();

        if($leave->leave_types_id === 1) {
            $user->paid_leave_taken = self::getDays($user->paid_leave_taken) + $leave->no_of_days;
        } else if ($leave->leave_types_id === 2) {
            $user->sick_leave_taken = self::getDays($user->sick_leave_taken) + $leave->no_of_days;
        }

        $user->save();
    }


    public function appliedLeaves(Request $request) {
        return Leave::where('applied_by', Auth::id())->with('leaveType')->get();
    }

    /**
     * Fetch Subordinate Users pending applications under a manager
     */
    public function pendingApplications(Request $request) {
        $manager_id = Auth::id();
        $subordinateUserIds = DB::table('user_manager')
            ->where('manager_id', $manager_id)
            ->pluck('user_id');

        $pendingLeaves = Leave::where('status', self::PENDING)
            ->whereIn('applied_by', $subordinateUserIds)
            ->with('leaveType')
            ->with('appliedUser')
            ->get();

        return $pendingLeaves;
    }

    public function approvedOrRejectedApplications(Request $request) {
        $manager_id = Auth::id();
        $subordinateUserIds = DB::table('user_manager')
            ->where('manager_id', $manager_id)
            ->pluck('user_id');

        $approvedOrRejectedLeaves = Leave::where('status', self::APPROVED)
            ->orWhere('status', self::REJECTED)
            ->whereIn('applied_by', $subordinateUserIds)
            ->with('leaveType')
            ->with('appliedUser')
            ->with('approvedUser')
            ->get();

        return $approvedOrRejectedLeaves;
    }



    public function leaveApproval(Request $request) {
        $leave = Leave::find($request->id);
        $user = User::where('id', $request->applied_by)->first();

        if (empty($leave)) {
            return response('Leave not found', 404);
        } else if (empty($user)) {
            return response('User not found', 404);
        }

        if ($request->action_type === 'approve') {
            $leave->status = self::APPROVED;
        } else if($request->action_type === 'reject') {
            $leave->status = self::REJECTED;
        }
        $leave->approved_by = Auth::id();
        $leave->save();

        if ($request->action_type === 'approve') {
            if($request->leave_types_id === 1) {
                $user->paid_leave_taken = self::getDays($user->paid_leave_taken) + $request->no_of_days;
            } else if ($request->leave_types_id === 2) {
                $user->sick_leave_taken = self::getDays($user->sick_leave_taken) + $request->no_of_days;
            }
        }
        $user->save();

        return response()->json([
            'message' => 'Leave Operation Successful!'
        ], 200);
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
