<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#00838f] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#00838f] focus:bg-[#00838f] active:bg-[#00838f] focus:outline-none focus:ring-0 focus:none focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
