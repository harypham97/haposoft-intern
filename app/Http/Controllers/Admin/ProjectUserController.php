<?php

namespace App\Http\Controllers\Admin;

use App\Model\Project;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::with('users:user_id,name')->orderByDesc('id')->paginate(Project::NUMBER_PER_PAGE);
        $list_projects = Project::all();
        $list_users = User::all();
        $data = [
            'data' => $projects,
            'list_projects' => $list_projects,
            'list_users' => $list_users,
        ];

        return view('admin.project_user.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $query = [];
        $project = Project::findOrFail($request->get('project_id'));
        $arrIdUser = json_decode($request->get('listIdUser'));

        for ($i = 0; $i < sizeof($arrIdUser); $i++) {
            $query[] = ['user_id' => $arrIdUser[$i]];
        }

        $data = [
            'success' => true,
            'message' => 'Your AJAX processed correctly',
        ];

        $project->users()->attach($query);
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
            $query->select('user_id', 'name')->distinct();
        }])->findOrFail($id);

        $data = [
            'project' => $project,
            'message' => 'Your AJAX processed correctly',
        ];
        return response()->json($data);
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


}
