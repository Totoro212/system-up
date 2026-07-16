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
        Schema::dropIfExists('finance_goals');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('finance_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->bigInteger('target_amount')->unsigned();
            $table->bigInteger('current_amount')->unsigned()->default(0);
            $table->timestamps();
        });
    }
};
