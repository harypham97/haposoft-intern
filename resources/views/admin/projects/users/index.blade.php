@extends('admin.layouts.default')
@section('title', trans('view.admin_titles.project_user_index'))
@section('name_feature', trans('view.admin_titles.project_user_index'))
@section('content')
    <div class="container-fluid">
        @if (Session::has('message'))
            <p class="text-danger">{{ Session::get('message') }}</p>
        @endif
        <div class="container">
            <form id="formAddUserProject" action="{{ route('project-user.store') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-row">
                    <div class="form-group col-md-6 mt-3">
                        <label for="inputProject">Choose project:</label>
                        <select id="inputProject" class="form-control @error('project_id') is-invalid @enderror"
                                name="project_id">
                            <option>---Choose project---</option>
                            @foreach($listProjects as $project)
                                <option value="{{ $project->id }}" {{ (old('project_id') == $project->id)? 'selected':'' }}>{{ $project->name }}</option>
                            @endforeach
                        </select>
                        @error('project_id')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 mt-3">
                        <label for="labelDepartment">Choose user's Department:</label>
                        <input type="hidden" id="urlGetUserByDepartment"
                               value="{{ route('project_user.get_user_by_department','departmentId') }}">
                        <select id="inputDepartment" class="form-control @error('checkBoxUserId') is-invalid @enderror"
                                name="department_id">
                            <option>---Choose Department---</option>
                            <option value="-1">All Departments</option>
                            @foreach( $listDepartments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                        @error('checkBoxUserId')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
                <div class="" id="loopCheckBox"></div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" id="btnAddNew">Add new</button>
                </div>
            </form>
            <br>
        </div>
        <table class="table table-bordered table-hover" id="tableProjectUser">
            <thead>
            <tr>
                <th>ID</th>
                <th>Project name</th>
                <th class="w-75">User name</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tableProjects as $project)
                <tr class="text-justify">
                    <td>{{ $project->id }}</td>
                    <td>{{ $project->name }}</td>
                    <td>
                        <input type="hidden" name="urlDeleteUserInProject" value="{{ route('project_user.delete_user_in_project',[$project->id,'userId']) }}">
                        @foreach($project->users->unique('name') as $user)
                            <button class="btn btn btn-outline-success mx-1 my-1 delete-user-in-project"
                                    value="{{ $user->user_id }}" title="Delete user">
                                {{ $user->name }} &nbsp;<i class="fa fa-window-close" aria-hidden="true"></i>
                            </button>
                        @endforeach
                    </td>
                    <td>
                        <form method="POST" action="{{ route('project-user.destroy',$project->id) }}">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button class="btn btn-outline-danger" type="submit" title="Delete all users"
                                    onclick="return confirm('Are you sure you want to delete the record {{ $project->id }} ?')">
                                <i class="fa fa-fw fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $tableProjects->links('pagination::bootstrap-4') }}
    </div>
@endsection
