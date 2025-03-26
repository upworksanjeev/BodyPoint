@php
$sortedSubcategory  = collect($subcategory)->sortBy('name')->values()->all();
@endphp
<div class="bg-[#fff] px-5 py-5 border border-[#ECECEC] rounded-[15px] mb-4" x-data="{ open: true, toggle() { this.open = !this.open }, redirectcat(cate) { var url = '{{ route('category', ':slug') }}'; url = url.replace(':slug', cate); window.location.href=url; } }">
  <a @click="toggle()" class="text-[#333] text-[20px] font-[400] flex justify-between items-center pb-5 border-b-2 border-[#ececec7a]">Sub Categories <svg width="18" height="10" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M0.666992 0.666504L9.00033 8.99984L17.3337 0.666504" stroke="#000" stroke-linecap="round" stroke-linejoin="round"/>
</svg></a>
  <div class="filter mt-5" x-show="open">
       @foreach ($sortedSubcategory as $cat)

       @php
        $formattedSubCategory = str_replace(' ', '-', strtolower(strip_tags(str_replace('-', '_', $cat['name']))));
        $formattedCategory = !empty($categoryName) ? str_replace(' ', '-', strtolower(strip_tags(str_replace('-', '_', $categoryName)))) : '';
        $finalSlug = !empty($formattedCategory) ? $formattedCategory . '/' . $formattedSubCategory : $formattedSubCategory;
       @endphp

          <div class="border border-[#ECECEC] rounded-[5px] p-[10px] flex gap-[15px] mb-[10px]">
               <input class="cursor-pointer" type="radio" id="{{ $cat['id'] ?? '' }}" name="fav_language" value="{{ $cat['name'] ?? '' }}" @click="redirectcat('{{ $finalSlug }}')">
			   <label for="{{ $cat['id'] ?? '' }}" class="cursor-pointer">{{ $cat['name'] ?? '' }}</label>
          </div>
        @endforeach
   </div>
</div>