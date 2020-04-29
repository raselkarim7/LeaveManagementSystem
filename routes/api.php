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
    Route::get('roles', 'RoleController@index');
    Route::get('employees', 'UserController@getEmployees');
    Route::get('hrmanagers', 'UserController@getHRmanagers');
    Route::post('employee', 'UserController@addEmployee');
    Route::put('employee', 'UserController@editEmployee');


});