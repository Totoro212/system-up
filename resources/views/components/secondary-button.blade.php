<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-4 py-2.5 bg-slate-900 border border-slate-800 rounded-xl font-bold text-xs text-slate-300 uppercase tracking-wider shadow-sm hover:bg-slate-850 hover:text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 disabled:opacity-50 transition-all duration-150 cursor-pointer']) }}>
    {{ $slot }}
</button>
