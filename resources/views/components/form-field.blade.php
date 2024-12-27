@props(['label', 'name', 'type' => 'text', 'required' => false])

<div class="form-group">
    @php
        $isInvalid = $errors->first($name) ? 'is-invalid' : '';
    @endphp
    
    <label for="{{ $name }}" class="form-label">
        {{ $label }} {!! $required ? '<span class="text-danger">*</span>' : '' !!}
    </label>

    @if ($type === 'textarea')
        <textarea 
            name="{{ $name }}" 
            id="{{ $name }}" 
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => "form-control {$isInvalid}"]) }}
        >{{ old($name) }}</textarea>
    @else
        <input 
            type="{{ $type }}" 
            name="{{ $name }}" 
            id="{{ $name }}" 
            value="{{ old($name) }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes->merge(['class' => "form-control {$isInvalid}"]) }}
        >
    @endif

    {!! $errors->first($name, '<div class="invalid-feedback">:message</div>') !!}
</div> 