<div class="bg-[#fff] px-5 pt-5 pb-7 border border-[#ECECEC] rounded-[15px] mb-10" x-data="{ open: true, toggle() { this.open = !this.open }, redirectcat(cate) { var url = '{{ route('category', ':slug') }}'; url = url.replace(':slug', cate); window.location.href=url; } }">
  <a @click="toggle()" class="text-[#333] text-[24px] font-[400] flex justify-between items-center pb-5 mb-7 border-b-2 border-[#ECECEC]">Sub Categories <i class="fa fa-chevron-down text-[16px]"></i></a>
  <div class="filter" x-show="open">
       @foreach ($subcategory as $cat)
          <div class="border border-[#ECECEC] rounded-[5px] p-[10px] flex gap-[15px] mb-[10px]">
               <input class="cursor-pointer" type="radio" id="{{ $cat['id'] ?? '' }}" name="fav_language" value="{{ $cat['name'] ?? '' }}" @click="redirectcat('<?php echo str_replace(' ', '-', strtolower(strip_tags(str_replace('-', '_', $cat['name'])))); ?>')">
			   <label for="{{ $cat['id'] ?? '' }}" class="cursor-pointer">{{ $cat['name'] ?? '' }}</label>
          </div>
        @endforeach
   </div>
</div>