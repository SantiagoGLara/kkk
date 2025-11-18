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
        Schema::create('registro_retrasos', function (Blueprint $table) {
            $table->comment('Control de asistencias y retrasos del personal');
            $table->increments('id_retraso');
            $table->integer('fk_personal')->nullable()->index('idx_retrasos_personal');
            $table->date('fecha_retraso')->index('idx_retrasos_fecha');
            $table->time('hora_entrada');
            $table->time('hora_limite');
            $table->integer('minutos_retraso');
            $table->date('periodo_mes')->index('idx_retrasos_periodo');
            $table->boolean('descuento_aplicado')->nullable()->default(false);
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_retrasos');
    }
};
