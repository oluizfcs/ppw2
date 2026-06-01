@extends('layouts.app')

@section('titulo', 'Moviestar - generos')

@section('conteudo')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="display-5">Gêneros</h1>
            <a class="btn btn-primary btn-lg" href="/generos/create">Cadastrar Gênero</a>
        </div>
        <div class="row g-3 justify-content-center">
            <div class="col-7">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($generos as $genero)
                            <tr>
                                <td>{{ $genero->id }}</td>
                                <td>{{ ucfirst($genero->nome) }}</td>
                                <td class="d-flex g-1">
                                    <div class="row justify-content-start">
                                        <div class="col">
                                            <a class="btn btn-secondary" href="/generos/{{ $genero->id }}/edit">Editar</a>
                                        </div>
                                        <div class="col">
                                            <form action="/generos/{{ $genero->id }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" type="submit">Excluir</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <div class="col-12 text-center py-5">
                                <p class="fs-5 text-muted">Nenhum gênero encontrado.</p>
                            </div>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-4">
                    {{ $generos->links() }}
                </div>
            </div>
        </div>
    @endsection
