<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filme;
use App\Models\Pessoa;
use App\Models\Estudio;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index');
    }

        public function buscar(Request $request)
    {
        $query = $request->input('search');

        if (empty($query)) {
            return redirect('/');
        }

        $filmes = Filme::with(['imagens' => function ($query) {
            $query->wherePivot('poster', true);
        }])
            ->where('nome', 'ILIKE', '%' . $query . '%')
            ->orWhere('sinopse', 'ILIKE', '%' . $query . '%')
            ->get();

        $diretores = Pessoa::has('diretor')
            ->with('imagens')
            ->where('nome', 'ILIKE', '%' . $query . '%')
            ->get();

        $atores = Pessoa::has('ator')
            ->with('imagens')
            ->where('nome', 'ILIKE', '%' . $query . '%')
            ->get();

        $escritores = Pessoa::has('escritor')
            ->with('imagens')
            ->where('nome', 'ILIKE', '%' . $query . '%')
            ->get();

        $produtores = Pessoa::has('produtor')
            ->with('imagens')
            ->where('nome', 'ILIKE', '%' . $query . '%')
            ->get();

        $estudios = Estudio::with('imagens')
            ->where('nome', 'ILIKE', '%' . $query . '%')
            ->orWhere('local', 'ILIKE', '%' . $query . '%')
            ->get();

        return view('home.busca', compact('query', 'filmes', 'diretores', 'atores', 'escritores', 'produtores', 'estudios'));
    }
}
