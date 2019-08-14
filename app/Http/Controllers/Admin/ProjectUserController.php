<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProjectUserResquest;
use App\Models\Department;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tableProjects = Project::with(['users'=>function($query){
           $query->select('user_id','name')->groupBy('user_id');
        }])->orderByDesc('id')->paginate(config('variables.number_per_page'));

//        $users = Project::with(['users' => function ($query) {
//            $query->select('user_id','name')->groupBy('user_id');
//        }])->findOrFail($projectId);

        $listDepartments = Department::all()->sortBy('name');
        $listProjects = Project::all()->sortBy('name');
        $data = [
            'tableProjects' => $tableProjects,
            'listProjects' => $listProjects,
            'listDepartments' => $listDepartments
        ];
        return view('admin.project_user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectUserResquest $request)
    {
        $listUsers = Project::findOrFail($request->get('project_id'))->users()->get();
        $arrCompare = [];
        $nameUsers = 'name: ';
        foreach ($listUsers as $user) {
            $arrCompare[] = $user->id;
        }

        $project = Project::findOrFail($request->get('project_id'));
        $query = [];
        $arrUserId = $request->get('checkBoxUserId');
        $checkExist = array_intersect($arrCompare, $arrUserId);

        if (sizeof($checkExist) == 0) {
            for ($i = 0; $i < sizeof($arrUserId); $i++) {
                $query[] = ['user_id' => $arrUserId[$i]];
            }
            $project->users()->attach($query);
            return redirect('/admin/project_user')->with('message', __('messages.project_user_add'));
        } else {
            $usersExist = User::findOrFail($checkExist);
            foreach ($usersExist as $user) {
                $nameUsers .= $user->name . ' || ';
            }
            return redirect('/admin/project_user')->with('message', 'Error: added user already exists, ' . $nameUsers);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::with(['users' => function ($query) {
            $query->select('user_id', 'name')->distinct('id');
        }])->findOrFail($id);

        $data = [
            'project' => $project,
            'message' => 'Your AJAX processed correctly',
        ];
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->users()->detach();
        return redirect('/admin/project_user')->with('message', __('messages.project_user_destroy'));
    }

    public function getUserByDepartment($departmentId)
    {
        $data = [];
        if (is_numeric($departmentId)) {
            $dept = Department::with('users')->findOrFail($departmentId);
            $data = [
                'department' => $dept,
            ];
        }

        if ($departmentId == 'all') {
            $users = User::all()->sortBy('name');
            $data = [
                'users' => $users,
                'department_id' => $departmentId
            ];
        }
        return response()->json($data);
    }

    public function showListAssign()
    {
        $projects = Project::all()->sortBy('name');
        $data = [
            'projects' => $projects,
        ];
        return view('admin.project_user.assign', $data);
    }

    public function getProjectById($projectId)
    {
        $data = [];
        if (is_numeric($projectId)) {
            $project = Project::with(['users' => function ($query) {
                $query->orderBy('name');
            }])->findOrFail($projectId);

            $users = Project::with(['users' => function ($query) {
                $query->select('user_id','name')->groupBy('user_id');
            }])->findOrFail($projectId);
            $data = [
                'project' => $project,
                'message' => 'call ajax',
                'users' => $users
            ];
        }
        return response()->json($data);
    }

    public function assignUser(Request $request)
    {
        $projectId = $request->project_id;
        $userId = $request->user_id;
        $dateJoin = $request->date_join;
        $dateLeave = $request->date_leave;
        $data = [
            'request'=> $request->all(),
        ];


        return response()->json($data);

    }
}
