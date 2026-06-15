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
        Schema::create('imagenables', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('usuario_id')->unsigned()->nullable()->index('idx_imagenables_usuario');
            $table->bigInteger('evento_id')->unsigned()->nullable()->index('idx_imagenables_evento');
            $table->bigInteger('regalo_id')->unsigned()->nullable()->index('idx_imagenables_regalo');
            $table->string('descripcion')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imagenables');
    }
};
