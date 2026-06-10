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
        Schema::create('regalos_reservas', function (Blueprint $table) {
            $table->id()->primary();
            $table->bigInteger('regalo_id')->unsigned()->index('idx_reservas_regalo');
            $table->bigInteger('invitado_id')->unsigned()->index('idx_reservas_invitado');
            $table->integer('cantidad_reservada')->nullable()->default(1);
            $table->string('comprobante_url', 500)->nullable();
            $table->timestamp('fecha_reserva')->nullable()->useCurrent();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();

            $table->unique(['regalo_id', 'invitado_id'], 'regalo_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regalos_reservas');
    }
};
