<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
     // Nombre de la tabla
    protected $table = 'usuarios';

    // Clave primaria
    protected $primaryKey = 'id';

    // Campos que pueden ser llenados de forma masiva
    protected $fillable = [
        'codigo_barras',
        'nombre',
        'apellido',
        'departamento',
        'posicion',
        'jefe_id',
        'turno',
        'hora_entrada',
        'hora_salida',
        'estado'
    ];

    // Desactivar timestamps si no tienes created_at y updated_at
    public $timestamps = false;

    // Relación de jefe a empleados
    public function jefe()
    {
        return $this->belongsTo(Usuario::class, 'jefe_id');
    }

    // Relación de un empleado con los empleados que están a su cargo
    public function empleados()
    {
        return $this->hasMany(Usuario::class, 'jefe_id');
    }

    // Relación con entradas y salidas
    public function entradasSalidas()
    {
        return $this->hasMany(EntradaSalida::class, 'usuario_id');
    }

    // Relación con el log de empleados
    public function logs()
    {
        return $this->hasMany(LogEmpleado::class, 'usuario_id');
    }
}
