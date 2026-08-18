@props(['cartItem'])

@php
    $product = $cartItem['Product'] ?? null;
    $productSlug = $product['slug'] ?? $product['name'] ?? null;
@endphp

{{-- Hidden when printing so a printed or saved quote carries no controls. --}}
<span class="inline-flex items-center gap-3 whitespace-nowrap print:hidden">
    @if ($productSlug)
        <a href="{{ route('product', $productSlug) }}" title="Edit this item"
            class="text-[#00838f] hover:text-[#005f66]">
            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
            <span class="sr-only">Edit this item</span>
        </a>
    @endif
    <button type="button" onclick="removeCheckoutItem({{ $cartItem['id'] }})" title="Remove this item"
        class="text-[#B3261E] hover:text-[#7F1A15]">
        <i class="fa fa-trash-o" aria-hidden="true"></i>
        <span class="sr-only">Remove this item</span>
    </button>
</span>

@once
    @push('other-scripts')
        <script>
            // Reloads rather than patching the row, so the subtotal, the totals and the
            // empty-cart guard are all recalculated by the server.
            function deleteCheckoutItem(cartItemId) {
                $.ajax({
                    url: '{{ route('update-cart-item') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        cart_item_id: cartItemId,
                        option: 'delete',
                    },
                    success: function() {
                        window.location.reload();
                    },
                    error: function() {
                        toastr.error('The item could not be removed. Please try again.');
                    }
                });
            }

            function removeCheckoutItem(cartItemId) {
                Swal.fire({
                    title: 'Remove this item?',
                    text: 'It will be taken off this list and your total will be updated.',
                    icon: 'warning',
                    iconColor: '#B3261E',
                    showCancelButton: true,
                    reverseButtons: true,
                    buttonsStyling: false,
                    confirmButtonText: 'Remove item',
                    cancelButtonText: 'Keep item',
                    customClass: {
                        confirmButton: 'swal-button-color bg-[#B3261E] px-6 py-2 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#7F1A15] focus:bg-[#7F1A15] active:bg-[#7F1A15] focus:outline-none',
                        cancelButton: 'swal-button-color bg-white border border-[#000] text-[#000] px-6 py-2 rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-gray-100 focus:outline-none mr-3',
                    }
                }).then(function(result) {
                    if (result.isConfirmed) {
                        deleteCheckoutItem(cartItemId);
                    }
                });
            }
        </script>
    @endpush
@endonce
