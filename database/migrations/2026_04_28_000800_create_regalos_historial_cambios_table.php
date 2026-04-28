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
        Schema::create('regalos_historial_cambios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->binary('regalo_id')->index('idx_historial_regalo');
            $table->string('campo_modificado', 100)->nullable();
            $table->text('valor_anterior')->nullable();
            $table->text('valor_nuevo')->nullable();
            $table->timestamp('fecha_cambio')->nullable()->useCurrent();
            $table->foreign(['regalo_id'], 'fk_historial_regalo')->references(['id'])->on('regalos')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regalos_historial_cambios');
    }
};
