<?php

namespace App\Http\Controllers\Client\Customer;

use App\Models\Project;
use Auth;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('users')->where('customer_id', Auth::id())->get();
        $data = [
            'projects' => $projects
        ];
        return view('client.customers.project.index', $data);
    }
}
