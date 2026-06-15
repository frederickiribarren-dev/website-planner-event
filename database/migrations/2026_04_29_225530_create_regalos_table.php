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
            $table->id();
            $table->bigInteger('evento_id')->unsigned()->nullable()->index('idx_regalos_evento');
            $table->bigInteger('categoria_id')->unsigned()->nullable()->index('idx_regalos_categoria');
            $table->bigInteger('lista_regalos_id')->unsigned()->nullable()->index('idx_regalos_lista');
            $table->string('nombre_regalo', 200);
            $table->longText('descripcion')->nullable();
            $table->enum('prioridad', ['Baja', 'Media', 'Alta', 'Urgente'])->nullable()->default('Media');
            $table->string('link_referencia', 500)->nullable();
            $table->string('link_referencia_2', 500)->nullable();
            $table->string('link_referencia_3', 500)->nullable();
            $table->decimal('precio_estimado', 12)->nullable();
            $table->integer('cantidad_solicitada')->nullable()->default(1);
            $table->integer('cantidad_completada')->nullable()->default(0);
            $table->enum('estado', ['Disponible', 'Reservado_Parcial', 'Completado'])->nullable()->default('Disponible');
            $table->string('imagen_portada_url', 500)->nullable();
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
        Schema::dropIfExists('regalos');
    }
};
