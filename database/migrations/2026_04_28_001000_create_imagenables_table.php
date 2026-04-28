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
            $table->binary('id')->default('uuid_to_bin(uuid(),1)')->primary();
            $table->binary('usuario_id')->nullable()->index('idx_imagenables_usuario');
            $table->binary('evento_id')->nullable()->index('idx_imagenables_evento');
            $table->binary('regalo_id')->nullable()->index('idx_imagenables_regalo');
            $table->string('descripcion')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
            $table->foreign(['evento_id'], 'fk_imagenables_evento')->references(['id'])->on('eventos')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['regalo_id'], 'fk_imagenables_regalo')->references(['id'])->on('regalos')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['usuario_id'], 'fk_imagenables_usuario')->references(['id'])->on('usuarios')->onUpdate('no action')->onDelete('cascade');
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
