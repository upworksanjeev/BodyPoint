<div class="bg-[#fff] px-5 py-5 border border-[#ECECEC] rounded-[15px] mb-4" x-data="{ open: true, toggle() { this.open = !this.open }, redirectcat(cate) { var url = '{{ route('category', ':slug') }}'; url = url.replace(':slug', cate); window.location.href=url; } }">
  <a @click="toggle()" class="text-[#333] text-[20px] font-[400] flex justify-between items-center pb-5 border-b-2 border-[#ececec7a]">Sub Categories <i class="fa fa-chevron-down text-[16px]"></i></a>
  <div class="filter mt-5" x-show="open">
       @foreach ($subcategory as $cat)
          <div class="border border-[#ECECEC] rounded-[5px] p-[10px] flex gap-[15px] mb-[10px]">
               <input class="cursor-pointer" type="radio" id="{{ $cat['id'] ?? '' }}" name="fav_language" value="{{ $cat['name'] ?? '' }}" @click="redirectcat('<?php echo str_replace(' ', '-', strtolower(strip_tags(str_replace('-', '_', $cat['name'])))); ?>')">
			   <label for="{{ $cat['id'] ?? '' }}" class="cursor-pointer">{{ $cat['name'] ?? '' }}</label>
          </div>
        @endforeach
   </div>
</div>