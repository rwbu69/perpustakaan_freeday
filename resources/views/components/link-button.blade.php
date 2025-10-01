@props(['href' => '#', 'class' => ''])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'btn btn-link ' . $class]) }}>
    {{ $slot }}
</a>