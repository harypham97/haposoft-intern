<?php

namespace App\Http\Controllers\Client\Staff;

use App\Http\Requests\Client\Report\UpdateRequest;
use App\Http\Requests\Client\Report\StoreRequest;
use App\Models\Project;
use App\Models\Report;
use App\Http\Controllers\Controller;
use Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('client.staffs.reports.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $projects = Auth::user()->projects()->pluck('name', 'project_id');
        $data = [
            'projects' => $projects,
        ];
        return view('client.staffs.reports.create', $data);
    }

    /**
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        $arrTasksId = $request->check_box_task_id;
        $arrReportTasks = [];
        $inputReport = [
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
        ];
        $report = Report::create($inputReport);
        for ($i = 0; $i < sizeof($arrTasksId); $i++) {
            $arrReportTasks[] = [
                'task_id' => $arrTasksId[$i],
                'date' => $request->date,
                'time_start' => $request->time_start,
                'time_end' => $request->time_end,
            ];
        }
        $report->tasks()->attach($arrReportTasks);
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
        $reportTasks = Report::with('tasks')->findOrFail($id);
        $data = [
            'reportTasks' => $reportTasks,
        ];
        return view('client.staffs.reports.edit', $data);
    }

    /**
     * @param UpdateRequest $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(UpdateRequest $request, $id)
    {
        $report = Report::findOrFail($id);
        $report->update($request->all());
        $arrIdTask = $report->tasks()->get()
            ->pluck('id')
            ->toArray();
        for ($i = 0; $i < sizeof($arrIdTask); $i++) {
            $report->tasks()->updateExistingPivot($arrIdTask[$i], [
                'date' => $request->date,
                'time_start' => $request->time_start,
                'time_end' => $request->time_end,
            ]);
        }
        return view('client.staffs.reports.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
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
}
