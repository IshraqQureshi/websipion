@extends('layouts.app')
@section('content')
    <div id="app">
        @include('layouts.admin.sidebar')
        <div id="main" class="layout-navbar navbar-fixed">
            @include('layouts.admin.header')
            @yield('content-dashboard')
            @include('layouts.admin.footer')
        </div>
    </div>
@endsection
