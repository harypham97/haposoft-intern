<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::with('user', 'project')->orderByDesc('id')->paginate(config('variables.number_per_page'));
        $data = [
            'tasks' => $tasks
        ];
        return view('admin.tasks.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = Project::with('users')->orderBy('name')->get();
        $data = [
            'projects' => $projects
        ];
        return view('admin.tasks.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Task::create($request->all());
        $data = [
            'data' => $request->all(),
        ];
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        Task::findOrFail($id)->delete();
        $data = [
            'message' => 'Task deleted successful!'
        ];
        return response()->json($data);
    }

    public function getTaskByProjectId($projectId)
    {
        if (is_numeric($projectId)) {
            $project = Project::findOrFail($projectId);
            $users = $project->users()->groupBy('id')->orderBy('name')->get();
            $tasks = $project->tasks()->get();

            $data = [
                'tasks' => $tasks,
                'users' => $users,
            ];
            return response()->json($data);
        }
    }
}
