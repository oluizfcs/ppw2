<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmeController;

Route::get('/', function () {
    return view('index');
});

Route::middleware('auth')->group(function () {
    Route::resource('filmes', FilmeController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::get('/filmes', [FilmeController::class, 'index']);
// Route::get('/filmes/{id}', [FilmeController::class, 'show']);

Route::get('/admin', function () {
    return view('admin');
})->middleware(['auth', 'verified'])->name('admin');


require __DIR__.'/auth.php';
