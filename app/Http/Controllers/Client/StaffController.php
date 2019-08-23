<?php

namespace App\Http\Controllers\Client;

use App\Http\Requests\Client\Report\UpdateRequest;
use App\Http\Requests\Client\Report\StoreRequest;
use App\Models\Project;
use App\Models\Report;
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
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeReport(StoreRequest $request)
    {
        $arr_tasks_id = $request->check_box_task_id;
        $arr_report_tasks = [];
        $input_report = [
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
        ];
        $report = Report::create($input_report);
        for ($i = 0; $i < sizeof($arr_tasks_id); $i++) {
            $arr_report_tasks[] = [
                'task_id' => $arr_tasks_id[$i],
                'date' => $request->date,
                'time_start' => $request->time_start,
                'time_end' => $request->time_end,
            ];
        }
        $report->tasks()->attach($arr_report_tasks);
        $data = [
            'report_id' => $report->id,
        ];
        return response()->json([
            'success' => true,
            'message' => 'report saved',
            'data' => $data
        ]);
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
     * @param UpdateRequest $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updateReport(UpdateRequest $request, $id)
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
        return response()->json([
            'success' => true,
            'message' => 'report deleted',
            'data' => '',
        ]);
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
                'project' => $project,
                'tasks' => $tasks,
            ];
            return response()->json([
                'success' => true,
                'message' => 'get info report, tasks by project',
                'data' => $data
            ]);
        } else {
            return response()->json([
                'success' => false,
                'status' => 404,
                'message' => 'error get info report',
                'data' => ''
            ]);
        }
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
            'reports' => $reports,
        ];
        return response()->json([
            'message' => 'report search successful',
            'success' => true,
            'data' => $data
        ]);
    }
}
