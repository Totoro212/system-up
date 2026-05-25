<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Workout extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'day_of_week',
        'last_performed_at',
    ];

    protected $casts = [
        'day_of_week' => 'array',
        'last_performed_at' => 'datetime',
    ];

    /**
     * Получить пользователя, которому принадлежит тренировка.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Получить список упражнений тренировки.
     */
    public function exercises(): HasMany
    {
        return $this->hasMany(Exercise::class);
    }
}
