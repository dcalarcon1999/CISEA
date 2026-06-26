<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('constancias', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('nro_orden')->unique();

            // Snapshot del funcionario (auto-completado desde la sesión)
            $table->string('cod_funcionario', 20);
            $table->string('grado', 60);
            $table->string('apellidos_nombre', 120);
            $table->string('unidad', 120);

            // Texto libre de la constancia
            $table->string('descripcion', 500);

            $table->foreignId('operador_id')->constrained('users');

            // Solo created_at — registro inmutable, sin updated_at
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('constancias');
    }
};
