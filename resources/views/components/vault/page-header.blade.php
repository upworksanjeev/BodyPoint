@props([
    'title' => 'Partner Vault',
])

<section class="bg-[#00838F] text-[#ffffff] px-6 lg:px-10">
    <div class="lg:container mx-auto py-7 md:py-9">
        <h1 class="text-[32px] md:text-5xl font-400 leading-tight">{{ $title }}</h1>
        {{ $slot }}
    </div>
</section>
