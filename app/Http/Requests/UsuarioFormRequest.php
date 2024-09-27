<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'codigo_barras' => 'required|string|max:100|unique:usuarios,codigo_barras,' . $this->route('usuario'),
            'nombre'        => 'required|string|max:100',
            'apellido'      => 'required|string|max:100',
            'departamento'  => 'required|string|max:100',
            'posicion'      => 'required|string|max:100',
            'jefe_id'       => 'nullable|exists:usuarios,id',
            'turno'         => 'required|string|in:Mañana,Tarde,Noche,Especial',
            'hora_entrada'  => 'required|date_format:H:i',
            'hora_salida'  => 'required|date_format:H:i',
            'estado'        => 'required|in:activo,inactivo',
        ];

        return $rules;
    }

    /**
     * Get custom attribute names for validation errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'codigo_barras' => 'Código de Barras',
            'nombre'        => 'Nombre',
            'apellido'      => 'Apellido',
            'departamento'  => 'Departamento',
            'posicion'      => 'Posición',
            'jefe_id'       => 'Jefe',
            'turno'         => 'Turno',
            'hora_entrada'  => 'Hora de Entrada',
            'hora_salida'   => 'Hora de Salida',
            'estado'        => 'Estado',
        ];
    }

    /**
     * Get custom messages for validation errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'codigo_barras.required' => 'El :attribute es obligatorio.',
            'codigo_barras.unique'   => 'El :attribute ya está en uso.',
            'nombre.required'        => 'El :attribute es obligatorio.',
            'apellido.required'      => 'El :attribute es obligatorio.',
            'departamento.required'  => 'El :attribute es obligatorio.',
            'posicion.required'      => 'La :attribute es obligatoria.',
            'jefe_id.exists'         => 'El jefe seleccionado no es válido.',
            'turno.required'         => 'El :attribute es obligatorio.',
            'hora_entrada.required'  => 'La :attribute es obligatoria.',
            'hora_entrada.date_format' => 'La :attribute debe tener el formato HH:MM.',
            'hora_salida.required'   => 'La :attribute es obligatoria.',
            'hora_salida.date_format'=> 'La :attribute debe tener el formato HH:MM.',
            'hora_salida.after'      => 'La hora de salida debe ser después de la hora de entrada.',
            'estado.required'        => 'El :attribute es obligatorio.',
        ];
    }
}