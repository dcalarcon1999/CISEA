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
            $table->id();
            $table->string('name');
            $table->string('rut', 12)->unique();
            $table->string('email')->unique();
            $table->enum('rol', ['operador', 'sip', 'jefatura', 'auditor'])->default('operador');
            // Datos institucionales (fuente Sección 2 del Anexo N°1)
            $table->string('cod_funcionario', 10)->nullable();  // formato 000000-N
            $table->string('apellidos', 80)->nullable();
            $table->string('nombres', 80)->nullable();
            $table->enum('grado', [
                'CARABINERO','CABO 2DO.','CABO 1RO.','SARGENTO 2DO.','SARGENTO 1RO.',
                'SUBOFICIAL','SUBOFICIAL MAYOR','SUBTENIENTE','TENIENTE',
                'CAPITÁN','MAYOR','TENIENTE CORONEL','CORONEL','GENERAL',
            ])->nullable();
            $table->string('unidad', 120)->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

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
