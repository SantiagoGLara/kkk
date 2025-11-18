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
        Schema::table('tabulador_salarial', function (Blueprint $table) {
            $table->foreign(['fk_tipo_personal'], 'tabulador_salarial_fk_tipo_personal_fkey')->references(['id_tipo_personal'])->on('tipo_personal')->onUpdate('no action')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tabulador_salarial', function (Blueprint $table) {
            $table->dropForeign('tabulador_salarial_fk_tipo_personal_fkey');
        });
    }
};
