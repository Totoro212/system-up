{{-- Раскрывающийся список упражнений (переиспользуемый partial) --}}
<div x-show="activeWorkout === {{ $workout->id }}" x-collapse
    class="mt-4 pt-4 border-t border-slate-950 space-y-3">
    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-1">Упражнения:</span>

    @foreach ($workout->exercises as $exercise)
        <div class="bg-slate-950/80 border border-slate-900 rounded-xl p-4">
            <div>
                <x-h3 class="text-slate-200 font-bold">
                    {{ $exercise->title }}</x-h3>
                <div class="text-xs font-mono text-emerald-400 font-bold mt-1">
                    {{ $exercise->sets }} × {{ $exercise->reps }}
                </div>
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
            </div>

            @if ($exercise->description)
                <x-p class="text-slate-300 mt-3 bg-slate-950 p-3 rounded-lg border border-slate-850/80 whitespace-pre-line">
                    {{ $exercise->description }}
                </x-p>
            @endif
        </div>
    @endforeach
</div>
