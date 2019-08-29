<?php

namespace App\Http\Controllers\Admin\Project;

use App\Http\Requests\Admin\Project\AssignRequest;
use App\Http\Requests\ProjectUserRequest;
use App\Models\Department;
use App\Models\Project;
use App\Models\User;
use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tableProjects = Project::with(['users' => function ($query) {
            $query->select('user_id', 'name');
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
     * @param ProjectUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
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

        if (count($checkExist) == 0) {
            for ($i = 0; $i < count($arrUserId); $i++) {
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
     * @param $projectId
     * @param $userId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteUserInProject($projectId, $userId)
    {
        $project = Project::findOrFail($projectId);
        $project->users()->detach($userId);
        return response()->json([
            'success' => true,
            'message' => 'bla bla',
            'data' => $projectId,
            'user' => $userId
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showListAssign()
    {
        $projects = Project::all()->sortBy('name');
        $data = [
            'projects' => $projects,
        ];
        return view('admin.project_user.assign', $data);
    }

    /**
     * @param AssignRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function assignUser(AssignRequest $request)
    {
        $arrSaveDateAssigned = [];
        $dateUnavailable = [];
        $flag = true;
        $error = [];
        $project = Project::findOrFail($request->project_id);
        $dateProject = $this->createArrayDate($project->date_start, $project->date_finish);
        $dateAssign = $this->createArrayDate($request->date_join, $request->date_leave);
        $dateAssigned = $project->users()->select('date_start', 'date_finish')
            ->where([
                ['user_id', $request->user_id],
                ['date_start', '!=', 'null']
            ])
            ->orderBy('date_start')
            ->get();

        for ($i = 0; $i < count($dateAssigned); $i++) {
            $arrSaveDateAssigned[] = $this->createArrayDate($dateAssigned[$i]['date_start'], $dateAssigned[$i]['date_finish']);
        }
        if (!empty($arrSaveDateAssigned))
            $dateUnavailable = call_user_func_array("array_merge", $arrSaveDateAssigned);

        if ($this->checkDateAssignInRangeProject($dateAssign, $dateProject)) {
            for ($i = 0; $i < count($dateAssign); $i++) {
                if (in_array($dateAssign[$i], $dateUnavailable)) {
                    $flag = false;
                    $error[] = $dateAssign[$i];
                    break;
                }
            }
        } else {
            $flag = false;
            $error[] = 'Date assign out of time\'s project';
        }

        if ($flag) {
            $project->users()->attach($request->user_id, [
                'date_start' => $request->date_join,
                'date_finish' => $request->date_leave,
            ]);
            $data = [
                'project_start' => $project->date_start,
                'project_finish' => $project->date_finish,
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

    /**
     * @param $fromDate
     * @param $toDate
     * @return array
     */
    public function createArrayDate($fromDate, $toDate)
    {
        $arrDate = [];
        $fromDate = new DateTime($fromDate);
        $toDate = new DateTime($toDate);
        for ($i = $fromDate; $i <= $toDate; $i->modify('+1 day')) {
            $arrDate[] = $i->format("Y-m-d");
        }
        return $arrDate;
    }

    /**
     * @param array $dateAssign
     * @param array $dateProject
     * @return bool
     */
    public function checkDateAssignInRangeProject(array $dateAssign, array $dateProject)
    {
        $check = false;
        if ($dateAssign[0] >= $dateProject[0] && $dateAssign[count($dateAssign) - 1] <= $dateProject[count($dateProject) - 1])
            $check = true;
        return $check;
    }

    public function getUserByDepartment($departmentId)
    {
        $data = [];
        if (is_numeric($departmentId)) {
            if ($departmentId > -1) {
                $dept = Department::with('users')->findOrFail($departmentId);
                $data = [
                    'department' => $dept,
                ];
            } else {
                $users = User::all()->sortBy('name');
                $data = [
                    'users' => $users,
                    'department_id' => $departmentId
                ];
            }
        }
        return response()->json([
            'success' => true,
            'message' => 'get user by department successful',
            'data' => $data,
        ]);
    }

    public function getUserByProject($projectId)
    {
        if (is_numeric($projectId)) {
            $projectUsers = Project::with(['users' => function ($query) {
                $query->orderBy('name')->groupBy('users.id');
            }])->findOrFail($projectId);
            $data = [
                'project_users' => $projectUsers,
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
        $userAssigned = Project::with(['users' => function ($query) use ($userId) {
            $query->select('user_id', 'name')
                ->orderBy('date_start')
                ->where('user_id', $userId);
        }])->findOrFail($projectId);
        $data = [
            'user_assigned' => $userAssigned
        ];
        return response()->json([
            'success' => true,
            'message' => 'get users by project successful',
            'data' => $data,
        ]);
    }
}
