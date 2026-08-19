@props([
    'name' => 'customer_po_number',
    'id' => 'customer-po-number',
    'value' => '',
    'required' => true,
    'label' => 'Customer PO Number',
    'duplicateBlockId' => 'duplicate-confirmation',
])

<div {{ $attributes->merge(['class' => 'px-6 pb-4']) }}>
    <label for="{{ $id }}" class="block mb-2 text-sm font-bold text-gray-900">
        {{ $label }}
        @unless($required)
            <span class="font-normal text-gray-500">(optional)</span>
        @endunless
    </label>
    <input
        type="text"
        name="{{ $name }}"
        id="{{ $id }}"
        value="{{ old($name, $value) }}"
        placeholder="Enter PO Number"
        @if($required) required @endif
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full max-w-md p-2.5"
    />
    <div id="{{ $duplicateBlockId }}" style="display: none;" class="mt-4 space-y-3">
        <div id="error_alert_po" style="display: none;" class="alert message-alert bg-red-100 text-red-800 border border-red-400 rounded-lg p-4 relative" role="alert"></div>
        <label class="flex items-start gap-2 text-sm text-gray-700">
            <input type="checkbox" name="agree_duplicate" id="agree-duplicate" value="yes" class="mt-1">
            <span>Yes, proceed with the duplicate.</span>
        </label>
    </div>
</div>
