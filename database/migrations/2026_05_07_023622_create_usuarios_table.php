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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->binary('id')->default('uuid_to_bin(uuid(),1)')->primary();
            $table->string('nombre', 100);
            $table->string('email')->unique('email');
            $table->string('password_hash');
            $table->string('telefono', 20)->nullable();
            $table->enum('estado', ['Activo', 'Suspendido', 'Eliminado'])->nullable()->default('Activo');
            $table->string('imagen_portada_url', 500)->nullable();
            $table->dateTime('ultimo_login')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->softDeletes();

            $table->index(['email'], 'idx_usuarios_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
