 <div class="grid grid-cols-1 lg:pb-14 pb-2 sm:pb-6">
          <div class="col-span-2">
            <ul class="flex flex-wrap items-center w-full text-sm font-medium text-center text-gray-500 sm:text-base order-step">
              <li
                class="active flex-1 flex flex-col items-center gap-3 relative after:content-[''] after:absolute after:top-[15px] after:left-[50%] after:w-full after:h-[2px] after:bg-gray-200">
                <div class="z-10">
				<a href="{{ route('shipping') }}">
                  <span
                    class="text-[13px] font-bold text-[#A6A2A2] bg-white w-[30px] min-w-[30px] h-[30px] border-2 border-solid rounded-full flex justify-center items-center">
                    1
                  </span>
				  </a>
                </div>
                <p class="text-[13px] min-h-[42px] sm:min-h-[auto] font-normal text-[#000]"><a href="{{ route('shipping') }}">Shipping Information</a></p>
              </li>
              <li
                class="{{ ($page=='payment' || $page=='checkout')?'active':'' }} flex-1 flex flex-col items-center gap-3 relative after:content-[''] after:absolute after:top-[15px] after:left-[50%] after:w-full after:h-[2px] after:bg-gray-200">
                <div class="z-10">
				<a href="{{ route('payment') }}">
                  <span
                    class="text-[13px] font-bold text-[#A6A2A2] bg-white w-[30px] min-w-[30px] h-[30px] border-2 border-solid rounded-full flex justify-center items-center">
                    2
                  </span>
				  </a>
                </div>
                <p class="text-[13px] min-h-[42px] sm:min-h-[auto] font-normal text-[{{ ($page=='payment' || $page=='checkout')?'#000':'#717171' }}]"><a href="{{ route('payment') }}">Payment Method</a></p>
              </li>
              <li
                class="{{ ($page=='checkout')?'active':'' }} flex-1 flex flex-col items-center gap-3 relative after:content-[''] after:absolute after:top-[15px] after:left-[50%] after:w-full after:h-[2px] after:bg-gray-200">
				
                <div class="z-10">
				<a href="{{ route('checkout') }}">
                  <span
                    class="text-[13px] font-bold text-[#A6A2A2] bg-white w-[30px] min-w-[30px] h-[30px] border-2 border-solid rounded-full flex justify-center items-center">
                    3
                  </span>
				  </a>
                </div>
				
                <p class="text-[13px] min-h-[42px] sm:min-h-[auto] font-normal text-[{{ ($page=='checkout')?'#000':'#717171' }}]"><a href="{{ route('checkout') }}">Confirm Order </a></p>
				
              </li>
              <li class="flex-1 flex flex-col items-center gap-3">
                <div class="z-10">
                  <span
                    class="text-[13px] font-bold text-[#A6A2A2] bg-white w-[30px] min-w-[30px] h-[30px] border-2 border-solid rounded-full flex justify-center items-center">
                    4
                  </span>
                </div>
                <p class="text-[13px] min-h-[42px] sm:min-h-[auto] font-normal text-[#717171]">Completion</p>
              </li>
            </ul>
          </div>
        </div>