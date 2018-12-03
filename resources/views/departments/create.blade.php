@extends('layouts.form')

@section('content')
    <div class="card">
        <div class="d-flex card-header">
            <span class="text-uppercase">Přidat ústav</span>
        </div>
        <div class="card-body py-5">
            <form method="POST" action="{{ route('departments.store') }}">
                @csrf
                <div class="form-group row">
                    <label for="shortcut" class="col-md-5 col-form-label text-right">
                        <strong>Zkratka:</strong>
                    </label>
                    <div class="col-md-6">
                        <input id="shortcut" type="text" class="form-control{{ $errors->has('shortcut') ? ' is-invalid' : '' }}" name="shortcut" value="{{ old('shortcut') }}" required>
                        @if ($errors->has('shortcut'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('shortcut') }}</strong>
                            </span>
                        @endif
                        <small class="form-text text-muted">
                            Označení musí být ve tvaru <strong>????</strong>, kde ? reprezentuje textový znak.
                        </small>
                    </div>
                </div>
                @component('components.form-group', ['format' => 'text', 'name' => 'name', 'mandatory' => true]) Název @endcomponent
                <div class="form-group row">
                    <div class="col-md-6 offset-md-5">
                        <button type="submit" class="btn btn-block btn-primary">Přidat</button>
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