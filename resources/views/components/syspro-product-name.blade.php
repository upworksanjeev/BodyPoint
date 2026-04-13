@props([
  'sku' => null,
  'fallback' => '',
])

@php
  $skuKey = is_string($sku) ? trim($sku) : (is_null($sku) ? '' : (string) $sku);
  $stock = (!empty($skuKey) && isset($sysproStockByCode) && is_array($sysproStockByCode))
      ? ($sysproStockByCode[$skuKey] ?? null)
      : null;

  // Syspro field names vary by payload; try common variants safely.
  $description = is_array($stock)
      ? ($stock['Description'] ?? $stock['StockDescription'] ?? $stock['description'] ?? $stock['stockDescription'] ?? null)
      : null;
  $longDescription = is_array($stock)
      ? ($stock['LongDescription'] ?? $stock['LongDesc'] ?? $stock['LongDescription1'] ?? $stock['longDescription'] ?? $stock['longDesc'] ?? null)
      : null;

  $displayName = $description ?: $fallback;
@endphp

<span class="block">
  <span class="block">{{ $displayName }}</span>
  @if(!empty($longDescription))
    <span class="block text-xs text-gray-600 mt-0.5">{{ $longDescription }}</span>
  @endif
</span>

