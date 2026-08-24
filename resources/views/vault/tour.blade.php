<x-mainpage-layout>
    @section('title', 'New to the Vault? - ' . config('app.name', 'Bodypoint'))

    <div class="min-h-[62vh] bg-[#f6f6f6]">
        <x-vault.page-header title="New to the Vault?" />

        <section>
            <div class="max-w-[1170px] mx-auto py-8 md:py-12 px-6">
                <x-vault.breadcrumb :items="[
                    ['label' => 'Partner Vault', 'url' => route('vault')],
                    ['label' => 'New to the Vault?'],
                ]" />

                <p class="text-[16px] text-[#3a3a3a] mb-6 max-w-3xl">
                    Start here: a short intro to Partner Resource Central, then a handful of files most partners download first.
                </p>

                <div class="bg-white rounded-2xl border border-[#E9E9E9] overflow-hidden mb-10">
                    <div style="position: relative; padding-bottom: 56.25%; height: 0;">
                        <iframe
                            src="{{ $videoUrl }}"
                            title="Partner Vault introduction"
                            frameborder="0"
                            webkitallowfullscreen
                            mozallowfullscreen
                            allowfullscreen
                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                        </iframe>
                    </div>
                </div>

                <h2 class="text-[22px] font-normal text-[#1a1a1a] mb-4">Start here</h2>
                <x-vault.asset-grid
                    :assets="$starters"
                    empty-title="The starter shortlist is being prepared"
                    empty-body="Browse the Vault in the meantime."
                />

                <div class="mt-8">
                    <a href="{{ route('vault') }}" class="text-[14px] font-medium text-[#00838F] hover:underline">
                        ← Back to the Vault
                    </a>
                </div>
            </div>
        </section>
    </div>
</x-mainpage-layout>
