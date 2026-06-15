<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvitadoRequest extends FormRequest
{
    public function authorize(): bool
    {
        $invitado = $this->route('invitado');
        return $invitado && $this->user()->can('update', $invitado);
    }

    public function rules(): array
    {
        return [
            'lista_invitado_id' => ['nullable', 'exists:listas_invitados,id'],
            'nombre' => ['required', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'estado_invitacion' => ['nullable', 'in:Pendiente,Enviado,Leído,Error'],
            'estado_asistencia' => ['nullable', 'in:Sin responder,Confirmado,Rechazado'],
            'cantidad_adultos' => ['nullable', 'integer', 'min:0'],
            'cantidad_ninos' => ['nullable', 'integer', 'min:0'],
            'alergias_notas' => ['nullable', 'string'],
            'fecha_confirmacion' => ['nullable', 'date'],
        ];
    }
}
