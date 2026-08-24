@props([
    'title',
    'body' => '',
])

<div class="rounded-xl border border-dashed border-[#cfe3e6] bg-white px-6 py-10 text-center">
    <p class="text-[16px] font-medium text-[#1a1a1a]">{{ $title }}</p>
    @if ($body !== '')
        <p class="mt-2 text-[14px] text-[#6b6b6b]">{{ $body }}</p>
    @endif
    {{ $slot }}
</div>
