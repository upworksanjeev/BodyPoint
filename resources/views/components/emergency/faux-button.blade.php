@props([
    'label' => '',
    'tooltip' => '',
    'primary' => false,
])
@php
    $fauxId = 'em-faux-' . \Illuminate\Support\Str::random(8);
@endphp
<span class="inline-flex max-w-full" title="{{ $tooltip }}">
    <span
        tabindex="0"
        role="button"
        class="inline-flex rounded-full focus:outline-none focus:ring-2 focus:ring-[#00838f] focus:ring-offset-1"
        aria-describedby="{{ $fauxId }}"
    >
        @if ($primary)
            <span
                class="py-2.5 px-5 text-sm font-medium text-white border border-[#FF9119] bg-[#FF9119] rounded-full opacity-50 cursor-not-allowed select-none pointer-events-none w-[160px] text-center justify-center"
            >{{ $label }}</span>
        @else
            <span
                class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-full border border-[#000000] opacity-50 cursor-not-allowed select-none pointer-events-none w-[160px] text-center justify-center"
            >{{ $label }}</span>
        @endif
    </span>
    <span id="{{ $fauxId }}" class="sr-only">{{ $tooltip }}</span>
</span>
