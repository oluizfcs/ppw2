@extends('layouts.app')

@section('titulo', 'Moviestar - Pessoas')

@section('conteudo')
    <div class="container min-vh-100 mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="display-5">Pessoas</h1>
            <a class="btn btn-primary btn-lg" href="{{ route('admin.pessoas.create') }}">Cadastrar Pessoa</a>
        </div>

        <div class="row g-4">
            @forelse ($pessoas as $pessoa)
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                    <div class="card bg-dark text-light border-secondary h-100 shadow-sm">
                        <a href="{{ route('admin.pessoas.show', $pessoa->id) }}" class="text-decoration-none text-light">
                            <img src="{{ asset($pessoa->imagens->isNotEmpty() ? 'storage/' . $pessoa->imagens->first()->caminho : 'images/profile.png') }}"
                                alt="Foto de {{ $pessoa->nome }}" class="img-fluid rounded shadow-sm mb-3"
                                style="width: 100%; max-height: 450px; object-fit: cover;">
                        </a>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title font-weight-bold mb-1">{{ $pessoa->nome }}</h5>
                            <div class="pt-2 border-top border-secondary">
                                <div class="row">
                                    <div class="col">
                                        <a href="{{ route('admin.pessoas.edit', $pessoa->id) }}"
                                            class="btn btn-outline-warning btn-sm w-100">Editar</a>
                                    </div>
                                    <div class="col">
                                        <form action="{{ route('admin.pessoas.destroy', $pessoa->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Tem certeza que deseja excluir esta pessoa?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm w-100">Excluir</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="fs-5 text-muted">Nenhuma pessoa encontrada.</p>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $pessoas->links() }}
        </div>
    </div>
@endsection
