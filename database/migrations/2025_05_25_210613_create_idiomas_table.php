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
        Schema::create('idiomas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('libreria_idiomas_id');
            $table->foreign('libreria_idiomas_id')->references('id')->on('libreria_idiomas');
            $table->unsignedBigInteger('postulante_id');
            $table->foreign('postulante_id')->references('id')->on('postulantes');
            $table->string ('nivel');
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('idiomas');
    }
};
