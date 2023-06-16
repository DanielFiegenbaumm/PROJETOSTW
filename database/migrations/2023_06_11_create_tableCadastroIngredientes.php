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
        Schema::create('ingrediente', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('receita_id');
            $table->string('ordem')->nullable();
            $table->string('codigo')->nullable();
            $table->string('descricao')->nullable();
            $table->string('previstoKG')->nullable();

            $table->foreign('receita_id')->references('id')->on('receita');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingrediente');
    }
};
