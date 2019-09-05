<?php

namespace App\Http\Controllers\Client\Staff;

use App\Models\Task;
use Auth;
use App\Models\User;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staff = User::with('projects')->findOrFail(Auth::id());
        $data = [
            'staff' => $staff
        ];
        return view('client.staffs.project.index', $data);
    }

    public function getTaskAssigned($staffId){
        $tasks = Task::with('project')->where('user_id',$staffId)->get();
        $data = [
            'tasks' => $tasks
        ];
        return response()->json([
            'success' => true,
            'message' => 'get tasks assigned by staff successfully',
            'data' => $data,
        ]);
    }
}
