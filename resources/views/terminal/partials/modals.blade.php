<!-- Модальные окна для редактирования событий -->
@foreach ($events ?? [] as $event)
    <x-modal name="edit-event-{{ $event->id }}" focusable>
        <div class="p-6">
            <x-h2 class="text-base text-slate-100 tracking-wider mb-4 pb-2 border-b border-slate-800/80">
                Редактировать событие
            </x-h2>

            <form method="POST" action="{{ route('events.update', $event->id) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <x-input-label for="event_title_{{ $event->id }}" value='Название события'></x-input-label>
                    <x-text-input type="text" name="title" id="event_title_{{ $event->id }}" required value="{{ $event->title }}" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="event_date_{{ $event->id }}" value="Дата" />
                        <x-text-input type="date" name="event_date" id="event_date_{{ $event->id }}" required value="{{ \Carbon\Carbon::parse($event->event_date)->format('Y-m-d') }}" />
                    </div>
                    <div>
                        <x-input-label for="event_icon_{{ $event->id }}" value="Иконка (Эмодзи)" />
                        <x-text-input type="text" name="icon" id="event_icon_{{ $event->id }}" value="{{ $event->icon }}" maxlength="10" />
                    </div>
                </div>

                <div>
                    <label class="flex items-center gap-3 cursor-pointer select-none bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 hover:bg-slate-850 transition-colors">
                        <input type="checkbox" name="is_annual" value="1" {{ $event->is_annual ? 'checked' : '' }}
                            class="w-4 h-4 rounded border-slate-700 bg-slate-900 text-indigo-500 focus:ring-indigo-500/30 cursor-pointer">
                        <div>
                            <span class="text-xs font-bold text-slate-200 block">🔁 Ежегодное событие</span>
                            <span class="text-[10px] text-slate-400 block mt-0.5">Будет автоматически переноситься на следующий год</span>
                        </div>
                    </label>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <x-secondary-button x-on:click="$dispatch('close')" type="button">Отмена</x-secondary-button>
                    <x-primary-button>Сохранить изменения</x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>
@endforeach

<!-- Модальное окно создания события -->
<x-modal name="create-event" focusable>
    <div class="p-6">
        <x-h2 class="text-base text-slate-100 tracking-wider mb-4 pb-2 border-b border-slate-800/80">
            Добавить важную дату
        </x-h2>

        <form method="POST" action="{{ route('events.store') }}" class="space-y-4">
            @csrf

            <div>
                <x-input-label for="event_title" value='Название события'></x-input-label>
                <x-text-input type="text" name="title" id="event_title" required
                    placeholder="Например: День рождения мамы, Продление Netflix" />
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <x-input-label for="event_date" value="Дата" />
                    <x-text-input type="date" name="event_date" id="event_date" required />
                </div>
                <div>
                    <x-input-label for="event_icon" value="Иконка (Эмодзи)" />
                    <x-text-input type="text" name="icon" id="event_icon" value="📅" maxlength="10" />
                </div>
            </div>

            <div>
                <label class="flex items-center gap-3 cursor-pointer select-none bg-slate-900 border border-slate-800 rounded-xl px-4 py-3 hover:bg-slate-850 transition-colors">
                    <input type="checkbox" name="is_annual" value="1"
                        class="w-4 h-4 rounded border-slate-700 bg-slate-900 text-indigo-500 focus:ring-indigo-500/30 cursor-pointer">
                    <div>
                        <span class="text-xs font-bold text-slate-200 block">🔁 Ежегодное событие</span>
                        <span class="text-[10px] text-slate-400 block mt-0.5">Будет автоматически переноситься на следующий год</span>
                    </div>
                </label>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <x-secondary-button x-on:click="$dispatch('close')" type="button">Отмена</x-secondary-button>
                <x-primary-button>Сохранить дату</x-primary-button>
            </div>
        </form>
    </div>
</x-modal>
