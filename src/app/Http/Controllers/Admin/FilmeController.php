<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreFilmeRequest;
use App\Http\Requests\UpdateFilmeRequest;
use App\Models\Filme;
use App\Models\Genero;
use App\Models\Imagem;
use App\Models\Estudio;
use App\Models\Diretor;
use App\Models\Produtor;
use App\Models\Escritor;
use App\Models\Ator;
use App\Models\Pessoa;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FilmeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filmes = Filme::with(['imagens' => function ($query) {
            $query->wherePivot('poster', true);
        }])->paginate(4);

        // $filmes = Filme::with('imagens')->get();

        // dd($filmes[0]);
        // dd($filmes[0]->imagens);

        return view('admin.filmes.index', compact('filmes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $generos = Genero::all('id', 'nome')->pluck('nome', 'id');
        $estudios = Estudio::all('id', 'nome')->pluck('nome', 'id');

        $pessoas = Pessoa::all('id', 'nome')->pluck('nome', 'id');

        return view('admin.filmes.create', compact('generos', 'estudios', 'pessoas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFilmeRequest $request)
    {
        $dados = $request->validated();
        $imagens = $request->file('imagens', []);

        $caminhoPoster = $request->file('poster')->store('posters', 'public');
        $caminhosImagens = [];

        foreach ($imagens as $imagem) {
            $caminhosImagens[] = $imagem->store('imagens', 'public');
        }

        $dados['caminho_poster'] = $caminhoPoster;
        $dados['caminhos_imagens'] = $caminhosImagens;

        DB::beginTransaction();
        try {
            $filme = Filme::create($dados);

            $poster = Imagem::create([
                'caminho' => $dados['caminho_poster'],
                'nome' => $filme->nome
            ]);

            $filme->imagens()->attach($poster->id, ['poster' => true]);

            foreach ($dados['caminhos_imagens'] as $caminhoImagem) {
                $imagem = Imagem::create([
                    'caminho' => $caminhoImagem,
                    'nome' => $filme->nome
                ]);

                $filme->imagens()->attach($imagem->id, ['poster' => false]);
            }

            $generoIds = [];

            foreach ($dados['generos'] as $nomeGenero) {
                $genero = Genero::firstOrCreate(
                    ['nome' => Str::lower(trim($nomeGenero))]
                );

                $generoIds[] = $genero->id;
            }

            $filme->generos()->attach($generoIds);

            if (!empty($dados['estudios'])) {
                $filme->estudios()->sync($dados['estudios']);
            }

            $this->sincronizarVinculos($filme, $request->input('vinculos', []));

            // $diretorIds = [];
            // if (!empty($dados['diretores'])) {
            //     foreach ($dados['diretores'] as $pessoaId) {
            //         $diretor = Diretor::firstOrCreate(['pessoa_id' => $pessoaId]);
            //         $diretorIds[] = $diretor->id;
            //     }
            // }
            // $filme->diretores()->sync($diretorIds);

            // $produtorIds = [];
            // if (!empty($dados['produtores'])) {
            //     foreach ($dados['produtores'] as $pessoaId) {
            //         $produtor = Produtor::firstOrCreate(['pessoa_id' => $pessoaId]);
            //         $produtorIds[] = $produtor->id;
            //     }
            // }
            // $filme->produtores()->sync($produtorIds);

            // $escritorIds = [];
            // if (!empty($dados['escritores'])) {
            //     foreach ($dados['escritores'] as $pessoaId) {
            //         $escritor = Escritor::firstOrCreate(['pessoa_id' => $pessoaId]);
            //         $escritorIds[] = $escritor->id;
            //     }
            // }
            // $filme->escritores()->sync($escritorIds);

            // $atoresSync = [];
            // if (!empty($dados['atores'])) {
            //     foreach ($dados['atores'] as $pessoaId) {
            //         $ator = Ator::firstOrCreate(['pessoa_id' => $pessoaId]);
            //         $papel = $dados['papeis'][$pessoaId] ?? 'Coadjuvante';
            //         $atoresSync[$ator->id] = ['papel' => $papel];
            //     }
            // }
            // $filme->atores()->sync($atoresSync);
            DB::commit();
        } catch (Exception $e) {
            Storage::disk('public')->delete($caminhoPoster);
            Storage::disk('public')->delete($caminhosImagens);
            DB::rollBack();
            return back()->with('error', 'Erro ao salvar o filme. Tente novamente.' . $e->getMessage());
        }

        return redirect(route('admin.filmes.show', $filme->id))->with('success', 'Filme cadastrado!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $filme = Filme::with([
            'imagens',
            'diretores.pessoa',
            'produtores.pessoa',
            'escritores.pessoa',
            'atores.pessoa.imagens',
            'estudios'
        ])->findOrFail($id);

        $generos = array_map('ucfirst', $filme->generos->pluck('nome')->toArray());
        $estudios = $filme->estudios->pluck('nome')->toArray();

        $avaliacoes = $filme->avaliacoes()->with('usuario')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.filmes.show', compact('filme', 'avaliacoes', 'generos', 'estudios'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $filme = Filme::findOrFail($id);
        $generos = Genero::all()->pluck('nome')->toArray();
        $generosDesteFilme = $filme->generos->pluck('nome')->toArray();
        $poster = $filme->imagens->firstWhere('pivot.poster', true);
        $outrasImagens = $filme->imagens->where('pivot.poster', false)->values()->all();

        $estudios = Estudio::all('id', 'nome')->pluck('nome', 'id');
        $estudiosDesteFilme = $filme->estudios->pluck('id')->toArray();

        $pessoas = Pessoa::all('id', 'nome')->pluck('nome', 'id');

        $diretoresDesteFilme = $filme->diretores->pluck('pessoa_id')->toArray();
        $produtoresDesteFilme = $filme->produtores->pluck('pessoa_id')->toArray();
        $escritoresDesteFilme = $filme->escritores->pluck('pessoa_id')->toArray();
        $atoresDesteFilme = $filme->atores->mapWithKeys(function ($ator) {
            return [$ator->pessoa_id => $ator->pivot->papel];
        })->toArray();

        return view('admin.filmes.edit', compact(
            'filme',
            'generos',
            'generosDesteFilme',
            'poster',
            'outrasImagens',
            'estudios',
            'estudiosDesteFilme',
            'pessoas',
            'diretoresDesteFilme',
            'produtoresDesteFilme',
            'escritoresDesteFilme',
            'atoresDesteFilme'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFilmeRequest $request, string $id)
    {
        $dados = $request->validated();
        $filme = Filme::findOrFail($id);

        $caminhoPoster = null;
        if ($request->hasFile('poster')) {
            $caminhoPoster = $request->file('poster')->store('posters', 'public');
        }

        $imagens = [];
        if ($request->hasFile('imagens')) {
            $imagens = $request->file('imagens', []);
        }

        $caminhosImagens = [];
        foreach ($imagens as $imagem) {
            $caminhosImagens[] = $imagem->store('imagens', 'public');
        }

        $dados['caminho_poster'] = $caminhoPoster;
        $dados['caminhos_imagens'] = $caminhosImagens;

        try {
            DB::transaction(function () use ($filme, $dados, $request) {
                $filme->update($dados);

                if ($dados['caminho_poster']) {
                    $oldPosters = $filme->imagens()->wherePivot('poster', true)->get();
                    foreach ($oldPosters as $oldPoster) {
                        $filme->imagens()->detach($oldPoster->id);

                        $usos = $oldPoster->filmes()->count() + $oldPoster->pessoa()->count();
                        if ($usos === 0) {
                            Storage::disk('public')->delete($oldPoster->caminho);
                            $oldPoster->delete();
                        }
                    }

                    $poster = Imagem::create([
                        'caminho' => $dados['caminho_poster'],
                        'nome' => $filme->nome
                    ]);
                    $filme->imagens()->attach($poster->id, ['poster' => true]);
                }

                if (!empty($dados['caminhos_imagens'])) {
                    foreach ($dados['caminhos_imagens'] as $caminhoImagem) {
                        $imagem = Imagem::create([
                            'caminho' => $caminhoImagem,
                            'nome' => $filme->nome
                        ]);
                        $filme->imagens()->attach($imagem->id, ['poster' => false]);
                    }
                }

                $generoIds = [];
                foreach ($dados['generos'] as $nomeGenero) {
                    $genero = Genero::firstOrCreate(
                        ['nome' => Str::lower(trim($nomeGenero))]
                    );
                    $generoIds[] = $genero->id;
                }
                $filme->generos()->sync($generoIds);

                if (Estudio::exists()) {
                    $filme->estudios()->sync($dados['estudios'] ?? []);
                }

                // $diretorIds = [];
                // if (!empty($dados['diretores'])) {
                //     foreach ($dados['diretores'] as $pessoaId) {
                //         $diretor = Diretor::firstOrCreate(['pessoa_id' => $pessoaId]);
                //         $diretorIds[] = $diretor->id;
                //     }
                // }
                // $filme->diretores()->sync($diretorIds);

                // $produtorIds = [];
                // if (!empty($dados['produtores'])) {
                //     foreach ($dados['produtores'] as $pessoaId) {
                //         $produtor = Produtor::firstOrCreate(['pessoa_id' => $pessoaId]);
                //         $produtorIds[] = $produtor->id;
                //     }
                // }
                // $filme->produtores()->sync($produtorIds);

                // $escritorIds = [];
                // if (!empty($dados['escritores'])) {
                //     foreach ($dados['escritores'] as $pessoaId) {
                //         $escritor = Escritor::firstOrCreate(['pessoa_id' => $pessoaId]);
                //         $escritorIds[] = $escritor->id;
                //     }
                // }
                // $filme->escritores()->sync($escritorIds);

                // $atoresSync = [];
                // if (!empty($dados['atores'])) {
                //     foreach ($dados['atores'] as $pessoaId) {
                //         $ator = Ator::firstOrCreate(['pessoa_id' => $pessoaId]);
                //         $papel = $dados['papeis'][$pessoaId] ?? 'Coadjuvante';
                //         $atoresSync[$ator->id] = ['papel' => $papel];
                //     }
                // }
                // $filme->atores()->sync($atoresSync);

                // 1. Remover vínculos marcados
                foreach ($request->input('remover_vinculos', []) as $relacao => $ids) {
                    if (in_array($relacao, ['atores', 'diretores', 'produtores', 'escritores'])) {
                        $filme->$relacao()->detach($ids);
                    }
                }
                // 2. Atualizar personagem dos atores existentes
                foreach ($request->input('atores_existentes', []) as $atorId => $dados) {
                    $filme->atores()->updateExistingPivot($atorId, [
                        'papel' => $dados['papel'] ?? 'Sem Papel'
                    ]);
                }
                // 3. Adicionar novos vínculos (mesmo método do store)
                $this->sincronizarVinculos($filme, $request->input('vinculos', []));
            });
        } catch (Exception $e) {
            if (!empty($caminhosImagens)) {
                Storage::disk('public')->delete($caminhosImagens);
            }
            if ($caminhoPoster !== null) {
                Storage::disk('public')->delete($caminhoPoster);
            }

            return back()->with('error', 'Erro ao editar o filme. Tente novamente: ' . $e->getMessage());
        }

        return redirect(route('admin.filmes.show', $filme->id))->with('success', 'Filme atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $filme = Filme::findOrFail($id);

        try {
            DB::transaction(function () use ($filme) {
                $filme->avaliacoes()->delete();

                $imagens = $filme->imagens;
                $filme->imagens()->detach();

                foreach ($imagens as $imagem) {
                    $usos = $imagem->filmes()->count() + $imagem->pessoa()->count() + $imagem->estudios()->count();
                    if ($usos === 0) {
                        Storage::disk('public')->delete($imagem->caminho);
                        $imagem->delete();
                    }
                }

                $filme->generos()->detach();
                $filme->estudios()->detach();
                $filme->diretores()->detach();
                $filme->produtores()->detach();
                $filme->escritores()->detach();
                $filme->atores()->detach();

                $filme->delete();
            });
        } catch (Exception $e) {
            return back()->with('error', 'Erro ao excluir o filme. Tente novamente: ' . $e->getMessage());
        }

        return redirect(route('admin.filmes.index'))->with('success', 'Filme excluído com sucesso!');
    }

    private function sincronizarVinculos(Filme $filme, array $vinculos): void
    {
        foreach ($vinculos as $v) {
            $pessoaId = $v['pessoa_id'] ?? null;
            $tipo = $v['tipo'] ?? null;
            $papel = $v['papel'] ?? null;
            if (!$pessoaId || !$tipo) continue;

            switch ($tipo) {
                case 'ator':
                    $ator = Ator::firstOrCreate(['pessoa_id' => $pessoaId]);

                    $filme->atores()->syncWithoutDetaching([
                        $ator->id => ['papel' => $papel]
                    ]);
                    break;
                case 'diretor':
                    $diretor = Diretor::firstOrCreate(['pessoa_id' => $pessoaId]);
                    $filme->diretores()->syncWithoutDetaching([$diretor->id]);
                    break;
                case 'produtor':
                    $produtor = Produtor::firstOrCreate(['pessoa_id' => $pessoaId]);
                    $filme->produtores()->syncWithoutDetaching([$produtor->id]);
                    break;
                case 'escritor':
                    $escritor = Escritor::firstOrCreate(['pessoa_id' => $pessoaId]);
                    $filme->escritores()->syncWithoutDetaching([$escritor->id]);
                    break;
            }
        }
    }
}
