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
        Schema::table('invitados', function (Blueprint $table) {
            $table->foreign(['evento_id'], 'invitados_ibfk_1')->references(['id'])->on('eventos')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invitados', function (Blueprint $table) {
            $table->dropForeign('invitados_ibfk_1');
        });
    }
};
