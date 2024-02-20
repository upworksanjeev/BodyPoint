<x-mainpage-layout>

    <section class="py-[30px] md:py-[60px]">
        <div class="ctm-container">
            <?php if(isset($error)){ echo $error; }else{ ?>


            <div class="antialiased">
                <div class="ctm-container-two mt-[50px]">
                    <div class="flex flex-col md:flex-row -mx-4">
                        <div class="md:flex-1 lg:px-5">
                            <div class = "product-imgs">
                                <div class = "img-display">
                                    <div class = "img-showcase">
                                        @foreach ($product['media'] as $media)
                                            <img src = "<?php echo url('storage/' . $media['id'] . '/' . $media['file_name']); ?>" alt = "{{ $product['name'] ?? '' }}">
                                        @endforeach
                                    </div>
                                </div>
                                <div class = "img-select">
                                    <?php $k = 1; ?>
                                    @foreach ($product['media'] as $media)
                                        <div class = "img-item">
                                            <a href = "#" data-id = "{{ $k }}">
                                                <img src = "<?php echo url('storage/' . $media['id'] . '/' . $media['file_name']); ?>">
                                            </a>
                                        </div>
                                        <?php $k++; ?>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                        <div class="md:flex-1 lg:px-5 ctm-mobile-mrgn">
                            <h2 class="text-[#333] text-[30px] font-[700]">{{ $product['name'] ?? '' }}</h2>
                            <p class="text-[#008C99] text-[18px] ">{{ $product['small_description'] ?? '' }}</p>
                            @foreach ($category as $k => $v)
                                <div class="relative py-[15px] linediv">
                                    <h6 class="text-[#333] text-[18px] font-[700]  bg-[#fff] pr-[10px] relative lineh6">
                                        Select {{ $v }}</h6>
                                </div>
                                <div class="grid-four pb-[10px]">
                                    @foreach ($attribute[$k] as $v1)
                                        <div class="grid-five">
                                            <div class="five-g-img">
                                                <img src="/img/standard-img.png" alt="">
                                            </div>
                                            <div class="five-content p-[10px]">
                                                <h6 class="text-[16px] text-[#008C99] font-[700]">{{ $v1 }}
                                                </h6>
                                                <p class="text-[14px] text-[#6A6D73]">Comfortable with a controlled
                                                    amount of stretch</p>
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
									 @if ($product['discount']>0)
									<p class="text-[14px] text-[#6A6D73]">Discounted Price</p>
									<p class="text-[14px] text-[#6A6D73]">Discount</p>
									@endif
                                </div>
                                <div class="right-price">
                                    <div class="text-set">
                                        <p class="text-[14px] text-[#6A6D73]">@if (isset($product['msrp'])) ${{ $product['msrp'] ?? '' }} EA @endif</p>
                                        <h6 class="text-[16px] text-[#000] font-[500]">@if (isset($product['price'])) ${{ $product['price'] ?? '' }} EA @endif</h6>
										 @if ($product['discount']>0)
										<p class="text-[14px] text-[#6A6D73]">${{ $product['discount_price'] ?? '' }} EA</p>
										<p class="text-[14px] text-[#6A6D73]">${{ $product['discount_in_price'] ?? '' }} ({{ $product['discount'] ?? '' }}% Off)</p>
										@endif
                                    </div>
									<form name="addtocart" method="POST" action="{{ url('/cart') }}">
									 @csrf
									<input type="hidden" name="price" value="{{ $product['price'] ?? '' }}">
									<input type="hidden" name="discount_price" value="{{ $product['discount_price'] ?? '' }}">
									<input type="hidden" name="discount" value="{{ $product['discount'] ?? '' }}">
									<input type="hidden" name="product_id" value="{{ $product['id'] ?? '' }}">
									<input type="hidden" name="product_attributes[]" value="">
                                    <button type="submit" class="bg-[#fe7300] hover:bg-[#e96a00] py-[10px] px-[25px] text-[16px] text-[#fff]">Add To Cart</button>
									</form>
                                </div>
                            </div>
                            <div class="detactor">
                                <div class="detactor-left">
                                    <p class="text-[#000] flex items-center gap-[10px]"><i
                                            class="fas fa-map-marker-alt text-[20px]"></i> <span
                                            class="text-[18px]">Find a Dealer</span></p>
                                </div>
                                <div class="detactor-right">
                                    <button
                                        class="bg-[#373B3C] rounded-[3px] py-[8px] px-[30px] text-[#fff] border border-[#373B3C] mr-[8px]">Save</button>
                                    <button
                                        class="border border-[#373B3C] text-[#373B3C] py-[8px] px-[30px]">Print</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <?php } ?>
        </div>
    </section>
    <section class="bg-[#f5f5f7]">
        <div class="ctm-container py-[30px] md:py-[60px]">
            <div class="chest-support">
                <div class="chest-img">
                    <iframe src="{{ $product['video'] ?? 'https://www.youtube.com/embed/-Yb6Ahx3gB8' }}"
                        class="w-full aspect-video rounded-lg" height="350"></iframe>
                </div>
                <div class="chest-content">
                    <h6 class="text-[#333] text-[20px] md:text-[30px] font-[600]">
                        {{ $product['small_description'] ?? '' }}</h6>
                    <p class="text-[#333] text-[16px] mt-[10px]"><?php echo htmlspecialchars_decode(htmlspecialchars($product['description'])); ?></p>
                </div>
            </div>
        </div>
    </section> 

    <section class="py-[30px] md:py-[60px]">
        <div class="max-w-screen-xl mx-auto ctm-accordion xl:px-0 lg:px-8 md:px-6 px-4">
            <div class="accordion">
                <div class="accordion-item border border-solid border-[#e5e6e7] rounded-lg">
                    <div class="accordion-item-header items-center bg-[#008c99] text-[#fff] rounded-lg">
                        <span class="w-[28px] h-[28px] mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                <path
                                    d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" fill="#fff" />
                            </svg>
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
                    <div class="accordion-item-header items-center bg-[#008c99] text-[#fff] rounded-lg">
                        <span class="w-[28px] h-[28px] mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path
                                    d="M.2 468.9C2.7 493.1 23.1 512 48 512l96 0 320 0c26.5 0 48-21.5 48-48l0-96c0-26.5-21.5-48-48-48l-48 0 0 80c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-80-64 0 0 80c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-80-64 0 0 80c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-80-80 0c-8.8 0-16-7.2-16-16s7.2-16 16-16l80 0 0-64-80 0c-8.8 0-16-7.2-16-16s7.2-16 16-16l80 0 0-64-80 0c-8.8 0-16-7.2-16-16s7.2-16 16-16l80 0 0-48c0-26.5-21.5-48-48-48L48 0C21.5 0 0 21.5 0 48L0 368l0 96c0 1.7 .1 3.3 .2 4.9z" fill="#fff" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                <path
                                    d="M96 0C43 0 0 43 0 96V416c0 53 43 96 96 96H384h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V384c17.7 0 32-14.3 32-32V32c0-17.7-14.3-32-32-32H384 96zm0 384H352v64H96c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16zm16 48H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16s7.2-16 16-16z" fill="#fff" />
                            </svg>
                        </span>
                        Instructions For Use
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
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path
                                    d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM169.8 165.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z" fill="#fff" />
                            </svg>
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
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path
                                    d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z" fill="#fff" />
                            </svg>
                        </span>
                        Warranty
                    </div><!-- /.accordion-item-header -->
                    <div class="accordion-item-body">
                        <div class="accordion-item-body-content border-t-0">
                            <?php echo htmlspecialchars_decode(htmlspecialchars($product['warranty'])); ?>
                        </div>
                    </div><!-- /.accordion-item-body -->
                </div>
            </div>
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
</x-mainpage-layout>
