@props([
    'label',
    'allUrl',
    'allActive' => false,
    'items' => [],
])

<div class="flex flex-wrap items-center gap-2">
    <span class="text-[12px] uppercase tracking-wide text-[#6b6b6b] self-center">{{ $label }}</span>
    <a href="{{ $allUrl }}"
        class="inline-flex items-center rounded-full px-3 py-1.5 text-[13px] border {{ $allActive ? 'bg-[#00838F] text-white border-[#00838F]' : 'bg-white text-[#1a1a1a] border-[#d4d4d4] hover:border-[#00838F]' }}">
        All
    </a>
    @foreach ($items as $item)
        <a href="{{ $item['url'] }}"
            class="inline-flex items-center rounded-full px-3 py-1.5 text-[13px] border {{ $item['active'] ? 'bg-[#00838F] text-white border-[#00838F]' : 'bg-white text-[#1a1a1a] border-[#d4d4d4] hover:border-[#00838F]' }}">
            {{ $item['name'] }}
            <span class="ms-1.5 text-[11px] opacity-80">{{ $item['count'] }}</span>
        </a>
    @endforeach
</div>
