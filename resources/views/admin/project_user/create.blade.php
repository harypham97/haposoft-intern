@extends('admin.layouts.default')
@section('title', 'Add user for project')
@section('name_feature', 'Add user for project')
@section('content')
    <div class="container-fluid">
        <form id="formAddUserProject" action="{{route('project-user.store')}}">
            {{ csrf_field() }}
            <div class="form-group col-md-6 mt-3">
                <label for="inputProject">Choose project:</label>
                <select id="inputProject" class="form-control" name="project_id">
                    @foreach( $data['list_projects'] as $project)
                        <option value="{{$project->id}}" id="selectProjectID">{{$project->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-12">
                <label for="inputUser"> Choose user: <a id="showListCheckBox" href="#">List users (Click to see) >></a></label>
                <input value="true" id="flag" class="d-none">
                <div class="form-control col-12 d-none flex-wrap h-auto" id="loopCheckBox">
                    @foreach( $data['list_users'] as $user)
                        <div class="col-3">
                            <input type="checkbox" value="{{$user->id}}" id="checkBoxUserID"
                                   name="checkBoxUserID">{{$user->name}}
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="form-group col-md-6">
                <button type="submit" class="btn btn-primary" id="btnAddNew">Add new</button>
            </div>

        </form>


    </div>
    <br>
    <table class="table table-bordered table-hover" id="tableProjectUser">
        <thead>
        <tr>
            <th class="w-25">Project name</th>
            <th class="w-50">User name</th>
            <th class="w-25">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data['data'] as $project)
            <tr>
                <td>{{$project->name}}</td>
                <td>
                    @foreach($project->users as $user)
                        {{$user->name}} ||
                    @endforeach
                </td>
                <td class=" d-flex">
                    <form id="formEdit">
                        <a class="btn btn-outline-primary btnEdit" href="{{route('project-user.edit',$project->id)}}" title="Edit">
                            <i class="fa fa-fw fa-edit"></i>
                        </a>
                    </form>
                    <form method="POST" action="">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button class="btn btn-outline-danger ml-3" type="submit" title="Delete"
                                onclick="return confirm('Are you sure you want to delete the record {{ $project->id }} ?')">
                            <i class="fa fa-fw fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $data['data']->links('pagination::bootstrap-4') }}
@endsection
