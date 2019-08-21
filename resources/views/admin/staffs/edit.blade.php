@extends('admin.layouts.default')
@section('title', 'Update Staff')
@section('name_feature', 'Update Staff')
@section('content')
    <div class="container-fluid">
        <div class="container mt-3">
            <form method="POST" action="{{route('staffs.update',[$user->id])}}" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT')}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail">Email:</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="inputEmail" placeholder="Email" name="email" value="{{$user->email}}">
                        @error('email')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputName">Name:</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="inputName" placeholder="Name" name="name" value="{{$user->name}}">
                        @error('name')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputDOB">Date of birth:</label>
                        <input type="date" class="form-control @error('dob') is-invalid @enderror"
                               id="inputDOB" placeholder="Date..." name="dob" value="{{$user->dob}}">
                        @error('dob')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputPhone">Phone:</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                               id="inputPhone" name="phone" value="{{$user->phone}}">
                        @error('phone')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputCity">City:</label>
                        <input type="text" class="form-control @error('city') is-invalid @enderror"
                               id="inputCity" name="city" value="{{$user->city}}">
                        @error('city')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputDept">Department:</label>
                        <select id="inputDept" class="form-control @error('department_id') is-invalid @enderror"
                                name="department_id">
                            @foreach($departments as $department)
                                @if($department->id == $user->department_id)
                                    {
                                    <option value="{{$department->id}} " selected>{{$department->name}}</option>
                                    }
                                @else
                                    <option value="{{$department->id}}">{{$department->name}}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('department_id')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <label for="image">Upload avatar:</label>
                        <input type="file" name="avatar"
                               class="form-control-file @error('avatar') is-invalid @enderror">
                        @error('avatar')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </form>
        </div>
    </div>
@endsection
