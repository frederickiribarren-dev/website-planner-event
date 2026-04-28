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
            $table->binary('id')->default('uuid_to_bin(uuid(),1)')->primary();
            $table->binary('evento_id')->index('idx_regalos_evento');
            $table->binary('categoria_id')->nullable()->index('idx_regalos_categoria');
            $table->string('nombre_regalo', 200);
            $table->text('descripcion')->nullable();
            $table->enum('prioridad', ['Baja', 'Media', 'Alta', 'Urgente'])->nullable()->default('Media');
            $table->string('link_referencia', 500)->nullable();
            $table->decimal('precio_estimado', 12)->nullable();
            $table->integer('cantidad_solicitada')->nullable()->default(1);
            $table->integer('cantidad_completada')->nullable()->default(0);
            $table->enum('estado', ['Disponible', 'Reservado_Parcial', 'Completado'])->nullable()->default('Disponible');
            $table->string('imagen_portada_url', 500)->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
            $table->softDeletes();
            $table->foreign(['categoria_id'], 'fk_regalos_categoria')->references(['id'])->on('categorias_regalos')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['evento_id'], 'fk_regalos_evento')->references(['id'])->on('eventos')->onUpdate('no action')->onDelete('cascade');
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
