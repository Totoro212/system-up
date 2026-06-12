@props(['hover' => false])

<div {{ $attributes->merge([
    'class' => 'bg-slate-900/40 border border-slate-800/40 backdrop-blur-md rounded-2xl p-5 shadow-lg transition-all duration-300 ' . 
               ($hover ? 'hover:border-indigo-500/30 hover:shadow-indigo-500/5' : '')
]) }}>
    {{ $slot }}
</div>
