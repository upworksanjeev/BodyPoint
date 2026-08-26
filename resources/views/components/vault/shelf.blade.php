@props([
    'title',
    'assets',
    'viewAllUrl' => null,
])

<section class="mb-8">
    <div class="flex items-end justify-between gap-3 mb-4">
        <h2 class="text-[22px] font-normal text-[#1a1a1a]">{{ $title }}</h2>
        @if ($viewAllUrl)
            <a href="{{ $viewAllUrl }}" class="text-[13px] text-[#00838F] hover:underline">View all</a>
        @endif
    </div>
    @if ($assets->isEmpty())
        <p class="text-sm text-[#6b6b6b]">Nothing on this shelf yet.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
            @foreach ($assets as $asset)
                <x-vault.asset-card :asset="$asset" />
            @endforeach
        </div>
    @endif
</section>
