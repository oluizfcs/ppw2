<?php

namespace App\Http\Controllers\Admin;

use App\Models\Filme;
use App\Models\Imagem;
use App\Models\Pessoa;
use App\Models\Estudio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImagemController extends Controller
{
    public function destroyFromFilme(Imagem $imagem, Filme $filme)
    {
        $filme->imagens()->detach($imagem->id);

        $usos = $imagem->filmes()->count() + $imagem->pessoa()->count() + $imagem->estudios()->count();

        if ($usos === 0) {
            Storage::disk('public')->delete($imagem->caminho);
            $imagem->delete();
        }

        return response()->json(['message' => 'Imagem removida!'], 200);
    }

    public function destroyFromPessoa(Imagem $imagem, Pessoa $pessoa)
    {
        $pessoa->imagens()->detach($imagem->id);

        $usos = $imagem->filmes()->count() + $imagem->pessoa()->count() + $imagem->estudios()->count();

        if ($usos === 0) {
            Storage::disk('public')->delete($imagem->caminho);
            $imagem->delete();
        }

        return response()->json(['message' => 'Imagem removida!'], 200);
    }

    public function destroyFromEstudio(Imagem $imagem, Estudio $estudio)
    {
        $estudio->imagens()->detach($imagem->id);

        $usos = $imagem->filmes()->count() + $imagem->pessoa()->count() + $imagem->estudios()->count();

        if ($usos === 0) {
            Storage::disk('public')->delete($imagem->caminho);
            $imagem->delete();
        }

        return response()->json(['message' => 'Imagem removida!'], 200);
    }
}
