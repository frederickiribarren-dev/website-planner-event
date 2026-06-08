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
        Schema::create('listas_regalos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->index('idx_listas_regalos_user');
            $table->bigInteger('evento_id')->unsigned()->nullable()->index('idx_listas_regalos_evento');
            $table->string('nombre', 150);
            $table->text('descripcion')->nullable();
            $table->enum('estado', ['Borrador', 'Activa', 'Completada'])->nullable()->default('Borrador');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate()->useCurrent();
            $table->softDeletes();

            $table->foreign('user_id', 'fk_listas_regalos_user')
                ->references('id')
                ->on('usuarios')
                ->cascadeOnDelete();

            $table->foreign('evento_id', 'fk_listas_regalos_evento')
                ->references('id')
                ->on('eventos')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listas_regalos');
    }
};
