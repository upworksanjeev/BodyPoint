<x-mainpage-layout>
    @section('title', 'Vault - ' . config('app.name', 'Bodypoint'))

    <div class="min-h-[62vh] bg-[#f6f6f6]">
        <x-vault.page-header>
            <p class="mt-2 text-lg font-normal text-white/90">Partner Resource Central</p>
        </x-vault.page-header>

        <section>
            <div class="max-w-[1170px] mx-auto py-8 md:py-12 px-6">
                <div class="mb-5">
                    <x-vault.search-form :search="$search" />
                </div>
                <x-vault.filter-chips
                    :search="$search"
                    :file-types="$fileTypes"
                    :categories="$categories"
                    :sub-categories="$subCategories"
                    :groups="$groups"
                />

                @if ($isSearching)
                    @php
                        $count = $results->count();
                    @endphp
                    <div class="flex items-center justify-between gap-3 mt-8 mb-4">
                        <p class="text-[15px] text-[#3a3a3a]">
                            {{ $count }} {{ $count === 1 ? 'asset' : 'assets' }}
                            @if ($search->term !== '')
                                for “{{ $search->term }}”
                            @endif
                        </p>
                        <x-vault.sort :search="$search" :action="route('vault')" />
                    </div>
                    <x-vault.asset-grid
                        :assets="$results"
                        empty-title="No assets match your search"
                        empty-body="Try a different keyword, or clear filters to browse the library."
                    />

                    <div class="mt-10">
                        <x-vault.review-form />
                    </div>
                @else
                    <a href="{{ route('vault.tour') }}"
                        class="mt-8 mb-8 flex items-center justify-between gap-4 rounded-xl border border-[#cfe3e6] bg-white p-5 hover:border-[#00838F] transition">
                        <div>
                            <p class="text-[18px] font-medium text-[#1a1a1a]">New to the Vault?</p>
                            <p class="mt-1 text-[14px] text-[#6b6b6b]">Watch the intro and start with a shortlist of essential files.</p>
                        </div>
                        <span class="shrink-0 text-[13px] font-medium text-[#00838F]">Start here →</span>
                    </a>

                    <x-vault.shelf title="Frequently used" :assets="$frequentlyUsed" />
                    <x-vault.shelf title="Newly added" :assets="$newlyAdded" />

                    <section class="mb-10">
                        <h2 class="text-[22px] font-normal text-[#1a1a1a] mb-4">Browse by category</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($categories as $summary)
                                <a href="{{ route('vault.category', $summary['category']) }}"
                                    class="block bg-white border border-[#E9E9E9] rounded-xl p-5 hover:border-[#00838F] transition">
                                    <p class="text-[17px] font-medium text-[#1a1a1a]">{{ $summary['category']->label() }}</p>
                                    <p class="mt-1 text-[13px] text-[#6b6b6b]">{{ $summary['category']->description() }}</p>
                                    <p class="mt-3 text-[13px] text-[#00838F]">{{ $summary['count'] }} {{ $summary['count'] === 1 ? 'asset' : 'assets' }}</p>
                                </a>
                            @endforeach
                        </div>
                    </section>

                    <x-vault.review-form />
                @endif

                <div class="flex items-center gap-1.5 py-4">
                    <img src="https://bodypoint.com/wp-content/uploads/2024/06/Vector-10.svg" alt="" />
                    <p class="text-base font-normal m-0">
                        Need Assistance? Email our Marketing Team
                        <a href="mailto:{{ config('vault.review_mailbox') }}" class="text-[#00838F]"><b>Here</b></a>
                    </p>
                </div>
            </div>
        </section>
    </div>
</x-mainpage-layout>
