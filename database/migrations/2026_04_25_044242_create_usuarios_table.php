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
            $table->binary('id')->default('uuid_to_bin(uuid())')->primary();
            $table->string('nombre', 100);
            $table->string('email')->unique('email');
            $table->string('password_hash');
            $table->string('telefono', 20)->nullable();
            $table->timestamp('fecha_registro')->nullable()->useCurrent();
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
