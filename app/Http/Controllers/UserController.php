<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use \App\Http\Requests\StoreUserRequest;
use \App\Http\Requests\EditUserRequest;


class UserController extends Controller
{

    // user count for non hr/admin user 
    public function getEmployeesCount() {
        return response(["length" => User::count()], 200);
    }

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

    public function addEmployee(StoreUserRequest $request) {
        $user = new User($request->all());
        $user->password = bcrypt('123456');

        $user->save();
        $user->roles()->attach($request->role_ids);
        $user->managers()->attach($request->manager_ids);

        return response()->json([
            'message' => 'Successfully created Employee!'
        ], 201);
    }

    public function editEmployee(EditUserRequest $request) {
        $user = User::find($request->id);
        if (empty($user)) {
            return response('User not found', 404);
        }

        $data = $request->all();
        $user->update($data);
        $user->roles()->sync($request->role_ids);
        $user->managers()->sync($request->manager_ids);
        return response()->json([
            'message' => 'Successfully Employee Edited!'
        ], 200);
    }
}
