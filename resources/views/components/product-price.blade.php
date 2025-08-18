@php
$customer = getCustomer();
// Example addon products (you should replace this with actual dynamic data from your backend)
$armSupportSku = ['AS201L', 'AS201R', 'AS202L', 'AS202R'];


$productSku = $product['sku'] ?? '';

// Check if the SKU exists in the array
if (in_array($productSku, $armSupportSku)) {
$addToCartButtonId = 'add-to-cart-button';
$buttonType= "button";
} else {
$addToCartButtonId = 'add-to-cart-all';
$buttonType= "submit";
}

$addonProducts = [
[
'product_id' => 370,
'attribute_id' => 1481,
'name' => 'Armrest Mounting Clamp',
'size' => 'Ø19mm (Ø3/4”)',
'image' => 'https://app.bodypoint.com/storage/d76doqKL3SfBnrG6CTViJq4DmOfm21D7KdUWbBhi.png',
'sku'=>'AS118'
],
[
'product_id' => 370,
'attribute_id' => 1482,
'name' => 'Armrest Mounting Clamp',
'size' => 'Ø22mm & 25mm (Ø7/8” & 1”)',
'image' => 'https://app.bodypoint.com/storage/d76doqKL3SfBnrG6CTViJq4DmOfm21D7KdUWbBhi.png',
'sku'=>'AS119'
],
[
'product_id' => 370,
'attribute_id' => 1483,
'name' => 'Armrest Mounting Plate',
'size' => 'Flat Armrest',
'image' => 'https://app.bodypoint.com/storage/d76doqKL3SfBnrG6CTViJq4DmOfm21D7KdUWbBhi.png',
'sku'=>'AS120'
]
];

function checkProductExists($productId) {
// Define your allowed product IDs
$allowedProducts = [368,369, 370,371,372, 373,374,375,376,377];

// Return true if exists, false otherwise
return in_array($productId, $allowedProducts);
}

@endphp
<style>
    .product-promo-box {
        background: #f9f9f9;
        border: 1px solid #ddd;
        padding: 12px 15px;
        border-radius: 6px;
        font-size: 14px;
        line-height: 1.6;
        display: block;
        width: 100%;
        white-space: normal;
        height: auto !important;
        margin-top: 5px;
    }
</style>
<div class="ctm-price mt-[30px]">
    <div class="left-price">
        <h6 class="text-[16px] text-[#000] font-[500]">SKU</h6>
    </div>
    <div class="right-price">
        <div class="text-set">
            <h6 class="text-[16px] text-[#FF9119] font-[500]">{{ $product['sku']??'' }}</h6>
        </div>
    </div>
