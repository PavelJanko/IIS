@extends('core')

@section('layout')
    <div class="container">
        <div class="row">
            <div class="col-3">
                @include('partials.sidebar')
            </div>
            <div class="col-9">
                @yield('content')
            </div>
        </div>
    </div>
@endsection
