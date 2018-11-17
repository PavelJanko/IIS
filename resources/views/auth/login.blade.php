@extends('layouts.form')

@section('content')
    <div class="card">
        <div class="d-flex card-header">
            <span class="text-uppercase">Přihlásit se</span>
            @if(App::environment('local'))
                <span class="d-flex flex-grow-1 justify-content-end"><samp class="mr-3">Ukázkové údaje: </samp><kbd><kbd>{{ \App\Employee::first()->username }}</kbd> / <kbd>secret</kbd></kbd></span>
            @endif
        </div>
        <div class="card-body py-5">
            <form method="POST" action="{{ route('auth.login') }}">
                @csrf
                @component('components.form-group', ['format' => 'text', 'name' => 'username', 'mandatory' => true]) Uživatelské jméno @endcomponent
                @component('components.form-group', ['format' => 'password', 'name' => 'password', 'mandatory' => true]) Heslo @endcomponent
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
                <div class="form-group row mb-0">
                    <div class="col-md-4 offset-md-5">
                        <button type="submit" class="btn btn-block btn-primary">Přihlásit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
