@extends('core')

@section('layout')
    <div class="d-flex flex-column flex-grow-1 justify-content-center align-items-center">
        <div class="d-flex flex-column justify-content-center col-md-4">
            @yield('content')
        </div>
    </div>
@endsection
