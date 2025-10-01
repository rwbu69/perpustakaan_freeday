@props([
    'type' => 'info',
    'dismissible' => false,
    'class' => ''
])

@php
$alertClasses = [
    'success' => 'alert-success',
    'danger' => 'alert-danger',
    'warning' => 'alert-warning',
    'info' => 'alert-info',
    'primary' => 'alert-primary',
    'secondary' => 'alert-secondary',
    'light' => 'alert-light',
    'dark' => 'alert-dark'
];

$classes = 'alert ' . $alertClasses[$type];
if ($dismissible) $classes .= ' alert-dismissible';
$classes .= ' ' . $class;
@endphp

<div {{ $attributes->merge(['class' => $classes]) }} role="alert">
    {{ $slot }}
    
    @if($dismissible)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
</div>