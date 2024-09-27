@extends('layouts.app')

@section('title', 'Registrar Entrada o Salida')

@section('content')
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow">
        <div class="card-header   
 bg-primary text-white">
          <h1 class="mb-0">Registrar   
 Entrada o Salida</h1>
        </div>
        <div class="card-body">

          @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <div class="card mb-4">
            <div class="card-body">   

              <h5 class="card-title">Fecha y Hora Actual</h5>
              <p class="card-text" id="current-datetime"></p>
            </div>
          </div>

          <form action="{{ route('entradas_salidas.store') }}" method="POST">
            @csrf

            <input type="hidden" id="fecha_hora" name="fecha_hora" value="{{ old('fecha_hora') }}">

            <div class="mb-3">
              <label for="codigo_barras" class="form-label">Código de Barras</label>
              <div class="input-group">
                <input type="text" class="form-control @error('codigo_barras') is-invalid @enderror" id="codigo_barras" name="codigo_barras" value="{{ old('codigo_barras') }}" required>
                <button class="btn btn-outline-secondary" type="button" id="consultar_btn">Consultar</button>
                @error('codigo_barras')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="row mb-3">
              <div class="col">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre"   
 name="nombre" readonly>
              </div>
              <div class="col">   

                <label for="jefe" class="form-label">Jefe</label>
                <input type="text" class="form-control" id="jefe" name="jefe" readonly>
              </div>
              <div class="col">
                <label for="hora_entrada" class="form-label">Hora de Entrada</label>
                <input type="text" class="form-control" id="hora_entrada" name="hora_entrada" readonly>
              </div>
              <div class="col">
                <label for="hora_salida" class="form-label">Hora de Salida</label>
                <input type="text" class="form-control" id="hora_salida" name="hora_salida" readonly>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col">
                <label for="departamento" class="form-label">Departamento</label>
                <input type="text" class="form-control" id="departamento" name="departamento"   
 readonly>
              </div>
              <div class="col">
                <label for="posicion" class="form-label">Posición</label>
                <input type="text" class="form-control" id="posicion" name="posicion" readonly>
              </div>
            </div>

        <div class="mb-3">
  <label for="tipo" class="form-label">Tipo</label>
  <select id="tipo" name="tipo" class="form-select">
    <option value="entrada" {{ old('tipo') == 'entrada' ? 'selected' : '' }}>Entrada</option>
    <option value="salida" {{ old('tipo') == 'salida' ? 'selected' : '' }}>Salida</option>
  </select>
</div>

<input type="hidden" id="usuario_id" name="usuario_id" value="{{ old('usuario_id') }}">

<div class="mb-3">
  <label for="justificacion" class="form-label">Justificación</label>
  <select class="form-select @error('justificacion') is-invalid @enderror" id="justificacion" name="justificacion" required>
    <option value="">Seleccione justificación</option>
    <option value="Enfermedad" {{ old('justificacion') == 'Enfermedad' ? 'selected' : '' }}>Enfermedad</option>
    <option value="Emergencia Familiar" {{ old('justificacion') == 'Emergencia Familiar' ? 'selected' : '' }}>Emergencia Familiar</option>
    <option value="Muerte familiar" {{ old('justificacion') == 'Muerte familiar' ? 'selected' : '' }}>Muerte familiar</option>
    <option value="Emergencia en el hogar" {{ old('justificacion') == 'Emergencia en el hogar' ? 'selected' : '' }}>Emergencia en el hogar</option>
    <option value="Hijo/a(Atención inesperada)" {{ old('justificacion') == 'Hijo/a(Atención inesperada)' ? 'selected' : '' }}>Hijo/a (Atención inesperada)</option>
    <option value="Otros motivos" {{ old('justificacion') == 'Otros motivos' ? 'selected' : '' }}>Otros motivos...</option>
    <option value="Entrada/salida correctamente" {{ old('justificacion') == 'Entrada/salida correctamente' ? 'selected' : '' }}>Entrada/salida correctamente</option>
    </select>
  @error('justificacion')
    <div class="invalid-feedback">{{ $message }}</div>
  @enderror
</div>

<button type="submit" class="btn btn-primary">Registrar</button>
</form>
</div>
</div>
</div>   

</div>
</div>
@endsection

