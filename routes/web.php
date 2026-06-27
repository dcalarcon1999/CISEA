<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ConstanciaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EvidenciaController;
use App\Http\Controllers\ReporteController;
use Illuminate\Support\Facades\Route;

// Auth (sin protección)
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    // Redirige al dashboard del rol correspondiente
    Route::get('/', [DashboardController::class, 'index'])->name('home');

    // Operador y SIP: módulo de constancias de monitoreo
    Route::middleware('role:operador,sip')->group(function () {
        Route::get('/constancias', [ConstanciaController::class, 'index'])->name('constancias.index');
        Route::post('/constancias', [ConstanciaController::class, 'store'])->name('constancias.store');
    });

    // Personal SIP: constancias + gestión completa de evidencias
    Route::middleware('role:sip')->group(function () {
        Route::post('/evidencias',                  [EvidenciaController::class, 'store'])->name('evidencias.store');
        Route::get('/evidencias',                   [EvidenciaController::class, 'index'])->name('evidencias.index');
        Route::get('/evidencias/create',            [EvidenciaController::class, 'create'])->name('evidencias.create');
        Route::get('/evidencias/{evidencia}',       [EvidenciaController::class, 'show'])->name('evidencias.show');
        Route::get('/evidencias/{evidencia}/acta', [EvidenciaController::class, 'acta'])->name('evidencias.acta');
        Route::get('/evidencias/{evidencia}/edit',  [EvidenciaController::class, 'edit'])->name('evidencias.edit');
        Route::put('/evidencias/{evidencia}',       [EvidenciaController::class, 'update'])->name('evidencias.update');
    });

    // Jefatura y Auditor TIC: reportes de control y trazabilidad
    Route::middleware('role:jefatura,auditor')->group(function () {
        Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
    });

    // Auditor TIC: logs inmutables y gestión de usuarios
    Route::middleware('role:auditor')->group(function () {
        Route::get('/auditoria', [DashboardController::class, 'auditoria'])->name('auditoria.index');
    });
});
