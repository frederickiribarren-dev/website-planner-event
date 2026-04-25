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
        Schema::create('regalos', function (Blueprint $table) {
            $table->binary('id')->default('uuid_to_bin(uuid())')->primary();
            $table->binary('evento_id')->index('evento_id');
            $table->string('nombre_regalo', 200);
            $table->text('descripcion')->nullable();
            $table->string('link_referencia', 500)->nullable();
            $table->binary('reservado_por_invitado_id')->nullable()->index('reservado_por_invitado_id');
            $table->enum('tipo_regalo', ['Sugerido', 'Externo'])->nullable()->default('Sugerido');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regalos');
    }
};
