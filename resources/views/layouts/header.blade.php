<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<header>
    <div class="container mx-auto px-2 xl:px-10">
    </div>
</header>
<header class="bg-[#008C99]">
    <div class="ctm-container mx-auto px-4 xl:px-8 lg:block hidden">
        <div class="grid grid-cols-12 py-2 mb-5 border-b-[1px]">
            <div class="col-span-6">
                <div class="slick-slider">
                    <div>
                        <p class="text-[15px] text-[#fff] font-normal mt-1">Thoughtful designs for stronger connections
                            between wheelchairs and people</p>
                    </div>
                    <div>
                        <p class="text-[15px] text-[#fff] font-normal mt-1">Bridging the gap between wheelchairs and
                            people... It's what we do.</p>
                    </div>
                    <div>
                        <p class="text-[15px] text-[#fff] font-normal mt-1">Empowering independence through thoughtful
                            design.</p>
                    </div>
                    <div>
                        <p class="text-[15px] text-[#fff] font-normal mt-1">30+ years of improving lives through
                            innovative
                            positioning.</p>
                    </div>
                </div>
            </div>
            <div class="col-span-6 text-right">
                <div class="h-8 flex justify-end text-[#fff] text-[15px] font-normal">
					 <div class="">
            <div class="flex items-center gap-2">
              <div class="relative">
                <div class="w-[20px] h-[20px]">
                
				  <x-svg name="basket" />
                </div>
                <div class="absolute top-[-6px] right-[-6px]">
                  <span
                    class="w-[16px] h-[16px] bg-white border border-solid border-[#008C9A] text-[10px] font-bold rounded-full text-[#000] flex items-center justify-center">{{ FunHelper::getCartCount() }}</span>
                </div>
              </div>
              <p class="text-lg font-normal">Cart</p>
            </div>
          </div>
                    <x-login-nav />
					
                </div>
            </div>
        </div>
    </div>
    <div class="ctm-container mx-auto px-4 xl:px-8">
        <x-main-nav />
    </div>
</header>


<script>
    $(document).ready(function() {
        $(".slick-slider").slick({
            autoplay: true,
            dots: false,
            arrows: false,
            speed: 2000,
        });
    });
</script>
