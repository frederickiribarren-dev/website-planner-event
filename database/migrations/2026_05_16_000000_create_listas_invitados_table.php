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
        Schema::create('listas_invitados', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('evento_id')->unsigned()->index('idx_listas_invitados_evento');
            $table->string('nombre', 150);
            $table->text('categoria')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate()->useCurrent();
            $table->softDeletes();

            $table->foreign('evento_id', 'fk_listas_invitados_evento')
                ->references('id')
                ->on('eventos')
                ->cascadeOnDelete();
        });

        Schema::table('invitados', function (Blueprint $table) {
            $table->bigInteger('lista_invitado_id')->unsigned()->nullable()->after('evento_id')->index('idx_invitados_lista');

            $table->foreign('lista_invitado_id', 'fk_invitados_lista_invitado')
                ->references('id')
                ->on('listas_invitados')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invitados', function (Blueprint $table) {
            $table->dropForeign(['lista_invitado_id']);
            $table->dropColumn('lista_invitado_id');
        });

        Schema::dropIfExists('listas_invitados');
    }
};
