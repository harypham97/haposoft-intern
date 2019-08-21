@extends('client.layouts.default')
@section('title', 'Reports')
@section('name_feature', 'Reports')
@section('content')
    <div class="container-fluid">
        <div class="container mt-3">
            <form method="POST" action="{{route('client.staffs.store_report')}}" id="formCreateReport">
                {{ csrf_field() }}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputProject">Project:</label>
                        <select id="inputProjectReport" class="form-control @error('project_id') is-invalid @enderror" name="project_id">
                            <option>----Choose project---</option>
                            @foreach($projects as $project_id => $project_name)
                                <option value="{{$project_id}}" {{(old('project_id')==$project_id)? 'selected':''}}>{{$project_name}}</option>
                            @endforeach
                        </select>
                        @error('project_id')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputTask">Task:</label>
                        <select id="inputSelectTask" class="form-control @error('task_id') is-invalid @enderror" name="task_id">
                        </select>
                        @error('task_id')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-9">
                        <label for="inputName">Name:</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="inputName"
                               placeholder="Report's name" name="name" value="{{old('name')}}">
                        @error('name')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="taskHour">Hour:</label>
                        <input type="text" class="form-control @error('hour') is-invalid @enderror" id="hour"
                               name="hour" value="{{old('hour')}}">
                        @error('hour')
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
                <button type="submit" class="btn btn-primary" id="createReport">Save</button>
            </form>

            <br><br>
            <table class="table table-bordered table-hover" id="tableReport">
                <thead>
                <tr>
                    <th>Report</th>
                    <th>Task</th>
                    <th>Project</th>
                    <th>Created_at</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection
