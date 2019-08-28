@extends('admin.layouts.default')
@section('title', trans('view.admin_titles.customer_index'))
@section('name_feature', trans('view.admin_titles.customer_index'))
@section('content')
    <div class="container-fluid">
        <form method="GET" action="{{route('customers.create')}}">
            <button class="btn btn-primary mt-3 mb-3"> Add new customer</button>
        </form>
        @if (Session::has('message'))
            <p class="text-danger">{{ Session::get('message') }}</p>
        @endif
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($customers as $customer)
                <tr>
                    <th>{{ $customer->id }}</th>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td class="d-flex">
                        <button class="btn btn-outline-primary btnInfoModal" id="{{ $customer->id }}" title="View">
                            <i class="fa fa-fw fa-search"></i>
                        </button>
                        <a class="btn btn-outline-warning ml-3 mr-3" id="{{ $customer->id }}" title="Edit"
                           href="{{route('customers.edit',$customer->id)}}">
                            <i class="fa fa-fw fa-edit"></i>
                        </a>
                        <form method="POST" action="{{ route('customers.destroy', [$customer->id]) }}">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button class="btn btn-outline-danger" type="submit" title="Delete"
                                    onclick="return confirm('Are you sure you want to delete the record of {{ $customer->name }} ?')">
                                <i class="fa fa-fw fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $customers->links('pagination::bootstrap-4') }}
    </div>
@endsection
