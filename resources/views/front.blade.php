<x-mainpage-layout>

 <section class="py-3">
      <div class="ctm-container">
	<?php if(isset($error)){ echo $error; }else{ ?>
	
          <div class="prodct-Category mt-[15px] md:mt-[30px]">
            <div>
              <div class="bg-[#fff] px-5 pt-5 pb-7 border border-[#ECECEC] rounded-[15px] mb-10"  x-data="{ open: true, toggle() { this.open = ! this.open }, redirectcat(cate) { window.location = '{{ url('/category/') }}/'+cate ; }   }" >
                <a @click="toggle()" class="text-[#333] text-[24px] font-[400] flex justify-between items-center pb-5 mb-7 border-b-2 border-[#ECECEC]">Categories <i class="fa fa-chevron-down text-[16px]"></i></a>
                <div class="filter" x-show="open">
				@foreach ($categories as $cat)
                  <div class="border border-[#ECECEC] rounded-[5px] p-[10px] flex gap-[15px] mb-[10px]">
                    <input type="radio" id="{{ $cat['id'] ?? '' }}" class="cursor-pointer" name="fav_language" value="{{ $cat['name'] ?? '' }}"  @click="redirectcat('<?php echo str_replace(' ','-',strtolower(strip_tags($cat['name']))); ?>')"><label for="{{ $cat['id'] ?? '' }}" class="cursor-pointer">{{ $cat['name'] ?? '' }}</label>
                  </div>
				  @endforeach
                 
                </div>
              </div>
              <div class="bg-[#fff] px-5 pt-5 pb-7 border border-[#ECECEC] rounded-[15px] mb-10" x-data="{ open: true, toggle() { this.open = ! this.open } , redirectprod(prod) {window.location = '{{ url('/product/') }}/'+prod;  } }">
                <a @click="toggle()" class="text-[#333] text-[24px] font-[400] flex justify-between items-center pb-5 mb-7 border-b-2 border-[#ECECEC]">Products <i class="fa fa-chevron-down text-[16px]"></i></a>
                <div class="filter" x-show="open">
				@foreach ($products as $prod)
				
                  <div class="border border-[#ECECEC] rounded-[5px] p-[10px] flex gap-[15px] mb-[10px]">
                    <input type="radio" id="prod{{ $prod['product']['id'] ?? '' }}" class="cursor-pointer" name="fav_language" value="{{ $prod['product']['name'] ?? '' }}" @click="redirectprod('<?php echo str_replace(' ','-',strtolower(strip_tags(str_replace('™','-tm',str_replace('®','-r',str_replace('-','_',$prod['product']['name'])))))); ?>')"><label for="prod{{ $prod['product']['id'] ?? '' }}" class="cursor-pointer">{{ $prod['product']['name'] ?? '' }}</label>
                  </div>
					
				 @endforeach
                  
                </div>
              </div>
              
            </div>
            <div>
              <h5 class="text-[#233049] text-[32px] capitalize mb-[20px] md:mb-[30px]">All Products</h5>
                 <div class="product-grid-three" x-data="{ open: true, redirectprod(prod) {   window.location = '{{ url('/product/') }}/'+prod;  } }">
			  @foreach ($products as $prod)
                <div class="relative bg-[#fff] rounded-[15px] p-5 border border-[#ECECEC] h-[auto] cursor-pointer" @click="redirectprod('<?php echo str_replace(' ','-',strtolower(strip_tags(str_replace('™','-tm',str_replace('®','-r',str_replace('-','_',$prod['product']['name'])))))); ?>')">
                  <img src="{{ asset('img/small-logo.png') }}"  class="absolute top-[8px] right-[8px] h-[40px] max-w-[40px] " alt="">
                  <img src="<?php if(isset($prod['product']['media'][0])){ echo url('storage/'.$prod['product']['media'][0]['id'].'/'.$prod['product']['media'][0]['file_name']); }else{ echo  url('img/logo.png'); } ?>"  class="mx-auto " alt="">
                  <h6 class="text-[18px] text-[#253D4E] mb-2 mt-3 font-[600]">{{ $prod['product']['name'] ?? '' }}</h6>
                  <p class="text-[14px] text-[#ADADAD] leading-[20px]"><?php echo substr(htmlspecialchars_decode(str_replace('</div>','',str_replace('<div>','',$prod['product']['description']))), 0, 100) ?? '' ; ?>.....
				  </p>
                </div>
				 @endforeach
            
              </div>
            </div>
          </div>
	<?php } ?>
      </div>
    </section>
	</x-mainpage-layout>