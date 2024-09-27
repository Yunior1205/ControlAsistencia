<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogEmpleado;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\LogEmpleadoFormRequest;


class LogEmpleadoController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $texto = trim($request->get('texto'));
        $logs = DB::table('log_empleados as le')
            ->join('usuarios as u', 'le.usuario_id', '=', 'u.id')
            ->select('le.id', 'u.nombre', 'le.accion', 'le.fecha_hora')
            ->where('u.nombre', 'LIKE', '%'.$texto.'%')
            ->orderBy('le.fecha_hora', 'desc')
            ->paginate(7);

        return view('log_empleados.index', compact('logs', 'texto'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuarios = DB::table('usuarios')->where('estado', '=', 'activo')->get();
        return view('log_empleados.create', compact('usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LogEmpleadoFormRequest $request)
    {
        $log = new LogEmpleado();
        $log->usuario_id = $request->input('usuario_id');
        $log->accion = $request->input('accion');
        $log->fecha_hora = $request->input('fecha_hora');
        $log->save();

        return redirect()->route('log_empleados.index');
    }

    /**
     * Show the specified resource.
     */
    public function show(string $id)
    {
        $log = LogEmpleado::findOrFail($id);
        return view('log_empleados.show', compact('log'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $log = LogEmpleado::findOrFail($id);
        $usuarios = DB::table('usuarios')->where('estado', '=', 'activo')->get();
        return view('log_empleados.edit', compact('log', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LogEmpleadoFormRequest $request, string $id)
    {
        $log = LogEmpleado::findOrFail($id);
        $log->usuario_id = $request->input('usuario_id');
        $log->accion = $request->input('accion');
        $log->fecha_hora = $request->input('fecha_hora');
        $log->save();

        return redirect()->route('log_empleados.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $log = LogEmpleado::findOrFail($id);
        $log->delete(); // Aquí puedes implementar lógica para desactivar en lugar de eliminar

        return redirect()->route('log_empleados.index');
    }
}
