@extends('admin.layouts.default')
@section('title', trans('view.admin_titles.report_index'))
@section('name_feature', trans('view.admin_titles.report_index'))
@section('content')
    <div class="container-fluid">
        @if (Session::has('message'))
            <p class="text-danger">{{ Session::get('message') }}</p>
        @endif
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Report name</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($reports as $report)
                <tr>
                    <td>{{$report->id}}</td>
                    <td>{{$report->name}}</td>
                    <td>{{$report->description}}</td>
                    <td class="d-flex">
                        <button class="btn btn-outline-primary btnInfoModal" id="{{$report->id}}" title="View">
                            <i class="fa fa-fw fa-search"></i>
                        </button>
                        <a class="btn btn-outline-warning ml-3 mr-3" id="{{$report->id}}" title="Edit"
                           href="{{route('manage-reports.edit',$report->id)}}">
                            <i class="fa fa-fw fa-edit"></i>
                        </a>
                        <form method="POST" action="{{ route('manage-reports.destroy', [$report->id]) }}">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button class="btn btn-outline-danger" type="submit" title="Delete"
                                    onclick="return confirm('Are you sure you want to delete the record of {{ $report->name }} ?')">
                                <i class="fa fa-fw fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $reports->links('pagination::bootstrap-4') }}
    </div>
@endsection
