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
        $staffs = User::with('department:id,name')->paginate(config('variables.number_per_page'));
        $departments = Department::all()->sortBy('name')->pluck('name', 'id');
        if ($request->has(['department_id', 'name', 'email'])) {
            $department_id = $request->department_id;
            $name = $request->name;
            $email = $request->email;
            if (is_numeric($department_id)) {
                if ($name == null && $email == null) {
                    $staffs = User::with('department:id,name')
                        ->where('department_id', $department_id)
                        ->get();
                } elseif ($name != null && $email == null) {
                    $staffs = User::with('department:id,name')
                        ->where([
                            ['department_id', $department_id],
                            ['name', 'like', "%$name%"]
                        ])
                        ->get();
                } elseif ($name == null && $email != null) {
                    $staffs = User::with('department:id,name')
                        ->where([
                            ['department_id', $department_id],
                            ['email', 'like', "%$email%"]
                        ])
                        ->get();
                } else {
                    $staffs = User::with('department:id,name')
                        ->where([
                            ['department_id', $department_id],
                            ['name', 'like', "%$name%"],
                            ['email', 'like', "%$email%"]
                        ])
                        ->get();
                }
            } else {
                if ($name != null && $email == null) {
                    $staffs = User::with('department:id,name')
                        ->where([
                            ['name', 'like', "%$name%"]
                        ])
                        ->get();
                } elseif ($name == null && $email != null) {
                    $staffs = User::with('department:id,name')
                        ->where([
                            ['email', 'like', "%$email%"]
                        ])
                        ->get();
                } elseif ($name == !null && $email != null) {
                    $staffs = User::with('department:id,name')
                        ->where([
                            ['name', 'like', "%$name%"],
                            ['email', 'like', "%$email%"]
                        ])
                        ->get();
                }
            }
            $data = [
                'staffs' => $staffs,
                'departments' => $departments,
                'department_id_chose' => $department_id,
                'name' => $name,
                'email' => $email,
            ];
            return view('client.customers.staffs.search', $data);
        } else {
            $data = [
                'staffs' => $staffs,
                'departments' => $departments
            ];
            return view('client.customers.staffs.index', $data);
        }
    }
}
