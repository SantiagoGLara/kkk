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
        Schema::table('registro_retrasos', function (Blueprint $table) {
            $table->foreign(['fk_personal'], 'registro_retrasos_fk_personal_fkey')->references(['id_personal'])->on('personal')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registro_retrasos', function (Blueprint $table) {
            $table->dropForeign('registro_retrasos_fk_personal_fkey');
        });
    }
};
