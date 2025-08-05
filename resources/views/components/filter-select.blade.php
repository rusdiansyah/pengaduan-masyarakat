@props(['name','label'])
<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <select wire:model.live="{{ $name }}" class="form-control">
        {{ $slot }}
    </select>
</div>
