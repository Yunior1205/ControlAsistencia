@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h1 class="mb-0">Crear Nuevo Usuario</h1>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('usuarios.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="codigo_barras" class="form-label">Código de Barras(llenado automático)</label>
                                <input type="text" class="form-control @error('codigo_barras') is-invalid @enderror" id="codigo_barras" name="codigo_barras" value="{{ old('codigo_barras') }}" required readonly>
                                @error('codigo_barras')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control @error('apellido') is-invalid @enderror" id="apellido" name="apellido" value="{{ old('apellido') }}" required>
                                @error('apellido')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="departamento" class="form-label">Departamento</label>
                                <select class="form-select @error('departamento') is-invalid @enderror" id="departamento" name="departamento" required>
                                    <option value="">Seleccione un departamento</option>
                                    <option value="Recursos Humanos" {{ old('departamento') == 'Recursos Humanos' ? 'selected' : '' }}>Recursos Humanos</option>
                                    <option value="Finanzas" {{ old('departamento') == 'Finanzas' ? 'selected' : '' }}>Finanzas</option>
                                    <option value="Marketing" {{ old('departamento') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                                    <option value="Ventas" {{ old('departamento') == 'Ventas' ? 'selected' : '' }}>Ventas</option>
                                    <option value="Producción" {{ old('departamento') == 'Producción' ? 'selected' : '' }}>Producción</option>
                                    <option value="Tecnología" {{ old('departamento') == 'Tecnología' ? 'selected' : '' }}>Tecnología</option>
                                    <option value="Logística" {{ old('departamento') == 'Logística' ? 'selected' : '' }}>Logística</option>
                                    <option value="Atención al Cliente" {{ old('departamento') == 'Atención al Cliente' ? 'selected' : '' }}>Atención al Cliente</option>
                                </select>
                                @error('departamento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="posicion" class="form-label">Posición</label>
                                <select class="form-select @error('posicion') is-invalid @enderror" id="posicion" name="posicion" required>
                                    <option value="">Seleccione primero un departamento</option>
                                </select>
                                @error('posicion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="jefe_id" class="form-label">Jefe</label>
                                <select class="form-select @error('jefe_id') is-invalid @enderror" id="jefe_id" name="jefe_id">
                                    <option value="">Seleccione un jefe</option>
                                    @foreach($jefes as $jefe)
                                        <option value="{{ $jefe->id }}" {{ old('jefe_id') == $jefe->id ? 'selected' : '' }}>
                                            {{ $jefe->nombre }} {{ $jefe->apellido }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('jefe_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="turno" class="form-label">Turno</label>
                                <select class="form-select @error('turno') is-invalid @enderror" id="turno" name="turno" required>
                                    <option value="">Seleccione un turno</option>
                                    <option value="Mañana" {{ old('turno') == 'Mañana' ? 'selected' : '' }}>Mañana</option>
                                    <option value="Tarde" {{ old('turno') == 'Tarde' ? 'selected' : '' }}>Tarde</option>
                                    <option value="Noche" {{ old('turno') == 'Noche' ? 'selected' : '' }}>Noche</option>
                                    <option value="Especial" {{ old('turno') == 'Especial' ? 'selected' : '' }}>Especial</option>
                                </select>
                                @error('turno')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="hora_entrada" class="form-label">Hora de Entrada</label>
                                <input type="time" class="form-control @error('hora_entrada') is-invalid @enderror" id="hora_entrada" name="hora_entrada" value="{{ old('hora_entrada') }}" required>
                                @error('hora_entrada')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="hora_salida" class="form-label">Hora de Salida</label>
                                <input type="time" class="form-control @error('hora_salida') is-invalid @enderror" id="hora_salida" name="hora_salida" value="{{ old('hora_salida') }}" required>
                                @error('hora_salida')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="estado" class="form-label">Estado</label>
                                <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                                    <option value="activo" {{ old('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                                    <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                </select>
                                @error('estado')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Vista previa del Código de Barras</label>
                                <svg id="barcode"></svg>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Crear Usuario</button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const departamentoSelect = document.getElementById('departamento');
    const posicionSelect = document.getElementById('posicion');
    const turnoSelect = document.getElementById('turno');
    const horaEntradaInput = document.getElementById('hora_entrada');
    const horaSalidaInput = document.getElementById('hora_salida');

    const posiciones = {
        'Recursos Humanos': ['Gerente de RRHH', 'Reclutador', 'Especialista en Compensaciones', 'Analista de RRHH'],
        'Finanzas': ['Director Financiero', 'Contador', 'Analista Financiero', 'Tesorero'],
        'Marketing': ['Director de Marketing', 'Gerente de Producto', 'Especialista en Marketing Digital', 'Diseñador Gráfico'],
        'Ventas': ['Director de Ventas', 'Gerente de Cuentas', 'Representante de Ventas', 'Especialista en Desarrollo de Negocios'],
        'Producción': ['Gerente de Producción', 'Supervisor de Línea', 'Operador de Maquinaria', 'Inspector de Calidad'],
        'Tecnología': ['Director de Tecnología', 'Desarrollador de Software', 'Administrador de Sistemas', 'Analista de Datos'],
        'Logística': ['Gerente de Logística', 'Coordinador de Almacén', 'Especialista en Cadena de Suministro', 'Despachador'],
        'Atención al Cliente': ['Gerente de Servicio al Cliente', 'Representante de Atención al Cliente', 'Especialista en Soporte Técnico', 'Coordinador de Experiencia del Cliente']
    };

    const turnos = {
        'Mañana': { entrada: '06:00', salida: '15:00' },
        'Tarde': { entrada: '15:00', salida: '23:00' },
        'Noche': { entrada: '23:00', salida: '06:00' },
        'Especial': { entrada: '', salida: '' }
    };

    function actualizarPosiciones() {
        const departamento = departamentoSelect.value;
        posicionSelect.innerHTML = '<option value="">Seleccione una posición</option>';
        
        if (departamento && posiciones[departamento]) {
            posiciones[departamento].forEach(posicion => {
                const option = document.createElement('option');
                option.value = posicion;
                option.textContent = posicion;
                if (posicion === '{{ old('posicion') }}') {
                    option.selected = true;
                }
                posicionSelect.appendChild(option);
            });
        }
    }

    function actualizarHorarios() {
        const turno = turnoSelect.value;
        if (turnos[turno]) {
            horaEntradaInput.value = turnos[turno].entrada;
            horaSalidaInput.value = turnos[turno].salida;
            horaEntradaInput.readOnly = turno !== 'Especial';
            horaSalidaInput.readOnly = turno !== 'Especial';
        } else {
            horaEntradaInput.value = '';
            horaSalidaInput.value = '';
            horaEntradaInput.readOnly = false;
            horaSalidaInput.readOnly = false;
        }
    }

    departamentoSelect.addEventListener('change', actualizarPosiciones);
    turnoSelect.addEventListener('change', actualizarHorarios);

    // Inicializar
    actualizarPosiciones();
    actualizarHorarios();
});

document.addEventListener('DOMContentLoaded', function () {
    const nombreInput = document.getElementById('nombre');
    const apellidoInput = document.getElementById('apellido');
    const codigoBarrasInput = document.getElementById('codigo_barras');
    const barcodeElement = document.getElementById('barcode'); // Asegúrate de tener un elemento con este ID en tu HTML.

    // Función para generar el código de barras
    function generarCodigoBarras() {
        const nombre = nombreInput.value.trim();
        const apellido = apellidoInput.value.trim();
        
        if (nombre && apellido) {
            const timestamp = Date.now();
            const codigoBarras = `${nombre.substring(0, 3).toUpperCase()}${apellido.substring(0, 3).toUpperCase()}${timestamp}`;
            codigoBarrasInput.value = codigoBarras;

            // Generar código de barras visual
            JsBarcode(barcodeElement, codigoBarras, {
                format: "CODE128",
                lineColor: "#0aa",
                width: 2,
                height: 40,
                displayValue: true
            });
        } else {
            // Limpiar el campo de código de barras si no hay nombre o apellido
            codigoBarrasInput.value = '';

            // Generar un código de barras vacío (silueta)
            JsBarcode(barcodeElement, '', {
                format: "CODE128",
                lineColor: "#0aa",
                width: 2,
                height: 40,
                displayValue: false // No mostrar el valor cuando está vacío
            });
        }
    }

    nombreInput.addEventListener('input', generarCodigoBarras);  // Cambiar 'change' por 'input'
    apellidoInput.addEventListener('input', generarCodigoBarras); // Cambiar 'change' por 'input'

    // Inicialización - Generar una silueta al cargar la página
    JsBarcode(barcodeElement, '', {
        format: "CODE128",
        lineColor: "#0aa",
        width: 2,
        height: 40,
        displayValue: false // No mostrar el valor inicial
    });
});
</script>
@endsection