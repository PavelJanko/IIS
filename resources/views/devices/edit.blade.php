@extends('layouts.form')

@section('content')
    <div class="card">
        <div class="d-flex card-header">
            <span class="text-uppercase">Upravit zařízení</span>
        </div>
        <div class="card-body py-5">
            <form method="POST" action="{{ route('devices.update', ['id' => $device->id]) }}">
                @csrf
                {{ method_field('PUT') }}
                @component('components.form-group', ['format' => 'text', 'name' => 'serial_number', 'mandatory' => true, 'value' => $device->serial_number]) Sériové číslo @endcomponent
                @component('components.form-group', ['format' => 'text', 'name' => 'name', 'mandatory' => true, 'value' => $device->name]) Název @endcomponent
                @component('components.form-group', ['format' => 'text', 'name' => 'type', 'mandatory' => true, 'value' => $device->type]) Typ @endcomponent
                @component('components.form-group', ['format' => 'text', 'name' => 'manufacturer', 'mandatory' => true, 'value' => $device->manufacturer]) Výrobce @endcomponent
                <div class="form-group row">
                    <label for="keeper_id" class="col-md-5 col-form-label text-right"><strong>Správce:</strong></label>
                    <div class="col-md-6">
                        <select id="keeper_id" class="form-control{{ $errors->has('keeper_id') ? ' is-invalid' : '' }}" name="keeper_id" required>
                            @foreach($employees as $keeper)
                                <option value="{{ $keeper->id }}"{{ $device->keeper_id == $keeper->id ? ' selected' : '' }}>{{ $keeper->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="room_id" class="col-md-5 col-form-label text-right">Místnost:</label>
                    <div class="col-md-6">
                        <select id="room_id" class="form-control{{ $errors->has('room_id') ? ' is-invalid' : '' }}" name="room_id">
                            <option value="">Žádná</option>
                            @foreach($rooms as $room)
                                @if($device->room_id !== NULL)
                                    <option value="{{ $room->id }}"{{ $device->room_id == $room->id ? ' selected' : '' }}>{{ $room->label }}</option>
                                @else
                                    <option value="{{ $room->id }}">{{ $room->label }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6 offset-md-5">
                        <button type="submit" class="btn btn-block btn-primary">Upravit</button>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-5">
                        Položky značené <strong>tučně</strong> jsou povinné
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
