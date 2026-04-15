<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;


class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::orderBy('nome')->get();
        $count = Produto::count();

        return view('produtos.index', ['produtos' => $produtos, 'count' => $count]);
    }

    public function caros()
    {
        $produtos = Produto::where("preco", ">", 500)->orderBy('preco', 'desc')->get();
        $count = count($produtos);

        return view('produtos.index', ['produtos' => $produtos, 'count' => $count]);
    }

    public function create()
    {
        return view('produtos.create');
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|min:3',
            'preco' => 'required|numeric|min:0'
        ], [
            'nome' => [
                'required' => 'O campo nome é obrigatório',
                'min' => 'O campo nome deve ter pelo menos 3 caracteres'
            ],
            'preco' => [
                'required' => 'O campo preço é obrigatório',
                'numeric' => 'O campo preço só aceita números',
                'min' => 'O preço deve ser maior que 0'
            ]
        ]);

        Produto::create($dados);

        return redirect('/produtos')->with('message', 'Produto cadastrado com sucesso!');
    }

    public function show(string $id)
    {
        return view('produtos.show', ['produto' => Produto::findOrFail($id)]);
    }

    public function edit(string $id)
    {
        return view('produtos.edit', ['produto' => Produto::findOrFail($id)]);
    }

    public function update(Request $request, string $id)
    {
        $dados = $request->validate([
            'nome' => 'required|min:3',
            'preco' => 'required|numeric|min:0'
        ], [
            'nome' => [
                'required' => 'O campo nome é obrigatório',
                'min' => 'O campo nome deve ter pelo menos 3 caracteres'
            ],
            'preco' => [
                'required' => 'O campo preço é obrigatório',
                'numeric' => 'O campo preço só aceita números',
                'min' => 'O preço deve ser maior que 0'
            ]
        ]);

        $produto = Produto::findOrFail($id);

        $produto->nome = $dados['nome'];
        $produto->preco = $dados['preco'];

        $produto->save();

        return redirect('/produtos')->with('message', 'Produto atualizado com sucesso!');
    }

    public function destroy(string $id)
    {
        Produto::findOrFail($id)->delete();

        return redirect('/produtos')->with('message', 'Produto excluído');
    }
}
