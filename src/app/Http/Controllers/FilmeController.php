<?php

namespace App\Http\Controllers;

use App\Models\Filme;
use Illuminate\Http\Request;

class FilmeController extends Controller
{
    public function show(string $id)
    {
        $filme = Filme::with([
            'imagens',
            'diretores.pessoa',
            'produtores.pessoa',
            'escritores.pessoa',
            'atores.pessoa.imagens',
            'estudios'
        ])->findOrFail($id);

        $generos = array_map('ucfirst', $filme->generos->pluck('nome')->toArray());
        $estudios = $filme->estudios->pluck('nome')->toArray();

        $avaliacoes = $filme->avaliacoes()->with('usuario')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('filmes.show', compact('filme', 'avaliacoes', 'generos', 'estudios'));
    }
}
