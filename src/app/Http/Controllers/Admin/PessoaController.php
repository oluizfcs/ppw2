<?php

namespace App\Http\Controllers\Admin;

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

        return view('admin.pessoas.index', compact('pessoas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pessoas.create');
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

        DB::beginTransaction();
        try {
            $pessoa = Pessoa::create($dados);

            foreach ($dados['caminhos_imagens'] as $caminhoImagem) {
                $imagem = Imagem::create([
                    'caminho' => $caminhoImagem,
                    'nome' => $pessoa->nome
                ]);

                $pessoa->imagens()->attach($imagem->id);
            }
            DB::commit();
        } catch (Exception $e) {
            Storage::disk('public')->delete($caminhosImagens);
            DB::rollBack();
            return back()->with('error', 'Erro ao salvar a pessoa. Tente novamente: ' . $e->getMessage());
        }

        return redirect(route('admin.pessoas.show', $pessoa->id))->with('success', 'Pessoa cadastrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pessoa = Pessoa::with('imagens')->findOrFail($id);

        return view('admin.pessoas.show', compact('pessoa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pessoa = Pessoa::findOrFail($id);
        $imagens = $pessoa->imagens;

        return view('admin.pessoas.edit', compact('pessoa', 'imagens'));
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

        return redirect(route('admin.pessoas.show', $pessoa->id))->with('success', 'Pessoa atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pessoa = Pessoa::findOrFail($id);

        $atorCount = $pessoa->ator()->count();
        $diretorCount = $pessoa->diretor()->count();
        $produtorCount = $pessoa->produtor()->count();
        $escritorCount = $pessoa->escritor()->count();

        $creditos = [];

        if ($atorCount > 0) {
            $creditos[] = "{$atorCount} " . ($atorCount > 1 ? "atuações" : "atuação");
        }
        if ($diretorCount > 0) {
            $creditos[] = "{$diretorCount} " . ($diretorCount > 1 ? "direções" : "direção");
        }
        if ($produtorCount > 0) {
            $creditos[] = "{$produtorCount} " . ($produtorCount > 1 ? "produções" : "produção");
        }
        if ($escritorCount > 0) {
            $creditos[] = "{$escritorCount} " . ($escritorCount > 1 ? "roteiros" : "roteiro");
        }

        if (!empty($creditos) && !request()->boolean('confirm')) {
            return back()->with([
                'confirm_deletion' => true,
                'pessoa_id' => $pessoa->id,
                'creditos_msg' => "Esta pessoa possui " . implode(', ', $creditos) . ". Realmente deseja excluí-la?",
            ]);
        }

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

        return redirect(route('admin.pessoas.index'))->with('success', 'Pessoa excluída com sucesso!');
    }

    public function buscar(Request $request)
    {
        $termo = trim($request->input('q', ''));
        $filmeId = $request->input('filme_id');
        if (strlen($termo) < 2) {
            return response()->json([]);
        }
        $pessoas = Pessoa::with('imagens')
            ->where('nome', 'ilike', "%{$termo}%")
            ->limit(8)
            ->get(['id', 'nome']);
        // Indica quais tipos de vínculo a pessoa já tem no filme
        return response()->json($pessoas->map(function ($p) use ($filmeId) {
            $vinculos = [];
            if ($filmeId) {
                if ($p->ator?->filmes()->where('filme_id', $filmeId)->exists())
                    $vinculos[] = 'ator';
                if ($p->diretor?->filmes()->where('filme_id', $filmeId)->exists())
                    $vinculos[] = 'diretor';
            }
            return [
                'id' => $p->id,
                'nome' => $p->nome,
                'foto' => $p->foto_url,
                'vinculos' => $vinculos
            ];
        }));
    }
}
