@extends('client.layouts.default')
@section('title', trans('view.titles.customer_project_index'))
@section('name_feature', trans('view.titles.customer_project_index'))
@section('content')
    <div class="container-fluid">

        <br>
        <table class="table table-bordered table-hover" id="tableCustomerStaff">
            <thead>
            <tr>
                <th>No.</th>
                <th>Project's name</th>
                <th>Users in project</th>
            </tr>
            </thead>
            <tbody>
            @foreach($projects as $key=>$project)
                <tr>
                    <th>{{ $key + 1 }}</th>
                    <td>{{ $project->name }}</td>
                    <td>
                        @foreach($project->users as $user)
                            <button class="btn btn btn-outline-success mx-1 my-1">{{ $user->name }}</button>
                        @endforeach
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
