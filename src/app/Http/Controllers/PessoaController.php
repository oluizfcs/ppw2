<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use Illuminate\Http\Request;

class PessoaController extends Controller
{
    public function show(string $id)
    {
        $pessoa = Pessoa::with('imagens')->findOrFail($id);

        return view('pessoas.show', compact('pessoa'));
    }
}
