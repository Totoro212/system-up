<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Workout extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'sort_order',
        'in_rotation',
        'last_performed_at',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'in_rotation' => 'boolean',
        'last_performed_at' => 'datetime',
    ];

    /**
     * Scope: сортировка по порядку в очереди.
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order');
    }

    /**
     * Scope: только тренировки в ротации программы.
     */
    public function scopeInRotation(Builder $query): Builder
    {
        return $query->where('in_rotation', true);
    }

    /**
     * Scope: только отдельные тренировки вне программы.
     */
    public function scopeStandalone(Builder $query): Builder
    {
        return $query->where('in_rotation', false);
    }

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
