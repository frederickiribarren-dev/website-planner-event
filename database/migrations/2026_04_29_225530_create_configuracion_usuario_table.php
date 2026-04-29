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
        Schema::create('configuracion_usuario', function (Blueprint $table) {
            $table->binary('usuario_id')->primary();
            $table->boolean('notificaciones_push')->nullable()->default(true);
            $table->boolean('notificaciones_email')->nullable()->default(true);
            $table->char('idioma', 5)->nullable()->default('es-CL');
            $table->string('timezone', 50)->nullable()->default('America/Santiago');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuracion_usuario');
    }
};
