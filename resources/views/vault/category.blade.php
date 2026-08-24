<x-mainpage-layout>
    @section('title', $category->label() . ' - Vault - ' . config('app.name', 'Bodypoint'))

    <div class="min-h-[62vh] bg-[#f6f6f6]">
        <x-vault.page-header :title="$category->label()" />

        <section>
            <div class="max-w-[1170px] mx-auto py-8 md:py-12 px-6">
                <x-vault.breadcrumb :items="[
                    ['label' => 'Partner Vault', 'url' => route('vault')],
                    ['label' => $category->label()],
                ]" />

                <p class="text-[15px] text-[#6b6b6b] mb-6">{{ $category->description() }}</p>

                <div class="mb-5">
                    <x-vault.search-form :search="$search" :action="route('vault.category', $category)" />
                </div>
                <x-vault.filter-chips
                    :search="$search"
                    :file-types="$fileTypes"
                    :sub-categories="$subCategories"
                    :groups="$groups"
                    :action="route('vault.category', $category)"
                />

                @php $count = $results->count(); @endphp
                <div class="flex items-center justify-between gap-3 mt-8 mb-4">
                    <p class="text-[15px] text-[#3a3a3a]">
                        {{ $count }} {{ $count === 1 ? 'asset' : 'assets' }}
                    </p>
                    <x-vault.sort :search="$search" :action="route('vault.category', $category)" />
                </div>

                <x-vault.asset-grid
                    :assets="$results"
                    empty-title="No assets in this category"
                    empty-body="Try another sub-filter or file type."
                />
            </div>
        </section>
    </div>
</x-mainpage-layout>
