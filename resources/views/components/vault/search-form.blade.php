@props([
    'search',
    'action' => null,
])

@php
    $action = $action ?? route('vault');
@endphp

<form method="get" action="{{ $action }}" class="w-full">
    @foreach ($search->toQuery(['q' => null]) as $name => $value)
        <input type="hidden" name="{{ $name }}" value="{{ $value }}">
    @endforeach
    <label for="vault-search" class="sr-only">Search the Vault</label>
    <div class="vault-search">
        <span class="vault-search__icon" aria-hidden="true">
            <x-icons.search />
        </span>
        <input type="text" id="vault-search" name="q" value="{{ $search->term }}"
            placeholder="Search assets by name, tag or category"
            autocomplete="off" enterkeyhint="search">
        <button type="submit">Search</button>
    </div>
</form>
