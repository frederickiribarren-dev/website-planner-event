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
        Schema::table('regalos', function (Blueprint $table) {
            $table->foreign(['evento_id'], 'regalos_ibfk_1')->references(['id'])->on('eventos')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['reservado_por_invitado_id'], 'regalos_ibfk_2')->references(['id'])->on('invitados')->onUpdate('no action')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('regalos', function (Blueprint $table) {
            $table->dropForeign('regalos_ibfk_1');
            $table->dropForeign('regalos_ibfk_2');
        });
    }
};
