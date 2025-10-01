@props([
    'title' => '',
    'class' => ''
])

<div {{ $attributes->merge(['class' => 'card ' . $class]) }}>
    @if($title)
        <div class="card-header">
            <h5 class="card-title mb-0">{{ $title }}</h5>
        </div>
    @endif
    <div class="card-body">
        {{ $slot }}
    </div>
</div>