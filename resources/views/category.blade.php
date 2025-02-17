<x-mainpage-layout>
    @section('title', $category['name'] ?? '' . ' - ' . config('app.name', 'Bodypoint'))
    <section class="py-5">
        <div class="ctm-container">
            <?php if(isset($error)){ echo $error; }else{ ?>
            <div class="ctm-prd-one relative overflow-hidden py-[30px] lg:py-[50px] px-[20px] lg:px-[70px] bg-no-repeat bg-center bg-cover min-h-[200px] md:min-h-[350px] flex justify-center rounded-[20px] after:content-['*'] after:absolute after:top-0 after:bottom-0 after:left-0 after:right-0 after:bg-[#000]/[.5] after:w-full after:h-full"
                style="background-image: url('<?php echo url('storage/' . $category['image']); ?>')">
                <img src="{{ asset('img/small-logo.png') }}"
                    class="h-[44px] max-w-[44px] contain absolute right-[10px] top-[10px] z-[1]" alt="">
                <h3
                    class="text-[#fff] text-[25px] md:text-[52px] uppercase font-[800] leading-[32px] md:leading-[62px] z-[1]">
                    {{ $category['name'] ?? '' }}</h3>
                <div class="mt-[10px] text-[16px] md:text-[18px] text-[#fff] max-w-[670px] z-[1]"><?php echo htmlspecialchars_decode(htmlspecialchars($category['description'])); ?>
                </div>
            </div>
            <div class="prodct-Category my-[15px] md:my-[30px]">
                <div class="category-sub-cat">
                    @if ($subcategory->isNotEmpty())
                        <x-subcat-left-menu :subcategory="$subcategory" />
                    @endif
                    <x-category-left-menu :categories="$categories" />
                    {{-- <x-product-left-menu  :products="$products"/> --}}
                    <button
                        class="p-2 bg-[#fe7300] hover:bg-[#e96a00] text-white text-[20px] font-[500] w-[100%] rounded-[10px]">Reset</button>
                </div>
                <div class="product-details">
                    <h5 class="text-[#233049] text-[24px] capitalize mb-[15px] ">
                        {{ $category['name'] ?? '' }} Products</h5>
                    <x-product-list-category-wise :products="$products" />
                </div>
            </div>
            <?php } ?>
        </div>
    </section>
</x-mainpage-layout>
<script>
    setTimeout(function() {
        window.location.reload();
    }, 1800000);
</script>
