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
        Schema::create('personal', function (Blueprint $table) {
            $table->comment('Tabla principal de empleados vinculada a users');
            $table->increments('id_personal');
            $table->bigInteger('user_id')->index('idx_personal_user');
            $table->string('nombre')->index('idx_personal_nombre');
            $table->integer('tipo_personal')->nullable()->index('idx_personal_tipo');
            $table->string('nivel_academico', 50);
            $table->integer('antiguedad')->nullable()->default(0);
            $table->enum('estado', ['activo', 'pasivo', 'inactivo'])->nullable()->default('activo')->index('idx_personal_estado');
            $table->string('forma_pago', 50)->nullable();
            $table->string('jornada_laboral', 50)->nullable();
            $table->date('fecha_ingreso')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent();

            $table->unique(['user_id'], 'personal_user_id_key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal');
    }
};
