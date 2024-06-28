<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<header>
    <div class="container mx-auto px-2 xl:px-10">
    </div>
</header>
<header class="bg-[#00838f] sticky top-0 z-50" id="app-site-header">
    <div class="ctm-container mx-auto px-4 xl:px-8 lg:block hidden">
        <div class="grid grid-cols-12 py-2 top-navbar items-center h-[43px]">
            <div class="col-span-6">
                <div class="slick-slider">
                    <div>
                        <p class="text-[15px] text-[#fff] font-normal">Thoughtful designs for stronger connections
                            between wheelchairs and people</p>
                    </div>
                    <div>
                        <p class="text-[15px] text-[#fff] font-normal">Bridging the gap between wheelchairs and
                            people... It's what we do.</p>
                    </div>
                    <div>
                        <p class="text-[15px] text-[#fff] font-normal">Empowering independence through thoughtful
                            design.</p>
                    </div>
                    <div>
                        <p class="text-[15px] text-[#fff] font-normal">30+ years of improving lives through innovative positioning.</p>
                    </div>
                </div>
            </div>
            <div class="col-span-6 text-right">
                <div class="flex justify-end text-[#fff] text-[15px] leading-7 font-normal items-center">
                    <div id="cart_count_div">
                        <x-cart.cart-count />
                    </div>
                    <div class="pe-5">
                        <a href="{{ config('bodypoint.home_url') }}/vault/" class="hover:text-[#fe7300] transition duration-150 ease-in-out">
                            <div class="flex items-center">
                                <i class="fa fa-briefcase text-[18px] pr-2" aria-hidden="true"></i>
                                <p class="text-[15px] font-light">Vault</p>
                            </div>
                        </a>
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
        $(window).on('scroll', function() {
            if ($(window).scrollTop() > 100) {
                $('#app-site-header').addClass('header-small');
            } else {
                $('#app-site-header').removeClass('header-small');
            }
        });
        $(".slick-slider").slick({
            autoplay: true,
            dots: false,
            arrows: false,
            speed: 2000,
        });
    });
</script>