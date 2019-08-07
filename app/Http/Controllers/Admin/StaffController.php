<?php

namespace App\Http\Controllers\Admin;

use App\Model\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\User;
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
        $users = User::paginate(User::NUMBER_PER_PAGE);
        $data = ['data' => $users];
        return view('admin.staff-index', $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $department = Department::all();
        $data = ['data' => $department];
        return view('admin.staff-create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $path = null;
        $input = $request->except('avatar', '_method');
        if ($request->hasFile('avatar')) {
            $path = $request->avatar->store('images', ['disk' => 'public']);
            $input['avatar'] = $path;
        }
        $input['password'] = \Hash::make($request->get('password'));
        $input['role_id'] = User::ROLE_USER;
        User::create($input);
        return redirect('/admin/staffs')->with('message', __('messages.user_create'));
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
        $dept_name = User::find($id)->department()->firstOrFail()->name;
        $user['dept_name'] = $dept_name;
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
        $departments = Department::all();
        $data = ['user' => $user, 'departments' => $departments];
        return view('admin.staff-update', compact('data'));
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
        $path = null;
        $input = $request->except('avatar', '_method', '_token');
        $user = User::findOrFail($id);

        if ($request->hasFile('avatar')) {
            Storage::disk('public')->delete('/' . $user->avatar);
            $path = $request->avatar->store('images', ['disk' => 'public']);
            $input['avatar'] = $path;
        }
        $user->update($input);
        return redirect('/admin/staffs')->with('message', __('messages.user_update'));
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
        return redirect('/admin/staffs')->with('message', __('messages.user_destroy'));
    }
}
