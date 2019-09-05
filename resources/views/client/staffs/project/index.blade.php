@extends('client.layouts.default')
@section('title', trans('view.titles.staff_project_index'))
@section('name_feature', trans('view.titles.staff_project_index'))
@section('content')
    <div class="container-fluid">
        <ul class="nav nav-tabs">
            <li class="nav-item ">
                <a class="nav-link active" href="#" id="projectJoined">Project</a>
            </li>
            <li class="nav-item">
                <input id="urlGetTasksAssignedByStaff" type="hidden"
                       value="{{ route('client.staffs.get_all_task_assigned_by_staff',auth()->user()->id) }}">
                <a class="nav-link" href="#" id="taskAssigned">Task assigned</a>
            </li>
        </ul>
        <br>
        <table class="table table-bordered table-hover" id="tableProjectJoin">
            <thead>
            <tr>
                <th>No.</th>
                <th class="w-20">Project 's name</th>
                <th class="w-50">Description</th>
                <th>Date start</th>
                <th>Date finish</th>
            </tr>
            </thead>
            <tbody>
            @foreach($staff->projects as $key=>$project)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->description }}</td>
                    <td>{{ $project->date_start }}</td>
                    <td>{{ $project->date_finish }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <table class="table table-bordered table-hover d-none" id="tableTaskAssigned">
            <thead>
            <tr>
                <th>No.</th>
                <th class="w-20">Project's name</th>
                <th class="w-50">Task's name</th>
                <th>Hour</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
@endsection
