 {{-- <div class="product-grid-three" x-data="{ open: true, redirectprod(prod) {  var url = '{{ route('product', ':slug') }}'; url = url.replace(':slug', prod); window.location.href=url; }}">
 @foreach ($products as $prod)
 <div class="relative bg-[#fff] rounded-[15px] p-5 border border-[#ECECEC] h-[auto] cursor-pointer" @click="redirectprod('{{ $prod['product']['slug'] }}')">
     <img src="{{ asset('img/small-logo.png') }}" class="absolute top-[8px] right-[8px] h-[40px] max-w-[40px] " alt="">
     <img src="<?php if(isset($prod['product']['media'][0])){ echo url('storage/'.$prod['product']['media'][0]['id'].'/'.$prod['product']['media'][0]['file_name']); }else{ echo  url('img/logo.png'); } ?>" class="mx-auto xxl:min-h-[250px] xl:min-h-[230px] lg:min-h-[223px] md:min-h-[200px] object-contain" alt="asasa">
     <h6 class="text-[18px] text-[#253D4E] mb-2 mt-3 font-[600]">{{ $prod['product']['name'] ?? '' }}</h6>
     <p class="text-[14px] text-[#ADADAD] leading-[20px]"><?php echo substr(htmlspecialchars_decode(str_replace('</div>','',str_replace('<div>','',$prod['product']['description']))), 0, 100) ?? '' ; ?>.....
     </p>

 </div>
 @endforeach

 </div> --}}

 <div class="product-grid-three" x-data="{ open: true, redirectprod(prod) {  
  var url = '{{ route('product', ':slug') }}'; 
  url = url.replace(':slug', prod); 
  window.location.href = url; 
}}">
@foreach ($products as $product)
  <div class="relative bg-[#fff] rounded-[15px] p-5 border border-[#ECECEC] h-auto cursor-pointer" @click="redirectprod('{{ $product->slug }}')">
      <img src="{{ asset('img/small-logo.png') }}" class="absolute top-[8px] right-[8px] h-[40px] max-w-[40px]" alt="">
      <img src="{{ $product->media->isNotEmpty() ? url('storage/'.$product->media[0]->id.'/'.$product->media[0]->file_name) : url('img/logo.png') }}" class="mx-auto xxl:min-h-[250px] xl:min-h-[230px] lg:min-h-[223px] md:min-h-[200px] object-contain" alt="{{ $product->name }}">
      <h6 class="text-[18px] text-[#253D4E] mb-2 mt-3 font-[600]">{{ $product->name }}</h6>
     <p class="text-[14px] text-[#ADADAD] leading-[20px]"><?php echo substr(htmlspecialchars_decode(str_replace('</div>','',str_replace('<div>','',$product->description))), 0, 100) ?? '' ; ?>.....
     </p>
  </div>
@endforeach
</div>
<div class="my-6">
  {{ $products->links() }}
</div>
