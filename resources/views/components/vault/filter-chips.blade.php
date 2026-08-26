@props([
    'search',
    'fileTypes' => [],
    'categories' => null,
    'subCategories' => [],
    'groups' => [],
    'action' => null,
])

@php
    $action = $action ?? route('vault');
    $queryUrl = fn (array $overrides) => $action.'?'.http_build_query($search->toQuery($overrides));
@endphp

<div class="flex flex-col gap-3">
    @if ($categories)
        <div class="flex flex-wrap gap-2">
            <a href="{{ $queryUrl(['category' => null, 'sub' => null, 'group' => null]) }}"
                class="inline-flex items-center rounded-full px-3 py-1.5 text-[13px] border {{ $search->category === null ? 'bg-[#00838F] text-white border-[#00838F]' : 'bg-white text-[#1a1a1a] border-[#d4d4d4] hover:border-[#00838F]' }}">
                All categories
            </a>
            @foreach ($categories as $summary)
                @php $category = $summary['category']; @endphp
                <a href="{{ $queryUrl(['category' => $category->value, 'sub' => null, 'group' => null]) }}"
                    class="inline-flex items-center rounded-full px-3 py-1.5 text-[13px] border {{ $search->category === $category ? 'bg-[#00838F] text-white border-[#00838F]' : 'bg-white text-[#1a1a1a] border-[#d4d4d4] hover:border-[#00838F]' }}">
                    {{ $category->label() }}
                    <span class="ms-1.5 text-[11px] opacity-80">{{ $summary['count'] }}</span>
                </a>
            @endforeach
        </div>
    @endif

    @if (count($subCategories) > 0)
        <x-vault.chip-row
            label="Sub-category"
            :all-url="$queryUrl(['sub' => null, 'group' => null])"
            :all-active="$search->subCategory === null"
            :items="collect($subCategories)->map(fn ($sub) => [
                'name' => $sub['name'],
                'count' => $sub['count'],
                'active' => $search->subCategory === $sub['name'],
                'url' => $queryUrl(['sub' => $sub['name'], 'group' => null]),
            ])->all()"
        />
    @endif

    @if (count($groups) > 0)
        <x-vault.chip-row
            label="Group"
            :all-url="$queryUrl(['group' => null])"
            :all-active="$search->groupName === null"
            :items="collect($groups)->map(fn ($group) => [
                'name' => $group['name'],
                'count' => $group['count'],
                'active' => $search->groupName === $group['name'],
                'url' => $queryUrl(['group' => $group['name']]),
            ])->all()"
        />
    @endif

    @if (count($fileTypes) > 0)
        <div class="flex flex-wrap items-center gap-2">
            <span class="text-[12px] uppercase tracking-wide text-[#6b6b6b]">File type</span>
            <a href="{{ $queryUrl(['type' => null]) }}"
                class="inline-flex items-center rounded-full px-3 py-1.5 text-[13px] border {{ $search->fileType === null ? 'bg-[#1a1a1a] text-white border-[#1a1a1a]' : 'bg-white text-[#1a1a1a] border-[#d4d4d4] hover:border-[#1a1a1a]' }}">
                All types
            </a>
            @foreach ($fileTypes as $type)
                <a href="{{ $queryUrl(['type' => $type->value]) }}"
                    class="inline-flex items-center rounded-full px-3 py-1.5 text-[13px] border {{ $search->fileType === $type ? 'bg-[#1a1a1a] text-white border-[#1a1a1a]' : 'bg-white text-[#1a1a1a] border-[#d4d4d4] hover:border-[#1a1a1a]' }}">
                    {{ $type->label() }}
                </a>
            @endforeach
        </div>
    @endif
</div>
