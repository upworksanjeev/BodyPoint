<x-mainpage-layout>
    @if (session()->has('customer_po_number'))
        @php
            // dd(session()->get('customer_po_number') );
        @endphp
    @endif
    @section('title', 'Quotes - ' . config('app.name', 'Bodypoint'))
    {{-- <x-cart-nav /> --}}

    <div class="p-6 ctm-container mx-auto">

        <div class="grid grid-cols-4 md:grid-cols-3 gap-4">
            @foreach ($images as $image)
                <div class="relative h-100 min-h-[300px]">
                    <img class="h-full max-w-full rounded-lg object-cover" src="{{ $image['url'] }}" alt="{{ $image['name'] }}">
                    <div class="absolute top-0 bottom-0 left-0 right-0 flex items-center justify-center">
                        <a onclick="downloadImage('{{ $image['url'] }}', '{{ $image['name'] }}')" download
                            class="p-2 bg-[#fe7300] hover:bg-[#e96a00] text-white text-[20px] font-[500] w-[100%] min-w-[140px] max-w-[140px] text-center rounded-[10px]">Download</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        function downloadImage(url, filename) {
            fetch(url)
                .then(response => response.blob())
                .then(blob => {
                    const link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = filename;
                    link.click();
                })
                .catch(console.error);
        }
    </script>

</x-mainpage-layout>
