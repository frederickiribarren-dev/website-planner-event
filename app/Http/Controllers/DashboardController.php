<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Invitado;
use App\Models\Regalo;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Cargar todos los eventos activos (no borrados, no cancelados) del usuario
        $eventos = $user->eventos()
            ->whereNotIn('estado', ['Cancelado', 'Finalizado'])
            ->whereNull('deleted_at')
            ->with(['invitados', 'listaRegalo.regalos'])
            ->orderBy('fecha_evento', 'asc')
            ->get();

        // Determinar cuál evento mostrar (puede cambiar con un query param)
        $eventoIndex = (int) $request->get('evento', 0);
        if ($eventoIndex >= $eventos->count()) {
            $eventoIndex = 0;
        }

        $evento = $eventos->count() > 0 ? $eventos[$eventoIndex] : null;

        // Estadísticas del evento seleccionado
        $stats = [
            'total_invitados'    => 0,
            'confirmados'        => 0,
            'pendientes'         => 0,
            'total_regalos'      => 0,
            'regalos_pendientes' => 0,
            'dias_restantes'     => null,
        ];

        if ($evento) {
            $invitados = $evento->invitados;
            $stats['total_invitados']    = $invitados->count();
            $stats['confirmados']        = $invitados->where('estado_asistencia', 'Confirmado')->count();
            $stats['pendientes']         = $invitados->whereIn('estado_asistencia', ['Sin responder', 'Pendiente'])->count();

            if ($evento->listaRegalo) {
                $regalos = $evento->listaRegalo->regalos;
                $stats['total_regalos']      = $regalos->count();
                $stats['regalos_pendientes'] = $regalos->whereIn('estado', ['Pendiente', 'Disponible'])->count();
            }

            $stats['dias_restantes'] = now()->startOfDay()->diffInDays(
                \Carbon\Carbon::parse($evento->fecha_evento)->startOfDay(),
                false
            );
        }

        // Actividad reciente: últimas 2 entre confirmaciones de invitados y regalos seleccionados
        // que pertenecen a eventos del usuario
        $eventoIds = $user->eventos()->pluck('id');

        $confirmaciones = Invitado::whereIn('evento_id', $eventoIds)
            ->where('estado_asistencia', 'Confirmado')
            ->whereNotNull('fecha_confirmacion')
            ->orderByDesc('fecha_confirmacion')
            ->limit(2)
            ->get()
            ->map(fn($inv) => [
                'tipo'    => 'confirmacion',
                'texto'   => "{$inv->nombre} ha confirmado asistencia",
                'fecha'   => $inv->fecha_confirmacion,
                'iniciales' => collect(explode(' ', $inv->nombre))->map(fn($p) => strtoupper($p[0]))->take(2)->join(''),
            ]);

        $regalosSeleccionados = Regalo::whereIn('evento_id', $eventoIds)
            ->where('estado', 'Completado')
            ->orderByDesc('updated_at')
            ->limit(2)
            ->get()
            ->map(fn($r) => [
                'tipo'    => 'regalo',
                'texto'   => "{$r->nombre_regalo} ha sido seleccionado",
                'fecha'   => $r->updated_at,
                'iniciales' => null,
            ]);

        $actividadReciente = $confirmaciones->merge($regalosSeleccionados)
            ->sortByDesc('fecha')
            ->take(2)
            ->values();

        return view('dashboard', compact('eventos', 'evento', 'eventoIndex', 'stats', 'actividadReciente'));
    }
}
