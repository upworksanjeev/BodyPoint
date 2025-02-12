<div class="product-grid-three" x-data="{
    open: true,
    redirectprod(prod) {
        var url = '{{ route('product', ':slug') }}';
        url = url.replace(':slug', prod);
        window.location.href = url;
    }
}">

    @php
        $rearrangeProduct = null;
    @endphp

    @foreach ($products as $product)
        @if ($product->product)
            @if ($product->product->id == '368')
                @php
                    $rearrangeProduct = $product->product;
                @endphp
                @continue
            @endif
            <div class="relative bg-[#fff] rounded-[15px] p-5 border border-[#ECECEC] h-auto cursor-pointer"
                @click="redirectprod('{{ $product->product->slug }}')">
                <img src="{{ asset('img/small-logo.png') }}" class="absolute top-[8px] right-[8px] h-[40px] max-w-[40px]"
                    alt="">
                <img src="{{ $product->product->media->isNotEmpty() ? url('storage/' . $product->product->media[0]->id . '/' . $product->product->media[0]->file_name) : url('img/logo.png') }}"
                    class="mx-auto xxl:min-h-[250px] xl:min-h-[230px] lg:min-h-[223px] md:min-h-[200px] object-contain"
                    alt="{{ $product->product->name }}">
                <h6 class="text-[16px] text-[#253D4E] mb-2 mt-3 font-[600]">{{ $product->product->name }}</h6>
                <p class="text-[14px] text-[#ADADAD] leading-[20px]"></p>
                <p class="text-[14px] text-[#ADADAD] leading-[20px]">{{ Str::limit(strip_tags($product->product->description), 100) }}...</p>
            </div>
        @endif
    @endforeach

    @if (!empty($rearrangeProduct))
        <div class="relative bg-[#fff] rounded-[15px] p-5 border border-[#ECECEC] h-auto cursor-pointer"
            @click="redirectprod('{{ $rearrangeProduct->slug }}')">
            <img src="{{ asset('img/small-logo.png') }}" class="absolute top-[8px] right-[8px] h-[40px] max-w-[40px]"
                alt="">
            <img src="{{ $rearrangeProduct->media->isNotEmpty() ? url('storage/' . $rearrangeProduct->media[0]->id . '/' . $rearrangeProduct->media[0]->file_name) : url('img/logo.png') }}"
                class="mx-auto xxl:min-h-[250px] xl:min-h-[230px] lg:min-h-[223px] md:min-h-[200px] object-contain"
                alt="{{ $rearrangeProduct->name }}">
            <h6 class="text-[16px] text-[#253D4E] mb-2 mt-3 font-[600]">{{ $rearrangeProduct->name }}</h6>
            <p class="text-[14px] text-[#ADADAD] leading-[20px]"></p>
            <p class="text-[14px] text-[#ADADAD] leading-[20px]">{{ Str::limit(strip_tags($rearrangeProduct->description), 100) }}...</p>
        </div>
    @endif
</div>
<div class="my-4 md:my-6">
    {{ $products->links() }}
</div>
