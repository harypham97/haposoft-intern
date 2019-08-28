@extends('client.layouts.default')
@section('title', trans('view.titles.customer_staff_index'))
@section('name_feature', trans('view.titles.customer_staff_index'))
@section('content')
    <div class="container-fluid">
        <form method="GET" action="{{ route('client.customers.staffs.index') }}">
        <div class="d-flex col-8 mx-auto justify-content-center">
                <select id="department_id" class="form-control" name="department_id">
                    <option value="{{ config('variables.default_value_option') }}">Choose department</option>
                    @foreach($departments as $department_id => $department_name)
                        <option value="{{ $department_id }}">{{ $department_name }}</option>
                    @endforeach
                </select>
                <input type="text" class="form-control col-3 mx-3 fontAwesome" name="name" id="name"
                       placeholder="&#xF002; name...">
                <input type="text" class="form-control col-3 mr-3 fontAwesome" name="email" id="email"
                       placeholder="&#xF002; email...">
                <button class="btn btn-primary" type="submit">Search</button>
        </div>
        </form>
        <br>
        <table class="table table-bordered table-hover" id="tableCustomerStaff">
            <thead>
            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Department</th>
            </tr>
            </thead>
            <tbody>
            @foreach($staffs as $key=>$staff)
                <tr>
                    <th>{{ $key + 1 }}</th>
                    <td>{{ $staff->name }}</td>
                    <td>{{ $staff->email }}</td>
                    <td>{{ $staff->department->name }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $staffs->links('pagination::bootstrap-4') }}
    </div>
@endsection
