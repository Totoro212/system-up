<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-4 py-2.5 bg-red-950/20 border border-red-900/40 text-red-400 hover:bg-red-900/30 hover:text-red-300 text-xs font-extrabold uppercase tracking-wider rounded-xl shadow-lg shadow-red-950/10 hover:-translate-y-0.5 active:translate-y-0 disabled:opacity-50 transition-all duration-200 cursor-pointer']) }}>
    {{ $slot }}
</button>
