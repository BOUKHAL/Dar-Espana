<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-white border border-capstone-yellow rounded-md font-semibold text-xs text-capstone-red uppercase tracking-widest shadow-sm hover:bg-capstone-yellow hover:text-white focus:outline-none focus:ring-2 focus:ring-capstone-red focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
