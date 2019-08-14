@extends('admin.layouts.default')
@section('title', 'Add user for project')
@section('name_feature', 'Add users for project')
@section('content')
    <div class="container-fluid">
        @if (Session::has('message'))
            <p class="text-danger">{{ Session::get('message') }}</p>
        @endif
        <div class="container">
            <form id="formAddUserProject" action="{{route('project_user.store')}}" method="POST">
                {{ csrf_field() }}
                <div class="form-row">
                    <div class="form-group col-md-6 mt-3">
                        <label for="inputProject">Choose project:</label>
                        <select id="inputProject" class="form-control @error('project_id') is-invalid @enderror"
                                name="project_id">
                            <option>---Choose project---</option>
                            @foreach($listProjects as $project)
                                <option value="{{$project->id}}" {{(old('project_id')==$project->id)? 'selected':''}}>{{$project->name}}</option>
                            @endforeach
                        </select>
                        @error('project_id')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 mt-3">
                        <label for="labelDepartment">Choose user's Department:</label>
                        <select id="inputDepartment" class="form-control @error('checkBoxUserId') is-invalid @enderror"
                                name="department_id">
                            <option>---Choose Department---</option>
                            <option value="all">All Departments</option>
                            @foreach( $listDepartments as $department)
                                <option value="{{$department->id}}">{{$department->name}}</option>
                            @endforeach
                        </select>
                        @error('checkBoxUserId')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
                <div class="" id="loopCheckBox"></div>
                <div class="form-group col-md-6">
                    <button type="submit" class="btn btn-primary" id="btnAddNew">Add new</button>
                </div>
            </form>
            <br>
        </div>
        <table class="table table-bordered table-hover" id="tableProjectUser">
            <thead>
            <tr>
                <th>ID</th>
                <th class="w-25">Project name</th>
                <th class="w-50">User name</th>
                <th class="w-25">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tableProjects as $project)
                <tr>
                    <td>{{$project->id}}</td>
                    <td>{{$project->name}}</td>
                    <td>
                        @foreach($project->users as $user)
                            {{$user->name}} ||
                        @endforeach
                    </td>
                    <td class=" d-flex">
                        <button class="btn btn-outline-primary btnInfoModal" id="{{$project->id}}" title="View detail">
                            <i class="fa fa-fw fa-search"></i>
                        </button>
                        <a class="btn btn-outline-warning ml-3 mr-3 btnEdit"
                           href="{{route('project_user.edit',$project->id)}}" title="Edit">
                            <i class="fa fa-fw fa-edit"></i>
                        </a>
                        <form method="POST" action="{{route('project_user.destroy',$project->id)}}">
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
        {{ $tableProjects->links('pagination::bootstrap-4') }}
    </div>
@endsection
