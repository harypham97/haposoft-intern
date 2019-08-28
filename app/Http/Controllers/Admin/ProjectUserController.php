<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Project\AssignRequest;
use App\Http\Requests\ProjectUserRequest;
use App\Models\Department;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DateTime;

class ProjectUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tableProjects = Project::with(['users' => function ($query) {
            $query->select('user_id', 'name')->groupBy('users.id');
        }])->orderByDesc('id')->paginate(config('variables.number_per_page'));
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectUserRequest $request)
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
            return redirect()->route('project_user.index')->with('message', __('messages.project_user_add'));
        } else {
            $usersExist = User::findOrFail($checkExist);
            foreach ($usersExist as $user) {
                $nameUsers .= $user->name . ' || ';
            }
            return redirect()->route('project_user.index')->with('message', 'Error: added user already exists, ' . $nameUsers);
        }
    }

    public function showListAssign()
    {
        $projects = Project::all()->sortBy('name');
        $data = [
            'projects' => $projects,
        ];
        return view('admin.project_user.assign', $data);
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
        ];
        return response()->json([
            'success' => true,
            'message' => 'get info project for editing successful',
            'data' => $data,
        ]);
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
        return redirect()->route('project_user.index')->with('message', __('messages.project_user_destroy'));
    }

    /**
     * @param AssignRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function assignUser(AssignRequest $request)
    {
        $date_unavailable = [];
        $flag = true;
        $error = [];
        $project = Project::findOrFail($request->project_id);
        $date_available = $this->createArrayDate($project->date_start, $project->date_finish);
        $date_assign = $this->createArrayDate($request->date_join, $request->date_leave);

        $date_assigned = $project->users()->select('date_start', 'date_finish')
            ->where([
                ['user_id', '=', $request->user_id],
                ['date_start', '!=', 'null']
            ])
            ->orderBy('date_start')
            ->get();

        for ($i = 0; $i < sizeof($date_assigned); $i++) {
            $start = new DateTime($date_assigned[$i]['date_start']);
            $finish = new DateTime($date_assigned[$i]['date_finish']);
            $size_date = $start->diff($finish)->days + 1;
            $offset = array_search($date_assigned[$i]['date_start'], $date_available);

            $split_date_assigned = array_splice($date_available, $offset, $size_date);
            for ($j = 0; $j < sizeof($split_date_assigned); $j++) {
                array_push($date_unavailable, $split_date_assigned[$j]);
            }
        }

        for ($i = 0; $i < sizeof($date_assign); $i++) {
            if (in_array($date_assign[$i], $date_unavailable)) {
                $flag = false;
                $error[] = $date_assign[$i];
                break;
            }
        }

        if ($flag) {
            $project->users()->attach($request->user_id, [
                'date_start' => $request->date_join,
                'date_finish' => $request->date_leave,
            ]);
            $data = [
                'project_start' => $project->date_start,
                'project_finish' => $project->date_finish
            ];
            return response()->json([
                'success' => true,
                'message' => 'user assign to project successful',
                'data' => $data,
            ]);
        } else {
            $data = [
                'error' => $error,
            ];
            return response()->json([
                'success' => false,
                'message' => 'error assign new date for user',
                'data' => $data,
            ]);
        }
    }

    public function createArrayDate($fromDate, $toDate)
    {
        $arr_date = [];
        $from_date = new DateTime($fromDate);
        $to_date = new DateTime($toDate);
        for ($i = $from_date; $i <= $to_date; $i->modify('+1 day')) {
            $arr_date[] = $i->format("Y-m-d");
        }
        return $arr_date;
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

    public function getUserByProject($projectId)
    {
        if (is_numeric($projectId)) {
            $project_users = Project::with(['users' => function ($query) {
                $query->orderBy('name')->groupBy('users.id');
            }])->findOrFail($projectId);
            $data = [
                'project_users' => $project_users,
            ];
            return response()->json([
                'success' => true,
                'message' => 'get users by project successful',
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'error get users by project',
                'data' => '',
            ]);
        }
    }

    public function getProjectAssignByUser($projectId, $userId)
    {
        $user_assigned = Project::with(['users' => function ($query) use ($userId) {
            $query->select('user_id', 'name')
                ->orderBy('date_start')
                ->where('user_id', $userId);
        }])->findOrFail($projectId);
        $data = [
            'user_assigned' => $user_assigned
        ];
        return response()->json([
            'success' => true,
            'message' => 'get users by project successful',
            'data' => $data,
        ]);
    }
}
