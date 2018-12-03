@extends('layouts.dashboard')

@section('graph')
    <div class="d-flex flex-column justify-content-center align-items-center h-100">
        <h1 class="display-1">{{ $department->shortcut }}</h1>
        <h1>{{ $department->name }}</h1>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white font-weight-bold text-uppercase">Seznam zaměstnanců ústavu</div>
        <div class="card-body p-0">
            @if($department->employees->count())
                <div class="row">
                    <div class="col-6">
                        <ul class="ml-5 my-5">
                            @foreach($department->employees()->limit($department->employees->count() / 2)->get() as $employee)
                                <li>{{ $employee->name }} ({{ $employee->username }})</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-6">
                        <ul class="ml-5 my-5">
                            @foreach($department->employees()->skip($department->employees->count() / 2 + 1)->limit($department->employees->count() / 2)->get() as $employee)
                                <li>{{ $employee->name }} ({{ $employee->username }})</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @else
                <p class="py-4 m-0 text-center" style="font-size: 125%;">V ústavu nejsou žádní zaměstnanci.</p>
            @endif
        </div>
    </div>
@endsection
