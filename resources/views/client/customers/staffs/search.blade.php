@extends('client.layouts.default')
@section('title', trans('view.titles.customer_staff_index'))
@section('name_feature', trans('view.titles.customer_staff_index'))
@section('content')
    <div class="container-fluid">
        <form method="GET" action="{{ route('client.customers.staffs.index') }}">
            <div class="d-flex col-8 mx-auto justify-content-center">
                <select id="department_id" class="form-control" name="department_id">
                    <option>Choose department</option>
                    @foreach($departments as $department_id => $department_name)
                        @if($department_id == $department_id_chose)
                            {
                            <option value="{{$department_id}} " selected>{{$department_name}}</option>
                            }
                        @else
                            <option value="{{$department_id}}">{{$department_name}}</option>
                        @endif
                    @endforeach
                </select>
                <input type="text" class="form-control col-3 mx-3 fontAwesome" name="name"
                       id="name" placeholder="&#xF002; name..." value="{{ $name }}">
                <input type="text" class="form-control col-3 mr-3 fontAwesome" name="email"
                       id="email" placeholder="&#xF002; email..." value="{{ $email }}">
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
            @if(count($staffs) > 0)
                @foreach($staffs as $key=>$staff)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $staff->name }}</td>
                        <td>{{ $staff->email }}</td>
                        <td>{{ $staff->department->name }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" class="text-center">---No data to display---</td>
                </tr>
            @endif
            </tbody>
        </table>
        @if( $staffs instanceof \Illuminate\Pagination\LengthAwarePaginator)
            {{ $staffs->links('pagination::bootstrap-4') }}
        @endif
    </div>
@endsection
