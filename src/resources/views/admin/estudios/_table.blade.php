<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Nome</th>
                        <th>Local</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($estudios as $estudio)
                        <tr>
                            <td>{{ $estudio->nome }}</td>
                            <td>{{ $estudio->local ?: 'Não informado' }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.estudios.show', $estudio) }}"
                                    class="btn btn-sm btn-outline-info me-1">Ver</a>
                                <a href="{{ route('admin.estudios.edit', $estudio) }}"
                                    class="btn btn-sm btn-outline-warning me-1">Editar</a>
                                <form action="{{ route('admin.estudios.destroy', $estudio) }}" method="POST"
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
    {{ $estudios->links() }}
</div>
