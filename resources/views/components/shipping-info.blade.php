 <div class="grid lg:grid-cols-2">
            <div>
              <div class="card-header px-6 py-2 bg-[#2F2F2F]">
                  <h4 class="text-[#fff]">Ship to information:</h4>
              </div>
              <div class="card-body p-6">
                <ul class="max-w-md space-y-5 text-gray-500 list-disc list-inside">
                  <li class="flex items-start gap-5">
                    <span class="text-sm text-[#000] font-normal leading-[17px] w-[55px]">Name:</span>
                    <span class="text-sm text-[#000] font-normal leading-[17px]">{{ $userDetail->shipping_user_name }} {{ $userDetail->shipping_last_name }}</span>
                  </li>
                  <li class="flex items-start gap-5">
                    <span class="text-sm text-[#000] font-normal leading-[17px] w-[55px]">Address:</span>
                    <span class="text-sm text-[#000] font-normal leading-[17px]">{{ $userDetail->shipping_address }}, <br>{{ $userDetail->shipping_city }}, {{ $userDetail->shipping_state }} {{ $userDetail->shipping_zip }} {{ $userDetail->shipping_country }}</span>
                  </li>
                  <li class="flex items-start gap-5">
                    <span class="text-sm text-[#000] font-normal leading-[17px] w-[55px]">Country</span>
                    <span class="text-sm text-[#000] font-normal leading-[17px]">{{ $userDetail->shipping_country }}</span>
                  </li>
                  <li class="flex items-start gap-5">
                    <span class="text-sm text-[#000] font-normal leading-[17px] w-[55px]">Phone</span>
                    <span class="text-sm text-[#000] font-normal leading-[17px]">+1 {{ $userDetail->shipping_phone }}</span>
                  </li>
                </ul>
              </div>
            </div>
            <div>
              <div class="card-header px-6 py-2 bg-[#2F2F2F]">
                  <h4 class="text-[#fff]">Bill to information:</h4>
              </div>
              <div class="card-body p-6">
                <ul class="max-w-md space-y-5 text-gray-500 list-disc list-inside">
                  <li class="flex items-start gap-5">
                    <span class="text-sm text-[#000] font-normal leading-[17px] w-[55px]">Name:</span>
                    <span class="text-sm text-[#000] font-normal leading-[17px]">{{ $userDetail->billing_user_name }} {{ $userDetail->billing_last_name }}</span>
                  </li>
                  <li class="flex items-start gap-5">
                    <span class="text-sm text-[#000] font-normal leading-[17px] w-[55px]">Address:</span>
                    <span class="text-sm text-[#000] font-normal leading-[17px]">{{ $userDetail->billing_address  }} <br>{{ $userDetail->billing_city }}, {{ $userDetail->billing_state }} {{ $userDetail->billing_zip  }} {{ $userDetail->billing_country }}</span>
                  </li>
                  <li class="flex items-start gap-5">
                    <span class="text-sm text-[#000] font-normal leading-[17px] w-[55px]">Country</span>
                    <span class="text-sm text-[#000] font-normal leading-[17px]">{{ $userDetail->billing_country }}</span>
                  </li>
                  <li class="flex items-start gap-5">
                    <span class="text-sm text-[#000] font-normal leading-[17px] w-[55px]">Phone</span>
                    <span class="text-sm text-[#000] font-normal leading-[17px]">+1 {{ $userDetail->billing_phone }}</span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="card-header px-6 py-2 bg-[#2F2F2F]">
            <h4 class="text-[#fff]">Payment Method</h4>
          </div>
          <div class="card-body p-6">
            <ul class="max-w-md space-y-5 text-gray-500 list-disc list-inside">
              <li class="flex items-start gap-5">
                <span class="text-sm text-[#000] font-normal leading-[17px]">Invoice -30</span>
              </li>
            </ul>
          </div>
          <div class="card-header px-6 py-2 bg-[#2F2F2F]">
            <h4 class="text-[#fff]">Shipping options</h4>
          </div>
          <div class="card-body p-6">
            <ul class="space-y-5 text-gray-500 list-disc list-inside">
              <li class="flex items-start gap-5">
                <span class="text-sm text-[#000] font-normal leading-[17px]">Special <br>instruction:</span>
              </li>
              <li class="flex items-start gap-5">
                <span class="text-sm text-[#000] font-normal leading-[17px]">Carrier:</span>
              </li>
              <li class="flex items-start gap-5">
                <span class="text-[13px] font-normal leading-[19px]">All orders placed will ship within 5 business days. Freight cost is calculated at time of shipping. For expedited shipping options please contact customer service at sales@bodybpoint.com or 206.405.4555</span>
              </li>
            </ul>
          </div>