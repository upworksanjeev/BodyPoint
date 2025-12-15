 <div class="grid lg:grid-cols-2">
     <div>
         <div class="card-header px-6 py-2 bg-[#00838f]">
             <h4 class="text-[#fff]">Ship To:</h4>
         </div>
         <div class="card-body p-6">
             <ul class="max-w-md space-y-5 text-gray-500 list-disc list-inside">
                 <li class="flex items-start gap-5">
                     <span class="text-sm text-[#000] font-normal leading-[17px] w-[55px]">Name:</span>
                     {{-- <span class="text-sm text-[#000] font-normal leading-[17px]">{{ $userDetail->first_name ?? auth()->user()->name }} {{ $userDetail->last_name ??'' }}</span> --}}
                     <span
                         class="text-sm text-[#000] font-normal leading-[17px]">{{ session()->get('customer_details') ? session()->get('customer_details')['CustomerName'] : '' }}</span>
                 </li>
                 <li class="flex items-start gap-5">
                     <span class="text-sm text-[#000] font-normal leading-[17px] w-[55px]">Address:</span>
                     <span class="text-sm text-[#000] font-normal leading-[17px] change-shipping-address">
                         {{ !empty(session('customer_address')['AddressLine2']) ? session('customer_address')['AddressLine2'] . ',' : (session('customer_details')['ShipToAddresses'][0]['AddressLine2'] ? session('customer_details')['ShipToAddresses'][0]['AddressLine2'] . ',': '') }}
                         {{ !empty(session('customer_address')['AddressLine1']) ? session('customer_address')['AddressLine1'] . ',' : (session('customer_details')['ShipToAddresses'][0]['AddressLine1'] ? session('customer_details')['ShipToAddresses'][0]['AddressLine1'] . ',': '') }}
                         {{ !empty(session('customer_address')['AddressLine3']) ? session('customer_address')['AddressLine3'] . ',' : (session('customer_details')['ShipToAddresses'][0]['AddressLine3'] ? session('customer_details')['ShipToAddresses'][0]['AddressLine3'] . ',': '') }}
                         <br>
                         {{ !empty(session('customer_address')['AddressLine4']) ? session('customer_address')['AddressLine4'] . ',' : (session('customer_details')['ShipToAddresses'][0]['AddressLine4'] ? session('customer_details')['ShipToAddresses'][0]['AddressLine4'] . ',' :'')  }}
                         {{ session('customer_address')['PostalCode'] ?? session('customer_details')['ShipToAddresses'][0]['PostalCode'] }},
                         {{ session('customer_address')['AddressLine5'] ?? session('customer_details')['ShipToAddresses'][0]['AddressLine5'] }}
                     </span>

                 </li>
                 <li class="flex items-start gap-5">
                     <span class="text-sm text-[#000] font-normal leading-[17px] w-[55px]">Country</span>
                     <span
                         class="text-sm text-[#000] font-normal leading-[17px]">{{ $userDetail->country ?? session('customer_address')['AddressLine5'] }}</span>
                 </li>
                 @php
                 $phone = $userDetail->primary_phone ?? $user->getUserDetails->primary_phone;
                 @endphp

                 @if(!empty($phone))
                 <li class="flex items-start gap-5">
                     <span class="text-sm text-[#000] font-normal leading-[17px] w-[55px]">Phone</span>
                     <span class="text-sm text-[#000] font-normal leading-[17px]">+1 {{ $phone }}</span>
                 </li>
                 @endif

             </ul>
         </div>
     </div>
     <div>
         <div class="card-header px-6 py-2 bg-[#00838f]">
             <h4 class="text-[#fff]">Bill To:</h4>
         </div>
         <div class="card-body p-6">
             <ul class="max-w-md space-y-5 text-gray-500 list-disc list-inside">
                 <li class="flex items-start gap-5">
                     <span class="text-sm text-[#000] font-normal leading-[17px] w-[55px]">Name:</span>
                     {{-- <span class="text-sm text-[#000] font-normal leading-[17px]">{{ $userDetail->first_name ?? auth()->user()->name }} {{ $userDetail->last_name ??'' }}</span> --}}
                     <span
                         class="text-sm text-[#000] font-normal leading-[17px]">{{ session()->get('customer_details') ? session()->get('customer_details')['CustomerName'] : '' }}</span>
                 </li>
                 <li class="flex items-start gap-5">
                     <span class="text-sm text-[#000] font-normal leading-[17px] w-[55px]">Address:</span>
                     <span class="text-sm text-[#000] font-normal leading-[17px]">
                         {{ !empty(session('customer_details')['billAddressLine2']) ? session('customer_details')['billAddressLine2'] . ',' : '' }}
                         <br>
                         {{ !empty(session('customer_details')['billAddressLine4']) ? session('customer_details')['billAddressLine4'] . ',' : '' }}
                         {{ !empty(session('customer_details')['billAddressLine1']) ? session('customer_details')['billAddressLine1'] . ',' : '' }}
                         @if (session('customer_details')['billAddressLine5'] || !empty(session('customer_details')['billAddressLine5']))
                         {{ !empty(session('customer_details')['billAddressPostalCode']) ? session('customer_details')['billAddressPostalCode'] . ',' : '' }}
                         @else
                         {{ !empty(session('customer_details')['billAddressPostalCode']) ? session('customer_details')['billAddressPostalCode'] : '' }}
                         @endif
                         {{ session('customer_details')['billAddressLine5'] ?? '' }}
                     </span>

                 </li>
                 <li class="flex items-start gap-5">
                     <span class="text-sm text-[#000] font-normal leading-[17px] w-[55px]">Country</span>
                     <span
                         class="text-sm text-[#000] font-normal leading-[17px]">{{ $userDetail->country ?? session('customer_address')['AddressLine5'] }}</span>
                 </li>
                 @php
                 $phone = $userDetail->primary_phone ?? $user->getUserDetails->primary_phone;
                 @endphp

                 @if(!empty($phone))
                 <li class="flex items-start gap-5">
                     <span class="text-sm text-[#000] font-normal leading-[17px] w-[55px]">Phone</span>
                     <span class="text-sm text-[#000] font-normal leading-[17px]">+1 {{ $phone }}</span>
                 </li>
                 @endif

             </ul>
         </div>
     </div>
 </div>
 <div class="card-header px-6 py-2 bg-[#00838f]">
     <h4 class="text-[#fff]">Payment Method:</h4>
 </div>
 <div class="card-body p-6">
     <ul class="max-w-md space-y-5 text-gray-500 list-disc list-inside">
         <li class="flex items-start gap-5">
             <span
                 class="text-sm text-[#000] font-normal leading-[17px]">{{ session('customer_details')['PaymentTermDescription'] ?? 'Invoice-30' }}</span>
         </li>
     </ul>
 </div>
 <div class="card-header px-6 py-2 bg-[#00838f]">
     <h4 class="text-[#fff]">Items:</h4>
 </div>
 <div class="card-body p-6">
     <ul class="space-y-5 text-gray-500 list-disc list-inside">

         <li class="flex items-start gap-5">
             <span class="text-sm text-[#000] font-normal leading-[17px]">Carrier:</span>
         </li>
         <li class="flex items-start gap-5">
             <span class="text-[13px] font-normal leading-[19px]">All orders ship within 5 business days after your order is processed. Freight charges are calculated when your order ships. For expedited shipping options, please contact Customer Support at Sales@bodypoint.com or 206.405.4555.</span>
         </li>
     </ul>
 </div>