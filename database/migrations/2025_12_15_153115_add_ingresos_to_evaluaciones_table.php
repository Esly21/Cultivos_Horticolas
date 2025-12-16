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
        Schema::table('evaluaciones_rendimientos', function (Blueprint $table) {
        // Agregamos el campo de ingresos después de la cantidad
        $table->decimal('ingresos_estimados', 10, 2)->default(0)->after('cantidad_cosechada');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evaluaciones_rendimientos', function (Blueprint $table) {
            $table->dropColumn('ingresos_estimados');
        });
    }
};
