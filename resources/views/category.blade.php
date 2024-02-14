<x-mainpage-layout>

    <section class="py-3">
        <div class="ctm-container">

            <?php if (isset($error)) {
                echo $error;
            } else { ?>


                <div class="ctm-prd-one relative overflow-hidden py-[30px] lg:py-[50px] px-[20px] lg:px-[70px] relative bg-no-repeat bg-center bg-cover h-[auto] md:h-[400px] flex justify-center rounded-[20px] after:content-['*'] after:absolute after:top-0 after:bottom-0 after:left-0 after:right-0 after:bg-[#000]/[.5] after:w-full after:h-full" style="background-image: url('<?php echo url('storage/' . $category['image']); ?>')">
                    <img src="{{ asset('img/small-logo.png') }}" class="h-[55px] max-w-[55px] contain absolute right-[10px] top-[10px] z-[1]" alt="">
                    <h3 class="text-[#fff] text-[30px] md:text-[65px] uppercase font-[800] leading-[39px] md:leading-[72px] z-[1]">
                        {{ $category['name'] ?? '' }}
                    </h3>
                    <div class="mt-[10px] text-[18px] text-[#fff] max-w-[670px] z-[1]"><?php echo htmlspecialchars_decode(htmlspecialchars($category['description'])); ?></div>
                </div>
                <div class="prodct-Category mt-[15px] md:mt-[30px]">
                    <div>
                        <div class="bg-[#fff] px-5 pt-5 pb-7 border border-[#ECECEC] rounded-[15px] mb-10" x-data="{ open: true, toggle() { this.open = !this.open }, redirectcat(cate) { window.location = '{{ url('/category/') }}/' + cate; } }">
                            <a @click="toggle()" class="text-[#333] text-[24px] font-[700] flex justify-between items-center pb-5 mb-7 border-b-2 border-[#ECECEC]">Categories
                                <i class="fa fa-chevron-down text-[16px]"></i></a>
                            <div class="filter" x-show="open">
                                @foreach ($categories as $cat)
                                <div class="border border-[#ECECEC] rounded-[5px] p-[10px] flex gap-[15px] mb-[10px]">
                                    <input type="radio" id="{{ $cat['id'] ?? '' }}" class="cursor-pointer" name="fav_language" value="{{ $cat['name'] ?? '' }}" @click="redirectcat('<?php echo str_replace(' ', '-', strtolower(strip_tags($cat['name']))); ?>')"><label for="{{ $cat['id'] ?? '' }}" class="cursor-pointer">{{ $cat['name'] ?? '' }}</label>
                                </div>
                                @endforeach

                            </div>
                        </div>
                        <div class="bg-[#fff] px-5 pt-5 pb-7 border border-[#ECECEC] rounded-[15px] mb-10" x-data="{ open: true, toggle() { this.open = !this.open }, redirectcat(cate) { window.location = '{{ url('/category/') }}/' + cate; } }">
                            <a @click="toggle()" class="text-[#333] text-[24px] font-[700] flex justify-between items-center pb-5 mb-7 border-b-2 border-[#ECECEC]">Sub
                                Categories <i class="fa fa-chevron-down text-[16px]"></i></a>
                            <div class="filter" x-show="open">
                                @foreach ($subcategory as $cat)
                                <div class="border border-[#ECECEC] rounded-[5px] p-[10px] flex gap-[15px] mb-[10px]">
                                    <input class="cursor-pointer" type="radio" id="{{ $cat['id'] ?? '' }}" name="fav_language" value="{{ $cat['name'] ?? '' }}" @click="redirectcat('<?php echo str_replace(' ', '-', strtolower(strip_tags(str_replace('-', '_', $cat['name'])))); ?>')"><label for="{{ $cat['id'] ?? '' }}" class="cursor-pointer">{{ $cat['name'] ?? '' }}</label>
                                </div>
                                @endforeach

                            </div>
                        </div>
                        <div class="bg-[#fff] px-5 pt-5 pb-7 border border-[#ECECEC] rounded-[15px] mb-10" x-data="{ open: true, toggle() { this.open = !this.open }, redirectprod(prod) { window.location = '{{ url('/product/') }}/' + prod; } }">
                            <a @click="toggle()" class="text-[#333] text-[24px] font-[700] flex justify-between items-center pb-5 mb-7 border-b-2 border-[#ECECEC]">Products
                                <i class="fa fa-chevron-down text-[16px]"></i></a>
                            <div class="filter" x-show="open">
                                @foreach ($products as $prod)
                                <div class="border border-[#ECECEC] rounded-[5px] p-[10px] flex gap-[15px] mb-[10px]">
                                    <input type="radio" id="prod{{ $prod['product']['id'] ?? '' }}" name="fav_language" value="{{ $prod['product']['name'] ?? '' }}" @click="redirectprod('<?php echo str_replace(' ', '-', strtolower(strip_tags(str_replace('w/', 'with', str_replace('w/o', 'without', str_replace('™', '-tm', str_replace('®', '-r', str_replace('-', '_', $prod['product']['name'])))))))); ?>')" class="cursor-pointer"><label for="prod{{ $prod['product']['id'] ?? '' }}" class="cursor-pointer">{{ $prod['product']['name'] ?? '' }}</label>
                                </div>
                                @endforeach

                            </div>
                        </div>
                        <button class="p-2 bg-[#fe7300] hover:bg-[#e96a00] text-white text-[20px] font-[500] w-[100%] rounded-[10px]">Reset</button>
                    </div>
                    <div class="product-details">
                        <h5 class="text-[#233049] text-[32px] capitalize mb-[20px] md:mb-[30px] font-[600]">
                            {{ $category['name'] ?? '' }} Products
                        </h5>
                        <div class="product-grid-three" x-data="{ redirectprod(prod) { window.location = '{{ url('/product/') }}/' + prod; } }">
                            @foreach ($products as $prod)
                            <div class="relative bg-[#fff] rounded-[15px] p-5 border border-[#ECECEC] h-[auto] cursor-pointer" @click="redirectprod('<?php echo str_replace(' ', '-', strtolower(strip_tags(str_replace('w/', 'with', str_replace('w/o', 'without', str_replace('™', '-tm', str_replace('®', '-r', str_replace('-', '_', $prod['product']['name'])))))))); ?>')">
                                <img src="{{ asset('img/small-logo-white.png') }}" class="absolute top-[8px] right-[8px] h-[40px] max-w-[40px] " alt="">
                                <img src="<?php if (isset($prod['product']['media'][0])) {
                                                echo url('storage/' . $prod['product']['media'][0]['id'] . '/' . $prod['product']['media'][0]['file_name']);
                                            } else {
                                                echo url('img/logo.png');
                                            } ?>" class="mx-auto min-h-[150px] max-h-[150px] object-contain" alt="">
                                <div class="product-card-content">
                                    <h6 class="text-[18px] text-[#008C99] mb-2 mt-3 font-[600] lg:text-left text-center lg:min-h-[54px] lg:max-h-[54px]">
                                        {{ $prod['product']['name'] ?? '' }}
                                    </h6>
                                    <p class="text-[14px] text-[#ADADAD] leading-[20px] lg:text-left text-center">
                                        <?php echo substr(htmlspecialchars_decode(str_replace('</div>', '', str_replace('<div>', '', $prod['product']['description']))), 0, 100) ?? ''; ?>.....
                                    </p>
                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>
</x-mainpage-layout>