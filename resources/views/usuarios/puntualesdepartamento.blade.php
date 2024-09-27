@extends('layouts.app')

@section('title', 'Puntualidad por Departamento')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3">Puntualidad por Departamento</h1>
        </div>
        <div class="col-md-6">
            <form action="{{ route('usuarios.puntualesdepartamento') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Buscar por departamento" value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-primary">Buscar</button>
            </form>
        </div>
    </div>

    @if ($departamentosPuntuales->isEmpty())
        <div class="alert alert-info" role="alert">
            No hay registros de puntualidad por departamento.
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Departamento</th>
                                <th>Total de Registros</th>
                                <th>Entradas/Salidas Correctas</th>
                                <th>Entradas/Salidas Fuera de Horario</th>
                                <th>Puntualidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($departamentosPuntuales as $departamento)
                                <tr>
                                    <td>{{ $departamento->departamento }}</td>
                                    <td>{{ $departamento->total_registros }}</td>
                                    <td>{{ $departamento->dentro_de_horario }}</td>
                                    <td>{{ $departamento->fuera_de_horario }}</td>
                                    <td>
                                        @php
                                            $puntualidad = ($departamento->dentro_de_horario / $departamento->total_registros) * 100;
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
                        {{ $departamentosPuntuales->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
