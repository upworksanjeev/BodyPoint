@props(['url', 'label' => 'Sync'])

<button type="button"
    class="sync-date-range-btn py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-[#000000] hover:bg-[#00838f] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 inline-flex gap-2 items-center justify-center whitespace-nowrap"
    data-sync-url="{{ $url }}"
    title="{{ $label }}">
    <i class="fa fa-refresh text-base" aria-hidden="true"></i>
    <span>{{ $label }}</span>
</button>

@once
    @push('other-scripts')
        <script>
            document.addEventListener('click', function(event) {
                const btn = event.target.closest('.sync-date-range-btn');
                if (!btn) {
                    return;
                }

                const from = document.getElementById('start_date')?.value || '';
                const to = document.getElementById('end_date')?.value || '';
                const url = new URL(btn.dataset.syncUrl, window.location.origin);

                if (from) {
                    url.searchParams.set('sync_from', from);
                }
                if (to) {
                    url.searchParams.set('sync_to', to);
                }

                window.location.href = url.toString();
            });
        </script>
    @endpush
@endonce
