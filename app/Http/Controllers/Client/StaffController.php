<?php

namespace App\Http\Controllers\Client;

use App\Models\Project;
use App\Models\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeReport(Request $request)
    {
        $arr_tasks = $request->checkBoxTaskId;
        $query = [];
        $input_report = [
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
        ];
        $report = Report::create($input_report);

        for ($i = 0; $i < sizeof($arr_tasks); $i++) {
            $query[] = [
                'task_id' => $arr_tasks[$i],
                'date' => $request->date,
                'time_start' => $request->time_start,
                'time_end' => $request->time_end,
            ];
        }
        $report->tasks()->attach($query);
        $data = [
            'message' => 'report saved',
            'success' => true,
            'report_id' => $report->id,
        ];
        return response()->json($data);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editReport($id)
    {
        $report_tasks = Report::with('tasks')->findOrFail($id);
        $data = [
            'report_tasks' => $report_tasks,
        ];
        return view('client.staffs.reports.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function updateReport(Request $request, $id)
    {
        $report = Report::findOrFail($id);
        $report->update($request->all());
        $arr_id_task = $report->tasks()->get()
            ->pluck('id')
            ->toArray();
        for ($i = 0; $i < sizeof($arr_id_task); $i++) {
            $report->tasks()->updateExistingPivot($arr_id_task[$i], [
                'date' => $request->date,
                'time_start' => $request->time_start,
                'time_end' => $request->time_end,
            ]);
        }
        return view('client.staffs.reports.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createReport()
    {
        $projects = Auth::user()->projects()->pluck('name', 'project_id');
        $data = [
            'projects' => $projects,
        ];
        return view('client.staffs.reports.create', $data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showReport()
    {
        return view('client.staffs.reports.index');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyReport($id)
    {
        $report = Report::findOrFail($id);
        $report->tasks()->detach();
        $report->delete();
        $data = [
            'message' => 'report deleted',
            'success' => true,
        ];
        return response()->json($data);
    }

    /**
     * @param $projectId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTasksByProject($projectId)
    {
        if (is_numeric($projectId)) {
            $project = Project::select('id', 'name')->findOrFail($projectId);
            $tasks = $project->tasks()->get();
            $data = [
                'message' => 'get info report, tasks by project',
                'success' => true,
                'project' => $project,
                'tasks' => $tasks,
            ];
        } else {
            $data = [
                'message' => 'error get info report',
                'success' => false,
            ];
        }
        return response()->json($data);
    }

    /**
     * @param $fromDate
     * @param $toDate
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchReportByDate($fromDate, $toDate)
    {
        $reports = Auth::user()->reports()
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->get();
        $data = [
            'message' => 'report search successful',
            'success' => true,
            'reports' => $reports,
        ];
        return response()->json($data);
    }
}
