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
        Schema::create('variables_ambientales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siembra_id')->constrained('siembras')->onDelete('cascade');
            $table->decimal('temperatura', 5, 2)->nullable();
            $table->decimal('humedad', 5, 2)->nullable();
            $table->decimal('luminosidad_lux', 8, 2)->nullable();
            $table->decimal('ph_suelo', 4, 2)->nullable();
            $table->timestamp('fecha_hora');
            $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variables_ambientales');
    }
};
