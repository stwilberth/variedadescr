@props(['label', 'name', 'options', 'required' => false])

<div class="form-group">
    @php
        $isInvalid = $errors->first($name) ? 'is-invalid' : '';
    @endphp
    
    <label for="{{ $name }}" class="form-label">
        {{ $label }} {!! $required ? '<span class="text-danger">*</span>' : '' !!}
    </label>

    <select 
        name="{{ $name }}" 
        id="{{ $name }}" 
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => "form-select {$isInvalid}"]) }}
    >
        <option value="">Seleccione una opción</option>
        @foreach($options as $value => $label)
            <option value="{{ $value }}" {{ old($name) == $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>

    {!! $errors->first($name, '<div class="invalid-feedback">:message</div>') !!}
</div> 