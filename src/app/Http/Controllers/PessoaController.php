<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePessoaRequest;
use App\Http\Requests\UpdatePessoaRequest;
use App\Models\Pessoa;
use App\Models\Imagem;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PessoaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pessoas = Pessoa::with('imagens')->paginate(4);

        return view('pessoas.index', compact('pessoas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pessoas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePessoaRequest $request)
    {
        $dados = $request->validated();
        $imagens = $request->file('imagens', []);
        $caminhosImagens = [];

        foreach ($imagens as $imagem) {
            $caminhosImagens[] = $imagem->store('pessoas', 'public');
        }

        $dados['caminhos_imagens'] = $caminhosImagens;

        try {
            DB::transaction(function () use ($dados) {
                $pessoa = Pessoa::create($dados);

                foreach ($dados['caminhos_imagens'] as $caminhoImagem) {
                    $imagem = Imagem::create([
                        'caminho' => $caminhoImagem,
                        'nome' => $pessoa->nome
                    ]);

                    $pessoa->imagens()->attach($imagem->id);
                }
            });
        } catch (Exception $e) {
            Storage::disk('public')->delete($caminhosImagens);

            return back()->with('error', 'Erro ao salvar a pessoa. Tente novamente: ' . $e->getMessage());
        }

        return redirect('/pessoas')->with('success', 'Pessoa cadastrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pessoa = Pessoa::with('imagens')->findOrFail($id);

        return view('pessoas.show', compact('pessoa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pessoa = Pessoa::findOrFail($id);
        $imagens = $pessoa->imagens;

        return view('pessoas.edit', compact('pessoa', 'imagens'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePessoaRequest $request, string $id)
    {
        $dados = $request->validated();
        $pessoa = Pessoa::findOrFail($id);

        $imagens = [];
        if ($request->hasFile('imagens')) {
            $imagens = $request->file('imagens', []);
        }

        $caminhosImagens = [];
        foreach ($imagens as $imagem) {
            $caminhosImagens[] = $imagem->store('pessoas', 'public');
        }

        $dados['caminhos_imagens'] = $caminhosImagens;

        try {
            DB::transaction(function () use ($pessoa, $dados) {
                $pessoa->update($dados);

                if (!empty($dados['caminhos_imagens'])) {
                    foreach ($dados['caminhos_imagens'] as $caminhoImagem) {
                        $imagem = Imagem::create([
                            'caminho' => $caminhoImagem,
                            'nome' => $pessoa->nome
                        ]);
                        $pessoa->imagens()->attach($imagem->id);
                    }
                }
            });
        } catch (Exception $e) {
            if (!empty($caminhosImagens)) {
                Storage::disk('public')->delete($caminhosImagens);
            }

            return back()->with('error', 'Erro ao editar a pessoa. Tente novamente: ' . $e->getMessage());
        }

        return redirect('/pessoas')->with('success', 'Pessoa atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pessoa = Pessoa::findOrFail($id);

        try {
            DB::transaction(function () use ($pessoa) {
                $imagens = $pessoa->imagens;
                $pessoa->imagens()->detach();

                foreach ($imagens as $imagem) {
                    $usos = $imagem->filmes()->count() + $imagem->pessoa()->count();
                    if ($usos === 0) {
                        Storage::disk('public')->delete($imagem->caminho);
                        $imagem->delete();
                    }
                }

                $pessoa->delete();
            });
        } catch (Exception $e) {
            return back()->with('error', 'Erro ao excluir a pessoa: ' . $e->getMessage());
        }

        return redirect('/pessoas')->with('success', 'Pessoa excluída com sucesso!');
    }
}
