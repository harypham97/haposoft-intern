@extends('admin.layouts.default')
@section('title', 'Create Projects')
@section('name_feature', 'Create new Project')
@section('content')
    <div class="container-fluid">
        <div class="container mt-3">
            <form method="POST" action="{{route('projects.store')}}">
                {{ csrf_field() }}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputName">Name:</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="inputName" placeholder="Name project" name="name" value="{{old('name')}}">
                        @error('name')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputCustomer">Customer:</label>
                        <select id="inputCustomer" class="form-control @error('customer_id') is-invalid @enderror" name="customer_id">
                            <option>----Choose customer---</option>
                            @foreach($data as $customer)
                                <option value="{{$customer->id}}" {{(old('customer_id')==$customer->id)? 'selected':''}}>{{$customer->name}}</option>
                            @endforeach
                        </select>
                        @error('customer_id')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="dateStart">Date start:</label>
                        <input type="date" class="form-control @error('date_start') is-invalid @enderror" id="dateStart"  name="date_start" value="{{old('date_start')}}">
                        @error('date_start')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="dateFinish">Date finish:</label>
                        <input type="date" class="form-control @error('date_finish') is-invalid @enderror" id="dateFish"  name="date_finish" value="{{old('date_finish')}}">
                        @error('date_finish')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
@endsection
