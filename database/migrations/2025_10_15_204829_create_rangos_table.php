<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('rangos', function (Blueprint $table) {
            $table->id('id_rango');
            $table->string('nombre'); // Ej: "Rango de temperatura A", "Rango de pH B"
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('rangos');
    }
};