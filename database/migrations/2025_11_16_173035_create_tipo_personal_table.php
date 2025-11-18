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
        Schema::create('tipo_personal', function (Blueprint $table) {
            $table->increments('id_tipo_personal');
            $table->string('nombre_tipo', 100)->index('idx_tipo_personal_nombre');
            $table->jsonb('caracteristicas_especiales')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent();

            $table->unique(['nombre_tipo'], 'tipo_personal_nombre_tipo_key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_personal');
    }
};
