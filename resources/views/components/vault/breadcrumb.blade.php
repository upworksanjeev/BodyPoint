@props([
    'items',
])

<nav aria-label="Breadcrumb" class="mb-4 text-[14px] text-[#6b6b6b]">
    <ol class="flex flex-wrap items-center gap-1.5">
        @foreach ($items as $index => $item)
            <li class="flex items-center gap-1.5">
                @if ($index > 0)
                    <span aria-hidden="true">/</span>
                @endif
                @if (!empty($item['url']) && !$loop->last)
                    <a href="{{ $item['url'] }}" class="text-[#00838F] hover:underline">{{ $item['label'] }}</a>
                @else
                    <span class="text-[#1a1a1a]">{{ $item['label'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