</div>
@if($customer)
@if(!checkProductExists($product['product_id'] ?? $product['id']))
<div class="ctm-price mt-[30px]">

    <div class="left-price">
        @if($customer->hasPermissionTo('viewMsrp'))
        <p class="text-[14px] text-[#6A6D73]">MSRP</p>
        @endif
        <h6 class="text-[16px] text-[#000] font-[500]">YOUR PRICE</h6>
        @if ($product['discount'] > 0 && $customer->hasPermissionTo('viewDiscount'))
        <p class="text-[14px] text-[#6A6D73]">Your Discounts (Primary + Secondary)</p>
        @endif
    </div>
    <div class="right-price">
        <div class="text-set">
            @if($customer->hasPermissionTo('viewMsrp'))
            <p class="text-[14px] text-[#6A6D73]">@if (isset($product['msrp'])) ${{ number_format($product['msrp'], 2, '.', ',') }} EA @endif</p>
            @endif
            <h6 class="text-[16px] text-[#000] font-[500]">@if (isset($product['discount_price'])) ${{ number_format($product['discount_price'], 2, '.', ',')  }} EA @endif</h6>
            @if ($product['discount'] > 0 && $customer->hasPermissionTo('viewDiscount'))
            <p class="text-[14px] text-[#6A6D73]">{{ calculateDiscountPercentage($product['msrp'],$product['price']) ?? '' }}% + {{ number_format($product['discount'], 2, '.', ',')  }}%</p>
            @endif
        </div>

        <input type="hidden" name="variation_id" id="variation_id" value="{{ $product['variation_id'] ?? '' }}">
        <input type="hidden" name="price" id="price" value="{{ $product['price'] ?? '' }}">
        <input type="hidden" name="sku" id="sku" value="{{ $product['sku'] ?? '' }}">
        <input type="hidden" name="msrp" id="msrp" value="{{ $product['msrp'] ?? '' }}">
        <input type="hidden" name="discount_price" id="discount_price" value="{{ $product['discount_price'] ?? '' }}">
        <input type="hidden" name="discount" id="discount" value="{{ $product['discount'] ?? '' }}">

        @if($customer->hasPermissionTo('addToCart'))
        <button type="{{$buttonType}}" id="{{$addToCartButtonId}}" class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 flex gap-3 items-center hover:bg-[#FF9119]/80 justify-center w-[160px]">Add To Cart</button>
        @endif

    </div>
    @if(!$customer->hasPermissionTo('addToCart'))
    <a href="https://bodypoint.com/contact-us/"><b class="underline">Contact Bodypoint to Order</b></a>
    @endif




</div>
@else
<div class="product-promo-box">
    <strong style="color:#f36f21;">This product has a special promotional price:</strong><br>
    Please contact <a href="mailto:sales@bodypoint.com">sales@bodypoint.com</a>
    for a quote or call <a href="tel:2064054555">206-405-4555</a> for more information.
</div>
@endif
@endif

<!-- Addon Products Popup -->
<div id="addon-popup" class="fixed inset-0 bg-gray-800 bg-opacity-70 flex justify-center items-center z-50 hidden">
    <div class="bg-white p-8 rounded-lg w-[80%] max-w-3xl shadow-lg">
        <h3 class="text-3xl font-bold text-center mb-6">Mounting Hardware Required</h3>

        <!-- List of Addon Products -->
        <div id="addon-products-list" class="grid grid-cols-1 gap-6">
            @foreach($addonProducts as $addonProduct)
            <div class="addon-item flex items-center justify-between border p-4 rounded-lg shadow-md hover:shadow-lg transition duration-200 ease-in-out">
                <!-- Image Section -->
                <img src="{{ $addonProduct['image']; }}" alt="{{ $addonProduct['name'] }}" class="w-20 h-20 object-cover rounded-md">

                <!-- Text Section -->
                <div class="ml-4 flex flex-col justify-between flex-grow">
                    <p class="font-semibold text-sm truncate">{{ $addonProduct['name'] }}</p>
                    <p class="text-sm text-gray-600 truncate">Mounting Hardware: {{ $addonProduct['size'] }}</p>
                    <p class="text-sm text-gray-600 truncate">SKU: {{ $addonProduct['sku'] }}</p>
                </div>

                <!-- Button Section -->
                <button class="add-to-cart-btn text-white bg-[#FF9119] px-4 py-2 rounded-md w-[150px] text-center"
                    data-product-id="{{ $addonProduct['product_id'] }}"
                    data-attribute-sku="{{ $addonProduct['sku'] }}"
                    data-attribute-id="{{ $addonProduct['attribute_id'] }}"
                    data-name="{{ $addonProduct['name'] }}"
                    data-size="{{ $addonProduct['size'] }}">
                    Add to Cart
                </button>
            </div>
            @endforeach
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 flex justify-between">
            <button id="close-popup" class="py-2 px-6 bg-gray-400 text-white rounded-lg text-lg">Skip</button>
            <button id="next-btn" class="py-2 px-6 bg-[#FF9119] text-white rounded-lg text-lg opacity-50 cursor-not-allowed" disabled>Next</button>
        </div>
    </div>
</div>


<script>
    // Show the popup when "Add to Cart" button is clicked
    document.getElementById('add-to-cart-button').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent form submission (if any)
        document.getElementById('addon-popup').classList.remove('hidden');
    });

    // Close the popup when "Skip" is clicked
    document.getElementById('close-popup').addEventListener('click', function() {
        document.getElementById('addon-popup').classList.add('hidden');
    });

    // Add selected addon product to the cart
    document.querySelectorAll('.add-to-cart-btn').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent form submission (if any)

            // Get product and variation data
            let productId = button.getAttribute('data-product-id');
            let variationId = button.getAttribute('data-attribute-id');
            let variationIdsku = button.getAttribute('data-attribute-sku');

            // Disable the button, change text to "Loading...", and apply a loading color
            button.textContent = "Loading...";
            button.disabled = true;
            button.classList.add('bg-gray-400', 'cursor-not-allowed'); // Optional: Change color to indicate loading state

            // Send AJAX request to add the product to the cart
            fetch("{{ route('add-to-cart-attachment') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Ensure CSRF token is sent
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        sku: variationIdsku,
                        variation_id: variationId,
                        qty: 1
                    })
                })
                .then(response => response.json())
                .then(data => {
                    // Handle response data
                    if (data.success) {
                        // Change text to "Added", disable the button, and style it as "added"
                        button.textContent = "Added";
                        button.classList.add('bg-gray-400', 'cursor-not-allowed');
                        button.disabled = true;

                        // Increment the count of products added to cart
                        productsAddedToCartModal++;

                        // Enable the "Next" button if at least one product is added
                        if (productsAddedToCartModal > 0) {
                            document.getElementById('next-btn').classList.remove('opacity-50', 'cursor-not-allowed');
                            document.getElementById('next-btn').removeAttribute('disabled');
                        }
                    } else {
                        toastr.error(data.message);
                        button.textContent = "Failed to Add";
                        button.classList.add('bg-red-500', 'text-white');
                        setTimeout(() => {
                            button.textContent = "Add to Cart"; // Reset to original text
                            button.classList.remove('bg-red-500', 'text-white');
                            button.classList.remove('bg-gray-400', 'cursor-not-allowed');
                            button.disabled = false; // Re-enable button for retry
                        }, 3000); // Reset button text and color after 3 seconds
                    }
                })
                .catch(error => {
                    toastr.error(error);

                    // In case of network errors or unexpected issues
                    button.textContent = "Error";
                    button.classList.add('bg-red-500', 'text-white');
                    setTimeout(() => {
                        button.textContent = "Add to Cart"; // Reset to original text
                        button.classList.remove('bg-red-500', 'text-white');
                        button.classList.remove('bg-gray-400', 'cursor-not-allowed');
                        button.disabled = false; // Re-enable button for retry
                    }, 3000); // Reset button text and color after 3 seconds
                });
        });
    });

    // Proceed to checkout if "Next" is clicked
    document.getElementById('next-btn').addEventListener('click', function() {
        // Implement checkout redirection here
        window.location.href = '#'; // Replace with the actual checkout page URL
    });
</script>