{{-- Раскрывающийся список упражнений (переиспользуемый partial) --}}
<div x-show="activeWorkout === {{ $workout->id }}" x-collapse
    class="mt-4 pt-4 border-t border-slate-100 space-y-3">
    <span class="text-xs font-bold text-slate-500 uppercase tracking-widest block mb-1">Упражнения:</span>

    @foreach ($workout->exercises as $exercise)
        <div class="bg-slate-50 border border-slate-200/80 rounded-xl p-4">
            <div>
                <x-h3 class="text-slate-900 font-bold">
                    {{ $exercise->title }}</x-h3>
                <div class="text-xs font-mono text-emerald-600 font-bold mt-1">
                    {{ $exercise->sets }} × {{ $exercise->reps }}
                </div>
            </div>
            <div class="flex flex-wrap gap-2 mt-2">
                @if ($exercise->target_muscles)
                    <span class="text-xs font-bold text-slate-600 bg-slate-100 px-2 py-0.5 rounded border border-slate-200/60">
                        🎯 {{ $exercise->target_muscles }}
                    </span>
                @endif
                @if ($exercise->weight)
                    <span class="text-xs font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded border border-amber-200/60">
                        💪 {{ $exercise->weight }}
                    </span>
                @endif
            </div>

            @if ($exercise->description)
                <x-p class="text-slate-600 mt-3 bg-white p-3 rounded-lg border border-slate-200/80 whitespace-pre-line">
                    {{ $exercise->description }}
                </x-p>
            @endif
        </div>
    @endforeach
</div>
