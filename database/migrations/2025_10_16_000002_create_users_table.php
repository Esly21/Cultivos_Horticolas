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
        Schema::create('users', function (Blueprint $table) {
            // Columna estándar de Laravel para el ID
            $table->id();

            // Columna estándar de Laravel para el nombre
            $table->string('name'); // Corresponde a 'nombre' en tu imagen

            // --- CAMPOS PERSONALIZADOS DE TU IMAGEN ---
            $table->string('apellido_paterno');
            $table->string('apellido_materno');
            $table->foreignId('id_tipo_usuario')->constrained('tipos_usuario');
            // --- FIN DE CAMPOS PERSONALIZADOS ---

            // Columnas estándar de Laravel para autenticación
            $table->string('email')->unique(); // Corresponde a 'correo'
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password'); // Corresponde a 'contrasenia'
            $table->rememberToken();

            // Columnas estándar de Laravel para fechas de creación/actualización
            $table->timestamps(); // Esto crea created_at y updated_at
        });

        // Esta tabla es necesaria para la función de "Olvidé mi contraseña" de Laravel
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Esta tabla es necesaria para que Laravel gestione las sesiones de los usuarios
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};