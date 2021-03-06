@extends('layouts.form')

@section('content')
    <div class="card">
        <div class="d-flex card-header">
            <span class="text-uppercase">Přidat místnost</span>
        </div>
        <div class="card-body py-5">
            <form method="POST" action="{{ route('rooms.store') }}">
                @csrf
                <div class="form-group row">
                    <label for="label" class="col-md-5 col-form-label text-right">
                        <strong>Označení:</strong>
                    </label>
                    <div class="col-md-6">
                        <input id="label" type="text" class="form-control{{ $errors->has('label') ? ' is-invalid' : '' }}" name="label" value="{{ old('label') }}" required>
                        @if ($errors->has('label'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('label') }}</strong>
                            </span>
                        @endif
                        <small class="form-text text-muted">
                            Označení musí být ve tvaru <strong>?###</strong>, kde ? reprezentuje textový znak a # číslicový znak.
                        </small>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="department_id" class="col-md-5 col-form-label text-right"><strong>Ústav:</strong></label>
                    <div class="col-md-6">
                        <select id="department_id" class="form-control{{ $errors->has('department_id') ? ' is-invalid' : '' }}" name="department_id" required>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}"{{ old('department_id') == $department->id ? ' selected' : '' }}>{{ $department->shortcut }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6 offset-md-5 form-check">
                        <input class="form-check-input" name="is_in_cvt" type="checkbox" value="{{ old('is_in_cvt') ? 'true' : '' }}" id="is_in_cvt">
                        <label class="form-check-label" for="is_in_cvt">
                            Je zařízení v ČVT
                        </label>
                    </div>
                </div>
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