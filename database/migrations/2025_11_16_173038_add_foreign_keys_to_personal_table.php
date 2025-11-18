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
        Schema::table('personal', function (Blueprint $table) {
            $table->foreign(['tipo_personal'], 'personal_tipo_personal_fkey')->references(['id_tipo_personal'])->on('tipo_personal')->onUpdate('no action')->onDelete('restrict');
            $table->foreign(['user_id'], 'personal_user_id_fkey')->references(['id'])->on('users')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personal', function (Blueprint $table) {
            $table->dropForeign('personal_tipo_personal_fkey');
            $table->dropForeign('personal_user_id_fkey');
        });
    }
};
