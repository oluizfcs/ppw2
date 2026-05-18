<header class="p-3 border-bottom bg-dark sticky-md-top">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a id="logo-link" href="/"
                class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
                <img src="{{ asset('images/star.svg') }}" class="me-1 mb-2" width="32px" height="32px"
                    alt="brand logo">
                <span class="brand-name me-2"><span id="movie">Movie</span><span id="star">star</span></span>
            </a>
            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li>
                    <a href="/" class="nav-link px-2 link-body-emphasis">Home</a>
                </li>
                <li>
                    <a href="filmes" class="nav-link px-2 link-body-emphasis">Filmes</a>
                </li>
                <li>
                    <a href="#" class="nav-link px-2 link-body-emphasis">Atores</a>
                </li>
                <li>
                    <a href="#" class="nav-link px-2 link-body-emphasis">Gêneros</a>
                </li>
            </ul>
            <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                <input type="search" class="form-control" placeholder="Pesquisar..." aria-label="Search">
            </form>
            @auth
                <div class="dropdown text-end">
                    <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('images/profile.png') }}" alt="foto do usuário" width="32" height="32"
                            class="rounded-circle">
                    </a>
                    <ul class="dropdown-menu text-small" style="">
                        <li><a class="dropdown-item" href="#">Configurações</a></li>
                        <li><a class="dropdown-item" href="#">Perfil</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                        <form action="/logout" method="post">
                            @csrf
                            <button type="submit" class="dropdown-item">Sair</button>
                        </form></li>
                    </ul>
                </div>
            @else
                <a href="/register" class="btn btn-dark me-2">Cadastrar</a>
                <a href="/login" class="btn btn-primary">Entrar</a>
            @endauth
        </div>
    </div>
</header>