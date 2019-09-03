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
        Route::get('/', 'HomeController@index')->name('admin.dashboard');
        Route::get('project-user/show-list-assign', 'Project\UserController@showListAssign')->name('project_user.show_list_assign');
        Route::resource('staffs', 'StaffController');
        Route::resource('projects', 'ProjectController');
        Route::resource('project-user', 'Project\UserController');
        Route::resource('tasks', 'TaskController');
        Route::resource('reports', 'ReportController');
        Route::resource('customers', 'CustomerController');
    });
    Route::prefix('admin/ajax')->group(function () {
        Route::get('/get-user-by-department/{departmentId}', 'Project\UserController@getUserByDepartment')->name('project_user.get_user_by_department');
        Route::get('/get-user-by-project/{projectId}', 'Project\UserController@getUserByProject')->name('project_user.get_user_by_project');
        Route::get('/get-project-assign-by-user/{projectId}/{userId}', 'Project\UserController@getProjectAssignByUser')->name('project_user.get_project_assign_by_user');
        Route::post('/assign-user', 'Project\UserController@assignUser')->name('project_user.assign_user');
        Route::get('/get-task-by-project-id/{projectId}', 'TaskController@getTaskByProjectId');
        Route::delete('/delete-user-in-project/{projectId}/{userId}','Project\UserController@deleteUserInProject')->name('project_user.delete_user_in_project');
        Route::delete('/delete-assignment/{projectId}/{userId}/{dateJoin}/{dateLeave}','Project\UserController@deleteAssignment')->name('project_user.delete_assignment');
    });
});
Route::namespace('Client')->group(function () {
    Route::prefix('client/ajax')->group(function () {
        Route::post('/store-staff-report', 'StaffController@storeReport')->name('client.staffs.store_report');
        Route::get('/get-tasks-by-project/{projectId}', 'Staff\ReportController@getTasksByProject')->name('client.staffs.get_tasks_by_project');
        Route::delete('/delete-staff-report/{reportId}', 'StaffController@destroyReport')->name('client.staffs.delete_report');
        Route::get('/search-report-by-date/{fromDate}/{toDate}', 'Staff\ReportController@searchReportByDate')->name('client.staffs.search_report_by_date');
    });
    Route::prefix('staffs')->middleware('auth')->group(function () {
        Route::get('/', 'StaffController@index')->name('client.staffs.index');
        Route::resource('reports', 'Staff\ReportController');
    });
    Route::prefix('customers')->middleware('auth:customer')->group(function () {
        Route::get('/', 'CustomerController@index')->name('client.customers.index');
        Route::get('staffs', 'Customer\StaffController@index')->name('client.customers.staffs.index');
    });
});
