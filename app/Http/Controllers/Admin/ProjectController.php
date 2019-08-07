<?php

namespace App\Http\Controllers\Admin;

use App\Model\Customer;
use App\Model\Project;
use App\Model\User;
use Illuminate\Http\Request;
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
        $projects = Project::paginate(Project::NUMBER_PER_PAGE);
        foreach ($projects as $project) {
            $customer_name = $project->customer()->firstOrFail()->name;
            $project['customer_name'] = $customer_name;
            $users = $project->users()->get();
            $user_name = array();
            foreach ($users as $user) {
                array_push($user_name, $user->name);
            }
            $project['user_name'] = $user_name;
        }
        $data = ['data' => $projects];
        return view('admin.project-index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::all();
        $data = ['data' => $customers];
        return view('admin.project-create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Project::create($request->all());
        return redirect('/admin/projects')->with('message', __('messages.user_create'));
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
        Project::findOrFail($id)->delete();
        return redirect('/admin/projects')->with('message', __('messages.user_destroy'));
    }
}
