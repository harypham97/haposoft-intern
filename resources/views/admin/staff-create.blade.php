@extends('admin.layouts.default')
@section('title', 'Create Staffs')
@section('content')
    <div class="container-fluid">
        <div class="container mt-3">
            <form method="POST" action="{{route('staffs.store')}}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Email:</label>
                        <input type="email" class="form-control" id="inputEmail4" placeholder="Email" name="email">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Password:</label>
                        <input type="password" class="form-control" id="inputPassword4" placeholder="Password"
                               name="password">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputName">Name:</label>
                        <input type="text" class="form-control" id="inputName" placeholder="Name" name="name">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputDOB">Date of birth:</label>
                        <input type="date" class="form-control" id="inputDOB" placeholder="Date..." name="dob">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputPhone">Phone:</label>
                        <input type="text" class="form-control" id="inputPhone" name="phone">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputCity">City:</label>
                        <input type="text" class="form-control" id="inputCity" name="city">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputDept">Department:</label>
                        <select id="inputDept" class="form-control" name="department_id">
                            @foreach($data as $department)
                                <option value="{{$department->id}}">{{$department->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="image">Upload avatar:</label>
                        <input type="file" name="avatar" class="form-control-file">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
@endsection
