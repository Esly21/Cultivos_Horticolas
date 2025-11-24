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
        Schema::create('cultivos', function (Blueprint $table) {
            $table->id(); // Coincide con tu nombre de columna
            $table->string('nombre_cientifico', 150)->unique();
            $table->string('nombre_comun', 150);
            $table->text('descripcion')->nullable();
            $table->string('imagen', 255)->nullable();

            // --- CAMPOS QUE FALTABAN O ESTABAN INCORRECTOS ---
           $table->foreignId('id_tipo_cultivo')->constrained('tipos_cultivo', 'id');
            $table->foreignId('id_tipo_siembra')->nullable()->constrained('tipos_siembra', 'id_tipo_siembra');
            $table->foreignId('id_periodo')->nullable()->constrained('periodos', 'id_periodo');
            $table->foreignId('id_rango')->nullable()->constrained('rangos', 'id_rango');
            $table->foreignId('id_dimension')->nullable()->constrained('dimensiones', 'id_dimension');// Coincide con el tipo de la imagen
            $table->integer('tiempo_riego')->nullable();
            $table->integer('tiempo_cosecha')->nullable();
            $table->decimal('profundidad_semilla', 6, 2)->nullable(); // Precisión corregida
            $table->boolean('iluminacion')->default(false); // tinyint(1) es un booleano
            $table->decimal('costo', 12, 2)->nullable(); // Precisión corregida
            $table->string('sector', 100)->nullable();
            $table->string('parcela', 100)->nullable();
            $table->integer('cantidad_de_plantas')->nullable();

            // --- FIN DE CAMPOS ---

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cultivos');
    }
};