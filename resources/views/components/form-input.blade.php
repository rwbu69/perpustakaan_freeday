@props([
    'type' => 'text',
    'name',
    'label' => '',
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'readonly' => false,
    'class' => ''
])

<div class="mb-3">
    @if($label)
        <label for="{{ $name }}" class="form-label">
            {{ $label }}
            @if($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif
    
    <input 
        type="{{ $type }}" 
        id="{{ $name }}" 
        name="{{ $name }}" 
        value="{{ old($name, $value) }}" 
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $readonly ? 'readonly' : '' }}
        {{ $attributes->merge(['class' => 'form-control ' . $class]) }}
    >
    
    @error($name)
        <div class="form-text text-danger">{{ $message }}</div>
    @enderror
</div>