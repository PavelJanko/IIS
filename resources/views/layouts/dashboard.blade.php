@extends('core')

@section('layout')
    <div class="container">
        <div class="row my-4">
            <div class="col-3">
                @include('partials.sidebar')
            </div>
            <div class="col-9">
                @yield('graph')
            </div>
        </div>
        @yield('content')
    </div>
@endsection
