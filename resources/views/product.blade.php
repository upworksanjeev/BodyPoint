<x-mainpage-layout>
    @if(isset($product))
    <section class="py-[30px] md:py-[60px]">
        <div class="ctm-container">
            @if(isset($error)) 
			{{ $error }}
            @else


                <div class="antialiased">
                    <div class="ctm-container-two mt-[50px]">
                        <div class="flex flex-wrap flex-col md:flex-row -mx-4">
                            <div class="md:flex-1 lg:px-5 product-outer-box">                               
                         
                                <div class="product-images-box">
                                    <div class="slider slider-for">
									@foreach ($product['media'] as $media)<div>
                                            <img src="{{ url('storage/' . $media['id'] . '/' . $media['file_name']); }}" alt="{{ $product['name'] ?? '' }}"></div>
                                            @endforeach
											
                                        
                                           
                                        
                                    </div>
                                    <div class="slider slider-nav">
									<?php $k = 1; ?>
                                        @foreach ($product['media'] as $media)
                                        <div>
                                            <a href="#" data-id="{{ $k }}">
                                                <img src="{{ url('storage/' . $media['id'] . '/' . $media['file_name']); }}">
                                            </a>
                                        </div>
                                        <?php $k++; ?>
                                        @endforeach
                                      
                                    </div>
                                </div>
                            </div>
                            <div class="md:flex-1 lg:px-5 ctm-mobile-mrgn product-outer-box">
                                <h2 class="text-[#333] text-[30px] font-[700]">{{ $product['name'] ?? '' }}</h2>
                                <p class="text-[#008C99] text-[18px] ">{{ $product['small_description'] ?? '' }}</p>
                                <form name="addtocart" id="addtocart" method="POST" action="{{ route('cart.save') }}">
                                    @csrf
                                    <input type="hidden" name="product_id" id="product_id" value="{{ $product['id'] ?? '' }}">
                                    <x-attribute index="0" :attribute="$attribute" :category="$category" :product="$product" />
                                    <div id="variation_price_div">
                                        @if($product['product_type']!="Option")
                                        <x-product-price :product="$product" />
                                        @endif
                                    </div>
                                </form>


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

           @endif
        </div>
    </section>
   
    <section class="bg-[#f5f5f7]">
        <div class="ctm-container py-[30px] md:py-[60px]">
            <div class="chest-support">
                <div class="chest-img">
                    <iframe src="{{ $product['video'] ?? 'https://www.youtube.com/embed/-Yb6Ahx3gB8' }}" class="w-full aspect-video rounded-lg" height="350"></iframe>
                </div>
                <div class="chest-content">
                    <h6 class="text-[#333] text-[20px] md:text-[30px] font-[600]">
                        {{ $product['small_description'] ?? '' }}
                    </h6>
                    <p class="text-[#333] text-[16px] mt-[10px]"><?php echo htmlspecialchars_decode(htmlspecialchars($product['description'])); ?></p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-[30px] md:py-[60px]">
        <div class="max-w-screen-xl mx-auto ctm-accordion xl:px-0 lg:px-8 md:px-6 px-4">
            <div class="accordion" id="accordion">
                <div class="accordion-item border border-solid border-[#e5e6e7] rounded-lg">
                    <div class="accordion-item-header items-center bg-[#008c99] text-[#fff] rounded-lg">
                        <span class="w-[28px] h-[28px] mr-4">
                            <x-icons.eye />

                        </span>
                        Overview
                    </div><!-- /.accordion-item-header -->
                    <div class="accordion-item-body">
                        <div class="accordion-item-body-content border-t-0">
                            <?php echo htmlspecialchars_decode(htmlspecialchars($product['overview'])); ?>
                        </div>
                    </div><!-- /.accordion-item-body -->
                </div>
                <div class="accordion-item border border-solid border-[#e5e6e7] rounded-lg">
                    <div class="accordion-item-header items-center bg-[#008c99] text-[#fff] rounded-lg" id="accordion-collapse-heading-2">
                        <span class="w-[28px] h-[28px] mr-4">
                            <x-icons.sizing />
                        </span>
                        Sizing
                    </div><!-- /.accordion-item-header -->
                    <div class="accordion-item-body">
                        <div class="accordion-item-body-content border-t-0">
                            <?php echo htmlspecialchars_decode(htmlspecialchars($product['sizing'])); ?>
                        </div>
                    </div><!-- /.accordion-item-body -->
                </div>
                <div class="accordion-item border border-solid border-[#e5e6e7] rounded-lg">
                    <div class="accordion-item-header items-center bg-[#008c99] text-[#fff] rounded-lg">
                        <span class="w-[28px] h-[28px] mr-4">
                            <x-icons.instruction />

                        </span>
                        Documents
                    </div><!-- /.accordion-item-header -->
                    <div class="accordion-item-body">
                        <div class="accordion-item-body-content border-t-0">
                            <?php echo htmlspecialchars_decode(htmlspecialchars($product['instruction_of_use'])); ?>
                        </div>
                    </div><!-- /.accordion-item-body -->
                </div>
                <div class="accordion-item border border-solid border-[#e5e6e7] rounded-lg">
                    <div class="accordion-item-header items-center bg-[#008c99] text-[#fff] rounded-lg">
                        <span class="w-[28px] h-[28px] mr-4">
                            <x-icons.faq />

                        </span>
                        FAQ's
                    </div><!-- /.accordion-item-header -->
                    <div class="accordion-item-body">
                        <div class="accordion-item-body-content border-t-0">
                            <?php echo htmlspecialchars_decode(htmlspecialchars($product['warranty'])); ?>
                        </div>
                    </div><!-- /.accordion-item-body -->
                </div>
                <div class="accordion-item border border-solid border-[#e5e6e7] rounded-lg">
                    <div class="accordion-item-header items-center bg-[#008c99] text-[#fff] rounded-lg">
                        <span class="w-[28px] h-[28px] mr-4">
                            <x-icons.setting />

                        </span>
                        Warranty
                    </div><!-- /.accordion-item-header -->
                    <div class="accordion-item-body">
                        <div class="accordion-item-body-content border-t-0">
                            <h1>LIMITED LIFETIME WARRANTY</h1>
                            <br />
                            <p>Most products manufactured by Bodypoint carry a limited lifetime warranty against defects in workmanship and materials arising under normal use by the original consumer. Product specifications are subject to change. For current specifications and warranty details, contact your local Independent Distributor or contact Customer Service at sales@bodypoint.com or 1-800-547-5716.</p>
                            <br />
                            <h1>Limitations on Warranties</h1>
                            <br />
                            <p>The warranties described herein do not extend to normal wear and tear; to products that have been subject to misuse, accident or tampering; nor to products that have been modified in any way other than that specifically described in the product instructions. Normal wear and tear is damage that naturally and inevitably occurs as a result of typical use. Purchaser’s sole remedy for defective products shall be repair, replacement or account adjustment at the discretion of Bodypoint. In all circumstances Bodypoint reserves the right to substitute an equivalent product or refund the purchase price of the original product.</p>
                            <br />
                            <p>THE FOREGOING WARRANTIES ARE IN LIEU OF ALL OTHER WARRANTIES EXPRESSED OR IMPLIED, INCLUDING WITHOUT LIMITATION, IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE. IN NO EVENT SHALL BODYPOINT BE LIABLE FOR ANY SPECIAL, INDIRECT, INCIDENTAL OR CONSEQUENTIAL LOSSES OR DAMAGES RESULTING FROM THE USE OF THE PRODUCT, INCLUDING WITHOUT LIMITATION, LOSS OF ANTICIPATED PROFITS, EVEN IF BODYPOINT SHALL HAVE BEEN ADVISED OF THE POSSIBILITY OF SUCH POTENTIAL LOSS OR DAMAGE. BODYPOINT SHALL NOT BE LIABLE FOR ANY LOSS OR DAMAGE CAUSED BY DELAY IN FURNISHING PRODUCT.</p>
                            <br />
                            <p>Bodypoint does not authorize any distributor, dealer, agent, sales person or any third party to change the terms or coverage of this warranty, and any such change shall be null and void. This warranty is non-transferable. This warranty will be governed in accordance with the laws of the State of Washington. The customer consents that jurisdiction under Venue for any action shall be in King County Washington. This warranty information is reprinted here for information purposes only and is subject to change without notice.</p><br />
                            <?php echo htmlspecialchars_decode(htmlspecialchars($product['warranty'])); ?>
                        </div>
                    </div><!-- /.accordion-item-body -->
                </div>
            </div>
        </div>
    </section>
    <x-success-story :product="$product" />
    @else
    <p>No Product Found</p>
    @endif

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

        function slideImage() {
            const displayWidth = document.querySelector('.img-showcase img:first-child').clientWidth;

            document.querySelector('.img-showcase').style.transform = `translateX(${- (imgId - 1) * displayWidth}px)`;
        }

        window.addEventListener('resize', slideImage);

        const accordionItemHeaders = document.querySelectorAll(".accordion-item-header");

        accordionItemHeaders.forEach(accordionItemHeader => {
            accordionItemHeader.addEventListener("click", event => {

                accordionItemHeader.classList.toggle("active");
                const accordionItemBody = accordionItemHeader.nextElementSibling;
                if (accordionItemHeader.classList.contains("active")) {
                    accordionItemBody.style.maxHeight = accordionItemBody.scrollHeight + "px";
                } else {
                    accordionItemBody.style.maxHeight = 0;
                }

            });
        });
    </script>
    <script>
        $('.slider-for').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '.slider-nav'
        });
        $('.slider-nav').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            asNavFor: '.slider-for',
            dots: false,
            centerMode: false,
            focusOnSelect: true,
            responsive: [
            {
            breakpoint: 1024,
            settings: {
                slidesToShow: 4,
                slidesToScroll: 4,
                infinite: true,
                dots: true
            }
            },
            {
            breakpoint: 575,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1
            }
            }
        ]
        });
    </script>
</x-mainpage-layout>