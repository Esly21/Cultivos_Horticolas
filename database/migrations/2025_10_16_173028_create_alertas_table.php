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
        Schema::create('alertas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siembra_id')->nullable()->constrained('siembras')->onDelete('cascade');
            $table->string('mensaje');
            $table->enum('severidad', ['info', 'warning', 'critical']);
            $table->timestamp('fecha');
            $table->boolean('leida')->default(false);
            $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alertas');
    }
};
