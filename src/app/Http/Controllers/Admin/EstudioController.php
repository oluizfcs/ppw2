<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreEstudioRequest;
use App\Http\Requests\UpdateEstudioRequest;
use App\Models\Estudio;
use App\Models\Imagem;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EstudioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estudios = Estudio::with('imagens')->paginate(4);

        return view('admin.estudios.index', compact('estudios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.estudios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEstudioRequest $request)
    {
        $dados = $request->validated();
        $dados['local'] = $dados['local'] ?? '';
        
        $imagens = $request->file('imagens', []);
        $caminhosImagens = [];

        foreach ($imagens as $imagem) {
            $caminhosImagens[] = $imagem->store('estudios', 'public');
        }

        $dados['caminhos_imagens'] = $caminhosImagens;

        DB::beginTransaction();
        try {
            $estudio = Estudio::create($dados);

            foreach ($dados['caminhos_imagens'] as $caminhoImagem) {
                $imagem = Imagem::create([
                    'caminho' => $caminhoImagem,
                    'nome' => $estudio->nome
                ]);

                $estudio->imagens()->attach($imagem->id);
            }
            DB::commit();
        } catch (Exception $e) {
            Storage::disk('public')->delete($caminhosImagens);
            DB::rollBack();
            return back()->with('error', 'Erro ao salvar o estúdio. Tente novamente: ' . $e->getMessage());
        }
        
        return redirect(route('admin.estudios.show', $estudio->id))->with('success', 'Estúdio cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $estudio = Estudio::with('imagens')->findOrFail($id);

        return view('admin.estudios.show', compact('estudio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $estudio = Estudio::findOrFail($id);
        $imagens = $estudio->imagens;

        return view('admin.estudios.edit', compact('estudio', 'imagens'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEstudioRequest $request, string $id)
    {
        $dados = $request->validated();
        $dados['local'] = $dados['local'] ?? '';
        
        $estudio = Estudio::findOrFail($id);

        $imagens = [];
        if ($request->hasFile('imagens')) {
            $imagens = $request->file('imagens', []);
        }

        $caminhosImagens = [];
        foreach ($imagens as $imagem) {
            $caminhosImagens[] = $imagem->store('estudios', 'public');
        }

        $dados['caminhos_imagens'] = $caminhosImagens;

        try {
            DB::transaction(function () use ($estudio, $dados) {
                $estudio->update($dados);

                if (!empty($dados['caminhos_imagens'])) {
                    foreach ($dados['caminhos_imagens'] as $caminhoImagem) {
                        $imagem = Imagem::create([
                            'caminho' => $caminhoImagem,
                            'nome' => $estudio->nome
                        ]);
                        $estudio->imagens()->attach($imagem->id);
                    }
                }
            });
        } catch (Exception $e) {
            if (!empty($caminhosImagens)) {
                Storage::disk('public')->delete($caminhosImagens);
            }

            return back()->with('error', 'Erro ao editar o estúdio. Tente novamente: ' . $e->getMessage());
        }

        return redirect(route('admin.estudios.show', $estudio->id))->with('success', 'Estúdio atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $estudio = Estudio::findOrFail($id);

        try {
            DB::transaction(function () use ($estudio) {
                $imagens = $estudio->imagens;
                $estudio->imagens()->detach();

                foreach ($imagens as $imagem) {
                    $usos = $imagem->filmes()->count() + $imagem->pessoa()->count() + $imagem->estudios()->count();
                    if ($usos === 0) {
                        Storage::disk('public')->delete($imagem->caminho);
                        $imagem->delete();
                    }
                }

                $estudio->delete();
            });
        } catch (Exception $e) {
            return back()->with('error', 'Erro ao excluir o estúdio: ' . $e->getMessage());
        }

        return redirect(route('admin.estudios.index'))->with('success', 'Estúdio excluído com sucesso!');
    }
}
