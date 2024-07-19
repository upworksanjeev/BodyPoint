<x-mainpage-layout>
<section class="py-3">
    <div class="ctm-container">
	  <?php if(isset($error)){ echo $error; }else{ ?>
          <div class="prodct-Category mt-[15px] md:mt-[30px]">
            <div>
                     <x-category-left-menu  :categories="$categories"/>
                     {{-- <x-product-left-menu  :products="$side_menu_products"/> --}}
            </div>
            <div id="product_div">
				 <h5 class="text-[#233049] text-[32px] capitalize mb-[20px] md:mb-[30px]">All Products</h5>
                 <x-product-list  :products="$products"/>
            </div>
          </div>
	  <?php } ?>
    </div>
</section>
</x-mainpage-layout>