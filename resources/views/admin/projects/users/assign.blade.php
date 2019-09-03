@extends('admin.layouts.default')
@section('title', 'Assign project to users')
@section('name_feature', 'Assign project to users')
@section('content')
    <div class="container-fluid">
        @if (Session::has('message'))
            <p class="text-danger">{{ Session::get('message') }}</p>
        @endif
        <div class="container">
            <form id="formAssign" action="{{route('project_user.assign_user')}}">
                <div class="form-group col-md-6 mt-3">
                    <label for="inputProject">Choose project:</label>
                    <input type="hidden" id="urlGetUserByProject"
                           value="{{ route('project_user.get_user_by_project','projectId') }}">
                    <input type="hidden" id="urlGetProjectAssignByUser"
                           value="{{ route('project_user.get_project_assign_by_user',['projectId','userId']) }}">
                    <select id="inputProjectAssign" class="form-control" name="project_id">
                        <option>---Choose project---</option>
                        @foreach( $projects as $project)
                            <option value="{{$project->id}}">{{$project->name}}</option>
                        @endforeach
                    </select>
                </div>
                <br>
                <div class="d-flex">
                    <div class="form-group col-4">
                        <label for="inputUser">User:</label>
                        <select id="inputSelectUser" class="form-control" name="user_id">
                        </select>
                    </div>
                    <div class="form-group col-4">
                        <label for="inputDateJoin">Date join:</label>
                        <input type="date" class="form-control" id="inputDateJoin" name="date_join">
                    </div>
                    <div class="form-group col-4">
                        <label for="inputDateLeave">Date leave:</label>
                        <input type="date" class="form-control" id="inputDateLeave" name="date_leave">
                    </div>
                </div>
                <div class="form-group col-8">
                    <button class="btn btn-primary mt-2" id="btnAssign">Assign</button>
                    <span class="d-block mt-3" id="errorAssign"></span>
                </div>
            </form>
        </div>
        <input type="hidden" id="urlDeleteAssignment" value="{{ route('project_user.delete_assignment',['projectId','userId','dateJoin','dateLeave']) }}">
        <br><br>
        <table class="table table-bordered table-hover" id="tableAssign">
            <thead>
            <tr>
                <th>Date start</th>
                <th>Date finish</th>
                <th>User name</th>
                <th>Date join</th>
                <th>Date leave</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
@endsection
