<?php

use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\CategoriaServicoController;
use App\Http\Controllers\PaginaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServicoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rotas Públicas (Acessíveis a todos, mesmo sem autenticação)
|--------------------------------------------------------------------------
*/

// Página inicial e contactos
Route::get('/', [PaginaController::class, 'inicio'])->name('inicio');
Route::get('/contacto', [PaginaController::class, 'contacto'])->name('contacto');
Route::post('/contacto', [PaginaController::class, 'enviarContacto'])->name('contacto.enviar');

// Listagens públicas de serviços e categorias
Route::get('/servicos', [ServicoController::class, 'index'])->name('servicos.index');
Route::get('/categorias', [CategoriaServicoController::class, 'index'])->name('categorias.index');

/*
|--------------------------------------------------------------------------
| Rotas de Administrador (Requerem login de Administrador)
| Devem vir ANTES das rotas dinâmicas /{id} para não haver colisões
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->group(function () {
    // Gestão de Agendamentos & Calendário
    Route::get('/admin/calendario', [AgendamentoController::class, 'calendario'])->name('admin.calendario');
    Route::patch('/admin/agendamentos/{agendamento}/estado', [AgendamentoController::class, 'atualizarEstado'])->name('admin.agendamentos.estado');

    // Gestão de Serviços
    Route::get('/servicos/criar', [ServicoController::class, 'create'])->name('servicos.create');
    Route::post('/servicos', [ServicoController::class, 'store'])->name('servicos.store');
    Route::get('/servicos/{servico}/editar', [ServicoController::class, 'edit'])->name('servicos.edit');
    Route::put('/servicos/{servico}', [ServicoController::class, 'update'])->name('servicos.update');
    Route::delete('/servicos/{servico}', [ServicoController::class, 'destroy'])->name('servicos.destroy');

    // Gestão de Categorias
    Route::get('/categorias/criar', [CategoriaServicoController::class, 'create'])->name('categorias.create');
    Route::post('/categorias', [CategoriaServicoController::class, 'store'])->name('categorias.store');
    Route::get('/categorias/{categoria}/editar', [CategoriaServicoController::class, 'edit'])->name('categorias.edit');
    Route::put('/categorias/{categoria}', [CategoriaServicoController::class, 'update'])->name('categorias.update');
    Route::delete('/categorias/{categoria}', [CategoriaServicoController::class, 'destroy'])->name('categorias.destroy');
});

/*
|--------------------------------------------------------------------------
| Detalhes Públicos com parâmetros dinâmicos
|--------------------------------------------------------------------------
*/
Route::get('/servicos/{servico}', [ServicoController::class, 'show'])->name('servicos.show');
Route::get('/categorias/{categoria}', [CategoriaServicoController::class, 'show'])->name('categorias.show');

/*
|--------------------------------------------------------------------------
| Rotas Protegidas de Utilizador (Requerem login)
| Ao clicar em agendar sem estar logado, o utilizador é redirecionado para /login
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Agendamentos - Apenas utilizadores autenticados podem marcar e consultar
    Route::get('/agendar', [AgendamentoController::class, 'create'])->name('agendamentos.create');
    Route::post('/agendar', [AgendamentoController::class, 'store'])->name('agendamentos.store');
    Route::get('/meus-agendamentos', [AgendamentoController::class, 'meusAgendamentos'])->name('agendamentos.meus');
    Route::post('/agendamentos/{agendamento}/cancelar', [AgendamentoController::class, 'cancelar'])->name('agendamentos.cancelar');

    // Perfil (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
