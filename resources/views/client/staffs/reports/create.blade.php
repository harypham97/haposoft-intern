@extends('client.layouts.default')
@section('title', trans('view.titles.staff_report_create'))
@section('name_feature', trans('view.titles.staff_report_create'))
@section('content')
    <div class="container-fluid">
        <div class="container mt-3">
            <input type="hidden" value="{{ route('client.staffs.delete_report','id') }}" id="getUrlDelete">
            <input type="hidden" value="{{ route('client.staffs.get_tasks_by_project','projectId') }}" id="getTasksByProject">
            <form method="POST" action="{{ route('client.staffs.store_report') }}" id="formCreateReport">
                {{ csrf_field() }}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputProject">Project:</label>
                        <select id="inputProjectReport" class="form-control" name="project_id">
                            <option>----Choose project---</option>
                            @foreach($projects as $project_id => $project_name)
                                <option value="{{ $project_id }}">{{ $project_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <label>Task:</label>
                </div>
                <div class="form-control col-12 d-flex flex-wrap h-auto mb-3" id="loopCheckBoxTask">
                    <div class="col-12"><span>---No data to display---</span></div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputName">Name:</label>
                        <input type="text" class="form-control" id="inputName" placeholder="Report's name" name="name">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputName">Date:</label>
                        <input type="date" class="form-control" id="date" name="date">
                    </div>
                    <div class="form-group col-md-4 pl-2">
                        <label>Time:</label>
                        <div class="d-flex">
                            <div class="d-lex flex-column">
                                <input type="time" class="form-control" id="time_start" name="time_start">
                            </div>
                            <span class="d-block">&nbsp;~&nbsp;</span>
                            <div class="d-lex flex-column">
                                <input type="time" class="form-control" id="time_end" name="time_end">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="descTask">Description:</label>
                        <textarea class="form-control" id="description" rows="3" name="description"></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" id="btnCreateReport">Save</button>
            </form>
            <br>
            <table class="table table-bordered table-hover" id="tableCreateReport">
                <thead>
                <tr>
                    <th>Report</th>
                    <th>Project</th>
                    <th>Date</th>
                    <th>Time</th>
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
