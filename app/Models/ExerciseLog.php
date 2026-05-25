<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExerciseLog extends Model
{
    protected $fillable = [
        'exercise_id',
        'user_id',
        'weight_used',
        'performed_at',
    ];

    protected $casts = [
        'weight_used' => 'decimal:1',
        'performed_at' => 'date',
    ];

    /**
     * Получить упражнение, к которому относится запись.
     */
    public function exercise(): BelongsTo
    {
        return $this->belongsTo(Exercise::class);
    }

    /**
     * Получить пользователя, выполнившего упражнение.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
