<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvitadoMasivoRequest extends FormRequest
{
    public function authorize(): bool
    {
        $eventoId = $this->input('evento_id');
        
        if ($eventoId) {
            $evento = $this->user()->eventos()->find($eventoId);
            return $evento !== null;
        }

        return true;
    }

    public function rules(): array
    {
        return [
            'evento_id' => ['nullable', 'exists:eventos,id'],
            'list_name' => ['required', 'string', 'max:150'],
            'list_category' => ['nullable', 'string', 'max:150'],
            'guests_json' => ['required', 'string', function ($attribute, $value, $fail) {
                $guests = json_decode($value, true);
                if (!is_array($guests) || empty($guests)) {
                    $fail('Debe añadir al menos un invitado.');
                }
            }],
        ];
    }
    
    public function messages(): array
    {
        return [
            'evento_id.exists' => 'El evento seleccionado no existe.',
            'list_name.required' => 'El nombre de la lista es obligatorio.',
            'list_name.max' => 'El nombre de la lista no puede exceder los 150 caracteres.',
            'guests_json.required' => 'Debe añadir al menos un invitado.',
        ];
    }
}
