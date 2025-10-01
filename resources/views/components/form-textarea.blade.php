@props([
    'name',
    'label' => '',
    'value' => '',
    'placeholder' => '',
    'rows' => 3,
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
    
    <textarea 
        id="{{ $name }}" 
        name="{{ $name }}" 
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $readonly ? 'readonly' : '' }}
        {{ $attributes->merge(['class' => 'form-control ' . $class]) }}
    >{{ old($name, $value) }}</textarea>
    
    @error($name)
        <div class="form-text text-danger">{{ $message }}</div>
    @enderror
</div>