 @foreach ($category as $k => $v)
					  <div id="product_att_{{$k}}">
					 @if($index==$k)
						        <input type="hidden" name="pro_att_id[]" id="pro_att_{{ $k }}">
                                <div class="relative py-[15px] linediv">
                                    <h6 class="text-[#333] text-[18px] font-[700]  bg-[#fff] pr-[10px] relative lineh6">
                                        Select {{ ucwords($v) }} 
										@if(str_contains($v,'size')) <a class="text-[#008C99] text-[14px] cursor-pointer">(See Sizing tab for size guide)</a> @endif
										</h6>
                                </div>
                                <div class="grid-four pb-[10px]">
                                    @foreach ($attribute[$k] as $v1)
									
                                        <button type="button" id="button_{{ $k }}_{{ $v1['product_attr_id'] }}" class="grid-five cursor-pointer hover:ring hover:ring-[#FF9119]-300 attribute_buttons_{{ $k }}" onclick="changeAttribute({{ $v1['product_attr_id'] }},{{ $product['id'] }},{{ $index }},{{ $k }})">
                                            <div class="five-g-img">
                                                <img src="<?php if(isset($v1['image']) && $v1['image']!=''){ echo url('storage/'.$v1['image']); }else{ echo "/img/standard-img.png"; } ?>"  alt="">
                                            </div>
                                            <div class="five-content p-[10px]">
                                                <h6 class="text-[16px] text-[#008C99] font-[700]">{{ $v1['attribute'] }}
                                                </h6>
                                                <p class="text-[14px] text-[#6A6D73]">{{ $v1['small_description'] }}</p>
                                            </div>
                                        </button>
                                    @endforeach
                                </div>
								@endif
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
                            

@push('other-scripts')
<script>
  var total_category={{ count($category) }};
  /* update attribute detail */
  function changeAttribute(product_att_id,product_id,index,k){
	 $("#pro_att_"+k).val(product_att_id);
	 $(".attribute_buttons_"+k).removeClass('attribute_buttons_active');
	 $("#button_"+k+"_"+product_att_id).addClass('attribute_buttons_active');
	  if(index==total_category-1){
		  //Get Variation Price
		   $.ajax({
                url: "{{ route('get-variation-price') }}",
                type: 'POST',
                data:  $("#addtocart").serialize(),
                success: function(response) {
					$('#variation_price_div').html(response);
                },
                error: function(xhr) {
                  
                }
            });
	  }else{
			$.ajax({
                url: "{{ route('product-next-attribute') }}",
                type: 'POST',
                data: {
					"_token": "{{ csrf_token() }}",
                    product_att_id: product_att_id,
                    product_id: product_id,
                    index: index,
                },
                success: function(response) {
					var j=index+1;
					for(var i=j;i<total_category;i++){
						$('#product_att_'+i).html('');
					}
					$('#product_att_'+j).html(response);
                },
                error: function(xhr) {
                  
                }
            });
	  }
  }
  
  
</script>
@endpush