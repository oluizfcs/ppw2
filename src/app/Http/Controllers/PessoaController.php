<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use Illuminate\Http\Request;

class PessoaController extends Controller
{
    public function show(string $id)
    {
        $pessoa = Pessoa::with([
            'imagens',
            'ator.filmes.imagens',
            'diretor.filmes.imagens',
            'produtor.filmes.imagens',
            'escritor.filmes.imagens',
        ])->findOrFail($id);

        $mapCredit = function ($filme, $subtitle = null) {
            $poster = $filme->poster();
            return [
                'title'    => $filme->nome,
                'subtitle' => $subtitle,
                'obj'      => $filme,
                'img'      => $poster ? asset('storage/' . $poster->caminho) : null,
            ];
        };

        $credits = [];

        if ($pessoa->ator) {
            $credits['ator'] = $pessoa->ator->filmes->map(
                fn($f) => $mapCredit($f, 'Como: ' . $f->pivot->papel ?? null)
            )->toArray();
        }

        if ($pessoa->diretor) {
            $credits['diretor'] = $pessoa->diretor->filmes->map(
                fn($f) => $mapCredit($f)
            )->toArray();
        }

        if ($pessoa->produtor) {
            $credits['produtor'] = $pessoa->produtor->filmes->map(
                fn($f) => $mapCredit($f)
            )->toArray();
        }

        if ($pessoa->escritor) {
            $credits['escritor'] = $pessoa->escritor->filmes->map(
                fn($f) => $mapCredit($f)
            )->toArray();
        }

        return view('pessoas.show', compact('pessoa', 'credits'));
    }
}
