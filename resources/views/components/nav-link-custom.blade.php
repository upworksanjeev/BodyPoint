@props(['classes'])

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
