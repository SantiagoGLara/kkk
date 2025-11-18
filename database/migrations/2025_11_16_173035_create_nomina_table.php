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
        Schema::create('nomina', function (Blueprint $table) {
            $table->comment('Cálculo y registro de nóminas mensuales');
            $table->increments('id_nomina');
            $table->timestamp('fecha_generacion')->nullable()->useCurrent()->index('idx_nomina_fecha_gen');
            $table->decimal('salario_total', 12);
            $table->integer('fk_horas_asignadas')->nullable();
            $table->decimal('descuentos', 10)->nullable()->default(0);
            $table->text('recibo')->nullable();
            $table->date('fecha_retrasos')->nullable();
            $table->time('hora_retrasos')->nullable();
            $table->time('tiempo_limite')->nullable();
            $table->integer('fk_personal')->nullable()->index('idx_nomina_personal');
            $table->date('periodo_inicio');
            $table->date('periodo_fin');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent();

            $table->index(['periodo_inicio', 'periodo_fin'], 'idx_nomina_periodo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nomina');
    }
};
