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
        Schema::table('horario', function (Blueprint $table) {
            $table->foreign(['fk_personal'], 'horario_fk_personal_fkey')->references(['id_personal'])->on('personal')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('horario', function (Blueprint $table) {
            $table->dropForeign('horario_fk_personal_fkey');
        });
    }
};
