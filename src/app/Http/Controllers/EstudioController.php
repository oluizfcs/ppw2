<?php

namespace App\Http\Controllers;

use App\Models\Estudio;
use Illuminate\Http\Request;

class EstudioController extends Controller
{
    public function show(string $id)
    {
        $estudio = Estudio::with(['imagens', 'filmes.imagens'])->findOrFail($id);

        $filmes = $estudio->filmes->map(fn($filme) => [
            'title'    => $filme->nome,
            'subtitle' => null,
            'obj'      => $filme,
            'img'      => $filme->imagens->isNotEmpty()
                ? asset('storage/' . $filme->imagens->first()->caminho)
                : null,
        ]);

        return view('estudios.show', compact('estudio', 'filmes'));
    }
}
