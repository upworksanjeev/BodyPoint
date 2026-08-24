@props([
    'search',
    'action',
])

<form method="get" action="{{ $action }}" class="flex items-center gap-2">
    @foreach ($search->toQuery(['sort' => null]) as $name => $value)
        <input type="hidden" name="{{ $name }}" value="{{ $value }}">
    @endforeach
    <label for="vault-sort" class="text-[13px] text-[#6b6b6b] shrink-0">Sort</label>
    <select id="vault-sort" name="sort" onchange="this.form.submit()"
        class="bg-white border border-[#d4d4d4] text-sm rounded-lg px-3 py-2 focus:ring-[#00838F] focus:border-[#00838F]">
        @foreach (\App\Enums\VaultSort::cases() as $sort)
            <option value="{{ $sort->value }}" @selected($search->sort === $sort)>{{ $sort->label() }}</option>
        @endforeach
    </select>
</form>
