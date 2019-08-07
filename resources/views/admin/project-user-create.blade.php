@extends('admin.layouts.default')
@section('title', 'Add user for project')
@section('content')
    <div class="container-fluid">
        <form method="POST" action="{{route('project-user.store')}}">
            {{ csrf_field() }}
            <div class="form-group col-md-6">
                <label for="inputProject">Project:</label>
                <select id="inputProject" class="form-control" name="project_id">
                    @foreach( $data['projects'] as $project)
                        <option value="{{$project->id}}">{{$project->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="inputUser">User:</label>
                <select id="inputUser" class="form-control" name="user_id">
                    @foreach( $data['users'] as $user)
                        <option value="{{$user->id}}">{{$user->name}}</option>
                    @endforeach
                </select>
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
            <button type="submit" class="btn btn-primary">Add new</button>
        </form>
    </div>
@endsection
