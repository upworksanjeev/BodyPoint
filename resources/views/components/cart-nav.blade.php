@if (Route::has('login'))
    @auth
    <section class="bg-white border-b border-solid border-[#E0E0E0]">
    <div class="container mx-auto">
      <div class="max-w-screen-xl mx-auto">
        <div class="flex items-center justify-between pt-1 pb-2">
          <div class="text-base font-medium text-center text-[#000]">
            <ul class="flex flex-wrap -mb-px">
              <li class="me-2">
                <a href="{{ route('cart') }}"
                  class="inline-block p-4 rounded-t-lg <?php if(Request::is('cart')){ echo "text-[#000] border-b-[3px] active border-[#00838f]"; }else{ echo "border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300"; } ?>" aria-current="page">Shopping Cart</a>
              </li>
              <li class="me-2">
                <a href="{{ route('order') }}"
                  class="inline-block p-4 rounded-t-lg <?php if(Request::is('order')){ echo "text-[#000] border-b-[3px] active border-[#00838f]"; }else{ echo "border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300"; } ?>">Order Lookup</a>
              </li>
              <li class="me-2">
                <a href="{{ route('profile.edit') }}"
                  class="inline-block p-4 rounded-t-lg <?php if(Request::is('profile')){ echo "text-[#000] border-b-[3px] active border-[#00838f]"; }else{ echo "border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300"; } ?>">My Account</a>
              </li>
              <li class="me-2">
                <a href="{{ route('quotes') }}"
                  class="inline-block p-4 rounded-t-lg <?php if(Request::is('quotes')){ echo "text-[#000] border-b-[3px] active border-[#00838f]"; }else{ echo "border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300"; } ?>">Quotes</a>
              </li>
            </ul>
          </div>
          <div class="">
            <div class="">
              <div class="">
                <label for="search-dropdown" class="text-sm font-medium text-[#000]">Change Associate customer</label>
                <div class="relative w-full flex flex-1">
                    @php
                        $user = auth()->user()->load(['associateCustomers']);
                    @endphp
                    <form method="POST" action="{{ route('change-customer') }}" id="customer-form">
                        @csrf
                        <select name="customer_id" id="search-dropdown">
                            @if(!$user->associateCustomers->isEmpty())
                                @foreach($user->associateCustomers as $customer)
                                    <option value="{{ $customer->customer_id }}" @if(session()->get('customer_id') == $customer->customer_id) selected @endif>
                                        {{ $customer->customer_id }} - {{ $customer->name }}
                                    </option>
                                @endforeach
                            @else
                                <option value="{{ auth()->user()->default_customer_id }}" @if(session()->get('customer_id') == auth()->user()->default_customer_id) selected @endif>
                                    {{ auth()->user()->default_customer_id }} - {{ auth()->user()->name }}
                                </option>
                            @endif
                        </select>
                        <button type="submit" id="dropdown-button" class=" py-2.5 px-4 text-sm font-medium text-center text-white bg-[#494949] rounded-e-lg">Change Customer</button>
                    </form>
                  {{-- <input type="search" id="search-dropdown"
                    class="block p-2.5 w-full z-20 text-sm text-[#070707] bg-white rounded-s-lg border border border-[#000] focus:ring-blue-500 focus:border-blue-500 placeholder:text-[#070707] border-e-0"
                    placeholder="Search Customer" required  value="{{ session('customer_details') ? session('customer_details')['CustomerAccountNumber'] . ' - ' . session('customer_details')['CustomerName'] : '' }}" />
                  <button type="submit"
                    class="p-2.5 text-sm font-medium text-[#070707] border-s-0 border border border-[#000]"><x-icons.search />

                    <span class="sr-only">Search</span>
                  </button>
                  <button id="dropdown-button" data-dropdown-toggle="dropdown"
                    class="flex-shrink-0 z-10 inline-flex items-center py-2.5 pe-4 text-sm font-medium text-center text-white bg-[#494949] rounded-e-lg"
                    type="button"><x-icons.down-arrow /></button> --}}
                  <div id="dropdown"
                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                    <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdown-button">
                      <li>
                        <button type="button"
                          class="inline-flex w-full px-4 py-2 hover:bg-gray-100">Mockups</button>
                      </li>
                      <li>
                        <button type="button"
                          class="inline-flex w-full px-4 py-2 hover:bg-gray-100">Templates</button>
                      </li>
                      <li>
                        <button type="button"
                          class="inline-flex w-full px-4 py-2 hover:bg-gray-100">Design</button>
                      </li>
                      <li>
                        <button type="button"
                          class="inline-flex w-full px-4 py-2 hover:bg-gray-100">Logos</button>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
    @endauth
@endif

<script>
    $(document).ready(function(){
        $('#customer-form').on('submit', function(event) {
            event.preventDefault();
            const csrfToken = $('input[name="_token"]').val();
            const customerId = $('#search-dropdown').val();
            if (confirm("Please confirm to switch the customer for your browsing session. \n\n All customer specific store settings will change including: \n - Available product and product categories\n- Product Pricing\n- Available shipping options and addresses\n- Credit Limit Settings\n- Available payment methods\n- Order posting customer account\n- Order history")) {
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        customer_id: customerId
                    },
                    success: function(response) {
                        if(response.success == true){
                            toastr.success(response.message);
                            window.location.href = '/dashboard';
                        }else{
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, messages) {
                                messages.forEach(message => toastr.error(message));
                            });
                        } else {
                            toastr.error('An error occurred. Please try again.');
                        }
                    }
                });
            }
        });
    });
</script>
