<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link href="{{asset('public/admin/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/admin/css/simple-sidebar.css')}}" rel="stylesheet">
    <link href="{{asset('public/admin/css/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title> @yield('title')</title>
</head>
<body>
    @include('admin.includes.header')
    <div class="d-flex" id="wrapper">
        @include('admin.includes.sidebar')
        <div id="page-content-wrapper">
                <span class="d-block pt-3 pl-3">--- @yield('name_feature') ---</span>
                <hr class="ml-3 w-25">
            @yield('content')
        </div>
    </div>
    @include('admin.includes.footer')
</body>
</html>
