@props(['quoteId'])

<form action="{{ route('pdf-download-quote', $quoteId) }}" method="GET" {{ $attributes->merge(['class' => 'flex flex-wrap items-center gap-2']) }}>
    <label for="price_option_{{ $quoteId }}" class="sr-only">Pricing to include</label>
    <select name="price_option" id="price_option_{{ $quoteId }}"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-full focus:ring-[#00838f] focus:border-[#00838f] p-2.5">
        <option value="all_price">All pricing</option>
        <option value="msrp_primary">MSRP and primary</option>
        <option value="msrp_only">MSRP only</option>
    </select>
    <button type="submit" class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 items-center hover:bg-[#FF9119]/80 justify-center whitespace-nowrap">Download PDF</button>
</form>
