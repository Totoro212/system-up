<?php

namespace App\Http\Controllers\Workout;

use App\Http\Controllers\Controller;
use App\Models\Workout;
use App\Models\ExerciseLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class WorkoutController extends Controller
{
    /**
     * Отобразить список тренировок и определить следующую в очереди.
     *
     * Логика очереди (round-robin):
     * Все тренировки пользователя отсортированы по sort_order.
     * Следующая тренировка — та, у которой last_performed_at самая старая
     * (или NULL, если ещё не выполнялась). При равенстве — приоритет по sort_order.
     * Если текущая «следующая» тренировка уже выполнена сегодня — значит день отдыха.
     */
    public function index(): View
    {
        $workouts = Workout::with(['exercises.logs' => function ($query) {
            $query->where('user_id', auth()->id())
                  ->orderByDesc('performed_at')
                  ->limit(2);
        }])
            ->where('user_id', auth()->id())
            ->ordered()
            ->get();

        // Все тренировки участвуют в ротации программы
        $programWorkouts = $workouts;

        // Определяем следующую тренировку в очереди (round-robin) ТОЛЬКО среди программных:
        // Приоритет: сначала те, что никогда не выполнялись (NULL),
        // затем те, что выполнялись давно, при равенстве — по sort_order.
        $nextWorkout = $programWorkouts
            ->sortBy(function ($workout) {
                $timestamp = $workout->last_performed_at
                    ? $workout->last_performed_at->timestamp
                    : 0;
                return $timestamp + ($workout->sort_order / 10000);
            })
            ->first();

        // Если следующая тренировка уже выполнена сегодня — показываем день отдыха
        $todayWorkout = null;
        if ($nextWorkout && !($nextWorkout->last_performed_at && $nextWorkout->last_performed_at->isToday())) {
            $todayWorkout = $nextWorkout;
        }

        // Рассчитываем статусы отставания для каждой тренировки
        foreach ($workouts as $workout) {
            if (!$workout->last_performed_at) {
                $workout->status = 'not_started';
                $workout->status_label = 'Не начато';
                $workout->status_color = 'text-slate-400 bg-slate-500/10 border-slate-500/20';
            } else {
                $daysSince = now()->diffInDays($workout->last_performed_at);
                if ($daysSince < 7) {
                    $workout->status = 'in_tone';
                    $workout->status_label = 'В тонусе';
                    $workout->status_color = 'text-emerald-400 bg-emerald-500/10 border-emerald-500/20';
                } elseif ($daysSince <= 10) {
                    $workout->status = 'warning';
                    $workout->status_label = 'Пропуск';
                    $workout->status_color = 'text-amber-400 bg-amber-500/10 border-amber-500/20';
                } else {
                    $workout->status = 'lagging';
                    $workout->status_label = 'Отстает! 🔥';
                    $workout->status_color = 'text-red-400 bg-red-500/10 border-red-500/20';
                }
            }

            // Рассчитываем прогрессию для каждого упражнения
            foreach ($workout->exercises as $exercise) {
                $logs = $exercise->logs
                    ->where('user_id', auth()->id())
                    ->sortByDesc('performed_at')
                    ->values();

                if ($logs->count() === 0) {
                    $exercise->progression_status = 'new';
                    $exercise->progression_label = 'Нет данных';
                    $exercise->progression_color = 'text-slate-400 bg-slate-500/10 border-slate-500/20';
                    $exercise->progression_diff = null;
                    $exercise->suggested_weight = null;
                    $exercise->last_weight = null;
                } elseif ($logs->count() === 1) {
                    $exercise->progression_status = 'first';
                    $exercise->progression_label = $logs[0]->weight_used . ' кг';
                    $exercise->progression_color = 'text-indigo-400 bg-indigo-500/10 border-indigo-500/20';
                    $exercise->progression_diff = null;
                    $exercise->suggested_weight = null;
                    $exercise->last_weight = $logs[0]->weight_used;
                } else {
                    $current = $logs[0]->weight_used;
                    $previous = $logs[1]->weight_used;
                    $diff = $current - $previous;
                    $exercise->last_weight = $current;

                    if ($diff > 0) {
                        $exercise->progression_status = 'up';
                        $exercise->progression_label = '↑ +' . abs($diff) . ' кг';
                        $exercise->progression_color = 'text-emerald-400 bg-emerald-500/10 border-emerald-500/20';
                        $exercise->progression_diff = $diff;
                        $exercise->suggested_weight = null;
                    } elseif ($diff < 0) {
                        $exercise->progression_status = 'down';
                        $exercise->progression_label = '↓ -' . abs($diff) . ' кг';
                        $exercise->progression_color = 'text-red-400 bg-red-500/10 border-red-500/20';
                        $exercise->progression_diff = $diff;
                        $exercise->suggested_weight = $current + 2.5;
                    } else {
                        $exercise->progression_status = 'same';
                        $exercise->progression_label = '→ стагнация';
                        $exercise->progression_color = 'text-amber-400 bg-amber-500/10 border-amber-500/20';
                        $exercise->progression_diff = 0;
                        $exercise->suggested_weight = $current + 2.5;
                    }
                }
            }
        }

        $totalProgramWorkouts = $programWorkouts->count();

        return view('workout.index', compact('programWorkouts', 'todayWorkout', 'totalProgramWorkouts'));
    }

    /**
     * Сохранить тренировку и все её упражнения одной безопасной транзакцией.
     * sort_order назначается автоматически (следующий в очереди).
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'in_rotation' => ['nullable', 'boolean'],
            'exercises' => ['required', 'array', 'min:1'],
            'exercises.*.title' => ['required', 'string', 'max:255'],
            'exercises.*.sets' => ['required', 'integer', 'min:1'],
            'exercises.*.reps' => ['required', 'string', 'max:255'],
            'exercises.*.target_muscles' => ['nullable', 'string', 'max:255'],
            'exercises.*.weight' => ['nullable', 'string', 'max:255'],
            'exercises.*.description' => ['nullable', 'string', 'max:5000'],
        ]);

        DB::transaction(function () use ($validated) {
            // sort_order назначается автоматически
            $maxOrder = auth()->user()->workouts()->max('sort_order') ?? -1;

            $workout = auth()->user()->workouts()->create([
                'title' => $validated['title'],
                'sort_order' => $maxOrder + 1,
                'in_rotation' => true,
            ]);

            foreach ($validated['exercises'] as $exerciseData) {
                $workout->exercises()->create($exerciseData);
            }
        });

        return redirect()->route('workouts.index')->with('success', 'Программа тренировки успешно создана!');
    }

    /**
     * Обновить тренировку и её упражнения безопасной транзакцией.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $workout = Workout::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'exercises' => ['required', 'array', 'min:1'],
            'exercises.*.id' => ['nullable', 'integer'],
            'exercises.*.title' => ['required', 'string', 'max:255'],
            'exercises.*.sets' => ['required', 'integer', 'min:1'],
            'exercises.*.reps' => ['required', 'string', 'max:255'],
            'exercises.*.weight' => ['nullable', 'string', 'max:255'],
        ]);

        DB::transaction(function () use ($validated, $workout) {
            $workout->update([
                'title' => $validated['title'],
            ]);

            $existingExerciseIds = [];
            foreach ($validated['exercises'] as $exerciseData) {
                if (!empty($exerciseData['id'])) {
                    $exercise = $workout->exercises()->findOrFail($exerciseData['id']);
                    $exercise->update($exerciseData);
                    $existingExerciseIds[] = $exercise->id;
                } else {
                    $newExercise = $workout->exercises()->create($exerciseData);
                    $existingExerciseIds[] = $newExercise->id;
                }
            }

            // Удаляем упражнения, которые больше не присутствуют в обновленном списке
            $workout->exercises()->whereNotIn('id', $existingExerciseIds)->delete();
        });

        return redirect()->route('workouts.index')->with('success', 'Программа тренировки успешно обновлена!');
    }

    /**
     * Отметить тренировку как выполненную сегодня и сохранить рабочие веса.
     */
    public function complete(Request $request, $id): RedirectResponse
    {
        $workout = Workout::where('user_id', auth()->id())->findOrFail($id);

        DB::transaction(function () use ($request, $workout) {
            $workout->update(['last_performed_at' => now()]);

            // Сохранение рабочих весов по каждому упражнению
            $weights = $request->input('weights', []);
            foreach ($weights as $exerciseId => $weightValue) {
                if ($weightValue !== null && $weightValue !== '' && is_numeric($weightValue)) {
                    // Проверяем, что упражнение действительно принадлежит этой тренировке
                    $exerciseBelongs = $workout->exercises()->where('id', $exerciseId)->exists();
                    if ($exerciseBelongs) {
                        ExerciseLog::create([
                            'exercise_id' => (int) $exerciseId,
                            'user_id' => auth()->id(),
                            'weight_used' => (float) $weightValue,
                            'performed_at' => today(),
                        ]);
                    }
                }
            }
        });

        return redirect()->route('workouts.index')->with('success', 'Отлично! Тренировка выполнена, прогрессия записана! 💪');
    }

    /**
     * Удалить программу тренировки со всеми её упражнениями.
     */
    public function destroy($id): RedirectResponse
    {
        $workout = Workout::where('user_id', auth()->id())->findOrFail($id);
        $workout->delete();

        return redirect()->route('workouts.index')->with('success', 'Программа тренировки успешно удалена.');
    }

    /**
     * Загрузить легендарную программу PUSH/PULL/LEGS по умолчанию для текущего пользователя.
     * Тренировки идут последовательно: PUSH → PULL → LEGS → ТОНУС.
     */
    public function seedDefault(): RedirectResponse
    {
        $user = auth()->user();

        DB::transaction(function () use ($user) {
            // Очищаем старые тренировки пользователя, чтобы избежать дублирования
            Workout::where('user_id', $user->id)->delete();

            // 1. PUSH (sort_order: 0)
            $push = Workout::create([
                'user_id' => $user->id,
                'title' => 'PUSH — грудь, плечи, трицепс',
                'sort_order' => 0,
            ]);

            $push->exercises()->createMany([
                [
                    'title' => 'Отжимания на брусьях',
                    'sets' => 4,
                    'reps' => '13',
                    'target_muscles' => 'грудь, трицепс, передняя дельта',
                    'weight' => '+4 кг',
                    'description' => "• Наклон корпуса вперёд ~30° = больше грудь\n• Корпус вертикально = больше трицепс\n• Не разгибай локти полностью в верхней точке (береги суставы)\n• Опускайся до угла 90° в локтях",
                ],
                [
                    'title' => 'Отжимания от пола (широкий хват)',
                    'sets' => 4,
                    'reps' => '14',
                    'target_muscles' => 'грудь, передняя дельта',
                    'weight' => '+4 кг',
                    'description' => "• Руки шире плеч на 1.5 ладони\n• Тело — прямая линия (не прогибай поясницу!)\n• Касайся грудью пола",
                ],
                [
                    'title' => 'Пайк-отжимания (Pike Push-Ups)',
                    'sets' => 3,
                    'reps' => '12',
                    'target_muscles' => 'передняя и средняя дельта, трицепс',
                    'weight' => '+4 кг',
                    'description' => "• Встань в перевёрнутую «V» — руки и ноги на полу, таз вверх\n• Опускай голову к полу между руками\n• Чем ближе ноги к рукам — тем сложнее",
                ],
                [
                    'title' => 'Разводки гантелей в стороны',
                    'sets' => 4,
                    'reps' => '14',
                    'target_muscles' => 'средний пучок дельт',
                    'weight' => '7 кг',
                    'description' => "• Стоя, руки с гантелями по бокам\n• Поднимай руки в стороны до уровня плеч (не выше!)\n• Локти слегка согнуты, мизинец чуть выше большого пальца\n• Опускай медленно (2 сек вниз)",
                ],
                [
                    'title' => 'Французский жим гантелей',
                    'sets' => 3,
                    'reps' => '12',
                    'target_muscles' => 'трицепс (длинная головка)',
                    'weight' => '7 кг',
                    'description' => "• Лёжа на спине, гантель двумя руками над головой\n• Сгибай локти, опуская гантель ЗА ГОЛОВУ (не ко лбу!)\n• Локти смотрят в потолок и НЕ расходятся в стороны\n• Разгибай руки плавно, чувствуя растяжение трицепса",
                ],
            ]);

            // 2. PULL (sort_order: 1)
            $pull = Workout::create([
                'user_id' => $user->id,
                'title' => 'PULL — спина, бицепс',
                'sort_order' => 1,
            ]);

            $pull->exercises()->createMany([
                [
                    'title' => 'Подтягивания (широкий хват)',
                    'sets' => 3,
                    'reps' => '10',
                    'target_muscles' => 'широчайшие, большая круглая, бицепс',
                    'weight' => '+4 кг',
                    'description' => "• Хват шире плеч, ладони от себя\n• Тяни локти вниз и назад, а не руки\n• Подбородок выше перекладины\n• Опускайся плавно (2–3 сек негативная фаза)",
                ],
                [
                    'title' => 'Подтягивания (обратный хват)',
                    'sets' => 3,
                    'reps' => '10',
                    'target_muscles' => 'бицепс, нижняя часть широчайших',
                    'weight' => '+4 кг',
                    'description' => "• Хват на ширине плеч, ладони к себе\n• Сведи лопатки в верхней точке\n• Контролируй спуск (2–3 сек)",
                ],
                [
                    'title' => 'Тяга гантели в наклоне',
                    'sets' => 4,
                    'reps' => '12 /руку',
                    'target_muscles' => 'широчайшие, ромбовидные, трапеции, бицепс',
                    'weight' => '10 кг',
                    'description' => "• Одно колено и рука на скамье/стуле\n• Спина параллельна полу\n• Тяни гантель к бедру, не к груди\n• Сведи лопаткой в верхней точке, задержись на 2 сек",
                ],
                [
                    'title' => 'Обратные разводки в наклоне',
                    'sets' => 4,
                    'reps' => '14',
                    'target_muscles' => 'задняя дельта, ромбовидные',
                    'weight' => '7 кг',
                    'description' => "• Наклонись вперёд ~45°, спина прямая\n• Руки с гантелями внизу, локти слегка согнуты\n• Разводи руки в стороны, сводя лопатки\n• Медленно опускай (2 сек вниз)",
                ],
                [
                    'title' => 'Сгибания на бицепс с гантелями',
                    'sets' => 3,
                    'reps' => '12',
                    'target_muscles' => 'бицепс, брахиалис',
                    'weight' => '7 кг',
                    'description' => "• Стоя, руки с гантелями по бокам, ладони вперёд\n• Сгибай руки, прижимая локти к корпусу (не раскачивай!)\n• В верхней точке — пиковое сокращение 1 сек\n• Опускай медленно (2–3 сек негативная фаза)",
                ],
            ]);

            // 3. LEGS (sort_order: 2)
            $legs = Workout::create([
                'user_id' => $user->id,
                'title' => 'LEGS + CORE — ноги, ягодицы, пресс',
                'sort_order' => 2,
            ]);

            $legs->exercises()->createMany([
                [
                    'title' => 'Приседания (гоблет)',
                    'sets' => 4,
                    'reps' => '13',
                    'target_muscles' => 'квадрицепсы, ягодицы, задняя бедра',
                    'weight' => '10 кг',
                    'description' => "• Стопы на ширине плеч, носки слегка наружу\n• Садись так, будто садишься на стул за спиной\n• Колени движутся по направлению носков (не внутрь!)\n• Опускайся до параллели бёдер с полом (или ниже)",
                ],
                [
                    'title' => 'Болгарские сплит-приседания',
                    'sets' => 3,
                    'reps' => '10 /ногу',
                    'target_muscles' => 'квадрицепсы, ягодицы, баланс',
                    'weight' => '7 + 10 кг',
                    'description' => "• Задняя нога на скамье/стуле\n• Опускайся плавно (3 сек вниз, 1 сек пауза)\n• Упор на пятку передней ноги, спина прямая",
                ],
                [
                    'title' => 'Румынская тяга с гантелями',
                    'sets' => 4,
                    'reps' => '12',
                    'target_muscles' => 'задняя бедра, ягодицы, разгибатели спины',
                    'weight' => '14 кг',
                    'description' => "• Стоя, гантели перед бёдрами\n• Наклоняйся вперёд, отводя таз назад\n• Спина абсолютно прямая - не округлять!\n• Опускайся до середины голени",
                ],
                [
                    'title' => 'Ягодичный мостик (на одной ноге)',
                    'sets' => 3,
                    'reps' => '10 /ногу',
                    'target_muscles' => 'ягодицы, задняя бедра',
                    'weight' => '10 кг',
                    'description' => "• Лёжа на спине, одна нога согнута, вторая в воздухе\n• Гантель на костях таза, придерживай руками\n• Поднимай таз, сжимая ягодицу 3 сек вверху",
                ],
                [
                    'title' => 'Подъём ног в висе на турнике',
                    'sets' => 3,
                    'reps' => '13',
                    'target_muscles' => 'пресс, сгибатели бедра',
                    'weight' => '+4 кг',
                    'description' => "• Виси на турнике, ноги вместе\n• Поднимай ноги до параллели с полом (или согнутые колени к груди)\n• Не раскачивайся!",
                ],
                [
                    'title' => 'Подъём на носки стоя',
                    'sets' => 3,
                    'reps' => '20',
                    'target_muscles' => 'икроножные',
                    'weight' => '10 кг',
                    'description' => "• На носках на краю ступени (пятки свисают)\n• Вниз максимально (2 сек) -> вверх максимально (2 сек)\n• Задержка и сжатие вверху на 1 сек",
                ],
                [
                    'title' => 'Велосипед (скручивания)',
                    'sets' => 3,
                    'reps' => '20 /сторона',
                    'target_muscles' => 'косые мышцы пресса',
                    'weight' => 'Свой вес',
                    'description' => "• Лёжа на спине, руки за головой, скручивай корпус\n• Локоть к противоположному колену медленно (2 сек на повтор)",
                ],
                [
                    'title' => 'Планка',
                    'sets' => 3,
                    'reps' => '45-60 сек',
                    'target_muscles' => 'кор (мышцы стабилизаторы)',
                    'weight' => 'Свой вес',
                    'description' => "• Упор на предплечья и носки, тело - прямая линия\n• Напряги пресс, не прогибай поясницу\n• Дыши ровно",
                ],
            ]);

            // 4. TONUS (sort_order: 3, в ротации программы)
            $tonus = Workout::create([
                'user_id' => $user->id,
                'title' => 'ТОНУС — всё тело (турник + брусья)',
                'sort_order' => 3,
                'in_rotation' => true,
            ]);

            $tonus->exercises()->createMany([
                [
                    'title' => 'Подтягивания',
                    'sets' => 3,
                    'reps' => '10',
                    'target_muscles' => 'широчайшие, бицепс, трапеция, ромбовидные',
                    'weight' => 'Свой вес',
                    'description' => "• Чередуй хваты: день — широкий (ладони от себя), день — обратный узкий (ладони к себе)\n• Тяни локтями вниз и назад\n• Подбородок выше перекладины\n• Опускайся плавно (2–3 сек)\n• Прогрессия: 3×10 → 3×12 → 3×10 с рюкзаком 3–5 кг",
                ],
                [
                    'title' => 'Отжимания на брусьях',
                    'sets' => 3,
                    'reps' => '12',
                    'target_muscles' => 'грудь, трицепс, передние дельты',
                    'weight' => 'Свой вес',
                    'description' => "• Наклон вперёд ~30° = больше грудь\n• Корпус вертикально = больше трицепс\n• Не разгибай локти полностью наверху\n• Опускайся до угла 90° в локтях\n• Прогрессия: 3×12 → 3×15 → замедли темп (3 сек вниз, 3 сек вверх) → с рюкзаком",
                ],
                [
                    'title' => 'Приседания',
                    'sets' => 3,
                    'reps' => '15-20',
                    'target_muscles' => 'квадрицепсы, ягодицы, задняя поверхность бедра',
                    'weight' => 'Свой вес (или гоблет с гантелей)',
                    'description' => "• Стопы на ширине плеч, носки слегка наружу\n• Спина прямая, садись как на стул\n• Колени движутся по направлению носков\n• Опускайся до параллели бёдер с полом\n• Прогрессия: 3×20 → гоблет с 10 кг → болгарские сплит-приседания",
                ],
                [
                    'title' => 'Подъём ног в висе',
                    'sets' => 3,
                    'reps' => '8-12',
                    'target_muscles' => 'пресс, косые мышцы, сгибатели бедра',
                    'weight' => 'Свой вес',
                    'description' => "• Виси на турнике, ноги вместе\n• Поднимай прямые ноги до параллели с полом\n• Сложно — поднимай согнутые колени к груди\n• Не раскачивайся!\n• Прогрессия: колени к груди → прямые ноги → ноги к перекладине",
                ],
                [
                    'title' => 'Выпады',
                    'sets' => 3,
                    'reps' => '10 /ногу',
                    'target_muscles' => 'квадрицепсы, ягодицы, баланс',
                    'weight' => 'Свой вес',
                    'description' => "• Шаг вперёд, опустись до 90° в обоих коленях\n• Колено задней ноги почти касается пола\n• Корпус ровно, взгляд вперёд\n• Толкайся пяткой передней ноги\n• Прогрессия: 3×10 → 3×12 → с гантелями в руках",
                ],
            ]);
        });

        return redirect()->route('workouts.index')->with('success', 'Легендарная программа PUSH/PULL/LEGS успешно установлена!');
    }
}
