<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StaffRequest;
use App\Models\Department;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(config('variables.number_per_page'));
        $data = ['data' => $users];
        return view('admin.staffs.index', $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $department = Department::all()->sortBy('name');
        $data = ['data' => $department];
        return view('admin.staffs.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StaffRequest $request)
    {
        $path = null;
        $input = $request->except('avatar', '_method');
        if ($request->hasFile('avatar')) {
            $path = $request->avatar->store('images', ['disk' => 'public']);
            $input['avatar'] = $path;
        }
        $input['password'] = \Hash::make($request->password);
        $input['role_id'] = config('auth.role_user.staff');
        User::create($input);
        return redirect()->route('staffs.index')->with('message', __('messages.staff_create'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $deptName = User::find($id)->department()->name;
        $user['dept_name'] = $deptName;
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $departments = Department::all()->sortBy('name');
        $data = [
            'user' => $user,
            'departments' => $departments
        ];
        return view('admin.staffs.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StaffRequest $request, $id)
    {
        $path = null;
        $input = $request->except('avatar', '_method', '_token');
        $user = User::findOrFail($id);

        if ($request->hasFile('avatar')) {
            Storage::disk('public')->delete('/' . $user->avatar);
            $path = $request->avatar->store('images', ['disk' => 'public']);
            $input['avatar'] = $path;
        }
        $user->update($input);
        return redirect()->route('staffs.index')->with('message', __('messages.staff_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('staffs.index')->with('message', __('messages.staff_destroy'));
    }
}
