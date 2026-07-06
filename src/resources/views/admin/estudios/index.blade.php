@extends('layouts.app')

@section('titulo', 'Moviestar - Estúdios')

@section('conteudo')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 fw-bold">Estúdios</h1>
            <a href="{{ route('admin.estudios.create') }}" class="btn btn-primary">Novo Estúdio</a>
        </div>

        <div id="container-paginar">
            @include('admin.estudios._table')
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
                        <form action="{{ route('admin.estudios.destroy', session('estudio_id')) }}" method="POST">
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

@vite('resources/js/pagination.js')
