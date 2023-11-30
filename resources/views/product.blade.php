<x-mainpage-layout>

 <section class="py-3">
      <div class="ctm-container">
	<?php if(isset($error)){ echo $error; }else{ ?>
	

          <div class="ctm-prd-one py-[30px] lg:py-[50px] px-[20px] lg:px-[70px] relative bg-no-repeat bg-center bg-cover h-[auto] md:h-[400px] flex justify-center rounded-[20px]" style="background-image: url('<?php echo url('storage/'.$product['media'][0]['id'].'/'.$product['media'][0]['file_name']); ?>')">
            <img src="{{ asset('img/small-logo.png') }}"  class="h-[55px] max-w-[55px] contain absolute right-[10px] top-[10px]" alt="">
            <h3 class="text-[#333] text-[30px] md:text-[65px] uppercase font-[800] leading-[30px] md:leading-[72px]">{{ $product['name'] ?? '' }}</h3>
            <div class="mt-[10px] text-[18px] text-[#233049] max-w-[670px]"><?php echo htmlspecialchars_decode(htmlspecialchars($product['description'])); ?></div>
          </div>
         
	<?php } ?>
      </div>
    </section>
	</x-mainpage-layout>