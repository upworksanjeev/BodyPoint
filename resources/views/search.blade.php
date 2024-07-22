<x-mainpage-layout>
<section class="py-3">
    <div class="ctm-container">
	  <?php if(isset($error)){ echo $error; }else{ ?>
          <div class="prodct-Category mt-[15px] md:mt-[30px]">
            <div>
                     <x-category-left-menu  :categories="$categories"/>
                    {{--  <x-product-left-menu  :products="$side_menu_products"/> --}}
            </div>
            <div id="product_div">
				 <h5 class="text-[#233049] text-[32px] capitalize mb-[20px] md:mb-[30px]">All Products For Search Keyword "{{ $searchinput }}"</h5>
                 <x-product-search-list  :products="$products" :searchinput="$searchinput"/>
            </div>
          </div>
	  <?php } ?>
    </div>
</section>
<script>
	$('#searchinput').val('{{ $searchinput }}');
	
	if($('#searchinput').val()!=''){
		$('#searchicon').html('<svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14" onclick="$(\'#searchinput\').val(\'\');$(\'#formsearch\').submit();" style="cursor:pointer;"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>');
	}else{
		$('#searchicon').html('<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke-color="#616060" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>');
	}
</script>
</x-mainpage-layout>