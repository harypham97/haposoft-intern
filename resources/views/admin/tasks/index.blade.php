@extends('admin.layouts.default')
@section('title', 'Tasks')
@section('name_feature', 'List Tasks')
@section('content')
    <div class="container-fluid">
        <form method="GET" action="{{route('tasks.create')}}">
            <button class="btn btn-primary mt-3 mb-3"> Add new tasks</button>
        </form>
        @if (Session::has('message'))
            <p class="text-danger">{{ Session::get('message') }}</p>
        @endif
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Task name</th>
                <th>Hour</th>
                <th>Project</th>
                <th>User</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tasks as $task)
                <tr>
                    <th>{{$task->id}}</th>
                    <td>{{$task->name}}</td>
                    <td>{{$task->hour}}</td>

                    <td>{{!empty($task->project)? $task->project->name : ''}}</td>
                    <td>{{!empty($task->user)? $task->user->name : ''}}</td>
                    <td class="d-flex">
                        <button class="btn btn-outline-primary btnInfoModal" id="{{$task->id}}" title="View">
                            <i class="fa fa-fw fa-search"></i>
                        </button>
                        <a class="btn btn-outline-warning ml-3 mr-3" id="{{$task->id}}" title="Edit"
                           href="{{route('staffs.edit',$task->id)}}">
                            <i class="fa fa-fw fa-edit"></i>
                        </a>
                        <form method="POST" action="{{ route('staffs.destroy', [$task->id]) }}">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button class="btn btn-outline-danger" type="submit" title="Delete"
                                    onclick="return confirm('Are you sure you want to delete the record of {{ $task->name }} ?')">
                                <i class="fa fa-fw fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $tasks->links('pagination::bootstrap-4') }}
    </div>
@endsection
