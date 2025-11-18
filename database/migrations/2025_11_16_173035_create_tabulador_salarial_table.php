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
        Schema::create('tabulador_salarial', function (Blueprint $table) {
            $table->comment('Tabulador de salarios por nivel académico y tipo');
            $table->increments('id_tabulador');
            $table->string('fk_nivel_academico', 50)->index('idx_tabulador_nivel');
            $table->integer('fk_tipo_personal')->nullable()->index('idx_tabulador_tipo');
            $table->decimal('salario_base_porhora', 10);
            $table->date('vigencia_inicio');
            $table->date('vigencia_fin')->nullable();
            $table->boolean('activo')->nullable()->default(true)->index('idx_tabulador_activo');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabulador_salarial');
    }
};
