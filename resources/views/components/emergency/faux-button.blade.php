@props([
    'label' => '',
    'tooltip' => '',
    'primary' => false,
    'wide' => false,
])
@php
    $fauxId = 'em-faux-' . \Illuminate\Support\Str::random(8);
    $widthClass = $wide
        ? 'w-full sm:w-auto sm:min-w-[200px]'
        : 'w-[160px]';
@endphp
<span class="inline-flex max-w-full" title="{{ $tooltip }}">
    <span
        tabindex="-1"
        role="button"
        aria-disabled="true"
        class="inline-flex rounded-full focus:outline-none pointer-events-none cursor-not-allowed select-none"
        aria-describedby="{{ $fauxId }}"
    >
        @if ($primary)
            <span
                class="py-2.5 px-5 text-sm font-medium text-white rounded-full border border-[#FF9119] bg-[#FF9119] opacity-[0.78] flex gap-3 items-center justify-center {{ $widthClass }} text-center"
            >{{ $label }}</span>
        @else
            <span
                class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-full border border-[#000000] opacity-[0.78] flex gap-3 items-center justify-center {{ $widthClass }} text-center"
            >{{ $label }}</span>
        @endif
    </span>
    <span id="{{ $fauxId }}" class="sr-only">{{ $tooltip }}</span>
</span>
