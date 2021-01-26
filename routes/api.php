<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/test', function(Request $request) {
    $data = $request->all();
    $data['fromServer'] = 'yessssssss';
    return $data;
    return 'Test api request successful';
});


Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');

    Route::group([
        'middleware' => 'auth:api'
    ], function() {

        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});


Route::group([
    'middleware' => 'auth:api'
], function() {
    
    Route::get('employees-count', 'UserController@getEmployeesCount');
    Route::put('employee', 'UserController@editEmployee');

    Route::get('leave-types', 'LeaveController@leaveTypes');
    Route::post('leaves', 'LeaveController@store');
    Route::get('applied-leaves', 'LeaveController@appliedLeaves');
    Route::get('pending-applications', 'LeaveController@pendingApplications');
    Route::get('approved-or-rejected-applications', 'LeaveController@approvedOrRejectedApplications');
    

    Route::post('change-password', 'AuthController@changePassword');

    // authorization for hr rolw
    Route::group([
        'middleware' => 'hr'
    ], function () {
        Route::get('employees', 'UserController@getEmployees');
        Route::get('roles', 'RoleController@index');
        Route::get('hrmanagers', 'UserController@getHRmanagers');
        Route::post('employee', 'UserController@addEmployee');
        Route::post('leave-approval', 'LeaveController@leaveApproval');
    });

});
