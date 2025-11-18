<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Cambiar el default de 'empleado' a 'rh_admin' para el registro público
        DB::statement("ALTER TABLE users ALTER COLUMN role SET DEFAULT 'rh_admin'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Volver al default anterior
        DB::statement("ALTER TABLE users ALTER COLUMN role SET DEFAULT 'empleado'");
    }
};
