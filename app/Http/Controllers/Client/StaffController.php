<?php

namespace App\Http\Controllers\Client;

use App\Models\Project;
use App\Models\Report;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Carbon\Carbon;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('client.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeReport(Request $request)
    {
        $input_report = [
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
        ];
        $date_start = Carbon::now()->toDateTimeString();
        $report = Report::create($input_report);
        $report->tasks()->attach($request->task_id, [
            'date_start' => $date_start,
            'date_finish' => Carbon::parse($date_start)->addHours($request->hour),
        ]);
        $data = [
            'message' => 'bla bla',
            'success' => true,
        ];
        return response()->json($data);
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
        //
    }

    public function showReport()
    {
        $projects = Auth::user()->projects()->pluck('name', 'project_id');
        $data = [
            'projects' => $projects,
        ];
        return view('client.staffs.reports.index', $data);
    }

    public function getReportTaskByProject($projectId)
    {
        $project = Project::select('id', 'name')->findOrFail($projectId);
        $task_report = Task::with(['reports' => function ($query) {
            $query->select('report_id', 'reports.name', 'reports.created_at')->whereDate('reports.created_at', Carbon::today()->toDateString());
        }])->where('project_id', $projectId)
            ->select('id', 'name')
            ->get();
        $data = [
            'message' => 'bla bla',
            'success' => true,
            'project' => $project,
            'task_report' => $task_report,
        ];
        return response()->json($data);
    }
}
