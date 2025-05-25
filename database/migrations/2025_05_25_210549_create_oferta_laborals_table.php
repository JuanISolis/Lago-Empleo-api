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
        Schema::create('oferta_laborars', function (Blueprint $table) {
            $table->id();
            $table->string('titulo_ofertalaboral');
            $table->text('descripcion');
            $table->string('ubicacion');
            $table->string('jornada');
            $table->date('fecha_inicio');
            $table->decimal('pago')->nullable();
            $table->integer('num_trabajadores');
            $table->string('experiencia');
            $table->string('nivel_estudio');
            $table->integer('edad');
            $table->boolean('estado');
            $table->timestamps();

            $table->unsignedBigInteger('imformacion_empresa_id');
            $table->foreign('imformacion_empresa_id')->references('id')->on('informacio_empresas');
        });

       
    
                
          
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oferta_laborars');
    }
};
