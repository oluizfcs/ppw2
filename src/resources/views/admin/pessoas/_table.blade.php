<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Data de Nascimento</th>
                        <th>Nacionalidade</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pessoas as $pessoa)
                        <tr>
                            <td>{{ $pessoa->nome }}</td>
                            <td>{{ $pessoa->cpf }}</td>
                            <td>{{ $pessoa->data_nascimento }}</td>
                            <td>{{ $pessoa->nacionalidade }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.pessoas.show', $pessoa) }}"
                                    class="btn btn-sm btn-outline-info me-1">Ver</a>
                                <a href="{{ route('admin.pessoas.edit', $pessoa) }}"
                                    class="btn btn-sm btn-outline-warning me-1">Editar</a>
                                <form action="{{ route('admin.pessoas.destroy', $pessoa) }}" method="POST"
                                    class="d-inline">
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
    {{ $pessoas->links() }}
</div>
