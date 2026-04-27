<?php

use App\Http\Controllers\FilmeController;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\ProdutoController;
// use App\Models\Produto;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('index');
});

// Route::get('/produtos/caros', [ProdutoController::class, 'caros']);
// Route::resource('produtos', ProdutoController::class);

Route::resource('filmes', FilmeController::class);

// Route::get('/ping', function () {
//     return response()->json(['status' => 'ok', 'version' => 1.0]);
// });

// Route::post('/dados', function () {
//     return response()->json(['mensagem' => 'dados recebidos']);
// });

// Route::get('/produtos', function() {
//     return response()->json([
//         ['id' => 0, 'nome' => 'produto1', 'preco' => 1500],
//         ['id' => 1, 'nome' => 'produto2', 'preco' => 3000],
//         ['id' => 2, 'nome' => 'produto3', 'preco' => 4500]
//     ]);
// });

// Route::get('/produtos/{id}', function (int $id) {
//     return response()->json(['id' => $id, 'nome' => "Produto$id", 'preco' => random_int(1500, 4000)]);
// });

// Route::get('/produtos', [ProdutoController::class, 'index']);
// Route::get('/produtos/create', [ProdutoController::class, 'create']);
// Route::post('/produtos', [ProdutoController::class, 'store']);
// Route::get('/produtos/{id}', [ProdutoController::class, 'show']);
// Route::get('/produtos/{id}/edit', [ProdutoController::class, 'edit']);
// Route::patch('/produtos/{id}', [ProdutoController::class, 'update']);
// Route::delete('/produtos/{id}', [ProdutoController::class, 'destroy']);

// Route::get('/produtos/{id}/avaliacoes', function (int $id) {
//     return response()->json([
//         ['id' => 0, 'nota' => 2, 'mensagem' => "O produto$id é péssimo."],
//         ['id' => 1, 'nota' => 4, 'mensagem' => "O produto$id é bom."],
//         ['id' => 2, 'nota' => 5, 'mensagem' => "O produto$id é excelente!"]
//     ]);
// });

// Route::get('/categorias/{slug?}', function (string $slug = 'todas') {
//     return response()->json(['categoria' => $slug]);
// });

// Route::get('/usuarios/{id}', function (int $id) {
//     return response()->json(['id' => $id, 'usuario' => "Usuario$id"]); 
// })->whereNumber('id');

// Route::prefix('admin')->name('admin.')->group(function () {

//     Route::get('/usuarios', function () {
//         return response()->json(['area' => 'admin']); 
//     })->name('usuarios');

//     Route::get('/relatorios', function () {
//         return response()->json(['relatorio' => 'mensal']); 
//     })->name('relatorios');
// });
