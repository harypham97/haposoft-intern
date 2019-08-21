@extends('admin.layouts.default')
@section('title', 'Create new Staff')
@section('name_feature', 'Create new Staff')
@section('content')
    <div class="container-fluid">
        <div class="container mt-3">
            <form method="POST" action="{{route('staffs.store')}}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail">Email:</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="inputEmail" placeholder="Email" name="email" value="{{old('email')}}">
                        @error('email')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Password:</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="inputPassword" placeholder="Password" name="password">
                        @error('password')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputName">Name:</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="inputName" placeholder="Name" name="name" value="{{old('name')}}">
                        @error('name')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputDOB">Date of birth:</label>
                        <input type="date" class="form-control @error('dob') is-invalid @enderror"
                               id="inputDOB" name="dob" value="{{old('dob')}}">
                        @error('dob')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputPhone">Phone:</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                               id="inputPhone" name="phone" placeholder="Phone number" value="{{old('phone')}}">
                        @error('phone')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputCity">City:</label>
                        <input type="text" class="form-control @error('city') is-invalid @enderror"
                               id="inputCity" name="city" placeholder="City" value="{{old('city')}}">
                        @error('city')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputDept">Department:</label>
                        <select id="inputDept" class="form-control @error('department_id') is-invalid @enderror"
                                name="department_id">
                            <option selected> ---Choose Department---</option>
                            @foreach($data as $department)
                                <option value="{{$department->id}}" {{(old('department_id')==$department->id)? 'selected':''}}>{{$department->name}}</option>
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
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
@endsection
