 @foreach ($category as $k => $v)
     <div id="product_att_{{ $k }}">
         @if ($index == $k)
             <input type="hidden" name="pro_att_id[]" id="pro_att_{{ $k }}">
             <div class="relative py-[15px] linediv">
                 <h6 class="text-[#333] text-[18px] font-[700]  bg-[#fff] pr-[10px] relative lineh6">
                     Select {{ ucwords($v) }}
                     @if (str_contains($v, 'size'))
                         <a class="text-[#00838f] text-[14px] cursor-pointer" href="#accordion-collapse-heading-2">(See
                             Sizing tab for size guide)</a>
                     @endif
                 </h6>
             </div>
             <div class="grid-four pb-[10px]">
                @php $attr_count = count($attribute[$k]); @endphp
                 @foreach ($attribute[$k] as $v1)
                     <button type="button" id="button_{{ $k }}_{{ $v1['product_attr_id'] }}"
                         class="grid-five cursor-pointer hover:ring hover:ring-[#FF9119]-300 attribute_buttons_{{ $k }}"
                         data-description="{{ $v1['small_description'] }}" data-title="{{ $v1['attribute'] }}"
                         onclick="changeAttribute({{ $v1['product_attr_id'] }},{{ $product['id'] }},{{ $index }},{{ $k }},{{$attr_count}}, this)">
                         <div class="five-g-img">
                             <img src="<?php if (isset($v1['image']) && $v1['image'] != '') {
                                 echo url('storage/' . $v1['image']);
                             } else {
                                 echo '/img/standard-img.png';
                             } ?>" alt="">
                         </div>
                         <div class="five-content p-[10px]">
                             <h6 class="text-[16px] text-[#00838f] font-[700]">{{ $v1['attribute'] }}
                             </h6>
                             <p class="text-[14px] text-[#6A6D73]">{{ $v1['small_description'] }}</p>
                         </div>
                     </button>
                 @endforeach
             </div>
         @endif
     </div>
 @endforeach

 @push('other-scripts')
     <script>
         var total_category = {{ count($category) }};
         var originalSrcs = {};

         $('.slider-for').on('beforeChange', function(event, slick, currentSlide) {
             
             $(slick.$slides).each(function(index, slide) {
                 let slideImg = $(slide).find('img');
                 if (!originalSrcs[index]) { 
                     originalSrcs[index] = slideImg.attr('src');
                     slideImg.attr('data-original-src', slideImg.attr('src'));
                 }
             });

             
             let currentImg = $(slick.$slides[currentSlide]).find('img');
             if (currentImg.attr('data-original-src')) {
                 currentImg.attr('src', currentImg.attr('data-original-src'));
             }
         });
        //  $('.slider-for').on('afterChange', function(event, slick, currentSlide) {

        //      $(slick.$slides).each(function(index, slide) {
        //          let slideImg = $(slide).find('img');
        //          if (!originalSrcs[index]) { 
        //              originalSrcs[index] = slideImg.attr('src');
        //              slideImg.attr('data-original-src', slideImg.attr('src'));
        //          }
        //      });

             
        //      let currentImg = $(slick.$slides[currentSlide]).find('img');
        //      if (currentImg.attr('data-original-src')) {
        //          currentImg.attr('src', currentImg.attr('data-original-src'));
        //      }
        //  });
        
         function changeAttribute(product_att_id, product_id, index, k,attr_count = 0, el = null) {

             const imgElement = el.querySelector('.five-g-img img');
             const imageUrl = imgElement?.src;

             if (imageUrl) {
                 let activeSlide = $('.slider-for .slick-current.slick-active img');
                 let slideIndex = $('.slider-for .slick-current.slick-active').index();


                 if (!originalSrcs[slideIndex]) {
                     originalSrcs[slideIndex] = activeSlide.attr('src');
                     activeSlide.attr('data-original-src', activeSlide.attr('src'));
                 }


                 activeSlide.attr('src', imageUrl);
             }
             const description = el.getAttribute('data-description');
             const title = el.getAttribute('data-title');

             if (title) {
                 
                 const firstSection = document.querySelector('.slider-for .slick-current.slick-active img');

                 if (firstSection) {
                     const existingDescriptionContainer = document.querySelector('.description-container');
                     if (existingDescriptionContainer) {
                         existingDescriptionContainer.remove(); // Remove the existing container
                     }
                     const descriptionContainer = document.createElement('div');
                     descriptionContainer.className = 'description-container';
                     descriptionContainer.style.cssText = `
                        border-top: 1px solid #ececec;
                        padding: 15px;
                        margin-top: 20px;
                        width: 100%;
                        text-align: center;
                        position: absolute;
                        bottom: 0px;                     
                    `;

                     if (title) {
                         const titleElement = document.createElement('h4');
                         titleElement.style.cssText = 'margin: 0 0 10px; font-weight: bold; font-size: 18px;';
                         titleElement.textContent = title;
                         descriptionContainer.appendChild(titleElement);
                     }

                     if (description) {
                         const descriptionElement = document.createElement('p');
                         descriptionElement.style.cssText = 'margin: 0; font-size: 14px; color: #555;';
                         descriptionElement.textContent = description;
                         descriptionContainer.appendChild(descriptionElement);
                     }

                     // descriptionContainer.inner = description;

                     // Insert the container after the first section
                     // Remove below comment to show variation names under the product image on change
                     //firstSection.insertAdjacentElement('afterend', descriptionContainer);
                 }

             }
             var rootAttributeId = $("#pro_att_0").val();
             $("#pro_att_" + k).val(product_att_id);
             $(".attribute_buttons_" + k).removeClass('attribute_buttons_active');
             $("#button_" + k + "_" + product_att_id).addClass('attribute_buttons_active');
             if (index == total_category - 1) {
                 //Get Variation Price
                 $.ajax({
                     url: "{{ route('get-variation-price') }}",
                     type: 'POST',
                     data: $("#addtocart").serialize(),
                     success: function(response) {
                         if (response.product_available || !response.is_auth_user) {
                             $('#variation_price_div').html(response.html);
                         } else {
                             $('#variation_price_div').html(
                                 '<div class="out-off-stock"><h1>Price of this product is not available. Please contact support.</h1></div>'
                             );
                         }
                     },
                     error: function(xhr) {

                     }
                 });
             } else {
                 $('#variation_price_div').html('');
                 $.ajax({
                     url: "{{ route('product-next-attribute') }}",
                     type: 'POST',
                     data: {
                         "_token": "{{ csrf_token() }}",
                         product_att_id: product_att_id,
                         product_id: product_id,
                         index: index,
                         rootAttributeId:rootAttributeId,
                         attr_count:attr_count
                     },
                     success: function(response) {
                         var j = index + 1;
                         for (var i = j; i < total_category; i++) {
                             $('#product_att_' + i).html('');
                         }
                         $('#product_att_' + j).html(response);
                     },
                     error: function(xhr) {

                     }
                 });
             }
         }
     </script>
 @endpush
