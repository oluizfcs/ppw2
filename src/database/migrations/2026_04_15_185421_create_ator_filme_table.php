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
        Schema::create('ator_filme', function (Blueprint $table) {
            $table->id();
            $table->string('papel', 45);
            $table->foreignId('ator_id')->constrained('ator');
            $table->foreignId('filme_id')->constrained('filme');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ator_filme');
    }
};
