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
        Schema::create('habilidads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('libreria_habilidades_id');
            $table->foreign('libreria_habilidades_id')->references('id')->on('libreria_habilidads');
            $table->unsignedBigInteger('postulante_id');
            $table->foreign('postulante_id')->references('id')->on('postulantes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habilidads');
    }
};
