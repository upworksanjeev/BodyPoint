@props([
  'sku' => null,
  'fallback' => '',
])

@php
  $skuKey = is_string($sku) ? trim($sku) : (is_null($sku) ? '' : (string) $sku);
  $stock = null;
  if (!empty($skuKey)) {
      $stockDetails = session('stock_details', []);
      if (is_array($stockDetails)) {
          foreach ($stockDetails as $row) {
              if (!is_array($row)) {
                  continue;
              }
              $code = $row['StockCode'] ?? $row['stockCode'] ?? null;
              if ((string) $code === $skuKey) {
                  $stock = $row;
                  break;
              }
          }
      }
  }

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

