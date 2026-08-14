@props([
    'compact' => false,
])

@php
    $authUser = auth()->user()->load(['associateCustomers']);
    $selectedCustomerId = session()->get('customer_id', $authUser->default_customer_id);
    $defaultCustomerId = $authUser->default_customer_id;
    $defaultCustomerName = $authUser->name;
    $hasDefaultCustomer = false;
    $formId = $compact ? 'home-customer-form' : 'customer-form';
    $selectId = $compact ? 'home-search-dropdown' : 'search-dropdown';
@endphp

<div class="{{ $compact ? 'w-full lg:w-auto' : 'w-full lg:w-auto' }}">
    <label for="{{ $selectId }}" class="{{ $compact ? 'block text-[13px] text-[#6b6b6b] mb-2' : 'text-base font-medium text-[#000]' }}">
        @if ($compact)
            Ordering for a different account?
        @else
            Change Customer Account
        @endif
    </label>
    <div class="relative w-full flex flex-1 {{ $compact ? '' : 'mt-1' }}">
        <form method="POST"
            class="w-full {{ $compact ? 'flex items-center gap-2' : 'lg:w-auto' }}"
            action="{{ route('change-customer') }}" id="{{ $formId }}" data-customer-switcher="true">
            @csrf
            <select name="customer_id" id="{{ $selectId }}" onchange="redirectToPage(this)"
                class="{{ $compact ? 'min-w-[220px] rounded-md border-[#d0d0d0] text-sm' : 'lg:w-auto w-full rounded-lg' }}">
                @if (!$authUser->associateCustomers->isEmpty())
                    @foreach ($authUser->associateCustomers as $linkedCustomer)
                        <option value="{{ $linkedCustomer->customer_id }}"
                            @if ($selectedCustomerId == $linkedCustomer->customer_id) selected @endif>
                            {{ $linkedCustomer->customer_id }} - {{ $linkedCustomer->name }}
                        </option>
                        @if ($linkedCustomer->customer_id == $defaultCustomerId)
                            @php $hasDefaultCustomer = true; @endphp
                        @endif
                    @endforeach
                @endif

                @if (!$hasDefaultCustomer)
                    <option value="{{ $defaultCustomerId }}"
                        @if ($selectedCustomerId == $defaultCustomerId) selected @endif>
                        {{ $defaultCustomerId }} - {{ $defaultCustomerName }}
                    </option>
                @endif
                <option value="link-account">➕ Link New Account</option>
            </select>

            <button type="submit"
                class="py-2.5 px-4 text-sm font-medium text-center text-white bg-[#494949] rounded-lg {{ $compact ? 'whitespace-nowrap' : 'lg:w-auto w-full mt-2' }}">
                {{ $compact ? 'Change' : 'Change Customer' }}
            </button>
        </form>
    </div>
</div>

@once
    <script>
        function redirectToPage(select) {
            let selectedValue = select.value;
            if (selectedValue === "link-account") {
                window.location.href = "{{ route('link-account') }}";
            }
        }
        $(document).ready(function() {
            $('form[data-customer-switcher="true"]').on('submit', function(event) {
                event.preventDefault();
                const customerId = $(this).find('select[name="customer_id"]').val();
                if (confirm(
                        "Please confirm to switch the customer for your browsing session. \n\n All customer specific store settings will change including: \n - Available product and product categories\n- Product Pricing\n- Available shipping options and addresses\n- Credit Limit Settings\n- Available payment methods\n- Order posting customer account\n- Order history"
                    )) {
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
                            if (response.success == true) {
                                toastr.success(response.message);
                                window.location.href = '/dashboard';
                            } else {
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
@endonce
