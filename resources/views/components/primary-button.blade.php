<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-3 bg-[#2563eb] border border-transparent rounded-xl font-extrabold text-sm text-white uppercase tracking-widest hover:bg-[#1d4ed8] focus:bg-[#1d4ed8] active:bg-[#1e40af] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md transform active:scale-95']) }}>
    {{ $slot }}
</button>
