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
        Schema::create('fechas_especiales', function (Blueprint $table) {
            $table->increments('id_fechas_especiales');
            $table->date('fechas')->unique('fechas_especiales_fechas_key');
            $table->string('tipo', 50);
            $table->text('descripcion')->nullable();
            $table->boolean('sin_checada')->nullable()->default(true);
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent();

            $table->index(['fechas'], 'idx_fechas_especiales_fecha');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fechas_especiales');
    }
};
