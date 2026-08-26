@props([
    'type' => 'pdf',
])

@php
    $path = match ($type) {
        'pdf' => 'M6 2h8l6 6v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2zm7 1.5V9h5.5',
        'pptx' => 'M4 4h16v16H4V4zm4 4h8M8 12h8M8 16h5',
        'xlsx' => 'M4 4h16v16H4V4zm4 8h8M8 8l8 8M16 8l-8 8',
        'zip' => 'M8 2h8v4H8V2zm0 4h8v16H8V6zm3 4h2m-2 3h2m-2 3h2',
        'folder' => 'M3 7h6l2 2h10v11H3V7z',
        default => 'M7 3h7l5 5v13H7V3z',
    };
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center justify-center w-10 h-10 rounded-lg bg-[#e6f4f6] text-[#00838F] shrink-0']) }}>
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $path }}" />
    </svg>
</span>
