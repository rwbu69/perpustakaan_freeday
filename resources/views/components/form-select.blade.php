@props([
    'name',
    'label' => '',
    'options' => [],
    'selected' => '',
    'placeholder' => 'Pilih...',
    'required' => false,
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
    
    <select 
        id="{{ $name }}" 
        name="{{ $name }}" 
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'form-select ' . $class]) }}
    >
        @if($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        
        @foreach($options as $value => $text)
            <option value="{{ $value }}" {{ (string)old($name, $selected) === (string)$value ? 'selected' : '' }}>
                {{ $text }}
            </option>
        @endforeach
    </select>
    
    @error($name)
        <div class="form-text text-danger">{{ $message }}</div>
    @enderror
</div>