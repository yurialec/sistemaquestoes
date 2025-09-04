<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BancaController;
use App\Http\Controllers\ProvaController;
use App\Http\Controllers\QuestaoController;
use App\Http\Controllers\ProfileController;

// Route::redirect('/', '/dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::delete('/dashboard/reset', [DashboardController::class, 'reset'])->name('dashboard.reset');

    Route::get('/bancas', [BancaController::class, 'index'])->name('banca.index');
    Route::get('/provas', [ProvaController::class, 'index'])->name('prova.index');

    Route::get('/questoes/{prova}', [QuestaoController::class, 'index'])
        ->name('questao.index');

    Route::get('/responder-questoes', [QuestaoController::class, 'responder'])
        ->name('questao.responder');

    Route::post('/salvar-resposta/{questao}', [QuestaoController::class, 'salvarResposta'])
        ->name('questao.salvar.resposta');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
