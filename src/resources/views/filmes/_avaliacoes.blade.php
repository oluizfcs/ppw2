@foreach ($avaliacoes as $avaliacao)
    @include('avaliacoes.review', ['avaliacao' => $avaliacao])
@endforeach
<div class="d-flex justify-content-center mt-4">
    {{ $avaliacoes->links() }}
</div>
