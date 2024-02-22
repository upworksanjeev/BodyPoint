<div class="bg-[#fff] px-5 pt-5 pb-7 border border-[#ECECEC] rounded-[15px] mb-10" x-data="{ open: true, toggle() { this.open = !this.open }, redirectprod(prod) { var url = '{{ route('product', ':slug') }}'; url = url.replace(':slug', prod); window.location.href=url;} }">
   <a @click="toggle()" class="text-[#333] text-[24px] font-[400] flex justify-between items-center pb-5 mb-7 border-b-2 border-[#ECECEC]">Products <i class="fa fa-chevron-down text-[16px]"></i></a>
   <div class="filter" x-show="open">
      @foreach ($products as $prod)
             <div class="border border-[#ECECEC] rounded-[5px] p-[10px] flex gap-[15px] mb-[10px]">
               <input type="radio" id="prod{{ $prod['product']['id'] ?? '' }}" name="fav_language" value="{{ $prod['product']['name'] ?? '' }}" @click="redirectprod('{{ $prod['product']['slug'] }}')" class="cursor-pointer"><label for="prod{{ $prod['product']['id'] ?? '' }}" class="cursor-pointer">{{ $prod['product']['name'] ?? '' }}</label>
              </div>
      @endforeach
   </div>
</div>