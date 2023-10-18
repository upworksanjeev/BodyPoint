<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#008c99] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#008c99] focus:bg-[#008c99] active:bg-[#008c99] focus:outline-none focus:ring-0 focus:none focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
