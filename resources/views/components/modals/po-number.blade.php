  <!-- Main modal -->
  <div id="{{ $id }}" data-modal-target='{{ $id }}' tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <div class="relative bg-white rounded-lg shadow ">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900">
                    CUSTOMER PO NUMBER
                </h3>
                <button type="button" class="{{ $cross }} text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="{{ $id }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <div class="p-4 md:p-5 space-y-4">
                <div id="error_alert_po" style="display: none;" class="alert message-alert bg-red-100 text-red-800 border border-red-400 rounded-lg p-4 relative" role="alert">
                    
                    
                </div>
                <form id="{{ $form }}" action="{{ $action }}" method="post">
                    <input type="hidden" value="<?= csrf_token() ?>" name="_token">
                    @if($form == "confirm-order-form")
                        <input type="hidden" name="cart_id" value="{{ $cart[0]['id'] ?? '' }}" id="order-cart-id">
                    @endif
                    <input type="text" name="customer_po_number" value="{{ $cart[0]['purchase_order_no'] ?? ''}}" placeholder="Enter PO Number" id="{{ $name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
                    <input type="hidden" name="selected_credit_card" id="form_credit_card_data" value="" />
                    <div id="duplicate-confirmation" style="display: none;">
                        <label>
                            <input type="checkbox" name="agree_duplicate" id="agree-duplicate" value="yes">
                            Yes, proceed with the duplicate.
                        </label>
                    </div>
                </form>
            </div>
            <div class="flex items-center justify-end gap-3 p-4 md:p-5 border-t border-gray-200 rounded-b">
                <button type="button" class="{{ $class }} py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-[#000000] hover:bg-[#00838f] hover:border-[#027480] hover:text-[#fff]  focus:z-10 focus:ring-4 focus:ring-gray-100 w-[160px]">Cancel</button>
                <button type="button" class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 items-center hover:bg-[#FF9119]/80 justify-center w-[160px]" id="{{ $save }}">Save</button>
            </div>
        </div>
    </div>
</div>
