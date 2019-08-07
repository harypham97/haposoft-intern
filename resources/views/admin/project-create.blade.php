@extends('admin.layouts.default')
@section('title', 'Create Projects')
@section('content')
    <div class="container-fluid">
        <div class="container mt-3">
            <form method="POST" action="{{route('projects.store')}}">
                {{ csrf_field() }}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputName">Name:</label>
                        <input type="text" class="form-control" id="inputName" placeholder="Name project" name="name">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputCustomer">Customer:</label>
                        <select id="inputCustomer" class="form-control" name="customer_id">
                            @foreach($data as $customer)
                                <option value="{{$customer->id}}">{{$customer->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="dateStart">Date start:</label>
                        <input type="date" class="form-control" id="dateStart" placeholder="Date..." name="date_start">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="dateFinish">Date finish:</label>
                        <input type="date" class="form-control" id="dateFish" placeholder="Date..." name="date_finish">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
@endsection
