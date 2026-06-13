        <!-- Модальное окно создания квеста -->
        <x-modal name="create-quest" :show="$errors->isNotEmpty()" focusable>
            <div class="p-6">
                <x-h2 class="text-base text-slate-100 tracking-wider mb-4 pb-2 border-b border-slate-800/80">
                    Создать личный квест
                </x-h2>

                <form method="POST" action="{{ route('quests.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <x-input-label for="title" value='Название'></x-input-label>
                        <x-text-input type="text" name="title" id="title" required
                            placeholder="Например: Выпить 2 литра воды" />
                        <x-input-error :messages="$errors->get('title')" class="mt-1" />
                    </div>

                    <div>
                        <x-input-label for="description" value="Описание" />
                        <x-text-input type="text" name="description" id="description" required
                            placeholder="Детали, регулярность или цель..." />
                        <x-input-error :messages="$errors->get('description')" class="mt-1" />
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <x-secondary-button x-on:click="$dispatch('close')" type="button">
                            Отмена
                        </x-secondary-button>
                        <x-primary-button>
                            Добавить в список
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </x-modal>