@section('scripts')
<script>
    // Función para limpiar los campos del formulario
    function clearFields() {
        document.getElementById('nombre').value = '';
        document.getElementById('jefe').value = '';
        document.getElementById('hora_entrada').value = '';
        document.getElementById('hora_salida').value = '';
        document.getElementById('departamento').value = '';
        document.getElementById('posicion').value = '';
        document.getElementById('usuario_id').value = '';
        document.getElementById('justificacion').value = ''; // Limpia el campo de justificación
        document.getElementById('tipo').value = 'entrada'; // Establece el valor por defecto
    }

    // Función para consultar el usuario al presionar el botón "Consultar"
    document.getElementById('consultar_btn').addEventListener('click', function() {
        const codigoBarras = document.getElementById('codigo_barras').value;

        if (codigoBarras) {
            fetch(`/usuario/consultar/${codigoBarras}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Usuario no encontrado o se encuentra inactivo');
                    }
                    return response.json();
                })
                .then(data => {
                    // Colocar los datos recibidos en los campos correspondientes
                    document.getElementById('nombre').value = data.usuario.nombre; // Ajuste aquí
                    document.getElementById('jefe').value = data.usuario.jefe;     // Ajuste aquí
                    document.getElementById('hora_entrada').value = data.usuario.hora_entrada; // Ajuste aquí
                    document.getElementById('hora_salida').value = data.usuario.hora_salida;   // Ajuste aquí
                    document.getElementById('departamento').value = data.usuario.departamento; // Ajuste aquí
                    document.getElementById('posicion').value = data.usuario.posicion;         // Ajuste aquí
                    document.getElementById('usuario_id').value = data.usuario.id;            // Ajuste aquí

                    // Llamada a checkTimeRange para verificar si está en el rango permitido
                    checkTimeRange(new Date());
                })
                .catch(error => {
                    alert(error.message);
                    clearFields(); // Limpia los campos si el usuario no es encontrado
                });
        } else {
            alert('Por favor, ingrese un código de barras.');
            clearFields(); // Limpia los campos si no se ingresa un código
        }
    });

    // Función para actualizar la fecha y hora actual
function updateDateTime() {
    const now = new Date();
    const options = { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    };
    const formattedDateTime = now.toLocaleDateString('es-ES', options);
    document.getElementById('current-datetime').textContent = formattedDateTime;

    // Asegurarnos de obtener la hora local en el campo oculto
    const timezoneOffset = now.getTimezoneOffset() * 60000; // Desplazamiento en milisegundos
    const localISOTime = new Date(now.getTime() - timezoneOffset).toISOString().slice(0, 19).replace('T', ' ');

    document.getElementById('fecha_hora').value = localISOTime; // Guardar en formato local
    checkTimeRange(now); // Verificar la hora actual con cada actualización
}

    // Función para verificar si la hora está dentro del rango permitido
    function checkTimeRange(currentTime) {
        const horaEntrada = document.getElementById('hora_entrada').value;
        const horaSalida = document.getElementById('hora_salida').value;
        const justificacionField = document.getElementById('justificacion');

        if (horaEntrada && horaSalida) {
            // Convertir las horas de entrada y salida a objetos de fecha
            const [entradaHour, entradaMinute] = horaEntrada.split(':').map(Number);
            const [salidaHour, salidaMinute] = horaSalida.split(':').map(Number);

            const entradaDate = new Date(currentTime);
            entradaDate.setHours(entradaHour, entradaMinute, 0);

            const salidaDate = new Date(currentTime);
            salidaDate.setHours(salidaHour, salidaMinute, 0);

            // Calcular los límites de 20 minutos antes y después
            const entradaLimitMin = new Date(entradaDate);
            entradaLimitMin.setMinutes(entradaLimitMin.getMinutes() - 20);

            const entradaLimitMax = new Date(entradaDate);
            entradaLimitMax.setMinutes(entradaLimitMax.getMinutes() + 20);

            const salidaLimitMin = new Date(salidaDate);
            salidaLimitMin.setMinutes(salidaLimitMin.getMinutes() - 20);

            const salidaLimitMax = new Date(salidaDate);
            salidaLimitMax.setMinutes(salidaLimitMax.getMinutes() + 20);

            // Verificar si la hora actual está dentro de los rangos permitidos
            if (
                (currentTime >= entradaLimitMin && currentTime <= entradaLimitMax) ||
                (currentTime >= salidaLimitMin && currentTime <= salidaLimitMax)
            ) {
                // Dentro del rango permitido
                justificacionField.style.backgroundColor = '';
                justificacionField.value = 'Entrada/salida correctamente'; // Selecciona automáticamente
            } else {
                // Fuera del rango permitido
                justificacionField.style.backgroundColor = '#f8d7da'; // Fondo rojo claro
            }
        }
    }

    // Actualizar la fecha y hora actual inmediatamente y luego cada segundo
    updateDateTime();
    setInterval(updateDateTime, 1000);
</script>
@endsection


