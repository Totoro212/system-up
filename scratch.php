<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $user = App\Models\User::first();
    App\Models\Account::create([
        'user_id' => $user->id,
        'name' => 'Test Account 2',
        'type' => 'card',
        'currency' => 'UZS',
        'balance' => 0,
        'is_joint' => false,
    ]);
    echo 'Success';
} catch(\Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
