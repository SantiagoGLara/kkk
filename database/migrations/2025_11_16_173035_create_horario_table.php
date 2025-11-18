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
        Schema::create('horario', function (Blueprint $table) {
            $table->comment('Registro de horarios laborales con firmas digitales');
            $table->increments('id_horario');
            $table->integer('fk_personal')->nullable()->index('idx_horario_personal');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->integer('horas_asignadas');
            $table->enum('estado_firma_personal', ['pendiente', 'firmado'])->nullable()->default('pendiente')->index('idx_horario_estado_personal');
            $table->enum('estado_firma_rh', ['pendiente', 'aprobado', 'rechazado'])->nullable()->default('pendiente')->index('idx_horario_estado_rh');
            $table->timestamp('fecha_firma_personal')->nullable();
            $table->timestamp('fecha_firma_rh')->nullable();
            $table->text('documento_firmado')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent();

            $table->index(['fecha_inicio', 'fecha_fin'], 'idx_horario_fechas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horario');
    }
};
