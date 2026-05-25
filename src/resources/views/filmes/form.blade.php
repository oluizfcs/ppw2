<div class="form-floating mb-3">
    <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ old('nome', $filme->nome ?? 'teste') }}" placeholder>
    <label for="nome">Nome:</label>
    @error('nome')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

</div>
<div class="form-floating mb-3">
    <textarea class="form-control @error('sinopse') is-invalid @enderror" id="sinopse" name="sinopse" placeholder>{{ old('sinopse', $filme->sinopse ?? 'teste') }}</textarea>
    <label for="sinopse">Sinopse</label>
</div>
<div class="form-floating mb-3">
    <input type="number" class="form-control @error('duracao') is-invalid @enderror" id="duracao" name="duracao" value="{{ old('duracao', $filme->duracao ?? '123') }}" placeholder>
    <label for="duracao">Duração em segundos:</label>
    @error('duracao')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-floating mb-3">
    <input type="date" class="form-control @error('data_lancamento') is-invalid @enderror" id="data_lancamento" name="data_lancamento" value="{{ old('data_lancamento', $filme->data_lancamento ?? '2010-10-10') }}" placeholder>
    <label for="data_lancamento">Data de lançamento</label>
    @error('data_lancamento')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-floating mb-3">
    <input type="text" class="form-control @error('classificacao') is-invalid @enderror" id="classificacao" name="classificacao" value="{{ old('classificacao', $filme->classificacao ?? 'L') }}" placeholder>
    <label for="classificacao">Classificação</label>
    @error('classificacao')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="form-group mb-3">
    <label for="poster">Poster</label>
    <input type="file" class="form-control @error('poster') is-invalid @enderror" id="poster" name="poster">
    @error('poster')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
