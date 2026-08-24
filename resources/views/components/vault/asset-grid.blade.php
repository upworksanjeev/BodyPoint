@props([
    'assets',
    'emptyTitle' => 'No assets match this view',
    'emptyBody' => 'Try another filter or clear search.',
])

@if ($assets->isEmpty())
    <x-vault.empty-state :title="$emptyTitle" :body="$emptyBody" />
@else
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
        @foreach ($assets as $asset)
            <x-vault.asset-card :asset="$asset" />
        @endforeach
    </div>
@endif
