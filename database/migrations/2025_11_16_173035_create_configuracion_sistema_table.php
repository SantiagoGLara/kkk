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
        Schema::create('configuracion_sistema', function (Blueprint $table) {
            $table->increments('id_config');
            $table->string('clave', 100)->unique('configuracion_sistema_clave_key');
            $table->text('valor');
            $table->string('tipo_dato', 20)->nullable()->default('string');
            $table->text('descripcion')->nullable();
            $table->string('categoria', 50)->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuracion_sistema');
    }
};
