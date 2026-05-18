<div class="col-md-3">
    <a href="/filmes/{{ $filme['id'] }}">
    <div class="card mb-2 bg-dark">
        <div class="card-body">
            <img src="{{ asset('images/filme-card.png') }}" alt="" class="card-img-top img-fluid">
            <div class="d-flex justify-content-between">
                <strong>{{ $filme['nome'] }}</strong>
            </div>
        </div>
    </div>
    </a>
</div>