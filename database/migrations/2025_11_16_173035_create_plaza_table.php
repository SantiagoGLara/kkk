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
        Schema::create('plaza', function (Blueprint $table) {
            $table->increments('id_plaza');
            $table->string('descripcion');
            $table->integer('horas_max');
            $table->string('tipo_persona_aplicable', 50)->nullable();
            $table->boolean('activa')->nullable()->default(true)->index('idx_plaza_activa');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plaza');
    }
};
