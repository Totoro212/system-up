@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-xs font-bold text-slate-400 mb-1.5 uppercase tracking-wider']) }}>
    {{ $value ?? $slot }}
</label>
