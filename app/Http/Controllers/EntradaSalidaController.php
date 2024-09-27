<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EntradaSalida;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\EntradaSalidaFormRequest;
use Carbon\Carbon;

class EntradaSalidaController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    
        $texto = trim($request->get('texto'));
        $entradas_salidas=DB::table('entradas_salidas as a')
            ->join('usuarios as u','a.usuario_id','=','u.id')
            ->select('u.codigo_barras','u.nombre','u.turno','u.hora_entrada','u.hora_salida','a.id','a.tipo','a.fecha','a.justificacion')
            ->where('u.codigo_barras','LIKE','%'.$texto.'%')
            ->orwhere('a.tipo','LIKE','%'.$texto.'%')
            ->orderBy('a.id','desc')
            ->paginate(7);

        return view('entradas_salidas.index', compact('entradas_salidas', 'texto'));

    }

    public function create(Request $request)
    {
       return view('entradas_salidas.create');

     
    }


    public function store(EntradaSalidaFormRequest $request)
    {
        
        // Crear una nueva entrada o salida
        $entradaSalida = new EntradaSalida();
        $entradaSalida->usuario_id = $request->input('usuario_id');
        $entradaSalida->tipo = $request->input('tipo');
        $entradaSalida->fecha = $request->input('fecha_hora');
        $entradaSalida->justificacion = $request->input('justificacion');

        // Guardar en la base de datos
        $entradaSalida->save();

        // Redirigir a una vista o retornar un mensaje de éxito
        return redirect()->route('entradas_salidas.index');
    }









     

}
