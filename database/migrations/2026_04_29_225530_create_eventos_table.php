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
           
            $table->id();
            $table->bigInteger('usuario_id')->unsigned()->index('idx_eventos_usuario');
            $table->string('slug', 100)->unique('slug');
            $table->string('nombre_bebe', 100)->nullable();
            $table->enum('genero_bebe', ['Niño', 'Niña', 'Sorpresa', 'Múltiple']);
            $table->dateTime('fecha_evento');
            $table->string('ubicacion_nombre')->nullable();

            $table->longText('mensaje_invitacion')->nullable();
            $table->string('color_tema', 7)->nullable()->default('#60A5FA');
            $table->enum('estado', ['Borrador', 'Publicado', 'Finalizado', 'Cancelado'])->nullable()->default('Borrador');
            $table->string('imagen_portada_url', 500)->nullable();
            $table->bigInteger('lista_invitado_id')->unsigned()->nullable()->index('idx_eventos_lista_invitado');
            $table->bigInteger('lista_regalos_id')->unsigned()->nullable()->index('idx_eventos_lista_regalos');
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
        Schema::dropIfExists('eventos');
    }
};
