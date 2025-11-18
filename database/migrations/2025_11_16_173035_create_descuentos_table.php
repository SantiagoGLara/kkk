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
        Schema::create('descuentos', function (Blueprint $table) {
            $table->increments('id_descuentos');
            $table->decimal('monto_descuentos', 10);
            $table->integer('numero_retrasos')->nullable()->default(4);
            $table->integer('fk_tiempo_limite')->nullable();
            $table->text('descripcion')->nullable();
            $table->boolean('activo')->nullable()->default(true);
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('descuentos');
    }
};
