<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('login')->group(function () {
    Route::get('/admin', 'Auth\AdminLoginController@showLoginForm')->name('login.admin');
    Route::post('/admin', 'Auth\AdminLoginController@login');
    Route::get('/customer', 'Auth\CustomerLoginController@showLoginForm')->name('login.customer');
    Route::post('/customer', 'Auth\CustomerLoginController@login');
});
Route::namespace('Admin')->group(function () {
    Route::prefix('admin')->middleware('auth:admin')->group(function () {
        Route::get('', 'HomeController@index')->name('admin.dashboard');
        Route::get('project_user/show-list-assign', 'ProjectUserController@showListAssign')->name('project_user.show_list_assign');
        Route::resource('staffs', 'StaffController');
        Route::resource('projects', 'ProjectController');
        Route::resource('project_user', 'ProjectUserController');
        Route::resource('tasks', 'TaskController');
        Route::resource('reports', 'ReportController');

    });
    Route::prefix('admin/ajax')->group(function () {
        Route::get('/get-user-by-department/{departmentId}', 'ProjectUserController@getUserByDepartment');
        Route::get('/get-project-by-id/{projectId}', 'ProjectUserController@getProjectById');
        Route::post('/assign-user', 'ProjectUserController@assignUser')->name('project_user.assign_user');
        Route::get('/get-task-by-project-id/{projectId}', 'TaskController@getTaskByProjectId');
    });
});
Route::namespace('Client')->group(function () {
    Route::prefix('staffs')->middleware('auth')->group(function () {
        Route::get('', 'StaffController@index')->name('client.staffs.index');
        Route::get('reports', 'StaffController@showReport')->name('client.staffs.show_report');
    });
    Route::prefix('customers')->middleware('auth:customer')->group(function () {
        Route::get('', 'CustomerController@index')->name('client.customers.index');
    });
    Route::prefix('client/ajax')->group(function () {
        Route::post('/store-staff-report', 'StaffController@storeReport')->name('client.staffs.store_report');
        Route::get('/get-report-task-by-project/{projectId}', 'StaffController@getReportTaskByProject')->name('client.staffs.get_report_task');

    });
});
