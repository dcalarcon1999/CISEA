<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evidencias', function (Blueprint $table) {
            $table->id();

            // Sección 1 — Identificación Novedad (ambos auto-generados por el servidor)
            $table->unsignedInteger('nro_novedad')->unique();
            $table->dateTime('fecha_novedad');

            // Sección 2 — Identificación Funcionario
            $table->string('cod_funcionario', 20);
            $table->string('grado', 60);
            $table->string('apellidos_nombre', 120);
            $table->string('unidad', 120);

            // Sección 3 — Identificación Estamento Solicitante
            $table->string('estamento_solicitante', 120);
            $table->enum('motivo', ['CAUSA', 'RIT', 'RUC', 'DOCUMENTACIÓN ELECTRÓNICA']);
            $table->string('motivo_nro', 40);

            // Sección 4 — Identificación de Grabaciones Solicitadas
            $table->dateTime('grabacion_desde')->nullable();
            $table->dateTime('grabacion_hasta')->nullable();
            $table->enum('tipo_grabacion', ['CCTV UNIDAD', 'CCTV VEHÍCULO POLICIAL', 'VIDEOCÁMARA CORPORAL'])->nullable();
            $table->string('identificador_grabacion', 120)->nullable();

            // Sección 5 — Identificación Oficio de Entrega (se completa en segundo paso)
            $table->string('oficio_entrega', 20)->nullable();
            $table->date('fecha_oficio')->nullable();
            $table->string('run_receptor', 12)->nullable();
            $table->string('apellidos_receptor', 80)->nullable();
            $table->string('nombres_receptor', 80)->nullable();
            $table->string('cargo_receptor', 120)->nullable();

            // Estado del ciclo de vida del registro
            $table->enum('estado', ['pendiente', 'entregado'])->default('pendiente');

            $table->foreignId('operador_id')->constrained('users');
            $table->timestamps();

            $table->index(['motivo', 'motivo_nro']);
        });

        Schema::create('logs_actividad', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evidencia_id')->constrained('evidencias');
            $table->foreignId('user_id')->constrained('users');
            $table->enum('accion', ['visualizacion', 'extraccion', 'entrega']);
            $table->text('descripcion')->nullable();
            $table->ipAddress('ip_origen')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logs_actividad');
        Schema::dropIfExists('evidencias');
    }
};
