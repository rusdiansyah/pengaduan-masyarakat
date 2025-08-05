@props(['name','label'])
<div class="form-check">
    <input wire:model="{{ $name }}" class="form-check-input" type="checkbox" checked="">
    <label class="form-check-label">{{ $label }}</label>
    @error($name)
        <div class="form-text text-danger">
            {{ $message }}
        </div>
    @enderror
</div>
