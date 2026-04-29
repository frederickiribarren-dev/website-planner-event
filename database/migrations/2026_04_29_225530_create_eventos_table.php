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
            $table->binary('id')->default('uuid_to_bin(uuid(),1)')->primary();
            $table->binary('usuario_id')->index('idx_eventos_usuario');
            $table->string('slug', 100)->unique('slug');
            $table->string('nombre_bebe', 100)->nullable();
            $table->enum('genero_bebe', ['Niño', 'Niña', 'Sorpresa', 'Múltiple']);
            $table->dateTime('fecha_evento');
            $table->string('ubicacion_nombre')->nullable();
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->longText('mensaje_invitacion')->nullable();
            $table->string('color_tema', 7)->nullable()->default('#60A5FA');
            $table->enum('estado', ['Borrador', 'Publicado', 'Finalizado', 'Cancelado'])->nullable()->default('Borrador');
            $table->string('imagen_portada_url', 500)->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->softDeletes();

            $table->index(['lat', 'lng'], 'idx_eventos_lat_lng');
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
