{{-- resources/views/produtos/index.blade.php--}}

{{-- 1. Indica qual layout usar --}}
@extends('layouts.app')

{{-- 2. Preenche o título da aba do navegador --}}
@section('titulo', 'Lista de Produtos')

{{-- 3. Preenche a região principal do layout --}}
@section('conteudo')
    <h1>Produtos</h1>
    <a href="/produtos/create" class="btn btn-success mb-2">Cadastrar Produto</a>
    @if (session('message'))
    <div class="alert alert-success" role="alert">
            {{ session('message') }}
        </div>
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
        @endforeach
    @endif
    <div>
        Mostrando {{ $count }} produtos
    </div>
    <div class='row g-3'>
    @forelse ($produtos as $produto)
        <div class='col-md-4'>
            <div class='card h-100 shadow-sm'>
                <div class='card-body'>
                    <h5 class='card-title'>{{ $produto->nome }}</h5>
                    <p class='card-text text-muted'>
                    R$ {{ number_format($produto->preco, 2, ',', '.') }}
                    </p>
                    @if ($produto->ativo)
                        <span class='badge bg-success'>Disponível</span>
                    @else
                        <span class='badge bg-secondary'>Indisponível</span>
                    @endif
                </div>
                <div class='card-footer d-flex flex-column'>
                    <form action="/produtos/{{ $produto->id }}" method="POST">
                        <a href='/produtos/{{ $produto->id }}' class='btn btn-primary btn-sm'>
                            Ver detalhes
                        </a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            Excluir
                        </button>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#modal-{{ $produto->id}}" class="btn btn-secondary btn-sm">
                            Editar
                        </button>
                        <a href="/produtos/{{ $produto->id }}/edit" class="btn btn-secondary btn-sm">
                            Editar 2
                        </a>
                    </form>
                    <div class="modal fade" id="modal-{{ $produto->id }}" tabindex="-1" aria-labelledby="modal-{{ $produto->id}}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="modal-{{ $produto->id}}">Editar produto</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action='/produtos/{{ $produto->id }}' method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-group">
                                            <label for="nome">Nome:</label>
                                            <input type="text" class="form-control" id="nome" name="nome" value="{{ $produto->nome }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="preco">Preço R$:</label>
                                            <input type="text" class="form-control" id="preco" name="preco" value="{{ $produto->preco}}">
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-2">Atualizar Produto</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class='col-12'>
            <div class='alert alert-warning'>
                Nenhum produto encontrado.
            </div>
        </div>
    @endforelse
    
    </div>
@endsection

{{-- 4. Scripts extras apenas nesta página (vai para @stack('scripts')) --}}
@push('scripts')
    <script>console.log('Página de produtos carregada.');</script>
@endpush
