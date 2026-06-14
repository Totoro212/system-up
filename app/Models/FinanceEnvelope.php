<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinanceEnvelope extends Model
{
    protected $fillable = [
        'user_id',
        'slug',
        'name',
        'percentage',
        'balance',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(FinanceTransaction::class);
    }

    public function getColorClassAttribute()
    {
        return match ($this->slug) {
            'needs' => 'indigo',
            'wants' => 'rose',
            'savings' => 'emerald',
            default => 'slate',
        };
    }
}
