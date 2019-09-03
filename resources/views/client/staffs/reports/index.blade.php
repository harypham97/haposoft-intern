@extends('client.layouts.default')
@section('title', trans('view.titles.staff_report_index'))
@section('name_feature', trans('view.titles.staff_report_index'))
@section('content')
    <div class="container-fluid">
        <div class="d-flex col-6">
            <input  type="hidden" value="{{ route('reports.edit','id') }}" id="getUrlEdit">
            <form id="formSearchReport" class="d-flex" method="get"
                  action="{{route('client.staffs.search_report_by_date',['',''])}}">
                <input type="date" class="form-control col-5" name="from_date" id="from_date" value="{{today()->toDateString()}}">
                <input type="date" class="form-control col-5 mx-3" name="to_date" id="to_date" value="{{today()->toDateString()}}">
                <button class="btn btn-primary" id="btnSearchReport">Search</button>
            </form>
            <a class="btn btn-success ml-5" href="{{ route('reports.create') }}"> <i class="fa fa-plus">&nbsp;</i>Add new</a>
        </div>
        <br>
        <table class="table table-bordered table-hover" id="tableReportSearch">
            <thead>
            <tr>
                <th>No.</th>
                <th class="w-50">Report</th>
                <th class="w-25">Created_at</th>
                <th class="w-25">Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
@endsection
