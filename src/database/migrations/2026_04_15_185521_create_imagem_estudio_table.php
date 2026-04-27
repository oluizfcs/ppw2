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
        Schema::create('imagem_estudio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('imagem_id')->constrained('imagem');
            $table->foreignId('estudio_id')->constrained('estudio');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imagem_estudio');
    }
};
