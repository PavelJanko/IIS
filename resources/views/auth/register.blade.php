@extends('layouts.form')

@section('content')
    <div class="card">
        <div class="card-header text-uppercase">Registrovat uživatele</div>
        <div class="card-body py-5">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                @component('components.form-group', ['format' => 'text', 'name' => 'name', 'mandatory' => true]) Jméno @endcomponent
                @component('components.form-group', ['format' => 'text', 'name' => 'username', 'mandatory' => true]) Uživatelské jméno @endcomponent
                @component('components.form-group', ['format' => 'email', 'name' => 'email', 'mandatory' => true]) E-mailová adresa @endcomponent
                <div class="form-group row">
                    <label for="department_id" class="col-md-5 col-form-label text-right"><strong>Oddělení:</strong></label>
                    <div class="col-md-6">
                        <select id="department_id" class="form-control{{ $errors->has('department_id') ? ' is-invalid' : '' }}" name="department_id" required>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}"{{ old('department_id') == $department->id ? ' selected' : '' }}>{{ $department->shortcut }} - {{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="room_id" class="col-md-5 col-form-label text-right">Místnost:</label>
                    <div class="col-md-6">
                        <select id="room_id" class="form-control{{ $errors->has('room_id') ? ' is-invalid' : '' }}" name="room_id">
                            <option>Žádná</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}"{{ old('room_id') == $room->id ? ' selected' : '' }}>{{ $room->label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @component('components.form-group', ['format' => 'tel', 'name' => 'phone_number', 'mandatory' => false]) Telefonní číslo @endcomponent
                @component('components.form-group', ['format' => 'text', 'name' => 'street', 'mandatory' => false]) Ulice @endcomponent
                @component('components.form-group', ['format' => 'number', 'name' => 'building_number', 'mandatory' => false]) Číslo popisné @endcomponent
                @component('components.form-group', ['format' => 'text', 'name' => 'city', 'mandatory' => false]) Město @endcomponent
                @component('components.form-group', ['format' => 'number', 'name' => 'zip_code', 'mandatory' => false]) PSČ @endcomponent
                <div class="form-group row">
                    <div class="col-md-6 offset-md-5">
                        <button type="submit" class="btn btn-block btn-primary">Registrovat</button>
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
