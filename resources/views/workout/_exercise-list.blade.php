{{-- Раскрывающийся список упражнений (переиспользуемый partial) --}}
@php $collapseVar = $workout->in_rotation ? 'activeWorkout' : 'activeStandalone'; @endphp
<div x-show="{{ $collapseVar }} === {{ $workout->id }}" x-collapse
    class="mt-4 pt-4 border-t border-slate-950 space-y-3">
    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-1">Упражнения:</span>

    @foreach ($workout->exercises as $exercise)
        <div class="bg-slate-950/80 border border-slate-900 rounded-xl p-4">
            <div class="flex justify-between items-center flex-wrap gap-2">
                <x-h3 class="text-slate-200 font-bold">
                    {{ $exercise->title }}</x-h3>
                <span class="text-xs font-mono text-emerald-400 font-bold bg-emerald-500/5 px-2.5 py-1 rounded">
                    {{ $exercise->sets }} × {{ $exercise->reps }}
                </span>
            </div>
            <div class="flex flex-wrap gap-2 mt-2">
                @if ($exercise->target_muscles)
                    <span class="text-xs font-bold text-slate-300 bg-slate-900 px-2 py-0.5 rounded">
                        🎯 {{ $exercise->target_muscles }}
                    </span>
                @endif
                @if ($exercise->weight)
                    <span class="text-xs font-bold text-amber-400 bg-amber-500/5 px-2 py-0.5 rounded border border-amber-500/10">
                        💪 {{ $exercise->weight }}
                    </span>
                @endif

                @if ($exercise->progression_status !== 'new')
                    <span class="text-xs font-bold px-2 py-0.5 rounded border {{ $exercise->progression_color }}">
                        📈 {{ $exercise->progression_label }}
                    </span>
                @endif

                @if ($exercise->suggested_weight)
                    <span class="text-xs font-bold text-amber-300 bg-amber-500/5 px-2 py-0.5 rounded border border-amber-400/20">
                        ⚡ +2.5 кг → {{ $exercise->suggested_weight }} кг
                    </span>
                @endif
            </div>

            @if ($exercise->description)
                <x-p class="text-slate-300 mt-3 bg-slate-950 p-3 rounded-lg border border-slate-850/80 whitespace-pre-line">
                    {{ $exercise->description }}
                </x-p>
            @endif
        </div>
    @endforeach
</div>
