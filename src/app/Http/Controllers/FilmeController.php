<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFilmeRequest;
use App\Http\Requests\UpdateFilmeRequest;
use App\Models\Filme;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FilmeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filmes = Filme::with(['imagens' => function ($query) {
            $query->wherePivot('poster', true);
        }])->paginate(2);

        // $filmes = Filme::with('imagens')->get();

        // dd($filmes[0]);
        // dd($filmes[0]->imagens);

        return view('filmes.index', compact('filmes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('filmes.create');
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

        foreach($imagens as $imagem) {
            $caminhosImagens[] = $imagem->store('imagens', 'public');
        }

        $dados['caminho_poster'] = $caminhoPoster;
        $dados['caminhos_imagens'] = $caminhosImagens;
        
        try {
            DB::transaction(function () use ($dados) {
                $filme = Filme::create($dados);

                $imagem_id = DB::table('imagem')->insertGetId([
                    'caminho' => $dados['caminho_poster'],
                    'nome' => $filme->nome
                ]);

                DB::table("imagem_filme")->insert([
                    'filme_id' => $filme->id,
                    'imagem_id' => $imagem_id,
                    'poster' => true
                ]);

                foreach($dados['caminhos_imagens'] as $caminhoImagem) {
                    $imagem_id = DB::table('imagem')->insertGetId([
                        'caminho' => $caminhoImagem,
                        'nome' => $filme->nome
                    ]);

                    DB::table("imagem_filme")->insert([
                        'filme_id' => $filme->id,
                        'imagem_id' => $imagem_id,
                        'poster' => false
                    ]);
                }
            });
        } catch(Exception $e) {
            Storage::disk('public')->delete($caminhoPoster);
            Storage::disk('public')->delete($caminhosImagens);

            return back()->with('error', 'Erro ao salvar o filme. Tente novamente.');
        }

        return redirect('/filmes')->with('success', 'Filme cadastrado!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $filme = Filme::findOrFail($id);

        // $filme = Filme::with(['imagens' => function ($query) {
        //     $query->wherePivot('poster', true);
        // }])->findOrFail($id);

        $filme = Filme::with('imagens')->findOrFail($id);

        $avaliacoes = $filme->avaliacoes()->with('usuario')
        ->orderBy('created_at', 'desc')
        ->get();

        return view('filmes.show', compact('filme', 'avaliacoes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('filmes.edit', ['filme' => Filme::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFilmeRequest $request, string $id)
    {
        $dados = $request->validated();

        $filme = Filme::findOrFail($id);

        $filme->nome = $dados['nome'];
        $filme->sinopse = $dados['sinopse'];
        $filme->duracao = $dados['duracao'];
        $filme->data_lancamento = $dados['data_lancamento'];
        $filme->classificacao = $dados['classificacao'];

        $filme->save();

        return redirect('/filmes')->with('success', 'Filme atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort(501, 'É preciso excluir todas as imagens do banco e do storage antes de excluir o filme.');
        
        Filme::findOrFail($id)->delete();

        return redirect('/filmes')->with('success', 'Filme excluído');
    }
}
