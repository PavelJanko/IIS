@extends('layouts.dashboard')

@section('graph')
    <div class="d-flex flex-column justify-content-center align-items-center h-100">
        <h1 class="display-1">{{ $room->label }}</h1>
        <h1>{{ $room->name }}</h1>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white font-weight-bold text-uppercase">Seznam zaměstnanců v místnosti</div>
        <div class="card-body p-0">
            @if($room->employees->count())
                <div class="row">
                    <div class="col-6">
                        <ul class="ml-5 my-5">
                            @foreach($room->employees()->limit($room->employees->count() / 2)->get() as $employee)
                                <li>{{ $employee->name }} ({{ $employee->username }})</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-6">
                        <ul class="ml-5 my-5">
                            @foreach($room->employees()->skip($room->employees->count() / 2 + 1)->limit($room->employees->count() / 2)->get() as $employee)
                                <li>{{ $employee->name }} ({{ $employee->username }})</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @else
                <p class="py-4 m-0 text-center" style="font-size: 125%;">V místnosti nejsou žádní zaměstnanci.</p>
            @endif
        </div>
    </div>
@endsection
