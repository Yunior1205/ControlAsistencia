<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EntradaSalidaFormRequest extends FormRequest
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
        return [
            'usuario_id'   => 'required|exists:usuarios,id',
            'tipo'         => 'required|in:entrada,salida',
            'fecha_hora'   => 'required|date',
            'justificacion' => 'nullable|string|max:255',
        ];
    }
}
