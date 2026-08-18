@props(['page', 'intent' => null])

@php
    // Steps 2 and 3 follow the dealer's order-or-quote choice, so the quote path is
    // never offered an order label. The completion screens pass the choice in, since
    // the cart it is stored on is already gone by the time they render.
    $flowIntent = $intent ?? app(\App\Services\CheckoutIntentService::class)->current();
    $isQuoteFlow = $flowIntent?->isQuote() ?? false;

    $reviewRoute = route(($flowIntent ?? \App\Enums\CheckoutIntent::Order)->reviewRouteName());
    $reviewLabel = $isQuoteFlow ? 'Review Quote' : 'Review Order';
    $completeLabel = $isQuoteFlow ? 'Quote Complete' : 'Order Complete';

    // Once the flow is finished there is nothing left to step back into, so the
    // completion page shows the trail without links.
    $isComplete = $page === 'complete';

    $steps = [
        ['label' => 'Shipping/Payment', 'route' => $isComplete ? null : route('shipping'), 'done' => true],
        ['label' => $reviewLabel, 'route' => $isComplete ? null : $reviewRoute, 'done' => in_array($page, ['review', 'complete'], true)],
        ['label' => $completeLabel, 'route' => null, 'done' => $isComplete],
    ];
    $lastStep = count($steps) - 1;
@endphp
<div class="grid grid-cols-1 lg:pb-14 pb-2 sm:pb-6">
    <div class="col-span-2">
        <ul class="flex flex-wrap items-center w-full text-sm font-medium text-center text-gray-500 sm:text-base order-step">
            @foreach ($steps as $index => $step)
                <li
                    class="{{ $step['done'] ? 'active' : '' }} flex-1 flex flex-col items-center gap-3 @if($index !== $lastStep) relative after:content-[''] after:absolute after:top-[15px] after:left-[50%] after:w-full after:h-[2px] after:bg-gray-200 @endif">
                    <div class="z-10">
                        @if ($step['route'])
                            <a href="{{ $step['route'] }}">
                                <span
                                    class="text-[13px] font-bold text-[#A6A2A2] bg-white w-[30px] min-w-[30px] h-[30px] border-2 border-solid rounded-full flex justify-center items-center">
                                    {{ $index + 1 }}
                                </span>
                            </a>
                        @else
                            <span
                                class="text-[13px] font-bold text-[#A6A2A2] bg-white w-[30px] min-w-[30px] h-[30px] border-2 border-solid rounded-full flex justify-center items-center">
                                {{ $index + 1 }}
                            </span>
                        @endif
                    </div>
                    <p class="text-[13px] min-h-[42px] sm:min-h-[auto] font-normal text-[{{ $step['done'] ? '#000' : '#717171' }}]">
                        @if ($step['route'])
                            <a href="{{ $step['route'] }}">{{ $step['label'] }}</a>
                        @else
                            {{ $step['label'] }}
                        @endif
                    </p>
                </li>
            @endforeach
        </ul>
    </div>
</div>
