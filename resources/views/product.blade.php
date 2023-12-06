<x-mainpage-layout>

 <section class="py-3">
      <div class="ctm-container">
	<?php if(isset($error)){ echo $error; }else{ ?>
	

         <div class="antialiased">
        <div class="ctm-container-two mt-[50px]">
          <div class="flex flex-col md:flex-row -mx-4">
            <div class="md:flex-1 px-5">
              <div class = "product-imgs">
                <div class = "img-display">
                  <div class = "img-showcase">
				  @foreach ($product['media'] as $media)
                    <img src = "<?php  echo url('storage/'.$media['id'].'/'.$media['file_name']); ?>" alt = "{{ $product['name'] ?? '' }}">
                     @endforeach
                  </div>
                </div>
                <div class = "img-select">
				<?php $k = 1; ?>
				@foreach ($product['media'] as $media)
				
                  <div class = "img-item">
                    <a href = "#" data-id = "{{ $k }}">
                      <img src = "<?php  echo url('storage/'.$media['id'].'/'.$media['file_name']); ?>">
                    </a>
                  </div>
				  <?php $k++; ?>
				  @endforeach
              
                </div>
              </div>
            </div>
            <div class="md:flex-1 px-5 ctm-mobile-mrgn">
              <h2 class="text-[#333] text-[30px] font-[700]">{{ $product['name'] ?? '' }}</h2>
              <p class="text-[#008C99] text-[18px] ">{{ $product['small_description'] ?? '' }}</p>
			  @foreach ($category as $k=>$v)
              <div class="relative py-[15px] linediv">
              <h6 class="text-[#333] text-[18px] font-[700]  bg-[#fff] pr-[10px] relative lineh6">Select {{ $v }}</h6>
            </div>
            <div class="grid-four pb-[10px]">
			 @foreach ($attribute[$k] as $v1)
                <div class="grid-five">
                  <div class="five-g-img">
                    <img src="/img/standard-img.png" alt="">
                  </div>
                  <div class="five-content p-[10px]">
                    <h6 class="text-[16px] text-[#008C99] font-[700]">{{ $v1 }}</h6>
                    <p class="text-[14px] text-[#6A6D73]">Comfortable with a controlled amount of stretch</p>
                  </div>
                </div>
               @endforeach
            </div>
				  @endforeach
            <!--div class="relative py-[15px] linediv">
            <h6 class="text-[#333] text-[18px] font-[700]  bg-[#fff] pr-[10px] relative lineh6">Select Harness Size <span class="text-[#008C99] text-[14px]">(See Sizing tab for size guide)</span></h6></div>
            <div class="size-button mb-[10px]">
              <a class="border rounded-[12px] py-[10px] px-[18px] text-[#333] text-[22px] uppercase font-[500] pt-[13px]" href="#">S</a>
              <a class="border rounded-[12px] py-[10px] px-[18px] text-[#333] text-[22px] uppercase font-[500] pt-[13px]" href="#">M</a>
              <a class="border rounded-[12px] py-[10px] px-[18px] text-[#333] text-[22px] uppercase font-[500] pt-[13px]" href="#">L</a>
              <a class="border rounded-[12px] py-[10px] px-[18px] text-[#333] text-[22px] uppercase font-[500] pt-[13px]" href="#">XL</a>
            </div-->
          
           
        <div class="ctm-price mt-[30px]">
          <div class="left-price">
            <p class="text-[14px] text-[#6A6D73]">MSRP</p>
            <h6 class="text-[16px] text-[#000] font-[500]">YOUR PRICE</h6>
          </div>
          <div class="right-price">
            <div class="text-set">
            <p class="text-[14px] text-[#6A6D73]">MSRP</p>
            <h6 class="text-[16px] text-[#000] font-[500]">YOUR PRICE</h6>
          </div>
            <button class="bg-[#fe7300] hover:bg-[#e96a00] py-[10px] px-[25px] text-[16px] text-[#fff]">Add To Cart</button>
          </div>
        </div>
        <div class="detactor">
          <div class="detactor-left">
            <p class="text-[#000] flex items-center gap-[10px]"><i class="fas fa-map-marker-alt text-[20px]"></i> <span class="text-[18px]">Find a Dealer</span></p>
          </div>
          <div class="detactor-right">
            <button class="bg-[#373B3C] rounded-[3px] py-[8px] px-[30px] text-[#fff] border border-[#373B3C] mr-[8px]">Save</button>
            <button class="border border-[#373B3C] text-[#373B3C] py-[8px] px-[30px]">Print</button>
          </div>
        </div>
            </div>
            
          </div>
        </div>
    </div>

    <div class="ctm-container-three py-[30px] md:py-[80px]">
      <div class="chest-support">
        <div class="chest-img">
          <img src="/img/chest.png" alt="">
        </div>
        <div class="chest-content">
          <h6 class="text-[#333] text-[20px] md:text-[30px] font-[600]">{{ $product['small_description'] ?? '' }}</h6>
          <p class="text-[#333] text-[16px] mt-[10px]"><?php echo htmlspecialchars_decode(htmlspecialchars($product['description'])); ?></p>
        </div>
      </div>
    </div>
    
    <div class="ctm-container-three ctm-accordion">
      <div class="accordion">
        <div class="accordion-item">
          <div class="accordion-item-header">
            Description
          </div><!-- /.accordion-item-header -->
          <div class="accordion-item-body">
            <div class="accordion-item-body-content">
             <?php echo htmlspecialchars_decode(htmlspecialchars($product['description'])); ?>
            </div>
          </div><!-- /.accordion-item-body -->
        </div><!-- /.accordion-item -->
        <div class="accordion-item">
          <div class="accordion-item-header">
            Sizing
          </div><!-- /.accordion-item-header -->
          <div class="accordion-item-body">
            <div class="accordion-item-body-content">
              <?php echo htmlspecialchars_decode(htmlspecialchars($product['sizing'])); ?>
            </div>
          </div><!-- /.accordion-item-body -->
        </div><!-- /.accordion-item --> 
		<div class="accordion-item">
          <div class="accordion-item-header">
            Instruction For Use
          </div><!-- /.accordion-item-header -->
          <div class="accordion-item-body">
            <div class="accordion-item-body-content">
              <?php echo htmlspecialchars_decode(htmlspecialchars($product['instruction_of_use'])); ?>
            </div>
          </div><!-- /.accordion-item-body -->
        </div><!-- /.accordion-item --> <div class="accordion-item">
          <div class="accordion-item-header">
            FAQ And Documents
          </div><!-- /.accordion-item-header -->
          <div class="accordion-item-body">
            <div class="accordion-item-body-content">
              <?php echo htmlspecialchars_decode(htmlspecialchars($product['warranty'])); ?>
            </div>
          </div><!-- /.accordion-item-body -->
        </div><!-- /.accordion-item --> <div class="accordion-item">
          <div class="accordion-item-header">
            Warranty and Repair
          </div><!-- /.accordion-item-header -->
          <div class="accordion-item-body">
            <div class="accordion-item-body-content">
              <?php echo htmlspecialchars_decode(htmlspecialchars($product['warranty'])); ?>
            </div>
          </div><!-- /.accordion-item-body -->
        </div><!-- /.accordion-item -->
      </div>
  </div>
         
	<?php } ?>
      </div>
    </section>
<script>
const imgs = document.querySelectorAll('.img-select a');
const imgBtns = [...imgs];
let imgId = 1;

imgBtns.forEach((imgItem) => {
    imgItem.addEventListener('click', (event) => {
        event.preventDefault();
        imgId = imgItem.dataset.id;
        slideImage();
    });
});

function slideImage(){
    const displayWidth = document.querySelector('.img-showcase img:first-child').clientWidth;

    document.querySelector('.img-showcase').style.transform = `translateX(${- (imgId - 1) * displayWidth}px)`;
}

window.addEventListener('resize', slideImage);
 
const accordionItemHeaders = document.querySelectorAll(".accordion-item-header");

accordionItemHeaders.forEach(accordionItemHeader => {
   accordionItemHeader.addEventListener("click", event => {

     accordionItemHeader.classList.toggle("active");
     const accordionItemBody = accordionItemHeader.nextElementSibling;
     if(accordionItemHeader.classList.contains("active")) {
      accordionItemBody.style.maxHeight = accordionItemBody.scrollHeight + "px";
     }
     else {
       accordionItemBody.style.maxHeight = 0;
     }
    
   });
});
  </script>
	</x-mainpage-layout>