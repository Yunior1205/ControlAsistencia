@extends('layouts.app')

@section('title', 'Usuarios Puntuales')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3">Usuarios Puntuales</h1>
        </div>
        <div class="col-md-6">
            <form action="{{ route('usuarios.puntuales') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Buscar por nombre o departamento" value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-primary">Buscar</button>
            </form>
        </div>
    </div>

    @if ($usuariosPuntuales->isEmpty())
        <div class="alert alert-info" role="alert">
            No hay usuarios puntuales registrados.
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Departamento</th>
                                <th>Nombre del Usuario</th>
                                <th>Total de Registros</th>
                                <th>Entradas/Salidas Correctas</th>
                                <th>Entradas/Salidas Fuera de Horario</th>
                                <th>Puntualidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuariosPuntuales as $usuario)
                                <tr>
                                    <td>{{ $usuario->departamento }}</td>
                                    <td>{{ $usuario->nombre }} {{ $usuario->apellido }}</td>
                                    <td>{{ $usuario->total_registros }}</td>
                                    <td>{{ $usuario->dentro_de_horario }}</td>
                                    <td>{{ $usuario->fuera_de_horario }}</td>
                                 <td>
                                        @php
                                            $puntualidad = ($usuario->dentro_de_horario / $usuario->total_registros) * 100;
                                        @endphp
                                        <span>{{ number_format($puntualidad, 1) }}%</span> <!-- Mostrar el porcentaje antes de la barra -->
                                            <div class="progress mt-1" style="height: 20px;"> <!-- Añadido un margen superior (mt-1) para separar el porcentaje de la barra -->
                                                <div class="progress-bar {{ $puntualidad >= 90 ? 'bg-success' : ($puntualidad >= 75 ? 'bg-warning' : 'bg-danger') }}"
                                                     role="progressbar"
                                                     style="width: {{ $puntualidad }}%;"
                                                     aria-valuenow="{{ $puntualidad }}"
                                                     aria-valuemin="0"
                                                     aria-valuemax="100">
                                                     <!-- Quitar la impresión del porcentaje dentro de la barra -->
                                                </div>
                                            </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $usuariosPuntuales->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Agregar tooltips a las barras de progreso
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)   

    })
});
</script>
@endsection