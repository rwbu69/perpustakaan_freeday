@props([
    'striped' => false,
    'hover' => true,
    'bordered' => true,
    'responsive' => true,
    'class' => ''
])

@php
$classes = 'table';
if ($striped) $classes .= ' table-striped';
if ($hover) $classes .= ' table-hover';
if ($bordered) $classes .= ' table-bordered';
$classes .= ' ' . $class;
@endphp

@if($responsive)
    <div class="table-responsive">
@endif

<table {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</table>

@if($responsive)
    </div>
@endif