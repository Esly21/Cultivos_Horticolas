<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('dimensiones', function (Blueprint $table) {
            $table->id('id_dimension');
            $table->decimal('altura', 8, 2);
            $table->decimal('ancho', 8, 2);
            $table->decimal('largo', 8, 2);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('dimensiones');
    }
};