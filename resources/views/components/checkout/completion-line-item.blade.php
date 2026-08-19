@props(['item', 'comment' => null])

<tr class="odd:bg-white even:bg-gray-50 border-b">
    <td class="px-6 py-4 text-sm leading-[18px] text-[#3E3E3E]">
        <div class="flex items-center gap-2">
            <div class="">
                <img src="<?php if (isset($item['Product']['Media'][0]['id'])) {
                    echo url('storage/' . $item['Product']['Media'][0]['id'] . '/' . $item['Product']['Media'][0]['file_name']);
                } else {
                    echo '/img/standard-img.png';
                } ?>" alt="product-img" class="w-[48px] h-[48px] object-cover" />
            </div>
            <div class="flex-1">
                <p class="text-sm font-normal leading-[18px] mb-2">
                    <a href="{{ route('product', $item['Product']['slug'] ?? $item['Product']['name']) }}" target="_blank">
                        <x-syspro-product-name :sku="$item['sku'] ?? null" :fallback="$item['Product']['name'] ?? ''" />
                    </a>
                </p>
                <span class="bg-[#E4E4E4] text-gray-800 text-[11px] leading-[18px] font-medium me-2 px-2.5 py-0.5 rounded-full">Qty:{{ $item['quantity'] }}</span>
                @if ($comment)
                    <div class="mt-2 text-xs italic text-gray-600">{{ $comment }}</div>
                @endif
            </div>
        </div>
    </td>
    <td class="px-4 py-4 text-sm leading-[18px] text-[#3E3E3E] text-right">
        ${{ $item['discount_price'] ? number_format($item['discount_price'] * $item['quantity'], 2, '.', ',') : 0 }}
    </td>
</tr>
