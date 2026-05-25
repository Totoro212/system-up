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
        Schema::create('stoic_quotes', function (Blueprint $table) {
            $table->id();
            $table->text('text');
            $table->string('author')->nullable();
            $table->string('source')->nullable();
            $table->text('practice')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stoic_quotes');
    }
};
