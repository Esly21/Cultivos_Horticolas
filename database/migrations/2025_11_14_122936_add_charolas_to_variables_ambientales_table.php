<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('variables_ambientales', function (Blueprint $table) {
            // Añade las 4 charolas 
            $table->decimal('humedad_charola1', 8, 2)->nullable()->after('ph_suelo');
            $table->decimal('humedad_charola2', 8, 2)->nullable()->after('humedad_charola1');
            $table->decimal('humedad_charola3', 8, 2)->nullable()->after('humedad_charola2');
            $table->decimal('humedad_charola4', 8, 2)->nullable()->after('humedad_charola3');

            // Añade los actuadores 
            $table->boolean('ventilador_activo')->default(false)->after('humedad_charola4');
            $table->boolean('riego_activo')->default(false)->after('ventilador_activo');
        });
    }

    public function down(): void
    {
        Schema::table('variables_ambientales', function (Blueprint $table) {
            $table->dropColumn([
                'humedad_charola1', 'humedad_charola2', 'humedad_charola3', 'humedad_charola4',
                'ventilador_activo', 'riego_activo'
            ]);
        });
    }
};