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
            $table->id();
            $table->bigInteger('evento_id')->unsigned()->nullable()->index('idx_invitados_evento');
            $table->string('nombre', 100);
            $table->string('email')->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('token_acceso', 64)->nullable()->unique('token_acceso');
            $table->enum('estado_invitacion', ['Pendiente', 'Enviado', 'Leído', 'Error'])->nullable()->default('Pendiente');
            $table->enum('estado_asistencia', ['Sin responder', 'Confirmado', 'Rechazado'])->nullable()->default('Sin responder');
            $table->integer('cantidad_adultos')->nullable()->default(1);
            $table->integer('cantidad_ninos')->nullable()->default(0);
            $table->longText('alergias_notas')->nullable();
            $table->dateTime('fecha_confirmacion')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->softDeletes();
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
