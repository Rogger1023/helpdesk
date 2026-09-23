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

Route::get('/chamados',[ChamadoController::class,'index'])
    ->name('chamados.index');

Route::get('/chamados/{chamado}', [ChamadoController::class, 'show'])
    ->name('chamados.show');

Route::get('/chamados/{chamado}/editar', [ChamadoController::class, 'edit'])
    ->name('chamados.edit');

Route::put('/chamados/{chamado}', [ChamadoController::class, 'update'])
    ->name('chamados.update');
