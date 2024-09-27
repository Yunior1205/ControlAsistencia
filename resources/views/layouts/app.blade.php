<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Administrador')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('usuarios.index') }}">Administrador</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('entradas_salidas.index') ? 'active' : '' }}" href="{{ route('entradas_salidas.index') }}">Entradas y Salidas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('usuarios.index') ? 'active' : '' }}" href="{{ route('usuarios.index') }}">Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('usuarios.puntuales') ? 'active' : '' }}" href="{{ route('usuarios.puntuales') }}">Log de usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('usuarios.puntualesdepartamento') ? 'active' : '' }}" href="{{ route('usuarios.puntualesdepartamento') }}">Log de departamentos</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mt-4">
        @yield('content')
    </main>
    @yield('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>