<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('periodos', function (Blueprint $table) {
            $table->id('id_periodo');
            $table->string('nombre'); // Ej: "Crecimiento rápido", "Maduración lenta"
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('periodos');
    }
};