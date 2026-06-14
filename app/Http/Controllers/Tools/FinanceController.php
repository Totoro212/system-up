<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FinanceEnvelope;
use App\Models\FinanceTransaction;
use App\Models\FinanceGoal;

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

        foreach ($envelopes as $envelope) {
            if ($envelope->percentage <= 0) continue;
            
            $share = (int) ($amount * ($envelope->percentage / 100));
            
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

    public function adjustCapital(Request $request)
    {
        $validated = $request->validate([
            'operation' => 'required|in:add,sub',
            'amount' => 'required|numeric|min:1',
        ]);

        $userId = auth()->id();
        $savingsEnvelope = FinanceEnvelope::where('user_id', $userId)->where('slug', 'savings')->firstOrFail();

        if ($validated['operation'] === 'sub' && $savingsEnvelope->balance < $validated['amount']) {
            return back()->withErrors(['amount' => 'Недостаточно средств в капитале.']);
        }

        $type = $validated['operation'] === 'add' ? 'income' : 'expense';
        $desc = $validated['operation'] === 'add' ? 'Проценты / Кешбэк' : 'Изъятие из капитала';

        FinanceTransaction::create([
            'user_id' => $userId,
            'finance_envelope_id' => $savingsEnvelope->id,
            'type' => $type,
            'amount' => $validated['amount'],
            'description' => $desc
        ]);

        if ($validated['operation'] === 'add') {
            $savingsEnvelope->increment('balance', $validated['amount']);
            $msg = 'Проценты успешно добавлены к капиталу!';
        } else {
            $savingsEnvelope->decrement('balance', $validated['amount']);
            $msg = 'Средства успешно изъяты из капитала!';
        }

        return back()->with('success', $msg);
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

    public function storeGoal(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:1',
        ]);

        FinanceGoal::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'target_amount' => $validated['target_amount'],
            'current_amount' => 0,
        ]);

        return back()->with('success', 'Цель успешно добавлена!');
    }

    public function addGoalFunds(Request $request, $id)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $goal = FinanceGoal::where('user_id', auth()->id())->findOrFail($id);
        $goal->increment('current_amount', $validated['amount']);

        return back()->with('success', 'Средства добавлены к цели!');
    }
}
