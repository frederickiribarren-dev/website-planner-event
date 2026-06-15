<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Evento;

class StoreInvitadoRequest extends FormRequest
{
    public function authorize(): bool
    {
        $evento = $this->route('evento');
        return $evento && $evento->usuario_id === auth()->id();
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
