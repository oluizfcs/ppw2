<?php

namespace App\Http\Controllers;

use App\Http\Requests\GeneroRequest;
use App\Models\Genero;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GeneroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $generos = Genero::orderBy('nome')->paginate(5);

        return view('generos.index', compact('generos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('generos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GeneroRequest $request)
    {
        if ($request->has('nome')) {
            $request->merge([
                'nome' => Str::lower(trim($request->nome))
            ]);
        }

        $dados = $request->validated();

        $genero = new Genero();
        $genero->nome = $dados['nome'];

        $genero->save();

        return redirect('/generos')->with('success', 'Gênero criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('generos.edit', ['genero' => Genero::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GeneroRequest $request, string $id)
    {
        if ($request->has('nome')) {
            $request->merge([
                'nome' => Str::lower(trim($request->nome))
            ]);
        }

        $dados = $request->validated();

        $genero = Genero::findOrFail($id);

        $genero->nome = $dados['nome'];

        $genero->save();

        return redirect('/generos')->with('success', 'Gênero atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $genero = Genero::findOrFail($id);

        $genero->filmes()->detach();

        $genero->delete();

        return redirect('/generos')->with('success', 'Gênero excluído com sucesso!');
    }
}
