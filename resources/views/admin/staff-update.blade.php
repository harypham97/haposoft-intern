@extends('admin.layouts.default')
@section('title', 'Update Staff')
@section('content')
    <div class="container-fluid">
        <div class="container mt-3">
            <form method="POST" action="{{route('staffs.update',$data['user']->id)}}" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT')}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputName">Name:</label>
                        <input type="text" class="form-control" id="inputName" placeholder="Name" name="name"
                               value="{{$data['user']->name}}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputDOB">Date of birth:</label>
                        <input type="date" class="form-control" id="inputDOB" placeholder="Date..." name="dob"
                               value="{{$data['user']->dob}}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputPhone">Phone:</label>
                        <input type="text" class="form-control" id="inputPhone" name="phone"
                               value="{{$data['user']->phone}}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputCity">City:</label>
                        <input type="text" class="form-control" id="inputCity" name="city"
                               value="{{$data['user']->city}}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputDept">Department:</label>
                        <select id="inputDept" class="form-control" name="department_id">
                            @foreach($data['departments'] as $department)
                                @if($department->id == $data['user']->department_id)
                                    {
                                    <option value="{{$department->id}} " selected>{{$department->name}}</option>
                                    }
                                @else
                                    <option value="{{$department->id}}">{{$department->name}}</option>
                                @endif
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
