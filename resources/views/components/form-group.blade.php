<div class="form-group row">
    <label for="{{ $name }}" class="col-md-5 col-form-label text-right">
        @if($mandatory)<strong>@endif{{ $slot }}:@if($mandatory)</strong>@endif
    </label>
    <div class="col-md-6">
        <input id="{{ $name }}" type="{{ $format }}" class="form-control{{ $errors->has($name) ? ' is-invalid' : '' }}" name="{{ $name }}" value="{{ isset($value) ? $value : old($name) }}"@if($mandatory) required @endif>
        @if ($errors->has($name))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first($name) }}</strong>
            </span>
        @endif
    </div>
</div>
