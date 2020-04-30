<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class UserController extends Controller
{

    public function getEmployees() {
        return User::has('roles', '==', 0)
            ->orWhereHas(
                'roles', function($q){
                $q->where('name', '<>', 'admin');
            })->with('roles')->with('managers')->get();
    }

    public function getHRmanagers() {
        return User::whereHas(
            'roles', function($q){
            $q->where('name', 'hr');
        })->with('roles')->with('managers')->get();
    }

    public function addEmployee(Request $request) {

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',

            'role_ids' => 'required',
            'total_paid_leave' => 'required|numeric|min:1|max:20',
            'total_sick_leave' => 'required|numeric|min:1|max:20'
        ],
        [
            'role_ids.required' => 'You have to select Roles!',

        ]);


        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('123456'),
            'total_paid_leave' => $request->total_paid_leave,
            'total_sick_leave' => $request->total_sick_leave
        ]);

        $user->save();
        $user->roles()->attach($request->role_ids);
        $user->managers()->attach($request->manager_ids);

        return response()->json([
            'message' => 'Successfully created Employee!'
        ], 201);
    }

    public function editEmployee(Request $request) {
        $user = User::find($request->id);
        if (empty($user)) {
            return response('User not found', 404);
        }

        $request->validate([
            'name' => 'required|string',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user)],

            'role_ids' => 'required',
            'total_paid_leave' => 'required|numeric|min:1|max:20',
            'total_sick_leave' => 'required|numeric|min:1|max:20'
        ],
        [
            'role_ids.required' => 'You have to select Roles!',

        ]);


        $user->name = $request->name;
        $user->email = $request->email;
        $user->total_paid_leave = $request->total_paid_leave;
        $user->total_sick_leave = $request->total_sick_leave;
        $user->save();
        $user->roles()->sync($request->role_ids);
        $user->managers()->sync($request->manager_ids);
        return response()->json([
            'message' => 'Successfully Employee Edited!'
        ], 200);
    }
}
