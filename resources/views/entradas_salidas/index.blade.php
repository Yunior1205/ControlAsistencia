@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3">Log de Usuarios</h1>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="{{ route('entradas_salidas.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Agregar Nuevo Movimiento
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('entradas_salidas.index') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" name="texto" class="form-control" placeholder="Buscar por nombre o código de barras" value="{{ $texto }}">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="bi bi-search"></i> Buscar
                    </button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Usuario / Código de Barras</th>
                            <th>Tipo</th>
                            <th>Fecha / Hora</th>
                            <th>Justificación</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($entradas_salidas as $entradas_salida)
                            <tr>
                                <td>{{ $entradas_salida->id }}</td>
                                <td>{{ $entradas_salida->nombre }} : {{ $entradas_salida->codigo_barras }}</td>
                                <td>{{ $entradas_salida->tipo }}</td>
                                <td>{{ $entradas_salida->fecha }}</td>
                                <td>{{ $entradas_salida->justificacion }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No se encontraron movimientos</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center">
                {{ $entradas_salidas->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection
