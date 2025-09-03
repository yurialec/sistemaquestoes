<?php

use App\Http\Controllers\BancaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProvaController;
use App\Http\Controllers\QuestaoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/bancas', [BancaController::class, 'index'])->name('banca.index');
Route::get('/provas', [ProvaController::class, 'index'])->name('prova.index');
Route::get('/questoes/{prova}', [QuestaoController::class, 'index'])->name('questao.index');
Route::get('/responder-questoes', [QuestaoController::class, 'responder'])->name('questao.responder');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
