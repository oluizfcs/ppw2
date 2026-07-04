@extends('layouts.app')

@section('titulo', 'Moviestar - Gêneros')

@section('conteudo')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 fw-bold">Gêneros</h1>
            <a href="{{ route('admin.generos.create') }}" class="btn btn-primary">Novo Gênero</a>
        </div>
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Nome</th>
                                <th class="text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($generos as $genero)
                                <tr>
                                    <td>{{ ucwords($genero->nome) }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.generos.edit', $genero) }}"
                                            class="btn btn-sm btn-outline-warning me-1">Editar</a>
                                        <form action="{{ route('admin.generos.destroy', $genero) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $generos->links() }}
        </div>
    </div>

    @if (session('confirm_deletion'))
        <div class="modal fade" id="confirmModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmar Exclusão</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        {{ session('filmes_msg') }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <form action="{{ route('admin.generos.destroy', session('genero_id')) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="confirm" value="1">
                            <button type="submit" class="btn btn-danger">Sim, excluir</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                new bootstrap.Modal('#confirmModal').show();
            });
        </script>
    @endif
@endsection
