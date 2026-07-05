<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filme;
use App\Models\Pessoa;
use App\Models\Avaliacao;

class HomeController extends Controller
{
    public function index()
    {
        $atores = Pessoa::has('ator')
            ->with('imagens')
            ->inRandomOrder()
            ->limit(3)
            ->get();

        $filmes = Filme::withCount('avaliacoes as reviews_count')
            ->withAvg('avaliacoes', 'nota')
            ->with('imagens')
            ->orderByDesc('reviews_count')
            ->orderByDesc('avaliacoes_avg_nota')
            ->limit(3)
            ->get();

        $new_movies = Filme::with('imagens')
            ->orderByDesc('data_lancamento')
            ->limit(3)
            ->get();

        $avaliacoes = Avaliacao::with(['usuario', 'filme.imagens'])
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();

        return view('home.index', compact('atores', 'filmes', 'new_movies', 'avaliacoes'));
    }

    public function buscar(Request $request)
    {
        $query = trim($request->input('q'));

        if (empty($query)) {
            return redirect('/');
        }

        $pessoas = Pessoa::where('nome', 'ILIKE', "%{$query}%")
            ->orWhere('biografia', 'ILIKE', "%{$query}%")
            ->with('imagens')
            ->get()
            ->map(function ($pessoa) {
                $roles = [];
                if ($pessoa->ator) $roles[] = 'Ator';
                if ($pessoa->diretor) $roles[] = 'Diretor';
                if ($pessoa->escritor) $roles[] = 'Escritor';
                if ($pessoa->produtor) $roles[] = 'Produtor';

                return [
                    'title' => $pessoa->nome,
                    'subtitle' => empty($roles) ? 'Nenhuma participação' : implode(' • ', $roles),
                    'obj' => $pessoa,
                    'img' => $pessoa->imagens->isNotEmpty()
                        ? asset('storage/' . $pessoa->imagens->first()->caminho)
                        : null,
                ];
            });

        $filmes = Filme::where('nome', 'ILIKE', "%{$query}%")
            ->orWhere('sinopse', 'ILIKE', "%{$query}%")
            ->with(['imagens', 'generos'])
            ->get()
            ->map(function ($filme) {
                $poster = $filme->poster();
                return [
                    'title' => $filme->nome,
                    'subtitle' => "<i class='bi bi-star-fill'></i> {$filme->displayNota()} &bull; {$filme->displayGeneros(2)} &bull; " . ($filme->data_lancamento ? date('Y', strtotime($filme->data_lancamento)) : ''),
                    'obj' => $filme,
                    'img' => $poster
                        ? asset('storage/' . $poster->caminho)
                        : null,
                ];
            });

        return view('home.busca', compact('query', 'pessoas', 'filmes'));
    }
}
