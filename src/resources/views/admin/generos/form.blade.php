<div class="form-floating mb-3">
    <input type="text" autofocus class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ old('nome', $genero->nome ?? '') }}" placeholder>
    <label for="nome">Nome:</label>
    @error('nome')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
