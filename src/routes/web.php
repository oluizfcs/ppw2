<?php

use App\Http\Controllers\AvaliacaoController;
use App\Http\Controllers\EstudioController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmeController;
use App\Http\Controllers\GeneroController;
use App\Http\Controllers\ImagemController;
use App\Http\Controllers\PessoaController;

Route::get('/', function () {
    return view('index');
});

Route::middleware('auth')->group(function () {
    Route::resource('filmes', FilmeController::class);
    Route::resource('generos', GeneroController::class);
    Route::get('/pessoas/buscar', [PessoaController::class, 'buscar']);
    Route::resource('pessoas', PessoaController::class);
    Route::resource('estudios', EstudioController::class);
    Route::get('/buscar', [FilmeController::class, 'buscar'])->name('buscar');

    Route::delete('/imagens/{imagem}/filme/{filme}', [ImagemController::class, 'destroyFromFilme']);
    Route::delete('/imagens/{imagem}/pessoa/{pessoa}', [ImagemController::class, 'destroyFromPessoa']);
    Route::delete('/imagens/{imagem}/estudio/{estudio}', [ImagemController::class, 'destroyFromEstudio']);
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/filme/{id}', [FilmeController::class, 'detalhar']);
Route::get('/filmes/{id}/avaliacoes', [AvaliacaoController::class, 'index']);

Route::get('/admin', function () {
    return view('admin');
})->middleware(['auth', 'verified'])->name('admin');


require __DIR__.'/auth.php';
