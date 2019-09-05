<?php

namespace App\Http\Controllers\Client\Customer;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StaffController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $departments = Department::all()->sortBy('name')->pluck('name', 'id');
        $departmentId = $request->department_id;
        $name = $request->name;
        $email = $request->email;
        $whereClause = [
            ['name', 'like', "%$name%"],
            ['email', 'like', "%$email%"],
        ];
        $data = [
            'departments' => $departments
        ];

        if ($departmentId > -1) {
            $whereClause[] = ['department_id', $departmentId];
        }
        $data['staffs'] = User::with('department:id,name')->where($whereClause)->paginate(config('variables.number_per_page'));
        if ($request->has(['department_id', 'name', 'email'])) {
            $data['department_id_chose'] = $departmentId;
            $data['name'] = $name;
            $data['email'] = $email;
            return view('client.customers.staffs.search', $data);
        }
        return view('client.customers.staffs.index', $data);
    }
}
