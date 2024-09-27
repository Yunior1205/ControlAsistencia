<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogEmpleado extends Model
{
     // Nombre de la tabla
    protected $table = 'log_empleados';

    // Clave primaria
    protected $primaryKey = 'id';

    // Campos que pueden ser llenados de forma masiva
    protected $fillable = [
        'usuario_id',
        'accion',
        'fecha_hora'
    ];

    // Desactivar timestamps si no tienes created_at y updated_at
    public $timestamps = false;

    // Relación con el usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
