<div class="col-md-3">
    <a href="/atores/{{ $ator['id'] }}">
    <div class="card mb-2 bg-dark border-secondary">
        <div class="card-body">
            <img src="{{ asset('images/profile.png') }}" alt="" class="card-img-top img-fluid">
            <div class="d-flex justify-content-between">
                <strong>{{ $ator['nome'] }}</strong>
            </div>
        </div>
    </div>
    </a>
</div>