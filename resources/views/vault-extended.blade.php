@foreach ($items as $key => $item)
    @if (is_array($item) && isset($item[0]['url'])) 
        @foreach ($item as $file)
            <li>
                <a href="{{ url($file['url']) }}" target="_blank" class="text-[15px] text-[#00838F] font-normal">
                    {{ $file['name'] }}
                </a>
            </li>
        @endforeach
    @elseif (is_array($item)) 
        <li>
            <div class="accordion-item">
                <div class="accordion-item-headers accordion-item-headers-inner flex items-center justify-between ps-8 pb-4 cursor-pointer relative text-base font-medium">
                    {{ $key }}
                </div>
                <div class="accordion-item-body max-h-full">
                    <div class="accordion-item-body-content accordion-item-body-content-inner leading-normal mb-4">
                        <ul>
                            @include('vault-extended', ['items' => $item])
                        </ul>
                    </div>
                </div>
            </div>
        </li>
    @endif
@endforeach
