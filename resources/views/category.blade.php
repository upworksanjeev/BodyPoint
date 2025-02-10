<x-mainpage-layout>
<section class="py-3">
	<div class="ctm-container">
	<?php if(isset($error)){ echo $error; }else{ ?>
		<div class="ctm-prd-one relative overflow-hidden py-[30px] lg:py-[50px] px-[20px] lg:px-[70px] bg-no-repeat bg-center bg-cover h-[auto] md:h-[400px] flex justify-center rounded-[20px] after:content-['*'] after:absolute after:top-0 after:bottom-0 after:left-0 after:right-0 after:bg-[#000]/[.5] after:w-full after:h-full" style="background-image: url('<?php echo url('storage/' . $category['image']); ?>')">
                <img src="{{ asset('img/small-logo.png') }}" class="h-[55px] max-w-[55px] contain absolute right-[10px] top-[10px] z-[1]" alt="">
                <h3 class="text-[#fff] text-[30px] md:text-[65px] uppercase font-[800] leading-[39px] md:leading-[72px] z-[1]">{{ $category['name'] ?? '' }}</h3>
                <div class="mt-[10px] text-[18px] text-[#fff] max-w-[670px] z-[1]"><?php echo htmlspecialchars_decode(htmlspecialchars($category['description'])); ?></div>
        </div>
        <div class="prodct-Category my-[15px] md:my-[30px]">
                <div>
					 <x-subcat-left-menu  :subcategory="$subcategory"/>
                     <x-category-left-menu  :categories="$categories"/>
                     {{-- <x-product-left-menu  :products="$products"/> --}}
                     <button class="p-2 bg-[#fe7300] hover:bg-[#e96a00] text-white text-[20px] font-[500] w-[100%] rounded-[10px]">Reset</button>
                </div>
                <div class="product-details">
                    <h5 class="text-[#233049] text-[24px] capitalize mb-[15px] md:mb-[20px]">
                        {{ $category['name'] ?? '' }} Products</h5>
                    <x-product-list-category-wise  :products="$products"/>
                </div>
         </div>
    <?php } ?>
    </div>
</section>
</x-mainpage-layout>
<script>
    setTimeout(function(){
        window.location.reload();
    }, 1800000);
</script>
