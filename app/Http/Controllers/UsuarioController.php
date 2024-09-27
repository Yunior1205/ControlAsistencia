<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UsuarioFormRequest;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $texto = trim($request->get('texto'));
        $usuarios = DB::table('usuarios')
            ->where('nombre', 'LIKE', '%'.$texto.'%')
            ->orWhere('codigo_barras', 'LIKE', '%'.$texto.'%')
            ->orderBy('id', 'desc')
            ->paginate(7);

        return view('usuarios.index', compact('usuarios', 'texto'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      $jefes = DB::table('usuarios')->where('estado', '=', 'activo')->get();
        return view('usuarios.create', compact('jefes'));
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(UsuarioFormRequest $request)
{
    // Generar código de barras único si no se envió uno
    $codigo_barras = $request->input('codigo_barras') ?: $this->generarCodigoBarras($request->input('nombre'), $request->input('apellido'));

    // Verificar si el código de barras ya existe
    if (Usuario::where('codigo_barras', $codigo_barras)->exists()) {
        return back()->withErrors(['codigo_barras' => 'El código de barras ya existe.'])->withInput();
    }

    try {
        // Asignar los valores al nuevo usuario
        $usuario = new Usuario();
        $usuario->codigo_barras = $codigo_barras;
        $usuario->nombre = $request->input('nombre');
        $usuario->apellido = $request->input('apellido');
        $usuario->departamento = $request->input('departamento');
        $usuario->posicion = $request->input('posicion');
        $usuario->jefe_id = $request->input('jefe_id');
        $usuario->turno = $request->input('turno');
        $usuario->hora_entrada = $request->input('hora_entrada');
        $usuario->hora_salida = $request->input('hora_salida');
        $usuario->estado = $request->input('estado', 'activo');
        $usuario->save();

        return redirect()->route('usuarios.index');
    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Ocurrió un error al crear el usuario.'])->withInput();
    }
}

// Método para generar código de barras
protected function generarCodigoBarras($nombre, $apellido)
{
    $uniquePart = uniqid(); // Generar una parte única
    return strtoupper(substr($nombre, 0, 3) . substr($apellido, 0, 3) . $uniquePart); // Combina nombre, apellido y parte única
}

    /**
     * Show the specified resource.
     */
    public function show(string $id)
    {
        $usuario = Usuario::findOrFail($id);
        return view('usuarios.show', compact('usuario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    $usuario = Usuario::findOrFail($id);
    
      // Formatear hora_entrada y hora_salida
    $usuario->hora_entrada = \Carbon\Carbon::parse($usuario->hora_entrada)->format('H:i');
    $usuario->hora_salida = \Carbon\Carbon::parse($usuario->hora_salida)->format('H:i');

    $jefes = DB::table('usuarios')->where('estado', '=', 'activo')->get();
    return view('usuarios.edit', compact('usuario', 'jefes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UsuarioFormRequest $request, string $id)
    {
       $usuario = Usuario::findOrFail($id);
    // No asignamos el codigo_barras aquí, ya que no queremos que se requiera
    $usuario->nombre = $request->input('nombre');
    $usuario->apellido = $request->input('apellido');
    $usuario->departamento = $request->input('departamento');
    $usuario->posicion = $request->input('posicion');
    $usuario->jefe_id = $request->input('jefe_id');
    $usuario->turno = $request->input('turno');
    $usuario->hora_entrada = $request->input('hora_entrada');
    $usuario->hora_salida = $request->input('hora_salida');
    $usuario->estado = $request->input('estado', 'activo');
    $usuario->save();

    return redirect()->route('usuarios.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->estado = 'inactivo'; 
        $usuario->save();

        return redirect()->route('usuarios.index');
    }

public function consultarPorCodigo($codigo_barras)
{

 // Buscar el usuario por el código de barras y estado activo
    $usuario = Usuario::where('codigo_barras', $codigo_barras)
                      ->where('estado', 1)
                      ->first();


    if ($usuario) {
        // Buscar al jefe basado en el jefe_id si existe
        $jefe = Usuario::find($usuario->jefe_id);

        return response()->json([
            'usuario' => [
                'id' => $usuario->id,
                'nombre' => $usuario->nombre . ' ' . $usuario->apellido,
                'jefe' => $jefe ? $jefe->nombre . ' ' . $jefe->apellido : 'No asignado',
                'hora_entrada' => $usuario->hora_entrada,
                'hora_salida' => $usuario->hora_salida,
                'departamento' => $usuario->departamento,
                'posicion' => $usuario->posicion
            ]
        ]);
    } else {
       return response()->json(['error' => 'Usuario no encontrado o inactivo'], 404);
    }
}

public function usuariosPuntuales(Request $request)
{
    // Obtener el parámetro de búsqueda desde la solicitud
    $search = $request->input('search');

    // Consulta para obtener usuarios y sus registros de entradas/salidas
    $usuariosPuntuales = DB::table('entradas_salidas')
        ->join('usuarios', 'entradas_salidas.usuario_id', '=', 'usuarios.id')
        ->select(
            'usuarios.id',
            'usuarios.nombre', 
            'usuarios.apellido', 
            'usuarios.departamento',
            DB::raw('COUNT(entradas_salidas.id) as total_registros'),
            DB::raw('SUM(CASE WHEN entradas_salidas.justificacion != "Entrada/salida correctamente" THEN 1 ELSE 0 END) as fuera_de_horario'),
            DB::raw('SUM(CASE WHEN entradas_salidas.justificacion = "Entrada/salida correctamente" THEN 1 ELSE 0 END) as dentro_de_horario')
        )
        ->when($search, function ($query, $search) {
            return $query->where('usuarios.nombre', 'LIKE', "%{$search}%")
                         ->orWhere('usuarios.apellido', 'LIKE', "%{$search}%")
                         ->orWhere('usuarios.departamento', 'LIKE', "%{$search}%");
        })
        ->groupBy('usuarios.id', 'usuarios.nombre', 'usuarios.apellido', 'usuarios.departamento')
        ->orderBy('usuarios.departamento')
        ->paginate(7);

    // Retornar la vista con los datos de los usuarios puntuales y el término de búsqueda
    return view('usuarios.puntuales', compact('usuariosPuntuales', 'search'));
}

public function puntualesPorDepartamento(Request $request)
{
    // Obtener el parámetro de búsqueda desde la solicitud
    $search = $request->input('search');

    // Consulta para obtener la información agrupada por departamento
    $departamentosPuntuales = DB::table('entradas_salidas')
        ->join('usuarios', 'entradas_salidas.usuario_id', '=', 'usuarios.id')
        ->select(
            'usuarios.departamento',
            DB::raw('COUNT(entradas_salidas.id) as total_registros'),
            DB::raw('SUM(CASE WHEN entradas_salidas.justificacion != "Entrada/salida correctamente" THEN 1 ELSE 0 END) as fuera_de_horario'),
            DB::raw('SUM(CASE WHEN entradas_salidas.justificacion = "Entrada/salida correctamente" THEN 1 ELSE 0 END) as dentro_de_horario')
        )
        ->when($search, function ($query, $search) {
            return $query->where('usuarios.departamento', 'LIKE', "%{$search}%");
        })
        ->groupBy('usuarios.departamento')
        ->orderBy('usuarios.departamento')
        ->paginate(7);

    // Retornar la vista con los datos de los departamentos puntuales y el término de búsqueda
    return view('usuarios.puntualesdepartamento', compact('departamentosPuntuales', 'search'));
}





}
