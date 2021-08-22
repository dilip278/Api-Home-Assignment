<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\ApiController;
// use App\Http\Controllers\API\ProductController;

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

//api for user login
Route::post('login', [ApiController::class, 'login']);
//api to create employee details 
Route::post('create-employees-details', [ApiController::class, 'creatEmployeeDetails']);
//api to create department details
Route::post('create-department-details', [ApiController::class, 'creatDepartmentDetails']);
//api to get employee details
Route::get('get-employee-details/{emp_code}', [ApiController::class, 'getEmployeeDetails']);
//api to update employee details
Route::post('update-employee-details', [ApiController::class, 'updateEmployeeDetails']);
//api to delete employee details
Route::get('delete-employee-details/{emp_code}', [ApiController::class, 'deleteEmployeeDetails']);
//api to search employee details
Route::get('search-employee-details/{search_value}', [ApiController::class, 'searchEmployee']);

