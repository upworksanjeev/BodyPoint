@props([
    'asset',
])

@php
    /** @var \App\Models\VaultAsset $asset */
    $type = $asset->file_type?->value ?? 'link';
    $dateLabel = $asset->published_at?->format('M Y');
    $meta = array_filter([
        $asset->file_type?->label(),
        $asset->sub_category,
        $dateLabel,
    ]);
@endphp

<article class="flex flex-col bg-white border border-[#E9E9E9] rounded-xl p-4 h-full">
    <div class="flex items-start gap-3">
        <x-vault.file-icon :type="$type" />
        <div class="min-w-0 flex-1">
            <h3 class="text-[15px] font-medium text-[#1a1a1a] leading-snug">{{ $asset->title }}</h3>
            @if ($meta)
                <p class="mt-1 text-[12px] text-[#6b6b6b] truncate">{{ implode(' · ', $meta) }}</p>
            @endif
        </div>
    </div>
    <div class="mt-4 pt-3 border-t border-[#F0F0F0] flex items-center justify-between gap-2">
        <span class="text-[12px] text-[#6b6b6b] truncate">{{ $asset->categoryLabel() }}</span>
        @if ($asset->hasUsableUrl())
            <a href="{{ $asset->file_url }}" target="_blank" rel="noopener noreferrer"
                class="shrink-0 inline-flex items-center text-[13px] font-medium text-white bg-[#00838F] hover:bg-[#006d76] rounded-lg px-3 py-1.5">
                {{ $asset->file_type?->actionLabel() ?? 'Open' }}
            </a>
        @else
            <span class="text-[12px] text-[#b42318]">Unavailable</span>
        @endif
    </div>
</article>
