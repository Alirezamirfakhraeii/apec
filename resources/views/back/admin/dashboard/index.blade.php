@extends('back.admin.layouts.master')

@section('title', 'داشبورد ادمین')

@section('content')
    <body class="main-body app sidebar-mini">

    <!-- Loader -->
    @include('back.admin.layouts.partials.loader')

    <!-- /Loader -->

    <!-- Page -->
    <div class="page">

        <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>

        @include('back.admin.layouts.partials.sidebar')

        <!-- main-sidebar -->
        <div class='main-content app-content'>

            <!-- main-header -->
            @include('back.admin.layouts.partials.navbar')
            <!-- /main-header -->

            <!-- Container open -->
            <div class="container-fluid">


                <!-- breadcrumb -->
                @include('back.admin.layouts.partials.breadcrumb')
                <!-- breadcrumb -->

                <!-- row -->
                @include('back.admin.layouts.partials.widgets')
                <!-- row closed -->

            </div>
            <!-- Container closed -->
        </div>
        <!-- main-content closed -->
@endsection
