<?php

namespace App\Http\Controllers\Terminal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TerminalController extends Controller
{
    /**
     * Отобразить рыночный терминал.
     */
    public function index()
    {
        return view('terminal.index');
    }
}
