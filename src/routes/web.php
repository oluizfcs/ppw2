<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AvaliacaoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FilmeController as PublicFilmeController;
use App\Http\Controllers\PessoaController as PublicPessoaController;
use App\Http\Controllers\Admin\EstudioController;
use App\Http\Controllers\Admin\FilmeController;
use App\Http\Controllers\Admin\GeneroController;
use App\Http\Controllers\Admin\ImagemController;
use App\Http\Controllers\Admin\PessoaController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/buscar', [HomeController::class, 'buscar']);
Route::get('/filmes/{id}', [PublicFilmeController::class, 'show'])->name('filmes.show');
Route::get('/pessoas/{id}', [PublicPessoaController::class, 'show'])->name('pessoas.show');
Route::get('/filmes/{id}/avaliacoes', [AvaliacaoController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::middleware('admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/filmes/buscar', [FilmeController::class, 'buscar']);
            Route::resource('filmes', FilmeController::class);
            Route::resource('generos', GeneroController::class);
            Route::get('/pessoas/buscar', [PessoaController::class, 'buscar']);
            Route::resource('pessoas', PessoaController::class);
            Route::resource('estudios', EstudioController::class);

            Route::delete('/imagens/{imagem}/filme/{filme}', [ImagemController::class, 'destroyFromFilme']);
            Route::delete('/imagens/{imagem}/pessoa/{pessoa}', [ImagemController::class, 'destroyFromPessoa']);
            Route::delete('/imagens/{imagem}/estudio/{estudio}', [ImagemController::class, 'destroyFromEstudio']);
        });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/avaliacoes', AvaliacaoController::class, ['only' => ['store', 'update', 'destroy']]);
});

require __DIR__ . '/auth.php';
