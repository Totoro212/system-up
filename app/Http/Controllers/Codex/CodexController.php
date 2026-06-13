<?php

namespace App\Http\Controllers\Codex;

use App\Http\Controllers\Controller;
use App\Models\StoicQuote;

class CodexController extends Controller
{
    public function index()
    {
        $count = StoicQuote::query()->count();
        $stoicQuote = null;
        if ($count > 0) {
            $dayOfYear = now()->dayOfYear;
            $offset = $dayOfYear % $count;
            $stoicQuote = StoicQuote::query()->skip($offset)->first();
        }

        return view('codex.index', compact('stoicQuote'));
    }
}
