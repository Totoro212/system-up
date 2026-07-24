<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FinanceEnvelope;
use App\Models\FinanceTransaction;

class FinanceController extends Controller
{
    public function storeIncome(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $amount = (int) $validated['amount'];
        $userId = auth()->id();

        $envelopes = FinanceEnvelope::where('user_id', $userId)->get();

        $remaining = $amount;
        $lastIndex = $envelopes->count() - 1;

        foreach ($envelopes as $index => $envelope) {
            if ($envelope->percentage <= 0) continue;
            
            // Последний конверт получает остаток, чтобы не терять копейки
            $share = ($index === $lastIndex)
                ? $remaining
                : (int) ($amount * ($envelope->percentage / 100));
            
            $remaining -= $share;
            
            FinanceTransaction::create([
                'user_id' => $userId,
                'finance_envelope_id' => $envelope->id,
                'type' => 'income',
                'amount' => $share,
                'description' => 'Пополнение'
            ]);

            if ($envelope->slug === 'savings') {
                $envelope->increment('balance', $share);
            }
        }

        return back()->with('success', 'Доход успешно распределен! Переведите сбережения на вклад.');
    }

    public function resetBudget()
    {
        FinanceTransaction::create([
            'user_id' => auth()->id(),
            'finance_envelope_id' => null,
            'type' => 'income',
            'amount' => 0,
            'description' => 'budget_reset'
        ]);

        return back()->with('success', 'Бюджеты успешно сброшены!');
    }
}

