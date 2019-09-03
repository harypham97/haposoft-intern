@extends('admin.layouts.default')
@section('title', 'Projects')
@section('name_feature', 'List Projects')
@section('content')
    <div class="container-fluid">
        <form method="GET" action="{{ route('projects.create') }}">
            <button class="btn btn-primary mt-3 mb-3"> Add new project</button>
        </form>
        @if (Session::has('message'))
            <p class="text-danger">{{ Session::get('message') }}</p>
        @endif
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Project name</th>
                <th>Customer</th>
                <th>Date start</th>
                <th>Date finish</th>
                <th class="w-25">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $project)
                <tr>
                    <td>{{ $project->id }}</td>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->customer->name }}</td>
                    <td>{{ $project->date_start }}</td>
                    <td>{{ $project->date_finish }}</td>
                    <td class="d-flex">
                        <a class="btn btn-outline-warning mr-3" id="{{ $project->id }}" title="Edit"
                           href="{{route('projects.edit',$project->id)}}">
                            <i class="fa fa-fw fa-edit"></i>
                        </a>
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
