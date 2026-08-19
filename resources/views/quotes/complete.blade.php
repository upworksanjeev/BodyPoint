<x-checkout.completion
    variant="quote"
    :quote="$quote"
    :expiresAt="$expiresAt"
    :canConvertToOrder="$canConvertToOrder ?? false"
/>
