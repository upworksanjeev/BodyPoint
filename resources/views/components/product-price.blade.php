@php
    $customer = getCustomer();
@endphp
<div class="ctm-price mt-[30px]">
    <div class="left-price">
        <h6 class="text-[16px] text-[#000] font-[500]">SKU</h6>
    </div>
    <div class="right-price">
        <div class="text-set">
            <h6 class="text-[16px] text-[#FF9119] font-[500]">{{ $product['sku']??'' }}</h6>
        </div>
    </div>
</div>
<div class="ctm-price mt-[30px]">
    <div class="left-price">
        @if($customer->hasPermissionTo('viewMsrp'))
            <p class="text-[14px] text-[#6A6D73]">MSRP</p>
        @endif
        <h6 class="text-[16px] text-[#000] font-[500]">YOUR PRICE</h6>
        @if ($product['discount'] > 0 && $customer->hasPermissionTo('viewDiscount'))
            <p class="text-[14px] text-[#6A6D73]">Your Discounts (Primary + Secondary)</p>
            {{-- <p class="text-[14px] text-[#6A6D73]">Discount</p> --}}
        @endif
    </div>
    <div class="right-price">
        <div class="text-set">
            @if($customer->hasPermissionTo('viewMsrp'))
                <p class="text-[14px] text-[#6A6D73]">@if (isset($product['msrp'])) ${{ number_format($product['msrp'], 2, '.', ',') }} EA @endif</p>
            @endif
            <h6 class="text-[16px] text-[#000] font-[500]">@if (isset($product['discount_price'])) ${{ number_format($product['discount_price'], 2, '.', ',')  }} EA @endif</h6>
            @if ($product['discount'] > 0 && $customer->hasPermissionTo('viewDiscount'))
                {{-- <p class="text-[14px] text-[#6A6D73]">${{ number_format($product['discount_price'], 2, '.', ',') }} EA</p> --}}
                <p class="text-[14px] text-[#6A6D73]">{{ calculateDiscountPercentage($product['msrp'],$product['price']) ?? '' }}% +  {{ number_format($product['discount'], 2, '.', ',')  }}%</p>
            @endif
        </div>

        <input type="hidden" name="variation_id" id="variation_id" value="{{ $product['variation_id'] ?? '' }}">
        <input type="hidden" name="price" id="price" value="{{ $product['price'] ?? '' }}">
        <input type="hidden" name="sku" id="sku" value="{{ $product['sku'] ?? '' }}">
        <input type="hidden" name="msrp" id="msrp" value="{{ $product['msrp'] ?? '' }}">
        <input type="hidden" name="discount_price" id="discount_price" value="{{ $product['discount_price'] ?? '' }}">
        <input type="hidden" name="discount" id="discount" value="{{ $product['discount'] ?? '' }}">

        @if($customer->hasPermissionTo('addToCart'))
            <button type="submit" class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 items-center hover:bg-[#FF9119]/80 justify-center w-[160px]">Add To Cart</button>
        @endif

    </div>
</div>
