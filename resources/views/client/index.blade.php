@extends('client.layouts.default')

@auth('customer')
@section('title', trans('view.titles.customer_index'))
@section('name_feature', trans('view.titles.customer_index'))
@section('content')
    <div class="container-fluid">
        <h1 class="mt-4">Customers Page</h1>
        <p></p>
    </div>
@endsection
@endauth
@auth('web')
@section('title', trans('view.titles.staff_index'))
@section('name_feature', trans('view.titles.staff_index'))
@section('content')
    <div class="container-fluid">
        <h1 class="mt-4">Staffs Page</h1>
        <p></p>
    </div>
@endsection
@endauth


