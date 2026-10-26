@props(['hover' => false])

<div {{ $attributes->merge([
    'class' => 'bg-white border border-slate-200/90 rounded-2xl p-5 shadow-[0_4px_20px_rgba(15,23,42,0.04)] transition-all duration-300 ' . 
               ($hover ? 'hover:border-indigo-400/50 hover:shadow-[0_8px_25px_rgba(99,102,241,0.08)] hover:-translate-y-0.5' : '')
]) }}>
    {{ $slot }}
</div>
