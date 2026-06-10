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
        Schema::create('auditoria_eventos', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('evento_id')->unsigned()->index('idx_auditoria_evento');
            $table->enum('entidad_tipo', ['EVENTO', 'INVITADO', 'REGALO', 'RESERVA'])->nullable();
            $table->bigInteger('entidad_id')->unsigned()->nullable();
            $table->enum('accion', ['CREAR', 'ACTUALIZAR', 'ELIMINAR', 'CONFIRMACION'])->nullable();
            $table->json('detalle_cambio')->nullable();
            $table->bigInteger('usuario_operador')->unsigned()->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();

            $table->index(['entidad_tipo', 'entidad_id'], 'idx_auditoria_entidad');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditoria_eventos');
    }
};
