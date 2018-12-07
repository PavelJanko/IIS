@extends('layouts.form')

@section('content')
    <div class="card mt-5">
        <div class="card-header text-uppercase">Upravit uživatele</div>
        <div class="card-body py-5">
            <form method="POST" action="{{ route('employees.update', ['id' => $employee->id]) }}">
                @csrf
                {{ method_field('PUT') }}
                @component('components.form-group', ['format' => 'text', 'name' => 'name', 'mandatory' => true, 'value' => $employee->name]) Jméno @endcomponent
                @component('components.form-group', ['format' => 'text', 'name' => 'username', 'mandatory' => true, 'value' => $employee->username]) Uživatelské jméno @endcomponent
                @component('components.form-group', ['format' => 'email', 'name' => 'email', 'mandatory' => true, 'value' => $employee->email]) E-mailová adresa @endcomponent
                @component('components.form-group', ['format' => 'password', 'name' => 'password', 'mandatory' => false, 'value' => '']) Heslo @endcomponent
                <div class="form-group row">
                    <label for="role" class="col-md-5 col-form-label text-right"><strong>Role:</strong></label>
                    <div class="col-md-6">
                        <select id="role" class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }}" name="role" required>
                            @foreach($roles as $role)
                                <option value="{{ $role }}"{{ old('role') == $role ? ' selected' : '' }}>{{ $role }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="department_id" class="col-md-5 col-form-label text-right"><strong>Oddělení:</strong></label>
                    <div class="col-md-6">
                        <select id="department_id" class="form-control{{ $errors->has('department_id') ? ' is-invalid' : '' }}" name="department_id" required>
                            @foreach($departments as $department)
                                @if($employee->department->id !== NULL)
                                    <option value="{{ $department->id }}"{{ $employee->department->id === $department->id ? ' selected' : '' }}>{{ $department->shortcut }}</option>
                                @else
                                    <option value="{{ $department->id }}">{{ $department->shortcut }}</option>
                                @endif
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
                                @if($employee->room->id !== NULL)
                                    <option value="{{ $room->id }}"{{ $employee->room->id == $room->id ? ' selected' : '' }}>{{ $room->label }}</option>
                                @else
                                    <option value="{{ $room->id }}">{{ $room->label }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                @component('components.form-group', ['format' => 'tel', 'name' => 'phone_number', 'mandatory' => false, 'value' => $employee->phone_number]) Telefonní číslo @endcomponent
                @component('components.form-group', ['format' => 'text', 'name' => 'street', 'mandatory' => false, 'value' => $employee->street]) Ulice @endcomponent
                @component('components.form-group', ['format' => 'number', 'name' => 'building_number', 'mandatory' => false, 'value' => $employee->building_number]) Číslo popisné @endcomponent
                @component('components.form-group', ['format' => 'text', 'name' => 'city', 'mandatory' => false, 'value' => $employee->city]) Město @endcomponent
                @component('components.form-group', ['format' => 'number', 'name' => 'zip_code', 'mandatory' => false, 'value' => $employee->zip_code]) PSČ @endcomponent
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
