@extends('layouts.form')

@section('content')
    <div class="card">
        <div class="card-header text-uppercase">Registrovat uživatele</div>
        <div class="card-body py-5">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group row">
                    <label for="name" class="col-md-5 col-form-label text-right"><strong>Jméno:</strong></label>
                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                        @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label for="username" class="col-md-5 col-form-label text-right"><strong>Uživatelské jméno:</strong></label>
                    <div class="col-md-6">
                        <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>
                        @if ($errors->has('username'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-md-5 col-form-label text-right"><strong>E-mailová adresa:</strong></label>
                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label for="department_id" class="col-md-5 col-form-label text-right"><strong>Oddělení:</strong></label>
                    <div class="col-md-6">
                        <select id="department_id" class="form-control{{ $errors->has('department_id') ? ' is-invalid' : '' }}" name="department_id" required>
                            @foreach(\App\Department::all()->sortBy('shortcut') as $department)
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
                            @foreach(\App\Room::all()->sortBy('label') as $room)
                                <option value="{{ $room->id }}"{{ old('room_id') == $room->id ? ' selected' : '' }}>{{ $room->label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="phoneNumber" class="col-md-5 col-form-label text-right">Telefonní číslo:</label>
                    <div class="col-md-6">
                        <input id="phoneNumber" type="tel" class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" name="phone_number" value="{{ old('phone_number') }}">
                        @if ($errors->has('phone_number'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('phone_number') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label for="street" class="col-md-5 col-form-label text-right">Ulice:</label>
                    <div class="col-md-6">
                        <input id="street" type="text" class="form-control{{ $errors->has('street') ? ' is-invalid' : '' }}" name="street" value="{{ old('street') }}">
                        @if ($errors->has('street'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('street') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label for="buildingNumber" class="col-md-5 col-form-label text-right">Číslo popisné:</label>
                    <div class="col-md-6">
                        <input id="buildingNumber" type="number" class="form-control{{ $errors->has('building_number') ? ' is-invalid' : '' }}" name="building_number" value="{{ old('building_number') }}">
                        @if ($errors->has('building_number'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('building_number') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label for="city" class="col-md-5 col-form-label text-right">Město:</label>
                    <div class="col-md-6">
                        <input id="city" type="text" class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}" name="city" value="{{ old('city') }}">
                        @if ($errors->has('city'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('city') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label for="zipCode" class="col-md-5 col-form-label text-right">PSČ:</label>
                    <div class="col-md-6">
                        <input id="zipCode" type="number" class="form-control{{ $errors->has('zip_code') ? ' is-invalid' : '' }}" name="zip_code" value="{{ old('zip_code') }}">
                        @if ($errors->has('zip_code'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('zip_code') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
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
