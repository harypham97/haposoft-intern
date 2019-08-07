@extends('admin.layouts.default')
@section('title', 'Staffs')
@section('content')
    <div class="container-fluid">
        <form method="GET" action="{{route('projects.create')}}">
            <button class="btn btn-primary mt-3 mb-3" style="cursor:pointer"> Add new project</button>
        </form>
        <form action="{{route('project-user.create')}}" method="get">
            <button class="btn btn-danger" type="submit"> add user for project</button>
        </form>

        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Project name</th>
                <th>Customer</th>
                <th>Users</th>
                <th>Date start</th>
                <th>Date finish</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $project)
                <tr>
                    <th>{{$project->id}}</th>
                    <td>{{$project->name}}</td>
                    <td>{{$project->customer_name}}</td>
                    <td>
                        @for($i = 0; $i< sizeof($project->user_name);$i++ )
                            {{$project->user_name[$i] .' && ' }}
                        @endfor
                    </td>
                    <th>{{$project->date_start}}</th>
                    <th>{{$project->date_finish}}</th>
                    <td class="d-flex">
                        <button class="btn btn-outline-primary btnInfoModal" id="{{$project->id}}" title="Edit">
                            <i class="fa fa-fw fa-search"></i>
                        </button>
                        <form method="POST" action="{{ route('projects.destroy', [$project->id]) }}">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button class="btn btn-outline-danger" type="submit" title="Delete"
                                    onclick="return confirm('Are you sure you want to delete the record {{ $project->id }} ?')">
                                <i class="fa fa-fw fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $data->links('pagination::bootstrap-4') }}
    </div>
@endsection
