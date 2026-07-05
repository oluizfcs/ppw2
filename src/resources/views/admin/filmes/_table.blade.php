<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Nome</th>
                        <th>Duracao</th>
                        <th>Data lancamento</th>
                        <th>Classificacao</th>
                        <th>Sinopse</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($filmes as $filme)
                        <tr>
                            <td>{{ $filme->nome }}</td>
                            <td>{{ $filme->duracao }}</td>
                            <td>{{ $filme->data_lancamento }}</td>
                            <td>{{ $filme->classificacao }}</td>
                            <td>{{ mb_strimwidth($filme->sinopse, 0, 50, '...') }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.filmes.show', $filme) }}"
                                    class="btn btn-sm btn-outline-info me-1">Ver</a>
                                <a href="{{ route('admin.filmes.edit', $filme) }}"
                                    class="btn btn-sm btn-outline-warning me-1">Editar</a>
                                <form action="{{ route('admin.filmes.destroy', $filme) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Tem certeza que deseja excluir este filme?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger me-1">Excluir</button>
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
    {{ $filmes->links() }}
</div>
