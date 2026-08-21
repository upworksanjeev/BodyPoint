@props([
    'action',
    'clearUrl',
    'syncUrl',
    'syncLabel',
    'searchLabel',
    'searchButtonName',
    'placeholder',
    'search' => '',
    'startDate' => '',
    'endDate' => '',
    'minDate' => null,
])

<form action="{{ $action }}" method="post">
    @csrf
    <div class="flex flex-col lg:flex-row lg:items-end gap-4 sm:gap-5 mb-6">
        <div class="w-full sm:max-w-[350px] lg:w-[350px] lg:shrink-0">
            <label for="search_input" class="block mb-2 text-sm font-medium text-gray-900">Search By:</label>
            <input type="text" id="search_input" name="search_input"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                placeholder="{{ $placeholder }}" value="{{ $search }}" />
        </div>
        <div class="flex-1 min-w-0">
            <label for="start_date" class="block mb-2 text-sm font-medium text-gray-900 lg:mb-2">Date:</label>
            <div class="flex flex-wrap items-center gap-2 xl:gap-3">
                <div date-rangepicker
                    datepicker-max-date="{{ now()->format('m/d/Y') }}"
                    @if ($minDate) datepicker-min-date="{{ $minDate }}" @endif
                    class="flex items-center gap-2 flex-wrap sm:flex-nowrap shrink-0">
                    <div class="relative w-[148px] sm:w-[156px] shrink-0">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <x-icons.date />
                        </div>
                        <input name="start_date" id="start_date" type="text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                            placeholder="Start date" value="{{ $startDate }}">
                    </div>
                    <span class="text-gray-500 inline-block shrink-0 px-0.5">to</span>
                    <div class="relative w-[148px] sm:w-[156px] shrink-0">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <x-icons.date />
                        </div>
                        <input name="end_date" id="end_date" type="text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                            placeholder="End date" value="{{ $endDate }}">
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-2 shrink-0">
                    <button type="submit" name="{{ $searchButtonName }}"
                        class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-[#FF9119] rounded-full border border-[#FF9119] focus:z-10 focus:ring-4 focus:ring-[#FF9119]/40 inline-flex items-center justify-center whitespace-nowrap hover:bg-[#FF9119]/80">
                        {{ $searchLabel }}
                    </button>
                    <a href="{{ $clearUrl }}"
                        class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-[#000000] hover:bg-[#00838f] hover:border-[#027480] hover:text-[#fff] focus:z-10 focus:ring-4 focus:ring-gray-100 inline-flex items-center justify-center whitespace-nowrap">
                        Clear Search
                    </a>
                    <x-sync-date-range-button :url="$syncUrl" :label="$syncLabel" />
                </div>
            </div>
        </div>
    </div>
</form>
