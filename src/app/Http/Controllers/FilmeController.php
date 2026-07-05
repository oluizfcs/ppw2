<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
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
            'estudios',
            'generos',
        ])->findOrFail($id);

        $generos = array_map('ucfirst', $filme->generos->pluck('nome')->toArray());
        $estudios = $filme->estudios->pluck('nome')->toArray();

        $elenco = $filme->atores->map(fn($ator) => [
            'title'    => $ator->pessoa->nome,
            'subtitle' => 'Como: ' . $ator->pivot->papel ?? null,
            'obj'      => $ator->pessoa,
            'img'      => $ator->pessoa->imagens->isNotEmpty()
                ? asset('storage/' . $ator->pessoa->imagens->first()->caminho)
                : null,
        ])->toArray();

        $avaliacoes = $filme->avaliacoes()->with('usuario.fotoPerfil')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        $userReview = null;
        $review = null;
        if (auth()->check()) {
            $userReview = $filme->avaliacoes()
                ->where('usuario_id', auth()->id())
                ->first();
            $review = new Avaliacao();
        }

        return view('filmes.show', compact(
            'filme',
            'avaliacoes',
            'generos',
            'estudios',
            'elenco',
            'userReview',
            'review'
        ));
    }
}
