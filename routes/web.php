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
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/admin/project_user/showListAssign', 'Admin\ProjectUserController@showListAssign')->name('project_user.showListAssign');
Route::get('/admin/ajax/getUserByDepartment/{departmentId}', 'Admin\ProjectUserController@getUserByDepartment');
Route::get('/admin/ajax/getProjectById/{projectId}', 'Admin\ProjectUserController@getProjectById');
Route::post('/admin/ajax/assignUser','Admin\ProjectUserController@assignUser')->name('project_user.assignUser');
Route::get('/login/admin', 'Auth\LoginController@showAdminLoginForm');
Route::post('/login/admin', 'Auth\LoginController@adminLogin');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::namespace('Admin')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::resource('', 'HomeController');
        Route::resource('staffs', 'StaffController');
        Route::resource('projects', 'ProjectController');
        Route::resource('project_user', 'ProjectUserController');
    });
});
