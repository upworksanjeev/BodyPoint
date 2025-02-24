<x-mainpage-layout>
    @if(isset($product))
    @section('title', $product['name'] ?? " " . ' - ' . config('app.name', 'Bodypoint'))
        <section class="py-[15px] md:py-[40px]">
            <div class="ctm-container">
                @if(isset($error))
                    {{ $error }}
                @else
                @php
                $sortedMedia = collect($product['media'])->sortBy('order_column')->values()->all();
                @endphp
                    <div class="antialiased">
                        <div class="ctm-container-two">
                            <div class="flex flex-wrap flex-col md:flex-row -mx-4">
                                <div class="md:flex-1 lg:px-5 product-outer-box">
                                    <div class="product-images-box">
                                        <div class="slider slider-for">
                                            @foreach ($sortedMedia as $media)<div>
                                                <img src="{{ url('storage/' . $media['id'] . '/' . $media['file_name']); }}" alt="{{ $product['name'] ?? '' }}"></div>
                                            @endforeach
                                        </div>
                                        <div class="slider slider-nav">
                                            <?php $k = 1; ?>
                                            @foreach ($sortedMedia as $media)
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
                                    <p class="text-[#00838f] text-[18px] ">{{ $product['small_description'] ?? '' }}</p>
                                    {{-- <p class="text-[#00838f] text-[18px] ">{{ $product['sku'] ?? '' }}</p> --}}
                                    <form name="addtocart" id="addtocart" method="POST" action="{{ route('cart.save') }}">
                                        @csrf
                                        <input type="hidden" name="product_id" id="product_id" value="{{ $product['id'] ?? '' }}">
                                        <x-attribute index="0" :attribute="$attribute" :category="$category" :product="$product" />
                                        <div id="variation_price_div">
                                            @if(auth()->user())
                                                @php
                                                    $found = false;
                                                @endphp
                                                @if(!empty(session('stock_details')))
                                                    @php
                                                        $customer = getCustomer();
                                                        $price = 0;
                                                        $stock = array_search($product['sku'],array_column(session('customer_details')['PriceList'], 'StockCode'));
                                                    @endphp
                                                    @if(!empty($stock) && $customer->hasPermissionTo('productConfigurator'))
                                                        @if($product['product_type'] != "Option")
                                                            <x-product-price :product="$product" />
                                                        @endif
                                                        @php
                                                            $found = true;
                                                        @endphp
                                                    @endif
                                                    @if((!$found && $product['product_type'] !="Option") || (!$found && $product['product_type'] == 'Option' && $product->attribute->isEmpty()))
                                                        <div class="out-off-stock">
                                                            <h1>Price of this product is not available. Please contact support.</h1>
                                                        </div>
                                                    @endif
                                                @endif
                                            @endif
                                        </div>
                                    </form>
                                    <div class="detactor">
                                        <div class="detactor-left">
                                            @if($showFindPartnerButton ?? false)
                                             <p class="text-[#000] flex items-center gap-[10px]"><i class="fas fa-map-marker-alt text-[20px]"></i> <span class="btn text-[18px]"><a href="{{$partnerPageURl}}"  target="_blank"><button class="bg-[#FE7300] rounded-lg text-white text-base font-medium min-w-[180px] p-4 lg:block hidden" >Find a Partner </button></a></span></p>
                                            @endif
                                           
                                        </div>
                                        <div class="detactor-right">
                                            {{-- <button class="bg-[#373B3C] rounded-[3px] py-[8px] px-[30px] text-[#fff] border border-[#373B3C] mr-[8px]">Save</button> --}}
                                            <button onclick="window.print()" class="border border-[#373B3C] text-[#373B3C] py-[8px] px-[30px]">Print</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <section class="bg-[#f5f5f7] max-w-screen-xl mx-auto ">
                @if(!empty($product['video']))
                <div class="ctm-container py-[30px] md:py-[60px]">
                    <div class="chest-support">
                        <div class="chest-img">
                            <iframe src="{{ $product['video'] ?? '' }}" class="w-full aspect-video rounded-lg" height="350"></iframe>
                        </div>
                    </div>
                </div>
                </div>
                @endif
                <div class="ctm-container ">
                    <div class="chest-content">
                        <h6 class="text-[#333] text-[20px] md:text-[30px] font-[600]">
                            {{ $product['small_description'] ?? '' }}
                        </h6>
                    </div>
                    <p class="text-[#333] text-[16px] mt-[10px]"><?php echo htmlspecialchars_decode(htmlspecialchars($product['description'])); ?></p>
                </div>
        </section>

        <section class="py-[30px] md:pt-[20px] md:pb-[60px]">
            <div class="max-w-screen-xl mx-auto ctm-accordion xl:px-0 lg:px-8 md:px-6 px-4">
                <div class="accordion" id="accordion">
                    <div class="accordion-item border border-solid border-[#e5e6e7] rounded-lg">
                        <div class="accordion-item-header items-center bg-[#00838f] text-[#fff] rounded-lg">
                            <span class="w-[28px] h-[28px] mr-4">
                                <x-icons.eye />

                            </span>
                            Overview
                        </div><!-- /.accordion-item-header -->
                        <div class="accordion-item-body">
                            <div class="accordion-item-body-content border-t-0">
                                @if(!empty($product->overview))
                                {!! $product->overview !!}
                                @else
                                No Data Exists
                                @endif
                            </div>
                        </div><!-- /.accordion-item-body -->
                    </div>
                    <div class="accordion-item border border-solid border-[#e5e6e7] rounded-lg">
                        <div class="accordion-item-header items-center bg-[#00838f] text-[#fff] rounded-lg" id="accordion-collapse-heading-2">
                            <span class="w-[28px] h-[28px] mr-4">
                                <x-icons.sizing />
                            </span>
                            Sizing
                        </div><!-- /.accordion-item-header -->
                        <div class="accordion-item-body">
                            <div class="accordion-item-body-content border-t-0">
                                @if(!empty($product->sizing))
                                {!! $product->sizing !!}
                                @else
                                No Data Exists
                                @endif
                            </div>
                        </div><!-- /.accordion-item-body -->
                    </div>
                    <div class="accordion-item border border-solid border-[#e5e6e7] rounded-lg">
                        <div class="accordion-item-header items-center bg-[#00838f] text-[#fff] rounded-lg">
                            <span class="w-[28px] h-[28px] mr-4">
                                <x-icons.instruction />

                            </span>
                            Documents
                        </div><!-- /.accordion-item-header -->
                        <div class="accordion-item-body">
                            <div class="accordion-item-body-content border-t-0">
                                @if(!empty($product->instruction_of_use))
                                {!! $product->instruction_of_use!!}
                                @else
                                No Data Exists
                                @endif
                            </div>
                        </div><!-- /.accordion-item-body -->
                    </div>
                    <div class="accordion-item border border-solid border-[#e5e6e7] rounded-lg">
                        <div class="accordion-item-header items-center bg-[#00838f] text-[#fff] rounded-lg">
                            <span class="w-[28px] h-[28px] mr-4">
                                <x-icons.faq />

                            </span>
                            FAQ's
                        </div><!-- /.accordion-item-header -->
                        <div class="accordion-item-body">
                            <div class="accordion-item-body-content border-t-0">
                                @if(!empty($product->warranty))
                                {!! $product->warranty !!}
                                @else
                                No Data Exists
                                @endif
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
        setTimeout(function() {
            window.location.reload();
        }, 1800000);

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
            responsive: [{
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

    
<script>
    // Declare the variable outside of the event listeners
let productsAddedToCartModal = 0;


</script>
@push('other-scripts')
{{-- <script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.productOverviewLeft a[href="https://www.bodypoint.com/ECommerce/product/hbqb/standards.aspx"]').forEach(link => {
            let img = link.querySelector('img'); // Get the image inside <a>
            if (img) {
                link.replaceWith(img); // Replace <a> with the <img>
            } else {
                link.remove(); // If no image, just remove the <a>
            }
        });
    });
</script> --}}
@endpush
</x-mainpage-layout>
