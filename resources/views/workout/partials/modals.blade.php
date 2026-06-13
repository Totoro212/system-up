        <!-- ================= МОДАЛЬНОЕ ОКНО СОЗДАНИЯ С ДИНАМИЧЕСКИМ ФОРМИРОВАНИЕМ НА ALPINE ================= -->
        <x-modal name="create-workout" :show="$errors->isNotEmpty()" focusable>
            <div class="p-6" x-data="{
                exercises: [
                    { title: '', sets: 3, reps: '10-12', target_muscles: '', weight: '', description: '' }
                ],
                addExercise() {
                    this.exercises.push({ title: '', sets: 3, reps: '10-12', target_muscles: '', weight: '', description: '' });
                },
                removeExercise(index) {
                    if (this.exercises.length > 1) {
                        this.exercises.splice(index, 1);
                    }
                }
            }">

                <x-h2 class="text-base text-slate-100 tracking-wider mb-4 pb-2 border-b border-slate-800/80">
                    Создать программу
                </x-h2>

                <form method="POST" action="{{ route('workouts.store') }}" class="space-y-4">
                    @csrf

                    <!-- Название тренировки -->
                    <div>
                        <x-input-label for="workout_title" value="Название программы" />
                        <x-text-input type="text" name="title" id="workout_title" required placeholder="Например: Силовая А, Сплит: Грудь/Спина" />
                        <x-input-error :messages="$errors->get('title')" class="mt-1" />
                    </div>

                    <!-- Переключатель: включить в программу -->
                    <div>
                        <label class="flex items-center gap-3 cursor-pointer select-none bg-slate-950 border border-slate-850 rounded-xl px-4 py-3">
                            <input type="checkbox" name="in_rotation" value="1" checked
                                class="w-4 h-4 rounded border-slate-700 bg-slate-900 text-indigo-500 focus:ring-indigo-500/30 focus:ring-offset-0 cursor-pointer">
                            <div>
                                <span class="text-xs font-bold text-slate-200 block">🔄 Включить в программу ротации</span>
                                <span class="text-[10px] text-slate-400 block mt-0.5">Тренировка будет идти по очереди с остальными. Если выключить — будет отдельной.</span>
                            </div>
                        </label>
                    </div>

                    <!-- Динамический блок упражнений -->
                    <div class="space-y-4 border-t border-slate-850 pt-4">
                        <div class="flex justify-between items-center">
                            <span class="text-xs font-black text-slate-300 uppercase tracking-widest">Упражнения в
                                тренировке</span>
                            <button type="button" x-on:click="addExercise()"
                                class="text-xs font-bold text-indigo-400 hover:text-indigo-300 uppercase tracking-wider cursor-pointer">
                                ➕ Добавить упражнение
                            </button>
                        </div>

                        <div class="space-y-4 max-h-[300px] overflow-y-auto pr-1">
                            <template x-for="(exercise, index) in exercises" :key="index">
                                <div
                                    class="bg-slate-950/80 border border-slate-850 p-4 rounded-2xl relative space-y-3">

                                    <!-- Кнопка удаления упражнения -->
                                    <button type="button" x-show="exercises.length > 1"
                                        x-on:click="removeExercise(index)"
                                        class="absolute top-2.5 right-2.5 w-6 h-6 rounded-md bg-slate-900 border border-slate-800 text-slate-400 hover:text-red-400 flex items-center justify-center transition-colors cursor-pointer text-xs">
                                        ✕
                                    </button>

                                    <div class="text-xs font-black text-slate-400 uppercase tracking-widest"
                                        x-text="'Упражнение #' + (index + 1)"></div>

                                    <!-- Название -->
                                    <div>
                                        <input type="text" :name="'exercises[' + index + '][title]'" required
                                            placeholder="Название (например: Жим штанги лежа)"
                                            class="w-full bg-slate-900 border border-slate-800 rounded-xl px-3 py-2 text-xs text-slate-200 placeholder-slate-650 focus:outline-none focus:border-indigo-500 transition-colors">
                                    </div>

                                    <!-- Подходы и повторения -->
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <input type="number" :name="'exercises[' + index + '][sets]'" required
                                                min="1" placeholder="Подходы (например: 4)"
                                                class="w-full bg-slate-900 border border-slate-800 rounded-xl px-3 py-2 text-xs text-slate-200 placeholder-slate-650 focus:outline-none focus:border-indigo-500 transition-colors">
                                        </div>
                                        <div>
                                            <input type="text" :name="'exercises[' + index + '][reps]'" required
                                                placeholder="Повторы (например: 12)"
                                                class="w-full bg-slate-900 border border-slate-800 rounded-xl px-3 py-2 text-xs text-slate-200 placeholder-slate-650 focus:outline-none focus:border-indigo-500 transition-colors">
                                        </div>
                                    </div>

                                    <!-- Мышцы и Веса -->
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <input type="text" :name="'exercises[' + index + '][target_muscles]'"
                                                placeholder="Мышцы (например: Грудь)"
                                                class="w-full bg-slate-900 border border-slate-800 rounded-xl px-3 py-2 text-xs text-slate-200 placeholder-slate-650 focus:outline-none focus:border-indigo-500 transition-colors">
                                        </div>
                                        <div>
                                            <input type="text" :name="'exercises[' + index + '][weight]'"
                                                placeholder="Вес (например: 50 кг)"
                                                class="w-full bg-slate-900 border border-slate-900 rounded-xl px-3 py-2 text-xs text-slate-200 placeholder-slate-650 focus:outline-none focus:border-indigo-500 transition-colors">
                                        </div>
                                    </div>

                                    <!-- Описание техники -->
                                    <div>
                                        <textarea :name="'exercises[' + index + '][description]'" rows="2"
                                            placeholder="Техника выполнения (необязательно)"
                                            class="w-full bg-slate-900 border border-slate-800 rounded-xl px-3 py-2 text-xs text-slate-200 placeholder-slate-650 focus:outline-none focus:border-indigo-500 transition-colors font-sans leading-relaxed"></textarea>
                                    </div>

                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Кнопки управления -->
                    <div class="flex justify-end gap-3 pt-2.5 border-t border-slate-850">
                        <x-secondary-button x-on:click="$dispatch('close')" type="button">
                            Отмена
                        </x-secondary-button>
                        <x-primary-button>
                            Сохранить план
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </x-modal>
