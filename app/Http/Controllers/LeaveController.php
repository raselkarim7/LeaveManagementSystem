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
use \App\Http\Requests\StoreLeaveRequest;

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
    private const REJECT = 'reject';

    public function leaveTypes() {
        return LeaveType::all();
    }

    public function index()
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

    public function store(StoreLeaveRequest $request)
    {

        $user = User::where('id', Auth::id())->with('managers')->first();
        
        // use mass assignment feature
        $leave = new Leave($request->all());
        $leave->applied_by = Auth::id();
        $leave->status = self::PENDING;
        
        $leave->save();

        $user = Auth::user();
        if ($request->leave_types_id === 1) {
            $alreadyTaken = self::getDays( $user->paid_leave_taken );
            $user->paid_leave_taken = $alreadyTaken + $leave->no_of_days;
        } else {
            $alreadyTaken = self::getDays( $user->sick_leave_taken );
            $user->sick_leave_taken = $alreadyTaken + $leave->no_of_days;
        }
        $user->save();


        /*
        * handle auto approval if there is no manager
        */ 
        $managers = $user->managers;
        if($managers->isEmpty()) {
           $leave->approve();
        }

        return response()->json([
            'message' => 'Leave Applied Successfully!'
        ], 201);
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

        // ensure current user is the manager of the applicant
        $manager = $user->managers()->where('id', '=',  Auth::id())->first();
        if (empty($manager)) {
            return response(['message' => 'You do not have the correct permissiong'], 404);
        }

        // ensure this leave is not processed yet
        if ($leave->isProcessed()) {
            return response(['message' => 'The leave has already been processed'], 422);
        }

        if ($request->action_type === 'approve') {
            $leave->approve(Auth::id());
        } else if($request->action_type === self::REJECT) {
            $leave->reject(Auth::id());
        }

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
