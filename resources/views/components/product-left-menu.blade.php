{{-- <div class="bg-[#fff] px-5 py-5  border border-[#ECECEC] rounded-[15px] mb-10" x-data="{ open: true, toggle() { this.open = !this.open }, redirectprod(prod) { var url = '{{ route('product', ':slug') }}'; url = url.replace(':slug', prod); window.location.href=url;} }">
   <a @click="toggle()" class="text-[#333] text-[24px] font-[400] flex justify-between items-center pb-4 border-b-2 border-[#ECECEC]">Products <svg width="18" height="10" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M0.666992 0.666504L9.00033 8.99984L17.3337 0.666504" stroke="#000" stroke-linecap="round" stroke-linejoin="round"/>
</svg></a>
   <div class="filter mt-5" x-show="open">
      @foreach ($products as $prod)
             <div class="border border-[#ECECEC] rounded-[5px] p-[10px] flex gap-[15px] mb-[10px]">
               <input type="radio" id="prod{{ $prod['product']['id'] ?? '' }}" name="fav_language" value="{{ $prod['product']['name'] ?? '' }}" @click="redirectprod('{{ $prod['product']['slug'] }}')" class="cursor-pointer"><label for="prod{{ $prod['product']['id'] ?? '' }}" class="cursor-pointer">{{ $prod['product']['name'] ?? '' }}</label>
              </div>
      @endforeach
   </div>
</div> --}}

<div class="bg-[#fff] px-5 py-5  border border-[#ECECEC] rounded-[15px] mb-10" x-data="{ open: true, toggle() { this.open = !this.open }, redirectprod(prod) { var url = '{{ route('product', ':slug') }}'; url = url.replace(':slug', prod); window.location.href=url;} }">
   <a @click="toggle()" class="text-[#333] text-[24px] font-[400] flex justify-between items-center pb-4 border-b-2 border-[#ECECEC]">Products <svg width="18" height="10" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M0.666992 0.666504L9.00033 8.99984L17.3337 0.666504" stroke="#000" stroke-linecap="round" stroke-linejoin="round"/>
</svg></a>
   <div class="filter mt-5" x-show="open">
      @foreach ($products as $product)
             <div class="border border-[#ECECEC] rounded-[5px] p-[10px] flex gap-[15px] mb-[10px]">
               <input type="radio" id="prod{{ $product->id ?? '' }}" name="fav_language" value="{{ $product->name ?? '' }}" @click="redirectprod('{{ $product->slug }}')" class="cursor-pointer"><label for="prod{{ $product->id ?? '' }}" class="cursor-pointer">{{ $product->name ?? '' }}</label>
              </div>
      @endforeach
   </div>
</div>
