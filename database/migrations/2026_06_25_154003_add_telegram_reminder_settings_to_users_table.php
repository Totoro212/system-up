<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('telegram_reminders_enabled')->default(false);
            $table->integer('telegram_reminders_interval')->default(60); // в минутах
            $table->integer('telegram_reminders_start_hour')->default(9); // 0-23
            $table->integer('telegram_reminders_end_hour')->default(18); // 0-23
            $table->timestamp('telegram_reminders_last_sent_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'telegram_reminders_enabled',
                'telegram_reminders_interval',
                'telegram_reminders_start_hour',
                'telegram_reminders_end_hour',
                'telegram_reminders_last_sent_at'
            ]);
        });
    }
};
