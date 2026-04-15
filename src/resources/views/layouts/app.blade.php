{{-- resources/views/layouts/app.blade.php--}}
<!DOCTYPE html>
<html lang='pt-BR'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>@yield('titulo', 'Sistema')</title>
    {{-- Estilos específicos de cada página (opcional) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <a href='/'>Início</a>
        <a href='/produtos'>Produtos</a>
    </nav>
    
    <main>
        {{-- Aqui será inserido o conteúdo de cada página --}}
        @yield('conteudo')
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} Meu Sistema</p>
    </footer>

    {{-- Scripts específicos de cada página (opcional) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    @stack('scripts')
</body>
</html>