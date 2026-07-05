<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAvaliacaoRequest;
use App\Models\Avaliacao;
use Exception;

class AvaliacaoController extends Controller
{
    public function store(StoreAvaliacaoRequest $request)
    {
        $dados = $request->validated();

        $exists = Avaliacao::where('filme_id', $dados['filme_id'])
            ->where('usuario_id', auth()->id())->exists();

        if ($exists) {
            return back()->with('error', 'Você já avaliou este filme.');
        }

        $dados['usuario_id'] = auth()->id();
        Avaliacao::create($dados);

        return back()->with('success', 'Avaliação criada com sucesso!');
    }

    public function update(StoreAvaliacaoRequest $request, string $id)
    {
        $avaliacao = Avaliacao::findOrFail($id);
        $dados = $request->validated();

        try {
            $avaliacao->update($dados);
        } catch (Exception $e) {
            return back()->with('error', 'Erro ao atualizar a avaliação. Tente novamente: ' . $e->getMessage());
        }

        return back()->with('success', 'Avaliação atualizada com sucesso!');
    }

    public function destroy(string $id)
    {
        $avaliacao = Avaliacao::findOrFail($id);

        try {
            $avaliacao->delete();
        } catch (Exception $e) {
            return back()->with('error', 'Erro ao excluir a avaliação. Tente novamente: ' . $e->getMessage());
        }

        return back()->with('success', 'Avaliação excluída com sucesso!');
    }
}
