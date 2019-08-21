@extends('admin.layouts.default')
@section('title', 'Create tasks')
@section('name_feature', 'Create tasks')
@section('content')
    <div class="container-fluid">
        <div class="container mt-3">
            <form method="POST" action="{{route('tasks.store')}}" id="formCreateTask">
                {{ csrf_field() }}
                <div class="form-row">
                    <div class="form-group col-md-9">
                        <label for="inputName">Name:</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="inputName"
                               placeholder="Task's name" name="name" value="{{old('name')}}">
                        @error('name')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="taskHour">Hour:</label>
                        <input type="text" class="form-control @error('hour') is-invalid @enderror" id="dateStart"
                               name="hour" value="{{old('hour')}}">
                        @error('hour')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputProject">Project:</label>
                        <select id="inputProject" class="form-control @error('project_id') is-invalid @enderror"
                                name="project_id">
                            <option>----Choose project---</option>
                            @foreach($projects as $project)
                                <option value="{{$project->id}}" {{(old('project_id')==$project->id)? 'selected':''}}>{{$project->name}}</option>
                            @endforeach
                        </select>
                        @error('project_id')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputSelectUser">User:</label>
                        <select id="inputSelectUser" class="form-control @error('user_id') is-invalid @enderror" name="user_id">
                        </select>
                        @error('user_id')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">

                <div class="form-group col-md-12">
                    <label for="descTask">Description:</label>
                    <textarea class="form-control" id="description" rows="3" name="description"></textarea>
                    @error('description')
                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                </div>
                <button type="submit" class="btn btn-primary" id="createTask">Save</button>
            </form>
        </div>
        <br><br>
        <table class="table table-bordered table-hover" id="tableTaskAssign">
            <thead>
            <tr>
                <th>Task</th>
                <th>User</th>
                <th>Hour</th>
                <th>Created_at</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
@endsection
