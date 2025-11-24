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
        Schema::create('bitacoras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siembra_id')->constrained('siembras')->onDelete('cascade');
            $table->date('fecha_seguimiento');
            $table->string('crecimiento')->nullable();
            $table->text('observaciones');
            $table->decimal('temperatura_actual', 5, 2)->nullable();
            $table->decimal('humedad_actual', 5, 2)->nullable();
            $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bitacoras');
    }
};
