<div class="form-group {{ $colClass ?? '' }}">
    @if(!empty($labelName)) <label for="{{ $name }}" @if(!empty($required)) class="{{ $required }}" @endif>{{ $labelName }}</label> @endif
    <input type="{{ $type ?? 'text' }}" name="{{ $name }}" id="{{ $name }}" class="form-control form-control-sm rounded-0 shadow-none {{ $class ?? '' }}" @if(!empty($placeholder)) placeholder="{{ $placeholder }}" @endif @if(!empty($value)) value="{{ $value }}" @endif />
    @error($name)
    <small class="text-danger text-left d-block">{{ $message }}</small>
    @enderror
</div>
