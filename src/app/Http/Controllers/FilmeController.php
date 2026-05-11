<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFilmeRequest;
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
        }])->get();

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
        $caminho = null;

        if ($request->hasFile('poster')) {
            $caminho = $request->file('poster')->store('posters', 'public');
            $dados['poster_url'] = $caminho;
        }

        try {
            DB::transaction(function () use ($dados) {
                $filme = Filme::create($dados);

                $imagem_id = DB::table('imagem')->insertGetId([
                    'caminho' => $dados['poster_url'],
                    'nome' => $filme->nome
                ]);

                DB::table("imagem_filme")->insert([
                    'filme_id' => $filme->id,
                    'imagem_id' => $imagem_id,
                    'poster' => true
                ]);
            });
        } catch(Exception $e) {
            if ($caminho) {
                Storage::disk('public')->delete($caminho);
            }
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
        $filme = Filme::with(['imagens' => function ($query) {
            $query->wherePivot('poster', true);
        }])->findOrFail($id);

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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
