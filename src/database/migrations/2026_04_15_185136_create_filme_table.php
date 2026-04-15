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
        Schema::create('filme', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 45);
            $table->unsignedSmallInteger('duracao');
            $table->date('data_lancamento');
            $table->string('classificacao', 45);
            $table->text('sinopse');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filme');
    }
};
