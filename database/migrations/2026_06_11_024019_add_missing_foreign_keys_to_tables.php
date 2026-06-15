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
        Schema::table('eventos', function (Blueprint $table) {
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
            // Nota: lista_invitado_id y lista_regalos_id se asumen que referencian a esas tablas.
            $table->foreign('lista_invitado_id')->references('id')->on('listas_invitados')->onDelete('set null');
            $table->foreign('lista_regalos_id')->references('id')->on('listas_regalos')->onDelete('set null');
        });

        Schema::table('configuracion_usuario', function (Blueprint $table) {
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
        });

        Schema::table('invitados', function (Blueprint $table) {
            $table->foreign('evento_id')->references('id')->on('eventos')->onDelete('cascade');
            // lista_invitado_id ya está cubierto en la migración de listas_invitados
        });

        Schema::table('regalos', function (Blueprint $table) {
            $table->foreign('evento_id')->references('id')->on('eventos')->onDelete('cascade');
            $table->foreign('categoria_id')->references('id')->on('categorias_regalos')->onDelete('set null');
            $table->foreign('lista_regalos_id')->references('id')->on('listas_regalos')->onDelete('set null');
        });

        Schema::table('auditoria_eventos', function (Blueprint $table) {
            $table->foreign('evento_id')->references('id')->on('eventos')->onDelete('cascade');
        });

        Schema::table('regalos_historial_cambios', function (Blueprint $table) {
            $table->foreign('regalo_id')->references('id')->on('regalos')->onDelete('cascade');
        });

        Schema::table('regalos_reservas', function (Blueprint $table) {
            $table->foreign('regalo_id')->references('id')->on('regalos')->onDelete('cascade');
            $table->foreign('invitado_id')->references('id')->on('invitados')->onDelete('cascade');
        });

        Schema::table('imagenables', function (Blueprint $table) {
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
            $table->foreign('evento_id')->references('id')->on('eventos')->onDelete('cascade');
            $table->foreign('regalo_id')->references('id')->on('regalos')->onDelete('cascade');
        });

        Schema::table('imagenes', function (Blueprint $table) {
            $table->foreign('imagenable_id')->references('id')->on('imagenables')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('eventos', function (Blueprint $table) {
            $table->dropForeign(['usuario_id']);
            $table->dropForeign(['lista_invitado_id']);
            $table->dropForeign(['lista_regalos_id']);
        });

        Schema::table('configuracion_usuario', function (Blueprint $table) {
            $table->dropForeign(['usuario_id']);
        });

        Schema::table('invitados', function (Blueprint $table) {
            $table->dropForeign(['evento_id']);
        });

        Schema::table('regalos', function (Blueprint $table) {
            $table->dropForeign(['evento_id']);
            $table->dropForeign(['categoria_id']);
            $table->dropForeign(['lista_regalos_id']);
        });

        Schema::table('auditoria_eventos', function (Blueprint $table) {
            $table->dropForeign(['evento_id']);
        });

        Schema::table('regalos_historial_cambios', function (Blueprint $table) {
            $table->dropForeign(['regalo_id']);
        });

        Schema::table('regalos_reservas', function (Blueprint $table) {
            $table->dropForeign(['regalo_id']);
            $table->dropForeign(['invitado_id']);
        });

        Schema::table('imagenables', function (Blueprint $table) {
            $table->dropForeign(['usuario_id']);
            $table->dropForeign(['evento_id']);
            $table->dropForeign(['regalo_id']);
        });

        Schema::table('imagenes', function (Blueprint $table) {
            $table->dropForeign(['imagenable_id']);
        });
    }
};
