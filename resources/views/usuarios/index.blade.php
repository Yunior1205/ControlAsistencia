@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="h3">Lista de Usuarios</h1>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="{{ route('usuarios.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Agregar Nuevo Usuario
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('usuarios.index') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" name="texto" class="form-control" placeholder="Buscar por nombre, apellido o código de barras" value="{{ $texto }}">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="bi bi-search"></i> Buscar
                    </button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Código de Barras</th>
                            <th>Nombre Completo</th>
                            <th>Departamento</th>
                            <th>Posición</th>
                            <th>Turno</th>
                            <th>Horario</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usuarios as $usuario)
                            <tr>
                                <td>{{ $usuario->codigo_barras }}</td>
                                <td>{{ $usuario->nombre }} {{ $usuario->apellido }}</td>
                                <td>{{ $usuario->departamento }}</td>
                                <td>{{ $usuario->posicion }}</td>
                                <td>{{ $usuario->turno }}</td>
                                <td>{{ $usuario->hora_entrada }} - {{ $usuario->hora_salida }}</td>
                                <td>
                                    <span class="badge bg-{{ $usuario->estado === 'activo' ? 'success' : 'danger' }}">
                                        {{ ucfirst($usuario->estado) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Está seguro que desea desabilitar este usuario?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No se encontraron usuarios</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

          <div class="d-flex justify-content-center">
        {{ $usuarios->links('pagination::bootstrap-4') }}
    </div>
        </div>
    </div>
</div>
@endsection