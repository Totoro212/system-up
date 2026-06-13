<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'event_date',
        'is_annual',
        'icon',
    ];

    protected $casts = [
        'event_date' => 'date',
        'is_annual' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
