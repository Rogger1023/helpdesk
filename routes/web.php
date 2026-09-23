<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ChamadoController;

Route::get('/', function () {
    return Inertia::render('home');
});
Route::get('/chamados/criar', [ChamadoController::class, 'create'])
    ->name('chamados.create');

Route::post('/chamados', [ChamadoController::class, 'store'])
    ->name('chamados.store');
