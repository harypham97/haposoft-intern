<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Customer\StoreRequest;
use App\Http\Requests\Admin\Customer\UpdateRequest;
use App\Models\Customer;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::orderBy('id', 'desc')->paginate(config('variables.number_per_page'));
        $data = [
            'customers' => $customers,
        ];
        return view('admin.customers.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * @param StoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        $path = null;
        $input = $request->except('avatar', '_method');
        if ($request->hasFile('avatar')) {
            $path = $request->avatar->store('images', ['disk' => 'public']);
            $input['avatar'] = $path;
        }
        $input['password'] = \Hash::make($request->password);
        Customer::create($input);
        return redirect()->route('customers.index')->with('message', __('messages.customer_create'));
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
        $customer = Customer::findOrFail($id);
        $data = [
            'customer' => $customer,
        ];
        return view('admin.customers.edit', $data);
    }

    /**
     * @param UpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, $id)
    {
        $path = null;
        $input = $request->except('avatar', '_method', '_token');
        $customer = Customer::findOrFail($id);

        if ($request->hasFile('avatar')) {
            Storage::disk('public')->delete('/' . $customer->avatar);
            $path = $request->avatar->store('images', ['disk' => 'public']);
            $input['avatar'] = $path;
        }
        $customer->update($input);
        return redirect()->route('customers.index')->with('message', __('messages.customer_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->projects()->delete();
        $customer->delete();
        return redirect()->route('customers.index')->with('message', __('messages.customer_delete'));
    }
}
