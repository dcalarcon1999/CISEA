<?php

use App\Http\Controllers\EvidenciaController;
use Illuminate\Support\Facades\Route;

// TODO: restaurar middleware auth y RBAC antes de pasar a producción
Route::get('/', fn() => redirect()->route('evidencias.index'));
Route::resource('evidencias', EvidenciaController::class)->except(['destroy']);

// Rutas placeholder para que los links del sidebar no rompan
Route::get('/custodia', fn() => redirect()->route('evidencias.index'))->name('custodia.index');
Route::get('/reportes', fn() => redirect()->route('evidencias.index'))->name('reportes.index');
Route::post('/logout', fn() => redirect('/'))->name('logout');
