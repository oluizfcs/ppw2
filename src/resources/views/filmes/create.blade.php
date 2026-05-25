@extends('layouts.app')

@section('titulo', 'Cadastrar Filme')

@section('conteudo')
    <div class="container mt-5 min-vh-100">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-12">
                <div class="display-4 text-center mb-2">Cadastrar Filme</div>
                <form action='/filmes' method="POST" enctype="multipart/form-data" class="card p-5 needs-validation bg-dark" novalidate>
                    @csrf
                    @include('filmes/form')
                    <label for="campos-imagem">Outras imagens</label>
                    <div id="campos-imagem"></div>
                    <button type="button" id="btn-adicionar" class="btn btn-secondary">Adicionar Imagem</button>
                    <button type="submit" class="btn btn-primary mt-2">Cadastrar Filme</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const container = document.getElementById('campos-imagem');
    const btnAdicionar = document.getElementById('btn-adicionar');
    let indice = 1;
    const MAX_FOTOS = 5;
    btnAdicionar.addEventListener('click', () => {
        if (indice > MAX_FOTOS) {
            alert('Máximo de ' + MAX_FOTOS + ' imagens.');
            return;
        }
        const div = document.createElement('div');
        div.className = 'campo-imagem mb-2 d-flex align-items-center gap-2';
        div.innerHTML = `
            <input type="file" name="imagens[]" class="form-control"
            accept="image/jpeg,image/png,image/webp">
            <button type="button" class="btn btn-sm btn-outline-danger"
            onclick="this.closest('.campo-imagem').remove(); indice--;">✕</button>`;
        container.appendChild(div);
        indice++;
    });
    </script>
@endpush