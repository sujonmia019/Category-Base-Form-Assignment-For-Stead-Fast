<div class="form-group {{ $colClass ?? '' }}">
    @if(!empty($labelName)) <label for="{{ $name }}" @if(!empty($required)) class="{{ $required }}" @endif>{{ $labelName }}</label> @endif
    <textarea name="{{ $name }}" @if(!empty($rows)) rows="{{ $rows }}" @endif id="{{ $name }}" class="form-control form-control-sm rounded-0 shadow-none {{ $class ?? '' }}" @if(!empty($placeholder)) placeholder="{{ $placeholder }}" @endif>@if(!empty($value)) value="{{ $value }}" @endif</textarea>
    @if(!empty($optional)) <p class="optional-text mb-0">{{ $optional }}</p> @endif
    @error($name)
    <small class="text-danger text-left d-block">{{ $message }}</small>
    @enderror
</div>
