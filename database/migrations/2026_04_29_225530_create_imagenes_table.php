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
        Schema::create('imagenes', function (Blueprint $table) {
            $table->id()->primary();
            $table->bigInteger('imagenable_id')->unsigned()->index('idx_imagenes_imagenable');
            $table->string('url', 500);
            $table->string('nombre_archivo')->nullable();
            $table->string('alt_text')->nullable();
            $table->string('tipo', 50)->nullable();
            $table->integer('orden')->nullable()->default(0);
            $table->json('metadata')->nullable();
            $table->boolean('is_primary')->nullable()->default(false);
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();

            $table->index(['imagenable_id', 'is_primary'], 'idx_imagenes_primary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imagenes');
    }
};
