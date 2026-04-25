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
        Schema::create('invitados', function (Blueprint $table) {
            $table->binary('id')->default('uuid_to_bin(uuid())')->primary();
            $table->binary('evento_id')->index('evento_id');
            $table->string('nombre', 100);
            $table->string('email')->nullable();
            $table->string('telefono', 20)->nullable();
            $table->enum('estado_invitacion', ['Pendiente', 'Enviado', 'Error'])->nullable()->default('Pendiente');
            $table->enum('estado_asistencia', ['Sin responder', 'Confirmado', 'Rechazado'])->nullable()->default('Sin responder');
            $table->integer('cantidad_asistentes')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitados');
    }
};
