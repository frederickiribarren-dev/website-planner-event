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
        Schema::create('eventos', function (Blueprint $table) {
            $table->binary('id')->default('uuid_to_bin(uuid())')->primary();
            $table->binary('usuario_id')->index('usuario_id');
            $table->string('nombre_bebe', 100)->nullable();
            $table->enum('genero_bebe', ['Niño', 'Niña', 'Sorpresa']);
            $table->date('fecha_evento');
            $table->time('hora_evento');
            $table->string('ubicacion', 500)->nullable();
            $table->string('mensaje_invitacion', 1000)->nullable();
            $table->enum('color_tema', ['Azul', 'Rosa', 'Verde', 'Amarillo', 'Morado', 'Naranja', 'Gris', 'Blanco'])->nullable();
            $table->enum('estado', ['Borrador', 'Activo', 'Finalizado'])->nullable()->default('Borrador');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
