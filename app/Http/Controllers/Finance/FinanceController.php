<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index()
    {
        $accounts = \App\Models\Account::where('user_id', auth()->id())->get();
        $funds = \App\Models\Fund::where('user_id', auth()->id())->get();
        
        return view('finance.index', compact('accounts', 'funds'));
    }

    public function storeIncome(Request $request)
    {
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string'
        ]);

        $account = \App\Models\Account::findOrFail($request->account_id);
        $amount = $request->amount;

        // 1. Update Physical Account Balance
        $account->balance += $amount;
        $account->save();

        // 2. Distribute to Funds based on target_percentage
        $funds = \App\Models\Fund::where('user_id', auth()->id())
            ->whereNotNull('target_percentage')
            ->where('currency', $account->currency)
            ->get();

        foreach ($funds as $fund) {
            $splitAmount = $amount * ($fund->target_percentage / 100);
            
            $fund->balance += $splitAmount;
            $fund->save();

            // Log Transaction for each split
            \App\Models\Transaction::create([
                'user_id' => auth()->id(),
                'account_id' => $account->id,
                'fund_id' => $fund->id,
                'type' => 'income',
                'amount' => $splitAmount,
                'currency' => $account->currency,
                'description' => 'Распределение дохода: ' . ($request->description ?? 'Зарплата')
            ]);
        }

        return redirect()->back()->with('success', 'Доход успешно добавлен и распределен по правилу 50/40/10!');
    }

    public function storeExpense(Request $request)
    {
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'fund_id' => 'required|exists:funds,id',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string'
        ]);

        $account = \App\Models\Account::findOrFail($request->account_id);
        $fund = \App\Models\Fund::findOrFail($request->fund_id);
        $amount = $request->amount;

        if ($account->currency !== $fund->currency) {
            return redirect()->back()->withErrors(['currency' => 'Валюта счета и фонда должна совпадать.']);
        }

        // Deduct from both
        $account->balance -= $amount;
        $account->save();

        $fund->balance -= $amount;
        $fund->save();

        \App\Models\Transaction::create([
            'user_id' => auth()->id(),
            'account_id' => $account->id,
            'fund_id' => $fund->id,
            'type' => 'expense',
            'amount' => $amount,
            'currency' => $account->currency,
            'description' => $request->description
        ]);

        return redirect()->back()->with('success', 'Расход записан!');
    }

    public function transfer(Request $request)
    {
        $request->validate([
            'from_account_id' => 'required|exists:accounts,id|different:to_account_id',
            'to_account_id' => 'required|exists:accounts,id',
            'amount' => 'required|numeric|min:0.01',
        ]);

        $fromAccount = \App\Models\Account::findOrFail($request->from_account_id);
        $toAccount = \App\Models\Account::findOrFail($request->to_account_id);
        $amount = $request->amount;

        if ($fromAccount->currency !== $toAccount->currency) {
            return redirect()->back()->withErrors(['currency' => 'Конвертация пока не поддерживается, выберите счета с одинаковой валютой.']);
        }

        $fromAccount->balance -= $amount;
        $fromAccount->save();

        $toAccount->balance += $amount;
        $toAccount->save();

        \App\Models\Transaction::create([
            'user_id' => auth()->id(),
            'account_id' => $fromAccount->id,
            'destination_account_id' => $toAccount->id,
            'type' => 'transfer',
            'amount' => $amount,
            'currency' => $fromAccount->currency,
            'description' => 'Перевод между своими счетами'
        ]);

        return redirect()->back()->with('success', 'Перевод выполнен успешно!');
    }
}
