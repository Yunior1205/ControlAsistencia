@extends('layouts.app')

@section('title', 'Editar Entrada/Salida')

@section('content')
<div class="container">
    <h1 class="mb-4">Editar Entrada/Salida</h1>

    <form action="{{ route('entradas_salidas.update', $entrada_salida->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="usuario_id" class="form-label">Usuario</label>
            <select class="form-select @error('usuario_id') is-invalid @enderror" id="usuario_id" name="usuario_id" required>
                @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->id }}" {{ $entrada_salida->usuario_id == $usuario->id ? 'selected' : '' }}>
                        {{ $usuario->nombre }} {{ $usuario->apellido }}
                    </option>
                @endforeach
            </select>
            @error('usuario_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo</label>
            <select class="form-select @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
                <option value="entrada" {{ $entrada_salida->tipo == 'entrada' ? 'selected' : '' }}>Entrada</option>
                <option value="salida" {{ $entrada_salida->tipo == 'salida' ? 'selected' : '' }}>Salida</option>
            </select>
            @error('tipo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="hora" class="form-label">Hora</label>
            <input type="time" class="form-control @error('hora') is-invalid @enderror" id="hora" name="hora" value="{{ $entrada_salida->hora }}" required>
            @error('hora')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection
