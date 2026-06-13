<?php

namespace App\Http\Controllers\Quest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quest;
use App\Models\StoicQuote;
use App\Models\Event;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Отобразить список квестов пользователя на сегодня.
     */
    public function index()
    {
        $quests = Quest::where('user_id', auth()->id())
            ->withExists(['log' => function ($query) {
                $query->whereDate('created_at', today())
                      ->where('user_id', auth()->id());
            }])->get();
            
        // Финансы
        $accounts = \App\Models\Account::where('user_id', auth()->id())->get();
        $funds = \App\Models\Fund::where('user_id', auth()->id())->get();

        return view('quest.index', [
            'quests' => $quests,
            'accounts' => $accounts,
            'funds' => $funds
        ]);
    }

    /**
     * Создать новую стоическую цитату.
     */
    public function storeStoicQuote(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:5000',
            'practice' => 'nullable|string|max:5000',
        ]);

        StoicQuote::create([
            'text' => $request->text,
            'practice' => $request->practice,
        ]);

        return redirect()->back()->with('success', 'Стоическая цитата успешно добавлена в свитки!');
    }
}
