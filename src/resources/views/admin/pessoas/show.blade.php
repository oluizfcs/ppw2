@extends('layouts.app')

@section('titulo', 'Moviestar - ' . $pessoa->nome)

@section('conteudo')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 fw-bold">Pessoa</h1>
            <div>
                <a href="{{ route('pessoas.show', $pessoa) }}" class="btn btn-outline-secondary me-2">Ver Página Pública</a>
                <a href="{{ route('admin.pessoas.edit', $pessoa) }}" class="btn btn-warning me-2">Editar</a>
                <a href="{{ route('admin.pessoas.index') }}" class="btn btn-outline-secondary">Voltar</a>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-3 text-muted">Nome</dt>
                    <dd class="col-sm-9">{{ $pessoa->nome }}</dd>
                    <dt class="col-sm-3 text-muted">CPF</dt>
                    <dd class="col-sm-9">{{ $pessoa->cpf }}</dd>
                    <dt class="col-sm-3 text-muted">Data de nascimento</dt>
                    <dd class="col-sm-9">{{ $pessoa->data_nascimento }}</dd>
                    <dt class="col-sm-3 text-muted">Nacionalidade</dt>
                    <dd class="col-sm-9">{{ $pessoa->nacionalidade }}</dd>
                    <dt class="col-sm-3 text-muted">Biografia</dt>
                    <dd class="col-sm-9">{{ $pessoa->biografia }}</dd>
                    <dt class="col-sm-3 text-muted">Gênero</dt>
                    <dd class="col-sm-9">{{ $pessoa->genero }}</dd>
                    <dt class="col-sm-3 text-muted">Filmes</dt>
                    <dd class="col-sm-9">{!! $pessoa->displayFilmes() !!}</dd>
                </dl>
                <p class="fs-3 fw-bold">Fotos ({{ count($pessoa->imagens) }})</p>
                @forelse ($pessoa->imagens as $imagem)
                    <img src="{{ asset('storage/' . $imagem->caminho) }}" alt=""
                        class="{{ $imagem->pivot->poster ? 'border border-primary border-5' : '' }}"
                        style="max-width: 300px; border-raidus: 6px;">
                @empty
                    <p>Nenuma foto cadastrada.</p>
                @endforelse
            </div>
            <div class="card-footer text-end">
                <form action="{{ route('admin.pessoas.destroy', $pessoa) }}" method="POST"
                    onsubmit="return confirm('Tem certeza que deseja excluir esta pessoa?')">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="confirm" value="1">
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
@endsection
