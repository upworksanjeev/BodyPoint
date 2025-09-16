<div class="product-grid-three" x-data="{
    open: true,
    redirectprod(prod) {
        var url = '{{ route('product', ':slug') }}';
        url = url.replace(':slug', prod);
        window.location.href = url;
    }
}">
    @foreach ($products as $product)
    @if ($product->product)
    @php
        // Ensure media is a collection
        $mediaCollection = $product->product->media ?? collect();

        // Get the media sorted by order_column ascending
        $mediaItem = $mediaCollection
            ->sortBy('order_column')  // Sort ascending
            ->first();               // Take the first available
        // Determine the image URL
        $imageUrl = $mediaItem
            ? url('storage/'.$mediaItem->id.'/'.$mediaItem->file_name)
            : url('img/logo.png');
    @endphp
    <div class="relative bg-[#fff] rounded-[15px] p-5 border border-[#ECECEC] h-auto cursor-pointer"
        @click="redirectprod('{{ $product->product->slug }}')">
        <img src="{{ asset('img/small-logo.png') }}" class="absolute top-[8px] right-[8px] h-[40px] max-w-[40px]"
            alt="">
        <img src="{{ $imageUrl }}"
            class="mx-auto xxl:min-h-[250px] xl:min-h-[230px] lg:min-h-[223px] md:min-h-[200px] object-contain"
            alt="{{ $product->product->name }}">
        <h6 class="text-[16px] text-[#253D4E] mb-2 mt-3 font-[600]">{{ $product->product->name }}</h6>
        <p class="text-[14px] text-[#ADADAD] leading-[20px]"></p>
        <p class="text-[14px] text-[#ADADAD] leading-[20px]">{{ Str::limit(strip_tags($product->product->description), 100) }}...</p>
    </div>
    @endif
    @endforeach
</div>

<div class="my-4 md:my-6">
    {{ $products->links() }}
</div>