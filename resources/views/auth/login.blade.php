@extends('layouts.form')

@section('content')
    <div class="card">
        <div class="d-flex card-header">
            <span class="text-uppercase">Přihlásit se</span>
            @if(App::environment('local'))
                <span class="d-flex flex-grow-1 justify-content-end"><samp class="mr-3">Ukázkové údaje: </samp><kbd><kbd>{{ \App\Employee::first()->username }}</kbd> / <kbd>secret</kbd></kbd></span>
            @endif
        </div>
        <div class="card-body">
            @if(App::environment('local'))
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group row">
                    <label for="username" class="col-md-5 col-form-label text-right">Uživatelské jméno: </label>
                    <div class="col-md-4">
                        <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>
                        @if ($errors->has('username'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password" class="col-md-5 col-form-label text-right">Heslo:</label>
                    <div class="col-md-4">
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-7 offset-md-5">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label ml-2" for="remember">
                                Pamatovat si mě
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-1">
                    <div class="col-md-4 offset-md-5">
                        <button type="submit" class="btn btn-block btn-primary">Přihlásit</button>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-7 offset-md-5">
                        <a class="btn btn-link pl-0" href="{{ route('password.request') }}">Zapomněli jste heslo?</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
