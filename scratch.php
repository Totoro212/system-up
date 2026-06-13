<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$txs = App\Models\Transaction::orderBy('created_at', 'desc')->take(5)->get();
foreach ($txs as $tx) {
    echo "{$tx->created_at}: [{$tx->type}] {$tx->amount} {$tx->currency} (Account: {$tx->account_id}, Fund: {$tx->fund_id}) - {$tx->description}\n";
}
