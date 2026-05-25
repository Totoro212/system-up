<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exercise extends Model
{
    protected $fillable = [
        'workout_id',
        'title',
        'sets',
        'reps',
        'target_muscles',
        'weight',
        'description',
    ];

    /**
     * Получить тренировку, к которой относится упражнение.
     */
    public function workout(): BelongsTo
    {
        return $this->belongsTo(Workout::class);
    }

    /**
     * Получить журнал прогрессии весов для данного упражнения.
     */
    public function logs(): HasMany
    {
        return $this->hasMany(ExerciseLog::class);
    }
}
