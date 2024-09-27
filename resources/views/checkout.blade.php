<x-mainpage-layout>
  <x-cart-nav />

  <section class="bg-[#F6F6F6] py-9 lg:px-0 px-4">
    <div class="container mx-auto">
      <div class="max-w-screen-xl mx-auto">
        <x-checkout-header page="checkout" />

        <div class="pb-6">
          <p class="text-[13px] font-normal leading-[19px] text-center">Your order summary is provided below. Please review carefully and click confirm order to process your order. Click cancel to return to your shopping cart.</p>
        </div>

        <div class="card w-full max-w-[920px] m-auto bg-white border border-gray-200 rounded-2xl shadow mb-4">
          <div class="card-header px-6 py-2 bg-[#00838f] rounded-t-xl">
            <h4 class="text-[#fff]">Order Information</h4>
          </div>
          <div class="card-body p-6">
            <ul class="max-w-md space-y-5 text-gray-500 list-disc list-inside">
              <li class="flex items-start gap-5">
                <span class="text-sm text-[#000] font-normal leading-[17px]">Account</span>
                <span class="text-sm text-[#000] font-normal leading-[17px]">{{ $user->email }}</span>
              </li>
              {{-- <li class="flex items-center gap-5">
                <span class="text-sm text-[#000] font-normal leading-[17px]">Purchase Order #:</span>
                <input class="py-[2px] px-5 text-sm font-medium focus:outline-none rounded-full border border-[#31BA32] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center" value="{{ $purchase_order_no }}" name="purchase_no" id="purchase_no" onchange="changePurchaseNo({{ $cart[0]['id'] }})">
              </li> --}}
            </ul>
          </div>
          <x-shipping-info :cart="$cart" :user="$user" :userDetail="$user_detail" />
          <x-cart.final-checkout-list :cart="$cart" />
          <div class="card-body p-6 border-t">
            <div class="flex items-center justify-end gap-2">
              <a href="{{ route('quote') }}" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-[#000000] hover:bg-[#00838f] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center justify-center w-[160px]"> Save a Quote</a>

              <a href="{{ route('cart') }}" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-[#000000] hover:bg-[#00838f] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 flex gap-3 items-center justify-center w-[160px]">Cancel</a>

              <form action="{{ route('confirm-order') }}" method="post">
                <input type="hidden" value="<?= csrf_token() ?>" name="_token">
                <input type="hidden" name="cart_id" value="{{ $cart[0]['id'] }}">
                <input type="hidden" name="purchase_order_no" value="{{ $purchase_order_no }}">
                <button type="submit" class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 items-center hover:bg-[#FF9119]/80 justify-center w-[160px]">Confirm Order</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@push('other-scripts')
  <script>
  function changePurchaseNo(cart_id)
  {
	  var p_num=$("#purchase_no").val();
	  $("#purchase_order_no").val(p_num);
	  $.ajax({
        url: "{{ route('update-purchase-no') }}",
        type: 'POST',
        data: {
          "_token": "{{ csrf_token() }}",
          cart_id: cart_id,
          purchase_order_no: p_num,
        },
        success: function(response) {

        }
      });
  }
  </script>
@endpush

</x-mainpage-layout>
