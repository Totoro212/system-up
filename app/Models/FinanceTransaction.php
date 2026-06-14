<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinanceTransaction extends Model
{
    protected $fillable = [
        'user_id',
        'finance_envelope_id',
        'type',
        'amount',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function envelope()
    {
        return $this->belongsTo(FinanceEnvelope::class, 'finance_envelope_id');
    }
}
