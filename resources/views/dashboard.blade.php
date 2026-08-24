<x-mainpage-layout>
    @section('title', 'Home - ' . config('app.name', 'Bodypoint'))
    <x-cart-nav />

    <section class="bg-[#f4f4f4] py-8 md:py-10 px-4 min-h-[62vh]">
        <div class="container mx-auto">
            <div class="max-w-screen-xl mx-auto">
                <div class="bg-white rounded-2xl border border-[#E5E5E5] shadow-sm p-6 md:p-8">
                    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6 mb-8">
                        <div>
                            <h1 class="text-[28px] md:text-[32px] leading-tight font-bold text-[#1a1a1a]">
                                Welcome back, {{ $firstName }} 👋
                            </h1>
                            <p class="mt-2 text-[15px] text-[#6b6b6b]">
                                You're working in account
                                <span class="font-semibold text-[#1a1a1a]">{{ $accountCode }} · {{ $accountName }}</span>
                            </p>
                        </div>
                        @if ($canSwitchAccount)
                            <div class="lg:pt-1">
                                <x-customer-switcher :compact="true" />
                            </div>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                        @if ($canPlaceOrders)
                            <div class="order-1 h-full rounded-xl p-5 bg-[#eaf6ea] border border-[#cfe8cf]">
                                <a href="{{ url('/') }}" class="block">
                                    <span class="block text-[26px] leading-none mb-4">🛒</span>
                                    <p class="text-[17px] font-bold text-[#1a1a1a]">Place an Order</p>
                                </a>
                                <p class="mt-1 text-[13px] leading-5 text-[#5c5c5c]">
                                    <a href="{{ url('/') }}" class="hover:underline">Browse products</a>
                                    or
                                    <a href="{{ url('/cart') }}" class="hover:underline">quick-reorder by stock code</a>
                                </p>
                            </div>
                        @endif

                        @if ($canViewQuotes)
                            <a href="{{ url('/') }}" class="order-2 h-full block rounded-xl p-5 bg-white border border-[#E5E5E5] hover:border-[#cfcfcf] transition">
                                <span class="block text-[26px] leading-none mb-4">📄</span>
                                <p class="text-[17px] font-bold text-[#1a1a1a]">Get a Quote</p>
                                <p class="mt-1 text-[13px] leading-5 text-[#5c5c5c]">Build a quote and save or download it</p>
                            </a>
                        @endif

                        @if ($canViewOrders)
                            <a href="{{ url('/order') }}" class="order-3 h-full block rounded-xl p-5 bg-white border border-[#E5E5E5] hover:border-[#cfcfcf] transition">
                                <span class="block text-[26px] leading-none mb-4">📦</span>
                                <p class="text-[17px] font-bold text-[#1a1a1a]">Track Orders</p>
                                <p class="mt-1 text-[13px] leading-5 text-[#5c5c5c]">See status &amp; history for your orders</p>
                            </a>
                        @endif

                        @if ($canAccessVault)
                            <a href="{{ route('vault') }}" class="order-4 h-full block rounded-xl p-5 bg-[#eee8f6] border border-[#ddd4ee] hover:brightness-[0.98] transition">
                                <span class="block text-[26px] leading-none mb-4">🔒</span>
                                <p class="text-[17px] font-bold text-[#1a1a1a]">Partner Vault</p>
                                <p class="mt-1 text-[13px] leading-5 text-[#5c5c5c] flex items-start gap-2">
                                    <span>Marketing assets, guides &amp; resources</span>
                                    <span class="shrink-0 mt-0.5 text-[10px] font-bold tracking-wide text-white bg-[#3d8a4a] px-1.5 py-0.5 rounded">NEW</span>
                                </p>
                            </a>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
                        @if ($canViewOrders)
                            <div class="rounded-xl border border-[#E5E5E5] p-5">
                                <div class="flex items-center justify-between mb-1">
                                    <h2 class="text-[16px] font-bold text-[#1a1a1a]">Recent Orders</h2>
                                    <a href="{{ url('/order') }}" class="text-[13px] text-[#2f6fed] underline">View all</a>
                                </div>
                                @if ($recentOrders->isEmpty())
                                    <p class="mt-4 text-sm text-[#6b6b6b]">No orders yet</p>
                                    <a href="{{ route('home') }}" class="inline-block mt-2 text-[13px] text-[#2f6fed] underline">Browse products</a>
                                @else
                                    <ul class="divide-y divide-dashed divide-[#d9d9d9]">
                                        @foreach ($recentOrders as $order)
                                            <li class="py-3 flex items-center justify-between gap-3">
                                                <p class="text-[13px] text-[#1a1a1a] truncate">
                                                    #{{ $order['number'] }}
                                                    @if (!empty($order['item_name']))
                                                        · {{ $order['item_name'] }}
                                                    @endif
                                                </p>
                                                <span class="shrink-0 text-[11px] font-medium px-2.5 py-0.5 rounded-full border border-[#3d8a4a] text-[#2f7a3c] bg-white">
                                                    {{ $order['status'] }}
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        @endif

                        @if ($canViewQuotes)
                            <div class="rounded-xl border border-[#E5E5E5] p-5">
                                <div class="flex items-center justify-between mb-1">
                                    <h2 class="text-[16px] font-bold text-[#1a1a1a]">Open Quotes</h2>
                                    <a href="{{ url('/quotes') }}" class="text-[13px] text-[#2f6fed] underline">View all</a>
                                </div>
                                @if ($openQuotes->isEmpty())
                                    <p class="mt-4 text-sm text-[#6b6b6b]">No open quotes</p>
                                    <a href="{{ route('home') }}" class="inline-block mt-2 text-[13px] text-[#2f6fed] underline">Start a quote</a>
                                @else
                                    <ul class="divide-y divide-dashed divide-[#d9d9d9]">
                                        @foreach ($openQuotes as $quote)
                                            <li class="py-3 flex items-center justify-between gap-3">
                                                <p class="text-[13px] text-[#1a1a1a] truncate">
                                                    #{{ $quote['number'] }}
                                                    @if (!empty($quote['item_name']))
                                                        · {{ $quote['item_name'] }}
                                                    @endif
                                                </p>
                                                <span class="shrink-0 text-[11px] font-medium px-2.5 py-0.5 rounded-full {{ $quote['near_expiry'] ? 'bg-[#f8d4d4] text-[#b42318]' : 'bg-[#f3e3c2] text-[#8a6a1b]' }}">
                                                    {{ $quote['expiry_label'] }}
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        @endif

                        <div class="rounded-xl border border-[#E5E5E5] p-5">
                            <h2 class="text-[16px] font-bold text-[#1a1a1a]">Your Cart</h2>
                            @if ($cartSummary['is_empty'])
                                <p class="mt-4 text-sm text-[#6b6b6b]">Your cart is empty</p>
                                <a href="{{ route('home') }}" class="inline-block mt-2 text-[13px] text-[#2f6fed] underline">Browse products</a>
                            @else
                                <div class="mt-6 flex items-center justify-between gap-3">
                                    <p class="text-[14px] text-[#1a1a1a]">
                                        {{ $cartSummary['count'] }} {{ $cartSummary['count'] === 1 ? 'item' : 'items' }} waiting
                                        · ${{ number_format($cartSummary['subtotal'], 2) }}
                                    </p>
                                    <a href="{{ url('/cart') }}"
                                        class="shrink-0 inline-flex items-center py-2 px-5 text-sm font-semibold text-white bg-[#f07a1a] rounded-lg hover:bg-[#d86c14]">
                                        Resume →
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="border-t border-[#E5E5E5] pt-5">
                        <div class="flex flex-wrap items-center justify-between gap-x-6 gap-y-3 text-[14px] text-[#3a3a3a]">
                            <a href="{{ route('vault.category', 'pricing-guide') }}" class="inline-flex items-center gap-2 hover:text-[#00838f]">
                                <span>📥</span>
                                <span>Price lists</span>
                            </a>
                            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 hover:text-[#00838f]">
                                <span>📖</span>
                                <span>Product catalog</span>
                            </a>
                            <a href="{{ config('bodypoint.home_how_to_url') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 hover:text-[#00838f]">
                                <span>🎦</span>
                                <span>How-to videos</span>
                            </a>
                            <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-2 hover:text-[#00838f]">
                                <span>👤</span>
                                <span>My account</span>
                            </a>
                            <a href="{{ config('bodypoint.home_url') }}/contact-us/" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 hover:text-[#00838f]">
                                <span>✉️</span>
                                <span>Contact Bodypoint</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-mainpage-layout>
