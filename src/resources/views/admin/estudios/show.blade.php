@extends('layouts.app')

@section('titulo', 'Moviestar - ' . $estudio->nome)

@section('conteudo')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 fw-bold">Estúdio</h1>
            <div>
                <a href="{{ route('estudios.show', $estudio) }}" class="btn btn-outline-secondary me-2">Ver Página Pública</a>
                <a href="{{ route('admin.estudios.edit', $estudio) }}" class="btn btn-warning me-2">Editar</a>
                <a href="{{ route('admin.estudios.index') }}" class="btn btn-outline-secondary">Voltar</a>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-3 text-muted">Nome</dt>
                    <dd class="col-sm-9">{{ $estudio->nome }}</dd>
                    <dt class="col-sm-3 text-muted">Localização</dt>
                    <dd class="col-sm-9">{{ $estudio->local ?: 'Não informada' }}</dd>
                    <dt class="col-sm-3 text-muted">Filmes</dt>
                    <dd class="col-sm-9">{!! $estudio->displayFilmes() !!}</dd>
                </dl>
                <p class="fs-3 fw-bold mt-3">Fotos ({{ count($estudio->imagens) }})</p>
                @forelse ($estudio->imagens as $imagem)
                    <img src="{{ asset('storage/' . $imagem->caminho) }}" alt=""
                        style="max-width: 300px; border-radius: 6px;">
                @empty
                    <p>Nenhuma foto cadastrada.</p>
                @endforelse
            </div>
            <div class="card-footer text-end">
                <form action="{{ route('admin.estudios.destroy', $estudio) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="confirm" value="1">
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
@endsection
