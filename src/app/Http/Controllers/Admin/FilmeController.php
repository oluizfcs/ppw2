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
use Illuminate\Support\Number;

class FilmeController extends Controller
{
    public function index(Request $request)
    {
        $filmes = Filme::with(['imagens' => function ($query) {
            $query->wherePivot('poster', true);
        }])->paginate(5);

        if ($request->ajax()) {
            return view('admin.filmes._table', compact('filmes'));
        }

        return view('admin.filmes.index', compact('filmes'));
    }

    public function create()
    {
        $generos = Genero::all('id', 'nome')->pluck('nome', 'id');
        $estudios = Estudio::all('id', 'nome')->pluck('nome', 'id');

        $pessoas = Pessoa::all('id', 'nome')->pluck('nome', 'id');

        return view('admin.filmes.create', compact('generos', 'estudios', 'pessoas'));
    }

    public function store(StoreFilmeRequest $request)
    {
        $dados = $request->validated();
        $posterIndex = $request->input('poster_index', "0");
        $arquivos = $request->file('imagens', []);
        $caminhos = [];

        foreach ($arquivos as $arquivo) {
            $caminhos[] = $arquivo->store('imagens', 'public');
        }

        DB::beginTransaction();
        try {
            $filme = Filme::create($dados);

            foreach ($caminhos as $i => $caminho) {
                $imagem = Imagem::create(['caminho' => $caminho]);

                $filme->imagens()->attach($imagem->id, [
                    'poster' => ($i === (int) $posterIndex)
                ]);
            }

            $generoIds = [];

            foreach ($dados['generos'] ?? [] as $nomeGenero) {
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

            DB::commit();
        } catch (Exception $e) {
            Storage::disk('public')->delete($caminhos);
            DB::rollBack();
            return back()->with('error', 'Erro ao salvar o filme. Tente novamente.' . $e->getMessage());
        }

        return redirect(route('admin.filmes.show', $filme->id))->with('success', 'Filme cadastrado!');
    }

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

    public function update(UpdateFilmeRequest $request, string $id)
    {
        $filme = Filme::findOrFail($id);
        $dados = $request->validated();

        DB::beginTransaction();
        try {
            $filme->update($dados);

            foreach ($filme->imagens as $img) {
                if ($img->pivot->poster)
                    $img->pivot->update(["poster" => false]);
            }

            if ($request->hasFile('imagens')) {
                $arquivos = $request->file('imagens');
                $caminhos = [];
                foreach ($arquivos as $arquivo) {
                    $caminhos[] = $arquivo->store('imagens', 'public');
                }
                foreach ($caminhos as $i => $caminho) {
                    $imagem = Imagem::create(['caminho' => $caminho]);
                    $filme->imagens()->attach($imagem->id, ['poster' => false]);
                }
            }

            $filme->load('imagens');

            $imagensCount = $filme->imagens->count();

            if ($imagensCount > 0) {
                $posterIndex = Number::clamp((int) $request->input('poster_index', "0"), 0, $imagensCount);
                $filme->imagens[$posterIndex]->pivot->update(["poster" => true]);
            }

            $generoIds = [];
            foreach ($dados['generos'] ?? [] as $nomeGenero) {
                $genero = Genero::firstOrCreate(
                    ['nome' => Str::lower(trim($nomeGenero))]
                );
                $generoIds[] = $genero->id;
            }
            $filme->generos()->sync($generoIds);

            if (Estudio::exists()) {
                $filme->estudios()->sync($dados['estudios'] ?? []);
            }

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
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            if (isset($caminhos)) {
                Storage::disk('public')->delete($caminhos);
            }

            return back()->with('error', 'Erro ao editar o filme. Tente novamente: ' . $e->getMessage());
        }

        return redirect(route('admin.filmes.show', $filme->id))->with('success', 'Filme atualizado com sucesso!');
    }

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

    public function buscar(Request $request)
    {
        $termo = trim($request->input('q', ''));
        $pessoaId = $request->input('pessoa_id');
        if (strlen($termo) < 2) {
            return response()->json([]);
        }
        $filmes = Filme::with('imagens')
            ->where('nome', 'ilike', "%{$termo}%")
            ->limit(8)
            ->get(['id', 'nome']);
        return response()->json($filmes->map(function ($f) use ($pessoaId) {
            $vinculos = [];
            if ($pessoaId) {
                $pessoa = Pessoa::find($pessoaId);
                if ($pessoa) {
                    if ($pessoa->ator && $f->atores()->where('ator_id', $pessoa->ator->id)->exists())
                        $vinculos[] = 'ator';
                    if ($pessoa->diretor && $f->diretores()->where('diretor_id', $pessoa->diretor->id)->exists())
                        $vinculos[] = 'diretor';
                    if ($pessoa->produtor && $f->produtores()->where('produtor_id', $pessoa->produtor->id)->exists())
                        $vinculos[] = 'produtor';
                    if ($pessoa->escritor && $f->escritores()->where('escritor_id', $pessoa->escritor->id)->exists())
                        $vinculos[] = 'escritor';
                }
            }
            return [
                'id' => $f->id,
                'nome' => $f->nome,
                'foto' => $f->poster()?->caminho ? asset('storage/' . $f->poster()->caminho) : null,
                'vinculos' => $vinculos,
            ];
        }));
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
