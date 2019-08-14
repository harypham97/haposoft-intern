@extends('admin.layouts.default')
@section('title', 'Edit Projects')
@section('name_feature', 'Edit Projects')
@section('content')
    <div class="container-fluid">
        <div class="container mt-3">
            <form method="POST" action="{{route('projects.update',$project->id)}}">
                {{ csrf_field() }}
                {{ method_field('PUT')}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="labelName">Name:</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="inputName" placeholder="Name project" name="name" value="{{$project->name}}">
                        @error('name')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="labelCustomer">Customer:</label>
                        <select id="inputCustomer" class="form-control @error('customer_id') is-invalid @enderror"
                                name="customer_id">
                            @foreach($customers as $customer)
                                @if($customer->id == $project->customer_id)
                                    {
                                    <option value="{{$customer->id}} " selected>{{$customer->name}}</option>
                                    }
                                @else
                                    <option value="{{$customer->id}}">{{$customer->name}}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('customer_id')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputDateStart">Date start:</label>
                        <input type="date" class="form-control @error('date_start') is-invalid @enderror"
                               id="inputDateStart" name="date_start" value="{{$project->date_start}}">
                        @error('date_start')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputDateFinish">Date finish:</label>
                        <input type="date" class="form-control @error('date_finish') is-invalid @enderror"
                               id="inputDateFinish" name="date_finish" value="{{$project->date_finish}}">
                        @error('date_finish')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </form>
        </div>
    </div>
@endsection
