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
        Schema::create('cosechas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->foreignId('siembra_id')->constrained('siembras')->onDelete('cascade');
        $table->foreignId('tipo_suelo_id')->constrained('tipos_suelos'); // Tu nuevo catálogo
        
        $table->date('fecha_cosecha_real');
        $table->integer('dias_transcurridos'); // Tiempo siembra a cosecha
        $table->decimal('cantidad_cosechada', 10, 2); // Cuánto salió
        $table->string('unidad_medida')->default('kg'); // Kg, Ton, etc.
        $table->foreignId('calidad_id')->constrained('calidad_cosechas');
        $table->string('tamano_promedio'); // Ej: Pequeño, Mediano, Grande
        $table->string('tipo_cosecha'); // Manual, Mecánica
        $table->text('observaciones')->nullable();
        
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cosechas');
    }
};
