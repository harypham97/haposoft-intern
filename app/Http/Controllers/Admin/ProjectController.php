<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProjectResquest;
use App\Models\Customer;
use App\Models\Project;
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
        $projects = Project::with(['customer', 'users'])->orderByDesc('id')->paginate(config('variables.number_per_page'));
        $data = ['data' => $projects];
        return view('admin.projects.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::all()->sortBy('name');
        $data = ['data' => $customers];
        return view('admin.projects.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectResquest $request)
    {
        Project::create($request->all());
        return redirect('/admin/projects')->with('message', __('messages.project_create'));
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
        $project = Project::findOrFail($id);
        $customers = Customer::all()->sortBy('name');
        $data = [
            'project' => $project,
            'customers' => $customers
        ];
        return view('admin.projects.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectResquest $request, $id)
    {
        $project = Project::findOrFail($id);
        $project->update($request->all());
        return redirect('/admin/projects')->with('message', __('messages.project_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Project::findOrFail($id)->delete();
        return redirect('/admin/projects')->with('message', __('messages.project_destroy'));
    }

}
